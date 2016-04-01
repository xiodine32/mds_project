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

if (!empty($_GET['classFor'])) {
    die(classFor($_GET['classFor']));
}

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
        <h1><a href="migration.php" target="_self">Migrations</a></h1>
        <hr>
        <?php if (empty($_POST['run'])):
            $handle = opendir(__DIR__ . '/migrations');
            ?>
            <form action="migration.php" method="post">
                <label for="run">Select Migration</label>
                <select name="run" id="run">
                    <option value="">--- SELECT ---</option>
                    <?php while (false !== ($file = readdir($handle))):
                        if ($file == '.' || $file == '..') continue;
                        ?>
                        <option value="<?= $file ?>"><?= ucfirst($file) ?></option>
                    <?php endwhile ?>
                </select>
                <button type="submit" class="button">Apply</button>
            </form>
            <?php
            closedir($handle);
        else: ?>
            <?php run($_POST['run']); ?>
        <?php endif ?>
        <hr>
        <h1>Tables</h1>
        <?php
        $arr = [];
        foreach (Database::instance()->query("SHOW TABLES;", [], Database::FETCH_ALL) as $item) {
            $arr[] = $item['Tables_in_x28xioro_mds'];
        }
        ?>
        <ul class="tabs" data-tabs id="table-datas">
            <?php foreach ($arr as $item): ?>
                <li class="tabs-title"><a href="#<?= strtolower($item) ?>"><?= ucfirst($item) ?></a></li>
            <?php endforeach ?>
        </ul>
        <div class="tabs-content" data-tabs-content='table-datas'>
            <?php
            foreach ($arr as $item) {
                describe($item);
            }
            ?>
        </div>
    </div>
</div>
<script src="content/js/vendor/jquery.min.js"></script>
<script src="content/js/vendor/what-input.min.js"></script>
<script src="content/js/foundation.min.js"></script>
<script src="content/js/app.js"></script>
<script>$("#table-datas").find("li > a").first().click();</script>
</body>
</html>

<?php

/**
 * Echo a table
 * @param $tableName string Table Name.
 */
function describe($tableName)
{
    $db = Database::instance();
    $table = $db->query("DESCRIBE {$tableName}", [], Database::FETCH_ALL);

    echo "<div class='tabs-panel ' id='" . strtolower($tableName) . "'>";
    echo "<table style='width: 100%;overflow: hidden;table-layout: fixed;font-size: 0.5em;' class='hover stack'>";
    echo "<thead>";
    echo "<tr>";
    foreach ($table as $item) {
        echo "<th style='text-align: center;'>{$item['Field']}<br><span style='font-weight: normal;'>{$item['Type']}</span></th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    $items = $db->query("SELECT * FROM {$tableName}", [], Database::FETCH_ALL);
    foreach ($items as $item) {
        echo "<tr>";
        foreach ($item as $value) {
            echo "<td>{$value}</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "<div><a href='#' onclick='$(this).parent().load(\"?classFor={$tableName}\");return false;'>get class</a></div>";
    echo "</div>";
}

/**
 * Run a SQL file.
 * @param $fileName string File name.
 */
function run($fileName)
{
    $query = file_get_contents(__DIR__ . "/migrations/" . $fileName);
    $database = Database::instance();

    foreach (explode(";", trim($query, ";")) as $item) {
        echo "<pre>" . print_r($item, true) . "</pre>";
        echo "<h1>";
        var_dump($database->query($item));
        echo "</h1>";
        echo "<hr>";
    }
}

function classFor($tableName)
{
    $db = Database::instance();
    $table = $db->query("DESCRIBE {$tableName}", [], Database::FETCH_ALL);
    $fields = [];
    foreach ($table as $item) {
        $fields[] = "    public \${$item['Field']};";
    }
    $fields = join("\n", $fields);

    $singleName = substr($tableName, 0, -1);

    $modelName = "Model{$singleName}";
    $code = "<?php
/**
 * Created at: " . date("d/m/y H:i") . "
 * Generated by migration.php
 */

namespace Models;

use SmartModel;

/**
 * Model {$singleName}.
 * @package Models
 */
class {$modelName} extends SmartModel
{
{$fields}

    /**
     * {$modelName} constructor.
     */
    public function __construct()
    {
        parent::__construct(\$this, \"{$tableName}\");
    }

}";
    return "<pre><textarea onclick='this.select();' style='font-size: 0.5em;' rows='50'>{$code}</textarea></pre>";
}