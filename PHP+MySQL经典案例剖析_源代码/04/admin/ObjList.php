<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
$id = $_GET['Id'];
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	if($_POST['SelId'])											//�ж��Ƿ�ѡ��������
	{
		foreach($_POST['SelId'] as $del_id)							//ѭ��ɾ������
		{
			$Data->DelObj($del_id);
		}
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
<td class=caption colSpan=2>�� �� �� �� ��</td>
</tr>
<tr>
<td width="80%">��������<?php echo $Count?>�� �� <font color="red"><?php echo $page?></font> / <?php echo $Pagecount?> ҳ ÿҳ <?php echo $Data->pagesize?></td>
<td width="20%" align="right">ת��
<select name="select" onChange="javascript:location.href='?Id=<?php echo $id?>Page='+this.options[selectedIndex].value;">
<?php
for($i = 1;$i <= $Pagecount;$i++)									//��ʾ��ҳ������
{
	echo "<option value='$i'";
	if($i == $page)												//����Ĭ��ѡ��
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
<th width=24><input id=allbox onclick=CA(); type=checkbox value=1 
name=allbox></th>
<th width=350>����</th>
<th width=72>��Ŀ��ֵ</th>
<th width=72>��Ŀ����</th>
<th width=66>��ȷ����</th>
<th width=64>�������</th>
<th width=129>����</th>
</tr>
<?php
if($List)														//�ж��Ƿ���������Ϣ
{
foreach($List as $value)											//ѭ����ʾ������Ϣ
{
	$sum = $value[F_OBJECTIVE_RIGHT] + $value[F_OBJECTIVE_WRONG];
	$right = @number_format(($value[F_OBJECTIVE_RIGHT] / $sum) * 100,2) . "%";
	$wrong = @number_format(($value[F_OBJECTIVE_WRONG] / $sum) * 100,2) . "%";	
?>
<tr bgColor=#ffffff>
<td align=middle><input type=checkbox value='<?php echo $value[F_ID]?>' name=SelId[]> </td>
<td><?php echo $value[F_OBJECTIVE_NAME]?></td>
<td align=middle><?php echo $value[F_OBJECTIVE_SCORE]?>��</td>
<td align=middle>
<?php 
if($value[F_OBJECTIVE_TYPE] == 1)								//�ж��Ƿ��ǵ�ѡ
{
	echo "��ѡ";
}else{
	echo "��ѡ";
}
?>
</td>
<td align=middle><?php echo $right?>(<?php echo $value[F_OBJECTIVE_RIGHT]?>)</td>
<td align=middle><?php echo $wrong?>(<?php echo $value[F_OBJECTIVE_WRONG]?>)</td>
<td align=middle><a href="ItemList.php?DataId=<?php echo $id?>&Id=<?php echo $value[F_ID]?>">[ѡ�����]</a>
<a href="ObjAdd.php?DataId=<?php echo $id?>&Id=<?php echo $value[F_ID]?>">[�༭]</a></td>
</tr>
<?php
}
}
?>
</table>
</td>
</tr>
<tr>
<th colSpan=2>
<input id=cmdAdd onclick=javascript:delobj(); type=button value=" ɾ �� �� �� " name=cmdDel>
<input type="button" name="Submit2" value=" �� �� �� �� " onClick="javascript:window.location='ObjAdd.php?DataId=<?php echo $id?>'">
<input type="button" name="Submit" value="��������˳��" onClick="javascript:window.location='ObjOrder.php?Id=<?php echo $id?>'"></th>
</tr></table>
</form>
<script language=JavaScript type=text/JavaScript>
/**
 * ʵ��ȫѡ����
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
/**
 * ʵ��ɾ��ȷ��
 */
function delobj()
{
	if(confirm("���Ҫɾ����?"))
	{
		document.form1.submit();
	}
}
</script>
</body>
</html>