<?php require_once('../../config.inc.php'); ?>
<?php
session_start();
if(!$_SESSION['F_ID'])											//判断是否有登陆
{
	header("Location:Login.php");								//没登陆则转到登陆页面
	exit();
}
?>
<HTML>
<HEAD>
<TITLE>后台管理系统</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=gb2312">
</HEAD>
<FRAMESET name=channel_admin cols="170,*" frameborder="NO" border="0" framespacing="0"> 
  <FRAME name="left" scrolling="no" noresize src="changewin.php?Type=<?php echo $_GET[Type]?>&MenuId=<?php echo $_GET[MenuId]?>">
  <FRAME name="n_right" id="n_right" src="right.php">
</FRAMESET>
<NOFRAMES><BODY bgcolor="#FFFFFF" text="#000000">
</BODY></NOFRAMES>
</HTML>

