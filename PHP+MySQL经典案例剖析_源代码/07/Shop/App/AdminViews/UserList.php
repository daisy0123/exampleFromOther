<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language='javascript' src='/Js/Base.js'></script>
<form name=form1 action="" method=post>
<table cellSpacing=0 width="95%" align=center border=0>
  <tr>
    <td class=caption colSpan=2>�� �� �� ��</td>
  </tr>
  <tr>
    <td colSpan=2>�û�������
      <input name="keyword" type="text" id="keyword">
      <select name="type" id="type">
        <option value="1" selected>�û���</option>
        <option value="2">EMAIL</option>
        <option value="3">��ʵ����</option>
      </select>
      <input type="button" name="Submit" value="�ύ" onClick="javascript:searchuser();"></td>
  </tr>
  <tr>
    <td colSpan=2>
      <table width="100%" border=0>
        <tr>
          <th width=25><input id=allbox onclick=CA(); type=checkbox value=1 
            name=allbox></th>
          <th width=61>�û���</th>
          <th width=171>EMAIL</th>
          <th width=86>�Ƿ�����ʼ�</th>
          <th width=52>�Ա�</th>
          <th width=83>��ʵ����</th>
          <th width=118>ע��ʱ��</th>
          <th width=61>�Ƿ񼤻�</th>
          <th width=112>����</th>
		</tr>
		{*foreach item=uu from=$list[data]*}
        <tr bgColor=#ffffff>
          <td align=middle><input type=checkbox value='{*$uu[F_ID]*}' name=SelId[]> </td>
          <td>{*$uu[F_LOGIN_NAME]*}</td>
          <td align=middle>{*$uu[F_LOGIN_EMAIL]*}</td>
          <td align=middle>
		 {*if $uu[F_LOGIN_ACCEPT_EMAIL] == 1*}
		 ��
		 {*else*}
		 ��
		 {*/if*}
		 </td>
          <td align=middle>
		  {*if $uu[F_USER_GENDER] == 1*}
		  ��
		  {*/if*}
		  {*if $uu[F_USER_GENDER] == 2*}
		  Ů
		  {*/if*}
		  </td>
          <td align=middle>{*$uu[F_USER_TRUENAME]*}</td>
          <td align=middle>{*$uu[F_LOGIN_TIME]|date:'m-d H:i'*}</td>
		  <td align=middle>{*if $uu[F_LOGIN_IS_ACTIVE] == 1*}
		  ��
		  {*else*}
		  ��
		  {*/if*}</td>
          <td align=middle><a href="/User/Info/Id/{*$uu[F_ID]*}">�鿴����</a> 
		  <a href="/Order/Index/UserId/{*$uu[F_ID]*}">�鿴����</a> </td>
        </tr>
		{*/foreach*}
		</table>
	</td>
  </tr>
  <tr>
    <th colSpan=2>&nbsp; <input id=cmdAdd onclick=javascript:deluser(); type=button value="ɾ �� �� ��" name=cmdDel><input type="button" name="Submit2" value="Ⱥ���ʼ�" onClick="javascript:window.location='/User/SendEmail'"></th>
  </tr></table>
<table width="95%" border="0" align="center">
  <tr>
    <td>{*$list[JumpBar]*}</td>
  </tr>
</table>
</form>
<script language=JavaScript type=text/JavaScript>
/**
 * ʵ��ȫѡ����
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
/**
 * ʵ������ת��
 */
function searchuser()
{
	if($(��keyword��).value.trim() == ����)
	{
		alert(������д�ؼ��֡�);
		$(��keyword��).focus();
	}else{
		document.form1.action='/User/Redirect';
		document.form1.submit();
	}
}
/**
 * ʵ��ɾ��ȷ��
 */
function deluser()
{
	if(confirm("���Ҫɾ����?"))
	{
		document.form1.submit();
	}
}
</script>
