<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">ϵͳ���ù���</p>
<table width="95%" border="0">
  <tr>
	<td height="80" valign="top" bgcolor="#eeeeee"> 
	  <table width="100%" border="0">
		<tr> 
		  <th width="250" height="23">������</th>
		  <th width="200">��ʶ</th>
		  <th width="100">����ֵ</th>
		  <th>����</th>
		</tr>
		{*foreach item=uu from=$list*}
		<tr> 
		  <td>{*$uu[F_CONFIG_NOTE]*}</td>
		  <td>{*$uu[F_CONFIG_NAME]*}</td>
		  <td align="center">{*$uu[F_CONFIG_VALUE]*}</td>
		  <td align="center"><a href="/Config/Edit/Id/{*$uu[F_ID]*}">�޸�</a></td>
		</tr>
		{*/foreach*}
	  </table>
	</td>
  </tr>
  <tr>
	<th align="center">&nbsp;</th>
  </tr>
</table>
