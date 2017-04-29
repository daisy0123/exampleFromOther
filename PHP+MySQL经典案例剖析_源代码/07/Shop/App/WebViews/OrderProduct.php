<link href="/Style/index.css" rel="stylesheet" type="text/css">
<table width="800">
<tr>
<td width="313" height=25>产品名称</td>
<td width="203" height=25>产品数量</td>
<td width="268">产品价格</td>
</tr>
{*foreach item=uu from=$list*}
{*if $uu[F_CART_PRODUCT_COUNT] > 0*}
<tr>
<td>{*$uu[F_PRODUCT_NAME]*}</td>
<td>{*$uu[F_CART_PRODUCT_COUNT]*}</td>
<td>{*$uu[F_PRODUCT_PRICE]*}元</td>
</tr>
{*/if*}
{*/foreach*}
<tr>
<td>总计：</td>
<td>{*$list[COUNT]*}</td>
<td>{*$list[SUM]*}元</td>
</tr>
</table>
