<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$News->GenIndex();
?>
<input type="button" name="Submit" value="·µ»ØÊ×Ò³ÉèÖÃ" onClick="window.location = 'Index.php?MenuId=<?php echo $_GET['MenuId']?>'">
