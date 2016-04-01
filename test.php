<?php
/**
 * Created at: 30/03/16 15:56
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


?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Migrations | RAT</title>
    <link rel="stylesheet" href="content/css/foundation.min.css"/>
    <link rel="stylesheet" href="content/css/app.css"/>
    <style type="text/css">td, th {
            text-overflow: ellipsis;
            overflow: hidden;
        }</style>
</head>
<body>
<div class="row">
    <div class="large-12">
        <?php
        use Models\Generated\ModelDepartment;

        $model = new ModelDepartment();
        $model->select("departmentID = 1");
        echo "<pre>";
        var_dump($model);
        echo "</pre>";
        $model->maxSize = 15;
        $return = $model->update() ? "update successfull" : "update failed";
        //        echo "<pre>";var_dump($model);echo "</pre>";
        echo "<pre>";
        var_dump($return);
        echo "</pre>";
        echo "<pre>";
        var_dump(Database::instance()->lastError());
        echo "</pre>";
        ?>
    </div>
</div>
<script src="content/js/vendor/jquery.min.js"></script>
<script src="content/js/vendor/what-input.min.js"></script>
<script src="content/js/foundation.min.js"></script>
<script src="content/js/app.js"></script>
<script>$("#table-datas").find("li > a").first().click();</script>
</body>
</html>