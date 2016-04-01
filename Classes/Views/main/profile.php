<?php
/**
 * Created at: 01/04/16 15:23
 */
if (!isset($viewbag)) die();
/**
 * @var \Models\ModelEmployee $user
 */
$user = $viewbag['employee'];
?>
<h1 class="text-center"><?= $user->lastName . " " . $user->middleInitial . ". " . $user->firstName ?></h1>
<hr>
<?php echo "<pre>";
echo $viewbag['employee'];
echo "</pre>"; ?>

