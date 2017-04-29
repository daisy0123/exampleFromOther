<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>会员注册</title>
<link href="/Style/index.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="/Js/Base.js"></script>
</head>
<body>
<div id="SearchContent" style="width:98%; ">
    <div id="top_left">
        <h2 class="hot">注册网上商城用户</h2>
    </div>
</div>
<div id="contt">
  <form id="form1" name="form1" method="post" action="/Register/Check" autocomplete="off">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="195" align="left" valign="top"><h2>帐号：</h2></td>
                <td width="505" align="left">{*if $error[NAME_MSG]*}
                    <div class="reg_error"> {*/if*}
                        <input name="name" type="text" id="name" size="40" value="{*$error[NAME_VALUE]*}" /><br />&lt;A-Z字母,0-9数字,下划线_组成,长度3-18个字符&gt;
                        {*if $error[NAME_MSG]*}
                        <div>{*$error[NAME_MSG]*}</div>
                    </div>
                    {*/if*}</td>
            </tr>
            <tr>
              <td width="195" align="left"><h2>激活邮箱：</h2></td>
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
                <td width="505" align="left"><p>例如:happy@egspace.com，错误的邮箱将无法激活帐号！</p></td>
            </tr>
            <tr>
              <td width="195" align="left"><h2>登录密码：</h2></td>
                <td width="505" align="left">{*if $error[PASS_MSG]*}
                    <div class="reg_error"> {*/if*}
                        <input name="password" type="password" id="password" value="{*$error[PASS_VALUE]*}" size="40" /><br />&lt;密码长度请在6-20位之间&gt;
                        {*if $error[PASS_MSG]*} 
                        <div>{*$error[PASS_MSG]*}</div>
                    </div>
              {*/if*} </td>
            </tr>
            <tr>
              <td width="195" align="left"><h2>确认密码：</h2></td>
                <td width="505" align="left">{*if $error[CNFM_MSG]*}
                    <div class="reg_error"> {*/if*}
                        <input name="rpassword" type="password" id="rpassword" value="{*$error[CNFM_VALUE]*}" size="40" />
                        {*if $error[CNFM_MSG]*}
                        <div>{*$error[CNFM_MSG]*}</div>
                    </div>
              {*/if*} </td>
            </tr>
            <tr>
              <td align="left"><h2>是否接收邮件：</h2></td>
              <td align="left"><input name="isacceptemail" type="radio" value="1" checked="checked" />
是
  <input name="isacceptemail" type="radio" value="0" />
否</td>
            </tr>
            <tr>
              <td width="195" align="left"><h2>验证码：</h2></td>
                <td width="505" align="left">{*if $error[VRFY_MSG]*}
                    <div class="reg_error">
                    {*/if*}
                    <input name="verify" type="text" id="verify" value="" size="6" />
                    &nbsp;(请输入：<img src="/Index/GetVerifyImg" style="cursor: pointer" onclick="this.src='/Index/GetVerifyImg?' + Math.random();" title="看不清验证码请点击" border="1">)
				{*if $error[VRFY_MSG]*}	
                    <div>{*$error[VRFY_MSG]*}</div>
                    <div>
              {*/if*}</td>
            </tr>
      </table>
          <input name="logintxt" type="button" value="提 交 注 册" style="padding:3px; font-size:14px;" onclick="javascript:DoRegister();" />
    </form>
</div>
<SCRIPT language=javascript>
/**
 * 功能：检测用户名的格式
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
 * 功能：判断EMAIL的格式
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
 * 功能：检测表单提交项
 */
function check_data()
{
	if($('name').value.trim() == '')									//判断用户名是否为空
	{
		alert("请填写用户名");
		$('name').focus()
		return false;
	}
	if($('name').value.trim().len() < 3 || $('name').value.trim().len() > 18)		//判断用户名的长度是否正确
	{
		alert("用户名长度不符")
		$('name').focus()
		return false
	}
	if(!isValidUserID($('name').value))								//判断用户名格式
	{
		alert("用户名有非法字符")
		$('name').focus()
		return false
	}
	if(!checkEmail($('email').value))									//判断EMAIL格式是否正确
	{
		alert("Email格式错误")
		document.form1.email.focus()
		return false
	}
	if($('password').value == "")									//判断密码是否为空
	{
		alert("密码不能为空")
		$('password').focus()
		return false
	}
	if($('password').value.len() < 6 || $('password').value.len() > 20)			//判断密码长度是否正确
	{
		alert("密码长度应在6-20之间")
		$('password').focus()
		return false
	}
	if($('password').value != $('rpassword').value)						//判断确认密码和密码是否相同
	{
		alert("密码前后不一致")
		$('rpassword').focus()
		return false
	}
	return true;	
}
/**
 * 功能：提交注册
 */
function DoRegister()
{
	if(check_data())												//判断检测是否通过
	{
		document.form1.logintxt.disabled = true;
		document.form1.submit();
	}
}
</SCRIPT>
</body>
</html>