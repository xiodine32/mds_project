<?php
/**
 * Created at: 20/04/16 11:31
 */
/**
 * @var $this \View
 * @var $viewbag array
 */
if (!isset($viewbag) || !isset($this)) die();
?>
<div class="row medium-up-2">
    <?php foreach ($viewbag['views'] as $item): ?>
        <div class="column">
            <pre><?= $item ?></pre>
    </div>
    <?php endforeach; ?>
</div>
