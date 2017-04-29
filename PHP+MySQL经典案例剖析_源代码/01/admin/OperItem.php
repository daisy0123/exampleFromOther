<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'vote.inc.php');
$vote = new Vote();
$title = "添加调查选项";
if($_GET['id'])											//判断是否有编辑选项ID，有则提取记录
{
	$info = $vote->getInfo($_GET['id'],$vote->_item);
	$title = "编辑调查选项";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')				//判断是否是提交请求
{
	$data['F_ID_VOTE_INFO'] = $_POST['voteid'];
	$data['F_ITEM_TITLE'] = $_POST['title'];
	$data['F_ITEM_COUNT'] = 0;
	$data['F_ITEM_ORDER'] = 0;
	if($_POST['id'])										//有选项ID参数，则执行编辑操作
	{
		if($vote->updateData($vote->_item,$_POST['id'],$data))	//判断是否操作成功
		{
			echo "添加操作成功<br>";
			echo "<a href='ItemList.php?id={$_POST['voteid']}'>返回</a>";
			exit();
		}else{
			echo "添加操作失败<br>";
			echo "<a href='ItemList.php?id={$_POST['voteid']}'>返回</a>";
			exit();			
		}
	}else{											//无选项ID参数，则执行添加操作
		if($vote->insertData($vote->_item,$data))				//判断是否操作成功
		{
			echo "编辑操作成功<br>";
			echo "<a href='ItemList.php?id={$_POST['voteid']}'>返回</a>";
			exit();
		}else{
			echo "编辑操作失败<br>";
			echo "<a href='ItemList.php?id={$_POST['voteid']}'>返回</a>";
			exit();			
		}		
	}
}
?>
<html>
<head>
<title>投票管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form name="form1"  action="" method="post" onsubmit="javascript:check();">
  <table width="60%" border="0" align="center" cellpadding="0" cellspacing="0" class=i_table>
    <tr>
      <td colspan="2" align="left" bgcolor="#FFFFFF" class="caption"><?php echo $title?></td>
    </tr>
    <tr class="l_field">
      <td width="24%" align="right" bgcolor="#FFFFFF">调查标题：</td>
      <td width="76%" bgcolor="#FFFFFF">您对网站的满意程度？</td>
    </tr>
    <tr class="l_field">
      <td align="right" bgcolor="#FFFFFF">选项标题：</td>
      <td bgcolor="#FFFFFF"><input name="title" type="text" id="title" size="40" value="<?php echo $info['F_ITEM_TITLE']?>" /></td>
    </tr>
    <tr class="title">
      <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="提交" />
        &nbsp;
      <input type="reset" name="reset" value="重置" />
      <input type='hidden' name="id" id="id" value="<?php echo $_GET['id']?>">
      <input type='hidden' name="voteid" id="voteid" value="<?php echo $_GET['voteid']?>">      </td>
    </tr>
  </table>
</form>
<script language="javascript">
function check()
{
	if(document.form1.title.value == "")			//判断标题是否为空，是则弹出提示框
	{
		alert('请填写选项标题');
		document.form1.focus();
		return false;
	}
	return true;
}
</script>
</body>
</html>