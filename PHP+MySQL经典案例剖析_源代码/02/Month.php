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
<title>����ͳ��ϵͳ</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
<script language="javascript" src="date.js"></script>				<!--��������ѡ���ļ�-->
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
		  if($_POST['year'])								//�ж��Ƿ��ύ��ѯ����ʾ��ѯ����
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
            <td width="16%" height="25" align="center"><span class="STYLE1">ʱ��</span></td>
            <td width="40%" align="center">������</td>
            <td width="44%" align="center">Ψһ�ÿ�</td>
            </tr>
<?php
if(!$_POST['year'])										//�ж��Ƿ��ύ��ѯ��������ʾ��ѯ���
{													//��������ʾ�ܵ�ͳ�ƽ��
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