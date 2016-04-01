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
        // curate
        $_GET = $this->curate($_GET);
        $_POST = $this->curate($_POST);
        $_FILES = $this->curate($_FILES);

        // call controller to get view
        $view = $this->call($_GET, $_POST, $_FILES);

        // set view name
        $view->setImplicitViewName(get_called_class());

        // apply viewbag to view
        $view->apply($this->viewbag);
//        require $name;
    }

    /**
     * Curate an array with XSS injection proofing.
     * @param $item mixed
     * @return mixed
     */
    private function curate($item)
    {
        if (is_array($item)) {
            foreach ($item as $key => $value) {
                $item[$key] = $this->curate($value);
            }
            return $item;
        }

        // should be a string
        if (!is_callable($item))
            return htmlspecialchars($item);
        return $item;
    }

    /**
     * Calls the controller to return a view.
     * @param array $get Curated GET.
     * @param array $post Curated POST.
     * @param array $files Curated FILES.
     * @return \View The View to be displayed.
     */
    public abstract function call($get, $post, $files);

    /**
     * A GET element exists
     * @param string $key Key of GET element
     * @param mixed|null [$value] Value of get element. If null, only existance is checked.
     * @return bool True if exists and (true if value is not null and equal to requested value or true if value is null)
     */
    protected function isGet($key, $value = null)
    {
        return $this->is($_GET, $key, $value);
    }

    /**
     * An element exists.
     * @param mixed $array Array to check against.
     * @param string $key Key of array to check.
     * @param mixed|null [$value] Value of get element. If null, only existance is checked.
     * @return bool True if exists and (true if value is not null and equal to requested value or true if value is null)
     */
    protected function is($array, $key, $value = null)
    {
        return isset($array[$key]) && (($value !== null && $array[$key] === $value) || $value === null);
    }

    /**
     * A POST element exists
     * @param string $key Key of POST element
     * @param mixed|null [$value] Value of get element. If null, only existance is checked.
     * @return bool True if exists and (true if value is not null and equal to requested value or true if value is null)
     */
    protected function isPost($key, $value = null)
    {
        return $this->is($_POST, $key, $value);
    }

}