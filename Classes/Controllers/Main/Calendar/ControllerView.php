<?php
/**
 * Created by PhpStorm.
 * User: Xiodine
 * Date: 20/06/2016
 * Time: 16:57
 */

namespace Controllers\Main\Calendar;


use Controllers\Main\ControllerMain;
use Models\Generated\ModelProject;
use Models\Generated\ModelTask;
use Models\ModelEmployee;

class ControllerView extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        $week = intval($request->get["week"]);
        if ($week < 10)
            $week = "0" . $week;
        $day = intval($request->get["day"]);
        $date = strtotime("2016-W" . $week . "-" . $day);
        $mysqlDate = date("Y-m-d", $date);
        $this->viewbag['tasks'] = (new ModelTask())->selectAll("startDate <= ? and ? <= endDate", [$mysqlDate, $mysqlDate]);
        $this->viewbag['day'] = date("l, d F Y", $date);
        $this->viewbag['title'] = date("l, d F Y", $date);
        $this->updateViewBag();
        return new \View();
    }

    private function updateViewBag()
    {
        foreach ($this->viewbag['tasks'] as $item) {
            $item->employee = new ModelEmployee();
            $item->employee->select("employeeID = ?", [$item->employeeID]);
            $item->project = new ModelProject();
            $item->project->select("projectID = ?", [$item->projectID]);
        }
    }
}