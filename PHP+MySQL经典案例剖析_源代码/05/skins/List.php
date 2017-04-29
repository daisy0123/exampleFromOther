<?php
include('header.php');										//包含头文件
$page = $_GET['Page'];										//取得当前页码
if(!$page)													//如果无页码则默认为1
	$page = 1;
$cat = $_GET['Cat'];											//取得当前分类ID
if(!$cat)													//如果无分类ID则默认为0
	$cat = 0;
$keyword = $_GET['Keywords'];								//取得搜索关键字
if(!$keyword)												//如果无关键字则默认为空
	$keyword = '';
$date = $_GET['Date'];										//取得搜索日期
if(!$date)													//如果无日期则默认为空
	$date = '';
$status = 0;												//设置取文章的状态,默认为取所有文章
if(!isset($_SESSION['User']['F_ID']))								//如果是游客则提取公开的文章
{
	$status = 1;
}else{
	if(!($blog_user['F_ID_USER_INFO'] == $_SESSION['User']['F_ID']))	//如果是登陆用户但不是博客主
	{													//则提取公开和只给会员看的文章列表
		$status = 2;
	}
}
$list = $blog->GetPostList($blogid,$cat,$keyword,$date,$status,$page);	//按条件提取文章列表
$count = $blog->GetPostCount($blogid,$cat,$keyword,$date,$status);	//提取文章数目
$pagecount = ceil($count/$blog->pagesize);						//计算页数
if(!$pagecount)												//如果计算页数为0则默认为1
	$pagecount = 1;
?>
<div id="main">
<div id="left">
<?php
if($list)													//判断是否有文章
{
	foreach($list as $value)									//循环显示文章
	{
?>
<div id="post">
<div id="title"><a href='/Index.php?BlogId=<?php echo $blogid?>&Action=Post&Post=<?php echo $value['F_ID']?>'><?php echo $value['F_POSTS_TITLE']?></a></div>
<div id="time"><?php echo date("Y-m-d H:i:s",$value['F_POSTS_ISSUE_DATE'])?></div>
<div id="description">
<?php
if($value['F_POSTS_UPLOAD'])								//判断是否有上传图片
{
	echo “<img src='" . UPLOAD_PATH . "{$value['F_POSTS_UPLOAD']}' onload='resizePic(this,400)'>";
}
if(mb_strlen($value['F_POSTS_CONTENTS']) > 50)					//判断文字信息是否大于50个字符
	echo mb_substr($value['F_POSTS_CONTENTS'],0,50) . “…";		//截取50个字符显示
else
	echo $value['F_POSTS_CONTENTS'];						//显示完整内容
?></div>
<div id="info">
分类:<a href='/Index.php?BlogId=<?php echo $blogid?>&Cat=<?php echo $value['CatId']?>'><?php echo $value['F_CATEGORIES_NAME']?></a>
<?php
if($value['F_POSTS_IS_COMMENTED'] AND $blog_info['F_BLOG_COMMENTS'])
{														//判断该文章和该博客是否可以评论
?>
|<a href='/Index.php?BlogId=<?php echo $blogid?>&Action=Post&Post=<?php echo $value['F_ID']?>#Comments'>评论</a>(<?php echo $value['F_POSTS_COMMENTS']?>)
<?php
}
?>
|访问次数(<?php echo $value['F_POSTS_VIEWS']?>)</div>
</div>
<?php
	}
}
?>
<div id="page">
<?php $str = Page($pagecount,$page,$blog->pagesize);echo $str;?>	//输出分页信息
</div>
</div>
<div id="right">
<?php require_once("Right.php")?>								//包含右部分文件
</div>
</div>
<?php
include('footer.php');											//包含底部文件
?>
