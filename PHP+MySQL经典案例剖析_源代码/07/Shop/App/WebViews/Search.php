<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<table cellSpacing=0 cellPadding=0 width="800" border=0>
<tr>
<td height=25>��ǰ����λ�ã�<A 
href="/">��ҳ</A> -- ��Ʒ����</td>
</tr>
<tr>
<td height=1></td>
</tr>
<tr>
<td vAlign=top>
<form name="form2" method="post" action="/Product/Redirect" onSubmit="javascript:Check();">
<h3>��Ʒ������
<input name="keyword" type="text" id="keyword" size="40">
<select id="class_id" name="class_id">
<option value="0" selected="selected">���з���</option>
{*html_options options=$option*}
</select>
<input type="submit" name="Submit2" value=" �� �� ">
</h3>
</form></td>
</tr>
{*foreach item=uu key=key from=$list[data]*}
{*if $key mod $perline == 0*}
<tr>
{*/if*}
<td vAlign=top width="{*$td_width*}">
<table width="100%" border=0>
<tr>
<td>
<table align=center border=0>
<tr>
<td align=middle>
<a href="/Product/Info/Id/{*$uu[F_ID]*}" target="_blank"><img 
height={*$height*} 
src="{*if $uu[F_PRODUCT_SMALL_IMG]*}{*$path*}{*$uu[F_PRODUCT_SMALL_IMG]*}{*else*}/Images/no-photo.gif{*/if*}" 
width={*$width*} border=0></a></td></tr>
<tr align=middle height=20>
<td bgColor=#464646><FONT 
color=#ffffff>{*$uu[F_PRODUCT_NAME]*}</FONT></td></tr>
<tr align=middle height=20>
  <td>�۸�<span style="TEXT-DECORATION: line-through;COLOR: #787878; ">{*$uu[F_PRODUCT_PRICE]*}</span></td>
</tr>
<tr align=middle height=20>
  <td>�ۿۼۣ�<font color="red">{*$uu[F_PRODUCT_LOW_PRICE]*}</font></td>
</tr>
</table></td>
</tr></table>
</td>
{*if $key mod $perline == $_perline*}
</tr>
{*/if*}
{*/foreach*}
{*foreach item=uu from=$data*}
{*$uu*}
{*/foreach*}
</table>
<div id="page" style="width:800px;">{*$list[JumpBar]*}</div>
<script language="javascript">
/**
 * ���ܣ������ύ��
 */
function Check()
{
	if($('keyword').value.trim() == '')									//�ж������ؼ����Ƿ�Ϊ��
	{
		alert('����д�ؼ���');
		$('keyword').focus();
		return false;
	}
	return true;
}
</script>
