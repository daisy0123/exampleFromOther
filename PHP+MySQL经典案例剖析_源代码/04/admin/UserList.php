<?php require_once('../config.inc.php');?>
<?php require_once(INCLUDE_PATH . 'User.inc.php'); ?>
<?php
$User = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST')							//�ж��Ƿ��ύɾ������
{
	if($_POST[del_id])												//�ж��Ƿ�ѡ����ɾ���û�
	{
		foreach($_POST[del_id] as $id)								//ѭ��ɾ��ѡ���û�
			$User->delData($id,"EM_USER_INFO");
	}
}
$page = $_GET['Page'];
if(!$page) $page = 1;													//�ж��Ƿ���ҳ�룬Ĭ��Ϊ1
$List = $User->GetUserList($page);
$Count = $User->GetUserCount();
$Pagecount = ceil($Count / $User->pagesize);
if(!$Pagecount) $Pagecount = 1;										//�ж��Ƿ���ҳ����Ĭ��Ϊ1
?>
<html>
<head>
<title>����ϵͳ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form name="form1" method="post" action="">
<table width="80%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="30" colspan="2" align="center" class="caption">�û��б�</td>
</tr>
<tr>
<td width="82%">�����û�<?php echo $Count?>�� ��<font color="red"><?php echo $page?></font>/<?php echo $Pagecount?> ÿҳ<?php echo $User->pagesize?></td>
<td width="18%" align="right">ת����
<select name="select" onchange="javascript:location.href='?Page='+this.options[selectedIndex].value;">
<?php
for($i = 1;$i <= $Pagecount;$i++)										//ѭ����ʾҳ��������
{
	echo "<option value='$i'";
	if($i == $page)													//����Ĭ��ҳ
		echo " selected";
	echo ">$i</option>";
}
?>
</select>
ҳ</td>
</tr>
</table>
<table width="80%"  border="0" align="center" cellpadding="1" cellspacing="1">
<tr>
<td bgcolor="#999999"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
<td><table width="100%" border="0">
<tr>
  <th width="28"> <input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
  <th width="172">�û�����</th>
  <th width="78">�Ա�</th>
  <th width="83">ѧ��</th>
  <th width="55">����</th>
</tr>
<?php
if($List)															//�ж��Ƿ����û���¼
{
	foreach($List as $key => $value){									//ѭ����ʾ�û���¼
?>
<tr>
  <td align="center"><?php echo "<input type='checkbox' name='del_id[]' value='{$value[F_ID]}'>" ?> </td>
  <td><?php echo $value[F_USER_NAME] ?> </td>
  <td align="center"><?php echo ($value[F_USER_GENDER]) ? "Ů" : "��"; ?> </td>
  <td align="center"><?php echo $value[F_USER_NO]?> </td>
  <td align="center"><a href="UserAdd.php?Id=<?php echo $value[F_ID] ?>">[�༭]</a></td>
</tr>
<?php
	}
}
else
{
?>
<tr>
<td align="center" colspan="5" bgcolor="#eeeeee">��ʱû���û���</td>
</tr>
<?php
}
?>
<tr>
<td align="center" colspan="5"><input type="button" name="Submit" value="����û�" onClick="javascript:window.location='UserAdd.php'">
&nbsp;<input type="button" name="Submit" value="ɾ���û�" onClick="javascript:del_user();"></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
</form>
<script language="JavaScript" type="text/JavaScript">
/**
 * ���ܣ�ʵ��ȫѡ����
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
/**
 * ���ܣ�ȷ���û�ɾ��
 */
function del_user()
{
	if(confirm("���Ҫɾ����?"))										//�ж��Ƿ�ȷ��ɾ��
	{
		document.form1.submit();
	}
}
</script>
</body>
</html>