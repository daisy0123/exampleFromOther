<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<table width="600" border=0 align="center" cellPadding=0 cellSpacing=0>
<tr>
<td height=25>当前您的位置：<a href="/">首页</a> -- <?php echo $this->_vars['info']['F_CLASS_NAME']; ?>
 </td>
</tr>
<tr>
<td height=1></td>
</tr>
<?php if (count((array)$this->_vars['list']['data'])): foreach ((array)$this->_vars['list']['data'] as $this->_vars['key'] => $this->_vars['uu']): ?>
<?php if ($this->_vars['key'] % $this->_vars['perline'] == 0): ?>
<tr>
<?php endif; ?>
<td vAlign=top width="<?php echo $this->_vars['td_width']; ?>
">
<table width="100%" border=0>
<tr>
<td>
<table align=center border=0>
<tr>
<td align=middle>
<a href="/Product/Info/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
" target="_blank"><img 
height=<?php echo $this->_vars['height']; ?>
 
src="<?php if ($this->_vars['uu']['F_PRODUCT_SMALL_IMG']):  echo $this->_vars['path'];  echo $this->_vars['uu']['F_PRODUCT_SMALL_IMG'];  else: ?>/Images/no-photo.gif<?php endif; ?>" 
width=<?php echo $this->_vars['width']; ?>
 border=0></a></td></tr>
<tr align=middle height=20>
<td bgColor=#464646><FONT 
color=#ffffff><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</FONT></td></tr>
<tr align=middle height=20>
  <td>价格：<span style="TEXT-DECORATION: line-through;COLOR: #787878; "><?php echo $this->_vars['uu']['F_PRODUCT_PRICE']; ?>
</span></td>
</tr>
<tr align=middle height=20>
  <td>折扣价：<font color="red"><?php echo $this->_vars['uu']['F_PRODUCT_LOW_PRICE']; ?>
</font></td>
</tr>
</table></td>
</tr></table>
</td>
<?php if ($this->_vars['key'] % $this->_vars['perline'] == $this->_vars['_perline']): ?>
</tr>
<?php endif; ?>
<?php endforeach; endif; ?>
<?php if (count((array)$this->_vars['data'])): foreach ((array)$this->_vars['data'] as $this->_vars['uu']): ?>
<?php echo $this->_vars['uu']; ?>

<?php endforeach; endif; ?>
</table>
<div id="page" style="width:800px;"><?php echo $this->_vars['list']['JumpBar']; ?>
</div>
