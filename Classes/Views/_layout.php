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
    <?php $this->includeCSS(["foundation.min.css", "foundation-icons.css", "jquery-ui.css"], false) ?>
    <?php $this->includeCSS(["app.css"]) ?>
</head>
<body>
<?php $this->includeJS("vendor/jquery.min.js", false) ?>
<div class="row expanded">
    <div class="large-12">
        <?php $this->continueRun(); ?>
    </div>
</div>

<?php $this->includeJS(["vendor/jquery-ui.min.js", "vendor/what-input.min.js", "vendor/foundation.min.js"], false) ?>
<?php $this->includeJS(["app.js"], true) ?>
<?= $this->footerJS ?>
</body>
</html>