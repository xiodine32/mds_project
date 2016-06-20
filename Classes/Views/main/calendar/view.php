<?php
/**
 * Created by PhpStorm.
 * User: Xiodine
 * Date: 20/06/2016
 * Time: 16:58
 */
/**
 * @var $this \View
 */
if (!isset($viewbag) || !isset($this)) die();
?>
    <div class="row">
        <div class="large-12 columns text-center">
            <h1><?= $this->viewbag['day'] ?></h1>
            <hr>
            <div class="row text-left">
                <?php $i = 0;
                $n = count($viewbag['tasks']);
                foreach ($viewbag['tasks'] as $item): $i++; ?>
                    <?php require __DIR__ . "/../_task.php"; ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
<?php $this->includeInlineBegin() ?>
    <script>
        $(".updatebutton").one("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            var $f = $(this);
            while (!$f.hasClass("formEstimation"))
                $f = $f.parent();
            var $find = $f.find(".label.secondary");
            $find.remove();
            $f.find("p").after("<input type='number' value='" + $find.html() + "' min='0' name='updateTask'>");
        });
    </script>
<?php $this->includeJSInlineEnd() ?>