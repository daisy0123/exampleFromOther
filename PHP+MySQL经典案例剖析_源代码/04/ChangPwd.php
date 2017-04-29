<?php require_once('config.inc.php'); ?>
<?php require_once(INCLUDE_PATH . 'User.inc.php');?>
<?php
session_start();
if(!$_SESSION['UserId'])											//判断是否登陆
{
	echo "<a href='Login.php'>您未登陆--请先登陆</a>";
	exit();
}
$User = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否是提交操作
{
	$data = array();
	$data[F_USER_PASSWORD] = md5($_POST['password']);
	$User->updateData("EM_USER_INFO",$_SESSION['UserId'],$data);	//修改密码
	echo "修改成功";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>考试系统</title>
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
<td height="25" colspan="2" class="STYLE2">修改密码</td>
</tr>
<tr>
<td width="86" class="STYLE3">新　密　码：</td>
<td width="204"><input name="password" type="password" id="password" /></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td class="STYLE3"> 密码长度为6-13位</td>
</tr>
<tr>
<td class="STYLE3">确认新密码：</td>
<td><input name="confirm" type="password" id="confirm" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="image" name="imageField" src="images/submit.gif" />
  <a href="ClassList.php">返回科目列表</a></td>
</tr>
</table>
</form>
<script language="javascript">
function check()
{
	if(document.form1.password.value == '')							//判断密码是否为空
	{
		alert('请填写新密码');
		document.form1.password.focus();
		return false;
	}
	if(document.form1.password.value.length < 6 || document.form1.password.value.length > 13)
	{														//判断新密码长度是否合法
		alert('新密码长度不正确');
		document.form1.password.focus();
		return false;		
	}
	if(document.form1.password.value != document.form1.confirm.value)
	{														//判断两次输入密码是否一致
		alert('密码前后输入不一致');
		document.form1.password.focus();
		return false;
	}	
	return true;
}
</script>
</body>
</html>