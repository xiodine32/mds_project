<?php
/**
 * Created at: 01/04/16 15:19
 */

namespace Controllers\Main;

use Models\Generated\ModelDepartment;

class ControllerDepartments extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        if ($this->has($request->post, "title")) {
            return $this->tryAdd($request->post);
        }
        return new \View();
    }

    private function tryAdd($post)
    {
        if (!$this->hasMany($post, ["title", "maxSize", "startDate", "monthlyExpenses"])) {
            $this->viewbag['error'] = 'Error validating input';
            return new \View();
        }
        $this->assureMany($post, ["title", "maxSize", "startDate", "monthlyExpenses", "deptDescription"]);
        $department = new ModelDepartment();
        \SmartModel::setFromArray($post, $department);

        if ($department->insert()) {
            $this->viewbag['success'] = 'Deparment successfully inserted!';
            return new \View();
        }

        $this->viewbag['error'] = \Database::instance()->lastError();
        return new \View();
    }
}