<?php
/**
 * Created at: 29/03/16 12:30
 */


// show errors if they exist
//define("DISABLE_MINIFY", 1);
ini_set("display_errors", 1);
error_reporting(E_ALL);

// get page (on empty, use 'index')
$page = empty($_GET['page']) ? "index" : $_GET['page'];


// register automatic inclusion of required classes
spl_autoload_register(function ($className) {

    // remove last \
    $className = ltrim($className, '\\');
    $fileName  = '';

    // find namespace and className if they're not in global namespace
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    // replace _ with dir separator
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    // set path
    $fileName = __DIR__ . "/Classes/" . $fileName;

    // if is file, require
    if (is_file($fileName)) {
        /** @noinspection PhpIncludeInspection */
        require $fileName;
    } else {

        // if requiring a weird class, die calling the 404 controller.
        require __DIR__ . "/Classes/Controllers/Controller404.php";
        (new \Controllers\Controller404())->run();
        die();
    }
});

// explode required page
$pages = explode("/", $page);
$n = count($pages);

// if trail empty, set as index
if (empty($pages[$n - 1]))
    $pages[$n - 1] = "index";


// capitalize each (to conform to PHP namespace standards)
foreach ($pages as $key => $value) {
    $pages[$key] = ucfirst($value);
}

// set globals (in case)

$GLOBALS['PAGE_ARR'] = $pages;
$GLOBALS['PAGE_STR'] = $page;

// add Controller to page name
$pages[$n - 1] = "Controller" . clear($pages[$n - 1]);

// construct the controller that needs to be created.
$controller = "\\Controllers\\" . implode("\\", $pages);

// create & run
/** @var Controller $c*/
$c = new $controller();
$c->run();

########## FUNCTIONS ##########

/**
 * Clear extension from page name
 * @param $page string
 * @return string
 */
function clear($page)
{
    $max = strrpos($page, ".");
    $page = substr($page, 0, $max !== false ? $max : strlen($page));
    return $page;
}
