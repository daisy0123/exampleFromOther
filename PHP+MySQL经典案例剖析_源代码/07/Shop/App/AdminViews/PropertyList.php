<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<p class="caption">��Ʒ���Թ���</p>
<table width="85%" align="center">
{*if $classid > 0*}
  <tr>
  <td valign="top" class="stress">���{*$info[F_CLASS_NAME]*}</td>
 </tr>
{*else*}
  <tr>
  <td valign="top" class="stress">��𣺣�����������û���Զ������Ե����</td>
 </tr>
{*/if*}
 <tr>
    <td height="80" valign="top" bgcolor="#eeeeee"> 
	  <table width="100%" align="center">
	<tr> 
	      <th>������</th>
	 <th width="150" height="23">�ֶ�����</th>
	 <th width="45">˳��</th>
	      <th width="60">����</th>
	</tr>
{*foreach item=uu from=$list*}
	<tr> 
	 <td align="center">{*$uu[F_PROPERTY_NAME]*}</td>
	 <td align="center">{*$uu[F_PROPERTY_FIELDNAME]*}</td>
	 <td align="center">{*$uu[F_PROPERTY_ORDER]*}</td>
	 <td align="center"><a href="/Class/PropertyAdd/ClassId/{*$classid*}/Id/{*$uu[F_ID]*}">�༭</a> <a href="/Class/PropertyDel/ClassId/{*$classid*}/Id/{*$uu[F_ID]*}">ɾ��</a></td>
	</tr>
{*/foreach*}
   </table></td>
 </tr>
 <tr>
  <th> 
   <input type="button" name="Submit" value="���Ӳ���" onclick="window.location='/Class/PropertyAdd/ClassId/{*$classid*}'">
   <input type="button" name="Submit2" value="����˳��" onclick="window.location='/Class/PropertyOrder/ClassId/{*$classid*}'">
   <input type="button" name="Submit22" value="����" onclick="window.location='/Class/Info/Id/{*$classid*}''"></th>
 </tr>
</table>
