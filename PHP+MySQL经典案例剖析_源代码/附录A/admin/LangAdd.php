<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'lang.inc.php');
$lang = new Lang();
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$data['F_CODE'] = $_POST['code'];
	$data['F_NAME'] = $_POST['name'];
	if($lang->insertData($data)){
		echo "�����ɹ�<br>";
	}else{
		echo "����ʧ��<br>";
	}
	echo "<a href='LangList.php'>�������</a>";
	exit();
}
?>
<html>
<head>
<title>���Թ���</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form id="form1" name="form1" method="post" action="">
<table border=0 cellpadding=0 cellspacing=0 width="70%" align="center" class=i_table>  
    <tr>
    <td class="head" colspan="2">��������</td>
  </tr>
    <tr>
      <td width="28%" align="right">�����룺</td>
      <td width="72%"><input name="code" type="text" />
      ��:zh_CN,en_US</td>
    </tr>
    <tr>
      <td width="28%" align="right">�������ƣ�</td>
      <td width="72%"><input name="name" type="text" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit2" value="ȷ��" />
      &nbsp;<input name="����" type="button" value="����" onClick="javascript:window.history.back();'"/></td>
    </tr>
  </table>
</form>
</body>
</html>