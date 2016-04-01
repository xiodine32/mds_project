<?php
/**
 * Created at: 29/03/16 12:34
 */
if (!isset($viewbag)) die();
$errors = isset($viewbag['error']);
?>
<h1>Resource Allocation Tool</h1>
<h2 class="subheader">Less bloatware, more productivity!</h2>
<hr>
<section>
    <h3 class="text-center">Login</h3>
    <form action="<?= $viewbag['root'] ?>login" method="post" data-abide novalidate>
        <div data-abide-error class="alert callout" style="<?= $errors ? 'display:block' : 'display:none' ?>"
            <?= $errors ? 'role="alert"' : '' ?>>
            <p><i class="fi-alert"></i> <?= $errors ? $viewbag['error'] : "There are some errors in your form." ?></p>
        </div>
        <div class="row">
            <div class="small-3 columns">
                <label for="username"
                       class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Username:</label>
            </div>
            <div class="small-9 columns">
                <input type="text" name="username" placeholder="Username" id="username" required
                       class="<?= $errors ? ' is-invalid-input' : '' ?>">
                <span class="form-error">I'm required!</span>
            </div>
        </div>
        <div class="row">
            <div class="small-3 columns">
                <label for="password"
                       class="text-right middle<?= $errors ? ' is-invalid-label' : '' ?>">Password:</label>
            </div>
            <div class="small-9 columns">
                <input type="password" name="password" placeholder="Password" id="password" required
                       class="<?= $errors ? ' is-invalid-input' : '' ?>">
                <span class="form-error">I'm required!</span>
            </div>
        </div>
        <div class="row">
            <div class="small-offset-3 small-9 column">
                <button type="submit" class="button">Login</button>
            </div>
        </div>
    </form>
</section>