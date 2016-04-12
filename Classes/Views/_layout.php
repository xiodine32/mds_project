<?php
/**
 * Created at: 29/03/16 14:31
 */
/**
 * @var $this \View
 */
if (!isset($viewbag) || !isset($this)) die();
if (empty($viewbag['title'])) $viewbag['title'] = 'FIXME';
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= $viewbag['title'] ?> | RAT</title>
    <link rel="stylesheet" href="<?= $viewbag['root'] ?>content/css/foundation.min.css"/>
    <link rel="stylesheet" href="<?= $viewbag['root'] ?>content/css/foundation-icons.css">
    <link rel="stylesheet" href="<?= $viewbag['root'] ?>content/css/jquery-ui.css"/>
    <link rel="stylesheet" href="<?= $viewbag['root'] ?>content/css/app.css"/>
    <script src="<?= $viewbag['root'] ?>content/js/vendor/jquery.min.js"></script>
    <script src="<?= $viewbag['root'] ?>content/js/vendor/jquery-ui.min.js"></script>
</head>
<body>
<div class="row expanded">
    <div class="large-12">
        <?php $this->continueRun(); ?>
    </div>
</div>
<script src="<?= $viewbag['root'] ?>content/js/vendor/what-input.min.js"></script>
<script src="<?= $viewbag['root'] ?>content/js/vendor/foundation.min.js"></script>
<script src="<?= $viewbag['root'] ?>content/js/app.js"></script>
</body>
</html>