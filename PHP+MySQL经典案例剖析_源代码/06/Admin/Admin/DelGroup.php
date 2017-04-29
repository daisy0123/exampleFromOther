<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php
$User = new User();
$User->DelGroup($_GET['Id']);
echo "删除成功<br>";
echo "<a href='GroupList.php?MenuId={$_GET['MenuId']}'>返回列表</a>";
?>
