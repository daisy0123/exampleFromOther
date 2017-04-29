<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'function.inc.php'); ?>
<?php
$News = new News();
if (!$_GET['Page'] < 1) $curr_page = 1;								//判断是否无页码
$List = array();
$Pagesize = 10;
$List = $News->GetNewsList(0,$curr_page = 1,$Pagesize,$keyword='',0,1);
$Count = $News->GetNewsCount(0,$keyword='',0,1);
$Pagecount = ceil($Count / $Pagesize);
if(!$Pagecount) $Pagecount = 1;
if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否提交操作
{
	if($_POST['del_id'])											//判断是否选择了信息
	{
		foreach($_POST['del_id'] as $id)							//循环恢复信息
		{
			$News->ReloadNews($id);
		}
	}
}
?>
  <table width="100%" border="0" cellspacing="0">
    <tr> 
      <td colspan="2" class="caption">信 息 回 收 站</td>
    </tr>
    <tr> 
      <td colspan="2"> 
        <?php echo Page($Pagecount,$curr_page,$Pagesize); ?>
      </td>
    </tr>
    <tr> 
      <td colspan="2"> 
	  <form name="form1" method="post" action="">
	  <table width="100%" border="0">
          <tr> 
            <th width="28"> <input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"> 
            </th>
            <th width="402">标题</th>
            <th width="99">管理</th>
          </tr>
<?php
foreach($List as $key => $news){									//循环显示回收站信息
	extract($news);
	$bgstr = "bgcolor=" . ($key % 2 ? "#eeeeee" : "#ffffff");
?>
          <tr <?php echo $bgstr ?>> 
            <td align="center"> <?php echo "<input type='checkbox' name='del_id[]' value='$F_ID'>" ?> 
            </td>
            <td> <?php echo $F_NDT_CAPTION ?> </td>
            <td align="center"><a href="<?php echo $F_NDT_CONTENT_URL ?>" target="_blank">查看</a></td>
          </tr>
<?php
}
?>
    <tr> 
      <th colspan="3"> &nbsp; <input name="cmdDel" type="submit" id="cmdAdd22" value="恢复新闻">
        &nbsp; <input type="button" name="Button" value="彻底删除" onClick="javascript:del_news_()">
        &nbsp; </th>
    </tr>
        </table>
</form>
		</td>
    </tr>
  </table>
<script language="JavaScript">
/**
 * 功能：实现全选效果
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){					//遍历表单元素
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;	//判断该复选框是否是全选框
	}
}
/**
 * 功能：转向信息删除文件
 */
function del_news_(){
	document.form1.action = "DelNews.php?Type=2&MenuId=<?php echo $_GET['MenuId']?>";
	document.form1.submit();
}
</script>
