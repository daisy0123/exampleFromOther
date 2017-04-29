<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'dict.inc.php');
require_once(INCLUDE_PATH . 'lang.inc.php');
$dict = new Dict();								//����һ������$dict
$lang = new Lang();
$cur_page = $_GET['page'];						//ȡ�õ�ǰҳ��
if(!$cur_page)
	$cur_page = 1;								//�����ҳ����Ĭ��Ϊ��һҳ
$lang_id = $_GET['id'];							//ȡ�õ�ǰ���Ե�ID
$list = $dict->getList($cur_page);
$count = $dict->getCount();
$pagecount = ceil($count/$dict->_pagesize);			//�����ܹ���ҳ��
if(!$pagecount)
	$pagecount = 1;							//�������ҳ������Ĭ��Ϊ1
$url = "?id=$cur_id&page=";						//��ҳ��ת�ĵ�ַ
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if ($lang->updateTransData($_POST['CodeID'],$_POST['LangId'],$_POST['Text'])){
		echo "�����ɹ�<br>";
	}else{
		echo "����ʧ��<br>";
	}
	echo "<a href='TransList.php?id=$lang_id'>�������</a>";
	exit();
}
?>
<html>
<head>
<title>���Թ���</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link type="text/css" rel="stylesheet" href="/style/admin.css">
</head>
<body>
<form name="form1"  action="" method="post">
<table width="98%" border="0" align="center" cellspacing="0"  class=i_table>
  <tr class="head">
    <td width="6%">���</td>
    <td width="30%">�ֵ�</td>
    <td width="60%">����</td>    
  </tr>
<?php
if($list)										//����м�¼��ѭ����ʾ
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
    <td colspan="8"><input type="submit" name="Submit3" value="����" /><input name="LangId" type="hidden" id="LangId" value="<?php echo $lang_id?>"></td>
  </tr>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
  <tbody><tr><td><table width='100%' align='center' border='0' cellspacing='0'>
	  <tr> 
    	<td> ���� <b><?php echo $count?></b> ��Ϣ �� <font color='#FF0000'><b><?php echo $cur_page?></b></font> 
      / <b><?php echo $pagecount?></b>ҳ ÿҳ <b><?php echo $dict->_pagesize?></b> </td>
    <td width=30>ת��</td>
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
		</td><td width=15>ҳ
		</td>
	  </tr>
	</table></td>
  </tr>
</tbody></table>
</form>
</body>
</html>