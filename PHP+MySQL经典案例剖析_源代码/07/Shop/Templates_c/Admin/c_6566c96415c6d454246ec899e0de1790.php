<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<script language="javascript" src="/Js/Ajax.js"></script>
<P class=caption>����²�Ʒ</P>
<form id=frm_add name=frm_add onSubmit="return check_data()" action="" method=post>
<table width="60%" align=center border=0>
<tr>
<th height=23>��ѡ���Ʒ</th></tr>
<tr>
<td align=middle bgColor=#eeeeee height=100>
<table width="70%" border=0>
<tr>
<td width="23%">��Ʒ���</td>
<td width="77%">
<select id=class_id onchange="javascript:query(this.options[selectedIndex].value);" name=class_id>
<option value=0>��ѡ�����</option>
<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['uu']): ?>
<option value="<?php echo $this->_vars['uu']['id']; ?>
"><?php echo $this->_vars['uu']['tree']; ?>
</option>
<?php endforeach; endif; ?>
</select> </td></tr>
<tr>
<td>��Ʒ</td>
<td><select id=product_id name=product_id>
<option value=0>��ѡ��</option>
</select></td>
</tr>
</table>
</td>
</tr>
<tr>
<th><input id=add type=submit value=�ύ name=add> <input id=cmdBack onclick=javascript:history.back() type=button value=���� name=cmdBack></th>
</tr>
</table>
</form>
<script language=JavaScript>
/**
 * ������
 */
function check_data(){
	if ($('product_id').value == 0){							//�ж��Ƿ�ѡ���˲�Ʒ
		alert("��û��ѡ���Ʒ");
		$('class_id').focus();
		return false;
	}
	return true;
}
</script>
