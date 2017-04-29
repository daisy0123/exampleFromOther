<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$News->DelComments($_GET['id']);
header("Location:CommentsList.php?MenuId={$_GET['MenuId']}");
?>
