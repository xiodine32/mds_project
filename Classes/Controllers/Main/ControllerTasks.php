<?php
/**
 * Created at: 01/04/16 15:17
 */

namespace Controllers\Main;


use Models\Generated\ModelProject;
use Models\Generated\ModelTask;
use Models\ModelEmployee;

class ControllerTasks extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        $view = new \View();
        if ($this->hasMany($request->post, ["taskDescription", "difficulty", "estimation"])) {
            $view = $this->tryInsertNewTask($request->post);
        }
        if ($this->hasMany($request->post, ["updateTaskID", "updateTask"])) {
            $view = $this->tryUpdateTask($request->post);
        }
        $this->addTasksToViewbag();
        return $view;
    }

    /**
     * Inserts a new item into the database
     * @param $post array
     * @return \View
     */
    private function tryInsertNewTask($post)
    {
        $this->assureMany($post, ["taskDescription", "difficulty",
            "projectID", "employeeID", "roleID",
            "startDate", "endDate", "estimation"]);


        $model = new ModelTask();
        \SmartModel::setFromArray($post, $model);
        if (!$model->insert()) {
            $view = new \View();
            $this->addTasksToViewbag();
            echo "Failed to insert: " . \Database::instance()->lastError();
            return $view;
        }
        return new \Redirect("/main/calendar");
    }

    /**
     * Adds tasks to viewbag.
     */
    private function addTasksToViewbag()
    {
        if ($this->employee->administrator) {
            $this->viewbag['employees'] = (new ModelEmployee())->selectAll();
            $this->viewbag['projects'] = (new ModelProject())->selectAll();
            $this->viewbag['tasks'] = (new ModelTask())->selectAll();
            $this->viewbag['tasks'] = $this->addEmployeeToSelect($this->viewbag['tasks']);

        }
        $this->viewbag['user_tasks'] = (new ModelTask())->selectAll("employeeID = ?", [$this->employee->employeeID]);
        $this->viewbag['user_tasks'] = $this->addEmployeeToSelect($this->viewbag['user_tasks']);

    }

    /**
     * @param $array array
     * @return mixed
     */
    private function addEmployeeToSelect($array)
    {
        /**
         * @var $item ModelTask
         */
        foreach ($array as $item) {
            $item->employee = new ModelEmployee();
            $item->employee->select("employeeID = ?", [$item->employeeID]);
            $item->project = new ModelProject();
            $item->project->select("projectID = ?", [$item->projectID]);
        }
        return $array;
    }

    private function tryUpdateTask($post)
    {
        //TODO: add validation so that an admin can modify other people's tasks, but a normal user can't
        $model = new ModelTask();
        $model->select("taskID = ?", [intval($post["updateTaskID"])]);
        $model->estimation = intval($post['updateTask']);
        $model->update();
        return new \View();
    }
}