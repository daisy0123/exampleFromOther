<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'display.inc.php');
$display = new Display();
if($_POST['Y'])											//�ж��Ƿ����ύ����
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
<title>����ͳ��ϵͳ</title>
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
		  if($_POST['year'])								//�ж��Ƿ����ύ��������ʾ��������
		  {
		  	echo "���ڣ�" . $_POST['year'] . "-" . $_POST['month'];
		  }
		  ?>
		  </td>
          <td width="45%" align="right"><select name="year">
            <?php
for($i=1;$i<=($year+1);$i++)								//��ʾ��������
{
	echo "<option value=$i";
	if($i == $year)
		echo " selected='selected'";
	echo ">$i</option>";
}
?>

            </select>
          ��
            <select name="month">
<?php
for($i=1;$i<=12;$i++)										//��ʾ��������
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
            ��   
            <input type="submit" name="Submit" value="�ύ" /></td>
        </tr>
      </table>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td bgcolor="#999999"><table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td height="25" align="center"><span class="STYLE1">ʱ��</span></td>
            <td align="center">������</td>
            <td align="center">Ψһ�ÿ�</td>
            <td align="center">ʱ��</td>
            <td align="center">������</td>
            <td align="center">Ψһ�ÿ�</td>
          </tr>
<?php
for($i = 1;$i <= 31;$i++)									//ѭ����ʾ31���ͳ��
{
	if($i < 10)											//��ǰ��0
		$k = '0' . $i;
	else 
		$k = $i;
	$j = $i + 1;
	if($j < 10)											//��ǰ��0
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