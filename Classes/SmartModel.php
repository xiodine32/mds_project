<?php

/**
 * Created at: 31/03/16 15:51
 */
abstract class SmartModel
{
    private $tableName;
    private $child;

    /**
     * SmartModel constructor.
     * @param \SmartModel $theThis To receive public members.
     * @param string $tableName Table name in Database.
     */
    public function __construct($theThis, $tableName)
    {
        $this->child = $theThis;
        $this->tableName = $tableName;
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

        $selects = join(", ", $selects);
        $questions = join(", ", $questions);

        $table = $this->tableName;

        $stmt = "INSERT INTO `{$table}` ({$selects}) VALUES ({$questions})";
//        echo "<pre style='white-space: pre-wrap;'>";var_dump($stmt);echo "</pre>";
//        echo "<pre>";var_dump($prepared);echo "</pre>";
//        die();
        return Database::instance()->query($stmt, $prepared, \Database::FETCH_NONE) !== false;
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

        $selects = join(", ", $selects);

        $stmt = "UPDATE `{$this->tableName}` SET {$selects} WHERE `{$primaryKey}` = ?";
//        echo "<pre>";var_dump($stmt);echo "</pre>";
//        echo "<pre>";var_dump($prepared);echo "</pre>";
//        die();
        return Database::instance()->query($stmt, $prepared, \Database::FETCH_NONE) !== false;
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

        $this->setFromArray($arr, $this->child);

        return true;
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