<?php
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'display.inc.php');
$display = new Display();
if($_GET['action'])										//���δ���ݲ�������Ĭ��Ϊ��ѯ��Դ����
{
	$action = $_GET['action'];
}else{
	$action = 'Area';
}
switch ($action)
{
	case 'Area':										//���ݲ���Ϊ��Area��,��ʾ��Դ����ͳ��
		$title = '��Դ����ͳ��';
		$field = 'F_CLIENT_AREA';
		break;
	case 'Browser':										//���ݲ���Ϊ��Browser��,��ʾ�����ͳ��
		$title = '�����';
		$field = 'F_CLIENT_BROWSER';
		break;
	case 'System':										//���ݲ���Ϊ��System��,��ʾ����ϵͳͳ��
		$title = '����ϵͳ';
		$field = 'F_CLIENT_SYSTEM';
		break;
	case 'Screen':										//���ݲ���Ϊ��Screen��,��ʾ�ֱ���ͳ��
		$title = '�ֱ���';
		$field = 'F_CLIENT_SCREEN';
		break;
	case 'Language':									//���ݲ���Ϊ��Language��,��ʾ�ͻ�������ͳ��
		$title = '�ͻ�������';
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
<title>����ͳ��ϵͳ</title>
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
            <td align="center">������</td>
            <td align="center">Ψһ�ÿ�</td>
            </tr>
<?php
if($list)												//�ж��Ƿ��¼
{
	foreach ($list as $value)								//ѭ����ʾ��¼
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