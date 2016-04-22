<?php
/**
 * Created at: 01/04/16 15:18
 */

namespace Controllers\Main;


use Database;
use Models\Generated\ModelDepartment;
use Models\Generated\ModelProject;

class ControllerProjects extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        if ($this->employee->administrator) {
            $this->viewbag['contacts'] = \SmartModelFactory::instance()->factoryEmptyModelsFromQuery("Contacts", "SELECT Contacts.* FROM Projects 
RIGHT JOIN Contacts USING (contactID)");
            $error = Database::instance()->lastError();
            if ($error) {
                var_dump($error);
            }

            $this->viewbag['departments'] = (new ModelDepartment())->selectAll();
            $error = Database::instance()->lastError();
            if ($error) {
                var_dump($error);
            }

            $postArr = ["title", "startDate", "endDate", "contractNumber", "pjDescription", "budget",
                "contactID"];
            if ($this->hasMany($request->post, $postArr)) {
                return $this->tryAddProject($request);
            }

        }

        $this->viewbag['projects'] = (new ModelProject())->selectAll();

        return new \View();
    }

    /**
     * @param \Request $request
     * @return \View
     */
    private function tryAddProject($request)
    {
        $project = \SmartModelFactory::instance()->factoryGeneratedModelFromPost("Project", $request);


        if (!$project->insert()) {
            $this->viewbag['error'] = Database::instance()->lastError();
            return new \View();
        }
        $this->viewbag['success'] = 'Project successfully added!';
        return new \View();
    }
}