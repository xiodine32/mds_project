<?php
/**
 * Created at: 01/04/16 16:57
 */
if (!isset($viewbag)) die();
/**
 * @var \Models\ModelEmployee $user
 */
$user = $viewbag['employee'];
if (empty($viewbag['tasks']))
    $viewbag['tasks'] = [];
?>
<section>
    <h1 class="text-center">Add New Task</h1>
    <form action="<?= $viewbag['root'] ?>main/tasks" method="post" class="callout">
        <div class="row">
            <div class="small-3 columns"><label for="task" class="text-right middle">Task</label></div>
            <div class="small-9 columns"><input type="text" id="task" name="task"></div>
        </div>
        <div class="row">
            <div class="small-3 columns"><label for="difficulty" class="text-right middle">Difficulty</label></div>
            <div class="small-9 columns"><input type="number" id="difficulty" name="difficulty" min="1" max="10"
                                                value="5"></div>
        </div>
        <div class="row">
            <div class="small-3 columns"><label for="submit" class="text-right middle">Submit</label></div>
            <div class="small-9 columns text-left">
                <button type="submit" id="submit" class="button success">Add Task</button>
            </div>
        </div>
    </form>
</section>
<section>
    <h1 class="text-center">View All Tasks</h1>
    <?php foreach ($viewbag['tasks'] as $item): ?>
        <div class="callout">
            <pre><?= $item ?></pre>
        </div>
    <?php endforeach ?>
</section>
