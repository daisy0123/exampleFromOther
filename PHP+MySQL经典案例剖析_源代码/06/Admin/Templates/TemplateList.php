<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'Template.inc.php'); ?>
<?php
$Temp = new Temp();
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ����ύ����
{
	if($_POST['del_id'])											//�ж��Ƿ�ѡ����ģ��
	{
		foreach($_POST['del_id'] as $id)							//ѭ��ɾ��ģ��
			$Temp->delData($id,"EE_TEMPLATE_INFO");
	}
}
$List = array();
$List = $Temp->GetTempList($_GET['id']);
$Info = $Temp->getInfo($_GET['id'],"EM_CLASS_INFO");
?>
<form name="form1" method="post" action="">
  <table width="98%" border="0" align="center" cellspacing="0">
	<tr> 
	  <td colspan="2" class="caption">ģ �� �� ��</td>
	</tr>
	<tr> 
	  <td class="stress">��ǰ���<?php echo $Info['F_CLASS_NAME'] ?></td>
	  <td class="stress">&nbsp;</td>
	</tr>
	<tr> 
	  <td colspan="2"> <table width="100%" border="0">
          <tr> 
            <th width="24"> <input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
            <th width="190">ģ������</th>
            <th width="183">ģ��˵��</th>
            <th width="84">ģ������</th>
            <th width="154">����</th>
            <th width="102">����</th>
          </tr>
          <?php
foreach($List as $key => $l){										//ѭ����ʾģ����Ϣ
	extract($l);
	$bgstr = "bgcolor=" . ($key % 2 ? "#eeeeee" : "#ffffff");
?>
          <tr <?php echo $bgstr ?>> 
            <td align="center"> <?php echo "<input type='checkbox' name='del_id[]' value='$F_ID'>" ?> 
            </td>
            <td> <?php echo $F_TMP_NAME ?> </td>
            <td align="center"> <?php echo $F_TMP_NOTE ?> </td>
            <td align="center"> <?php echo ($F_TMP_TYPE) ? "����" : "ͼƬ(����)" ?> </td>
            <td align="center"><?php echo "[".$F_TMP_NAME ."]"?></td>
            <td align="center"><a href="TemplateAdd.php?Id=<?php echo $F_ID ?>&ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $_GET['MenuId']?>">[�޸�]</a> 
              <a href="#" onClick="javascript:view('<?php echo $F_ID ?>','<?php echo $_GET['MenuId']?>')">[Ԥ��]</a></td>
          </tr>
          <?php
}
?>
        </table></td>
	</tr>
	<tr> 
	  <th colspan="2"> <input name="cmdAdd" type="button" id="cmdAdd" value="���ģ��" onClick="window.location='TemplateAdd.php?ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $_GET['MenuId']?>'">
      &nbsp;<input type="submit" name="Submit" value="ɾ��ģ��"></th>
	</tr>
</table>
</form>
<script language="JavaScript">
/**
 * ���ܣ�ʵ��ȫѡ����
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;
	}
}
/**
 * ���ܣ�����Ԥ���Ի���
 */
function view(ID,MENUID){
	var w=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	window.showModalDialog("TemplateView.php?Id=" + ID + "&MenuId=" + MENUID,null,theDes);
}
</script>
