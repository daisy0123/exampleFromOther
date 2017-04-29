<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'dict.inc.php');
require_once(INCLUDE_PATH . 'lang.inc.php');
$dict = new Dict();								//声明一个对象$dict
$lang = new Lang();
$cur_page = $_GET['page'];						//取得当前页码
if(!$cur_page)
	$cur_page = 1;								//如果无页码则默认为第一页
$lang_id = $_GET['id'];							//取得当前语言的ID
$list = $dict->getList($cur_page);
$count = $dict->getCount();
$pagecount = ceil($count/$dict->_pagesize);			//计算总共的页数
if(!$pagecount)
	$pagecount = 1;							//如果无总页数，则默认为1
$url = "?id=$cur_id&page=";						//翻页跳转的地址
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if ($lang->updateTransData($_POST['CodeID'],$_POST['LangId'],$_POST['Text'])){
		echo "操作成功<br>";
	}else{
		echo "操作失败<br>";
	}
	echo "<a href='TransList.php?id=$lang_id'>点击返回</a>";
	exit();
}
?>
<html>
<head>
<title>语言管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form name="form1"  action="" method="post">
<table width="98%" border="0" align="center" cellspacing="0"  class=i_table>
  <tr class="head">
    <td width="6%">序号</td>
    <td width="30%">字典</td>
    <td width="60%">翻译</td>    
  </tr>
<?php
if($list)										//如果有记录则循环显示
{
	foreach($list as $key => $value)
	{
		$info = $lang->getTransInfo($value['F_ID'],$lang_id);
?>
  <tr class="l_field">
    <td align="left"><?php echo ($key+1) ?></td>
    <td align="left"><?php echo $value['F_CODE']?></td>
    <td align="left"><input type="text" name="Text[]" value="<?php echo $info[F_TEXT]?>" size="60">
        <input type="hidden" name="CodeID[]" value="<?php echo $value['F_ID']?>"></td>    
  </tr>
<?php
	}
}
?>
  <tr>
    <td colspan="8"><input type="submit" name="Submit3" value="保存" /><input name="LangId" type="hidden" id="LangId" value="<?php echo $lang_id?>"></td>
  </tr>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
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
</form>
</body>
</html>