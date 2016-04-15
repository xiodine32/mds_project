<?php
/**
 * Created at: 15/04/16 12:42
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

if (customCode()) {
    header("Location: cache.php");
}

$globs = glob(__DIR__ . "/content/cache/*");

?>
    <!doctype html>
    <html class="no-js" lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Cache | RAT</title>
        <link rel="stylesheet" href="content/css/foundation.min.css"/>
        <link rel="stylesheet" href="content/css/app.css"/>
    </head>
<body>
<div class="row">
    <div class="large-12 text-center">
        <h1>Cache</h1>
        <hr>
        <a href="?delete=true" class="button" onclick="return confirm('Are you sure?');">Delete Cache</a>
        <ul id="cookies" class="no-bullet">
            <?php foreach ($globs as $glob): ?>
                <li>
                    <div class="row" style="margin:0 0 2em 0">
                        <div class="small-5 columns text-right">
                            <a href="content/cache/<?= basename($glob) ?>" target="_blank"><?= basename($glob) ?></a>
                        </div>
                        <div class="small-2 columns text-center">-</div>
                        <div class="small-5 columns text-left"><?= date(DATE_COOKIE, filectime($glob)) ?></div>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<script src="content/js/vendor/jquery.min.js"></script>
<script src="content/js/vendor/foundation.min.js"></script>
<script>
    $(function () {
        var reload = function () {
            $("#cookies").load("cache.php #cookies > li");
        };
        setInterval(reload, 10000);
        $(window).on('focus', reload);
    });
</script>
<?php
function customCode()
{
    $delete = filter_input(INPUT_GET, "delete", FILTER_SANITIZE_STRING);
    if ($delete) {

        foreach (glob(__DIR__ . "/content/cache/*") as $file) {
            unlink($file);
        }

        return true;
    }

    return false;
}