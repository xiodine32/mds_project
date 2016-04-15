<?php
/**
 * Created at: 05/04/16 17:12
 */
if (!isset($viewbag)) die();
$errors = isset($viewbag['error']);
$success = isset($viewbag['success']);

$formGenerator = new FormGenerator($this);
$formGenerator->title = "Register new contact";
$formGenerator->formID = "addContact";
$formGenerator->ajax = $viewbag['partial'];
$formGenerator->action = "{$viewbag['root']}main/contacts";
$formGenerator->show = $viewbag['employee']->administrator;
$formGenerator->success = isset($viewbag['success']);
$formGenerator->successMessage = isset($viewbag['success']) ? $viewbag['success'] : "";
$formGenerator->error = isset($viewbag['error']);
$formGenerator->errorMessage = isset($viewbag['error']) ? $viewbag['error'] : "There are some errors in your form.";


$formGenerator->addInput("text", "contactName", "contactName", "Contact Name", "Please specify a name!", true);
$formGenerator->addInput("text", "contactPhoneNumber", "phoneNumber", "Phone", "", false);
$formGenerator->addInput("text", "contactFaxNumber", "faxNumber", "Fax", "", false);
$formGenerator->addInput("text", "contactEmail", "email", "Email", "", false);
$formGenerator->addInput("text", "contactAddress", "physicalAddress", "Physical Address", "", false);

$formGenerator->addSubmit("button", "Add");
    

?>
    <h1 class="text-center">Contacts</h1>
<?php if ($viewbag['employee']->administrator): ?>
    <?= $formGenerator->generate() ?>
<?php endif ?>
<div class="row">
    <div class="columns large-12">
        <hr>
        <pre><?= join("</pre><hr><pre>", $this->viewbag['contacts']) ?></pre>
    </div>
</div>