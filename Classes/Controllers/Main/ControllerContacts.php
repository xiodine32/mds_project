<?php
/**
 * Created at: 01/04/16 15:18
 */

namespace Controllers\Main;


class ControllerContacts extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        return new \View();
    }
}