<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'vote.inc.php');
$vote = new Vote();
$list = $vote->areaList($_GET['id']);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="32" background="/images/lefttop.jpg" class="head">调查管理>区域统计</td>
  </tr>
</table>
<form name="form1"  action="" method="post">
<table width="60%" border="0" align="center" cellspacing="0" class="l_table_1" id="table_1">
  <tr class="title">
    <td width="9%">序号</td>
    <td width="58%">区域</td>
    <td width="33%">次数</td>    
    </tr>
<?php
if($list)
{
	foreach ($list as $key => $value)
	{
?>
    <tr class="l_field">
    <td align="left"><?php echo ($key + 1)?></td>
    <td align="left"><?php echo $value['F_USER_AREA']?></td>
    <td align="left"><?php echo $value['C']?></td>    
    </tr>
<?php
	}
}
?>
</table>
</form>
