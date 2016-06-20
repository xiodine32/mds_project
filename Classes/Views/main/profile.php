<?php
/**
 * Created at: 01/04/16 15:23
 */
if (!isset($viewbag)) die();
/**
 * @var \Models\ModelEmployee $user
 */
$user = $viewbag['employee'];
?>
<h1 class="text-center"><?= $user->lastName . " " . $user->middleInitial . ". " . $user->firstName ?></h1>
<hr>
<dl class="presentator">
    <dt>First Name</dt>
    <dd><?= $user->firstName ?></dd>
    <dt>Middle Initial</dt>
    <dd><?= $user->middleInitial ?></dd>
    <dt>Last Name</dt>
    <dd><?= $user->lastName ?></dd>
    <dt>Title</dt>
    <dd><?= $user->title ?></dd>
    <dt>CNP</dt>
    <dd><?= $user->cnp ?></dd>
    <dt>Salary</dt>
    <dd><?= $user->salary ?></dd>
    <?php if ($user->administrator): ?>
        <dt>Prior Salary</dt>
        <dd><?= $user->priorSalary ?></dd>
    <?php endif ?>
    <dt>Hire Date</dt>
    <dd><?= $user->hireDate ?></dd>
    <?php if ($user->administrator && !empty($user->terminationDate)): ?>
        <dt>Termination Date</dt>
        <dd><?= $user->terminationDate ?></dd>
    <?php endif ?>
    <?php if (!empty($user->managerID)): ?>
        <dt>Manager</dt>
        <dd><?= $user->manager->firstName . " " . $user->manager->lastName ?></dd>
    <?php endif ?>
    <?php if (!empty($user->departmentID)): ?>
        <dt>Department</dt>
        <dd><?= $user->department->title ?></dd>
    <?php endif ?>
    <?php if (!empty($user->roleID)): ?>
        <dt>Role</dt>
        <dd><?= $user->role->name ?></dd>
    <?php endif ?>
</dl>

