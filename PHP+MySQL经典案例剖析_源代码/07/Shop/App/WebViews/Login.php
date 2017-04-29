<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<div id="SearchContent" style="width:98%; ">
<div id="top_left">
<h2 class="hot">登录</h2>
</div>
</div>
<form id="form1" name="form1" method="post" action="/Login/Check">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="85"><h2>用户名:</h2></td>
<td>{*if $error[NAME_ERR]*}
<div class="reg_error"> {*/if*}
<input name="name" value="{*$error[NAME_VALUE]*}" type="text" id="name" size="40" />
{*if $error[NAME_ERR]*}	
<div>{*$error[NAME_MSG]*}</div>
</div>
{*/if*} </td>
</tr>
<tr>
<td><h2>密　码:</h2></td>
<td>{*if $error[PASS_ERR]*}
<div class="reg_error">{*/if*}
<input name="password" type="password" id="password" value="" size="40" />
{*if $error[PASS_ERR]*}	
<div>{*$error[PASS_MSG]*}</div>
</div>
{*/if*} </td>
</tr>
<tr>
<td><h2>验证码:</h2></td>
<td>{*if $error[VRFY_MSG]*}
<div class="reg_error">{*/if*}
<input name="verify" type="text" id="verify" value="" size="6" />
（请输入<img src="/Index/GetVerifyImg" style="cursor: pointer" onclick="this.src='/Index/GetVerifyImg?';" title="如看不清楚,请点击此处换一张" border="1">）
{*if $error[VRFY_MSG]*}
<div>{*$error[VRFY_MSG]*}</div>
</div>
{*/if*}</td>
</tr>

<tr>
<td><h2>&nbsp;</h2></td>
<td>{*if $error[CONT_ERR]*}
<div class="reg_error"><div style="float:left; width:85px">{*/if*}
<input type="submit" name="Submit" value="登 录 " id="Submit" /> 
<input type="submit" name="Submit2" value="注 册" onclick="javascript:window.location = '/Register'" />
<a href="/Login/ForgetPwd">[忘记密码?]</a>
{*if $error[CONT_ERR]*}</div>
<div style="float:right;">{*$error[CONT_MSG]*}</div>
</div>
{*/if*} </td>
</tr>
</table>
</form>
