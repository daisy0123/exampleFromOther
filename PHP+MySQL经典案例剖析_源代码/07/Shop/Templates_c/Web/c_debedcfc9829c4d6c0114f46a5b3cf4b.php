<link href="/Style/index.css" rel="stylesheet" type="text/css">
<table width="800">
<tr>
<td width="313" height=25>��Ʒ����</td>
<td width="203" height=25>��Ʒ����</td>
<td width="268">��Ʒ�۸�</td>
</tr>
<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['uu']): ?>
<tr>
<td><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</td>
<td><?php echo $this->_vars['uu']['F_CART_PRODUCT_COUNT']; ?>
</td>
<td><?php echo $this->_vars['uu']['F_PRODUCT_PRICE']; ?>
Ԫ</td>
</tr>
<?php endforeach; endif; ?>
<tr>
<td>�ܼƣ�</td>
<td><?php echo $this->_vars['list']['COUNT']; ?>
</td>
<td><?php echo $this->_vars['list']['SUM']; ?>
Ԫ</td>
</tr>
</table>
