<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . "db.inc.php");
require_once(INCLUDE_PATH . "user.inc.php");
session_start();
$User = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ��ύ����
{
	if(!(strtoupper($_SESSION['verify']) == strtoupper($_POST['code'])))		//�ж���֤���Ƿ���ȷ
	{
		$msg = "��֤�����";
		$codeError = 1;
	}else{
		if($User->CheckUserNameExist($_POST['username']))			//�ж��û����Ƿ����
		{
			$msg = "�û����Ѵ���";
			$userError = 1;
		}else{
			if($Id=$User->Register($_POST))							//�ж��Ƿ�ע��ɹ�
			{
				echo "ע��ɹ�--<a href='/Index.php?BlogId=$Id'>������ҳ</a>";
				exit();
			}
		}
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�û�ע��</title>
<script language="javascript" src="/js/Base.js"></script>
</head>
<body>
<div align="center">
<form name="register" method="post" action="" onSubmit="javascript:return CheckForm();"> 
<table border="0"  align="center" width=724>
<tr>
  <td height="25" align="center">�û�ע��</td>
</tr>
<tr> 
<td>��ע�⣺����**ѡ�������д,���д���<font color="#FF0000">**</font>�ŵ�ѡ��ע��ɹ��󽫲����޸�</td> 
</tr> 
</table>
<table cellpadding="2" cellspacing="2" width="724" height="350"  border="1"  class="unnamed1" bordercolordark=#FFFFFF bordercolorlight=#808080>
<tr bgcolor="A3A2A2">
<td height="25" colspan="3"><FONT  color=#FFFFFF><B>&nbsp;������Ϣ��</B></FONT></td>
</tr> 
<tr valign="top">
  <td width="20%" align="right"  valign="top">�û���:</td> 
<td width="40%"><input name="username" type="text" id="username" value="<?php echo $_POST['username']?>" size="16" maxLength="16" >
  <font color="#FF0000">**</font>
  <input type="button" name="Submit2" value="����û���" onClick="javascript:window.open('CheckUser.php?User='+document.register.username.value)">
<td width="40%"  class="p1">
<?php
if($userError)													//�ж��û�����������Ƿ�Ϊ1
{
	echo $msg;												//���Ϊ1����ʾ������ʾ��Ϣ
}else{
?>
<span class="bbc">�û�����<b>a��z</b>��Ӣ����ĸ(�����ִ�Сд)��<b>0��9</b>��������ɣ����ַ���������ĸ�������ִ�Сд������Ϊ4-16���ַ����û��������ظ���ע��ɹ��󲻿����޸ġ�
</span>
<?php
}
?>
</td> 
</tr> 
<tr valign="top"> 
<td align="right"  valign="top"><font color="#000000">�ܡ���:</td> 
<td><input name="password" type="password" id="password" size="16" maxLength="16" >** 
<td class="p1"><span class="bbc">����ΪӢ����ĸ��������ϣ����ִ�Сд������Ϊ6-16���ַ���Ϊ�˾�����֤�����ǿ׳�����������ʺŰ�ȫ����þ������ӣ���������Ҫ����һ�����֣�����ҲҪ����һ����ĸ��
</span></td> 
</tr> 
<tr> 
<td align="right"><font color="#000000">������һ������:</font></td> 
<td><input name="Confirm" type="password" id="Confirm" size="16" maxLength="16">**</td> 
<td class="p1">&nbsp;</td> 
</tr>
<tr>
  <td align="right">�ǳ�:</td>
  <td><input name="NickName" type="text" id="NickName" value="<?php echo $_POST['NickName']?>" size="16" maxLength="16" ></td>
  <td  class="p1">�ǳƿ���Ϊ���֡�����Ϊ6-16���ַ���</td>
</tr>
<tr> 
<td align="right" valign="top"><font color="#000000">����E-mail:</font></td> 
<td valign="top"><input name="Email" type="text" id="Email"  value="<?php echo $_POST['Email']?>"size="30" maxLength="40" 
>**<td  class="p1"><span class="bbc">
����������ȡ�����빦�ܣ�����ȷ��д</span></td> 
</tr>
<tr>
  <td align="right" valign="top">��������:</td>
  <td valign="top"><input name="Blog" type="text" id="Blog" value="<?php echo $_POST['Blog']?>" size="30" maxLength="40">**<td  class="p1">���Ƴ���Ϊ50���ַ�(25������)</td>
</tr>
<tr bgcolor="A3A2A2">
<td height="25" colspan="3"><FONT  color=#FFFFFF><B>&nbsp;��֤��Ϣ��</B></FONT></td>
</tr> 
<tr> 
<td align="right" valign="top"><font color="#000000">��������λ��֤�룺</font></td> 
<td valign="top"><input type="text" size="16" maxlength="4" name="code" valign="middle">&nbsp;&nbsp; **&nbsp;&nbsp;
<img src="include/GetVerifyImg.php" name="getcode"  border="1" onClick="javascript:this.src='include/GetVerifyImg.php';">
<td  class="p1">
<?php
if($codeError)													//�ж���֤���������Ƿ�Ϊ1
{
	echo $msg;												//���Ϊ1����ʾ������ʾ��Ϣ
}else{
?>
������֤�벻�����ִ�Сд������������������Ե��ͼƬˢ�¡�
<?php
}
?>
</tr> 
<tr> 
<td align="center" colspan="3">
<br>
<input type="submit" name="Submit" value=" ע �� "></td>
</tr>
</table>
</form>
</div>
</body>
</html>
