<?php
/**
 * Created at: 29/03/16 14:31
 */
/**
 * @var $this \View
 */
if (!isset($viewbag) || !isset($this)) die();
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Foundation | Welcome</title>
    <link rel="stylesheet" href="<?= $viewbag['root'] ?>content/css/foundation.min.css"/>
    <link rel="stylesheet" href="<?= $viewbag['root'] ?>content/css/app.css"/>
</head>
<body>
<div class="row">
    <div class="large-12">
        <?php $this->continueRun(); ?>
    </div>
</div>
<script src="<?= $viewbag['root'] ?>content/js/vendor/jquery.min.js"></script>
<script src="<?= $viewbag['root'] ?>content/js/vendor/what-input.min.js"></script>
<script src="<?= $viewbag['root'] ?>content/js/foundation.min.js"></script>
<script src="<?= $viewbag['root'] ?>content/js/app.js"></script>
</body>
</html>