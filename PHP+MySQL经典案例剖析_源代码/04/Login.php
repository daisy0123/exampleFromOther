<?php require_once('config.inc.php'); ?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php
session_start();
$User = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	if($r = $User->CheckLogin($_POST['userno'],$_POST['password']))		//��֤�û���������
	{
		$_SESSION['UserId'] = $r[F_ID];
		$_SESSION['UserName'] = $r[F_USER_NAME];
		$_SESSION['UserNo'] = $_POST['userno'];
		header("Location:ClassList.php");
		exit();
	}else{
		$msg = "ѧ�Ż��������";
	}
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
<form name="form1" method="post" action="">
<table width="300" border="0" align="center">
<tr>
<td height="25" colspan="2"><span class="STYLE2">�û���¼</span></td>
</tr>
<tr>
<td width="55"><span class="STYLE3">ѧ���ţ�</span></td>
<td><input name="userno" type="text" id="userno" /></td>
</tr>
<tr>
<td class="STYLE3">�ܡ��룺</td>
<td><input name="password" type="password" id="password" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="image" name="imageField" src="images/login.gif" />
  <font color="red"><?php echo $msg?></font></td>
</tr>
</table>
</form>
</body>
</html>