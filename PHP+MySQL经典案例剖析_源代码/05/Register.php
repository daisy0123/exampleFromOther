<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . "db.inc.php");
require_once(INCLUDE_PATH . "user.inc.php");
session_start();
$User = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否提交操作
{
	if(!(strtoupper($_SESSION['verify']) == strtoupper($_POST['code'])))		//判断验证码是否正确
	{
		$msg = "验证码错误";
		$codeError = 1;
	}else{
		if($User->CheckUserNameExist($_POST['username']))			//判断用户名是否存在
		{
			$msg = "用户名已存在";
			$userError = 1;
		}else{
			if($Id=$User->Register($_POST))							//判断是否注册成功
			{
				echo "注册成功--<a href='/Index.php?BlogId=$Id'>返回首页</a>";
				exit();
			}
		}
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>用户注册</title>
<script language="javascript" src="/js/Base.js"></script>
</head>
<body>
<div align="center">
<form name="register" method="post" action="" onSubmit="javascript:return CheckForm();"> 
<table border="0"  align="center" width=724>
<tr>
  <td height="25" align="center">用户注册</td>
</tr>
<tr> 
<td>请注意：带有**选项都必须填写,其中带有<font color="#FF0000">**</font>号的选项注册成功后将不能修改</td> 
</tr> 
</table>
<table cellpadding="2" cellspacing="2" width="724" height="350"  border="1"  class="unnamed1" bordercolordark=#FFFFFF bordercolorlight=#808080>
<tr bgcolor="A3A2A2">
<td height="25" colspan="3"><FONT  color=#FFFFFF><B>&nbsp;基本信息：</B></FONT></td>
</tr> 
<tr valign="top">
  <td width="20%" align="right"  valign="top">用户名:</td> 
<td width="40%"><input name="username" type="text" id="username" value="<?php echo $_POST['username']?>" size="16" maxLength="16" >
  <font color="#FF0000">**</font>
  <input type="button" name="Submit2" value="检查用户名" onClick="javascript:window.open('CheckUser.php?User='+document.register.username.value)">
<td width="40%"  class="p1">
<?php
if($userError)													//判断用户名错误变量是否为1
{
	echo $msg;												//如果为1则显示错误提示信息
}else{
?>
<span class="bbc">用户名由<b>a～z</b>的英文字母(不区分大小写)、<b>0～9</b>的数字组成，首字符必须是字母，不区分大小写。长度为4-16个字符。用户名不能重复。注册成功后不可以修改。
</span>
<?php
}
?>
</td> 
</tr> 
<tr valign="top"> 
<td align="right"  valign="top"><font color="#000000">密　码:</td> 
<td><input name="password" type="password" id="password" size="16" maxLength="16" >** 
<td class="p1"><span class="bbc">密码为英文字母及数字组合，区分大小写。长度为6-16个字符。为了尽量保证密码的强壮，保护您的帐号安全，最好尽量复杂，例如至少要包含一个数字，至少也要包含一个字母。
</span></td> 
</tr> 
<tr> 
<td align="right"><font color="#000000">再输入一次密码:</font></td> 
<td><input name="Confirm" type="password" id="Confirm" size="16" maxLength="16">**</td> 
<td class="p1">&nbsp;</td> 
</tr>
<tr>
  <td align="right">昵称:</td>
  <td><input name="NickName" type="text" id="NickName" value="<?php echo $_POST['NickName']?>" size="16" maxLength="16" ></td>
  <td  class="p1">昵称可以为汉字。长度为6-16个字符。</td>
</tr>
<tr> 
<td align="right" valign="top"><font color="#000000">您的E-mail:</font></td> 
<td valign="top"><input name="Email" type="text" id="Email"  value="<?php echo $_POST['Email']?>"size="30" maxLength="40" 
>**<td  class="p1"><span class="bbc">
该邮箱用于取回密码功能，请正确填写</span></td> 
</tr>
<tr>
  <td align="right" valign="top">博客名称:</td>
  <td valign="top"><input name="Blog" type="text" id="Blog" value="<?php echo $_POST['Blog']?>" size="30" maxLength="40">**<td  class="p1">名称长度为50个字符(25个汉字)</td>
</tr>
<tr bgcolor="A3A2A2">
<td height="25" colspan="3"><FONT  color=#FFFFFF><B>&nbsp;验证信息：</B></FONT></td>
</tr> 
<tr> 
<td align="right" valign="top"><font color="#000000">请输入四位验证码：</font></td> 
<td valign="top"><input type="text" size="16" maxlength="4" name="code" valign="middle">&nbsp;&nbsp; **&nbsp;&nbsp;
<img src="include/GetVerifyImg.php" name="getcode"  border="1" onClick="javascript:this.src='include/GetVerifyImg.php';">
<td  class="p1">
<?php
if($codeError)													//判断验证码错误变量是否为1
{
	echo $msg;												//如果为1则显示错误提示信息
}else{
?>
输入验证码不必区分大小写。如若看不清楚，可以点击图片刷新。
<?php
}
?>
</tr> 
<tr> 
<td align="center" colspan="3">
<br>
<input type="submit" name="Submit" value=" 注 册 "></td>
</tr>
</table>
</form>
</div>
</body>
</html>
