<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')							//�ж��Ƿ����ύ����
{
	if($blog->BlogSet($blogid,$_POST))									//�ж��Ƿ����óɹ�
	{
		echo "���óɹ�";
	}
}
$info = $blog->GetBlogInfo($blogid);
$list = $blog->GetSkinsList();
?>
<div class="wrap">
<FORM action="Index.php?Action=BlogSet" name="form1" method=post onsubmit=��return check();��>
  <TABLE width="80%">
  <TR vAlign=top>
    <TH width="16%">Blog ����:</TH>
    <TD width="84%"><INPUT id=blogname value="<?php echo $info['F_BLOG_NAME']?>" name=blogname></TD></TR>
  <TR vAlign=top>
    <TH>Blog����:</TH>
    <TD><textarea name="description" cols="50" rows="6"><?php echo $info['F_BLOG_DESCRIPTION']?></textarea></TD>
  </TR>
  <TR vAlign=top>
    <TH>Blog�ؼ���:</TH>
    <TD><INPUT id=keyword size=40 value="<?php echo $info['F_BLOG_KEYWORDS']?>" name=keyword>
      ������ؼ���֮���ö��Ÿ�����</TD>
  </TR>
  <TR vAlign=top>
    <TH>Blogģ��:</TH>
    <TD><select name="skins" id="skins">
<?php
foreach($list as $value)												//ѭ�����ģ��
{
	echo "<option value='" . $value['F_SKINS_FILE'] . "'";
	if($info['F_BLOG_DEFAULT_SKINS'] == $value['F_SKINS_FILE'])			//����Ĭ��ѡ��
	{
		echo " selected='selected'";
	}
	echo ">" . $value['F_SKINS_NAME'] . "</option>";
}
?>
    </select>
    </TD>
  </TR>
  <TR vAlign=top>
    <TH>����״̬:</TH>
    <TD>
    <?php 
    echo "<INPUT name=comment type=checkbox id=comment value=1";
    if($info['F_BLOG_PERM_COMMENTS'] == 1)							//�ж�Blog��������
    	echo " checked";
    echo ">";
    ?>
      ��������</TD>
  </TR>
  <TR vAlign=top>
    <TH>Blog״̬:</TH>
    <TD>    
    <?php 
    echo "<INPUT name=lock type=checkbox id=lock value=1";
    if($info['F_BLOG_IS_LOCKED'] == 1)								//�ж�Blog��״̬�Ƿ�����
    	echo " checked";
    echo ">";
    ?>
      ����</TD>
  </TR>
  <TR vAlign=top>
    <TH scope=row>Blog����:</TH>
    <TD><input name="password" type="password" id="password"></TD>
  </TR>
  <TR vAlign=top>
    <TH scope=row>ȷ������:</TH>
    <TD><input name="confirm" type="password" id="confirm"></TD>
  </TR>
  </TABLE>
  <P><INPUT type=submit value="�ύ����" name=Submit></P>
</FORM>
<script language="javascript">
function check()
{
	if(document.form1.blogname.value == '')								//�ж������Ƿ�Ϊ��
	{
		alert('����д����');											//Ϊ������ʾ
		document.form1.blogname.focus();								//���㶨λ�����������
		return false;
	}
	
	if(!checkByteLength(document.form1.blogname.value,1,50))				//�ж����Ƴ����Ƿ�Ϸ�
	{
		alert('���Ƴ��Ȳ���ȷ������Ϊ1-50���ַ�'); 						//Ϊ������ʾ
		document.form1.blogname.focus();								//���㶨λ�����������
		return false;
	}
	
	if(document.form1.description.value != '')								//�ж������Ƿ�Ϊ��
	{
		if(!checkByteLength(document.form1.description.value,1,200))			//��Ϊ���жϳ����Ƿ�Ϸ�
		{
			alert('�������Ȳ���ȷ������Ϊ1-200���ַ�');					//���Ϸ�����ʾ
			document.form1.description.focus();							//���㶨λ�����������
			return false;		
		}
	}
	if(document.form1.password.value != '')								//�ж������Ƿ�Ϊ��
	{
		if(!checkByteLength(document.form1.password.value,6,16))			//��Ϊ�����жϳ����Ƿ�Ϸ�
		{
			alert('���볤�Ȳ���ȷ������Ϊ6-16���ַ�');					//���Ϸ�����ʾ
			document.form1.password.focus();							//���㶨λ�����������
			return false;		
		}
		
		if(document.form1.password.value != document.form1.confirm.value)	//�ж��������������Ƿ�һ��
		{
			alert('��������ǰ��һ��');								//��һ������ʾ
			document.form1.password.focus();							//���㶨λ�����������
			return false;
		}
	}
	return true;
}
</script>
</div>