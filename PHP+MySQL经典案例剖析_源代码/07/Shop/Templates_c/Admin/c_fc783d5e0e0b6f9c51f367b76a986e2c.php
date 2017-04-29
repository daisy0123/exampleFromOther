<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<P class=caption>设置产品属性顺序</P>
<form name=form1 action="" method=post>
<table width="75%" align=center>
<tr>
<td vAlign=top height=50>
<table width="100%" align=center>
<tr>
<th width=300>属性名称</th>
<th width=150 height=23>字段名称</th>
<th>顺序值</th></tr>
<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['uu']): ?>
<tr>
<td align="center"><?php echo $this->_vars['uu']['F_PROPERTY_NAME']; ?>
<input type="hidden" name="id[]" value="<?php echo $this->_vars['uu']['F_ID']; ?>
" /></td>
<td height=23 align="center"><?php echo $this->_vars['uu']['F_PROPERTY_FIELDNAME']; ?>
</td>
<td align="center"><input name="order[]" type="text" value="<?php echo $this->_vars['uu']['F_PROPERTY_ORDER']; ?>
" size="15"></td>
</tr>
<?php endforeach; endif; ?>
</table>
</td>
</tr>
<tr>
<th>
<input type=submit value=提交 name=Submit>
</th>
</tr>
</table>
</form>
