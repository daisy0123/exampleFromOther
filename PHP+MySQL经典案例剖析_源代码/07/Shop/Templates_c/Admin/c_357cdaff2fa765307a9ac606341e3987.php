<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">产品类别排列顺序</p>
<form name="form1" method="post" action="">
<table width="75%" align="center">
<tr> 
  <td height="80" valign="top" bgcolor="#eeeeee"> 
	<table width="100%" align="center">
 <tr> 
  <th width="50">ID</th>
  <th width="80">图片</th>
  <th width="200" height="23">类别</th>
  <th width="50">顺序</th>
 </tr>
<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['uu']): ?>
 <tr> 
  <td align="center"><input type='hidden' name='SelId[]' value='<?php echo $this->_vars['uu']['F_ID']; ?>
'>
  <?php echo $this->_vars['uu']['F_ID']; ?>
</td>
  <td align="center">
  <?php if ($this->_vars['uu']['F_CLASS_IMG']): ?>
  <img src="<?php echo $this->_vars['path'];  echo $this->_vars['uu']['F_CLASS_IMG']; ?>
" width="100" height="75" />
  <?php else: ?>
  无
  <?php endif; ?>
  </td>
  <td align="center"><?php echo $this->_vars['uu']['F_CLASS_NAME']; ?>
</td>
  <td align="center"><input name="Order[]" type="text" value="<?php echo $this->_vars['uu']['F_CLASS_ORDER']; ?>
" size="15">
  </td>
 </tr>
<?php endforeach; endif; ?>
</table></td>
</tr>
<tr> 
<th><input type="submit" name="Submit" value="提交">
	<input name="cmdBack" type="button" id="cmdBack" value="返回" onclick="javascript:window.history.back()"></th>
</tr>
</table>
</form>
