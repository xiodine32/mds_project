<?php
/**
 * Created by PhpStorm.
 * User: xiodine
 * Date: 4/10/2016
 * Time: 6:23 PM
 */

namespace Controllers\Main;


use Models\Generated\ModelContact;
use Models\Generated\ModelDepartment;
use Models\Generated\ModelEducation;
use Models\Generated\ModelProject;
use Models\Generated\ModelRole;
use Models\Generated\ModelTask;
use Models\ModelEmployee;
use ViewContent;

class ControllerExport extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        return new ViewContent("application/json", json_encode([
            "contacts" => (new ModelContact())->selectAll(),
            "department" => (new ModelDepartment())->selectAll(),
            "education" => (new ModelEducation())->selectAll(),
            "employee" => (new ModelEmployee())->selectAll(),
            "project" => (new ModelProject())->selectAll(),
            "role" => (new ModelRole())->selectAll(),
            "task" => (new ModelTask())->selectAll(),
        ]), "database.json");
    }
}