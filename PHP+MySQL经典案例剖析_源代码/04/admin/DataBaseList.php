<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'Data.inc.php'); ?>
<?php
$Data = new Data();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	if($_POST['SelId'])											//�ж��Ƿ�ѡ�������
	{
		foreach($_POST['SelId'] as $id)								//ѭ��ɾ�����
		{
			$Data->DelDataBase($id);
		}
	}
}
if($_GET['Page'])												//�ж��Ƿ���ҳ��
	$page = $_GET['Page'];
else
	$page = 1;
$List = $Data->GetDataList($page);
$Count = $Data->GetDataCount();
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
<td class=caption colSpan=2>�� �� �� ��</td>
</tr>
<tr>
<td width="80%">�������<?php echo $Count?>�� �� <font color="red"><?php echo $page?></font> / <?php echo $Pagecount?> ҳ ÿҳ <?php echo $Data->pagesize?></td>
<td width="20%" align="right">ת��
<select name="select" onchange="javascript:location.href='?Page='+this.options[selectedIndex].value;">
<?php
for($i = 1;$i <= $Pagecount;$i++)									//ѭ����ʾ��ҳ������
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
<th width=26><input id=allbox onclick=CA(); type=checkbox value=1 
name=allbox></th>
<th width=157>�������</th>
<th width=74>������Ŀ</th>
<th width=120>��ע</th>
<th width=91>����ʱ��</th>
<th width=79>�͹�����Ŀ</th>
<th width=76>��������Ŀ</th>
<th width=150>����</th>
</tr>
<?php
if($List)														//�ж��Ƿ�������¼
{
foreach($List as $value)											//ѭ����ʾ����¼
{
	$Info = $Data->getInfo($value[F_ID_CLASS_INFO],"EM_CLASS_INFO");
	$Objcount = $Data->GetObjCount($value[F_ID]);
	$Subcount = $Data->GetSubCount($value[F_ID]);
?>
<tr bgColor=#ffffff>
<td align=middle><input type=checkbox value='<?php echo $value[F_ID]?>' name=SelId[]> </td>
<td><?php echo $value[F_DATABASE_NAME]?></td>
<td align=middle><?php echo $Info[F_CLASS_NAME]?></td>
<td align=middle><?php echo $value[F_DATABASE_NOTE]?></td>
<td align=middle><?php echo date("Y-m-d",$value[F_DATABASE_TIME]);?></td>
<td align=middle><?php echo $Objcount;?></td>
<td align=middle><?php echo $Subcount;?></td>
<td align=middle><a href="ObjList.php?Id=<?php echo $value[F_ID]?>">[�͹���]</a> 
<a href="SubList.php?Id=<?php echo $value[F_ID]?>">[������]</a> 
<a href="DataBaseAdd.php?Id=<?php echo $value[F_ID]?>">[�༭]</a></td>
</tr>
<?php
}
}
?>
</table>
</td>
</tr>
<tr>
<th colSpan=2>&nbsp; <input id=cmdAdd onclick=javascript:deldata(); type=button value=" ɾ �� �� �� " name=cmdDel>
<input type="button" name="Submit2" value=" �� �� �� �� " onClick="javascript:window.location='DataBaseAdd.php'"></th>
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
function deldata()
{
	if(confirm("���Ҫɾ����?"))
	{
		document.form1.submit();
	}
}
</script>
</body>
</html>