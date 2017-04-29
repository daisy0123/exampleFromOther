<?php
$class = $blog->GetCatList($blogid);									//ȡ�øò��͵ķ����б�
$new_post = $blog->GetPostList($blogid,0,'','',$status,1,5);				//ȡ�����µ�5ƪ����
$comments = $blog->GetCommentsList($blogid,$postid,5);				//ȡ�����µ�5������
?>
<div id="main">
<div id="blog">
<h2><?php echo $blog_info['F_BLOG_NAME']?></h2>					//��ʾ���ͱ���
<?php echo $blog_info['F_BLOG_DESCRIPTION']?>					//��ʾ��������
</div>
<div id="user">
<div id="head">
<img src="<?php												//��ʾ������ͷ��
if($user_info['F_USER_HEAD']) 
	echo UPLOAD_PATH . $user_info['F_USER_HEAD'];
else 
	echo "/images/default.gif";
?>" onload="resizePic(this,200)">
</div>
<div id="name">
<?php 
if($user_info['F_USER_NICKNAME'])								//�жϲ������Ƿ����ǳ�
	echo $user_info['F_USER_NICKNAME'];							//������ʾ�ǳ�
else
	echo $user_info['F_USER_NAME'];								//������ʾ�û���
?>
</div>
</div>
<div id="calendar">
<?php require("Calendar.php") ?>									//���������ļ�
</div>
<div id="class">
<h2>��־����</h2>
<ul>
<?php
if($class)														//�ж��Ƿ��з���
{
	foreach($class as $value)										//ѭ����ʾ����
	{
		echo "<li><a href='/Index.php?BlogId=$blogid&Cat={$value[F_ID]}'>";
		echo "{$value[F_CATEGORIES_NAME]}</a>({$value[F_CATEGORIES_POSTS]})</li>";
	}
}
?>
</ul>
</div>
<div id="new_post">
<h2>������־</h2>
<ul>
<?php
if($new_post)													//�ж��Ƿ���������
{
	foreach($new_post as $post)									//ѭ����ʾ����
	{
		echo "<li><a href='/Index.php?BlogId=$blogid&Action=Post&Post={$post['F_ID']}'>";
		if(mb_strlen($post['F_POSTS_TITLE']) > 10)					//�жϱ����Ƿ����10���ַ�
			echo mb_substr($post['F_POSTS_TITLE'],0,10) . "...";		//�������ȡ��ʾ
		else 
			echo $post['F_POSTS_TITLE'];							//С�ڻ������������ʾ
		echo "</a></li>";
	}
}
?>
</ul>
</div>
<div id="new_comments">
<h2>��������</h2>
<ul>
<?php
if($comments)													//�ж��Ƿ�������
{
	foreach ($comments as $value)								//ѭ����ʾ����
	{
		echo "<li><a href='/Index.php?BlogId=$blogid&Action=Post&Post={$value['F_ID_POSTS_INFO']}#Comments'>";
		if(mb_strlen($value['F_COMMENTS_CONTENT']) > 10)			//�ж����������Ƿ����10���ַ�
			echo mb_substr($value['F_COMMENTS_CONTENT'],0,10) . "...";
		else 
			echo $value['F_COMMENTS_CONTENT'];
		echo "</a></li>";
	}
}
?>
</ul>
</div>
<div id="opa">
<h2>����</h2>
<ul>
<?php
if(isset($_SESSION['User']['F_ID']))									//�ж��û��Ƿ��½
{
?>
<li><a href="/Login.php">��½</a></li>
<li><a href="/Register.php">ע��</a></li>
<?php
}else{
?>
<li><a href="/admin/Index.php">�û�����</a></li>
<?php
}
?>
</ul>
</div>
<div id="search">
<form name="search" id="search" action="/Index.php" method="GET">
<h2>����</h2>
<div id="keyword"><input type="text" name="Keywords" /><input type="submit" name="Submit" value="�ύ" /></div>
</form>
</div>
<div id="rss">
<a href="/rss/Index.php"><img src="/images/rss.gif" border="0"></a>
</div>
</div>
