<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">��ƷͼƬ</p>
<form action="" method="post" enctype="multipart/form-data" name="frm_add" id="frm_add" onSubmit="return check_data()">
 <table width="400" border="0" align="center">
  <tr>
   	  <th height="23" align="center">��Ʒ��{*$info[F_PRODUCT_NAME]*}</th>
  </tr>
  <tr>
   	  <td height="100" bgcolor="#eeeeee"> 
	  {*if $msg*}
		<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>
			<font color="red">
			{*foreach item=uu from=$msg*}
			<p>{*$uu*}</p>
			{*/foreach*}
			</font></td>
          </tr>
        </table>
	 {*/if*}
		<table width="85%" border="0" align="center">
	 <tr> 
	  <td width="18%" height="24" align="right">Сͼ</td>
	  <td width="82%"><input name="small" type="file" id="small"></td>
	 </tr>
	 {*if $info[F_PRODUCT_SMALL_IMG]*}
	 <tr>
	   <td height="24" align="right">СͼԤ��</td>
	   <td><a href="{*$upload_path*}{*$info[F_PRODUCT_SMALL_IMG]*}"><img src="{*$upload_path*}{*$info[F_PRODUCT_SMALL_IMG]*}" width="80" height="80" border="0" /></a></td>
	   </tr>
	 {*/if*}
	 <tr>
	   <td height="24" align="right">��ͼ</td>
	   <td><input name="big" type="file" id="big"></td>
	   </tr>
	 {*if $info[F_PRODUCT_BIG_IMG]*}
	 <tr>
	   <td height="24" align="right">��ͼԤ��</td>
	   <td><a href="{*$upload_path*}{*$info[F_PRODUCT_BIG_IMG]*}"><img src="{*$upload_path*}{*$info[F_PRODUCT_BIG_IMG]*}" width="80" height="80" border="0" /></a></td>
	   </tr>
	 {*/if*}
	</table>
	  </td>
  </tr>
  <tr>
   	  <th align="center"> <input type="submit" name="Submit" value="�ύ">
		<input name="cmdBack" type="button" id="cmdBack" value="����" onClick="javascript:history.back()">
		<input name="pid" type="hidden" id="pid" value="{*$info[F_ID]*}"></th>
  </tr>
 </table>
</form>