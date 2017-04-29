<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>请输入密码</title>
</head>
<body rightmargin="0" bottommargin="0" leftmargin="0" topmargin="0">
<form id="form1" name="form1" method="post" action="?BlogId=<?php echo $blogid?>&Action=Check">
  <table width="100%" border="0">
    <tr>
      <td height="300">
	  <p align="center">本博客需要密码登入，请输入密码：</p>
	  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellpadding="0" cellspacing="1">
            <tr>
              <td width="27%" height="25" align="right" bgcolor="#FFFFFF">密码：</td>
              <td width="73%" bgcolor="#FFFFFF"><input name="password" type="password" id="password" />
              <font color="Red"><?php echo $msg?></font></td>
            </tr>
            <tr>
              <td height="25" align="right" bgcolor="#FFFFFF">确认密码：</td>
              <td bgcolor="#FFFFFF"><input name="confirm" type="password" id="confirm" /></td>
            </tr>
          </table></td>
        </tr>
      </table>
	  <p align="center">
	    <input type="submit" name="Submit" value="提交" />&nbsp;
		<input type="button" name="Submit2" value="登陆" onclick="javascript:window.location = '<?php echo ROOT_PATH ?>login.php'" />&nbsp;<input type="button" name="Submit2" value="注册" onclick="javascript:window.location = '<?php echo ROOT_PATH ?>register.php'" />
	  </p>
	  </td>
    </tr>
  </table>
</form>
</body>
</html>
