<?php require_once('config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
if($_GET['Page'])												//�ж��Ƿ���ҳ��
	$page = $_GET['Page'];
else
	$page = 1;
$id = $_GET['Id'];
$List = $Data->GetDataList($id,$page);
$Count = $Data->GetDataCount($id);
$Pagecount = ceil($Count / $Data->pagesize);
if(!$Pagecount) $Pagecount = 1;									//�ж��Ƿ���ҳ��
$Info = $Data->getInfo($id,"EM_CLASS_INFO");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>����ϵͳ</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
</head>

<body>
<table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="28" background="1.gif" style="padding-left:25px;">
<?php echo $Info[F_CLASS_NAME]?> - ����б�
</td>
</tr>
<tr>
<td style="padding-left:20px; padding-right:20px;">
<table width="100%" border="0">
<?php
if($List)														//�ж��Ƿ��������Ϣ
{
foreach($List as $value)											//ѭ����ʾ�����Ϣ
{
?>
<tr>
<td height="28" style="border-bottom:1px dotted #000000;">
��<a href="ObjList.php?ClassId=<?php echo $id?>&Id=<?php echo $value[F_ID]?>"><?php echo $value[F_DATABASE_NAME]?></a>[<?php echo date("Y-m-d",$value[F_DATABASE_TIME]);?>]</td>
</tr>
<?php
}
}
?>
</table></td>
</tr>
</table>
<table width="550" border="0" align="center">
<tr>
<td>
�������<?php echo $Count?>�� 
��<?php echo $page?>/<?php echo $Pagecount?> 
ÿҳ<?php echo $Data->pagesize?></td>
<td align="right">ת����
<select name="select" onchange="javascript:location.href='?Id=<?php echo $id?>Page='+this.options[selectedIndex].value;">
<?php
for($i = 1;$i <= $Pagecount;$i++)									//ѭ����ʾ��ҳ������
{
	echo "<option value='$i'";
	if($i == $page)
		echo " selected";
	echo ">$i</option>";
}
?>
</select>
ҳ</td>
</tr>
</table>
</body>
</html>