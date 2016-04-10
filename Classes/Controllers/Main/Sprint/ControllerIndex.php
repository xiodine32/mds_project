<?php
/**
 * Created by PhpStorm.
 * User: radu
 * Date: 4/10/16
 * Time: 4:20 PM
 */

namespace Controllers\Main\Sprint;


use Controllers\Main\ControllerMain;

class ControllerIndex extends ControllerMain
{

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected function mainCall($request)
    {
        // TODO: Implement mainCall() method.
        return new \HTMLView("<p> Nascut si crescut in PANTELIMON </p>");
    }
}