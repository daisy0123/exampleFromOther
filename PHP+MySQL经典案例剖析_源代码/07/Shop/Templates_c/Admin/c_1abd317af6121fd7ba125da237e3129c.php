<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">系统配置管理</p>
<table width="95%" border="0">
  <tr>
	<td height="80" valign="top" bgcolor="#eeeeee"> 
	  <table width="100%" border="0">
		<tr> 
		  <th width="250" height="23">配置项</th>
		  <th width="200">标识</th>
		  <th width="100">设置值</th>
		  <th>管理</th>
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
">修改</a></td>
		</tr>
		<?php endforeach; endif; ?>
	  </table>
	</td>
  </tr>
  <tr>
	<th align="center">&nbsp;</th>
  </tr>
</table>
