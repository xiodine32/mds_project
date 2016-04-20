<?php
/**
 * Created at: 20/04/16 11:32
 */
/**
 * @var $this \View
 */
if (!isset($viewbag) || !isset($this)) die();


?>
<div class="row">
    <div class="large-12 column">

        <h1 class="text-center">Models</h1>
        <hr>

        <div class="row small-up-4">
            <?php foreach ($viewbag['models'] as $model): ?>
                <div class="column text-center">
                    <a href="<?= $viewbag['root'] ?>main/models/<?= strtolower($model[0]) . substr($model, 1) ?>"
                       class="button large secondary">
                        <?= $model ?>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
