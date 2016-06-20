<?php
/**
 * Created at: 01/04/16 15:23
 */
/**
 * @var $this \View
 */
if (!isset($viewbag)) die();
/**
 * @var \Models\ModelEmployee $user
 */
$user = $viewbag['employee'];
?>
    <h1 class="text-center">Calendar - Weeks</h1>
    <hr>
    <div id="hidden-div" data-toggler=".visible">
        <?php for ($i = 1; $i < date("W"); $i++): ?>
            <?php showItem($i); ?>
        <?php endfor ?>
    </div>
    <div class="text-center" style="clear:both;margin-bottom: 1rem;">
        <a href="#" onclick="return false;" data-toggle="hidden-div">Toggle hidden</a>
    </div>
<?php for ($i = date("W"); $i <= 52; $i++): ?>
    <?php showItem($i); ?>
<?php endfor ?>
<?php $this->includeJS("main/tasks.js") ?>
<?php

function showItem($weekDate)
{
    $today = date("W");
    $callout = 'smart callout';
    if ($weekDate == $today)
        $callout .= ' success';
    elseif ($weekDate > $today)
        $callout .= ' secondary';
    else
        $callout .= ' warning';
    $days = [
        date("l", mktime(0, 0, 0, 1, 1, 1990)),
        date("l", mktime(0, 0, 0, 1, 2, 1990)),
        date("l", mktime(0, 0, 0, 1, 3, 1990)),
        date("l", mktime(0, 0, 0, 1, 4, 1990)),
        date("l", mktime(0, 0, 0, 1, 5, 1990)),
        "<small>" . date("l", mktime(0, 0, 0, 1, 6, 1990)) . "</small>",
        "<small>" . date("l", mktime(0, 0, 0, 1, 7, 1990)) . "</small>",
    ];
    ?>
    <div class="row text-center" style="position: relative;">
        <?php for ($day = 1; $day <= 7; $day++):
            $column = "small-2";
            if (strpos($days[$day - 1], "<small>") !== false)
                $column = "small-1";
            ?>
            <a href="calendar/view?week=<?= $weekDate ?>&day=<?= $day ?>">
                <div class="<?= $callout ?> columns <?= $column ?>" data-equal-size>
                    <?= $days[$day - 1] ?>
                    <br>
                    <span style="font-size:0.6em">
                        <?= date("Y-m-d", strtotime("2016-W" . $weekDate . "-" . $day)); ?>
                    </span>
                </div>
            </a>
        <?php endfor ?>
        <div class="label label-bottom"><?= $weekDate ?></div>
    </div>
    <?php
}