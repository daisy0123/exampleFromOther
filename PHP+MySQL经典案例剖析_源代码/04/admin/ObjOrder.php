<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$id = $_GET['Id'];
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	foreach($_POST['SelId'] as $key => $del_id)						//ѭ������˳��
	{
		$data = array();
		$data[F_OBJECTIVE_ORDER] = $_POST['order'][$key];
		$Data->updateData("EE_OBJECTIVE_INFO",$del_id,$data);
	}
}
if($_GET['Page'])												//�ж��Ƿ���ҳ��
	$page = $_GET['Page'];
else
	$page = 1;
$List = $Data->GetObjList($id,$page);
$Count = $Data->GetObjCount($id);
$Pagecount = ceil($Count / $Data->pagesize);
if(!$Pagecount) $Pagecount = 1;									//�ж��Ƿ���ҳ��
?>
<html>
<head>
<title>����ϵͳ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form name=form1 action="" method=post>
<table cellSpacing=0 width="95%" align=center border=0>
<tr>
<td class=caption colSpan=2>�� �� �� �� �� ˳ ��</td>
</tr>
<tr>
<td width="80%">��������<?php echo $Count?>�� �� <font color="red"><?php echo $page?></font> / <?php echo $Pagecount?> ҳ ÿҳ <?php echo $Data->pagesize?></td>
<td width="20%" align="right">ת��
<select name="select" onChange="javascript:location.href='?Id=<?php echo $id?>Page='+this.options[selectedIndex].value;">
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
<tr>
<td colSpan=2>
<table width="100%" border=0>
<tr>
<th width=350>����</th>
<th width=72>��Ŀ��ֵ</th>
<th width=72>��Ŀ����</th>
<th width=66>��ȷ����</th>
<th width=64>�������</th>
<th width=129>˳��</th>
</tr>
<?php
if($List)														//�ж��Ƿ��п͹�����Ϣ
{
foreach($List as $value)											//ѭ����ʾ�͹�����Ϣ
{
	$sum = $value[F_OBJECTIVE_RIGHT] + $value[F_OBJECTIVE_WRONG];
	$right = @number_format(($value[F_OBJECTIVE_RIGHT] / $sum) * 100,2) . "%";
	$wrong = @number_format(($value[F_OBJECTIVE_WRONG] / $sum) * 100,2) . "%";	
?>
<tr bgColor=#ffffff>
<td><?php echo $value[F_OBJECTIVE_NAME]?>
  <input name="SelId[]" type="hidden" id="SelId[]" value="<?php echo $value[F_ID]?>"></td>
<td align=middle><?php echo $value[F_OBJECTIVE_SCORE]?>��</td>
<td align=middle>
<?php 
if($value[F_OBJECTIVE_TYPE] == 1)								//�ж��Ƿ��ǵ�ѡ
{
	echo "��ѡ";
}else{
	echo "��ѡ";
}
?></td>
<td align=middle><?php echo $right?>(<?php echo $value[F_OBJECTIVE_RIGHT]?>)</td>
<td align=middle><?php echo $wrong?>(<?php echo $value[F_OBJECTIVE_WRONG]?>)</td>
<td align=middle><input name="order[]" type="text" id="order[]" size="10" value="<?php echo $value[F_OBJECTIVE_ORDER]?>"></td>
</tr>
<?php
}
}
?>
</table>
</td>
</tr>
<tr>
<th colSpan=2><input id=cmdAdd type=submit value=" �� �� �� �� " name=cmdDel>
  <input type="button" name="Submit" value=" �� �� �� �� " onClick="javascript:window.location='ObjList.php?Id=<?php echo $id?>'"></th>
</tr></table>
</form>
</body>
</html>