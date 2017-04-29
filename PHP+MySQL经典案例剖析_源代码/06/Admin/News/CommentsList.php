<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'function.inc.php'); ?>
<?php
$News = new News();
if(!$_GET['Page']) $curr_page = 1;									//判断是否有页码
$List = array();
$Pagesize = 10;
$List = $News->GetRemarkList($curr_page,$Pagesize);
$Count = $News->GetRemarkCount();
$Pagecount = ceil($Count / $Pagesize);
if(!$Pagecount) $Pagecount = 1;									//判断是否有页数
?>
<p align="center"><b>评论管理</b></p>
<table width="70%" border="0" align="center">
  <tr>
    <td><?php echo Page($Pagecount,$curr_page,$Pagesize); ?></td>
  </tr>
</table>
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
<?php
foreach($List as $Comment){										//循环输出评论
	extract($Comment);
?>
  <tr>
    <td bgcolor="#0066CC"><table width="100%" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td height="22"><strong><font color="#FFFFFF" size="2">新闻标题：<?php echo $F_NDT_CAPTION?></font></strong></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0">
              <tr> 
                <td bgcolor="#0099CC"><font color="#FFFFFF"><?php echo $F_REMARK_NAME?>&nbsp;&nbsp;发表时间：<?php echo date("Y-m-d H:i:s",$F_REMARK_TIME)?>&nbsp;&nbsp;IP地址：<?php echo long2ip($F_REMARK_IP)?></font></td>
              </tr>
              <tr> 
                <td><?php echo $F_REMARK_CONTENT?></td>
              </tr>
              <tr>
                <td height="22" align="right"><a href="DelComments.php?id=<?php echo $F_ID?>&MenuId=<?php echo $_GET['MenuId']?>" onClick="return confirm('真的要删除吗？')">[删除]</a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
<?php
}
?>
</table>
