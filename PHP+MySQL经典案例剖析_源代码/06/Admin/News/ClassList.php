<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>后台管理</title>
<link href="/Style/admin.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#B6C8D6" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>	
    <td align="center"><input type="button" name="Submit" value="网站首页(根目录)" style="width:158" onClick="javascript:parent.parent.frames('n_right').location='Index.php?MenuId=<?php echo $_GET['MenuId']?>'"></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="120" valign="top"> 
      <?php
$MenuId = $_GET['MenuId'];
$News = new News();
switch ($_GET['Type'])											//判断是哪个管理模块调用
{
	case 0:													//0表示是栏目管理
		$url = "ClassInfo.php";									//文字连接为栏目信息页
		break;
	case 1:													//1表示是信息管理
		$url = "NewsList.php";									//文字连接到信息列表页
		break;
	case 2:													//2表示是信息审核
		$url = "CheckList.php";									//文字连接到等待审核信息列表
		break;
	case 3:													//3表示是模块管理
		$url = "../Templates/TemplateList.php";						//文字连接到模块列表
		break;
}
$html = "<table width='100%'>";
$class_list = array();
$News->GetClassListAll();
foreach($class_list as $key => $l)									//循环显示栏目
{
	extract($l);
	if($parent_id == 0)											//判断是否是顶层栏目
		$images = "<img src='/Images/plus.gif'>";
	else
		$images = "";
	$html .= "<tr><td>$images<a href='$url?id=$id&MenuId=$MenuId' target='n_right'>$class</a></td></tr>";
}
$html .= "</table>";
echo $html;
?>
    </td>
  </tr>
  <?php
if($_GET['Type'] == 0){											//判断是否是栏目管理
?>
  <tr> 
    <td align="center"> <input type="button" name="Button" value="新增顶层栏目" onClick="javascript:parent.parent.frames('n_right').location='ClassAdd.php?id=0&MenuId=<?php echo $MenuId?>'"> 
    </td>
  </tr>
  <?php
}
?>
</table>
