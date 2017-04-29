<?php
$class = $blog->GetCatList($blogid);									//取得该博客的分类列表
$new_post = $blog->GetPostList($blogid,0,'','',$status,1,5);				//取得最新的5篇文章
$comments = $blog->GetCommentsList($blogid,$postid,5);				//取得最新的5条评论
?>
<div id="main">
<div id="blog">
<h2><?php echo $blog_info['F_BLOG_NAME']?></h2>					//显示博客标题
<?php echo $blog_info['F_BLOG_DESCRIPTION']?>					//显示博客描述
</div>
<div id="user">
<div id="head">
<img src="<?php												//显示博客主头像
if($user_info['F_USER_HEAD']) 
	echo UPLOAD_PATH . $user_info['F_USER_HEAD'];
else 
	echo "/images/default.gif";
?>" onload="resizePic(this,200)">
</div>
<div id="name">
<?php 
if($user_info['F_USER_NICKNAME'])								//判断博客主是否有昵称
	echo $user_info['F_USER_NICKNAME'];							//有则显示昵称
else
	echo $user_info['F_USER_NAME'];								//无则显示用户名
?>
</div>
</div>
<div id="calendar">
<?php require("Calendar.php") ?>									//包含日历文件
</div>
<div id="class">
<h2>日志分类</h2>
<ul>
<?php
if($class)														//判断是否有分类
{
	foreach($class as $value)										//循环显示分类
	{
		echo "<li><a href='/Index.php?BlogId=$blogid&Cat={$value[F_ID]}'>";
		echo "{$value[F_CATEGORIES_NAME]}</a>({$value[F_CATEGORIES_POSTS]})</li>";
	}
}
?>
</ul>
</div>
<div id="new_post">
<h2>最新日志</h2>
<ul>
<?php
if($new_post)													//判断是否有新文章
{
	foreach($new_post as $post)									//循环显示文章
	{
		echo "<li><a href='/Index.php?BlogId=$blogid&Action=Post&Post={$post['F_ID']}'>";
		if(mb_strlen($post['F_POSTS_TITLE']) > 10)					//判断标题是否大于10个字符
			echo mb_substr($post['F_POSTS_TITLE'],0,10) . "...";		//大于则截取显示
		else 
			echo $post['F_POSTS_TITLE'];							//小于或等于则完整显示
		echo "</a></li>";
	}
}
?>
</ul>
</div>
<div id="new_comments">
<h2>最新评论</h2>
<ul>
<?php
if($comments)													//判断是否有评论
{
	foreach ($comments as $value)								//循环显示评论
	{
		echo "<li><a href='/Index.php?BlogId=$blogid&Action=Post&Post={$value['F_ID_POSTS_INFO']}#Comments'>";
		if(mb_strlen($value['F_COMMENTS_CONTENT']) > 10)			//判断评论内容是否大于10个字符
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
<h2>操作</h2>
<ul>
<?php
if(isset($_SESSION['User']['F_ID']))									//判断用户是否登陆
{
?>
<li><a href="/Login.php">登陆</a></li>
<li><a href="/Register.php">注册</a></li>
<?php
}else{
?>
<li><a href="/admin/Index.php">用户管理</a></li>
<?php
}
?>
</ul>
</div>
<div id="search">
<form name="search" id="search" action="/Index.php" method="GET">
<h2>搜索</h2>
<div id="keyword"><input type="text" name="Keywords" /><input type="submit" name="Submit" value="提交" /></div>
</form>
</div>
<div id="rss">
<a href="/rss/Index.php"><img src="/images/rss.gif" border="0"></a>
</div>
</div>
