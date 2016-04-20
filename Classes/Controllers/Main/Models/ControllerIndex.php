<?php
/**
 * Created at: 20/04/16 11:32
 */

namespace Controllers\Main\Models;


use Controllers\Main\ControllerMain;

class ControllerIndex extends ControllerMain
{

    /**
     * Calls the controller to  return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        if (!$this->employee->administrator)
            return new \Redirect("/");

        $models = [];
        $dir = opendir(__DIR__ . "/../../../Models/Generated");
        while ($item = readdir($dir)) {
            if ($item === '.' || $item === '..')
                continue;
            $models[] = $item;
        }
        closedir($dir);

        $start = strlen("Model");
        $length = -strlen(".php");

        foreach ($models as &$model) {
            $model = substr($model, $start, $length);
        }
        unset($model);

        $this->viewbag['models'] = $models;

        return new \View();
    }
}