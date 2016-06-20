<?php
/**
 * Created at: 29/03/16 13:41
 */

namespace Controllers\Main;

use Models\Generated\ModelTask;


/**
 * Index Controller Main
 * @package Controllers\Main
 */
class ControllerIndex extends ControllerMain
{
    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        $this->viewbag['title'] = 'Main Page';
        $this->viewbag['tasks'] = count((new ModelTask())->selectAll('employeeID = ? ', [$this->employee->employeeID]));

        $prepared = [];
        $adminClause = "";
        if (!$this->employee->administrator) {
            $adminClause = 'employeeID = ? AND ';
            $prepared[] = $this->employee->employeeID;
        }

        $prepared[] = date("Y-m-d");
        $prepared[] = date("Y-m-d");

        $this->viewbag['todayTasks'] =
            count((new ModelTask())->selectAll($adminClause . 'startDate <= ? AND ? <= endDate ', $prepared));

        return new \View();
    }
}