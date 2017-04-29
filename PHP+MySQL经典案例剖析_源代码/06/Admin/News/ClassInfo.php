<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$MenuId = $_GET['MenuId'];
$info = $News->getInfo($_GET['id'],'EM_CLASS_INFO');
@extract($info);
$count = $News->GetClassCount($_GET['id']);
$news_count = $News->GetNewsCount($_GET['id']);
?>
<table width="90%" border="0" align="center">
  <tr>
    <th height="22" align="left">基本信息</td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellpadding="0" cellspacing="1">
        <tr bgcolor="#FFFFFF"> 
          <td width="150" height="22" align="right">栏目名称</td>
          <td width="175" height="22">&nbsp;<?php echo $F_CLASS_NAME?></td>
          <td width="150" height="22" align="right">栏目目录路径</td>
          <td width="175" height="22">&nbsp;<?php echo $F_CLASS_PATH?></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="150" height="22" align="right">子类别数量</td>
          <td height="22">&nbsp;<?php echo $count?></td>
          <td width="150" height="22" align="right">新闻数量</td>
          <td height="22">&nbsp;<?php echo $news_count?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="150" height="22" align="right">栏目首页模板</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_TEMPLATE_URL?></td>
          <td width="150" height="22" align="right">栏目列表样式</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_LIST_STYLE?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="150" height="22" align="right">栏目信息模板</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_NEWS_TEMPLATE?></td>
          <td width="150" height="22" align="right">每页显示信息数量</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_NEWS_COUNT?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="150" height="22" align="right">信息标题长度</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_CAP_LEN?></td>
          <td width="150" height="22" align="right">信息内容长度</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_CON_LEN?></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="90%" border="0" align="center">
  <tr>
    <th height="22" align="left">子栏目列表</td>
  </tr>
</table>
<table width="80%" border="0" align="center">
<?php
$class = array();
$class = $News->GetClassList($_GET['id']);
$perline = 4;
$width = (int)(100/$perline) . "%";
foreach($class as $key => $list){								//循环显示该栏目的子栏目列表
	extract($list);
	if($key % $perline == 0){									//判断是否是一行的开始
?>
  <tr>
<?php
}
?>
    <td width="<?php echo $width?>"><?php echo $ncs_name?></td>
<?php
if($key % $perline == $perline - 1){								//判断是否是一行的结束
?>
  </tr>
<?php
}
}
if($key % $perline < $perline - 1){								//判断是否刚好一行
	for(;$key % $perline < $perline - 1;$key++)					//循环补足剩余的表格项
		echo "<td width='$width'>&nbsp;</td>";
	echo "</tr>";
}
?>
</table>
<br>
<table width="90%" border="0" align="center">
  <tr>
    <th height="22" align="left">操作</td>
  </tr>
</table>
<table width="100%" border="0" align="center">
  <tr>
    <td height="22" align="center">
        <input type="button" name="Submit2" value=" 修改栏目 " onClick="window.location = 'ClassAdd.php?id=<?php echo $_GET['id']?>&MenuId=<?php echo $MenuId?>'">
        &nbsp;<input type="button" name="Button" value=" 删除栏目 " onClick="javascript:del_class()">&nbsp;<input type="button" name="Button" value=" 新建子栏目 " onClick="window.location = 'ClassAdd.php?ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $MenuId?>'">&nbsp;<input type="button" name="Submit" value=" 生成首页 " onClick="window.location = 'GenList.php?ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $MenuId?>'">&nbsp;
        <input type="button" name="Submit" value=" 生成XML页 " onClick="window.location = 'GenRss.php? ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $MenuId?>'"></td>
  </tr>
</table>
<table width="90%" border="0" align="center">
  <tr>
    <th>&nbsp;</td>
  </tr>
</table>
<script language="JavaScript" type="text/JavaScript">
/**
 * 功能：转到删除栏目文件
 */
function del_class(){
	if(confirm("真的要删除吗？"))								//判断是否确认删除
		window.location = "ClassDel.php?id=<?php echo $_GET['id']?>&MenuId=<?php echo $MenuId?>";
}
</script>
