<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . "vote.inc.php");
$vote = new Vote();
$time = time();
$where = "F_VOTE_IS_DISPLAY = 1 AND F_VOTE_END >= $time";
$list = $vote->getVoteList($where);
if($list)
{
	foreach($list as $key => $value)					//循环显示调查
	{
		$item = $vote->getItemList($value['F_ID']);		//提取指定调查的选项
?>
<form name="form_<?php echo $value['F_ID']?>" method="post" action="Deal.php">
  <table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><strong><?php echo ($key+1)?>. <?php echo $value['F_VOTE_TITLE']?></strong></td>
    </tr>
    <tr>
      <td>
      <?php
      if($item)
      {
      	foreach($item as $val)						//循环显示调查选项
      	{
      		if($value['F_VOTE_ITEM_TYPE'] == 1)			//判断调查选项的形式，以不同方式显示
      			echo "<input type='radio' name='item' value='{$val['F_ID']}'>";
      		else 
      			echo "<input name='item[]' type='checkbox' id='item[]' value='{$val['F_ID']}' />";
      		echo $val['F_ITEM_TITLE'] . "<br>";
      	}
      }
      ?>
      </td>
    </tr>
    <tr>
      <td><input type="submit" name="Submit" value="提交">
      <input type="button" name="Submit2" value="查看结果" onclick="javascript:window.open('Result.php?id=<?php echo $value['F_ID']?>')">
      <input type="hidden" name="id" value="<?php echo $value['F_ID']?>">
      </td>
    </tr>
  </table>
</form>
<?php
	}
} else {
	echo "暂时没有数据！";
}
?>
