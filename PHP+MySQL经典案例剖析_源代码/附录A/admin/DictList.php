<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'dict.inc.php');
$dict = new Dict();								//声明一个对象$dict
$cur_page = $_GET['page'];						//取得当前页码
if(!$cur_page)
	$cur_page = 1;								//如果无页码则默认为第一页
$action = $_GET['action'];							//取得当前操作
if(!$action)
	$action = "add";							//如果无操作则默认为添加操作
if ($action == "add") {							//如果为添加操作，那么表单提交的地址为AddDict.php
	$post = "AddDict.php";
}else{
	$post = "EditDict.php";						//否则为EditDict.php
}
$cur_id = $_GET['id'];							//取得当前编辑记录的ID
if(!$cur_id)									//如果无值，则ID为0
	$cur_id = 0;
if($cur_id > 0 AND $action == 'edit')
{
	$info = $dict->getInfo($cur_id);					//如果ID > 0AND$action == 'edit'那么提取该ID记录
}
$list = $dict->getList($cur_page);
$count = $dict->getCount();
$pagecount = ceil($count/$dict->_pagesize);			//计算总共的页数
if(!$pagecount)
	$pagecount = 1;							//如果无总页数，则默认为1
$url = "?action=$action&id=$cur_id&page=";			//翻页跳转的地址
?>
<html>
<head>
<title>语言管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form id="form1" name="form1" method="post" action="<?php echo $post?>">
<table width="70%" border="0" align="center" cellspacing="0" class=i_table>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="l_field">
    <td align="center" >英文CODE:<input type="text" name="Code" size="40" value="<?php echo $info['F_CODE']?>"/></td>
  </tr>
  <tr class="l_field">
   <td height="22" colspan="3" align="center"><input type="submit" name="Submit" value="提交" /><input type=hidden name=id value=<?php echo $cur_id?>> </td>
 </tr>
</table></form>
<table width="90%" border="0" align="center" cellspacing="0" class=i_table>
<tr class="head">
<td width="6%">序号 </td>
<td width="70%">英文CODE </td>
<td width="20%">操作</td>
</tr>
<?php
if($list)										//如果有记录则循环显示
{
	foreach($list as $key => $value)
	{
?>
		<tr class="l_field">
		<td align="left"><?php echo ($key+1) ?></td>
		<td align="left"><?php echo $value['F_CODE']?></td>
		<td align="left">[<a href="DictList.php?action=edit&id=<?php echo $value['F_ID']?>">编辑</a>][<a href="DelDict.php?id=<?php echo $value['F_ID']?>">删除</a>]</td>
		</tr>
<?php
	}
}
?>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
  <tbody><tr><td><table width='100%' align='center' border='0' cellspacing='0'>
	  <tr> 
    	<td> 共有 <b><?php echo $count?></b> 信息 共 <font color='#FF0000'><b><?php echo $cur_page?></b></font> 
      / <b><?php echo $pagecount?></b>页 每页 <b><?php echo $dict->_pagesize?></b> </td>
    <td width=30>转到</td>
	<td width=50>
<select name="page" style="width:50px" onChange="javascript:location.href=document.getElementById('url')+this.options[selectedIndex].value">
<?php
for($i=1;$i<=$pagecount;$i++)
{
	echo "<option value='$i'";
	if($i == $cur_page)
		echo " selected='selected'";
	echo ">$i</option>";
}
?>
</select><input type=hidden name=url value=<?php echo $url?>>
		</td><td width=15>页
		</td>
	  </tr>
	</table></td>
  </tr>
</tbody></table>
</body>
</html>