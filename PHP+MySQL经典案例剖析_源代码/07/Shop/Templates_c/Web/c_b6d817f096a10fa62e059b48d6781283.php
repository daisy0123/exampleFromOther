<table width="100%" border="0">
<tr>
<td height="30" align="center"><strong>�ҵĹ��ﳵ</strong></td>
</tr>
</table>
<form name=form1 action="/Cart/UpdateCount" method=post>
<table cellSpacing=0 cellPadding=0 width="70%" align=center border=0>
<tr>
<td bgColor=#eeeeee colSpan=3>
<table cellSpacing=1 cellPadding=1 width="100%" align=center border=0>
<tr align=middle bgColor=#eeeeee>
<td width="26%" height=25><FONT 
size=2>��Ʒ����</FONT></td>
<td width="18%"><FONT size=2>����</FONT></td>
<td width="20%"><FONT size=2><strong>��Ʒ�۸�</strong></FONT></td>
<td width="18%"><FONT size=2>ɾ��</FONT></td>
<td width="18%"><FONT size=2><strong>����</strong></FONT></td>
</tr>
<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['uu']): ?>
<tr align=middle bgColor=#ffffff>
<td height=25><FONT size=2><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</FONT>
<input type="hidden" name="id[]" value="<?php echo $this->_vars['uu']['F_ID']; ?>
" id="id[]">
</td>
<td><INPUT id="count[]" size=8 value="<?php echo $this->_vars['uu']['F_CART_PRODUCT_COUNT']; ?>
" name="count[]"></td>
<td><FONT size=2>
<?php if ($this->_vars['uu']['F_PRODUCT_LOW_PRICE']): ?>
<?php echo $this->_vars['uu']['F_PRODUCT_LOW_PRICE']; ?>

<?php else: ?>
<?php echo $this->_vars['uu']['F_PRODUCT_PRICE']; ?>

<?php endif; ?>Ԫ/��</FONT></td>
<td><INPUT onClick="javascript:window.location = '/Cart/DelProduct/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
'" type=button value=ɾ�� name=Submit></td>
<td><input type="submit" name="Submit" value="����"></td>
</tr>
<?php endforeach; endif; ?>
<tr align=middle bgColor=#ffffff>
<td colSpan=5
height=25><FONT size=2><strong>�ܼƣ�<?php echo $this->_vars['sum']; ?>
Ԫ</strong></FONT></td>
</tr></table></td></tr></table>
<table width="70%" align=center border=0>
<tr>
<td align=center><INPUT onclick=javascript:window.close() type=button value=�������� name=Submit2>&nbsp; 
<INPUT onClick="javascript:window.location='/Order'; " type=button value=�¶��� name=Submit3>
&nbsp; <INPUT onClick="javascript:window.location='/Cart/Truncate'" type=button value=��չ��ﳵ name=Submit4></td>
</tr>
</table>
</form>
