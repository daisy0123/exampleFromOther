<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$dataid = $_GET['DataId'];
$id = $_GET['Id'];
$info = $Data->getInfo($id,"EE_OBJECTIVE_INFO");
$List = $Data->GetItemList($id);
?>
<html>
<head>
<title>����ϵͳ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form name=form1 action="" method=post>
<table cellSpacing=0 width="60%" align=center border=0>
<tr>
<td class=caption>�� �� �� ѡ �� �� ��</td>
</tr>
<tr>
<td>�͹�����⣺<?php echo $info[F_OBJECTIVE_NAME]?></td>
</tr>
<tr>
<td>
<table width="100%" border=0>
<tr>
<th width=256>����</th>
<th width=118>�Ƿ�����ȷ��</th>
<th width=121>����</th>
</tr>
<?php
if($List)														//�ж��Ƿ���ѡ����Ϣ
{
foreach($List as $value)											//ѭ����ʾѡ����Ϣ
{
?>
<tr bgColor=#ffffff>
<td><?php echo $value[F_ITEM_NAME]?></td>
<td align=middle>
<?php
if($value[F_ITEM_IS_RIGHT])										//�ж��Ƿ�����ȷ��
	echo "��";
else
	echo "��";
?>
</td>
<td align=middle>
<a href="ItemAdd.php?DataId=<?php echo $dataid?>&ObjId=<?php echo $id?>&Id=<?php echo $value[F_ID]?>">[�༭]</a> 
<a href="DelItem.php?DataId=<?php echo $dataid?>&ObjId=<?php echo $id?>&Id=<?php echo $value[F_ID]?>">[ɾ��]</a></td>
</tr>
<?php
}
}
?>
</table></td>
</tr>
<tr>
<th>
<input id=cmdAdd type=button value=" �� �� ѡ �� " name=cmdDel onClick="javascript:window.location='ItemAdd.php?DataId=<?php echo $dataid?>&ObjId=<?php echo $id?>'">
<input type="button" name="Submit2" value=" ����ѡ��˳�� " onClick="javascript:window.location='ItemOrder.php?DataId=<?php echo $dataid?>&Id=<?php echo $id?>'" />
<input type="button" name="Submit" value=" �� �� �� �� " onClick="javascript:window.location='ObjList.php?Id=<?php echo $dataid?>'"></th>
</tr></table>
</form>
</body>
</html>