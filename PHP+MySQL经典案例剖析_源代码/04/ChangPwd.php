<?php require_once('config.inc.php'); ?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php
session_start();
if(!$_SESSION['UserId'])											//�ж��Ƿ��½
{
	echo "<a href='Login.php'>��δ��½--���ȵ�½</a>";
	exit();
}
$User = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	$data = array();
	$data[F_USER_PASSWORD] = md5($_POST['password']);
	$User->updateData("EM_USER_INFO",$_SESSION['UserId'],$data);	//�޸�����
	echo "�޸ĳɹ�";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>����ϵͳ</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
<style type="text/css">
<!--
.STYLE2 {
	color: #7e7e7e;
	font-size: 14px;
	font-weight: bold;
}
.STYLE3 {color: #3f5994}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="" onsubmit="javascript:return check();">
<table width="300" border="0" align="center">
<tr>
<td height="25" colspan="2" class="STYLE2">�޸�����</td>
</tr>
<tr>
<td width="86" class="STYLE3">�¡��ܡ��룺</td>
<td width="204"><input name="password" type="password" id="password" /></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td class="STYLE3"> ���볤��Ϊ6-13λ</td>
</tr>
<tr>
<td class="STYLE3">ȷ�������룺</td>
<td><input name="confirm" type="password" id="confirm" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="image" name="imageField" src="images/submit.gif" />
  <a href="ClassList.php">���ؿ�Ŀ�б�</a></td>
</tr>
</table>
</form>
<script language="javascript">
function check()
{
	if(document.form1.password.value == '')							//�ж������Ƿ�Ϊ��
	{
		alert('����д������');
		document.form1.password.focus();
		return false;
	}
	if(document.form1.password.value.length < 6 || document.form1.password.value.length > 13)
	{														//�ж������볤���Ƿ�Ϸ�
		alert('�����볤�Ȳ���ȷ');
		document.form1.password.focus();
		return false;		
	}
	if(document.form1.password.value != document.form1.confirm.value)
	{														//�ж��������������Ƿ�һ��
		alert('����ǰ�����벻һ��');
		document.form1.password.focus();
		return false;
	}	
	return true;
}
</script>
</body>
</html>