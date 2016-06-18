<?php
/**
 * Created at: 29/03/16 12:34
 */
if (!isset($viewbag)) die();
//$viewbag['error'] = 'Wrong username / password!';
$fg = new FormGenerator($this);
$fg->error = isset($viewbag['error']);
$fg->errorMessage = $fg->error ? $viewbag['error'] : "There are some errors in your form.";
$fg->success = isset($viewbag['success']);
$fg->successMessage = isset($viewbag['success']) ? $viewbag['success'] : "";

$fg->action = $viewbag['root'] . "main/departments";
$fg->title = "Register new department";
$fg->formID = "addDepartment";
$fg->ajax = $viewbag['partial'];
$fg->show = $viewbag['employee']->administrator;

$fg->addInput("text", "title", "title", "Title", "Required!", true);
$fg->addInput("number", "maxSize", "maxSize", "Max Size", "Error here!", true, ["attributes" => 'min="1"']);
$fg->addInput("date", "startDate", "startDate", "Start Date", "Required!", "date");
$fg->addInput("text", "monthlyExpenses", "monthlyExpenses", "Monthy Expenses", "Required and a number!", "number");
$fg->addInput("text", "deptDescription", "deptDescription", "Department Description", "", false);

$fg->addSubmit("button", "Register");

?>
<h1 class="text-center">Departments</h1>
<hr>
<?= $fg->generate() ?>
