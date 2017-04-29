<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<table cellSpacing=0 cellPadding=0 width="800" border=0>
<tr>
<td height=25>当前您的位置：<A 
href="/">首页</A> -- 产品搜索</td>
</tr>
<tr>
<td height=1></td>
</tr>
<tr>
<td vAlign=top>
<form name="form2" method="post" action="/Product/Redirect" onSubmit="javascript:Check();">
<h3>产品搜索：
<input name="keyword" type="text" id="keyword" size="40">
<select id="class_id" name="class_id">
<option value="0" selected="selected">所有分类</option>
{*html_options options=$option*}
</select>
<input type="submit" name="Submit2" value=" 搜 索 ">
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
  <td>价格：<span style="TEXT-DECORATION: line-through;COLOR: #787878; ">{*$uu[F_PRODUCT_PRICE]*}</span></td>
</tr>
<tr align=middle height=20>
  <td>折扣价：<font color="red">{*$uu[F_PRODUCT_LOW_PRICE]*}</font></td>
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
 * 功能：检测表单提交项
 */
function Check()
{
	if($('keyword').value.trim() == '')									//判断搜索关键字是否为空
	{
		alert('请填写关键字');
		$('keyword').focus();
		return false;
	}
	return true;
}
</script>
