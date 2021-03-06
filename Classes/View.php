<?php

/**
 * Created at: 29/03/16 12:34
 */


/**
 * Class View
 */
class View
{
    protected $viewPage;
    private $name;
    private $partial;
    private $path;
    private $layout = [];
    private $callIndex = -1;
    private $viewbag;
    private $footerJS = "";

    /**
     * View constructor.
     * @param null|string $name null if default view (for Controller) or view for controller.
     * @param null|boolean $isPartial If true, will display view without layout.
     */
    public function __construct($name = null, $isPartial = null)
    {
//        foreach (glob(__DIR__ . "/../content/cache/*") as $item) {
//            if (is_file($item))
//                unlink($item);
//        }
        $this->name = $name;
        $this->partial = $isPartial;
        $this->viewPage = $this->viewbag['root'] . $GLOBALS['PAGE_STR'];
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
        $count = count($spaced);

        // remove "Controller" from the name of the controller (eg: ControllerIndex -> Index)
        $spaced[$count - 1] = substr($spaced[$count - 1], strlen("Controller"));

        // transform each folder name to lowercase
        foreach ($spaced as $key => $value) {
            $spaced[$key] = strtolower($value);
        }

        // if not default view, skip the naming convention of the required controller.
        if ($skipName)
            $spaced[$count - 1] = $this->name;

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
        /**@var Request $request */
        $request = $viewbag['request'];

        // if partial is null, decide for myself
        if ($this->partial === null) {

            // if ajax, it's partial
            $this->partial = !empty($request->server['HTTP_X_REQUESTED_WITH']) &&
                strtolower($request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        }

        // set the viewbag
        $this->viewbag = $viewbag;

        // set existing values
        $this->viewbag['root'] = $this->applyRoot($request);
        $this->viewbag['partial'] = $this->partial;
        $this->viewbag['page'] = $this->viewPage;

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
            return;
        }

        $this->includeItem($this->name);
    }

    /**
     * Constructs the view path (taking into account the depth of the current path)
     * @param Request $request
     * @return string
     */
    protected function applyRoot($request)
    {
        $depth = 0;
        str_replace("/", "", $request->globals['PAGE_STR'], $depth);
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

        $this->includeItem($item);
    }

    /**
     * @param $item string
     */
    protected function includeItem($item)
    {
        // if exists, bind the viewbag and require file.
        if (is_file($item)) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $viewbag = $this->viewbag;
            /** @noinspection PhpIncludeInspection */
            require $item;
            return;
        }

        echo "<pre>Could not find view '" . substr($this->name, strlen($this->path) + 1, -4) . "'\n</pre>";
    }

    public function includeCSS($paths, $minify = true)
    {
        if (!is_array($paths))
            $paths = [$paths];

        $content = "";
        foreach ($paths as $path) {
            $content .= file_get_contents(__DIR__ . "/../content/css/{$path}") . "\n";
        }
        $pathNew = Minifier::instance()->css($content, "{$this->viewbag['root']}content/", $minify);
        echo "<link rel='stylesheet' href='{$pathNew}' />\n";
        return;
    }

    public function includeJS($paths, $minify = true, $atFooter = false)
    {
        if (!is_array($paths))
            $paths = [$paths];

        $content = "";
        foreach ($paths as $path) {
            $content .= file_get_contents(__DIR__ . "/../content/js/{$path}") . "\n";
        }
        $pathNew = Minifier::instance()->js($content, "{$this->viewbag['root']}content/", $minify);

        $str = "<script type='application/javascript' src='{$pathNew}'></script>\n";

        if ($atFooter) {
            $this->footerJS .= $str;
            return;
        }
        echo $str;
    }

    public function includeCSSInlineEnd()
    {
        $content = ob_get_contents();
        ob_end_clean();

        $content = trim($content);
        if (substr($content, 0, 7) === "<style>")
            $content = substr($content, 7);
        if (substr($content, -8) === "</style>")
            $content = substr($content, 0, -8);
        $content = trim($content);

        $pathNew = Minifier::instance()->css($content, "{$this->viewbag['root']}content/");
        echo "<link rel='stylesheet' href='{$pathNew}' />\n";
    }

    public function includeInlineBegin()
    {
        ob_start();
    }

    public function includeJSInlineEnd($atFooter = true)
    {
        $content = ob_get_contents();
        ob_end_clean();

        $content = trim($content);
        if (substr($content, 0, 8) === "<script>")
            $content = substr($content, 8);
        if (substr($content, -9) === "</script>")
            $content = substr($content, 0, -9);
        $content = trim($content);

        $pathNew = Minifier::instance()->js($content, "{$this->viewbag['root']}content/");
        $text = "<script type='application/javascript' src='{$pathNew}'></script>\n";

        if ($atFooter) {
            $this->footerJS .= $text;
            return;
        }
        echo $text;
    }

}