<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'display.inc.php');
$display = new Display();
$list = $display->GetYear($_POST['year']);
list($year,$month,$day) = explode("-",date('Y-m-d'));
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
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" valign="top" bgcolor="#B1B1D3"><?php include("left.inc.php")?></td>
    <td valign="top">
	<form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0">
        <tr>
          <td width="55%">
		  <?php
		  if($_POST['year'])
		  {
		  	echo "日期：" . $_POST['year'] . "年";
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
          年<input type="submit" name="Submit" value="提交" /></td>
        </tr>
      </table>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td bgcolor="#999999"><table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td height="25" align="center"><span class="STYLE1">时间</span></td>
            <td align="center">访问量</td>
            <td align="center">唯一访客</td>
            </tr>
<?php
if($list)
{
foreach($list as $value)
{
?>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $value['F_MONTH_YEAR']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $value['F_YEAR_COUNT']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $value['F_YEAR_IP_COUNT']?></td>
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