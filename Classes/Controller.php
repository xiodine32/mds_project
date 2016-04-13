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

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->viewbag = [];
    }

    /**
     * Run the controller. Curates GET/POST/FILES. Applies View.
     */
    public function run()
    {
        $request = Request::getInstance();

        // call controller to get view
        $view = $this->call($request);

        // lock session
        $request->lockSession();

        // set view name
        $view->setImplicitViewName(get_called_class());

        // set viewbag request
        $this->viewbag['request'] = $request;

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

    /**
     * @param mixed $array Array to check against.
     * @param string[] $keys Keys of array to check.
     * @param boolean $checkEmpty If <b>TRUE</b>, checks to exist. If <b>FALSE</b>, checks only to be set.
     * @return bool True if all keys are set.
     */
    protected function hasMany($array, $keys, $checkEmpty = true)
    {
        if ($checkEmpty) {
            foreach ($keys as $key) {
                if (empty($array[$key]))
                    return false;
            }
            return true;
        }
        foreach ($keys as $key) {
            if (!isset($array[$key]))
                return false;
        }
        return true;
    }

    /**
     * Assures a key exists and if it doesn't, initialises it.
     * @param mixed $array Array to check against.
     * @param string $key Key of array to check.
     * @param mixed $default Default value
     */
    protected function assure(&$array, $key, $default = null)
    {
        if (empty($array[$key]))
            $array[$key] = $default;
    }

    /**
     * Assures multiple keys exist and if they don't, initialise them.
     * @param mixed $array Array to check against.
     * @param string[] $keys Keys of array to check.
     * @param mixed $default Default value
     */
    protected function assureMany(&$array, $keys, $default = null)
    {
        foreach ($keys as $key) {
            if (empty($array[$key]))
                $array[$key] = $default;
        }
    }
}