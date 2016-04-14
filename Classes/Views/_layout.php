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
    <?= $this->includeCSS(["foundation.min.css", "foundation-icons.css", "jquery-ui.css", "app.css"]) ?>
    <?= $this->includeJS(["vendor/jquery.min.js", "vendor/jquery-ui.min.js"]) ?>
</head>
<body>
<div class="row expanded">
    <div class="large-12">
        <?php $this->continueRun(); ?>
    </div>
</div>

<?= $this->includeJS(["vendor/what-input.min.js", "vendor/foundation.min.js", "app.js"]) ?>
</body>
</html>