<?php require_once('config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$ClassInfo = $Data->getInfo($_GET['ClassId'],"EM_CLASS_INFO");
$DataInfo = $Data->getInfo($_GET['Id'],"EE_DATABASE_INFO");
$List = $Data->GetObjListAll($_GET['Id']);
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	$Result = array();
	$sum = 0;
	foreach($_POST['id'] as $objid)									//ѭ����������
	{
		$info = $Data->getInfo($objid,"EE_OBJECTIVE_INFO");
		switch($Data->CheckIsRight($objid,$_POST['f_' . $objid]))		//�ж����Ľ��
		{
			case 0:											//0Ϊû������
				$Result[$objid]['Result'] = "<font color=red>��δѡ����⣡</font>";
				break;
			case 1:											//1Ϊ���
				$Result[$objid]['Result'] = "<font color=red>������ˣ�</font>";
				$sum = $sum + $info[F_OBJECTIVE_SCORE];
				break;
			case 2:											//2Ϊ���
				$Result[$objid]['Result'] = "<font color=red>������ˣ�</font>";
				break;		
		}
	}
	$is_submit = true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>����ϵͳ</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
</head>

<body>
<form name=form1 action="ObjList.php?ClassId=<?php echo $_GET['ClassId']?>&Id=<?php echo $_GET['Id']?>&Action=Result" method=post>
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="28" background="1Up.gif" style="padding-left:25px;">
<?php echo $ClassInfo[F_CLASS_NAME]?> - <?php echo $DataInfo[F_DATABASE_NAME]?> - �͹���</td>
</tr>
<?php
if($List)														//�ж��Ƿ���������Ϣ
{
foreach($List as $key => $value)									//ѭ����ʾ������Ϣ
{
$i = $key + 1;
$ItemList = $Data->GetItemList($value[F_ID]);
?>
<tr>
<td style="padding-left:20px; padding-right:20px;"><table width="100%" border="0">
<tr>
<td>
<?php echo $i?>.<?php echo $value[F_OBJECTIVE_NAME]?>
<input name="id[]" type="hidden" id="id[]" value="<?php echo $value[F_ID]?>" />
(<?php echo $value[F_OBJECTIVE_SCORE]?>��)
</td>
</tr>
<tr>
<td>
<?php
if($ItemList)													//�ж��Ƿ���ѡ����Ϣ
{
foreach($ItemList as $val)											//ѭ����ʾѡ��
{
if($value[F_OBJECTIVE_TYPE] == 1)								//�ж��Ƿ��ǵ�ѡ
{
?>
<input type="radio" name="f_<?php echo $value[F_ID]?>" value="<?php echo $val[F_ID]?>" />
<?php
}else{
?>
<input type="checkbox" name="f_<?php echo $value[F_ID]?>[]" value="<?php echo $val[F_ID]?>" />
<?php
}
echo $val[F_ITEM_NAME];
}
}
?></td>
</tr>
<tr>
  <td>
<?php
if($_GET['Action'] == 'Result')										//�ж��Ƿ��ǲ鿴��,��ʾ��
{
	echo "��ȷ��:" . $Data->GetRight($value[F_ID]) . "<br>";
	if($is_submit)												//�ж��Ƿ��ύ����,��ʾ���Ľ��
	{
		echo $Result[$value[F_ID]]['Result'];
	}
}
?>
</td>
</tr>
<?php
}
}
?>
</table>
<table width="100%" border="0">
<tr>
<td>
<?php
if($_GET['Action'] == 'Result' and $is_submit)							//�ж��Ƿ��ύ����,��ʾ�ܵ÷�
{
	echo "�����ܵ÷�Ϊ��$sum ��";
}
?>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table width="550" border="0" align="center">
<tr>
<td align="center">
<input type="submit" name="Submit" value="�ύ����" /> 
<input type="button" name="Submit2" value="�鿴��" onclick="window.location='ObjList.php?ClassId=<?php echo $_GET['ClassId']?>&Id=<?php echo $_GET['Id']?>&Action=Result'" />
<input type="button" name="Submit3" value="����������" onclick="window.location='SubList.php?ClassId=<?php echo $_GET['ClassId']?>&Id=<?php echo $_GET['Id']?>'" />
</td>
</tr>
</table>
</form>
</body>
</html>