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
		<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['uu']): ?>
		<?php if ($this->_vars['uu']['F_CART_PRODUCT_COUNT']): ?>
        <tr bgColor=#ffffff>
          <td><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</td>
          <td align=middle><?php echo $this->_vars['uu']['F_CART_PRODUCT_COUNT']; ?>
</td>
          <td align=middle><?php echo $this->_vars['uu']['F_PRODUCT_PRICE']; ?>
Ԫ</td>
        </tr>
		<?php endif; ?>
		<?php endforeach; endif; ?>
        <tr bgColor=#ffffff>
          <td>�ܼ�</td>
          <td align=middle><?php echo $this->_vars['list']['COUNT']; ?>
</td>
          <td align=middle><?php echo $this->_vars['list']['SUM']; ?>
Ԫ</td>
        </tr>
	  </table>	</td>
  </tr>
  <tr>
    <th colSpan=2>&nbsp;
      <input type="button" name="Submit2" value="���ض����б�" onClick="javascript:window.history.back();" /></th>
  </tr>
 </table>
