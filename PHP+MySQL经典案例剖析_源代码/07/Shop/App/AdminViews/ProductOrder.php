<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">��Ʒ����˳��</p>
<form name="form1" method="post" action="">
 <table width="75%" align="center">
  <tr> 
   <td valign="top" class="stress">���{*$info[F_CLASS_NAME]*}</td>
  </tr>
  <tr> 
   <td height="80" valign="top"> <table width="100%" align="center">
	 <tr> 
	  <th width="50" height="23">ID</th>
	  <th width="250">��Ʒ����</th>
	  <th>˳�����</th>
	 </tr>
	 {*foreach item=uu from=$list[data]*}
	 <tr> 
	  <td align="center"><input type='hidden' name='SelId[]' value='{*$uu[F_ID]*}'>{*$uu[F_ID]*}</td>
	  <td align="center">{*$uu[F_PRODUCT_NAME]*}</td>
	  <td align="center"> <input name="order[]" type="text" value="{*$uu[F_PRODUCT_ORDER]*}" size="15"></td>
	 </tr>
	 {*/foreach*}
	</table></td>
  </tr>
  <tr> 
   <th><input type="submit" name="Submit" value="�ύ">
     <input type="button" name="Submit2" value="����" onClick="javascript:window.location='/Product/Index/ClassId/{*$classid*}'"></th>
  </tr>
 </table>
<table width="75%" border="0" align="center">
<tr>
  <td>{*$list[JumpBar]*}</td>
</tr>
</table>
 </form>
