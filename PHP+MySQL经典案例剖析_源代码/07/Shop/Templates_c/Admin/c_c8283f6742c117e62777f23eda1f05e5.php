<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<P class=caption>新产品管理</P>
<form name="form1" method="post" action="">
<table width="80%" align=center border=0>
<tr>
  <td vAlign=top bgColor=#eeeeee><table width="100%" border=0>
	  <tr>
		<th width=45><input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
		<th width=278 height=23>产品类别</th>
		<th width=267>产品名称</th>
		<th width=68>顺序</th>
	  </tr>
	  <?php if (count((array)$this->_vars['list']['data'])): foreach ((array)$this->_vars['list']['data'] as $this->_vars['uu']): ?>
	  <tr align=middle>
		<td><input name="SelId[]" type="checkbox" id="SelId[]" value="<?php echo $this->_vars['uu']['F_ID']; ?>
"></td>
		<td height=30><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</td>
		<td height=30><?php echo $this->_vars['uu']['F_CLASS_NAME']; ?>
</td>
		<td height=30><?php echo $this->_vars['uu']['F_NEW_ORDER']; ?>
</td>
	  </tr>
	  <?php endforeach; endif; ?>
  </table></td>
</tr>
<tr>
  <th><input id=order onClick="window.location='/Product/NewOrder'" type=button value=设置排列顺序 name=order>
	  <input id=add onClick="window.location='/Product/AddNew'" type=button value=添加新标识产品 name=add>
	  <input type="submit" name="Submit" value="删除新产品"></th>
</tr>
</table>
<table width="80%" border="0" align="center">
<tr>
  <td><?php echo $this->_vars['list']['JumpBar']; ?>
</td>
</tr>
</table>
</form>
<script language="javascript">
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
</script>
