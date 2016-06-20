<?php
/**
 * Created at: 01/04/16 16:57
 */
if (!isset($viewbag)) die();
/**
 * @var \View $this
 */
/**
 * @var \Models\ModelEmployee $user
 */
$user = $viewbag['employee'];
if (empty($viewbag['tasks']))
    $viewbag['tasks'] = [];
?>
<?php if ($user->administrator):

    $projects = [];
    foreach ($viewbag['projects'] as $project) {
        $projects[$project->projectID] = $project->title;
    }
    $employees = [];
    foreach ($viewbag['employees'] as $employee) {
        $employees[$employee->employeeID] = $employee->firstName . " " . $employee->lastName;
    }

    $fg = new FormGenerator($this);
    $fg->error = isset($viewbag['error']);
    $fg->errorMessage = $fg->error ? $viewbag['error'] : "There are some errors in your form.";
    $fg->success = isset($viewbag['success']);
    $fg->successMessage = isset($viewbag['success']) ? $viewbag['success'] : "";
    $fg->action = $viewbag['root'] . "main/tasks";
    $fg->title = "Add New Task";
    $fg->formID = "addTask";
    $fg->ajax = $viewbag['partial'];
    $fg->show = $viewbag['employee']->administrator;

    $fg->addInput("text", "taskDescription", "taskDescription", "Task Description", "Required!", true);
    $fg->addInput("number", "taskDifficulty", "difficulty", "Difficulty", "Required!", "number", [
        "attributes" => "min='1' max='10'"
    ]);
    $fg->addInput("number", "taskEstimation", "estimation", "Estimation", "Required!", "number");
    $fg->addInput("select", "taskEmployee", "employeeID", "Employee", "Invalid!", false, [
        "options" => $employees
    ]);
    $fg->addInput("select", "taskProject", "projectID", "Project", "Invalid!", false, [
        "options" => $projects
    ]);
    $fg->addInput("date", "taskStartDate", "startDate", "Start Date", "Invalid!", false);
    $fg->addInput("date", "taskEndDate", "endDate", "End Date", "Invalid!", false);
    $fg->addSubmit("button", "Add Task");

    ?>
    <?= $fg->generate() ?>
    <!--    <section>-->
    <!--        <h1 class="text-center">Add New Task</h1>-->
    <!--        <form action="--><? //= $viewbag['root'] 
    ?><!--main/tasks" method="post" class="callout">-->
    <!--            <div class="row">-->
    <!--                <div class="small-3 columns"><label for="task" class="text-right middle">Task</label></div>-->
    <!--                <div class="small-9 columns"><input type="text" id="task" name="task"></div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="small-3 columns"><label for="difficulty" class="text-right middle">Difficulty</label></div>-->
    <!--                <div class="small-9 columns"><input type="number" id="difficulty" name="difficulty" min="1" max="10"-->
    <!--                                                    value="5"></div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="small-3 columns"><label for="taskProject" class="text-right middle">Project: </label></div>-->
    <!--                <div class="small-9 columns">-->
    <!--                    <select name="taskProject" id="taskProject">-->
    <!--                        <option value="">--- NONE ---</option>-->
    <!--                        --><?php //foreach ($projects as $key => $value): 
    ?>
    <!--                            <option value="--><? //= $key
    ?><!--">--><? //= $value
    ?><!--</option>-->
    <!--                        --><?php //endforeach 
    ?>
    <!--                    </select>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="small-3 columns"><label for="taskEmployee" class="text-right middle">Employee: </label></div>-->
    <!--                <div class="small-9 columns">-->
    <!--                    <select name="taskEmployee" id="taskEmployee">-->
    <!--                        <option value="">--- NONE ---</option>-->
    <!--                        --><?php //foreach ($employees as $key => $value): 
    ?>
    <!--                            <option value="--><? //= $key
    ?><!--">--><? //= $value
    ?><!--</option>-->
    <!--                        --><?php //endforeach 
    ?>
    <!--                    </select>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="small-3 columns"><label for="submit" class="text-right middle">Submit</label></div>-->
    <!--                <div class="small-9 columns text-left">-->
    <!--                    <button type="submit" id="submit" class="button success">Add Task</button>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </form>-->
    <!--    </section>-->
    <section>
        <h1 class="text-center">View All Tasks</h1>
        <hr>
        <div class="row">
            <?php $i = 0;
            $n = count($viewbag['tasks']);
            foreach ($viewbag['tasks'] as $item):$i++;
                /**
                 * @var $item \Models\Generated\ModelTask
                 */
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
                                <form action="<?= $viewbag['root'] . "main/tasks" ?>" method="post" id="formEstimation">
                                    <p>Estimation: <span style="float:right;"
                                                         class="label secondary"><?= $item->estimation ?></span></p>
                                    <div class="text-center">
                                        <button class="button small" id="updatebutton"
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
                                <div style="float: right;">End: <span class="label alert"><?= $item->endDate ?></span>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </section>
<?php endif ?>
<section>
    <h1 class="text-center">Your Tasks</h1>
    <hr>
    <div class="row">
        <?php $i = 0;
        $n = count($viewbag['user_tasks']);
        foreach ($viewbag['user_tasks'] as $item): $i++; ?>
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
                            <form action="<?= $viewbag['root'] . "main/tasks" ?>" method="post" id="formEstimation">
                                <p>Estimation: <span style="float:right;"
                                                     class="label secondary"><?= $item->estimation ?></span></p>
                                <div class="text-center">
                                    <button class="button small" id="updatebutton"
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
        <?php endforeach ?>
    </div>
</section>
<?php $this->includeInlineBegin() ?>
    <script>
        $("#updatebutton").one("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            var $f = $("#formEstimation");
            var $find = $f.find(".label.secondary");
            $find.remove();
            $f.find("p").after("<input type='number' value='" + $find.html() + "' min='0' name='updateTask'>");
        });
    </script>
<?php $this->includeJSInlineEnd() ?>