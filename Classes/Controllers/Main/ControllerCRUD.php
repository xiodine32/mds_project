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


    /**
     * @param string $itemName
     * @param boolean $nullable
     * @param string $dataType
     * @param int|null $maxLength
     */
    protected function addItem($itemName, $nullable, $dataType, $maxLength = null)
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

        $this->addClassName();


        $this->addModelsToViewbag();

        if ($this->has($request->get, "delete")) {
            return $this->delete($request);
        }

        if ($this->has($request->get, "edit")) {
            return $this->edit();
        }

        if ($this->has($request->get, "create")) {
            return $this->create();
        }

        $this->viewbag['views'] = $this->model->selectAll();

        return new \View("view");
    }

    protected function addClassName()
    {
        $className = get_class($this->model);

        $lastChar = strrpos($className, "\\");
        $start = $lastChar + 1 + strlen("Model");

        $className = substr($className, $start);
        $this->viewbag['model'] = $className;
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

    /**
     * @param \Request $request
     * @return \Redirect
     */
    protected function delete($request)
    {
        if ($this->model->selectPrimaryKey($request->get['delete'])) {
            if ($this->model->delete()) {
                return new \Redirect(".");
            }
            return new \Redirect(".?error=true");
        }
        return new \Redirect(".");
    }

    /**
     * @return \View
     */
    protected function edit()
    {
        return new \View("edit");
    }

    /**
     * @return \View
     */
    protected function create()
    {
        return new \View("create");
    }
}