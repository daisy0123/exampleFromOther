<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<P align=center><B>�� �� �� Ϣ �� ��</B></P>
{*foreach item=uu from=$list[data]*}
<table cellSpacing=0 cellPadding=0 width="70%" align=center border=0>
<tr>	
<td bgColor=#0066cc>
<table cellSpacing=1 cellPadding=0 width="100%" border=0>
<tr>
<Th height=22 align="left">��Ʒ���ƣ�{*$uu[F_PRODUCT_NAME]*}</Th>
</tr>
<tr>
<td bgColor=#ffffff>
<table width="100%" border=0>
<tr>
<td bgColor=#666666><FONT 
color=#ffffff>{*$uu[F_LOGIN_NAME]*}&nbsp;&nbsp;����ʱ�䣺{*$uu[F_MESSAGE_TIME]|date:"Y-m-d H:i:s"*}</FONT></td>
</tr>
<tr>
<td>{*$uu[F_MESSAGE_CONTENT]|nl2br*}</td>
</tr>
<tr>
<td align=right height=22>
<a href="/Message/SendMail/Id/{*$uu[F_ID_LOGIN_INFO]*}">[�����ʼ�]</a> 
<a onclick="return confirm('���Ҫɾ����')" href="/Message/Del/Id/{*$uu[F_ID]*}">[ɾ����Ϣ]</a></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
{*foreachelse*}
<table cellSpacing=0 cellPadding=0 width="70%" align=center border=0>
<tr>	
<td>û�м�¼��</td>
</tr>
</table>
{*/foreach*}
<table width="70%" border="0" align="center">
  <tr>
    <td>{*$list[JumpBar]*}</td>
  </tr>
</table>
