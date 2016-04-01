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
     * @param array $get Curated GET.
     * @param array $post Curated POST.
     * @param array $files Curated FILES.
     * @return \View The View to be displayed.
     */
    protected function mainCall($get, $post, $files)
    {
        if ($this->is($post, "task") && $this->is($post, "difficulty")) {
            return $this->tryInsertNewPost($post['task'], $post['difficulty']);
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
        if ($model->insert()) {

        } else {
            echo "Failed to insert: " . \Database::instance()->lastError();
            die();
        }
        return new \Redirect("/main/calendar");
    }
}