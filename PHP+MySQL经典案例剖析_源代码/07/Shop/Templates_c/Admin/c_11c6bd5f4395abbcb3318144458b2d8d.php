<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">��Ʒ����</p>
<form name="form1" method="post" action="">
  <table width="95%" align="center">
    <tr>
      <td valign="top" class="stress">���<?php echo $this->_vars['class']['F_CLASS_NAME']; ?>
</td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#eeeeee"><table width="100%" align="center">
          <tr>
            <th width="27"><input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
            <th width="61" height="23">ID</th>
            <th width="274">��Ʒ����</th>
            <th width="68">СͼƬ</th>
            <th width="62">��ͼƬ</th>
            <th width="83">˳��</th>
            <th width="194">����</th>
          </tr>
        <?php if (count((array)$this->_vars['list']['data'])): foreach ((array)$this->_vars['list']['data'] as $this->_vars['uu']): ?>
        <tr>
          <td align="center"><input type='checkbox' name='SelId[]' value='<?php echo $this->_vars['uu']['F_ID']; ?>
'></td>
          <td align="center"><?php echo $this->_vars['uu']['F_ID']; ?>
</td>
          <td align="center"><?php echo $this->_vars['uu']['F_PRODUCT_NAME']; ?>
</td>
          <td align="center">
		  <?php if ($this->_vars['uu']['F_PRODUCT_SMALL_IMG']): ?>
		  <a href="<?php echo $this->_vars['path'];  echo $this->_vars['uu']['F_PRODUCT_SMALL_IMG']; ?>
" target="_blank"><img src="<?php echo $this->_vars['path'];  echo $this->_vars['uu']['F_PRODUCT_SMALL_IMG']; ?>
" width="100" height="50"></a>
		  <?php else: ?>
		  ��
		  <?php endif; ?>
		  </td>
          <td align="center">
		  <?php if ($this->_vars['uu']['F_PRODUCT_BIG_IMG']): ?>
		  <a href="<?php echo $this->_vars['path'];  echo $this->_vars['uu']['F_PRODUCT_BIG_IMG']; ?>
" target="_blank"><img src="<?php echo $this->_vars['path'];  echo $this->_vars['uu']['F_PRODUCT_BIG_IMG']; ?>
" width="100" height="50"></a>
		  <?php else: ?>
		  ��
		  <?php endif; ?>
		  </td>
          <td align="center"><?php echo $this->_vars['uu']['F_PRODUCT_ORDER']; ?>
</td>
          <td align="center"><a href="/Product/Edit/ClassId/<?php echo $this->_vars['class']['F_ID']; ?>
/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
">�༭</a>
		   <a href="/Product/Pic/ClassId/<?php echo $this->_vars['class']['F_ID']; ?>
/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
">ͼƬ����</a></td>
        </tr>
        <?php endforeach; else: ?>
		<tr align='center'><td height='30' colspan='6'>��ҳû�в�Ʒ��Ϣ</td></tr>
		<?php endif; ?>
      </table></td>
    </tr>
    <tr>
      <th> <input type="button" name="Submit" value="���Ӳ�Ʒ" onClick="window.location='/Product/Add/ClassId/<?php echo $this->_vars['class']['F_ID']; ?>
'">
          <input type="button" name="Submit2" value="����˳��" onClick="window.location='/Product/Order/ClassId/<?php echo $this->_vars['class']['F_ID']; ?>
'">
		  <input type="submit" name="Submit3" value="ɾ����Ʒ" onClick="window.location='/Product/Order/ClassId/<?php echo $this->_vars['class']['F_ID']; ?>
'">
      </th>
    </tr>
  </table>
  <table width="95%" border="0" align="center">
    <tr>
      <td><?php echo $this->_vars['list']['JumpBar']; ?>
</td>
    </tr>
  </table>
</form>
<script language="javascript">
/**
 * ʵ��ȫѡ����
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
</script>
