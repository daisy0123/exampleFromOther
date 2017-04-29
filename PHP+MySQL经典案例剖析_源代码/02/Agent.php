<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'display.inc.php');
$display = new Display();
if($_GET['action'])										//如果未传递参数，则默认为查询来源地域
{
	$action = $_GET['action'];
}else{
	$action = 'Area';
}
switch ($action)
{
	case 'Area':										//传递参数为’Area’,显示来源地域统计
		$title = '来源地域统计';
		$field = 'F_CLIENT_AREA';
		break;
	case 'Browser':										//传递参数为’Browser’,显示浏览器统计
		$title = '浏览器';
		$field = 'F_CLIENT_BROWSER';
		break;
	case 'System':										//传递参数为’System’,显示操作系统统计
		$title = '操作系统';
		$field = 'F_CLIENT_SYSTEM';
		break;
	case 'Screen':										//传递参数为’Screen’,显示分辨率统计
		$title = '分辨率';
		$field = 'F_CLIENT_SCREEN';
		break;
	case 'Language':									//传递参数为’Language’,显示客户端语言统计
		$title = '客户端语言';
		$field = 'F_CLIENT_LANGUAGE';
		break;
	default:
		break;
}
$list = $display->GetAgent($action);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>流量统计系统</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
</head>

<body>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" valign="top" bgcolor="#B1B1D3"><?php include("left.inc.php")?></td>
    <td valign="top">
	<form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td bgcolor="#999999"><table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td height="25" align="center"><?php echo $title?></td>
            <td align="center">访问量</td>
            <td align="center">唯一访客</td>
            </tr>
<?php
if($list)												//判断是否记录
{
	foreach ($list as $value)								//循环显示记录
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