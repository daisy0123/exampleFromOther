<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$classid = 0;
if($_POST[‘classid’])													//判断是否是指定栏目
	$classid = $_POST[‘classid’];
$NewsCount = $News->GetNewsCount($classid);							//获取刷新的信息条数
$start = 0;															//开始位置
$end = 1;															//结束位置
$html = file_get_contents("Pub.php");									//指定刷新文件
$html = str_replace("[u]","DealContent.php?n=$NewsCount&start=$start&end=$end&classid=$classid&MenuId={$_GET['MenuId']}",$html);
echo $html;														//显示页面
?>
