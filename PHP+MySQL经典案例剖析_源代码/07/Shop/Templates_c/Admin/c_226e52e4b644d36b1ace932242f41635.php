<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">产品排列顺序</p>
<form name="form1" method="post" action="">
 <table width="75%" align="center">
  <tr> 
   <td valign="top" class="stress">类别：<?php echo $this->_vars['info']['F_CLASS_NAME']; ?>
</td>
  </tr>
  <tr> 
   <td height="80" valign="top"> <table width="100%" align="center">
	 <tr> 
	  <th width="50" height="23">ID</th>
	  <th width="250">产品名称</th>
	  <th>顺序管理</th>
	 </tr>
	 <?php if (count((array)$this->_vars['list']['data'])): foreach ((array)$this->_vars['list']['data'] as $this->_vars['uu']): ?>
	 <tr> 
	  <td align="center"><input type='hidden' name='SelId[]' value='<?php echo $this->_vars['uu']['F_ID']; ?>
'><?php echo $this->_vars['uu']['F_ID']; ?>
</td>
	  <td align="center"><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</td>
	  <td align="center"> <input name="order[]" type="text" value="<?php echo $this->_vars['uu']['F_PRODUCT_ORDER']; ?>
" size="15"></td>
	 </tr>
	 <?php endforeach; endif; ?>
	</table></td>
  </tr>
  <tr> 
   <th><input type="submit" name="Submit" value="提交">
     <input type="button" name="Submit2" value="返回" onClick="javascript:window.location='/Product/Index/ClassId/<?php echo $this->_vars['classid']; ?>
'"></th>
  </tr>
 </table>
<table width="75%" border="0" align="center">
<tr>
  <td><?php echo $this->_vars['list']['JumpBar']; ?>
</td>
</tr>
</table>
 </form>
