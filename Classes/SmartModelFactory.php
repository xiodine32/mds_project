<?php

/**
 * Created at: 22/04/16 16:53
 */
class SmartModelFactory
{
    /**
     * SmartModelFactory constructor.
     */
    private function __construct()
    {
    }

    public static function instance()
    {
        static $singleton = null;
        if ($singleton === null)
            $singleton = new SmartModelFactory();

        return $singleton;
    }

    public function factoryGeneratedModelFromPost($modelName, $request)
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

    public function factoryEmptyModelsFromQuery($tableName, $query, $prepared = [])
    {

        $return = Database::instance()->query($query, $prepared, Database::FETCH_ALL);

        // return false on error
        if (empty($return))
            return false;

        // if there are elements, return them.
        $items = [];
        foreach ($return as $item) {
            $items[] = self::emptyModelFromArray($tableName, $item);
        }
        return $items;
    }

    /**
     * Constructs an EmptyModel with rows from a PDO Return Statement.
     * @param $tableName string table name.
     * @param $row mixed[] PDO Return Statement
     * @return EmptyModel
     */
    public static function emptyModelFromArray($tableName, $row)
    {
        $model = new EmptyModel($tableName);
        SmartModel::setFromArray($row, $model);
        return $model;
    }
}