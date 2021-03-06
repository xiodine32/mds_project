<?php
/**
 * Created at: 01/04/16 15:18
 */

namespace Controllers\Main;


use Models\Generated\ModelTask;

class ControllerCalendar extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        $this->viewbag['tasks'] = (new ModelTask())->selectAll('employeeID IS NULL ORDER BY taskID DESC');
        return new \View();
    }
}