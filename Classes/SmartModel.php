<?php

/**
 * Created at: 31/03/16 15:51
 */
abstract class SmartModel
{
    private $tableName;
    private $child;
    private $oldDatabaseTable;

    /**
     * SmartModel constructor.
     * @param \SmartModel $theThis To receive public members.
     * @param string $tableName Table name in Database.
     */
    public function __construct($theThis, $tableName)
    {
        $this->child = $theThis;
        $this->tableName = $tableName;
        $this->oldDatabaseTable = [];
    }

    /**
     * @param $tableName
     * @param $query
     * @param array $prepared
     * @return false|EmptyModel|EmptyModel[]
     */
    public static function factoryEmptyModelsFromQuery($tableName, $query, $prepared = [])
    {

        $return = Database::instance()->query($query, $prepared, Database::FETCH_ALL);

        // return false on error
        if (empty($return))
            return false;

        // if there are elements, return them.
        $items = [];
        foreach ($return as $item) {
            $items[] = self::factoryEmptyModelFromArray($tableName, $item);
        }
        return $items;
    }

    /**
     * Constructs an EmptyModel with rows from a PDO Return Statement.
     * @param $tableName string table name.
     * @param $row mixed[] PDO Return Statement
     * @return EmptyModel
     */
    public static function factoryEmptyModelFromArray($tableName, $row)
    {
        $model = new EmptyModel($tableName);
        $model->setFromArray($row, $model);
        return $model;
    }

    /**
     * Transforms child from table array into object (by selecting first element)
     * @param array $array Table array.
     * @param \SmartModel $element Element to be modified (by reference)
     */
    private function setFromArray($array, &$element)
    {
        foreach ($array as $key => $item) {
            $element->$key = $item;
        }
    }

    public static function factoryGeneratedModelFromPost($modelName, $request)
    {
        $modelName = "\\Models\\Generated\\Model{$modelName}";
        $model = new $modelName();
        /** @var $model SmartModel */
        $elements = array_slice($model->getPublicMembers(), 1);
        foreach ($elements as $key) {
            $value = isset($request->post[$key]) ? $request->post[$key] : null;
            $model->$key = $value;
        }
        return $model;
    }

    /**
     * Gets public members of child class.
     * @return string[] Public members.
     */
    private function getPublicMembers()
    {
        $publics = call_user_func('get_object_vars', $this->child);
        return array_keys($publics);
    }

    /**
     * Inserts the current model into the database.
     * @return bool True if inserted successfully.
     */
    public function insert()
    {
        $publics = $this->getPublicMembers();

        $selects = [];
        $questions = [];
        $prepared = [];
        foreach ($publics as $item) {

            $selects[] = "`{$item}`";
            $questions[] = "?";

            if ($this->child->$item === null)
                $prepared[] = null;
            else
                $prepared[] = $this->child->$item;
        }

        $this->oldDatabaseTable = $prepared;

        $selects = join(", ", $selects);
        $questions = join(", ", $questions);

        $table = $this->tableName;

        $stmt = "INSERT INTO `{$table}` ({$selects}) VALUES ({$questions})";
//        echo "<pre style='white-space: pre-wrap;'>";var_dump($stmt);echo "</pre>";
//        echo "<pre>";var_dump($prepared);echo "</pre>";
//        die();
        return Database::instance()->query($stmt, $prepared, \Database::FETCH_NONE) !== false;
    }

    function __toString()
    {
        $publics = $this->getPublicMembers();
        $text = [substr(get_called_class(), 7)];
        $max = 0;
        foreach ($publics as $item) {
            $strlen = strlen($item);
            $max = $max > $strlen ? $max : $strlen;
        }
        foreach ($publics as $item) {
            $i = " * <strong>" . str_pad($item, $max, ' ') . "</strong> => ";
            $result = $this->child->$item;
            if ($result === null)
                $i .= "NULL";
            elseif ($result === true)
                $i .= "TRUE";
            elseif ($result === false)
                $i .= "FALSE";
            elseif (is_numeric($result))
                $i .= "{$result}";
            else
                $i .= "'{$result}'";
            $text[] = $i;
        }
        return "(" . implode("\n", $text) . "\n)";
    }

