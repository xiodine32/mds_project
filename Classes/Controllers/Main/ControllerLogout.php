<?php
/**
 * Created at: 29/03/16 13:41
 */

namespace Controllers\Main;


use Models\ModelEmployee;

/**
 * Logout Controller Main
 * @package Controllers\Main
 */
class ControllerLogout extends ControllerMain
{
    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        ModelEmployee::unsetSession($request);
        return new \Redirect("/");
    }
}