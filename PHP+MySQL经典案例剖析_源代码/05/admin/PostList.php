<?php
$catid = 0;
if($_GET['CatId'])											//判断是否有分类ID
	$catid = $_GET['CatId'];
$keyword = '';
if($_GET['Keywords'])										//判断是否有搜索关键字
	$keyword = $_GET['Keywords'];
$page = $_GET['Page'];
if(!$page)													//判断是否有页码,默认为1
	$page = 1;
$list = $blog->GetPostList($blogid,$catid,$keyword,'',0,$page,$blog->pagesize);
$count = $blog->GetPostCount($blogid,$catid,$keyword,'',0); 
$pagecount = ceil($count/$blog->pagesize); 						//计算页数
if(!$pagecount)												//如果页数为0,则默认为1
	$pagecount = 1;
$cat = $blog->GetCatList($blogid);
?>
<script language="javascript">
function goSearch() {
	window.location = 'Index.php?Action=PostList&Keywords=' + document.searchform.Keywords.value;
	return false;
}
function goSearchByCat() {
	window.location = 'Index.php?Action=PostList&CatId=' + document.viewcat.CatId.options[document.viewcat.CatId.selectedIndex].value;
	return false;
}
</script>
<ul id=submenu>
  <li><a href="Index.php?Action=Post">写文章</a></li>
  <li><a href="Index.php?Action=PostList">文章列表</a></li>
</ul>
<div class="wrap">
  <h2>文章列表</h2>
  <form action="" method="post" name="searchform" id="searchform" onsubmit="javascript:return goSearch();">
    <fieldset>
      <legend>搜索文章…</legend>
      <input size="17" name="Keywords" />
      <input type="submit" value="搜索" name="submit" />
    </fieldset>
  </form>
  <form action="" method="post" name="viewcat" id="viewcat" onsubmit="javascript:return goSearchByCat();">
    <fieldset>
      <legend>浏览分类…</legend>
      <select name="CatId">
        <option value="0" selected="selected">All</option>
		<?php
		foreach ($cat as $value) {
			echo "<option value='" . $value[F_ID] . "'>" . $value[F_CATEGORIES_NAME] . "</option>";
		}
		?>
      </select>
      <input type="submit" value="显示分类" name="submit2" />
    </fieldset>
  </form>
  <table class="widefat">
      <tr>
        <th width="6%" scope="col">ID</th>
        <th width="21%" scope="col">时间</th>
        <th width="33%" scope="col">标题</th>
        <th width="8%" scope="col">分类</th>
        <th width="8%" scope="col">评论</th>
        <th colspan="3" scope="col">操作</th>
      </tr>
<?php
if($list)													//判断是否有文章
{
	foreach($list as $value)									//循环显示文章列表
	{
?>	
     <tr>
        <th><?php echo $value['F_ID']?></th>
        <td><?php echo date('Y-m-d H:i',$value['F_POSTS_ISSUE_DATE']);?></td>
        <td><?php echo $value['F_POSTS_TITLE']?></td>
        <td><?php echo $value['F_CATEGORIES_NAME']?></td>
        <td><a href='Index.php?Action=Comments&PostId=<?php echo $value['F_ID']?>'><?php echo $value['F_POSTS_COMMENTS']?></a></td>
        <td><a href="/Index.php?BlogId=<?php echo $blogid?>&Post=<?php echo $value['F_ID']?>&Action=Post" target="_blank">查看</a></td>
        <td><a href="Index.php?Action=Post&PostId=<?php echo $value['F_ID']?>">编辑</a></td>
        <td><a onclick="return confirm('真的要删除吗？');" href="Index.php?Action=DelPost&PostId=<?php echo $value['F_ID']?>">删除</a></td>
      </tr>
<?php
	}
}
?>
  </table>
  <div id="page"><?php echo Page($pagecount,$page,$blog->pagesize)?></div>
  </div>
</div>
