<?php
$post = 0;
if($_GET['PostId'])													//判断是否有文章ID
{
	$post = $_GET['PostId'];
	$info = $blog->getInfo($post,"EE_BLOG_POSTS");
	if($info['F_ID_USER_INFO'] != $_SESSION['User']['F_ID'])				//判断此文章是否是该用户的
	{
		echo "你无权查看评论";
		exit();
	}
	$title = "<p>文章：{$info['F_POSTS_TITLE']}</p>";
}	
$page = 1;
if($_GET['Page'])													//判断是否有页码
	$page = $_GET['Page'];
$list = $blog->GetCommentsList($blogid,$post,$blog->pagesize,$page);
$count = $blog->GetCommentsCount($blogid,$post);
$pagecount = ceil($count/$blog->pagesize);
if(!$pagecount)														//判断是否有页数,默认为1
	$pagecount = 1;
?>
<div class="wrap">
<h2>评论</h2>
<ul>
<?php 
echo $title;
if($list)															//判断是否有评论
{
	foreach($list as $value)											//循环显示评论
	{
?>
  <li>
  <p><strong><?php echo $value['F_COMMENTS_USER']?></strong> | 
  IP 地址: <?php echo long2ip($value['F_COMMENTS_USER_IP'])?></p>
  <p><?php echo $value['F_COMMENTS_CONTENT']?></P>
  <p><?php echo date("Y-m-d H:i",$value['F_COMMENTS_DATE'])?>  — 
  [ <a onclick="return confirm('真的要删除吗?');" href="Index.php?Action=DelComments&ComId=<?php echo $value['F_ID']?>">删除</a>
   | <a href="/Index.php?BlogId=<?php echo $blogid?>&Post=<?php echo $value['F_ID_POSTS_INFO']?>&Action=Post" target="_blank">查看文章</a> ]</p></li>
<?php
	}
}
?>
</ul>
<div id="page"><?php echo Page($pagecount,$page,$blog->pagesize)?></div>
</div>
