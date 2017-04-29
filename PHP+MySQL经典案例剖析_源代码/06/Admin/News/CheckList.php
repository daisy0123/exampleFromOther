<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'function.inc.php'); ?>
<?php
$News = new News();
if (!$_GET['Page']) $curr_page = 1;								//判断是否有页码,默认为1
$Class = $News->getInfo($_GET['id'],"EM_CLASS_INFO");
$Pagesize = 10;
$List = array();
$List = $News->GetNewsList($_GET['id'],$curr_page,$Pagesize,"",1);
$NewsCount = $News->GetNewsCount($_GET['id'],"",1);
$Pagecount = ceil($NewsCount / $Pagesize);
if(!$Pagecount) $Pagecount = 1;
if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否提交审核
{
	if($_POST[del_id])										//判断是否有选择信息
	{
		foreach($_POST[del_id] as $id)						//循环审核信息
			$News->Check($id);
	}
}
?>
  <table width="90%" border="0" align="center" cellspacing="0">
	<tr> 
	  <td colspan="2" class="caption">信 息 审 核</td>
	</tr>
	<tr> 
	  <td class="stress">当前类别：<?php echo $Class['F_CLASS_NAME'] ?></td>
	  <td class="stress">&nbsp;</td>
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
            <th width="23"> <input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
            <th width="543">标题</th>
            <th width="121">管理</th>
          </tr>
<?php
foreach($List as $key => $news){								//循环显示审核信息
	extract($news);
	$bgstr = "bgcolor=" . ($key % 2 ? "#eeeeee" : "#ffffff");			//单行显示白色双行显示灰色
?>
          <tr <?php echo $bgstr ?>> 
            <td align="center"> <?php echo "<input type='checkbox' name='del_id[]' value='$F_ID'>" ?> 
            </td>
            <td> <?php echo $F_NDT_CAPTION ?> </td>
            <td align="center"><a href="<?php echo $F_NDT_CONTENT_URL?>" target="_blank">[查看]</a></td>
          </tr>
<?php
}
?>
	<tr> 
	  <th colspan="3">
      <input type="submit" name="Button" value="提交审核"></th></tr>

        </table>
</form>
		</td>
	</tr>
  </table>
<p> 
<script language="JavaScript">
/**
 * 功能：实现全选效果
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
</script>
