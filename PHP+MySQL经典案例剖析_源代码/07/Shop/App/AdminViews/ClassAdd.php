<link href="/Style/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/Js/Base.js"></script>
<form action="/Class/{*$action*}" method="post" enctype="multipart/form-data" name="frm_add" id="frm_add" onsubmit="return check_data()">
  <table width="85%" border="0" align="center">
    <tr>
   	  <th height="23">
	  {*if $action == 'Insert'*}
	  ����
	  {*else*}
	  �༭
	  {*/if*}��Ʒ����</th>
  </tr>
  <tr>
   	  <td height="100" bgcolor="#eeeeee"> 
		<table border="0" align="center">
          <tr> 
            <td align="right" class="stress">�������</td>
            <td class="stress">
			{*if $action == 'Insert'*}
			{*if $class_id==0*}
			<��Ϊ��������><input type="hidden" id="class_id" name="class_id" value="{*$class_id*}" />
			{*else*}
			<select id="class_id" name="class_id">
			<option value="0">��������</option>
			{*html_options options=$option selected=$class_id*}
			</select>
			{*/if*}
			{*else*}
			<select id="class_id" name="class_id">
			<option value="0">��������</option>
			{*html_options options=$option selected=$info[F_PARENT_ID]*}
			</select>			
			{*/if*}
			</td>
          </tr>
          <tr> 
            <td align="right">�������<font color="red">*</font></td>
            <td> <input name="name" type="text" id="name" value="{*$info[F_CLASS_NAME]*}">
              25����������</td>
          </tr>
          <tr> 
            <td align="right">���˵��</td>
            <td><input name="note" type="text" id="note" value="{*$info[F_CLASS_NOTE]*}">
              100����������</td>
          </tr>
          <tr> 
            <td align="right">��ʶͼƬ</td>
            <td><input name="image" type="file" id="image"style="width:300px"> 
            </td>
          </tr>
          <tr>
            <td align="right">�Ƿ�ʹ��Ĭ�ϲ�Ʒ����</td>
            <td><select name="use_default" id="use_default">
                <option value="1"
				{*if $info[F_CLASS_IS_DEFAULT_PROPERTY] == 1*} 	//�ж�ʹ��Ĭ�������Ƿ�Ϊ1
				selected="selected"
				{*/if*}>��</option>
                <option value="0"
				{*if $info[F_CLASS_IS_DEFAULT_PROPERTY] == 0*} 	//�ж�ʹ��Ĭ�������Ƿ�Ϊ0
				selected="selected"
				{*/if*}>��</option>
              </select></td>
          </tr>
		{*if $class_id == 0 || $info[F_PARENT_ID] == 0*}	
          <tr id='parent_property'> 
            <td align="right">�Ƿ�ʹ�ü̳и��������</td>
            <td><select name="use_parent_property" id="use_parent_property">
                <option value="1"
				{*if $info[F_CLASS_IS_PARENT_PROPERTY] == 1*} 	//�жϼ̳и������Ƿ�Ϊ1
				selected="selected"
				{*/if*}>��</option>
                <option value="0"
				{*if $info[F_CLASS_IS_PARENT_PROPERTY] == 0*} 	//�жϼ̳и������Ƿ�Ϊ0
				selected="selected"
				{*/if*}>��</option>
              </select></td>
          </tr>
 		{*/if*}
        </table>
	  </td>
  </tr>
  <tr>
   	  <th align="center">
	  <input type="submit" name="Submit" value="�ύ">
	  <input name="id" type="hidden" id="id" value="{*$info[F_ID]*}" /></th>
  </tr>
 </table>
</form>
<script language='javascript'>
/**
 * ���ܣ�������
 */
function check_data(){
	if ($('name').value.trim() == ''){									//�ж���������Ƿ�Ϊ��
		alert("������Ʋ���Ϊ��")
		$('name').focus()
		return false
	}
	return true;
}
</script>
