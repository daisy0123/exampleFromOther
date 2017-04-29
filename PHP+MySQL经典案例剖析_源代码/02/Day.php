<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'display.inc.php');
$display = new Display();
if($_POST['Y'])											//判断是否有提交搜索
{
	$year = $_POST['Y'];
	$month = $_POST['m'];
}else{
	$year = date('Y');
	$month = date('m');
}
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
      <table width="100%" border="0">
        <tr>
          <td width="55%">
		  <?php
		  if($_POST['year'])								//判断是否有提交搜索，显示搜索日期
		  {
		  	echo "日期：" . $_POST['year'] . "-" . $_POST['month'];
		  }
		  ?>
		  </td>
          <td width="45%" align="right"><select name="year">
            <?php
for($i=1;$i<=($year+1);$i++)								//显示年下拉框
{
	echo "<option value=$i";
	if($i == $year)
		echo " selected='selected'";
	echo ">$i</option>";
}
?>

            </select>
          年
            <select name="month">
<?php
for($i=1;$i<=12;$i++)										//显示月下拉框
{
	if($i < 10)
		$i = '0' . $i;
	echo "<option value=$i";
	if($i == $month)
		echo " selected='selected'";
	echo ">$i</option>";
}
?>

            </select>
            月   
            <input type="submit" name="Submit" value="提交" /></td>
        </tr>
      </table>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td bgcolor="#999999"><table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td height="25" align="center"><span class="STYLE1">时间</span></td>
            <td align="center">访问量</td>
            <td align="center">唯一访客</td>
            <td align="center">时间</td>
            <td align="center">访问量</td>
            <td align="center">唯一访客</td>
          </tr>
<?php
for($i = 1;$i <= 31;$i++)									//循环显示31天的统计
{
	if($i < 10)											//加前导0
		$k = '0' . $i;
	else 
		$k = $i;
	$j = $i + 1;
	if($j < 10)											//加前导0
		$j = '0' + $j;
	$info = $display->GetDay($_POST['year'],$_POST['month'],$k);
	$next_info = $display->GetDay($_POST['year'],$_POST['month'],$j);
?>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $i?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo ($info['F_DAY_COUNT']) ? $info['F_DAY_COUNT'] : '&nbsp;'?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo ($info['F_DAY_IP_COUNT']) ? $info['F_DAY_IP_COUNT'] : '&nbsp;'?></td>
            <td align="center" bgcolor="#FFFFFF"><?php echo $j?></td>
            <td align="center" bgcolor="#FFFFFF"><?php echo ($next_info['F_DAY_COUNT']) ? $next_info['F_DAY_COUNT'] : '&nbsp;'?></td>
            <td align="center" bgcolor="#FFFFFF"><?php echo ($next_info['F_DAY_IP_COUNT']) ? $next_info['F_DAY_IP_COUNT'] : '&nbsp;'?></td>
          </tr>
<?php
	$i++;
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