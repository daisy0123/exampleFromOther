<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">��Ʒ�������˳��</p>
<form name="form1" method="post" action="">
<table width="75%" align="center">
<tr> 
  <td height="80" valign="top" bgcolor="#eeeeee"> 
	<table width="100%" align="center">
 <tr> 
  <th width="50">ID</th>
  <th width="80">ͼƬ</th>
  <th width="200" height="23">���</th>
  <th width="50">˳��</th>
 </tr>
{*foreach item=uu from=$list*}
 <tr> 
  <td align="center"><input type='hidden' name='SelId[]' value='{*$uu[F_ID]*}'>
  {*$uu[F_ID]*}</td>
  <td align="center">
  {*if $uu[F_CLASS_IMG]*}
  <img src="{*$path*}{*$uu[F_CLASS_IMG]*}" width="100" height="75" />
  {*else*}
  ��
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
<th><input type="submit" name="Submit" value="�ύ">
	<input name="cmdBack" type="button" id="cmdBack" value="����" onclick="javascript:window.history.back()"></th>
</tr>
</table>
</form>
