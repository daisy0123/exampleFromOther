<?php
session_start();
if(!$_SESSION['F_ID'])											//�ж��Ƿ��е�½
{
	header("Location:Login.php");								//û��½��ת����½ҳ��
	exit();
}
?>
<HTML>
<HEAD>
<TITLE>��̨����</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=gb2312">
</HEAD>
<FRAMESET name=forum cols="170,*" frameborder="NO" border="0" framespacing="0"> 
  <FRAME name="left" scrolling="no" noresize src="changewin.html">
  <FRAME name="right" src="Right.php">
</FRAMESET>
<NOFRAMES><BODY bgcolor="#FFFFFF" text="#000000">
</BODY></NOFRAMES>
</HTML>
