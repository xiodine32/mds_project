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
    <div class="text-center" style="margin-bottom: 1rem;">
        <a href="#" onclick="return false;" data-toggle="hidden-div">Toggle hidden</a>
    </div>
<?php for ($i = date("W"); $i <= 52; $i++): ?>
    <?php showItem($i); ?>
<?php endfor ?>
<?= $this->includeJS("main/tasks.js") ?>
<?php

function showItem($weekDate)
{
    $today = date("W");
    $callout = 'callout';
    if ($weekDate == $today)
        $callout .= ' success';
    elseif ($weekDate > $today)
        $callout .= ' secondary';
    else
        $callout .= ' warning';
    ?>
    <div class="<?= $callout ?> row" style="position: relative;">
        <div class="columns small-2" data-equal-size>Luni</div>
        <div class="columns small-2" data-equal-size>Marti</div>
        <div class="columns small-2" data-equal-size>Miercuri</div>
        <div class="columns small-2" data-equal-size>Joi</div>
        <div class="columns small-2" data-equal-size>Vineri</div>
        <div class="columns small-1" data-equal-size>
            <small>Sambata</small>
        </div>
        <div class="columns small-1" data-equal-size>
            <small>Duminica</small>
        </div>
        <div class="label label-bottom"><?= $weekDate ?></div>
    </div>
    <?php
}