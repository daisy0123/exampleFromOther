<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'display.inc.php');
$display = new Display();
$year = date('Y');
$month = date('n');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>流量统计系统</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
<script language="javascript" src="date.js"></script>				<!--调用日期选择文件-->
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
		  if($_POST['year'])								//判断是否提交查询，显示查询日期
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
            <td width="16%" height="25" align="center"><span class="STYLE1">时间</span></td>
            <td width="40%" align="center">访问量</td>
            <td width="44%" align="center">唯一访客</td>
            </tr>
<?php
if(!$_POST['year'])										//判断是否提交查询，是则显示查询结果
{													//不是则显示总的统计结果
for($i=1;$i<=12;$i++)
{
$info = $display->GetMonth('',$i);
?>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $i?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo ($info['F_MONTH_COUNT']) ? $info['F_MONTH_COUNT'] : 0?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo ($info['F_MONTH_COUNT']) ? $info['F_MONTH_IP_COUNT'] : 0?></td>
          </tr>
<?php
}
}else{
$info = $display->GetMonth($_POST['year'],$_POST['month']);
$month = (int)$_POST['month'];
?>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $month?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo ($info['F_MONTH_COUNT']) ? $info['F_MONTH_COUNT'] : 0?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo ($info['F_MONTH_COUNT']) ? $info['F_MONTH_IP_COUNT'] : 0?></td>
          </tr>
<?php
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