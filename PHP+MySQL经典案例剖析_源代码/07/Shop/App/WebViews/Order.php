<script language="javascript" src="/Js/Base.js"></script>
<table width="98%">
<tr align=right bgColor=#f5f5f5 height=26>
<td colSpan=3 height=25><img 
height=24 src="/images/cart.gif" width=142 
border=0></td>
</tr>
<tr bgColor=#f5f5f5 height=26>
<td colSpan=3 height=25><B>订购车中的产品：</B></td>
</tr>
<tr bgColor=#e3e3e3>
<td width="50%" height=25><B>产品名称</B></td>
<td align=middle width="20%" height=25><B>数量</B></td>
<td align=middle height=25><B>价格</B></td>
</tr>
{*foreach item=uu from=$list*}
<tr bgColor=#e3e3e3>
<td height=25>{*$uu[F_PRODUCT_NAME]*}</td>
<td align=middle height=25>{*$uu[F_CART_PRODUCT_COUNT]*}</td>
<td align=middle height=25>
{*if $uu[F_PRODUCT_LOW_PRICE]*}
{*$uu[F_PRODUCT_LOW_PRICE]*}
{*else*}
{*$uu[F_PRODUCT_PRICE]*}
{*/if*}</td>
</tr>
{*/foreach*}
<tr bgColor=#e3e3e3>
<td height=25 colspan="3"><b>总计：{*$sum*}元</b></td>
</tr>
</table>
<form action="/Order/Add" method="post" name="myform" onSubmit="return check();">
<table width="98%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#999999">
<tr align="center">
<td colspan="2" bgcolor="#EEEEEE">::: 订购信息 :::</td>
</tr>
<tr>
<td width="26%" align="right" bgcolor="#EEEEEE">联系姓名：</td>
<td width="74%" bgcolor="#FAFAFA"><input name="name" type="text" id="name" size="20" value="{*$info[F_USER_TRUENAME]*}">
<span class="STYLE1">*</span> 请输入联系人姓名 </td>
</tr>
<tr>
<td align="right" bgcolor="#EEEEEE">联系地址：</td>
<td bgcolor="#FAFAFA"><input name="address" type="text" id="address" size="50" value="{*$info[F_USER_ADDRESS]*}">
<span class="STYLE1">*</span> 请输入详细地址</td>
</tr>
<tr>
<td height="22" align="right" bgcolor="#EEEEEE">邮政编码：</td>
<td bgcolor="#FAFAFA"><input name="zipcode" type="text" id="zipcode" size="20" value="{*$info[F_USER_ZIPCODE]*}">
<span class="STYLE1">*</span> 请输入邮政编码</td>
</tr>
<tr>
<td align="right" bgcolor="#EEEEEE">联系电话：</td>
<td bgcolor="#FAFAFA"><input name="phone" type="text" id="phone" size="50" value="{*$info[F_USER_PHONE]*}">
<span class="STYLE1">*</span> 请输入联系电话</td>
</tr>
<tr>
<td align="right" bgcolor="#EEEEEE">家庭电话：</td>
<td bgcolor="#FAFAFA"><input name="home_phone" type="text" id="home_phone" size="50" value="{*$info[F_USER_HOME_PHONE]*}">
请输入家庭电话</td>
</tr>

<tr>
<td align="right" bgcolor="#EEEEEE">联系手机：</td>
<td bgcolor="#FAFAFA"><input name="mobile" type="text" id="mobile" size="20" value="{*$info[F_USER_MOBILE]*}">                    
请输入联系人的手机号码 </td>
</tr>
{*if $info[F_USER_TRUENAME] == ''*}
<tr>
<td align="right" bgcolor="#EEEEEE">是否做为用户资料保存：</td>
<td bgcolor="#FAFAFA"><input name="store" type="radio" value="1" checked>
是
<input name="store" type="radio" value="0">
否</td>
</tr>
{*/if*}
<tr>
<td align="right" bgcolor="#EEEEEE">备注：</td>
<td bgcolor="#FAFAFA"><textarea name="note" cols="50" rows="8" id="note"></textarea></td>
</tr>
<tr>
<td align="right" bgcolor="#EEEEEE">验证码：</td>
<td bgcolor="#FAFAFA"><input name="verify" type="text" id="verify" size="8"><span class="STYLE1">*</span>
<img src="/Index/GetVerifyImg" style="cursor: pointer" onclick="this.src='/Index/GetVerifyImg';" title="看不清验证码请点击" border="1"></td>
</tr>
<tr align="center">
<td colspan="2" bgcolor="#EEEEEE"><input type="submit" name="Submit" value="确定提交">
<input type="reset" name="Submit2" value="重新填写"></td>
</tr>
</table>
</form>
<script language="javascript">
/**
 * 功能：检测表单项
 */
function check()
{
	if($('name').value.trim() == '')									//判断联系人姓名是否为空
	{
		alert('联系人姓名不能为空');
		$('name').focus();
		return false;
	}
	if($('address').value.trim() == '')									//判断联系地址是否为空
	{
		alert('联系地址不能为空');
		$('address').focus();
		return false;
	}
	if($('zipcode').value.trim() == '')									//判断邮政编码是否为空
	{
		alert('邮政编码不能为空');
		$('zipcode').focus();
		return false;
	}
	if($('phone').value.trim() == '')									//判断联系电话是否为空
	{
		alert('联系电话不能为空');
		$('phone').focus();
		return false;
	}
	return true;
}
</script>
