<?php
/**
 * Created at: 01/04/16 15:17
 */

namespace Controllers\Main;


use Models\Generated\ModelTask;

class ControllerTasks extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        if ($this->has($request->post, "task") && $this->has($request->post, "difficulty")) {
            return $this->tryInsertNewPost($request->post['task'], $request->post['difficulty']);
        }
        $this->addTasksToViewbag();
        return new \View();
    }

    /**
     * Inserts a new item into the database
     * @param $task string
     * @param $difficulty
     * @return \View
     */
    private function tryInsertNewPost($task, $difficulty)
    {
        $model = new ModelTask();
        $model->taskDescription = $task;
        $model->difficulty = intval($difficulty);
        $isEmpty = empty($model->taskDescription);
        if ($isEmpty || !$model->insert()) {
            $view = new \View();
            $this->addTasksToViewbag();
            if (!$isEmpty) {
                echo "Failed to insert: " . \Database::instance()->lastError();
                return $view;
            }
            $this->viewbag["error"] = "Task name cannot be empty!";
            return $view;
        }
        return new \Redirect("/main/calendar");
    }

    /**
     * Adds tasks to viewbag.
     */
    private function addTasksToViewbag()
    {
        $this->viewbag['tasks'] = (new ModelTask())->selectAll();
    }
}