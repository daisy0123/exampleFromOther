<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">ϵͳ���ù���</p>
<table width="95%" border="0">
  <tr>
	<td height="80" valign="top" bgcolor="#eeeeee"> 
	  <table width="100%" border="0">
		<tr> 
		  <th width="250" height="23">������</th>
		  <th width="200">��ʶ</th>
		  <th width="100">����ֵ</th>
		  <th>����</th>
		</tr>
		<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['uu']): ?>
		<tr> 
		  <td><?php echo $this->_vars['uu']['F_CONFIG_NOTE']; ?>
</td>
		  <td><?php echo $this->_vars['uu']['F_CONFIG_NAME']; ?>
</td>
		  <td align="center"><?php echo $this->_vars['uu']['F_CONFIG_VALUE']; ?>
</td>
		  <td align="center"><a href="/Config/Edit/Id/<?php echo $this->_vars['uu']['F_ID']; ?>
">�޸�</a></td>
		</tr>
		<?php endforeach; endif; ?>
	  </table>
	</td>
  </tr>
  <tr>
	<th align="center">&nbsp;</th>
  </tr>
</table>
