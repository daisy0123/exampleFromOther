<link href="/Style/index.css" rel="stylesheet" type="text/css">
<table width="800">
<tr>
<td width="313" height=25>产品名称</td>
<td width="203" height=25>产品数量</td>
<td width="268">产品价格</td>
</tr>
<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['uu']): ?>
<tr>
<td><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</td>
<td><?php echo $this->_vars['uu']['F_CART_PRODUCT_COUNT']; ?>
</td>
<td><?php echo $this->_vars['uu']['F_PRODUCT_PRICE']; ?>
元</td>
</tr>
<?php endforeach; endif; ?>
<tr>
<td>总计：</td>
<td><?php echo $this->_vars['list']['COUNT']; ?>
</td>
<td><?php echo $this->_vars['list']['SUM']; ?>
元</td>
</tr>
</table>
