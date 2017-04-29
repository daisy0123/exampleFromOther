<?php
require_once("../config.inc.php");
require_once(INCLUDE_PATH . "db.inc.php");
require_once(INCLUDE_PATH ."User.inc.php");
session_start();
$user = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if($r = $user->CheckLogin($_POST['username'],$_POST['password']))
	{
		$_SESSION['GROUP_ID'] = $r['F_ID_GROUP_INFO'];
		$_SESSION['F_ID'] = $r['F_ID'];
		$_SESSION['F_NAME'] = $r['F_USER_NAME'];
		header("Location:Index.php");
		exit();
	}else{
		$msg = "用户名或密码错误";
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>CMS系统后台登陆入口</title>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">
</head>

<body>

<form name="form1" action="" method="post">
<TABLE height=258 border=0 align=center cellPadding=1 cellSpacing=0 
style="BORDER-RIGHT: 3px outset; BORDER-TOP: 3px outset; BORDER-LEFT: 3px outset; WIDTH: 0px; BORDER-BOTTOM: 3px outset">
  <TBODY>
  <TR>
    <TD height=252>
      <TABLE cellSpacing=0 cellPadding=0 width=605 align=center border=0>
        <TBODY>
        <TR>
          <TD background=images/admin_login_r1_c1.jpg height=17>
            <DIV class=ht align=center></DIV></TD></TR></TBODY></TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=605 align=center border=0>
        <TBODY>
        <TR>
          <TD width=24 height=212><IMG height=212 
            src="images/admin_login_r2_c1.jpg" width=23></TD>
          <TD vAlign=middle align=middle width=494 bgColor=#f7faff>
            <TABLE cellSpacing=5 cellPadding=0 width="100%" align=center 
            border=0>
              <TBODY>
              <TR>
                <TD align=center width="34%"><font color="Red"><?php echo $msg?></font></TD>
                <TD width="66%" align="left" valign="middle">
                  <DIV align=left>
                    <table width="100%" border="0">
                      <tr>
                        <td><span class="caption"><strong>CMS系统后台登陆入口</strong></span></td>
                      </tr>
                    </table>
                    <br>
                    <TABLE class=ht style="BORDER-COLLAPSE: collapse" height=74 
                  cellSpacing=0 cellPadding=0 width=220 border=0>
                    <TBODY>
                    <TR>
                      <TD width=67 height=16 align="right">会员账号：</TD>
                      <TD align=left width=109 height=16>
                        <P><FONT size=2><INPUT id=name4 size=20 name=username style="height:18px;width:120px"> 
                        </FONT></P></TD></TR>
                    <TR vAlign=center align=middle>
                      <TD width=67 height=16 align="right">登陆密码：</TD>
                      <TD align=left width=109 height=16>
                        <P><FONT size=2><INPUT id=password type=password size=20 
                        name=password style="height:18px;width:120px"> 
                        </FONT></P></TD></TR>
                    <TR vAlign=center align=middle>
                      <TD height=16 align="right">验证码：</TD>
                      <TD align=left height=16><input name="code" id="code" size="10" />
      <img src="../Include/GetVerifyImg.php" onClick="this.src='../Include/GetVerifyImg.php';" /></TD>
                    </TR>
                    <TR vAlign=center align=middle>
                      <TD colSpan=2 height=13>
                <DIV align=center><FONT size=2>
                  <INPUT type=image 
                        height=19 width=50 src="images/submit.gif" 
                        value=提交 name=Submit> </FONT><FONT size=2></FONT><FONT 
                        size=2><A onclick=document.form1.reset() 
                        href="javascript:;"><IMG height=19 
                        src="images/reset.gif" width=50 
                        border=0></A></FONT></DIV></TD></TR>
                    <TR vAlign=center align=middle>
                      <TD colSpan=2 height=13>系统管理员：admin 密码：123456</TD>
                    </TR>
                    </TBODY></TABLE>
                  </DIV></TD></TR></TBODY></TABLE></TD>
          <TD width=88><IMG height=212 alt="网站后台管理系统" 
            src="images/admin_login_r2_c3.jpg" 
        width=88></TD></TR></TBODY></TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=605 align=center border=0>
        <TBODY>
        <TR>
  <TD><IMG height=21 src="images/admin_login_r4_c1.jpg" 
            width=605></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></form>
</body>
</html>