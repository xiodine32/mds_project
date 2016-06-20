<?php
/**
 * Created at: 29/03/16 13:45
 */
if (!isset($viewbag)) die();
?>
<h1 class="text-center">Resource Allocation Tool</h1>
<hr>
<div class="row">
    <div class="small-6 columns">
        <a href="<?= $viewbag['root'] ?>main/calendar#week">
            <div class="callout text-center">
                <p>Current week: <?= date("W") ?></p>
            </div>
        </a>
    </div>
    <div class="small-6 columns">
        <a href="<?= $viewbag['root'] ?>main/calendar/view?week=<?= date("W") ?>&day=<?= date("N") ?>">
            <div class="callout text-center">
                <p>Today tasks: <?= $viewbag['todayTasks'] ?></p>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="small-6 columns">
        <a href="<?= $viewbag['root'] ?>main/tasks">
            <div class="callout text-center">
                <p>Your tasks: <?= $viewbag['tasks'] ?></p>
            </div>
        </a>
    </div>
    <div class="small-6 columns">
        <a href="<?= $viewbag['root'] ?>main/profile">
            <div class="callout text-center">
                <p>Your Profile</p>
            </div>
        </a>

    </div>
</div>