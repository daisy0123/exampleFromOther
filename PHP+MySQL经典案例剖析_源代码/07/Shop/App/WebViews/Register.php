<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��Աע��</title>
<link href="/Style/index.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="/Js/Base.js"></script>
</head>
<body>
<div id="SearchContent" style="width:98%; ">
    <div id="top_left">
        <h2 class="hot">ע�������̳��û�</h2>
    </div>
</div>
<div id="contt">
  <form id="form1" name="form1" method="post" action="/Register/Check" autocomplete="off">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="195" align="left" valign="top"><h2>�ʺţ�</h2></td>
                <td width="505" align="left">{*if $error[NAME_MSG]*}
                    <div class="reg_error"> {*/if*}
                        <input name="name" type="text" id="name" size="40" value="{*$error[NAME_VALUE]*}" /><br />&lt;A-Z��ĸ,0-9����,�»���_���,����3-18���ַ�&gt;
                        {*if $error[NAME_MSG]*}
                        <div>{*$error[NAME_MSG]*}</div>
                    </div>
                    {*/if*}</td>
            </tr>
            <tr>
              <td width="195" align="left"><h2>�������䣺</h2></td>
                <td width="505" align="left">{*if $error[MAIL_MSG]*}
                    <div class="reg_error"> {*/if*}
                        <input name="email" type="text" id="email" size="40" value="{*$error[MAIL_VALUE]*}"/>
                        {*if $error[MAIL_MSG]*}
                        <div>{*$error[MAIL_MSG]*}</div>
                    </div>
              {*/if*} </td>
            </tr>
            <tr>
                <td width="195" align="left" valign="top"></td>
                <td width="505" align="left"><p>����:happy@egspace.com����������佫�޷������ʺţ�</p></td>
            </tr>
            <tr>
              <td width="195" align="left"><h2>��¼���룺</h2></td>
                <td width="505" align="left">{*if $error[PASS_MSG]*}
                    <div class="reg_error"> {*/if*}
                        <input name="password" type="password" id="password" value="{*$error[PASS_VALUE]*}" size="40" /><br />&lt;���볤������6-20λ֮��&gt;
                        {*if $error[PASS_MSG]*} 
                        <div>{*$error[PASS_MSG]*}</div>
                    </div>
              {*/if*} </td>
            </tr>
            <tr>
              <td width="195" align="left"><h2>ȷ�����룺</h2></td>
                <td width="505" align="left">{*if $error[CNFM_MSG]*}
                    <div class="reg_error"> {*/if*}
                        <input name="rpassword" type="password" id="rpassword" value="{*$error[CNFM_VALUE]*}" size="40" />
                        {*if $error[CNFM_MSG]*}
                        <div>{*$error[CNFM_MSG]*}</div>
                    </div>
              {*/if*} </td>
            </tr>
            <tr>
              <td align="left"><h2>�Ƿ�����ʼ���</h2></td>
              <td align="left"><input name="isacceptemail" type="radio" value="1" checked="checked" />
��
  <input name="isacceptemail" type="radio" value="0" />
��</td>
            </tr>
            <tr>
              <td width="195" align="left"><h2>��֤�룺</h2></td>
                <td width="505" align="left">{*if $error[VRFY_MSG]*}
                    <div class="reg_error">
                    {*/if*}
                    <input name="verify" type="text" id="verify" value="" size="6" />
                    &nbsp;(�����룺<img src="/Index/GetVerifyImg" style="cursor: pointer" onclick="this.src='/Index/GetVerifyImg?' + Math.random();" title="��������֤������" border="1">)
				{*if $error[VRFY_MSG]*}	
                    <div>{*$error[VRFY_MSG]*}</div>
                    <div>
              {*/if*}</td>
            </tr>
      </table>
          <input name="logintxt" type="button" value="�� �� ע ��" style="padding:3px; font-size:14px;" onclick="javascript:DoRegister();" />
    </form>
</div>
<SCRIPT language=javascript>
/**
 * ���ܣ�����û����ĸ�ʽ
 */
function isValidUserID(strUserID)
{
	var i,cChar
	var strValidID = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
	for (i=0;i<strUserID.length;i++)
	{
		cChar = strUserID.charAt(i);
		if(strValidID.indexOf(cChar)==-1) return false;
	}
	return true;
}
/**
 * ���ܣ��ж�EMAIL�ĸ�ʽ
 */
function checkEmail(str)
{
    if(str == "")
        return false;
    if (str.charAt(0) == "." || str.charAt(0) == "@" || str.indexOf('@', 0) == -1
        || str.indexOf('.', 0) == -1 || str.lastIndexOf("@") == str.length-1 || str.lastIndexOf(".") == str.length-1)
        return false;
    else
        return true;
}
/**
 * ���ܣ������ύ��
 */
function check_data()
{
	if($('name').value.trim() == '')									//�ж��û����Ƿ�Ϊ��
	{
		alert("����д�û���");
		$('name').focus()
		return false;
	}
	if($('name').value.trim().len() < 3 || $('name').value.trim().len() > 18)		//�ж��û����ĳ����Ƿ���ȷ
	{
		alert("�û������Ȳ���")
		$('name').focus()
		return false
	}
	if(!isValidUserID($('name').value))								//�ж��û�����ʽ
	{
		alert("�û����зǷ��ַ�")
		$('name').focus()
		return false
	}
	if(!checkEmail($('email').value))									//�ж�EMAIL��ʽ�Ƿ���ȷ
	{
		alert("Email��ʽ����")
		document.form1.email.focus()
		return false
	}
	if($('password').value == "")									//�ж������Ƿ�Ϊ��
	{
		alert("���벻��Ϊ��")
		$('password').focus()
		return false
	}
	if($('password').value.len() < 6 || $('password').value.len() > 20)			//�ж����볤���Ƿ���ȷ
	{
		alert("���볤��Ӧ��6-20֮��")
		$('password').focus()
		return false
	}
	if($('password').value != $('rpassword').value)						//�ж�ȷ������������Ƿ���ͬ
	{
		alert("����ǰ��һ��")
		$('rpassword').focus()
		return false
	}
	return true;	
}
/**
 * ���ܣ��ύע��
 */
function DoRegister()
{
	if(check_data())												//�жϼ���Ƿ�ͨ��
	{
		document.form1.logintxt.disabled = true;
		document.form1.submit();
	}
}
</SCRIPT>
</body>
</html>