<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<table cellSpacing=0 width="95%" align=center border=0>
  <tr>
    <td class=caption colSpan=2>订 单 详 情 </td>
  </tr>
  <tr>
    <td colSpan=2>
      <table width="100%" border=0>
        <tr>
          <th>产品名称</th>
          <th>产品数量</th>
          <th>产品价格</th>
          </tr>
		<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['uu']): ?>
		<?php if ($this->_vars['uu']['F_CART_PRODUCT_COUNT']): ?>
        <tr bgColor=#ffffff>
          <td><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</td>
          <td align=middle><?php echo $this->_vars['uu']['F_CART_PRODUCT_COUNT']; ?>
</td>
          <td align=middle><?php echo $this->_vars['uu']['F_PRODUCT_PRICE']; ?>
元</td>
        </tr>
		<?php endif; ?>
		<?php endforeach; endif; ?>
        <tr bgColor=#ffffff>
          <td>总计</td>
          <td align=middle><?php echo $this->_vars['list']['COUNT']; ?>
</td>
          <td align=middle><?php echo $this->_vars['list']['SUM']; ?>
元</td>
        </tr>
	  </table>	</td>
  </tr>
  <tr>
    <th colSpan=2>&nbsp;
      <input type="button" name="Submit2" value="返回订单列表" onClick="javascript:window.history.back();" /></th>
  </tr>
 </table>
