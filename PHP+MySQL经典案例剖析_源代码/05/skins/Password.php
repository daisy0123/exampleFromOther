<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>����������</title>
</head>
<body rightmargin="0" bottommargin="0" leftmargin="0" topmargin="0">
<form id="form1" name="form1" method="post" action="?BlogId=<?php echo $blogid?>&Action=Check">
  <table width="100%" border="0">
    <tr>
      <td height="300">
	  <p align="center">��������Ҫ������룬���������룺</p>
	  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellpadding="0" cellspacing="1">
            <tr>
              <td width="27%" height="25" align="right" bgcolor="#FFFFFF">���룺</td>
              <td width="73%" bgcolor="#FFFFFF"><input name="password" type="password" id="password" />
              <font color="Red"><?php echo $msg?></font></td>
            </tr>
            <tr>
              <td height="25" align="right" bgcolor="#FFFFFF">ȷ�����룺</td>
              <td bgcolor="#FFFFFF"><input name="confirm" type="password" id="confirm" /></td>
            </tr>
          </table></td>
        </tr>
      </table>
	  <p align="center">
	    <input type="submit" name="Submit" value="�ύ" />&nbsp;
		<input type="button" name="Submit2" value="��½" onclick="javascript:window.location = '<?php echo ROOT_PATH ?>login.php'" />&nbsp;<input type="button" name="Submit2" value="ע��" onclick="javascript:window.location = '<?php echo ROOT_PATH ?>register.php'" />
	  </p>
	  </td>
    </tr>
  </table>
</form>
</body>
</html>
