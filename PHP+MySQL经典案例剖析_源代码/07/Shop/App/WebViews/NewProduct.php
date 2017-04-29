<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<table width="800" border="0">
{*foreach item=uu key=key from=$list[data]*}
{*if $key mod $perline == 0*}
<tr align='center'>
{*/if*}
<td width='{*$td_width*}'><table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">&nbsp;</td>
    <td align="left"><a href="/Product/Info/Id/{*$uu[F_ID]*}" target="_blank"><img src="{*if $uu[F_PRODUCT_SMALL_IMG]*}{*$path*}{*$uu[F_PRODUCT_SMALL_IMG]*}{*else*}/Images/no-photo.gif{*/if*}" height="{*$height*}" width="{*$width*}" border="1" style="border-color:#000000 " /></a></td>
  </tr>
  <tr>
    <td width="14%">&nbsp;</td>
    <td width="86%" height="20">类别：<a href="/Product/List/Id/{*$uu[CLASS_ID]*}">{*$uu[F_CLASS_NAME]*}</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="20">产品：<a href="/Product/Info/Id/{*$uu[F_ID]*}" target="_blank">{*$uu[F_PRODUCT_NAME]*}</a></td>
  </tr>
  <tr height="20">
    <td width="14%">&nbsp;</td>
    <td>价格：<span style="TEXT-DECORATION: line-through;COLOR: #787878; ">{*$uu[F_PRODUCT_PRICE]*}</span></td>
  </tr>
  <tr height="20">
    <td width="14%">&nbsp;</td>
    <td>折扣价：<font color="red">{*$uu[F_PRODUCT_LOW_PRICE]*}</font></td>
  </tr>
</table></td>
{*if $key mod $perline == $_perline*}
</tr>
{*/if*}
{*foreachelse*}
<tr>
  <td>暂时无数据</td>
</tr>
{*/foreach*}
{*if $list[data]*}
{*foreach item=uu from=$data*}
{*$uu*}
{*/foreach*}
{*/if*}
</table>
<div id="page" style="width:800px">{*$list[JumpBar]*}</div>
