<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'dict.inc.php');
$dict = new Dict();								//����һ������$dict
$cur_page = $_GET['page'];						//ȡ�õ�ǰҳ��
if(!$cur_page)
	$cur_page = 1;								//�����ҳ����Ĭ��Ϊ��һҳ
$action = $_GET['action'];							//ȡ�õ�ǰ����
if(!$action)
	$action = "add";							//����޲�����Ĭ��Ϊ��Ӳ���
if ($action == "add") {							//���Ϊ��Ӳ�������ô���ύ�ĵ�ַΪAddDict.php
	$post = "AddDict.php";
}else{
	$post = "EditDict.php";						//����ΪEditDict.php
}
$cur_id = $_GET['id'];							//ȡ�õ�ǰ�༭��¼��ID
if(!$cur_id)									//�����ֵ����IDΪ0
	$cur_id = 0;
if($cur_id > 0 AND $action == 'edit')
{
	$info = $dict->getInfo($cur_id);					//���ID > 0AND$action == 'edit'��ô��ȡ��ID��¼
}
$list = $dict->getList($cur_page);
$count = $dict->getCount();
$pagecount = ceil($count/$dict->_pagesize);			//�����ܹ���ҳ��
if(!$pagecount)
	$pagecount = 1;							//�������ҳ������Ĭ��Ϊ1
$url = "?action=$action&id=$cur_id&page=";			//��ҳ��ת�ĵ�ַ
?>
<html>
<head>
<title>���Թ���</title>
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
    <td align="center" >Ӣ��CODE:<input type="text" name="Code" size="40" value="<?php echo $info['F_CODE']?>"/></td>
  </tr>
  <tr class="l_field">
   <td height="22" colspan="3" align="center"><input type="submit" name="Submit" value="�ύ" /><input type=hidden name=id value=<?php echo $cur_id?>> </td>
 </tr>
</table></form>
<table width="90%" border="0" align="center" cellspacing="0" class=i_table>
<tr class="head">
<td width="6%">��� </td>
<td width="70%">Ӣ��CODE </td>
<td width="20%">����</td>
</tr>
<?php
if($list)										//����м�¼��ѭ����ʾ
{
	foreach($list as $key => $value)
	{
?>
		<tr class="l_field">
		<td align="left"><?php echo ($key+1) ?></td>
		<td align="left"><?php echo $value['F_CODE']?></td>
		<td align="left">[<a href="DictList.php?action=edit&id=<?php echo $value['F_ID']?>">�༭</a>][<a href="DelDict.php?id=<?php echo $value['F_ID']?>">ɾ��</a>]</td>
		</tr>
<?php
	}
}
?>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="90%">
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
</body>
</html>