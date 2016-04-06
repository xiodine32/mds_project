<?php
/**
 * Created at: 05/04/16 17:12
 */
if (!isset($viewbag)) die();
$errors = isset($viewbag['error']);
$success = isset($viewbag['success']);

$formGenerator = new FormGenerator();
$formGenerator->title = "Register new contact";
$formGenerator->formID = "addContact";
$formGenerator->ajax = $viewbag['partial'];
$formGenerator->action = "{$viewbag['root']}main/contacts";
$formGenerator->show = $viewbag['employee']->administrator;
$formGenerator->success = isset($viewbag['success']);
$formGenerator->successMessage = isset($viewbag['success']) ? $viewbag['success'] : "";
$formGenerator->error = isset($viewbag['error']);
$formGenerator->errorMessage = isset($viewbag['error']) ? $viewbag['error'] : "There are some errors in your form.";


$formGenerator->addInput("text", "contactTitle", "title", "Project Title", "Error here, please fix!", true);

$formGenerator->addInput("date", "contactStartDate", "startDate", "Start Date", "Error here, please fix!", "date");
$formGenerator->addInput("date", "contactEndDate", "endDate", "End Date", "Error here, please fix!", "date");

$formGenerator->addInput("text", "contactContractNumber", "contractNumber", "Contract Number", "Error here, please fix!", true);
$formGenerator->addInput("text", "contactPjDescription", "pjDescription", "PJ Description", "Error here, please fix!", true);

$formGenerator->addInput("text", "contactBudget", "budget", "Budget", "Error here, please fix!", "number");

$formGenerator->addInput("select", "contactDepartmentID", "departmentID", "Department", "Error here, please fix!", false, ['options' => [
    "test" => "Test"
]]);

$formGenerator->addSubmit("button", "New Project");

?>
    <h1 class="text-center">Contacts</h1>
<?= $formGenerator->generate() ?>