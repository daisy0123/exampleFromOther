<?php
$cat = $blog->GetCatList($blogid);
$title = "添加分类";
$url = "Index.php?Action=Class";
if($_GET['CatId'])										//判断是否有分类ID,有则是编辑分类状态
{
	$info = $blog->getInfo($_GET['CatId'],'EE_BLOG_CATEGORIES');
	if(!$info)											//判断是否此分类ID存在
	{
		echo "该分类不存在";
		exit();
	}
	$title = "编辑分类";
	$url = "Index.php?Action=Class&CatId={$_GET['CatId']}";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')				//判断是否为提交操作
{
	$data = array();
	$data['F_ID_BLOG_INFO'] = $blogid;
	$data['F_CATEGORIES_NAME'] = $_POST['cat_name'];
	$data['F_CATEGORIES_DESCRIPTION'] = $_POST['description'];
	if($_GET['CatId'])									//判断是否为编辑状态
	{
		$blog->updateData('EE_BLOG_CATEGORIES',$_GET['CatId'],$data);
		header("Location:Index.php?Action=Class");
		exit();
	}else{
		$blog->insertData('EE_BLOG_CATEGORIES',$data);
		header("Location:Index.php?Action=Class");
		exit();
	}
}
?>
<div id=main>
<?php
if(!$_GET['CatId'])										//判断是否为编辑状态,不是则显示分类列表
{
?>
<div class="wrap">
<h2>分类 (<A href="#addcat">添加新分类</A>) </h2>
<table>
  <tr>
    <th>ID<th/>
    <th>名称</th>
    <th>描述</th>
    <th>文章</th>
    <th colspan="2">操作</th>
  </tr>
<?php
foreach($cat as $value)
{
?>
  <tr>
    <th><?php echo $value['F_ID']?></th>
    <th><?php echo $value['F_CATEGORIES_NAME']?></th>
    <th><?php echo $value['F_CATEGORIES_DESCRIPTION']?></th>
    <th><a href="Index.php?CatId=<?php echo $value['F_ID']?>&Action=Class">编辑</a></th>
    <th>
    <?php
    if($value['F_CATEGORIES_DEFAULT'] == 1)								//判断是否为默认分,是则显示默认
    	echo "默认";
    else{											//不是则显示删除操作
    	echo "<a href=\"Index.php?CatId={$value['F_ID']}&Action=ClassDel\"";
    	echo " onclick=\"javascript:confirm('真的要删除吗？')\">删除</a>";
	}
    ?>
	</th>
  </tr>
<?php
 }
?>
</table>
</div>
<div class="wrap">
<p><strong>注意</strong>: <br />
  删除一个分类并不会删除其中的书签。被删除分类中的所有文章将会转移到默认分类中。</p>
</div>
<?php
}
?>
<div class=wrap>
<H2><?php echo $title?></H2>
<form id=addcat name=addcat action="<?php echo $url?>" method=post onsubmit="javascript:return check();" >
<table class=editform cellSpacing=2 cellPadding=5 width="80%">
  <tr>
    <th>分类名称:</th>
    <td><input id=cat_name size=40 name=cat_name value="<?php echo $info['F_CATEGORIES_NAME']?>"></td>
  </tr>
  
  <tr>
    <th vAlign=top scope=row>描述:(可选)</th>
    <td><textarea id=description name=description rows=5 cols=50><?php echo $info['F_CATEGORIES_DESCRIPTION']?></textarea></td>
	</tr>
</table>
<P><input type=submit value="<?php echo $title?>" name=submit></P>
<script language="javacript">
/**
 *功能：检测表单提交数据
 *
 */
function check()
{
	if(document.addcat.cat_name.value == '')							//判断分类名称是否为空
	{
		alert('请填写分类名称');									//为空则提示
		document.addcat.cat_name.focus();							//定位焦点到分类名称输入框
		return false;		
	}
	if(!checkByteLength(document.addcat.cat_name.value,1,50))			//判断分类名称长度是否合法
	{
		alert('分类名称长度不正确，长度为1-50个字符');				//不合法则提示
		document.addcat.cat_name.focus();							//定位焦点到分类名称输入框
		return false;
	}
	if(document.addcat.description.value != '')							//判断描述是否为空
	{
		if(!checkByteLength(document.addcat.description.value,1,100))	//不为空则判断长度是否合法
		{
			alert('分类描述长度不正确，长度为1-100个字符');			//不合法则提示
			document.addcat.description.focus();					//定位焦点到分类描述输入框
			return false;
		}
	}
	return true;
}
</script>
</form>
</div>
