<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<P class=caption>设置新产品顺序</P>
<form name=form1 action="" method=post>
<table width="70%" align=center border=0>
  <tr>
    <td vAlign=top bgColor=#eeeeee height=100>
      <table width="100%" border=0>
        <tr>
          <th width=150 height=23>产品类别</th>
          <th width=250>产品名称</th>
          <th>顺序</th></tr>
		<?php if (count((array)$this->_vars['list']['data'])): foreach ((array)$this->_vars['list']['data'] as $this->_vars['uu']): ?>
        <tr>
          <td height=23 align="center"><?php echo $this->_vars['uu']['F_CLASS_NAME']; ?>
 
            <input name="id[]" type="hidden" id="id[]" value="<?php echo $this->_vars['uu']['F_ID']; ?>
"></td>
          <td align="center"><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</td>
          <td align="center"><input name="order[]" type="text" id="order[]" value="<?php echo $this->_vars['uu']['F_NEW_ORDER']; ?>
"></td>
        </tr>
		<?php endforeach; endif; ?>
        </table></td></tr>
  <tr>
    <th><input id=cmdOk type=submit value=提交 name=cmdOk> <input id=cmdBack onclick=javascript:history.back() type=button value=返回 name=cmdBack></th></tr></table>
<table width="70%" border="0" align="center">
  <tr>
    <td><?php echo $this->_vars['list']['JumpBar']; ?>
</td>
  </tr>
</table>
</form>
