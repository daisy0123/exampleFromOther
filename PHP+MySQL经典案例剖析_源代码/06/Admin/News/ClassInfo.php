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
    <th height="22" align="left">������Ϣ</td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellpadding="0" cellspacing="1">
        <tr bgcolor="#FFFFFF"> 
          <td width="150" height="22" align="right">��Ŀ����</td>
          <td width="175" height="22">&nbsp;<?php echo $F_CLASS_NAME?></td>
          <td width="150" height="22" align="right">��ĿĿ¼·��</td>
          <td width="175" height="22">&nbsp;<?php echo $F_CLASS_PATH?></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td width="150" height="22" align="right">���������</td>
          <td height="22">&nbsp;<?php echo $count?></td>
          <td width="150" height="22" align="right">��������</td>
          <td height="22">&nbsp;<?php echo $news_count?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="150" height="22" align="right">��Ŀ��ҳģ��</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_TEMPLATE_URL?></td>
          <td width="150" height="22" align="right">��Ŀ�б���ʽ</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_LIST_STYLE?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="150" height="22" align="right">��Ŀ��Ϣģ��</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_NEWS_TEMPLATE?></td>
          <td width="150" height="22" align="right">ÿҳ��ʾ��Ϣ����</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_NEWS_COUNT?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="150" height="22" align="right">��Ϣ���ⳤ��</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_CAP_LEN?></td>
          <td width="150" height="22" align="right">��Ϣ���ݳ���</td>
          <td height="22">&nbsp;<?php echo $F_CLASS_CON_LEN?></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="90%" border="0" align="center">
  <tr>
    <th height="22" align="left">����Ŀ�б�</td>
  </tr>
</table>
<table width="80%" border="0" align="center">
<?php
$class = array();
$class = $News->GetClassList($_GET['id']);
$perline = 4;
$width = (int)(100/$perline) . "%";
foreach($class as $key => $list){								//ѭ����ʾ����Ŀ������Ŀ�б�
	extract($list);
	if($key % $perline == 0){									//�ж��Ƿ���һ�еĿ�ʼ
?>
  <tr>
<?php
}
?>
    <td width="<?php echo $width?>"><?php echo $ncs_name?></td>
<?php
if($key % $perline == $perline - 1){								//�ж��Ƿ���һ�еĽ���
?>
  </tr>
<?php
}
}
if($key % $perline < $perline - 1){								//�ж��Ƿ�պ�һ��
	for(;$key % $perline < $perline - 1;$key++)					//ѭ������ʣ��ı����
		echo "<td width='$width'>&nbsp;</td>";
	echo "</tr>";
}
?>
</table>
<br>
<table width="90%" border="0" align="center">
  <tr>
    <th height="22" align="left">����</td>
  </tr>
</table>
<table width="100%" border="0" align="center">
  <tr>
    <td height="22" align="center">
        <input type="button" name="Submit2" value=" �޸���Ŀ " onClick="window.location = 'ClassAdd.php?id=<?php echo $_GET['id']?>&MenuId=<?php echo $MenuId?>'">
        &nbsp;<input type="button" name="Button" value=" ɾ����Ŀ " onClick="javascript:del_class()">&nbsp;<input type="button" name="Button" value=" �½�����Ŀ " onClick="window.location = 'ClassAdd.php?ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $MenuId?>'">&nbsp;<input type="button" name="Submit" value=" ������ҳ " onClick="window.location = 'GenList.php?ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $MenuId?>'">&nbsp;
        <input type="button" name="Submit" value=" ����XMLҳ " onClick="window.location = 'GenRss.php? ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $MenuId?>'"></td>
  </tr>
</table>
<table width="90%" border="0" align="center">
  <tr>
    <th>&nbsp;</td>
  </tr>
</table>
<script language="JavaScript" type="text/JavaScript">
/**
 * ���ܣ�ת��ɾ����Ŀ�ļ�
 */
function del_class(){
	if(confirm("���Ҫɾ����"))								//�ж��Ƿ�ȷ��ɾ��
		window.location = "ClassDel.php?id=<?php echo $_GET['id']?>&MenuId=<?php echo $MenuId?>";
}
</script>
