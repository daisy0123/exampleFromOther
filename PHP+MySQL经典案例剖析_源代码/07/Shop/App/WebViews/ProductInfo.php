<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<form id=form1 name=form1 action="/Product/SendMessage?Back=' + encodeURIComponent(location.pathname) + '" method=post onSubmit="javascript:Check();">        
<table cellSpacing=0 cellPadding=0 width="600" border=0>
<tr vAlign=top>
<td width=290>
<table cellSpacing=0 cellPadding=5 width="100%" border=0>
<tr>
<td align=middle width=120>{*if $info[F_PRODUCT_BIG_IMG]*}<a href="{*$path*}{*$info[F_PRODUCT_BIG_IMG]*}" 
target=_blank><img height=127 
src="{*$path*}{*$info[F_PRODUCT_BIG_IMG]*}" 
width=95 border=0></a>{*else*}<img height=127 
src="/Images/no-photo.gif" 
width=95 border=0>{*/if*}</td>
<td 
class=line_h20><B>����</B>��{*$info[F_PRODUCT_NAME]*}
<BR>
{*foreach item=uu from=$property*}
<B>{*$uu[F_CAPTION]*}</B>��{*$uu[F_VALUE]*}<BR>
{*/foreach*}
<B>�г���</B>����{*$info[F_PRODUCT_PRICE]*}<BR>
<B>�̳Ǽ�</B>����{*$info[F_PRODUCT_LOW_PRICE]*}<br>
<input type="button" name="Submit4" value="���빺�ﳵ" onClick="javascript:Cart({*$info[F_ID]*})"></td>
</tr>
<tr>
<td align=middle>{*if $info[F_PRODUCT_BIG_IMG]*}<a 
href="{*$path*}{*$info[F_PRODUCT_BIG_IMG]*}" 
target=_blank>�������ͼ</a>{*/if*}</td>
<td>&nbsp;</td></tr></table></td>
</tr></table>
<table cellSpacing=0 cellPadding=8 width="600" border=0>
<tr>
<td class=font11 width=116>��Ʒ���</td></tr></table>
<table cellSpacing=12 cellPadding=0 width="600" border=0>
<tr>
<td height=2>{*$info[F_PRODUCT_DESCRIPTION]|nl2br*}</td>
</tr></table>
<table cellSpacing=0 cellPadding=8 width="600" border=0>
<tr>
<td class=font11>�û�����</td>
<td align=right>&nbsp;</td></tr></table>
<table cellSpacing=10 cellPadding=0 width="600" border=0>
<tr>
<td>
<table width="100%" border="0">
{*if $isLogin == 1*}
<tr>
<td width="24%">�û�����</td>
<td colspan="2">{*$_TPL[SESSION][User][F_LOGIN_NAME]*}</td>
</tr>
{*else*}
<tr>
<td width="24%">�û�����</td>
<td colspan="2"><input name="name" type="text" id="name">
<font color="red">*</font></td>
</tr>
<tr>
<td>�ܡ��룺</td>
<td colspan="2"><input name="password" type="password" id="password">
<font color="red">*</font></td>
</tr>
{*/if*}
<tr>
<td valign="top">�ڡ��ݣ�</td>
<td colspan="2"><textarea name="content" cols="50" rows="8" id="content"></textarea>
<font color="red">*</font></td>
</tr>
<tr>
<td>��֤�룺</td>
<td width="17%" valign="middle"><input name="verify" type="text" id="verify" size="10"></td>
<td width="59%" valign="middle"><img src="/Index/GetVerifyImg" style="cursor: pointer" onclick="this.src='/Index/GetVerifyImg';" title="�翴�����,�����˴���һ��" border="1"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2"><input type="submit" name="Submit3" value="�ύ">
  <input name="id" type="hidden" id="id" value="{*$info[F_ID]*}" /></td>
</tr>
</table></td></tr></table>
</form>
<script language="javascript">
/**
 * ���ܣ�������
 */
function Check()
{
	{*if $isLogin == 0*}											//�ж��Ƿ��ѵ�½
	if($('name').value.trim() == '')									//�ж��û����Ƿ�Ϊ��
	{
		alert('�û�������Ϊ��');
		$('name').focus();
		return false;
	}
	if($('password').value == '')									//�ж������Ƿ�Ϊ��
	{
		alert('���벻��Ϊ��');
		$('password').focus();
		return false;
	}
	{*/if*}
	if($('content').value == '')										//�ж������Ƿ�Ϊ��
	{
		alert('���ݲ���Ϊ��');
		$('content').focus();
		return false;
	}
	if($('verify').value.trim() == '')										//�ж���֤���Ƿ�Ϊ��
	{
		alert('��֤�벻��Ϊ��');
		$('verify').focus();
		return false;
	}	
	return true;
}
/**
 * ���ܣ��򿪹��ﳵ����
 */
function Cart(ID)
{
	window.open('/Cart/AddCart/Id/'+ ID, 'cart', 'height=100,width=400,toolbar=yes,menubar=yes,scrollbars=yes, resizable=yes,location=yes,status=yes')
}
</script>
