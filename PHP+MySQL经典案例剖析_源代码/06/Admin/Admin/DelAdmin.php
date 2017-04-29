<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php
$user = new User();
$user->delData($_GET['Id'],"EM_ADMIN_INFO");
echo "删除成功<br>";
echo "<br><a href='AdminList.php'>返回管理员列表</a>";
?>
