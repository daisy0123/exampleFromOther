<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'lang.inc.php');
$lang = new Lang();
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$data['F_CODE'] = $_POST['code'];
	$data['F_NAME'] = $_POST['name'];
	if($lang->insertData($data)){
		echo "操作成功<br>";
	}else{
		echo "操作失败<br>";
	}
	echo "<a href='LangList.php'>点击返回</a>";
	exit();
}
?>
<html>
<head>
<title>语言管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form id="form1" name="form1" method="post" action="">
<table border=0 cellpadding=0 cellspacing=0 width="70%" align="center" class=i_table>  
    <tr>
    <td class="head" colspan="2">语言设置</td>
  </tr>
    <tr>
      <td width="28%" align="right">国家码：</td>
      <td width="72%"><input name="code" type="text" />
      如:zh_CN,en_US</td>
    </tr>
    <tr>
      <td width="28%" align="right">国家名称：</td>
      <td width="72%"><input name="name" type="text" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit2" value="确定" />
      &nbsp;<input name="返回" type="button" value="返回" onClick="javascript:window.history.back();'"/></td>
    </tr>
  </table>
</form>
</body>
</html>