    /**
     * Updates the current model in the Database.
     * @return bool True if updated successfully.
     */
    public function update()
    {
        $keys = $this->getPublicMembers();
        $primaryKey = $keys[0];
        array_splice($keys, 0, 1);
        $selects = [];
        $prepared = [];
        foreach ($keys as $item) {
            $selects[] = "`{$item}` = ?";

            if ($this->child->$item === null)
                $prepared[] = null;
            else
                $prepared[] = $this->child->$item;
        }

        $prepared[] = $this->child->$primaryKey;

//        echo "<pre>";var_dump("before", $prepared);echo "</pre>";

        // if was selected, do a diff.
        list($selectsCurated, $preparedCurated) = $this->updateDiff($keys, $selects, $prepared);

        if (!count($preparedCurated))
            return true;

        $preparedCurated[] = $this->child->$primaryKey;

        $selects = join(", ", $selectsCurated);


        $stmt = "UPDATE `{$this->tableName}` SET {$selects} WHERE `{$primaryKey}` = ?";
//        echo "<pre>";var_dump($stmt);echo "</pre>";
//        echo "<pre>";var_dump($preparedCurated);echo "</pre>";
//        die();
        return Database::instance()->query($stmt, $preparedCurated, \Database::FETCH_NONE) !== false;
    }

    /**
     * Updates the selects and prepares depending on what's changed.
     * @param array $keys
     * @param array $selects
     * @param array $prepared
     * @return array
     */
    private function updateDiff($keys, $selects, $prepared)
    {
        $selectsCurated = [];
        $preparedCurated = [];

        if (count($this->oldDatabaseTable) != count($keys) + 1) {

            $selectsCurated = $selects;
            $preparedCurated = $prepared;
            return [$selectsCurated, $preparedCurated];

        }

        $old = array_values($this->oldDatabaseTable);
        $oldKeys = array_keys($this->oldDatabaseTable);
        $count = count($old);

        for ($i = 0; $i < $count; $i++) {

            // primary key is first, so wrap backwards.
            $left = $prepared[($i + $count - 1) % $count];
            $right = $old[$i];

            // strict type casting is NOT USED (FOR GOOD REASONS!)
            if ($left != $right) {

                $item = $oldKeys[$i];
                $this->oldDatabaseTable[$item] = $left;

                $selectsCurated[] = "`{$item}` = ?";


                if ($this->child->$item === null)
                    $preparedCurated[] = null;
                else
                    $preparedCurated[] = $this->child->$item;
            }
        }
        return [$selectsCurated, $preparedCurated];
    }

    /**
     * Gets the primary key value associated with the model.
     * @return mixed Primary Key value.
     */
    public function getPrimaryKeyValue()
    {
        $key = $this->getPrimaryKey();
        return $this->child->$key;
    }

    /**
     * Gets the primary key associated with the model.
     * @return string Primary Key name.
     */
    public function getPrimaryKey()
    {
        return $this->getPublicMembers()[0];
    }

    /**
     * Transforms the model into the selected query, using the primary key as a selector
     * @param string $value
     * @return bool
     */
    public function selectPrimaryKey($value)
    {
        return $this->select("`" . $this->getPrimaryKey() . "` = ?", [$value]);
    }

    /**
     * Transforms the model into the selected query.
     * @param string $where SQL where.
     * @param array $prepared Prepared array for where.
     * @return bool True if child became selected element.
     */
    public function select($where = '', $prepared = [])
    {
        $selects = [];
        foreach ($this->getPublicMembers() as $item) {
            $selects[] = "`{$item}`";
        }
        $selects = join(", ", $selects);


        $table = $this->tableName;


        $whereQuery = '';
        if (!empty($where))
            $whereQuery = "WHERE {$where}";


        $arr = Database::instance()->query("SELECT {$selects} FROM {$table} {$whereQuery}", $prepared, \Database::FETCH_ONE);

        if ($arr === false)
            return false;

        $this->oldDatabaseTable = $arr;

        $this->setFromArray($arr, $this->child);

        return true;
    }

    /**
     * Selects all objects that match the where.
     * @param string $where SQL where.
     * @param array $prepared Prepared array for where.
     * @return array|bool False if error or array with instantiated objects if success.
     */
    public function selectAll($where = '', $prepared = [])
    {
        $selects = [];
        foreach ($this->getPublicMembers() as $item) {
            $selects[] = "`{$item}`";
        }
        $selects = join(", ", $selects);


        $table = $this->tableName;


        $whereQuery = '';
        if (!empty($where))
            $whereQuery = "WHERE {$where}";


        $arr = Database::instance()->query("SELECT {$selects} FROM {$table} {$whereQuery}", $prepared, \Database::FETCH_ALL);

        if ($arr === false)
            return false;

        $returnItems = [];
        foreach ($arr as $items) {
            $leItem = new $this->child();
            $this->setFromArray($items, $leItem);
            $returnItems[] = $leItem;
        }

        return $returnItems;
    }

    /**
     * Deletes the object from the Database
     * @return bool True if no error occured.
     */
    public function delete()
    {
        $primaryKey = $this->getPublicMembers()[0];
        $prepared = [$this->child->$primaryKey];

        $stmt = "DELETE FROM `{$this->tableName}` WHERE `{$primaryKey}` = ?";

        return Database::instance()->query($stmt, $prepared, \Database::FETCH_NONE) !== false;
    }
}