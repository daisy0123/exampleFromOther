<script language="javascript" src="/Js/Base.js"></script>
<table width="98%">
<tr align=right bgColor=#f5f5f5 height=26>
<td colSpan=3 height=25><img 
height=24 src="/images/cart.gif" width=142 
border=0></td>
</tr>
<tr bgColor=#f5f5f5 height=26>
<td colSpan=3 height=25><B>�������еĲ�Ʒ��</B></td>
</tr>
<tr bgColor=#e3e3e3>
<td width="50%" height=25><B>��Ʒ����</B></td>
<td align=middle width="20%" height=25><B>����</B></td>
<td align=middle height=25><B>�۸�</B></td>
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
<td height=25 colspan="3"><b>�ܼƣ�{*$sum*}Ԫ</b></td>
</tr>
</table>
<form action="/Order/Add" method="post" name="myform" onSubmit="return check();">
<table width="98%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#999999">
<tr align="center">
<td colspan="2" bgcolor="#EEEEEE">::: ������Ϣ :::</td>
</tr>
<tr>
<td width="26%" align="right" bgcolor="#EEEEEE">��ϵ������</td>
<td width="74%" bgcolor="#FAFAFA"><input name="name" type="text" id="name" size="20" value="{*$info[F_USER_TRUENAME]*}">
<span class="STYLE1">*</span> ��������ϵ������ </td>
</tr>
<tr>
<td align="right" bgcolor="#EEEEEE">��ϵ��ַ��</td>
<td bgcolor="#FAFAFA"><input name="address" type="text" id="address" size="50" value="{*$info[F_USER_ADDRESS]*}">
<span class="STYLE1">*</span> ��������ϸ��ַ</td>
</tr>
<tr>
<td height="22" align="right" bgcolor="#EEEEEE">�������룺</td>
<td bgcolor="#FAFAFA"><input name="zipcode" type="text" id="zipcode" size="20" value="{*$info[F_USER_ZIPCODE]*}">
<span class="STYLE1">*</span> ��������������</td>
</tr>
<tr>
<td align="right" bgcolor="#EEEEEE">��ϵ�绰��</td>
<td bgcolor="#FAFAFA"><input name="phone" type="text" id="phone" size="50" value="{*$info[F_USER_PHONE]*}">
<span class="STYLE1">*</span> ��������ϵ�绰</td>
</tr>
<tr>
<td align="right" bgcolor="#EEEEEE">��ͥ�绰��</td>
<td bgcolor="#FAFAFA"><input name="home_phone" type="text" id="home_phone" size="50" value="{*$info[F_USER_HOME_PHONE]*}">
�������ͥ�绰</td>
</tr>

<tr>
<td align="right" bgcolor="#EEEEEE">��ϵ�ֻ���</td>
<td bgcolor="#FAFAFA"><input name="mobile" type="text" id="mobile" size="20" value="{*$info[F_USER_MOBILE]*}">                    
��������ϵ�˵��ֻ����� </td>
</tr>
{*if $info[F_USER_TRUENAME] == ''*}
<tr>
<td align="right" bgcolor="#EEEEEE">�Ƿ���Ϊ�û����ϱ��棺</td>
<td bgcolor="#FAFAFA"><input name="store" type="radio" value="1" checked>
��
<input name="store" type="radio" value="0">
��</td>
</tr>
{*/if*}
<tr>
<td align="right" bgcolor="#EEEEEE">��ע��</td>
<td bgcolor="#FAFAFA"><textarea name="note" cols="50" rows="8" id="note"></textarea></td>
</tr>
<tr>
<td align="right" bgcolor="#EEEEEE">��֤�룺</td>
<td bgcolor="#FAFAFA"><input name="verify" type="text" id="verify" size="8"><span class="STYLE1">*</span>
<img src="/Index/GetVerifyImg" style="cursor: pointer" onclick="this.src='/Index/GetVerifyImg';" title="��������֤������" border="1"></td>
</tr>
<tr align="center">
<td colspan="2" bgcolor="#EEEEEE"><input type="submit" name="Submit" value="ȷ���ύ">
<input type="reset" name="Submit2" value="������д"></td>
</tr>
</table>
</form>
<script language="javascript">
/**
 * ���ܣ�������
 */
function check()
{
	if($('name').value.trim() == '')									//�ж���ϵ�������Ƿ�Ϊ��
	{
		alert('��ϵ����������Ϊ��');
		$('name').focus();
		return false;
	}
	if($('address').value.trim() == '')									//�ж���ϵ��ַ�Ƿ�Ϊ��
	{
		alert('��ϵ��ַ����Ϊ��');
		$('address').focus();
		return false;
	}
	if($('zipcode').value.trim() == '')									//�ж����������Ƿ�Ϊ��
	{
		alert('�������벻��Ϊ��');
		$('zipcode').focus();
		return false;
	}
	if($('phone').value.trim() == '')									//�ж���ϵ�绰�Ƿ�Ϊ��
	{
		alert('��ϵ�绰����Ϊ��');
		$('phone').focus();
		return false;
	}
	return true;
}
</script>
