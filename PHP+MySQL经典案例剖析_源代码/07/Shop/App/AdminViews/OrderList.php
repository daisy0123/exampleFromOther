<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<script language="javascript" src="/Js/Date.js"></script>
<table cellSpacing=0 width="95%" align=center border=0>
  <tr>
    <td class=caption colSpan=2>�� �� �� ��</td>
  </tr>
  <tr>
    <td colSpan=2>
<form name=search action="/Order/Redirect{*if $userid*}/UserId/{*$userid*}{*/if*}" method=post onSubmit="javascript:return Check();">
	����������<span id="searchuser">
      <input name="keyword" type="text" id="keyword" size="10">
      <select name="type" id="type">
        <option value="1" selected>�û���</option>
        <option value="2">EMAIL</option>
        <option value="3">��ʵ����</option>
      </select>
      <input name="user" type="hidden" id="user" value="1">
	  </span>
	  <span id="date">
	  <select id="start_y" name="start_y">
	  {*$date[Year]*}
	  </select>
	  <select id="start_m" onChange="javascript:register_buildDay(this.value,'start_y','start_d');" name="start_m">
	  {*$date[Month]*}  		
	  </select>
	  <select id="start_d" name="start_d">
	  {*$date[Day]*} 
	  </select>
	  -
      <select id="end_y" name="end_y">
	  {*$date[Year]*}  
	  </select>
      <select id="end_m" onChange="javascript:register_buildDay(this.value,'end_y','end_d');" name="end_m">
	  {*$date[Month]*}  
	  </select>
      <select id="end_d" name="end_d">
	  {*$date[Day]*}
	  </select>
      <input name="time" type="hidden" id="time" value="1">
	  </span>
	  <input type="submit" name="Submit" value="�ύ">
	  <a href="#" onClick="javascript:ChangeUser();">[<span id="disp_user">����</span>�û�����]</a>
	  <a href="#" onClick="javascript:ChangeDate();">[<span id="disp_date">����</span>ʱ������]</a>
	  </form>
	  </td>
  </tr>
  <tr>
    <td colSpan=2>
<form name=form1 action="" method=post onSubmit="">
      <table width="100%" border=0>
        <tr>
          <th width=25><input id=allbox onclick=CA(); type=checkbox value=1 name=allbox></th>
          <th width=99>�û���</th>
          <th width=165>��ַ</th>
          <th width=98>��������</th>
          <th width=111>�̶��绰</th>
          <th width=109>�µ�ʱ��</th>
          <th width=57>״̬</th>
          <th width=109>����</th></tr>
		{*foreach item=uu from=$list[data]*}
        <tr bgColor=#ffffff>
          <td align=middle><input type=checkbox value='{*$uu[F_ID]*}' name=SelId[]> </td>
          <td>{*$uu[F_LOGIN_NAME]*}</td>
          <td align=middle>{*$uu[F_ORDER_ADDRESS]*}</td>
          <td align=middle>{*$uu[F_ORDER_ZIPCODE]*}</td>
          <td align=middle>{*$uu[F_ORDER_PHONE]*}</td>
          <td align=middle>{*$uu[F_ORDER_TIME]|date:'m-d H:i'*}</td>
          <td align=middle>{*if $uu[F_ORDER_STATUS] == 1*}�Ѵ���{*else*}δ����{*/if*}</td>
          <td align=middle><a href="/Order/List/Id/{*$uu[F_ID]*}">�鿴����</a></td>
        </tr>
		{*/foreach*}
		  <tr>
    		<th colSpan=8>&nbsp;
      <input type="submit" name="Submit2" value="������" /></th>
  		</tr>
		</table>
</form>
	</td>
  </tr>
  </table>
<table width="95%" border="0" align="center">
  <tr>
    <td>{*$list[JumpBar]*}</td>
  </tr>
</table>
<SCRIPT language=JavaScript type=text/JavaScript>
/**
 * ���ܣ�ʵ��ȫѡ
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
/**
 * ���ܣ�������
 */
function Check()
{
	if($('user').value == 1)											//�ж��Ƿ��а��û�����
	{
		if($('keyword').value.trim() == '')									//�жϹؼ����Ƿ�Ϊ��
		{
			alert('����д�����ؼ���');
			return false;
		}
	}
	return true;
}
/**
 * ���ܣ�����/��ʾ���û���������
 */
function ChangeUser()
{
	if($('searchuser').style.display == '')									//�ж��û����������Ƿ���ʾ
	{
		$('searchuser').style.display = 'none';								//�����û���������
		$('user').value = 0;
		$('disp_user').innerHTML = "��ʾ";
	}else{
		$('searchuser').style.display = '';								//��ʾ�û���������
		$('user').value = 1;
		$('disp_user').innerHTML = "����";
	}
}
/**
 * ���ܣ�����/��ʾʱ����������
 */
function ChangeDate()
{
	if($('date').style.display == '')										//�ж�ʱ�����������Ƿ���ʾ
	{
		$('date').style.display = 'none';									//����ʱ����������
		$('time').value = 0;
		$('disp_date').innerHTML = "��ʾ";
	}else{
		$('date').style.display = '';										//��ʾʱ����������
		$('time').value = 1;
		$('disp_date').innerHTML = "����";
	}
}
</SCRIPT>
