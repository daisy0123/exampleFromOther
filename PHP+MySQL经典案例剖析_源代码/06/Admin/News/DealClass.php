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
if($n > 0)															//�ж��Ƿ���ˢ����
{
	$str = "��Ŀҳ��ˢ�����ڽ�����...";									//���ˢ��ʣ��ҳ��
	echo "$n"."<meta http-equiv='refresh' content='0;url=DealClass.php?n=$n&start=$start&end=$end&MenuId={$_GET['MenuId']}'><body leftmargin='0' rightmargin='0' topmargin='0' bottommargin='0' bgcolor='#D6D3CE' style='font-size:12px'>$str";
}else{															//�����ˢ�����
	$str = "<body leftmargin='0' rightmargin='0' topmargin='0' bottommargin='0' bgcolor='#D6D3CE' style='font-size:12px'>������Ŀҳ��ˢ�����";
	echo "$str";
}
?>
</body>
