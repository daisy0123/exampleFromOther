<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$News->GenList($_GET['ClassId']);									//������Ŀ��ҳ
?>
���ɳɹ�
<input type="button" name="Submit" value="������һҳ" onClick="window.history.back();'">
