<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$arr = array();
if($_POST[del_id])
	$arr = $_POST[del_id];
$News->GenContent($_POST[del_id],0,0,0,0);
?>
���ɳɹ�
<br>
<input type="button" name="Submit" value="���������б�" onClick="window.location = 'NewsList.php?id=<?php echo $_GET['ClassId']?>&MenuId=<?php echo $_GET['MenuId']?>'">
<input type="button" name="Submit2" value="������������" onClick="window.location = 'NewsAdd.php?ClassId=<?php echo $_GET['ClassId']?>&MenuId=<?php echo $_GET['MenuId']?>'">
