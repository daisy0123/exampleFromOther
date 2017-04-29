<?php
$cat = $blog->GetCatList($blogid);
$status = array("1" => "����","2" => "��Ա�鿴","3" => "������");
$url = "Index.php?Action=Post";
if($_GET['PostId'])													//�ж��Ƿ�Ϊ�༭״̬
{
	$info = $blog->getInfo($_GET['PostId'],"EE_BLOG_POSTS");	
	if($info['F_ID_USER_INFO'] != $_SESSION['User']['F_ID'])				//�ж��Ƿ�༭�Լ�������
	{
		echo "����Ȩ�༭������";
		exit();
	}
	$url = "Index.php?Action=Post&PostId={$_GET['PostId']}";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')							//�ж��Ƿ�Ϊ�ύ����
{
	$data = array();
	$time = time();
	$upload = "";
	if($_FILES['file']['size'] > 0)										//�ж��Ƿ����ϴ�ͼƬ
	{
		$result = upload($_FILES['file'],UPLOAD_PATH,MAX_UPLOAD_SIZE);	//�ϴ�ͼƬ
		if($result['errocode'] == 'size_erro')								//�ж�ͼƬ�Ƿ����
		{
			echo "ͼƬ���󣬲��ܳ���200K";
			exit();
		}
		if($result['errocode'] == 'type_erro')								//�ж��ļ������ǲ���ͼƬ
		{
			echo "�ϴ��ļ�����ͼƬ";
			exit();
		}
		$upload = $result['file_name'];									//ȡ���ϴ���ַ
	}
	$data['F_ID_CATEGORIES'] = $_POST['catid'];
	$data['F_ID_USER_INFO'] = $_SESSION['User']['F_ID'];
	$data['F_POSTS_MOD_DATE'] = $time;
	$data['F_POSTS_STATUS'] = $_POST['status'];
	$data['F_POSTS_CONTENTS'] = $_POST['content'];
	$data['F_POSTS_TITLE'] = $_POST['title'];
	$data['F_POSTS_IS_COMMENTED'] = ($_POST['comment']) ? 1 : 0;
	$data['F_POSTS_UPLOAD'] = $upload;
	if($_GET['PostId'])												//�ж��Ƿ�Ϊ�༭״̬
	{
		if($blog->updateData("EE_BLOG_POSTS",$_GET['PostId'],$data))		//�ж��Ƿ���³ɹ�
		{
			header("Location:Index.php?Action=PostList");
			exit();
		}
	}else{
		$data['F_POSTS_ISSUE_DATE'] = $time;
		$data['F_POSTS_VIEWS'] = 0;
		$data['F_POSTS_COMMENTS'] = 0;
		if($blog->insertData("EE_BLOG_POSTS",$data))					//�ж��Ƿ�������ݳɹ�
		{
			$blog->UpdateCatPosts($_POST['catid']);							//���·���������
			header("Location:Index.php?Action=PostList");
			exit();
		}
	}
}
?>
<script language="javascript" src="/js/Base.js"></script>
<ul id="submenu">
<li><a href="Index.php?Action=Post">д����</a></li>
<li><a href="Index.php?Action=PostList">�����б�</a></li>
</ul>
<div class="wrap">
<h2>д����</h2>
<form name="form1" method="post" action="<?php echo $url?>" onsubmit="return check();">
<fieldset><legend>����</legend>
<div><input id=title name=title value="<?php echo $info['F_POSTS_TITLE']?>"></div></fieldset> 
<fieldset><legend>����</legend>
<div><TEXTAREA id=content name=content rows=10 cols=60><?php echo $info['F_POSTS_CONTENTS']?></TEXTAREA>
</div>
</fieldset> 
<P><input id=post type=submit value=���� name=post>
<input type=reset value=��д name=submit>
</P>
<fieldset>
<h2>�ϴ��ļ�</h2>
<div id="upload"><input type="file" name="file"></div>
</fieldset>
<fieldset>
<h3>����</h3>
<ul>
<?php
foreach($cat as $value)								//ѭ���������
{
	if(isset($info['F_ID_CATEGORIES']))					//�ж��Ƿ���ȡ�����·���ID
	{
		if($info['F_ID_CATEGORIES'] == $value['F_ID'])	//�жϱ��༭���µķ���ID�Ƿ���÷������
			$checked = "checked='checked' ";
	}else{
		if($value['F_ID'] == 1)						//Ĭ��ѡ��Ĭ�Ϸ���
			$checked = "checked='checked' ";
	}
	echo "<li>";
  	echo "<input type='radio' value={$value['F_ID']} " . $checked . "name=catid>";
  	echo $value['F_CATEGORIES_NAME'];
	echo "</li>";
}
?>
</ul>
</fieldset> 
<fieldset>
<h3>����</h3>
<div>
<label>
<?php
$checked = "checked='checked' ";
if($info['F_POSTS_IS_COMMENTED'] == 0)				//�жϱ��༭���µ�����״̬�Ƿ�Ϊ0
	$checked = "";
?>
<input id=comment type=checkbox <?php echo $checked?>value=1 name=comment>
��������
</label></div>
</fieldset> 
<fieldset>
<h3>����״̬</h3>
<div>
<?php
for($i=1;$i<=3;$i++)									//ѭ���������״̬ѡ��
{
echo "<label>";
echo "<input name=status type=radio id=status value=1";
if(isset($info['F_POSTS_STATUS']))						//�ж��Ƿ�Ϊ�༭״̬
{
	if($info['F_POSTS_STATUS'] == $i)					//�жϱ��༭���µ�״̬�Ƿ�ʹ�״̬��ͬ
		echo " checked";
}else{
	if($i == 1)										//Ĭ��ѡ������״̬
		echo " checked";
}
echo ">".$status[$i];
echo "</label>";
}
?>
</div></fieldset> 
</form>
</div>
<script language="javascript">
function check()
{
	if(document.form1.title.value == '')							//�������Ƿ�Ϊ��
	{
		alert('����д����');									//���Ϊ�գ�����ʾ
		document.form1.title.focus();							//���㶨λ�����������
		return false;
	}
	if(!checkByteLength(document.form1.title.value,1,255))			//�жϱ��ⳤ���Ƿ���ȷ
	{
		alert('���ⳤ�Ȳ���ȷ������Ϊ1-255���ַ�');				//����ȷ������ʾ
		document.form1.title.focus();							//���㶨λ�����������
		return false;
	}
	if(document.form1.content.value == '')						//��������Ƿ�Ϊ��
	{
		alert('����д����');									//���Ϊ�գ�����ʾ
		document.form1.content.focus();						//���㶨λ�����������
		return false;		
	}
	return true;
}
</script>
