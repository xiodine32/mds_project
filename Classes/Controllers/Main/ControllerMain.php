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

    /**
     * Assures employee exists (otherwise, redirects him) and calls main controller for a view.
     * @param array $get Curated GET.
     * @param array $post Curated POST.
     * @param array $files Curated FILES.
     * @return \View The View to be displayed.
     */
    public function call($get, $post, $files)
    {
        // try to read employee from session
        $this->employee = ModelEmployee::fromSession();

        // if employee is gay or homeless
        if ($this->employee === false) {
            return new \Redirect("/login");
        }

        $this->viewbag['title'] = 'Main Page';

        //
        $this->viewbag['employee'] = $this->employee;

        return $this->mainCall($get, $post, $files);
    }

    /**
     * Calls the controller to return a view, with employee assured to exist.
     * @param array $get Curated GET.
     * @param array $post Curated POST.
     * @param array $files Curated FILES.
     * @return \View The View to be displayed.
     */
    protected abstract function mainCall($get, $post, $files);
}