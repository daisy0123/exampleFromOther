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
                <td class="stress">{*$info[F_CLASS_NAME]*}</td>
                <td width="70">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="right"><strong>子类别数量：</strong></td>
                <td>{*$sub_count*}</td>
                <td><strong>产品数量：</strong></td>
                <td>{*$product_count*}</td>
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
	  {*foreach item=uu from=$sub_class*}
	  <li><a href='/Class/Info/Id/{*$uu[F_ID]*}'>{*$uu[F_CLASS_NAME]*}</a></li>
	  {*foreachelse*}
	  <li>无子类别</li>
	  {*/foreach*}
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
                <td>{*$img*}</td>
                <td width="70">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td>产品预览图片</td>
                <td>{*$small_img_display*}</td>
                <td>产品图片</td>
                <td>{*$big_img_display*}</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td>每页产品数</td>
                <td>{*$pagesize*}</td>
                <td>每行产品数</td>
                <td>{*$perline*}</td>
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
			  {*foreach item=uu from=$property*}
              <tr bgcolor="#FFFFFF"> 
                <td>{*$uu[F_PROPERTY_NAME]*}</td>
                <td align="center">{*$uu[F_PROPERTY_FIELDNAME]*}</td>
              </tr>			  
			  {*/foreach*}
            </table></td>
        </tr>
{*if $info[F_CLASS_IS_DEFAULT_PROPERTY] == 1 || $info[F_CLASS_IS_PARENT_PROPERTY] == 1*}
        <tr>
          <td bgcolor="#FFFFFF" class="stress">{*$property_note*}</td>
        </tr>
{*/if*}
      </table></td>
  </tr>
  <tr> 
    <th align="left">管理操作</th>
  </tr>
  <tr> 
    <td align="center"> <input name="edit" type="button" onClick="window.location='/Class/Edit/Id/{*$info[F_ID]*}'" value="修改类别"> 
      <input name="Submit33" type="button" onClick="javascript:Delete()" value="删除类别"> 
      <input name="add" type="submit" id="add" value="新建子类别" onClick="window.location='/Class/Add/ParentId/{*$info[F_ID]*}'"> 
<input name="Submit32" type="button" onClick="window.location='/Class/Order/Id/{*$info[F_ID]*}'" value="设置产品顺序">
      <input name="Submit" type="button" onClick="window.location='/Class/Config/Id/{*$info[F_ID]*}'" value="设置显示参数"> 
      <input name="Submit2" type="button" onClick="window.location='/Class/Property/Id/{*$info[F_ID]*}'" value="产品属性管理"> 
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
		window.location='/Class/Delete/Id/{*$info[F_ID]*}';
}
</script>
