<?php
$catid = 0;
if($_GET['CatId'])											//�ж��Ƿ��з���ID
	$catid = $_GET['CatId'];
$keyword = '';
if($_GET['Keywords'])										//�ж��Ƿ��������ؼ���
	$keyword = $_GET['Keywords'];
$page = $_GET['Page'];
if(!$page)													//�ж��Ƿ���ҳ��,Ĭ��Ϊ1
	$page = 1;
$list = $blog->GetPostList($blogid,$catid,$keyword,'',0,$page,$blog->pagesize);
$count = $blog->GetPostCount($blogid,$catid,$keyword,'',0); 
$pagecount = ceil($count/$blog->pagesize); 						//����ҳ��
if(!$pagecount)												//���ҳ��Ϊ0,��Ĭ��Ϊ1
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
  <li><a href="Index.php?Action=Post">д����</a></li>
  <li><a href="Index.php?Action=PostList">�����б�</a></li>
</ul>
<div class="wrap">
  <h2>�����б�</h2>
  <form action="" method="post" name="searchform" id="searchform" onsubmit="javascript:return goSearch();">
    <fieldset>
      <legend>�������¡�</legend>
      <input size="17" name="Keywords" />
      <input type="submit" value="����" name="submit" />
    </fieldset>
  </form>
  <form action="" method="post" name="viewcat" id="viewcat" onsubmit="javascript:return goSearchByCat();">
    <fieldset>
      <legend>������࡭</legend>
      <select name="CatId">
        <option value="0" selected="selected">All</option>
		<?php
		foreach ($cat as $value) {
			echo "<option value='" . $value[F_ID] . "'>" . $value[F_CATEGORIES_NAME] . "</option>";
		}
		?>
      </select>
      <input type="submit" value="��ʾ����" name="submit2" />
    </fieldset>
  </form>
  <table class="widefat">
      <tr>
        <th width="6%" scope="col">ID</th>
        <th width="21%" scope="col">ʱ��</th>
        <th width="33%" scope="col">����</th>
        <th width="8%" scope="col">����</th>
        <th width="8%" scope="col">����</th>
        <th colspan="3" scope="col">����</th>
      </tr>
<?php
if($list)													//�ж��Ƿ�������
{
	foreach($list as $value)									//ѭ����ʾ�����б�
	{
?>	
     <tr>
        <th><?php echo $value['F_ID']?></th>
        <td><?php echo date('Y-m-d H:i',$value['F_POSTS_ISSUE_DATE']);?></td>
        <td><?php echo $value['F_POSTS_TITLE']?></td>
        <td><?php echo $value['F_CATEGORIES_NAME']?></td>
        <td><a href='Index.php?Action=Comments&PostId=<?php echo $value['F_ID']?>'><?php echo $value['F_POSTS_COMMENTS']?></a></td>
        <td><a href="/Index.php?BlogId=<?php echo $blogid?>&Post=<?php echo $value['F_ID']?>&Action=Post" target="_blank">�鿴</a></td>
        <td><a href="Index.php?Action=Post&PostId=<?php echo $value['F_ID']?>">�༭</a></td>
        <td><a onclick="return confirm('���Ҫɾ����');" href="Index.php?Action=DelPost&PostId=<?php echo $value['F_ID']?>">ɾ��</a></td>
      </tr>
<?php
	}
}
?>
  </table>
  <div id="page"><?php echo Page($pagecount,$page,$blog->pagesize)?></div>
  </div>
</div>
