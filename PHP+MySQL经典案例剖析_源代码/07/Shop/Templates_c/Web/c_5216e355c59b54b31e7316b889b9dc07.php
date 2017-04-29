<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<table width="800" border="0">
<?php if (count((array)$this->_vars['list']['data'])): foreach ((array)$this->_vars['list']['data'] as $this->_vars['key'] => $this->_vars['uu']): ?>
<?php if ($this->_vars['key'] % $this->_vars['perline'] == 0): ?>
<tr align='center'>
<?php endif; ?>
<td width='<?php echo $this->_vars['td_width']; ?>
'><table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">&nbsp;</td>
    <td align="left"><a href="/Product/Info/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
" target="_blank"><img src="<?php if ($this->_vars['uu']['F_PRODUCT_SMALL_IMG']):  echo $this->_vars['path'];  echo $this->_vars['uu']['F_PRODUCT_SMALL_IMG'];  else: ?>/Images/no-photo.gif<?php endif; ?>" height="<?php echo $this->_vars['height']; ?>
" width="<?php echo $this->_vars['width']; ?>
" border="1" style="border-color:#000000 " /></a></td>
  </tr>
  <tr>
    <td width="14%">&nbsp;</td>
    <td width="86%" height="20">类别：<a href="/Product/List/Id/<?php echo $this->_vars['uu']['CLASS_ID']; ?>
"><?php echo $this->_vars['uu']['F_CLASS_NAME']; ?>
</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="20">产品：<a href="/Product/Info/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
" target="_blank"><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</a></td>
  </tr>
  <tr height="20">
    <td width="14%">&nbsp;</td>
    <td>价格：<span style="TEXT-DECORATION: line-through;COLOR: #787878; "><?php echo $this->_vars['uu']['F_PRODUCT_PRICE']; ?>
</span></td>
  </tr>
  <tr height="20">
    <td width="14%">&nbsp;</td>
    <td>折扣价：<font color="red"><?php echo $this->_vars['uu']['F_PRODUCT_LOW_PRICE']; ?>
</font></td>
  </tr>
</table></td>
<?php if ($this->_vars['key'] % $this->_vars['perline'] == $this->_vars['_perline']): ?>
</tr>
<?php endif; ?>
<?php endforeach; else: ?>
<tr>
  <td>暂时无数据</td>
</tr>
<?php endif; ?>
<?php if ($this->_vars['list']['data']): ?>
<?php if (count((array)$this->_vars['data'])): foreach ((array)$this->_vars['data'] as $this->_vars['uu']): ?>
<?php echo $this->_vars['uu']; ?>

<?php endforeach; endif; ?>
<?php endif; ?>
</table>
<div id="page" style="width:800px"><?php echo $this->_vars['list']['JumpBar']; ?>
</div>
