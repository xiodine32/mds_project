<?php
/**
 * Created at: 29/03/16 13:41
 */

namespace Controllers\Main;


use Models\ModelEmployee;

/**
 * @abstract
 * Abstract Main Controller. Assures Employee is logged in.
 * @package Controllers\Main
 */
abstract class ControllerMain extends \Controller
{

    /**
     * @var ModelEmployee
     */
    protected $employee;


    public function __construct()
    {
        parent::__construct();
        // try to read employee from session
    }

    /**
     * Assures employee exists (otherwise, redirects him) and calls main controller for a view.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    public function call($request)
    {
        $this->employee = ModelEmployee::fromSession($request);

        // if employee is gay or homeless
        if ($this->employee === false) {
            return new \Redirect("/login");
        }

        $this->viewbag['title'] = 'Main Page';

        //
        $this->viewbag['employee'] = $this->employee;

        return $this->mainCall($request);
    }

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param \Request $request
     * @return \View The View to be displayed.
     */
    protected abstract function mainCall($request);
}