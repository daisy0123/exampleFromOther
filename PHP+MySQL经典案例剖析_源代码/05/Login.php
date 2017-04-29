<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . "db.inc.php");
require_once(INCLUDE_PATH . "user.inc.php");
session_start();
$User = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if($_SESSION['verify'] == $_POST['verify'])
	{
		if($User->Login($_POST['User'],$_POST['Password']))	
		{
			header("Location:admin/Index.php");
			exit();
		}else{
			$msg = "登陆失败";
		}
	}else{
		$msg = "验证码错误";
	}
}
?>
<HTML>
<HEAD>
<TITLE>登陆</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
</HEAD>
<BODY>
<DIV id=SearchContent style="WIDTH: 98%">
<DIV id=top_left>
<H2 class=hot>登陆</H2></DIV>
</DIV>
<FORM id=form1 name=form1 action="" method=post>
<TABLE style="TABLE-LAYOUT: fixed" cellSpacing=0 cellPadding=0 width="100%" 
border=0>
  <TBODY>
  <TR>
    <TD width="85"><H2>登陆</H2></TD>
    <TD><INPUT id=User size=40 name=User> </TD></TR>
  <TR>
    <TD>
      <H2>用户名：</H2></TD>
    <TD><INPUT id=Password type=password size=40 name=Password> </TD></TR>
  <TR>
    <TD>
      <H2>密码：</H2></TD>
    <TD><INPUT id=verify size=6 name=verify> <IMG title=验证码
      style="CURSOR: pointer" onClick="this.src='include/GetVerifyImg.php';" src="include/GetVerifyImg.php" border=1> </TD></TR>
  
  <TR>
    <TD><?php echo $msg?></TD>
    <TD><INPUT id=Submit type=submit value="提交" name=Submit>
      <INPUT id=Submit2 type=button value="注册" name=Submit2 onClick="javascript:window.location='Register.php'"></TD></TR></TBODY></TABLE>
</FORM>
</BODY>
</HTML>
