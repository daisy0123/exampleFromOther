<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . "vote.inc.php");
$vote = new Vote();
if($_GET['id'])												//判断是否有传递参数
{
	$info = $vote->getInfo($_GET['id'],$vote->_name);
	if(!isset($info[F_ID]))										//判断此ID的调查是否存在
	{
		echo "无此调查";
		exit();
	}
	$item = $vote->getItemList($_GET['id']);
	$sum = 0;
	foreach ($item as $value)									//计算总投票数
	{
		$sum += $value['F_ITEM_COUNT'];
	}
}else{													//无参数则提示
	echo "参数错误";
	exit();
}
?>
<table width="50%" border="0" align="center">
<tr>
  <td><?php echo $info['F_VOTE_TITLE']?></td>
</tr>
</table>
<table width="50%" border="0" align="center" cellpadding="3" cellspacing="2">
<?php
if($item)
{
	foreach ($item as $value)
	{
		$percent = @number_format($value['F_ITEM_COUNT']/$sum,2);	//计算每个选项票数所占比例
		$length = $percent*100 . "%";
?>
      <tr>
        <td width="27%"><font color="#000000"><?php echo $value['F_ITEM_TITLE']?></font></td>
        <td width="32%"><table height="12" cellspacing="1" cellpadding="0" width="<?php echo $length?>" 
                  bgcolor="#000000" border="0">
              <tr>
                <td bgcolor="#FF0000">&nbsp;</td>
              </tr>
        </table></td>
        <td width="41%"><span class="STYLE2"><?php echo $value['F_ITEM_COUNT']?></span><font color="#000000"> <?php echo $length?></font></td>
      </tr>
<?php
	}
}
?>
</table>
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><input type="button" name="Submit" value="返回列表" onclick="javascript:window.location='VoteList.php'" /></td>
  </tr>
</table>
