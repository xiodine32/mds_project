<?php
/**
 * Created by PhpStorm.
 * User: radu
 * Date: 4/10/16
 * Time: 4:20 PM
 */

namespace Controllers\Main\Sprint;


use Controllers\Main\ControllerMain;
use Models\Generated\ModelProject;
use Models\Generated\ModelTask;
use Models\ModelEmployee;
use Models\ModelSprint;

class ControllerIndex extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        $sprintId = $request->getSession("sessionID");
        $employeeId = $request->getSession("employeeID");

        $sprintModel = new ModelSprint();


        // find user with account name
        if ((!$sprintModel->select('sprintId = ?', [$sprintId])) || (!(new ModelEmployee())->select('employeeId = ?', [$employeeId]))) {
            $this->viewbag['error'] = 'User and/or Sprint not found';
            return new \View();
        }

        //get current sprint
        /**
         * @var ModelSprint $currentSprint
         */
        $currentSprint = $sprintModel->select('sprintId =?', [$sprintId]);

        //get current project
        $projectId = $currentSprint->projectID;

        //
        $parentProject = (new ModelProject())->selectAll('sprintID = ?', [$projectId]);
        $templateTasks = (new ModelTask())->selectAll('sprintID = ?', [$sprintId]);
        $assignedTasks = (new ModelTask())->selectAll('employeeID = ? and sprintID = ?', [$employeeId, $sprintId]);


        return new \View();
    }
}