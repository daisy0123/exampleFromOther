<?php require_once('../../config.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'db.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=gb2312">
<style type="text/css">body {font-size:	9pt}</style>
</head>
<BODY bgcolor="#FFFFFF" MONOSPACE>
<?php
/*'==============================
'需要传递的参数：             =
' 1、action  动作  修改时用   =
' 2、ID 被修改的ID号          =
'=============================*/
if ($_GET['action'] == "edit"){
	$News = new News();
	$Info = $News->getInfo($_GET['newsid'],"EE_NEWS_DETAIL");
	$content = $Info[F_NDT_CONTENT];
	echo $content;
}
?>
</body>
</html>
