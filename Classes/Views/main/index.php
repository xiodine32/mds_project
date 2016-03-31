<?php
/**
 * Created at: 29/03/16 13:45
 */
if (!isset($viewbag)) die();
?>
<a href="?logout=true">Logout</a>
<div class="callout secondary">
    <?php echo "<pre>";
    var_dump($viewbag['employee']);
    echo "</pre>"; ?>
</div>