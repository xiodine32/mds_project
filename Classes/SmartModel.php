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
     * @param \SmartModel $theThis
     * @param string $tableName
     */
    public function __construct($theThis, $tableName)
    {
        $this->child = $theThis;
        $this->tableName = $tableName;
    }

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
     * @return string[]
     */
    private function getPublicMembers()
    {
        $publics = call_user_func('get_object_vars', $this->child);
        return array_keys($publics);
    }

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

        foreach ($arr as $key => $item) {
            $this->child->$key = $item;
        }

        return true;
    }

    public function selectFirst($array)
    {
        foreach (reset($array) as $key => $item) {
            $this->child->$key = $item;
        }
    }

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
            foreach ($items as $key => $item) {
                $leItem->$key = $item;
            }
            $returnItems[] = $leItem;
        }

        return $returnItems;
    }

    public function delete()
    {
        $primaryKey = $this->getPublicMembers()[0];
        $prepared = [$this->child->$primaryKey];

        $stmt = "DELETE FROM `{$this->tableName}` WHERE `{$primaryKey}` = ?";

        return Database::instance()->query($stmt, $prepared, \Database::FETCH_NONE) !== false;
    }
}