<?php
/**
 * Created at: 29/03/16 12:34
 */
if (!isset($viewbag)) die();
//$viewbag['error'] = 'Wrong username / password!';
$errors = isset($viewbag['error']);
$success = isset($viewbag['success']);
?>
<h1 class="text-center">Employees</h1>
<hr>
<section>
    <?php if ($viewbag['employee']->administrator): ?>
        <h3 class="text-center">Register new employee</h3>
        <?php if ($success): ?>
            <div class="callout success">
                <?= $viewbag['success'] ?>
            </div>
        <?php endif ?>
        <form action="<?= $viewbag['root'] ?>main/employees" method="post" data-abide novalidate>
            <div data-abide-error class="alert callout" style="<?= $errors ? 'display:block' : 'display:none' ?>"
                <?= $errors ? 'role="alert"' : '' ?>>
                <p><i class="fi-alert"></i><?= $errors ? $viewbag['error'] : "There are some errors in your form." ?>
                </p>
            </div>

            <!-- Username -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="username"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Username:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="username" placeholder="Username" id="username" required
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Required!</span>
                </div>
            </div>

            <!-- First Name -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="firstName"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">First Name:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="firstName" placeholder="First Name" id="firstName" required
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Required!</span>
                </div>
            </div>

            <!-- Middle Initial -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="middleInitial"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Middle Initial:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="middleInitial" placeholder="Middle Initial" id="middleInitial" required
                           class="<?= $errors ? ' is-invalid-input' : '' ?>" maxlength="1">
                    <span class="form-error">Required!</span>
                </div>
            </div>

            <!-- Last Name -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="lastName"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Last Name:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="lastName" placeholder="Last Name" id="lastName" required
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Required!</span>
                </div>
            </div>

            <!-- Title -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="title"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Title:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="title" placeholder="Title" id="title" required
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Required!</span>
                </div>
            </div>

            <!-- CNP -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="cnp"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">CNP:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="cnp" placeholder="CNP" id="cnp" required pattern="cnp"
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Required!</span>
                </div>
            </div>

            <!-- Salary -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="salary"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Salary:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="salary" placeholder="Salary" id="salary" required pattern="number"
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Required!</span>
                </div>
            </div>

            <!-- Prior Salary -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="priorSalary"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Prior Salary:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="priorSalary" placeholder="Prior Salary" id="priorSalary" required
                           pattern="number"
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Required!</span>
                </div>
            </div>

            <!-- Hire Date -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="hireDate"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Hire Date:</label>
                </div>
                <div class="small-9 columns">
                    <input type="text" name="hireDate" placeholder="<?= date("Y-m-d") ?>" id="hireDate" required
                           pattern="date"
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Required!</span>
                </div>
            </div>

            <!-- Password -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="password"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Password:</label>
                </div>
                <div class="small-9 columns">
                    <input type="password" name="password" placeholder="Password" id="password" required
                           class="<?= $errors ? ' is-invalid-input' : '' ?>">
                    <span class="form-error">Required!</span>
                </div>
            </div>

            <!-- Repeat Password -->
            <div class="row">
                <div class="small-3 columns">
                    <label for="password2"
                           class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Repeat:</label>
                </div>
                <div class="small-9 columns">
                    <input type="password" name="password2" placeholder="Password" id="password2" required
                           class="<?= $errors ? ' is-invalid-input' : '' ?>" data-equalto="password">
                    <span class="form-error">Required to match password!</span>
                </div>
            </div>

            <!-- Submit -->
            <div class="row">
                <div class="small-offset-3 small-9 column">
                    <button type="submit" class="button">Register</button>
                </div>
            </div>
        </form>
    <?php endif ?>
</section>