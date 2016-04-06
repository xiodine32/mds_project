<?php

/**
 * Created at: 29/03/16 12:34
 */

/**
 * Abstract Class Controller.
 */
abstract class Controller
{
    protected $viewbag;
    private $request;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->viewbag = [];
        $this->request = Request::getInstance();
    }

    /**
     * Run the controller. Curates GET/POST/FILES. Applies View.
     */
    public function run()
    {
        // call controller to get view
        $view = $this->call($this->request);

        // set view name
        $view->setImplicitViewName(get_called_class());

        // set viewbag request
        $this->viewbag['request'] = $this->request;

        // apply viewbag to view
        $view->apply($this->viewbag);

    }

    /**
     * Calls the controller to return a view.
     * @param Request $request
     * @return View The View to be displayed.
     */
    public abstract function call($request);

    /**
     * An element exists.
     * @param mixed $array Array to check against.
     * @param string $key Key of array to check.
     * @param mixed|null [$value] Value of get element. If null, only existance is checked.
     * @return bool True if exists and (true if value is not null and equal to requested value or true if value is null)
     */
    protected function has($array, $key, $value = null)
    {
        return isset($array[$key]) && (($value !== null && $array[$key] === $value) || $value === null);
    }
}