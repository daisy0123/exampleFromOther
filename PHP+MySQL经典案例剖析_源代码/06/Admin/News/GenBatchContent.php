<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$classid = 0;
if($_POST[��classid��])													//�ж��Ƿ���ָ����Ŀ
	$classid = $_POST[��classid��];
$NewsCount = $News->GetNewsCount($classid);							//��ȡˢ�µ���Ϣ����
$start = 0;															//��ʼλ��
$end = 1;															//����λ��
$html = file_get_contents("Pub.php");									//ָ��ˢ���ļ�
$html = str_replace("[u]","DealContent.php?n=$NewsCount&start=$start&end=$end&classid=$classid&MenuId={$_GET['MenuId']}",$html);
echo $html;														//��ʾҳ��
?>
