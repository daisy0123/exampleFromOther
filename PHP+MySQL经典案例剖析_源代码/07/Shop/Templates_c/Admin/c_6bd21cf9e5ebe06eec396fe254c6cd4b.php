<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">��Ʒ���Թ���</p>
<table width="85%" align="center">
<?php if ($this->_vars['classid'] > 0): ?>
  <tr>
  <td valign="top" class="stress">���<?php echo $this->_vars['info']['F_CLASS_NAME']; ?>
</td>
 </tr>
<?php else: ?>
  <tr>
  <td valign="top" class="stress">��𣺣�����������û���Զ������Ե����</td>
 </tr>
<?php endif; ?>
 <tr>
    <td height="80" valign="top" bgcolor="#eeeeee"> 
	  <table width="100%" align="center">
	<tr> 
	      <th>������</th>
	 <th width="150" height="23">�ֶ�����</th>
	 <th width="45">˳��</th>
	      <th width="60">����</th>
	</tr>
<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['uu']): ?>
	<tr> 
	 <td align="center"><?php echo $this->_vars['uu']['F_PROPERTY_NAME']; ?>
</td>
	 <td align="center"><?php echo $this->_vars['uu']['F_PROPERTY_FIELDNAME']; ?>
</td>
	 <td align="center"><?php echo $this->_vars['uu']['F_PROPERTY_ORDER']; ?>
</td>
	 <td align="center"><a href="/Class/PropertyAdd/ClassId/<?php echo $this->_vars['classid']; ?>
/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
">�༭</a> <a href="/Class/PropertyDel/ClassId/<?php echo $this->_vars['classid']; ?>
/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
">ɾ��</a></td>
	</tr>
<?php endforeach; endif; ?>
   </table></td>
 </tr>
 <tr>
  <th> 
   <input type="button" name="Submit" value="���Ӳ���" onclick="window.location='/Class/PropertyAdd/ClassId/<?php echo $this->_vars['classid']; ?>
'">
   <input type="button" name="Submit2" value="����˳��" onclick="window.location='/Class/PropertyOrder/ClassId/<?php echo $this->_vars['classid']; ?>
'">
   <input type="button" name="Submit22" value="����" onclick="window.location='/Class/Info/Id/<?php echo $this->_vars['classid']; ?>
''"></th>
 </tr>
</table>
