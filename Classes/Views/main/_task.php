<?php
/**
 * Created by PhpStorm.
 * User: Xiodine
 * Date: 20/06/2016
 * Time: 17:56
 * @var $item \Models\Generated\ModelTask
 */
if (empty($viewbag)) die('no viewbag');
if (empty($item)) die("no task");
if (!isset($i) || !isset($n)) die("no loop");
$taskEstimateClass = "secondary";
$taskEstimation = $item->estimation;
if ($item->estimation == 0) {
    $taskEstimateClass = "success";
    $taskEstimation = "done";
}
if ($viewbag['employee']->administrator || $item->employeeID == $viewbag['employee']->employeeID) {
?>
    <div class="small-6 <?= ($i % 2 == 1) && $i == $n ? "small-centered" : "columns" ?>">
        <div class="callout">
            <ul style="list-style-type: none;margin-left: 0;">
                <li>
                                <span
                                    style="float:right;"><?= $item->employee->firstName . " " . $item->employee->lastName ?></span>
                    <p><strong><?= $item->taskDescription ?></strong></p>
                </li>
                <li>
                    <p>
                        Project:
                        <span style="float: right;"><?= $item->project->title ?></span>
                    </p>
                </li>
                <li>
                    <p>Difficulty: <span style="float: right;"
                                         class="label secondary"><?= $item->difficulty ?></span></p>
                </li>
                <li>
                    <form action="<?= $viewbag['root'] . "main/tasks" ?>" method="post" class="formEstimation">
                        <p>Estimation: <span style="float:right;"
                                             class="label <?= $taskEstimateClass ?>"><?= $taskEstimation ?></span></p>
                        <div class="text-center">
                            <button class="button small updatebutton"
                                    name="updateTaskID" value="<?= $item->taskID ?>"
                                    type="submit">Update
                            </button>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </li>
                <li>
                    Start:
                    <span class="label secondary"><?= $item->startDate ?></span>
                    <div style="float: right;">End: <span class="label alert"><?= $item->endDate ?></span></div>
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
    </div>
<?php } ?>
