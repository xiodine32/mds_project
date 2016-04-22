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

$fg->action = $viewbag['root'] . "main/employees";
$fg->title = "Register new employee";
$fg->formID = "addEmployee";
$fg->ajax = $viewbag['partial'];
$fg->show = $viewbag['employee']->administrator;

$fg->addInput("text", "employeeUsername", "username", "Username", "Required!", true);
$fg->addInput("text", "employeeFirstName", "firstName", "First Name", "Required!", true);
$fg->addInput("text", "employeeMiddleInitial", "middleInitial", "Middle Initial", "Error here!", false);
$fg->addInput("text", "employeeLastName", "lastName", "Last Name", "Required!", true);
$fg->addInput("text", "employeeTitle", "title", "Title", "Required!", true);
$fg->addInput("text", "employeeCNP", "cnp", "CNP", "Required and must be valid", "cnp");
$fg->addInput("text", "employeeSalary", "salary", "Salary", "Required and must be number!", "number");
$fg->addInput("text", "employeePriorSalary", "priorSalary", "Prior Salary", "Required and must be number!", "number");
$fg->addInput("text", "employeeHireDate", "hireDate", "Hire Date", "Required and must be date!", "date");
$fg->addInput("password", "employeePassword", "password", "Password", "Required!", true);
$fg->addInput("password", "employeePasswordRepeat", "password2", "Repeat", "Required and must match!", true, [
    "attributes" => "data-equalto=\"employeePassword\""
]);

$fg->addSubmit("button", "Register");

?>
<h1 class="text-center">Employees</h1>
<hr>
<?= $fg->generate() ?>
