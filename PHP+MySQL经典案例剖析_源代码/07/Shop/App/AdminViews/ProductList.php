<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">产品管理</p>
<form name="form1" method="post" action="">
  <table width="95%" align="center">
    <tr>
      <td valign="top" class="stress">类别：{*$class[F_CLASS_NAME]*}</td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#eeeeee"><table width="100%" align="center">
          <tr>
            <th width="27"><input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
            <th width="61" height="23">ID</th>
            <th width="274">产品名称</th>
            <th width="68">小图片</th>
            <th width="62">大图片</th>
            <th width="83">顺序</th>
            <th width="194">管理</th>
          </tr>
        {*foreach item=uu from=$list[data]*}
        <tr>
          <td align="center"><input type='checkbox' name='SelId[]' value='{*$uu[F_ID]*}'></td>
          <td align="center">{*$uu[F_ID]*}</td>
          <td align="center">{*$uu[F_PRODUCT_NAME]*}</td>
          <td align="center">
		  {*if $uu[F_PRODUCT_SMALL_IMG]*}
		  <a href="{*$path*}{*$uu[F_PRODUCT_SMALL_IMG]*}" target="_blank"><img src="{*$path*}{*$uu[F_PRODUCT_SMALL_IMG]*}" width="100" height="50"></a>
		  {*else*}
		  无
		  {*/if*}
		  </td>
          <td align="center">
		  {*if $uu[F_PRODUCT_BIG_IMG]*}
		  <a href="{*$path*}{*$uu[F_PRODUCT_BIG_IMG]*}" target="_blank"><img src="{*$path*}{*$uu[F_PRODUCT_BIG_IMG]*}" width="100" height="50"></a>
		  {*else*}
		  无
		  {*/if*}
		  </td>
          <td align="center">{*$uu[F_PRODUCT_ORDER]*}</td>
          <td align="center"><a href="/Product/Edit/ClassId/{*$class[F_ID]*}/Id/{*$uu[F_ID]*}">编辑</a>
		   <a href="/Product/Pic/ClassId/{*$class[F_ID]*}/Id/{*$uu[F_ID]*}">图片管理</a></td>
        </tr>
        {*foreachelse*}
		<tr align='center'><td height='30' colspan='6'>本页没有产品信息</td></tr>
		{*/foreach*}
      </table></td>
    </tr>
    <tr>
      <th> <input type="button" name="Submit" value="增加产品" onClick="window.location='/Product/Add/ClassId/{*$class[F_ID]*}'">
          <input type="button" name="Submit2" value="设置顺序" onClick="window.location='/Product/Order/ClassId/{*$class[F_ID]*}'">
		  <input type="submit" name="Submit3" value="删除产品" onClick="window.location='/Product/Order/ClassId/{*$class[F_ID]*}'">
      </th>
    </tr>
  </table>
  <table width="95%" border="0" align="center">
    <tr>
      <td>{*$list[JumpBar]*}</td>
    </tr>
  </table>
</form>
<script language="javascript">
/**
 * 实现全选功能
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
</script>
