<?php
/**
 * Created at: 20/04/16 11:32
 */
/**
 * @var $this \View
 */
if (!isset($viewbag) || !isset($this)) die();

$form = new FormGenerator($this);
$form->title = "Regenerate Controllers";
$form->action = $viewbag['root'] . "main/models/";
$form->formID = "regenerateTables";
$form->success = isset($viewbag['success']);
$form->successMessage = "Successfully regenerated controllers";
$form->addSubmit("button", "Regenerate Tables", "name=\"regenerate\" value=\"true\"");

?>
<?php if (DEV): ?>
    <div class="callout secondary">
        <?= $form->generate() ?>
    </div>
<?php endif ?>
<div class="text-center">
    Please select a model.
</div>
