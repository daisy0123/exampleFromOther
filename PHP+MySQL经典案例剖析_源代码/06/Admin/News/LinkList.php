<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'function.inc.php'); ?>
<?php
$News = new News();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ��ύɾ��
{
	if($_POST[del_id])											//�ж��Ƿ���ѡ������
	{
		foreach($_POST[del_id] as $id)							//ѭ��ɾ������
			$News->DelLink($id);
	}
}
if(!$_GET['Page']) $curr_page = 1;									//�ж��Ƿ���ҳ��
$List = array();
$Pagesize = 10;
$List = $News->GetLinkList($curr_page,$Pagesize);
$Count = $News->GetLinkCount();
$Pagecount = ceil($Count/$Pagesize);
if(!$Pagecount) $Pagecount = 1;									//�ж��Ƿ���ҳ��
?>
  <table width="85%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="30" align="center" class="caption">���������б�</td>
    </tr>
    <tr>
      <td><?php echo Page($Pagecount,$curr_page,$Pagesize); ?></td>
    </tr>
  </table>
<form name="form1" method="post" action="">
  <table width="85%"  border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td bgcolor="#999999"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td><table width="100%" border="0">
            <tr>
              <th width="33"> <input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
              <th width="165">������������</th>
              <th width="227">�������ӵ�ַ</th>
              <th width="104">��ʾ������ɫ</th>
              <th width="109">����</th>
              </tr>
<?php
foreach($List as $key => $r){										//ѭ����ʾ����
	extract($r);
?>
            <tr>
              <td align="center"><?php echo "<input type='checkbox' name='del_id[]' value='$F_ID'>" ?> </td>
              <td><?php echo $F_LINK_NAME ?></td>
              <td align="center"><?php echo $F_LINK_URL ?></td>
              <td align="center"><?php echo $F_LINK_COLOR ?></td>
              <td align="center"><a href="LinkAdd.php?id=<?php echo $F_ID?>&MenuId=<?php echo $_GET['MenuId']?>">[�༭]</a></td>
              </tr>
<?php
}
?>
    <tr>
      <td align="center" colspan="5">
        <input type="submit" name="Submit" value="ɾ������">
        &nbsp;&nbsp;<input type="button" name="Submit" value="�������" onClick="javascript:window.location='LinkAdd.php?MenuId=<?php echo $_GET['MenuId']?>'"> </td>
    </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<script language="JavaScript" type="text/JavaScript">
/**
 * ���ܣ�ʵ��ȫѡЧ��
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
</script>
