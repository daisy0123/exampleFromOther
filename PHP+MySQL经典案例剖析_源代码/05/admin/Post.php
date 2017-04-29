<?php
$cat = $blog->GetCatList($blogid);
$status = array("1" => "公开","2" => "会员查看","3" => "不公开");
$url = "Index.php?Action=Post";
if($_GET['PostId'])													//判断是否为编辑状态
{
	$info = $blog->getInfo($_GET['PostId'],"EE_BLOG_POSTS");	
	if($info['F_ID_USER_INFO'] != $_SESSION['User']['F_ID'])				//判断是否编辑自己的文章
	{
		echo "您无权编辑此文章";
		exit();
	}
	$url = "Index.php?Action=Post&PostId={$_GET['PostId']}";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')							//判断是否为提交操作
{
	$data = array();
	$time = time();
	$upload = "";
	if($_FILES['file']['size'] > 0)										//判断是否有上传图片
	{
		$result = upload($_FILES['file'],UPLOAD_PATH,MAX_UPLOAD_SIZE);	//上传图片
		if($result['errocode'] == 'size_erro')								//判断图片是否过大
		{
			echo "图片过大，不能超过200K";
			exit();
		}
		if($result['errocode'] == 'type_erro')								//判断文件类型是不是图片
		{
			echo "上传文件不是图片";
			exit();
		}
		$upload = $result['file_name'];									//取得上传地址
	}
	$data['F_ID_CATEGORIES'] = $_POST['catid'];
	$data['F_ID_USER_INFO'] = $_SESSION['User']['F_ID'];
	$data['F_POSTS_MOD_DATE'] = $time;
	$data['F_POSTS_STATUS'] = $_POST['status'];
	$data['F_POSTS_CONTENTS'] = $_POST['content'];
	$data['F_POSTS_TITLE'] = $_POST['title'];
	$data['F_POSTS_IS_COMMENTED'] = ($_POST['comment']) ? 1 : 0;
	$data['F_POSTS_UPLOAD'] = $upload;
	if($_GET['PostId'])												//判断是否为编辑状态
	{
		if($blog->updateData("EE_BLOG_POSTS",$_GET['PostId'],$data))		//判断是否更新成功
		{
			header("Location:Index.php?Action=PostList");
			exit();
		}
	}else{
		$data['F_POSTS_ISSUE_DATE'] = $time;
		$data['F_POSTS_VIEWS'] = 0;
		$data['F_POSTS_COMMENTS'] = 0;
		if($blog->insertData("EE_BLOG_POSTS",$data))					//判断是否插入数据成功
		{
			$blog->UpdateCatPosts($_POST['catid']);							//更新分类文章数
			header("Location:Index.php?Action=PostList");
			exit();
		}
	}
}
?>
<script language="javascript" src="/js/Base.js"></script>
<ul id="submenu">
<li><a href="Index.php?Action=Post">写文章</a></li>
<li><a href="Index.php?Action=PostList">文章列表</a></li>
</ul>
<div class="wrap">
<h2>写文章</h2>
<form name="form1" method="post" action="<?php echo $url?>" onsubmit="return check();">
<fieldset><legend>标题</legend>
<div><input id=title name=title value="<?php echo $info['F_POSTS_TITLE']?>"></div></fieldset> 
<fieldset><legend>内容</legend>
<div><TEXTAREA id=content name=content rows=10 cols=60><?php echo $info['F_POSTS_CONTENTS']?></TEXTAREA>
</div>
</fieldset> 
<P><input id=post type=submit value=发布 name=post>
<input type=reset value=重写 name=submit>
</P>
<fieldset>
<h2>上传文件</h2>
<div id="upload"><input type="file" name="file"></div>
</fieldset>
<fieldset>
<h3>分类</h3>
<ul>
<?php
foreach($cat as $value)								//循环输出分类
{
	if(isset($info['F_ID_CATEGORIES']))					//判断是否提取了文章分类ID
	{
		if($info['F_ID_CATEGORIES'] == $value['F_ID'])	//判断被编辑文章的分类ID是否与该分类相等
			$checked = "checked='checked' ";
	}else{
		if($value['F_ID'] == 1)						//默认选择默认分类
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
<h3>评论</h3>
<div>
<label>
<?php
$checked = "checked='checked' ";
if($info['F_POSTS_IS_COMMENTED'] == 0)				//判断被编辑文章的评论状态是否为0
	$checked = "";
?>
<input id=comment type=checkbox <?php echo $checked?>value=1 name=comment>
允许评论
</label></div>
</fieldset> 
<fieldset>
<h3>文章状态</h3>
<div>
<?php
for($i=1;$i<=3;$i++)									//循环输出文章状态选项
{
echo "<label>";
echo "<input name=status type=radio id=status value=1";
if(isset($info['F_POSTS_STATUS']))						//判断是否为编辑状态
{
	if($info['F_POSTS_STATUS'] == $i)					//判断被编辑文章的状态是否和此状态相同
		echo " checked";
}else{
	if($i == 1)										//默认选定公开状态
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
	if(document.form1.title.value == '')							//检查标题是否为空
	{
		alert('请填写标题');									//如果为空，则提示
		document.form1.title.focus();							//焦点定位到标题输入框
		return false;
	}
	if(!checkByteLength(document.form1.title.value,1,255))			//判断标题长度是否正确
	{
		alert('标题长度不正确，长度为1-255个字符');				//不正确，则提示
		document.form1.title.focus();							//焦点定位到标题输入框
		return false;
	}
	if(document.form1.content.value == '')						//检查内容是否为空
	{
		alert('请填写内容');									//如果为空，则提示
		document.form1.content.focus();						//焦点定位到内容输入框
		return false;		
	}
	return true;
}
</script>
