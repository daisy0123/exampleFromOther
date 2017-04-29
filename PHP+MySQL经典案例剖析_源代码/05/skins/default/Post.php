<?php
include('header.php');											//包含头文件
$postid = $_GET['Post'];											//取得文章ID
$info = $blog->GetPosts($postid);									//提取文章信息
if(!$info)														//判断信息是否为空
{
	echo "无此文章";
	exit();
}
$blog->UpdatePostView($postid);
$status = 0;
if(!isset($_SESSION['User']['F_ID']))									//判断该用户是否登陆
{
	$status = 1;
	if($info['F_POSTS_STATUS'] != 1)								//判断该用户是否有权访问此文章
	{
		echo "对不起，你无权访问此文章";
		exit();
	}
}else{
	if(!($blog_user['F_ID_USER_INFO'] == $_SESSION['User']['F_ID']))		//判断该用户是否是博客主
	{
		$status = 2;
		if($info['F_POSTS_STATUS'] != 1 && $info['F_POSTS_STATUS'] != 2)//判断该用户是否有权访问此文章
		{
			echo "对不起，你无权访问此文章";
			exit();		
		}
	}
}
if($info['F_POSTS_IS_COMMENTED'] AND $blog_info['F_BLOG_PERM_COMMENTS'])//判断该博客和文章是否可评论
{
	$page = $_GET['Page'];										//取得当前页码
	if(!$page)													//无页码默认为1
		$page = 1;
	$com_list = $blog->GetCommentsList($blogid,$postid,0,$page);		//提取评论列表
	$count = $blog->GetCommentsCount($blogid,$postid);				//提取评论条数
	$pagecount = ceil($count/$blog->pagesize);						//计算评论页数
	if(!$pagecount)												//如果页数为0则默认为1
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
if($info['F_POSTS_UPLOAD'])										//判断是否有上传图片
{
	echo "<img src='" . UPLOAD_PATH . "{$info['F_POSTS_UPLOAD']}' onload='resizePic(this,400)'>";
	echo "<br>";
}
echo $info['F_POSTS_CONTENTS']
?>
</div>
<div id="info">分类:<a href='/Index.php?BlogId=<?php echo $blogid?>&Cat=<?php echo $info['CatId']?>'><?php echo $info['F_CATEGORIES_NAME']?></a>
<?php
if($info['F_POSTS_IS_COMMENTED'] AND $blog_info['F_BLOG_PERM_COMMENTS'])
{														//判断该文章和该博客是否可以评论
?>
|<a href='#Comments'>评论</a>(<?php echo $info['F_POSTS_COMMENTS']?>)
<?php
}
?>
|访问次数(<?php echo $info['F_POSTS_VIEWS']?>)</div>
</div>
<?php
if($com_list)												//判断是否有评论
{
?>
<div id="comments">
<h4>评论</h4>
<ul>
<?php
foreach($com_list as $com)									//循环显示评论
{
	
	echo "<li id='com_user'>{$com['F_COMMENTS_USER']}";
	echo "时间：" . date("Y-m-d H:i:s",$com['F_COMMENTS_DATE']);
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
if(isset($_SESSION['User']['User_Name']))						//判断是否登陆
{
	echo $_SESSION['User']['User_Name'];
	echo "<input name='username' type='hidden' id='username' value='{$_SESSION['User']['User_Name']}'>";
}else{
	echo "游客:<input name='username' type='text' id='username'>(名称6-16个字符)";
}
?>
</div>
<div id="comment_input">
  <textarea name="content" cols="50" rows="10"></textarea> 
  (评论不能超过200个字符)
</div>
<div id="submit">
  <input type="submit" name="Submit" value="提交">
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
if(!isset($_SESSION['User']['User_Name']))						//判断是否登陆
{														//没登陆则判断是否输入用户名称
?>
	if(document.form1.username.value == '')						//判断名称是否为空
	{
		alert('请填写名称');
		document.form1.username.focus();
		return false;		
	}
	if(!checkByteLength(document.form1.username.value,6,16))		//判断名称长度是否合法
	{
		alert('名称长度不正确');
		document.form1.username.focus();
		return false;
	}
<?php
}
?>
	if(document.form1.content.value == '')						//判断内容是否为空
	{
		alert('请填写评论内容');
		document.form1.content.focus();
		return false;		
	}
	if(!checkByteLength(document.form1.content.value,1,200))		//判断内容长度是否合法
	{
		alert('评论内容长度不正确');
		document.form1.content.focus();
		return false;
	}
	return true;
}
</script>
<?php
include('footer.php');
?>
