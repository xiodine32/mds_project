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
<p class="text-center">
    <a href="?create=true" class="button success">Create</a>
</p>
<div class="row medium-up-2">
    <?php foreach ($viewbag['views'] as $item): /**@var SmartModel $item */
        $index = $item->getPrimaryKey() ?>
        <div class="column">
            <div class="callout">
                <pre><?= $item ?></pre>
                <div class="button-group expanded small">
                    <a href="?delete=<?= $index ?>" class="button alert" onclick="return confirm('Are you sure?');">
                        Delete
                    </a>
                    <a href="?edit=<?= $index ?>" class="button">Edit</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
