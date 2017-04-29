<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$start = $_GET['start'];
$end = $_GET['end'];
$n = $_GET['n'];
$News->GenList(0,1,$start,$end);
$start++;
$end++;
$n--;
if($n > 0)															//判断是否已刷新完
{
	$str = "栏目页面刷新正在进行中...";									//输出刷新剩余页面
	echo "$n"."<meta http-equiv='refresh' content='0;url=DealClass.php?n=$n&start=$start&end=$end&MenuId={$_GET['MenuId']}'><body leftmargin='0' rightmargin='0' topmargin='0' bottommargin='0' bgcolor='#D6D3CE' style='font-size:12px'>$str";
}else{															//输出已刷新完成
	$str = "<body leftmargin='0' rightmargin='0' topmargin='0' bottommargin='0' bgcolor='#D6D3CE' style='font-size:12px'>所有栏目页面刷新完成";
	echo "$str";
}
?>
</body>
