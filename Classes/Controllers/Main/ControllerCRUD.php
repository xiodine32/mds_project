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
    private $fields = [];

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
        $this->fields[$itemName] = [$nullable, $dataType, $maxLength];
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
            return $this->edit($request);
        }

        if ($this->has($request->get, "create")) {
            return $this->create($request);
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
     * @param $request \Request
     * @return \View
     */
    protected function edit($request)
    {
        $view = new \View("edit");

        $this->model->selectPrimaryKey($request->get['edit']);

        $status = null;

        $items = array_slice($this->model->getPublicMembers(), 1);
        if ($this->hasMany($request->post, $items, false)) {
            $this->assureMany($request->post, $items, null);
            foreach ($items as $item) {
                $this->model->$item = $request->post[$item];
            }

            $status = false;
            if ($this->model->update()) {
                $status = true;
            }
        }

        $this->viewbag['form_generator'] = $this->generateForm($view, $request, $this->model, $status);
        return $view;
    }

    /**
     * @param $view \View
     * @param $request \Request
     * @param $editData false|\SmartModel
     * @param null $hasStatus
     * @return \FormGenerator
     */
    private function generateForm($view, $request, $editData, $hasStatus = null)
    {
        $formGenerator = new \FormGenerator($view);
        $formGenerator->formID = !empty($editData) ? "edit" : "create";
        $formGenerator->title = !empty($editData) ? "Edit" : "Create";
        $formGenerator->action = $request->server['REQUEST_URI'];
        $formGenerator->errorMessage = "Error occured. Please fix and try again.";
        if ($hasStatus === true) {
            $formGenerator->success = true;
            $formGenerator->successMessage = "Operation completed successfully";
        } elseif ($hasStatus === false) {
            $formGenerator->error = true;
            $formGenerator->errorMessage = "Error occured: " . \Database::instance()->lastError();
        }

        $primaryKey = true;
        foreach ($this->fields as $fieldName => $field) {

            // skip first item
            if (empty($editData) && $primaryKey) {
                $primaryKey = false;
                continue;
            }

            $added = null;
//            echo "<pre>";var_dump($fieldName);echo "</pre>";
            if (!empty($editData)) {
                $added = $editData->$fieldName;
            }

            $this->formGenerateInput($field, $fieldName, $formGenerator, $added);
        }

        $formGenerator->addSubmit("button", !empty($editData) ? "Save" : "Create");

        return $formGenerator;
    }

    /**
     * @param $field string
     * @param $fieldName string
     * @param $formGenerator \FormGenerator
     * @param null|string $value
     */
    private function formGenerateInput($field, $fieldName, $formGenerator, $value = null)
    {
        list($fieldNullable, $fieldDataType, $fieldMaxLength) = $field;

        $options = ["value" => $value];
        if ($fieldMaxLength)
            $options["maxlength"] = $fieldMaxLength;

        $required = $this->getRequired($fieldNullable, $fieldDataType);

        $hasID = false;
        $fieldNameReplaced = str_replace("ID", "", $fieldName, $hasID);


        $prettyName = $this->getPrettyName($fieldNameReplaced);

        if ($hasID) {
            $options["options"] = $this->getOptionsForFieldID($fieldName);
            if ($options["options"] === false)
                $hasID = false;
        }
        $formGenerator->addInput(
            $hasID ? "select" : "text",
            $formGenerator->formID . ucfirst($fieldName),
            $fieldName,
            $prettyName,
            "Error here!",
            $required,
            $options);
    }

    /**
     * @param $fieldNullable
     * @param $fieldDataType
     * @return bool|string
     */
    private function getRequired($fieldNullable, $fieldDataType)
    {
        $required = !$fieldNullable;

        if ($required && in_array($fieldDataType, ["number", "int", "short"]))
            return "number";
        if ($required && in_array($fieldDataType, ['varchar', 'text', 'char']))
            return true;
        if ($required && in_array($fieldDataType, ['date']))
            return "date";
        if ($required && in_array($fieldDataType, ['datetime']))
            return "datetime";

        return $required;
    }

    /**
     * @param $fieldNameReplaced string
     * @return string
     */
    private function getPrettyName($fieldNameReplaced)
    {
        $prettyName = strtoupper($fieldNameReplaced[0]);
        for ($i = 1; $i < strlen($fieldNameReplaced); $i++) {
            if (strtoupper($fieldNameReplaced[$i]) === $fieldNameReplaced[$i])
                $prettyName .= " ";
            $prettyName .= $fieldNameReplaced[$i];
        }
        return $prettyName;
    }

    private function getOptionsForFieldID($fieldName)
    {
        if (!preg_match('/^([a-zA-Z]+)ID$/', $fieldName, $matches))
            return false;
        $fieldName = $matches[1];
        $list = [];
        $fieldName = ucfirst($fieldName) . "s";
        $models = \SmartModel::factoryEmptyModelsFromQuery($fieldName, "SELECT * FROM {$fieldName}");
        if ($models === false)
            $models = [];
        foreach ($models as $item) {
            /**@var $item \SmartModel */
            $list[$item->getPrimaryKeyValue()] = "" . $item;
        }
        return $list;
    }

    /**
     * @param $request \Request
     * @return \View
     */
    protected function create($request)
    {
        $view = new \View("create");

        $status = null;
        $items = array_slice($this->model->getPublicMembers(), 1);
        if ($this->hasMany($request->post, $items, false)) {
            $this->assureMany($request->post, $items, null);
            $model = \SmartModel::factoryGeneratedModelFromPost(substr($this->model->getTableName(), 0, -1), $request);

            $status = false;
            if ($model->insert()) {
                $status = true;
            }
        }

        $this->viewbag['form_generator'] = $this->generateForm($view, $request, false, $status);

        return $view;
    }
}