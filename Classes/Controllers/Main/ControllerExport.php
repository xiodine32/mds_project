<?php
/**
 * Created by PhpStorm.
 * User: xiodine
 * Date: 4/10/2016
 * Time: 6:23 PM
 */

namespace Controllers\Main;


use ContentView;

class ControllerExport extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        return new ContentView("text/csv", "test,test\n\na,b\nc,d", "test.csv");
    }
}