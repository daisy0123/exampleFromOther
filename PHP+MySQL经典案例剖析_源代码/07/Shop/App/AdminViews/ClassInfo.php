<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<table width="85%" border="0" align="center">
  <tr> 
    <th align="left">������Ϣ</th>
  </tr>
  <tr> 
    <td><table width="85%" border="0" align="center" cellpadding="0">
        <tr> 
          <td bgcolor="#999999"> <table width="100%" border="0" cellpadding="2" cellspacing="1">
              <tr bgcolor="#FFFFFF"> 
                <td width="80" align="right"><strong>�������</strong></td>
                <td class="stress">{*$info[F_CLASS_NAME]*}</td>
                <td width="70">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="right"><strong>�����������</strong></td>
                <td>{*$sub_count*}</td>
                <td><strong>��Ʒ������</strong></td>
                <td>{*$product_count*}</td>
              </tr>
            </table></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <th align="left">��<strong>���</strong>�б� </th>
  </tr>
  <tr> 
    <td height="20"> 
      <table width='85%' border='0' align='center'>
	  <ul>
	  {*foreach item=uu from=$sub_class*}
	  <li><a href='/Class/Info/Id/{*$uu[F_ID]*}'>{*$uu[F_CLASS_NAME]*}</a></li>
	  {*foreachelse*}
	  <li>�������</li>
	  {*/foreach*}
	  </ul>
    </table></td>
  </tr>
  <tr> 
    <th align="left">��ʾ����</th>
  </tr>
  <tr> 
    <td align="left"><table width="85%" border="0" align="center" cellpadding="0">
        <tr> 
          <td bgcolor="#999999"> <table width="100%" border="0" cellpadding="2" cellspacing="1">
              <tr bgcolor="#FFFFFF"> 
                <td width="70">��־ͼƬ</td>
                <td>{*$img*}</td>
                <td width="70">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td>��ƷԤ��ͼƬ</td>
                <td>{*$small_img_display*}</td>
                <td>��ƷͼƬ</td>
                <td>{*$big_img_display*}</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td>ÿҳ��Ʒ��</td>
                <td>{*$pagesize*}</td>
                <td>ÿ�в�Ʒ��</td>
                <td>{*$perline*}</td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td class="stress">ע����ƷԤ��ͼƬ�ߴ硢��ƷͼƬ�ߴ硢ÿ�в�Ʒ����Ϊ��ɫʱ��Ϊ�û�����ֵ��Ϊ��ɫ����ΪϵͳĬ��ֵ����Ҫ�޸�Ĭ�ϲ�������ѡ�����˵��еġ����ù����������á�</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <th align="left">��Ʒ����</th>
  </tr>
  <tr> 
    <td align="left"><table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td bgcolor="#999999"> <table width="100%" border="0" cellpadding="2" cellspacing="1">
              <tr align="center" bgcolor="#CCCCCC"> 
                <td width="350">������</td>
                <td>�ֶ���</td>
              </tr>
			  {*foreach item=uu from=$property*}
              <tr bgcolor="#FFFFFF"> 
                <td>{*$uu[F_PROPERTY_NAME]*}</td>
                <td align="center">{*$uu[F_PROPERTY_FIELDNAME]*}</td>
              </tr>			  
			  {*/foreach*}
            </table></td>
        </tr>
{*if $info[F_CLASS_IS_DEFAULT_PROPERTY] == 1 || $info[F_CLASS_IS_PARENT_PROPERTY] == 1*}
        <tr>
          <td bgcolor="#FFFFFF" class="stress">{*$property_note*}</td>
        </tr>
{*/if*}
      </table></td>
  </tr>
  <tr> 
    <th align="left">�������</th>
  </tr>
  <tr> 
    <td align="center"> <input name="edit" type="button" onClick="window.location='/Class/Edit/Id/{*$info[F_ID]*}'" value="�޸����"> 
      <input name="Submit33" type="button" onClick="javascript:Delete()" value="ɾ�����"> 
      <input name="add" type="submit" id="add" value="�½������" onClick="window.location='/Class/Add/ParentId/{*$info[F_ID]*}'"> 
<input name="Submit32" type="button" onClick="window.location='/Class/Order/Id/{*$info[F_ID]*}'" value="���ò�Ʒ˳��">
      <input name="Submit" type="button" onClick="window.location='/Class/Config/Id/{*$info[F_ID]*}'" value="������ʾ����"> 
      <input name="Submit2" type="button" onClick="window.location='/Class/Property/Id/{*$info[F_ID]*}'" value="��Ʒ���Թ���"> 
    </td>
  </tr>
  <tr> 
    <th align="left">&nbsp;</th>
  </tr>
</table>
<script language="javascript">
/**
 * ת�����ɾ��ҳ��
 */
function Delete()
{
	if(confirm('���Ҫɾ�������'))								//�ж��û��Ƿ�ȷ��ɾ��
		window.location='/Class/Delete/Id/{*$info[F_ID]*}';
}
</script>
