<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Class.inc.php'); ?>
<?php
$Class = new ClassModel();
$Class->DelClass($_GET['Id']);
header("Location:ClassList.php");
exit();
?>