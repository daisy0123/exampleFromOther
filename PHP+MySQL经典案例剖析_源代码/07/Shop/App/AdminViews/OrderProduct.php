<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<table cellSpacing=0 width="95%" align=center border=0>
  <tr>
    <td class=caption colSpan=2>�� �� �� �� </td>
  </tr>
  <tr>
    <td colSpan=2>
      <table width="100%" border=0>
        <tr>
          <th>��Ʒ����</th>
          <th>��Ʒ����</th>
          <th>��Ʒ�۸�</th>
          </tr>
		{*foreach item=uu from=$list*}
		{*if $uu[F_CART_PRODUCT_COUNT]>0*}
        <tr bgColor=#ffffff>
          <td>{*$uu[F_PRODUCT_NAME]*}</td>
          <td align=middle>{*$uu[F_CART_PRODUCT_COUNT]*}</td>
          <td align=middle>{*$uu[F_PRODUCT_PRICE]*}Ԫ</td>
        </tr>
		{*/if*}
		{*/foreach*}
        <tr bgColor=#ffffff>
          <td>�ܼ�</td>
          <td align=middle>{*$list[COUNT]*}</td>
          <td align=middle>{*$list[SUM]*}Ԫ</td>
        </tr>
	  </table>	</td>
  </tr>
  <tr>
    <th colSpan=2>&nbsp;
      <input type="button" name="Submit2" value="���ض����б�" onClick="javascript:window.history.back();" /></th>
  </tr>
 </table>
