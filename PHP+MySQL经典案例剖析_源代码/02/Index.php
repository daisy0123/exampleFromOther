<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'display.inc.php');
$display = new Display();
$info = $display->GetIndex();
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
    <td>����ͳ��ϵͳ��<a href="count.html" target="_blank">����˴���ҳ�沢ˢ�»�ȡͳ������</a></td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" valign="top" bgcolor="#B1B1D3"><?php include("left.inc.php")?></td>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr>
        <td bgcolor="#999999"><table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr>
            <td height="30" colspan="2" align="center"><span class="STYLE1">��վͳ��</span></td>
            </tr>
          <tr>
            <td width="47%" height="26" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; �ܷ�����:</td>
            <td width="53%" height="26" bgcolor="#FFFFFF"><?php echo $info['COUNT']?></td>
          </tr>
          <tr>
            <td height="26" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; ��Ψһ�ÿͣ�</td>
            <td height="26" bgcolor="#FFFFFF"><?php echo $info['IPCOUNT']?></td>
          </tr>
          <tr>
            <td height="26" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; ƽ���շ�������</td>
            <td height="26" bgcolor="#FFFFFF"><?php echo $info['DAYCOUNT']?></td>
          </tr>
          <tr>
            <td height="26" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; ƽ����Ψһ�ÿͣ�</td>
            <td height="26" bgcolor="#FFFFFF"><?php echo $info['DAYIP']?></td>
          </tr>
          <tr>
            <td height="26" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; �����������գ���</td>
            <td height="26" bgcolor="#FFFFFF"><?php echo $info['MAXDAY']?></td>
          </tr>
          <tr>
            <td height="26" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; �����������£���</td>
            <td height="26" bgcolor="#FFFFFF"><?php echo $info['MAXMONTH']?></td>
          </tr>
          <tr>
            <td height="26" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; 
              ���Ψһ�ÿͣ��գ���</td>
            <td height="26" bgcolor="#FFFFFF"><?php echo $info['MAXDAYIP']?></td>
          </tr>
          <tr>
            <td height="26" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; 
              ���Ψһ�ÿͣ��£���</td>
            <td height="26" bgcolor="#FFFFFF"><?php echo $info['MAXMONTHIP']?></td>
          </tr>      
        </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>