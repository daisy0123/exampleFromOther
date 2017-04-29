<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<table width="600" border=0 align="center" cellPadding=0 cellSpacing=0>
<tr>
<td height=25>当前您的位置：<a href="/">首页</a> -- {*$info[F_CLASS_NAME]*} </td>
</tr>
<tr>
<td height=1></td>
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
