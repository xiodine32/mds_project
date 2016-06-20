<?php
/**
 * Created at: 20/04/16 11:37
 */
/**
 * @var $this \View
 */
if (!isset($viewbag) || !isset($this)) die();
$text = (!isset($viewbag['model']) ? "Table" : $viewbag['model']) . "s";

?>
<div class="row">
    <div class="large-12 column">
        <h1 class="text-center"><?= $text ?></h1>
        <div class="text-center">
            <a href="<?= $viewbag['root'] ?>main/models/" class="button large secondary">Index</a>
        </div>
        <div class="row small-up-4">
            <?php foreach ($viewbag['models'] as $model): ?>
                <div class="column text-center">
                    <a href="<?= $viewbag['root'] ?>main/models/<?= $model ?>"
                       class="button large secondary">
                        <?= ucfirst($model) ?>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
        <hr>
        <?php $this->continueRun(); ?>
    </div>
</div>


