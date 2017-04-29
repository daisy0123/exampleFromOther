<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
header("Content-type:text/xml");
$News = new News();
$News->GenXml($_GET['ClassId']);
?>
<input type="button" name="Submit" value="返回栏目信息页" onClick="window.location = 'ClassInfo.php?id=<?php echo $_GET['ClassId']?>&MenuId=<?php echo $_GET['MenuId']?>'">
