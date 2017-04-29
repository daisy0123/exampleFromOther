<?php
$info = $blog->getInfo($blogid,'em_blog_info');
$menu = array();
switch ($action) {
	case 'Post':
	case 'PostList':
		$menu['post'] = 'class=current ';
		break;
	case 'Class':
		$menu['class'] = 'class=current ';
		break;
	case 'Comments':
		$menu['comment'] = 'class=current ';
		break;
	case 'BlogSet':
		$menu['blogset'] = 'class=current ';
		break;
	case 'UserSet':
		$menu['userset'] = 'class=current ';
		break;
}
?>
<!DOCTYPE html PUBliC "-//W3C//DTD html 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html lang=zh-CN xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>博客管理</TITLE>
<meta http-equiv=Content-Type content="text/html; charset=gb2312">
<link href="/style/admin.css" type=text/css rel=stylesheet>
</head>
<body>
<div id=wphead>
<h1><?php echo $info['F_BLOG_NAME']?></h1></div>
<div id=user_info>
<p>您好， <strong><?php echo $_SESSION['User']['User_Name']?></strong>。<a href="../Index.php?BlogId=<?php echo $blogid?>">访问博客</a></p></div>
<ul id=adminmenu>
  <li><a <?php echo $menu['post']?>href="./">文章管理</a> 
  <li><a <?php echo $menu['class']?>href="?Action=Class">分类管理</a>
  <li><a <?php echo $menu['comment']?>href="?Action=Comments">评论管理</a> 
  <li><a <?php echo $menu['blogset']?>href="?Action=BlogSet">Blog设置</a> 
  <li><a <?php echo $menu['userset']?>href="?Action=UserSet">个人设置</a> 
</ul>