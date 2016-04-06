<?php
/**
 * Created at: 05/04/16 16:54
 */

namespace Controllers\Main;


class ControllerJson extends ControllerMain
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