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
			$msg = "��½ʧ��";
		}
	}else{
		$msg = "��֤�����";
	}
}
?>
<HTML>
<HEAD>
<TITLE>��½</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
</HEAD>
<BODY>
<DIV id=SearchContent style="WIDTH: 98%">
<DIV id=top_left>
<H2 class=hot>��½</H2></DIV>
</DIV>
<FORM id=form1 name=form1 action="" method=post>
<TABLE style="TABLE-LAYOUT: fixed" cellSpacing=0 cellPadding=0 width="100%" 
border=0>
  <TBODY>
  <TR>
    <TD width="85"><H2>��½</H2></TD>
    <TD><INPUT id=User size=40 name=User> </TD></TR>
  <TR>
    <TD>
      <H2>�û�����</H2></TD>
    <TD><INPUT id=Password type=password size=40 name=Password> </TD></TR>
  <TR>
    <TD>
      <H2>���룺</H2></TD>
    <TD><INPUT id=verify size=6 name=verify> <IMG title=��֤��
      style="CURSOR: pointer" onClick="this.src='include/GetVerifyImg.php';" src="include/GetVerifyImg.php" border=1> </TD></TR>
  
  <TR>
    <TD><?php echo $msg?></TD>
    <TD><INPUT id=Submit type=submit value="�ύ" name=Submit>
      <INPUT id=Submit2 type=button value="ע��" name=Submit2 onClick="javascript:window.location='Register.php'"></TD></TR></TBODY></TABLE>
</FORM>
</BODY>
</HTML>
