<link href="/Style/index.css" rel="stylesheet" type="text/css">
<table width="800">
<tr>
<td width="313" height=25>��Ʒ����</td>
<td width="203" height=25>��Ʒ����</td>
<td width="268">��Ʒ�۸�</td>
</tr>
{*foreach item=uu from=$list*}
{*if $uu[F_CART_PRODUCT_COUNT] > 0*}
<tr>
<td>{*$uu[F_PRODUCT_NAME]*}</td>
<td>{*$uu[F_CART_PRODUCT_COUNT]*}</td>
<td>{*$uu[F_PRODUCT_PRICE]*}Ԫ</td>
</tr>
{*/if*}
{*/foreach*}
<tr>
<td>�ܼƣ�</td>
<td>{*$list[COUNT]*}</td>
<td>{*$list[SUM]*}Ԫ</td>
</tr>
</table>
