<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$News->DelPic($_GET['id']);
header("Location:PicList.php?id={$_GET['NewsId']}&MenuId={$_GET['MenuId']}");
?>
