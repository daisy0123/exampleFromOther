<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<P class=caption>�����²�Ʒ˳��</P>
<form name=form1 action="" method=post>
<table width="70%" align=center border=0>
  <tr>
    <td vAlign=top bgColor=#eeeeee height=100>
      <table width="100%" border=0>
        <tr>
          <th width=150 height=23>��Ʒ���</th>
          <th width=250>��Ʒ����</th>
          <th>˳��</th></tr>
		{*foreach item=uu from=$list[data]*}
        <tr>
          <td height=23 align="center">{*$uu[F_CLASS_NAME]*} 
            <input name="id[]" type="hidden" id="id[]" value="{*$uu[F_ID]*}"></td>
          <td align="center">{*$uu[F_PRODUCT_NAME]*}</td>
          <td align="center"><input name="order[]" type="text" id="order[]" value="{*$uu[F_NEW_ORDER]*}"></td>
        </tr>
		{*/foreach*}
        </table></td></tr>
  <tr>
    <th><input id=cmdOk type=submit value=�ύ name=cmdOk> <input id=cmdBack onclick=javascript:history.back() type=button value=���� name=cmdBack></th></tr></table>
<table width="70%" border="0" align="center">
  <tr>
    <td>{*$list[JumpBar]*}</td>
  </tr>
</table>
</form>
