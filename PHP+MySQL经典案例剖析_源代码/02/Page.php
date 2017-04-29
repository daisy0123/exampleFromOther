<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'display.inc.php');
$display = new Display();
if($_GET['action'])										//判断显示信息类型，默认为网站来路统计
{
	$action = $_GET['action'];
}else{
	$action = 'Refer';
}
switch ($action)
{
	case 'Refer':										//传递参数为’Refer’,显示网站来路信息
		$title = '网站来路域名';
		$field = 'F_REFER_URL';
		break;
	case 'Page':										//传递参数为’Page’,显示受访页面信息
		$title = '受访页面';
		$field = 'F_REFER_PAGE';
		break;
	default:
		break;
}
$list = $display->GetPage($action);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>流量统计系统</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
</head>

<body>
<table width="800" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" valign="top" bgcolor="#B1B1D3"><?php include("left.inc.php")?></td>
    <td valign="top">
	<form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td bgcolor="#999999"><table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td width="31%" height="25" align="center"><?php echo $title?></td>
            <td width="33%" align="center">访问量</td>
            <td width="36%" align="center">唯一访客</td>
            </tr>
<?php
if($list)
{
	foreach ($list as $value)
	{
?>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $value[$field]?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $value['COUNT']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $value['IPCOUNT']?></td>
            </tr>
<?php
	}
}
?>
        </table></td>
        </tr>
    </table>
      </form>
    </td>
  </tr>
</table>
</body>
</html>