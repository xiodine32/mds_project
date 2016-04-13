<?php
/**
 * Created at: 01/04/16 15:18
 */

namespace Controllers\Main;


use Database;
use SmartModel;

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
            $this->viewbag['contacts'] = SmartModel::factoryFromQuery("Contacts", "SELECT Contacts.* FROM Projects 
RIGHT JOIN Contacts USING (contactID)");
            $error = Database::instance()->lastError();
            if ($error) {
                var_dump($error);
            }
        }
        return new \View();
    }
}