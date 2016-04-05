<?php
/**
 * Created at: 05/04/16 17:12
 */
if (!isset($viewbag)) die();
$errors = isset($viewbag['error']);
$success = isset($viewbag['success']);
?>
<h1 class="text-center">Contacts</h1>
<section id="addContact">
    <?php if ($viewbag['employee']->administrator): ?>
        <h3 class="text-center">Register new contact</h3>
        <?php if ($success): ?>
            <div class="callout success">
                <?= $viewbag['success'] ?>
            </div>
        <?php endif ?>
        <form action="<?= $viewbag['root'] ?>main/contacts" method="post" data-abide novalidate>
            <div data-abide-error class="alert callout" style="<?= $errors ? 'display:block' : 'display:none' ?>"
                <?= $errors ? 'role="alert"' : '' ?>>
                <p><i class="fi-alert"></i><?= $errors ? $viewbag['error'] : "There are some errors in your form." ?>
                </p>
            </div>

            <!-- title -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="title"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Title: </label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="title" placeholder="Project Title" id="title" required
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Error here, please fix!</span>
                </div>
            </div>

            <!-- startDate -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="startDate"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Start Date: </label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="startDate" placeholder="Start Date" id="startDate" required
                           pattern="date"
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Error here, please fix!</span>
                </div>
            </div>

            <!-- endDate -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="endDate"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">End Date: </label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="endDate" placeholder="End Date" id="endDate" required
                           pattern="date"
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Error here, please fix!</span>
                </div>
            </div>

            <!-- contractNumber -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="contractNumber"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Contract Nr:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="contractNumber" placeholder="Contract Number" id="contractNumber" required
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Error here, please fix!</span>
                </div>
            </div>

            <!-- pjDescription -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="pjDescription"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">PJ Description:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="pjDescription" placeholder="Juridic Person Description" id="pjDescription"
                           required
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Error here, please fix!</span>
                </div>
            </div>

            <!-- budget -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="budget"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Budget:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="budget" placeholder="Budget" id="budget" required pattern="number"
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Error here, please fix!</span>
                </div>
            </div>

            <!-- departmentID -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="departmentID"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Department: </label>
                </div>
                <div class="small-9 columns">
                    <select class="<?= $errors ? ' is-invalid-input' : '' ?>" id="departmentID">
                        <option>--- NONE ---</option>
                    </select>
                    <span class="form-error">Error here, please fix!</span>
                </div>
            </div>

            <!-- Submit -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="contactID"
                           class="text-right middle">Submit: </label>
                </div>
                <div class="small-9 column">
                    <button type="submit" class="button">New Project</button>
                </div>
            </div>
        </form>
    <?php endif ?>
</section>
