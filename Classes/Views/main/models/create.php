<?php
/**
 * Created at: 2016-04-20 14:39
 */
/**
 * @var array $viewbag
 * @var $this \View
 */
if (!isset($viewbag) || !isset($this)) die();

$isEdit = isset($isEdit) ? $isEdit : false;
$title = $isEdit ? "Edit" : "Create";

/** @var \FormGenerator $formg */
$formg = $viewbag['form_generator'];
?>
<?= $formg->generate() ?>