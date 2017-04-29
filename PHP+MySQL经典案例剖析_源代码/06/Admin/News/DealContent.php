<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$classid = 0;
$start = $_GET['start'];
$end = $_GET['end'];
$n = $_GET['n'];
if($_GET['classid']) $classid = $_GET['classid'];
$array = array();
$News->GenContent($array,1,$classid,$start,$end);
$start++;
$end++;
$n--;
if($n > 0)															//判断是否已刷新完
{
	$str = "信息页面刷新正在进行中...";
	echo "$n"."<meta http-equiv='refresh' content='0;url=DealContent.php?n=$n&start=$start&end=$end&class_id=$classid&MenuId={$_GET['MenuId']}'><body leftmargin='0' rightmargin='0' topmargin='0' bottommargin='0' bgcolor='#D6D3CE' style='font-size:12px'>$str";											//输出刷新剩余页面
}else{
	$str = "<body leftmargin='0' rightmargin='0' topmargin='0' bottommargin='0' bgcolor='#D6D3CE' style='font-size:12px'>所有信息页面刷新完成";								//输出已刷新完成
	echo "$str";
}
?>
</body>
