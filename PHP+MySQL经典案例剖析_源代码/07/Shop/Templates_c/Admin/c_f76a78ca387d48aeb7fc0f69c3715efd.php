<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<table width="85%" border="0" align="center">
  <tr> 
    <th align="left">基本信息</th>
  </tr>
  <tr> 
    <td><table width="85%" border="0" align="center" cellpadding="0">
        <tr> 
          <td bgcolor="#999999"> <table width="100%" border="0" cellpadding="2" cellspacing="1">
              <tr bgcolor="#FFFFFF"> 
                <td width="80" align="right"><strong>类别名：</strong></td>
                <td class="stress"><?php echo $this->_vars['info']['F_CLASS_NAME']; ?>
</td>
                <td width="70">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="right"><strong>子类别数量：</strong></td>
                <td><?php echo $this->_vars['sub_count']; ?>
</td>
                <td><strong>产品数量：</strong></td>
                <td><?php echo $this->_vars['product_count']; ?>
</td>
              </tr>
            </table></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <th align="left">子<strong>类别</strong>列表 </th>
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
	  <li>无子类别</li>
	  <?php endif; ?>
	  </ul>
    </table></td>
  </tr>
  <tr> 
    <th align="left">显示参数</th>
  </tr>
  <tr> 
    <td align="left"><table width="85%" border="0" align="center" cellpadding="0">
        <tr> 
          <td bgcolor="#999999"> <table width="100%" border="0" cellpadding="2" cellspacing="1">
              <tr bgcolor="#FFFFFF"> 
                <td width="70">标志图片</td>
                <td><?php echo $this->_vars['img']; ?>
</td>
                <td width="70">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td>产品预览图片</td>
                <td><?php echo $this->_vars['small_img_display']; ?>
</td>
                <td>产品图片</td>
                <td><?php echo $this->_vars['big_img_display']; ?>
</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td>每页产品数</td>
                <td><?php echo $this->_vars['pagesize']; ?>
</td>
                <td>每行产品数</td>
                <td><?php echo $this->_vars['perline']; ?>
</td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td class="stress">注：产品预览图片尺寸、产品图片尺寸、每行产品数等为红色时，为用户定义值，为黑色，则为系统默认值。若要修改默认参数，请选择主菜单中的“配置管理”进行设置。</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <th align="left">产品属性</th>
  </tr>
  <tr> 
    <td align="left"><table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td bgcolor="#999999"> <table width="100%" border="0" cellpadding="2" cellspacing="1">
              <tr align="center" bgcolor="#CCCCCC"> 
                <td width="350">参数项</td>
                <td>字段名</td>
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
    <th align="left">管理操作</th>
  </tr>
  <tr> 
    <td align="center"> <input name="edit" type="button" onClick="window.location='/Class/Edit/Id/<?php echo $this->_vars['info']['F_ID']; ?>
'" value="修改类别"> 
      <input name="Submit33" type="button" onClick="javascript:Delete()" value="删除类别"> 
      <input name="add" type="submit" id="add" value="新建子类别" onClick="window.location='/Class/Add/ParentId/<?php echo $this->_vars['info']['F_ID']; ?>
'"> 
<input name="Submit32" type="button" onClick="window.location='/Class/Order/Id/<?php echo $this->_vars['info']['F_ID']; ?>
'" value="设置产品顺序">
      <input name="Submit" type="button" onClick="window.location='/Class/Config/Id/<?php echo $this->_vars['info']['F_ID']; ?>
'" value="设置显示参数"> 
      <input name="Submit2" type="button" onClick="window.location='/Class/Property/Id/<?php echo $this->_vars['info']['F_ID']; ?>
'" value="产品属性管理"> 
    </td>
  </tr>
  <tr> 
    <th align="left">&nbsp;</th>
  </tr>
</table>
<script language="javascript">
/**
 * 转向类别删除页面
 */
function Delete()
{
	if(confirm('真的要删除类别吗？'))								//判断用户是否确认删除
		window.location='/Class/Delete/Id/<?php echo $this->_vars['info']['F_ID']; ?>
';
}
</script>
