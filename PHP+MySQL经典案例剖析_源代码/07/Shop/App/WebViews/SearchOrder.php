<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<script language='javascript' src='/Js/Base.js'></script>
<script language='javascript' src='/Js/Date.js'></script>
<form name="form1" method="post" action="/Order/Redirect">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
    <tr>
      <td><h4 class="bule">������ѯ</h4></td>
    </tr>
    <tr>
      <td><p>
        <select id="start_y" name="start_y">
	  {*$date[Year]*}
	  </select>
        ��
	    <select id="start_m" onChange="javascript:register_buildDay(this.value,'start_y','start_d');" name="start_m">
	  {*$date[Month]*}  		
	  </select>
	    ��
	    <select id="start_d" name="start_d">
	  {*$date[Day]*} 
	  </select>
	    ��
	  ��
      <select id="end_y" name="end_y">
	  {*$date[Year]*}  
	  </select>
      ��
      <select id="end_m" onChange="javascript:register_buildDay(this.value,'end_y','end_d');" name="end_m">
	  {*$date[Month]*}  
	  </select>
      ��
      <select id="end_d" name="end_d">
	  {*$date[Day]*}
	  </select>
      ��
        <input type="submit" value="��ѯ" name="button" />
      </p>
      </td>
    </tr>
</table>
{*if $action=='Search' *}
<table width="100%" border="0">
  <tr>
    <td><p><p>��ѯ�����</p></p></td>
  </tr>
</table>
<table cellspacing="1" cellpadding="0" width="100%" align="center" 
      bgcolor="#003366" border="0">
  <tbody>
    <tr>
      <td class="STYLE3" valign="center" align="middle" width="15%" 
          bgcolor="#ddf3ff" height="25">ʱ��</td>
      <td class="STYLE3" valign="center" align="middle" width="25%" 
          bgcolor="#ddf3ff" height="25">��ϵ��ַ</td>
      <td class="STYLE3" valign="center" align="middle" width="16%" 
          bgcolor="#ddf3ff">��������</td>
      <td class="STYLE3" valign="center" align="middle" width="20%" 
          bgcolor="#ddf3ff">��ϵ�绰</td>
      <td class="STYLE3" valign="center" align="middle" width="11%" 
          bgcolor="#ddf3ff">״̬</td>
      <td class="STYLE3" valign="center" align="middle" width="13%" 
          bgcolor="#ddf3ff">����</td>
    </tr>
	{*foreach item=uu from=$list[data]*}
    <tr>
      <td valign="center" bgcolor="#FFFFFF">{*$uu[F_ORDER_TIME]|date:'Y-m-d'*}</td>
      <td bgcolor="#FFFFFF">{*$uu[F_ORDER_ADDRESS]*}</td>
      <td bgcolor="#FFFFFF">{*$uu[F_ORDER_ZIPCODE]*}</td>
      <td bgcolor="#FFFFFF">{*$uu[F_ORDER_PHONE]*}</td>
      <td bgcolor="#FFFFFF">{*if $uu[F_ORDER_STATUS] == 1*}
		�Ѵ���
		{*else*}
		δ����{*/if*}</td>
      <td bgcolor="#FFFFFF"><a href="/Order/List/Id/{*$uu[F_ID]*}" target="_blank">[�鿴����]</a></td>
    </tr>
	{*/foreach*}
  </tbody>
</table>
<table width="100%" border="0">
  <tr>
    <td>{*$list[JumpBar]*}</td>
  </tr>
</table>
{*/if*}
</form>
