<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<div id="SearchContent" style="width:98%; ">
<div id="top_left">
<h2 class="hot">��¼</h2>
</div>
</div>
<form id="form1" name="form1" method="post" action="/Login/Check">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="85"><h2>�û���:</h2></td>
<td>{*if $error[NAME_ERR]*}
<div class="reg_error"> {*/if*}
<input name="name" value="{*$error[NAME_VALUE]*}" type="text" id="name" size="40" />
{*if $error[NAME_ERR]*}	
<div>{*$error[NAME_MSG]*}</div>
</div>
{*/if*} </td>
</tr>
<tr>
<td><h2>�ܡ���:</h2></td>
<td>{*if $error[PASS_ERR]*}
<div class="reg_error">{*/if*}
<input name="password" type="password" id="password" value="" size="40" />
{*if $error[PASS_ERR]*}	
<div>{*$error[PASS_MSG]*}</div>
</div>
{*/if*} </td>
</tr>
<tr>
<td><h2>��֤��:</h2></td>
<td>{*if $error[VRFY_MSG]*}
<div class="reg_error">{*/if*}
<input name="verify" type="text" id="verify" value="" size="6" />
��������<img src="/Index/GetVerifyImg" style="cursor: pointer" onclick="this.src='/Index/GetVerifyImg?';" title="�翴�����,�����˴���һ��" border="1">��
{*if $error[VRFY_MSG]*}
<div>{*$error[VRFY_MSG]*}</div>
</div>
{*/if*}</td>
</tr>

<tr>
<td><h2>&nbsp;</h2></td>
<td>{*if $error[CONT_ERR]*}
<div class="reg_error"><div style="float:left; width:85px">{*/if*}
<input type="submit" name="Submit" value="�� ¼ " id="Submit" /> 
<input type="submit" name="Submit2" value="ע ��" onclick="javascript:window.location = '/Register'" />
<a href="/Login/ForgetPwd">[��������?]</a>
{*if $error[CONT_ERR]*}</div>
<div style="float:right;">{*$error[CONT_MSG]*}</div>
</div>
{*/if*} </td>
</tr>
</table>
</form>
