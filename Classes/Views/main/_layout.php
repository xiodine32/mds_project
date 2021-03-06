<?php
/**
 * Created at: 29/03/16 14:31
 */

/**
 * @var $this \View
 */
if (!isset($viewbag) || !isset($this)) die();
/**@var \Models\ModelEmployee $user */
$user = $viewbag['employee'];
?>

    <div class="top-bar">

        <div class="top-bar-title">

            <a href="<?= $viewbag['root'] ?>main/">
                <strong>Home</strong>
            </a>

        <span class="menu-hamburger show-for-small-only" data-responsive-toggle="responsive-menu"
              data-hide-for="medium">
            <span class="menu-text" data-toggle>Menu</span>
            <span class="menu-icon" data-toggle></span>
        </span>

        </div>

        <div id="responsive-menu">
            <div class="top-bar-left">
                <ul class="menu" data-responsive-menu="drilldown medium-dropdown">
                    <li><a href="<?= $viewbag['root'] ?>main/calendar">Calendar</a></li>
                    <li><a href="<?= $viewbag['root'] ?>main/projects">Projects</a></li>
                    <li><a href="<?= $viewbag['root'] ?>main/tasks">Tasks</a></li>
                    <?php if ($user->administrator): ?>
                        <li><a href="<?= $viewbag['root'] ?>main/employees">Employees</a></li>
                        <li><a href="<?= $viewbag['root'] ?>main/departments">Departments</a></li>
                        <li><a href="<?= $viewbag['root'] ?>main/models/">Database</a></li>
                    <?php endif ?>
                </ul>
            </div>
            <div class="top-bar-right">
                <ul class="menu" data-responsive-menu="drilldown medium-dropdown">
                    <li><span>Welcome, <a href="<?= $viewbag['root'] ?>main/profile"><?= $user->firstName ?></a> </span>&nbsp;
                    </li>
                    <li class="active"><a href="<?= $viewbag['root'] ?>main/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
<?php $this->includeJS(["app.js"], true, true) ?>
<?php $this->continueRun(); ?>