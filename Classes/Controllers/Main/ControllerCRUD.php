<?php
/**
 * Created at: 20/04/16 11:30
 */

namespace Controllers\Main;


abstract class ControllerCRUD extends ControllerMain
{
    /**
     * @var \SmartModel
     */
    private $model;
    private $theThis;

    public function __construct($theThis, $model)
    {
        parent::__construct();
        $this->theThis = $theThis;
        $this->model = $model;
    }

    protected function addItem($itemName, $nullable, $dataType)
    {

    }

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected final function mainCall($request)
    {
        if (!$this->employee->administrator)
            return new \Redirect("/");

        $this->addModelsToViewbag();

        $className = get_class($this->model);

        $lastChar = strrpos($className, "\\");
        $start = $lastChar + 1 + strlen("Model");

        $className = substr($className, $start);
        $this->viewbag['model'] = $className;

        $this->viewbag['views'] = $this->model->selectAll();

        return new \View("view");
    }

    private function addModelsToViewbag()
    {
        $models = $this->directoryArray(__DIR__ . "/Models/");

        $start = strlen("Controller");
        $length = -strlen(".php");

        foreach ($models as $key => &$model) {
            if ($model == "ControllerIndex.php") {
                unset($models[$key]);
                continue;
            }
            $model = substr($model, $start, $length);
            $model = strtolower($model[0]) . substr($model, 1);
        }
        unset($model);

//        echo "<pre>";var_dump($models);echo "</pre>";
        $this->viewbag['models'] = array_values($models);
    }

    /**
     * @param string $dir
     * @return array
     */
    private function directoryArray($dir)
    {
        $models = [];
        $dir = opendir($dir);
        while ($item = readdir($dir)) {
            if ($item === '.' || $item === '..')
                continue;
            $models[] = $item;
        }
        closedir($dir);
        return $models;
    }
}