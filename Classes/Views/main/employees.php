<?php
/**
 * Created at: 29/03/16 12:34
 */
if (!isset($viewbag)) die();
//$viewbag['error'] = 'Wrong username / password!';

$departments = [];
foreach ($viewbag['departments'] as $department) {
    if (empty($department->departmentID)) {
        $department->departmentID = "null";
        $department->title = "None";
    }
    $departments[$department->departmentID] = $department->title;
}
$projects = [];
foreach ($viewbag['projects'] as $project) {
    if (empty($project->departmentID)) {
        $project->projectID = "null";
        $project->departmentID = "null";
        $project->title = "None";
    }
    $projects[$project->projectID] = $project->title;

}

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
<div class="row collapse">
    <div class="columns large-12">
        <ul class="tabs" data-tabs id="example-tabs">
            <li class="tabs-title is-active"><a href="#add" aria-selected="true">Register Employee</a></li>
            <li class="tabs-title"><a href="#link" id="tab2">Link Employee Department</a></li>
            <li class="tabs-title"><a href="#linkProject" id="tab3">Link Employee Project</a></li>
        </ul>
    </div>
</div>
<div class="tabs-content" data-tabs-content="example-tabs">
    <div class="tabs-panel is-active" id="add">
        <?= $fg->generate() ?>
    </div>
    <section class="tabs-panel" id="link">
        <form action="<?= $viewbag['root'] . "main/employees#tab2" ?>" method="post">
            <h3 class="text-center">Link Employee Department</h3>
            <div class="row">
                <?php
                /**@param \Models\ModelEmployee $employee */
                /**@param \Models\Generated\ModelDepartment $department */
                foreach ($viewbag['employees'] as $employee):
                    ?>
                    <div class="columns small-3">
                        <ul style="list-style-type: none;margin-left:0;">
                            <li>
                                <?= $employee->firstName . " " . $employee->lastName ?>
                            </li>
                            <li>
                                <p>
                                    Currently in:
                                    <strong>
                                        <?= !empty($employee->departmentID) ? $departments[$employee->departmentID] : "none" ?>
                                    </strong>
                                </p>
                            </li>
                        </ul>
                        <label for="employee_<?= $employee->employeeID ?>">
                            Selected:
                            <input type="checkbox" name="employee[]"
                                   value="<?= $employee->employeeID ?>"
                                   id="employee_<?= $employee->employeeID ?>">
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <div class="row">
                <?php foreach ($viewbag['departments'] as $department): ?>
                    <div class="columns small-4">
                        <label for="department_<?= $department->departmentID ?>">
                            Department <strong><?= $department->title ?></strong>:
                            <input type="radio" name="department" value="<?= $department->departmentID ?>"
                                   id="department_<?= $department->departmentID ?>">
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <div class="row collapse">
                <div class="column small-12">
                    <button class="button expanded" type="submit" name="link" value="true">Link</button>
                </div>
            </div>
        </form>
    </section>
    <section class="tabs-panel" id="linkProject">
        <form action="<?= $viewbag['root'] . "main/employees#tab3" ?>" method="post">
            <h3 class="text-center">Link Employee Project</h3>
            <div class="row">
                <?php
                /**@param \Models\ModelEmployee $employee */
                /**@param \Models\Generated\ModelProject $department */
                foreach ($viewbag['employees'] as $employee):
                    ?>
                    <div class="columns small-3">
                        <ul style="list-style-type: none;margin-left:0;">
                            <li>
                                <?= $employee->firstName . " " . $employee->lastName ?>
                            </li>
                            <li>
                                Department:
                                <strong>
                                    <?= !empty($employee->departmentID) ? $departments[$employee->departmentID] : "none" ?>
                                </strong>
                            </li>
                            <li>
                                Project:
                                <strong>
                                    <?= !empty($employee->projectID) ? $projects[$employee->projectID] : "none" ?>
                                </strong>
                            </li>

                        </ul>
                        <label for="employeeProject_<?= $employee->employeeID ?>">
                            Selected:
                            <input type="checkbox" name="employeeProject[]"
                                   value="<?= $employee->employeeID ?>"
                                   id="employeeProject_<?= $employee->employeeID ?>">
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <div class="row">
                <?php foreach ($viewbag['projects'] as $project): ?>
                    <div class="columns small-4">
                        <ul style="list-style-type: none;margin-left:0;">
                            <li><strong><?= $project->title ?></strong></li>
                            <li>Department: <?= $departments[$project->departmentID] ?></li>
                        </ul>
                        <label for="project_<?= $project->projectID ?>">
                            Selected:
                            <input type="radio" name="project" value="<?= $project->projectID ?>"
                                   id="project_<?= $project->projectID ?>">
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <div class="row collapse">
                <div class="column small-12">
                    <button class="button expanded" type="submit" name="linkProject" value="true">Link</button>
                </div>
            </div>
        </form>
    </section>
</div>
<?php $this->includeInlineBegin() ?>
<script>
    $(function () {
        if (window.location.hash.length > 1) {
            $(window.location.hash).click();
        }
    });
</script>
<?php $this->includeJSInlineEnd() ?>
