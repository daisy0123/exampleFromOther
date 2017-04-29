<?php
include('header.php');											//����ͷ�ļ�
$postid = $_GET['Post'];											//ȡ������ID
$info = $blog->GetPosts($postid);									//��ȡ������Ϣ
if(!$info)														//�ж���Ϣ�Ƿ�Ϊ��
{
	echo "�޴�����";
	exit();
}
$blog->UpdatePostView($postid);
$status = 0;
if(!isset($_SESSION['User']['F_ID']))									//�жϸ��û��Ƿ��½
{
	$status = 1;
	if($info['F_POSTS_STATUS'] != 1)								//�жϸ��û��Ƿ���Ȩ���ʴ�����
	{
		echo "�Բ�������Ȩ���ʴ�����";
		exit();
	}
}else{
	if(!($blog_user['F_ID_USER_INFO'] == $_SESSION['User']['F_ID']))		//�жϸ��û��Ƿ��ǲ�����
	{
		$status = 2;
		if($info['F_POSTS_STATUS'] != 1 && $info['F_POSTS_STATUS'] != 2)//�жϸ��û��Ƿ���Ȩ���ʴ�����
		{
			echo "�Բ�������Ȩ���ʴ�����";
			exit();		
		}
	}
}
if($info['F_POSTS_IS_COMMENTED'] AND $blog_info['F_BLOG_PERM_COMMENTS'])//�жϸò��ͺ������Ƿ������
{
	$page = $_GET['Page'];										//ȡ�õ�ǰҳ��
	if(!$page)													//��ҳ��Ĭ��Ϊ1
		$page = 1;
	$com_list = $blog->GetCommentsList($blogid,$postid,0,$page);		//��ȡ�����б�
	$count = $blog->GetCommentsCount($blogid,$postid);				//��ȡ��������
	$pagecount = ceil($count/$blog->pagesize);						//��������ҳ��
	if(!$pagecount)												//���ҳ��Ϊ0��Ĭ��Ϊ1
		$pagecount = 1;
}
?>
<div id="main">
<div id="left">
<div id="post">
<div id="title"><?php echo $info['F_POSTS_TITLE']?></div>
<div id="time"><?php echo date("Y-m-d H:i:s",$info['F_POSTS_ISSUE_DATE'])?></div>
<div id="description">
<?php 
if($info['F_POSTS_UPLOAD'])										//�ж��Ƿ����ϴ�ͼƬ
{
	echo "<img src='" . UPLOAD_PATH . "{$info['F_POSTS_UPLOAD']}' onload='resizePic(this,400)'>";
	echo "<br>";
}
echo $info['F_POSTS_CONTENTS']
?>
</div>
<div id="info">����:<a href='/Index.php?BlogId=<?php echo $blogid?>&Cat=<?php echo $info['CatId']?>'><?php echo $info['F_CATEGORIES_NAME']?></a>
<?php
if($info['F_POSTS_IS_COMMENTED'] AND $blog_info['F_BLOG_PERM_COMMENTS'])
{														//�жϸ����º͸ò����Ƿ��������
?>
|<a href='#Comments'>����</a>(<?php echo $info['F_POSTS_COMMENTS']?>)
<?php
}
?>
|���ʴ���(<?php echo $info['F_POSTS_VIEWS']?>)</div>
</div>
<?php
if($com_list)												//�ж��Ƿ�������
{
?>
<div id="comments">
<h4>����</h4>
<ul>
<?php
foreach($com_list as $com)									//ѭ����ʾ����
{
	
	echo "<li id='com_user'>{$com['F_COMMENTS_USER']}";
	echo "ʱ�䣺" . date("Y-m-d H:i:s",$com['F_COMMENTS_DATE']);
	echo "</li>";
	echo "<li id='content'>{$com['F_COMMENTS_CONTENT']}</li>";
}
?>
</ul>
</div>
<div id="page"><?php $str = Page($pagecount,$page,$blog->pagesize);echo $str;?></div>
<?php
}
?>
<div id="comments">
<form name="form1" method="post" action="/Index.php?BlogId=<?php echo $blogid?>&Action=Comments&ReturnUrl=<?php echo urlencode($_SERVER['REQUEST_URI'])?>" onSubmit="javascript:return check();">
<div id="comment_user">
<?php
if(isset($_SESSION['User']['User_Name']))						//�ж��Ƿ��½
{
	echo $_SESSION['User']['User_Name'];
	echo "<input name='username' type='hidden' id='username' value='{$_SESSION['User']['User_Name']}'>";
}else{
	echo "�ο�:<input name='username' type='text' id='username'>(����6-16���ַ�)";
}
?>
</div>
<div id="comment_input">
  <textarea name="content" cols="50" rows="10"></textarea> 
  (���۲��ܳ���200���ַ�)
</div>
<div id="submit">
  <input type="submit" name="Submit" value="�ύ">
<input name="postid" type="hidden" id="postid" value="<?php echo $postid?>">
</div>
</form>
</div>
</div>
<div id="right">
<?php require_once("right.php")?>
</div>
</div>
<script language="javacript">
function check()
{
<?php
if(!isset($_SESSION['User']['User_Name']))						//�ж��Ƿ��½
{														//û��½���ж��Ƿ������û�����
?>
	if(document.form1.username.value == '')						//�ж������Ƿ�Ϊ��
	{
		alert('����д����');
		document.form1.username.focus();
		return false;		
	}
	if(!checkByteLength(document.form1.username.value,6,16))		//�ж����Ƴ����Ƿ�Ϸ�
	{
		alert('���Ƴ��Ȳ���ȷ');
		document.form1.username.focus();
		return false;
	}
<?php
}
?>
	if(document.form1.content.value == '')						//�ж������Ƿ�Ϊ��
	{
		alert('����д��������');
		document.form1.content.focus();
		return false;		
	}
	if(!checkByteLength(document.form1.content.value,1,200))		//�ж����ݳ����Ƿ�Ϸ�
	{
		alert('�������ݳ��Ȳ���ȷ');
		document.form1.content.focus();
		return false;
	}
	return true;
}
</script>
<?php
include('footer.php');
?>
