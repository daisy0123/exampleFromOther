<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<table width="85%" border="0" align="center">
  <tr> 
    <th align="left">������Ϣ</th>
  </tr>
  <tr> 
    <td><table width="85%" border="0" align="center" cellpadding="0">
        <tr> 
          <td bgcolor="#999999"> <table width="100%" border="0" cellpadding="2" cellspacing="1">
              <tr bgcolor="#FFFFFF"> 
                <td width="80" align="right"><strong>�������</strong></td>
                <td class="stress"><?php echo $this->_vars['info']['F_CLASS_NAME']; ?>
</td>
                <td width="70">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="right"><strong>�����������</strong></td>
                <td><?php echo $this->_vars['sub_count']; ?>
</td>
                <td><strong>��Ʒ������</strong></td>
                <td><?php echo $this->_vars['product_count']; ?>
</td>
              </tr>
            </table></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <th align="left">��<strong>���</strong>�б� </th>
  </tr>
  <tr> 
    <td height="20"> 
      <table width='85%' border='0' align='center'>
	  <ul>
	  <?php if (count((array)$this->_vars['sub_class'])): foreach ((array)$this->_vars['sub_class'] as $this->_vars['uu']): ?>
	  <li><a href='/Class/Info/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
'><?php echo $this->_vars['uu']['F_CLASS_NAME']; ?>
</a></li>
	  <?php endforeach; else: ?>
	  <li>�������</li>
	  <?php endif; ?>
	  </ul>
    </table></td>
  </tr>
  <tr> 
    <th align="left">��ʾ����</th>
  </tr>
  <tr> 
    <td align="left"><table width="85%" border="0" align="center" cellpadding="0">
        <tr> 
          <td bgcolor="#999999"> <table width="100%" border="0" cellpadding="2" cellspacing="1">
              <tr bgcolor="#FFFFFF"> 
                <td width="70">��־ͼƬ</td>
                <td><?php echo $this->_vars['img']; ?>
</td>
                <td width="70">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td>��ƷԤ��ͼƬ</td>
                <td><?php echo $this->_vars['small_img_display']; ?>
</td>
                <td>��ƷͼƬ</td>
                <td><?php echo $this->_vars['big_img_display']; ?>
</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td>ÿҳ��Ʒ��</td>
                <td><?php echo $this->_vars['pagesize']; ?>
</td>
                <td>ÿ�в�Ʒ��</td>
                <td><?php echo $this->_vars['perline']; ?>
</td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td class="stress">ע����ƷԤ��ͼƬ�ߴ硢��ƷͼƬ�ߴ硢ÿ�в�Ʒ����Ϊ��ɫʱ��Ϊ�û�����ֵ��Ϊ��ɫ����ΪϵͳĬ��ֵ����Ҫ�޸�Ĭ�ϲ�������ѡ�����˵��еġ����ù����������á�</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <th align="left">��Ʒ����</th>
  </tr>
  <tr> 
    <td align="left"><table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td bgcolor="#999999"> <table width="100%" border="0" cellpadding="2" cellspacing="1">
              <tr align="center" bgcolor="#CCCCCC"> 
                <td width="350">������</td>
                <td>�ֶ���</td>
              </tr>
			  <?php if (count((array)$this->_vars['property'])): foreach ((array)$this->_vars['property'] as $this->_vars['uu']): ?>
              <tr bgcolor="#FFFFFF"> 
                <td><?php echo $this->_vars['uu']['F_PROPERTY_NAME']; ?>
</td>
                <td align="center"><?php echo $this->_vars['uu']['F_PROPERTY_FIELDNAME']; ?>
</td>
              </tr>			  
			  <?php endforeach; endif; ?>
            </table></td>
        </tr>
<?php if ($this->_vars['info']['F_CLASS_IS_DEFAULT_PROPERTY'] == 1 || $this->_vars['info']['F_CLASS_IS_PARENT_PROPERTY'] == 1): ?>
        <tr>
          <td bgcolor="#FFFFFF" class="stress"><?php echo $this->_vars['property_note']; ?>
</td>
        </tr>
<?php endif; ?>
      </table></td>
  </tr>
  <tr> 
    <th align="left">�������</th>
  </tr>
  <tr> 
    <td align="center"> <input name="edit" type="button" onClick="window.location='/Class/Edit/Id/<?php echo $this->_vars['info']['F_ID']; ?>
'" value="�޸����"> 
      <input name="Submit33" type="button" onClick="javascript:Delete()" value="ɾ�����"> 
      <input name="add" type="submit" id="add" value="�½������" onClick="window.location='/Class/Add/ParentId/<?php echo $this->_vars['info']['F_ID']; ?>
'"> 
<input name="Submit32" type="button" onClick="window.location='/Class/Order/Id/<?php echo $this->_vars['info']['F_ID']; ?>
'" value="���ò�Ʒ˳��">
      <input name="Submit" type="button" onClick="window.location='/Class/Config/Id/<?php echo $this->_vars['info']['F_ID']; ?>
'" value="������ʾ����"> 
      <input name="Submit2" type="button" onClick="window.location='/Class/Property/Id/<?php echo $this->_vars['info']['F_ID']; ?>
'" value="��Ʒ���Թ���"> 
    </td>
  </tr>
  <tr> 
    <th align="left">&nbsp;</th>
  </tr>
</table>
<script language="javascript">
/**
 * ת�����ɾ��ҳ��
 */
function Delete()
{
	if(confirm('���Ҫɾ�������'))								//�ж��û��Ƿ�ȷ��ɾ��
		window.location='/Class/Delete/Id/<?php echo $this->_vars['info']['F_ID']; ?>
';
}
</script>
