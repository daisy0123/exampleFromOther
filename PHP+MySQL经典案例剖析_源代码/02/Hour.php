<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'display.inc.php');
$display = new Display();
$date = "";
list($year,$month,$day) = explode("-",date('Y-m-d'));
if($_POST['year']){										//判断是否有提交搜索
	$date = mktime(0,0,0,$_POST['month'],$_POST['day'],$_POST['year']);
} else {
	$date = mktime(0,0,0,$month,$day,$year);
}
$r = $display->GetHour($date);
$info = $r[0];
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
          <td width="50%"><?php if($date) echo "日期：" . date("Y-m-d",$date);?></td>
          <td width="50%" align="right"><select name="year" id="year">
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
        <select name="month" id="month" onchange="javascript:register_buildDay(this.value);">
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
        <select name="day" id="day">
<?php
echo "<option value='$day'>$day</option>";					//显示当前日
?>
        </select>
        日 

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
            <td height="25" align="center">唯一访客</td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">00：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR0']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR0_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">12：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR12']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR12_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">01：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR1']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR1_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">13：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR13']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR13_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">02：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR2']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR2_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">14：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR14']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR14_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">03：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR3']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR3_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">15：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR15']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR15_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">04：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR4']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR4_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">16：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR16']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR16_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">05：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR5']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR5_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">17：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR17']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR17_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">06：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR6']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR6_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">18：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR18']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR18_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">07：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR7']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR7_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">19：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR19']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR19_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">08：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR8']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR8_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">20：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR20']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR20_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">09：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR9']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR9_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">21：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR21']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR21_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">10：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR10']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR10_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">22：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR22']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR22_IP']?></td>
          </tr>
          <tr>
            <td height="26" align="center" bgcolor="#FFFFFF">11：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR11']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR11_IP']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF">23：00</td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR23']?></td>
            <td height="26" align="center" bgcolor="#FFFFFF"><?php echo $info['F_DAY_HOUR23_IP']?></td>
          </tr>
                
        </table></td>
        </tr>
    </table>
        </form>
    </td>
  </tr>
</table>
</body>
</html>