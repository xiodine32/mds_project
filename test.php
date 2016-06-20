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


$tests = [];
$running = [];

$i = 0;
foreach (glob(__DIR__ . "/tests/*") as $test) {
    $tests[] = basename($test);
    if (!empty($_POST['test'][++$i]))
        $running[] = basename($test);
}

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tests | RAT</title>
    <link rel="stylesheet" href="content/css/foundation.min.css"/>
    <link rel="stylesheet" href="content/css/app.css"/>
    <style type="text/css">code {
            white-space: inherit;
        }</style>
</head>
<body>
<div class="row">
    <div class="large-12 columns text-center">
        <h1>Unit Tests</h1>
        <hr>
    </div>
</div>
<?php foreach ($running as $test): ?>
    <div class="row">
        <div class="large-12 columns">
            <h2><?= ucfirst(basename($test, ".test")) ?></h2>
            <div class="callout">
                <?php runLanguage(file_get_contents(__DIR__ . "/tests/" . $test)) ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<div class="row">
    <div class="large-12 columns">
        <form action="test.php" method="post">
            <?php $i = 0;
            foreach ($tests as $test):$i++ ?>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="test-<?= $i ?>" class="text-right"><?= ucfirst(basename($test, ".test")) ?>
                            : </label>
                    </div>
                    <div class="small-9 columns text-left">
                        <input type="checkbox" id="test-<?= $i ?>" name="test[<?= $i ?>]" class="testare">
                    </div>
                </div>
            <?php endforeach ?>
            <div class="row">
                <div class="small-9 columns small-offset-3">
                    <button class="button large" type="submit">Run Selected</button>
                    <button class="button large secondary" id="runAll" type="submit">Run All</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php

?>
<script src="content/js/vendor/jquery.min.js"></script>
<script src="content/js/vendor/what-input.min.js"></script>
<script src="content/js/vendor/foundation.min.js"></script>
<script src="content/js/app.js"></script>
<script>
    $("#runAll").click(function () {
        $(".testare").each(function () {
            $(this).click();
        });
    });
</script>
</body>
</html>

<?php


function runLanguage($fileData)
{
    $test = new \Tester();
    $test->failed = false;
    foreach (explode("\n", $fileData) as $line) {
        flush();
        ob_flush();
        flush();
        $line = trim($line);
        if ($line[0] == '#')
            continue;

        if (stringBeginsWith($line, "load ")) {
            if (stringBeginsWith($line, "singleton ")) {
                $test->loadClassSingleton($line);
                echo "<p>loaded class: " . highlightCode($line) . "</p>";
                continue;
            }
            if ($test->loadClass($line)) {
                echo "<p>loaded class: " . highlightCode($line) . "</p>";
            }
            continue;
        }

        if (stringBeginsWith($line, "expect ")) {

            if (stringBeginsWith($line, "field ")) {
                list($fieldName, $value) = explode(" ", $line);
                echo "<p>expecting field " . highlightCode($fieldName);
                echo " (" . highlightCode($test->getField($fieldName)) . ") - ";
                echo highlightCode($value) . " - ";
                if ($test->expectField($fieldName, $value)) {
                    echo "<span class='label success'>true</span>";
                    continue;
                }
                echo "<span class='label alert'>false</span>";
                break;
            }

            if (stringBeginsWith($line, "true ")) {
                echo "<p>expecting expression " . highlightCode($line);
                if ($test->evaluateExpression($line)) {
                    echo " - <span class='label success'>true</span>";
                    continue;
                }
                echo " - <span class='label alert'>false</span>";
                break;
            }

            echo "<p>undefined expect: " . highlightCode($line) . "</p>";
            continue;
        }

        if (stringBeginsWith($line, "method ")) {
            $test->runMethod($line);
            echo "<p>ran method " . highlightCode($line);
            continue;
        }

        echo "<p>undefined call: " . highlightCode($line) . "</p>";
        continue;
    }
    if ($test->failed) {
        echo "<p class='label alert' style='font-size: 2em;'>TEST FAILED</p>";
        return;
    }
    echo "<p class='label success' style='font-size: 2em;'>TEST SUCCESS</p>";
}

/**
 * @param $line string
 * @param $match string
 * @return bool
 */
function stringBeginsWith(&$line, $match)
{
    $strlen = strlen($match);

    if (substr($line, 0, $strlen) === $match) {
        $line = substr($line, $strlen);
        return true;
    }

    return false;
}

/**
 * @param $code string
 * @return string
 */
function highlightCode($code)
{
    if ($code == null)
        $code = "null";
    return str_replace("\n", "", highlight_string($code, true));
}