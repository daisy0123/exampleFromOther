<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">产品属性管理</p>
<table width="85%" align="center">
{*if $classid > 0*}
  <tr>
  <td valign="top" class="stress">类别：{*$info[F_CLASS_NAME]*}</td>
 </tr>
{*else*}
  <tr>
  <td valign="top" class="stress">类别：（适用于所有没有自定义属性的类别）</td>
 </tr>
{*/if*}
 <tr>
    <td height="80" valign="top" bgcolor="#eeeeee"> 
	  <table width="100%" align="center">
	<tr> 
	      <th>参数项</th>
	 <th width="150" height="23">字段名称</th>
	 <th width="45">顺序</th>
	      <th width="60">管理</th>
	</tr>
{*foreach item=uu from=$list*}
	<tr> 
	 <td align="center">{*$uu[F_PROPERTY_NAME]*}</td>
	 <td align="center">{*$uu[F_PROPERTY_FIELDNAME]*}</td>
	 <td align="center">{*$uu[F_PROPERTY_ORDER]*}</td>
	 <td align="center"><a href="/Class/PropertyAdd/ClassId/{*$classid*}/Id/{*$uu[F_ID]*}">编辑</a> <a href="/Class/PropertyDel/ClassId/{*$classid*}/Id/{*$uu[F_ID]*}">删除</a></td>
	</tr>
{*/foreach*}
   </table></td>
 </tr>
 <tr>
  <th> 
   <input type="button" name="Submit" value="增加参数" onclick="window.location='/Class/PropertyAdd/ClassId/{*$classid*}'">
   <input type="button" name="Submit2" value="设置顺序" onclick="window.location='/Class/PropertyOrder/ClassId/{*$classid*}'">
   <input type="button" name="Submit22" value="返回" onclick="window.location='/Class/Info/Id/{*$classid*}''"></th>
 </tr>
</table>
