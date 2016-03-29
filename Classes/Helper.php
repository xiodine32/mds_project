<?php

/**
 * Created at: 29/03/16 15:34
 */
class Helper
{
    /**
     * @param array $array
     * @param mixed $key
     * @param mixed $item
     * @return bool
     */
    public static function existsAndEquals($array, $key, $item)
    {
        return isset($array) && isset($array[$key]) && $array[$key] === $item;
    }

    /**
     * @param string $model Model name.
     * @param string [$where] Where clause.
     * @param array [$prepared] Prepare elements.
     * @param int [$fetchType] Fetch type.
     * @return IModel|IModel[] Model
     */
    public static function databaseSelectDefault($model, $where = '', $prepared = [], $fetchType = \Database::FETCH_ONE)
    {
        /**
         * @var IModel $model
         */


        $selects = "`{$model::tablePrimaryKey()}`";
        foreach ($model::tableNames() as $item) {
            $selects .= ", `{$item}`";
        }


        $table = $model::tableName();


        $whereQuery = '';
        if (!empty($where))
            $whereQuery = "WHERE {$where}";


        $arr = Database::instance()->query("SELECT {$selects} FROM {$table} {$whereQuery}", $prepared, $fetchType);

        if ($fetchType === \Database::FETCH_ONE) {
            if ($arr === false)
                return null;
            return $model::fromDatabase($arr);
        }

        $items = [];
        foreach ($arr as $item) {
            $items[] = $model::fromDatabase($item);
        }
        return $items;
    }

    /**
     * @param IModel $modelThis
     * @return bool
     */
    public static function databaseInsertDefault($modelThis)
    {
        $selects = [];
        $questions = [];
        $prepared = [];
        foreach ($modelThis::tableNames() as $item) {
            $selects[] = "`{$item}`";
            $questions[] = "?";

            $getter = "get" . ucfirst($item);
            $prepared[] = $modelThis->$getter();
        }

        $selects = join(", ", $selects);
        $questions = join(", ", $questions);

        $table = $modelThis::tableName();

        $stmt = "INSERT INTO `{$table}` ({$selects}) VALUES ({$questions})";
        return Database::instance()->query($stmt, $prepared, \Database::FETCH_NONE) !== false;

    }

    /**
     * @param IModel $modelThis
     * @return bool
     */
    public static function databaseUpdateDefault($modelThis)
    {
        $selects = [];
        $prepared = [];
        foreach ($modelThis::tableNames() as $item) {
            $selects[] = "`{$item}` = ?";

            $getter = "get" . ucfirst($item);
            $prepared[] = $modelThis->$getter();
        }

        $getterPrimary = "get" . ucfirst($modelThis::tablePrimaryKey());
        $prepared[] = $modelThis->$getterPrimary();

        $selects = join(", ", $selects);

        $stmt = "UPDATE `{$modelThis::tableName()}` SET {$selects} WHERE `{$modelThis::tablePrimaryKey()}` = ?";

        return Database::instance()->query($stmt, $prepared, \Database::FETCH_NONE) !== false;
    }

    /**
     * @param IModel $modelThis
     * @return bool
     */
    public static function databaseDeleteDefault($modelThis)
    {
        $getterPrimary = "get" . ucfirst($modelThis::tablePrimaryKey());
        $prepared = [$modelThis->$getterPrimary()];

        $stmt = "DELETE FROM `{$modelThis::tableName()}` WHERE `{$modelThis::tablePrimaryKey()}` = ?";

        return Database::instance()->query($stmt, $prepared, \Database::FETCH_NONE) !== false;
    }
}