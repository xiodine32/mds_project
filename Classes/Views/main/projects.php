<?php
/**
 * Created at: 01/04/16 17:37
 */
/**
 * @var $this \View
 */
if (!isset($viewbag)) die();
$errors = isset($viewbag['error']);
$success = isset($viewbag['success']);
$contacts = isset($viewbag['contacts']) ? $viewbag['contacts'] : [];
$departments = isset($viewbag['departments']) ? $viewbag['departments'] : [];
$projects = isset($viewbag['projects']) ? $viewbag['projects'] : [];

$formGenerator = new FormGenerator($this);
$formGenerator->title = "Register new project";
$formGenerator->formID = "addProject";
$formGenerator->ajax = $viewbag['partial'];
$formGenerator->action = "{$viewbag['root']}main/projects";
$formGenerator->show = $viewbag['employee']->administrator;
$formGenerator->success = isset($viewbag['success']);
$formGenerator->successMessage = isset($viewbag['success']) ? $viewbag['success'] : "";
$formGenerator->error = isset($viewbag['error']);
$formGenerator->errorMessage = isset($viewbag['error']) ? $viewbag['error'] : "There are some errors in your form.";


$formGenerator->addInput("text", "projectTitle", "title", "Project Title", "Error here, please fix!", true);

$formGenerator->addInput("date", "projectStartDate", "startDate", "Start Date", "Error here, please fix!", "date");
$formGenerator->addInput("date", "projectEndDate", "endDate", "End Date", "Error here, please fix!", "date");

$formGenerator->addInput("text", "projectContractNumber", "contractNumber", "Contract Number", "Error here, please fix!", true);
$formGenerator->addInput("text", "contactPjDescription", "pjDescription", "PJ Description", "Error here, please fix!", true);

$formGenerator->addInput("text", "contactBudget", "budget", "Budget", "Error here, please fix!", "number");

$deps = [];
foreach ($departments as $department) {
    /** @var $department \Models\Generated\ModelDepartment */
    $deps[$department->departmentID] = $department->title;
}
$formGenerator->addInput("select", "contactDepartmentID", "departmentID", "Department", "Error here, please fix!", false, ['options' => $deps]);

?>
<h1 class="text-center">Projects</h1>
<?php if ($viewbag['employee']->administrator): ?>
    <?php $formGenerator->addCustomBegin(); ?>
    <!-- contactID -->
    <div class="row">
        <div class="small-3 columns">
            <label for="contactID"
                   class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Contact: </label>
            </div>
        <div class="small-9 columns">
            <select class="<?= $errors ? ' is-invalid-input' : '' ?>" id="contactID" required name="contactID">
                <option value="">--- NONE ---</option>
                <?php foreach ($contacts as $contact): /**@var $contact \Models\Generated\ModelContact */ ?>
                    <option value="<?= $contact->contactID ?>"><?= $contact->contactName ?></option>
                <?php endforeach ?>
            </select>
            <a href="#" onclick="return false;" id="addContactButton" class="button success small">Add
                Contact</a>
            <span class="form-error">Error here, please fix!</span>
        </div>
    </div>
    <?php $formGenerator->addCustomEnd(); ?>
    <?php $formGenerator->addSubmit("button", "New Project"); ?>
    <?= $formGenerator->generate() ?>
<?php endif ?>
    <hr>
    <div class="row">
        <div class="large-12 columns">
            <?php foreach ($projects as $project): /** @var \Models\Generated\ModelProject $project */ ?>
                <dl class="presentator callout" style="min-width: 500px;">
                    <dt>Title</dt>
                    <dd><?= $project->title ?></dd>
                    <dt>Start Date</dt>
                    <dd><?= $project->startDate ?></dd>
                    <dt>End Date</dt>
                    <dd><?= $project->endDate ?></dd>
                    <dt>Contract Number</dt>
                    <dd><?= $project->contractNumber ?></dd>
                    <dt>PJ Description</dt>
                    <dd><?= $project->pjDescription ?></dd>
                    <dt>Budget</dt>
                    <dd><?= $project->budget ?></dd>
                    <dt>Department</dt>
                    <dd><?= $project->department->title ?></dd>
                    <dt>Contact</dt>
                    <dd><?= $project->contact->contactName ?> (
                        <a href="tel:<?= $project->contact->phoneNumber ?>"><?= $project->contact->phoneNumber ?></a>
                        )
                    </dd>
                </dl>
            <?php endforeach ?>
        </div>
    </div>
<?php $this->includeJS("main/quickadd.js", true, true) ?>
<?php $this->includeInlineBegin() ?>
<script>
    (function () {
        $('#addContactButton').click(function () {
            var $vi = $(this);
            $vi.attr("disabled", true);
            var quickAdd = new QuickAdd("<?=$viewbag['root']?>main/contacts", "#addContact");
            quickAdd.close(function () {
                setTimeout(function () {
                    $("#contactID").load("<?=$viewbag['root']?>main/contacts", {reloadcontactID: true}, function () {
                        $vi.attr("disabled", false);
                    });
                }, 1000);
            });
        });
    })();
</script>
<?php $this->includeJSInlineEnd() ?>