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
if($n > 0)															//�ж��Ƿ���ˢ����
{
	$str = "��Ϣҳ��ˢ�����ڽ�����...";
	echo "$n"."<meta http-equiv='refresh' content='0;url=DealContent.php?n=$n&start=$start&end=$end&class_id=$classid&MenuId={$_GET['MenuId']}'><body leftmargin='0' rightmargin='0' topmargin='0' bottommargin='0' bgcolor='#D6D3CE' style='font-size:12px'>$str";											//���ˢ��ʣ��ҳ��
}else{
	$str = "<body leftmargin='0' rightmargin='0' topmargin='0' bottommargin='0' bgcolor='#D6D3CE' style='font-size:12px'>������Ϣҳ��ˢ�����";								//�����ˢ�����
	echo "$str";
}
?>
</body>
