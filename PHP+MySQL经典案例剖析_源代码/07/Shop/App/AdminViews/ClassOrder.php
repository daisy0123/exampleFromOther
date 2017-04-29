<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">产品类别排列顺序</p>
<form name="form1" method="post" action="">
<table width="75%" align="center">
<tr> 
  <td height="80" valign="top" bgcolor="#eeeeee"> 
	<table width="100%" align="center">
 <tr> 
  <th width="50">ID</th>
  <th width="80">图片</th>
  <th width="200" height="23">类别</th>
  <th width="50">顺序</th>
 </tr>
{*foreach item=uu from=$list*}
 <tr> 
  <td align="center"><input type='hidden' name='SelId[]' value='{*$uu[F_ID]*}'>
  {*$uu[F_ID]*}</td>
  <td align="center">
  {*if $uu[F_CLASS_IMG]*}
  <img src="{*$path*}{*$uu[F_CLASS_IMG]*}" width="100" height="75" />
  {*else*}
  无
  {*/if*}
  </td>
  <td align="center">{*$uu[F_CLASS_NAME]*}</td>
  <td align="center"><input name="Order[]" type="text" value="{*$uu[F_CLASS_ORDER]*}" size="15">
  </td>
 </tr>
{*/foreach*}
</table></td>
</tr>
<tr> 
<th><input type="submit" name="Submit" value="提交">
	<input name="cmdBack" type="button" id="cmdBack" value="返回" onclick="javascript:window.history.back()"></th>
</tr>
</table>
</form>
