<?php
/**
 * Created at: 29/03/16 13:33
 */

namespace Controllers;


/**
 * 404 Controller - Page Not Found
 * @package Controllers
 */
class Controller404 extends \Controller
{

    /**
     * Displays 404.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    public function call($request)
    {
        $this->viewbag['title'] = '404';
        return new \View();
    }
}