<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$News->GenList($_GET['ClassId']);									//生成栏目首页
?>
生成成功
<input type="button" name="Submit" value="返回上一页" onClick="window.history.back();'">
