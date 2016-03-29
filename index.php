<?php
/**
 * Created at: 29/03/16 12:30
 */

ini_set("display_errors", 1);
error_reporting(E_ALL);

$page = empty($_GET['page']) ? "index" : $_GET['page'];

spl_autoload_register(function ($className) {
    $className = ltrim($className, '\\');
    $fileName  = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fileName = __DIR__ . "/Classes/" . $fileName;
    echo "<pre>";var_dump($fileName);echo "</pre>";
    require $fileName;
});

$pages = explode("/", $page);
$n = count($pages);

if (empty($pages[$n - 1]))
    $pages[$n - 1] = "index";

$pages[$n - 1] = "Controller" . ucfirst($pages[$n - 1]);

$controller = "\\Controllers\\" . implode("\\", $pages);

/** @var Controller $c*/
$c = new $controller();

$c->run();
