<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	foreach($_POST['id'] as $key => $value)							//ѭ������ѡ��˳��
	{
		$data = array();
		$data[F_ITEM_ORDER] = $_POST['order'][$key];
		$Data->updateData("EE_OBJECTIVE_ITEM",$value,$data);
	}
}
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
<td class=caption>�� �� �� �� �� ˳ ��</td>
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
<th width=121>˳��</th>
</tr>
<?php
if($List)														//�ж��Ƿ���ѡ��
{
foreach($List as $value)											//ѭ����ʾѡ��
{
?>
<tr bgColor=#ffffff>
<td><?php echo $value[F_ITEM_NAME]?>
  <input name="id[]" type="hidden" id="id[]" value="<?php echo $value[F_ID]?>"></td>
<td align=middle>
<?php
if($value[F_ITEM_IS_RIGHT])										//�ж��Ƿ�����ȷ��
	echo "��";
else
	echo "��";
?>
</td>
<td align=middle>
<input name="order[]" type="text" id="order[]" size="10" value="<?php echo $value[F_ITEM_ORDER]?>">
</td>
</tr>
<?php
}
}
?>
</table></td>
</tr>
<tr>
<th><input id=cmdAdd type=submit value=" �� �� �� �� " name=cmdDel>
  <input type="button" name="Submit" value=" �� �� �� �� " onClick="javascript:window.location='ItemList.php?DataId=<?php echo $dataid?>&Id=<?php echo $id?>'"></th>
</tr></table>
</form>
</body>
</html>