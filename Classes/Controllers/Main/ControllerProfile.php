<?php
/**
 * Created at: 01/04/16 15:17
 */

namespace Controllers\Main;


class ControllerProfile extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        $this->employee->joinAll();

        return new \View();
    }
}