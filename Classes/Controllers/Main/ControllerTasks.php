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
        $this->viewbag['tasks'] = (new ModelTask())->selectAll();
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
        if (!$model->insert()) {
            echo "Failed to insert: " . \Database::instance()->lastError();
            return new \View();
        }
        return new \Redirect("/main/calendar");
    }
}