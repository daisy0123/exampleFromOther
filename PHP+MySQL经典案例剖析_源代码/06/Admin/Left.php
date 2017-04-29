<?php require_once("../config.inc.php");?>
<?php require_once(INCLUDE_PATH . "db.inc.php");?>
<?php require_once(INCLUDE_PATH ."User.inc.php");?>
<?php
session_start();
$User = new User();
$menu = array();
$menu = $User->GetMenuList($_SESSION['GROUP_ID'],0);
?>
<html>
<head>
<title>左侧导航菜单</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
table { BORDER-TOP: 0px; BORDER-LEFT: 0px; BORDER-BOTTOM: 2px}
select {
	FONT-SIZE: 12px;
	COLOR: #000000; background-color: #E0E2F1;
}
a { TEXT-DECORATION: none; color:#000000}
a:hover{ text-decoration: underline;}
body {font-family:Verdana;FONT-SIZE: 12px;MARGIN: 0;color: #000000;background: #F7F7F7;}
textarea,input,object{font-size: 12px;}
td { BORDER-RIGHT: 1px; BORDER-TOP: 0px; FONT-SIZE: 12px; COLOR: #000000;}
.b{background:#F7F7F7;}

.head { color: #ffffff;background: #739ACE;}
.head td{color: #ffffff;}
.head a{color: #ffffff;}
.head_2 {background: #CED4E8;}
.head_2 td{color: #000000;}
.left_padding{background:#F7F7F7;}
.hr  {border-top: 1px solid #6365CE; border-bottom: 0; border-left: 0; border-right: 0; }
.bold {font-weight:bold;}
.smalltxt {font-family: Tahoma, Verdana; font-size: 12px;color: #000000;}
.i_table{border: 1px solid #6365CE;background:#DEE3EF;}
</style>
<script language="javascript1.1">
/**
  * 功能：打开文件管理对话框
  */
function file_list(){
	var w=850;h=400;									//定义对话框的高和宽
	var theDes="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";										//定义对话框其他属性
	window.showModalDialog("File/",null,theDes);
}
</script> 
</head>
<body topmargin=5 leftmargin=5>
<script language="JavaScript" src="/Js/Menu.js"></script>
<table width=100% align="center" cellpadding=3 cellspacing=0>
<tr><td class=head height=23 align=center>
<a target="right" href="right.php"><b>管理区首页</b></a> | <a target="_top" href="Logout.php"><b>退出</b></a>
</td></tr>
<tr>
<td class=b align=center>
<a href="#" onClick="return Clear(<?php echo count($menu);?>);">+ 全部展开</a> <a href="#" onClick="return SetAdminDeploy(<?php echo count($menu)?>);">- 全部收缩</a>
</td></tr>
<?php
$i = 0;
foreach($menu as $value)									//循环显示主菜单
{
	$sub = array();
	$sub = $User->GetMenuList($_SESSION['GROUP_ID'],$value['F_ID_MENU_INFO']);
?>
<tr>
<td>
<table width=98% align=center cellspacing=1 cellpadding=4 class=i_table><tr>
<td class=head>
<a style="float:right" href="#" onClick="return Tree('a<?php echo $i?>',1);"><img src="/Images/cate_fold.gif" width="14" height="14" border=0 id="img_a<?php echo $i?>"></a>
<b><?php echo $value['F_MENU_NAME']?></b></td>
</tr>
<tbody id="cate_a<?php echo $i?>" style="">
<tr><td class=left_padding>
<?php
	foreach($sub as $val)								//循环显示子菜单
	{
		if($val[F_ID_MENU_INFO] == 13) {
?>
<a href="<?php echo $val['F_MENU_LINK']?>"><?php echo $val['F_MENU_NAME']?></a><br>
<?php
		} else {
?>
<a target=right href="<?php echo $val['F_MENU_LINK']?>"><?php echo $val['F_MENU_NAME']?></a><br>
<?php
		}
	}
?>
</td></tr>
</tbody>
</table>
</td>
</tr>
<?php
	$i++;
}
?>
<tr><td class=head_2 align=center>WWW.XXXX.COM
</td></tr></table>
</body>
</html>
