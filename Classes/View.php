<?php

/**
 * Created at: 29/03/16 12:34
 */


/**
 * Class View
 */
class View
{
    private $name;
    private $partial;
    private $path;
    private $layout = [];
    private $callIndex = -1;
    private $viewbag;

    /**
     * View constructor.
     * @param null|string $name null if default view (for Controller) or view for controller.
     * @param null|boolean $isPartial If true, will display view without layout.
     */
    public function __construct($name = null, $isPartial = null)
    {
        $this->name = $name;
        $this->partial = $isPartial;

        // if partial is null, decide for myself
        if ($this->partial === null) {

            // if ajax, it's partial
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            )
                $this->partial = true;
            else
                $this->partial = false;
        }


    }

    /**
     * @return null|string Name of view.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean Is partial view.
     */
    public function isPartial()
    {
        return $this->partial;
    }

    /**
     * Sets the implicit view name.
     * @param string $className The caller class's name.
     */
    public function setImplicitViewName($className)
    {

        // if not default view, skip the naming convention
        $skipName = false;
        if ($this->name !== null)
            $skipName = true;

        // remove "Controllers" folder from explosion (as we're using Views as root)
        $name = substr($className, strlen("Controllers"));

        // explode namespace (and thus path)
        $spaced = explode("\\", trim($name, "\\"));
        $n = count($spaced);

        // remove "Controller" from the name of the controller (eg: ControllerIndex -> Index)
        $spaced[$n - 1] = substr($spaced[$n - 1], strlen("Controller"));

        // transform each folder name to lowercase
        foreach ($spaced as $key => $value) {
            $spaced[$key] = strtolower($value);
        }

        // if not default view, skip the naming convention of the required controller.
        if ($skipName)
            $spaced[$n - 1] = $this->name;

        // name contains path and the file name
        $this->path = __DIR__ . "/Views/" . implode("/", array_slice($spaced, 0, -1));
        $this->name = __DIR__ . "/Views/" . implode("/", $spaced) . ".php";
    }

    /**
     * Apply view into existance.
     * @param $viewbag array Viewbag
     */
    public function apply($viewbag)
    {

        // set the viewbag
        $this->viewbag = $viewbag;

        // set existing values
        $this->viewbag['root'] = $this->applyRoot();
        $this->viewbag['partial'] = $this->partial;

        // if not partial, call recursively the layout engine.
        if (!$this->partial) {

            // get call array
            $this->layout = $this->layout();

            // add the current view to the display. see "continueRun".
            $this->layout[] = $this->name;

            // prepare the view
            $this->callIndex = -1;

            // call the view
            $this->continueRun();
        } else {
            // if partial file exists, display it.
            if (is_file($this->name)) {
                /** @noinspection PhpUnusedLocalVariableInspection */
                $viewbag = $this->viewbag;
                /** @noinspection PhpIncludeInspection */
                require $this->name;
            } else {
                echo "<pre>Could not find view '" . substr($this->name, strlen($this->path) + 1, -4) . "'\n</pre>";
            }
        }

    }

    /**
     * Constructs the view path (taking into account the depth of the current path)
     * Uses $GLOBALS['PAGE_STR'].
     * @return string
     *
     */
    protected function applyRoot()
    {
        $depth = 0;
        str_replace("/", "", $GLOBALS['PAGE_STR'], $depth);
        $root = './';
        $root .= str_repeat("../", $depth);
        return $root;
    }

    /**
     * Finds out every layout page that can be applied.
     * @return string[]
     */
    private function layout()
    {
        $arr = [];

        // assure "/" at the end.
        $path = rtrim($this->path, "/") . "/";

        // while not in "Classes/" (the root dir)
        do {
            if (substr($path, -8) === "Classes/")
                break;

            // add the current folder to the array
            $arr[] = $path;

            // and remove last element
            $path = substr($path, 0, strrpos(substr($path, 0, -1), "/") + 1);
        } while (true);

        // reverse to apply from the global layout to the individual layout.
        return array_reverse($arr);
    }

    /**
     * Continues running the layout. <br>
     * The layout file *will* call this method (because an private method is accesible through _this_, as the file is
     *  _required_ in the scope of the object. <br>
     * <br>
     * Eg:
     * <ol>
     *  <li>Views/_layout.php "$this->continueRun()"</li>
     *  <li>Views/main/_layout.php "$this->continueLayout()"</li><br>
     *  <li>Views/main/index.php "&lt;EOF&gt;"</li><br>
     *  <li>Views/main/_layout.php "&lt;EOF&gt;"</li>
     *  <li>Views/_layout.php "&lt;EOF&gt;" </li>
     * </ol>
     */
    private function continueRun()
    {

        // increment call index
        $this->callIndex++;

        // select path from array
        $item = $this->layout[$this->callIndex];

        // if not the last one, get the layout scheme.
        if ($this->callIndex != count($this->layout) - 1)
            $item .= "_layout.php";

        // if exists, bind the viewbag and require file.
        if (is_file($item)) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $viewbag = $this->viewbag;
            /** @noinspection PhpIncludeInspection */
            require $item;
        } else {
            echo "<pre>Could not find view '" . substr($this->name, strlen($this->path) + 1, -4) . "'\n</pre>";
        }
    }
}