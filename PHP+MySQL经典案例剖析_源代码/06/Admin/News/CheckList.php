<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'function.inc.php'); ?>
<?php
$News = new News();
if (!$_GET['Page']) $curr_page = 1;								//�ж��Ƿ���ҳ��,Ĭ��Ϊ1
$Class = $News->getInfo($_GET['id'],"EM_CLASS_INFO");
$Pagesize = 10;
$List = array();
$List = $News->GetNewsList($_GET['id'],$curr_page,$Pagesize,"",1);
$NewsCount = $News->GetNewsCount($_GET['id'],"",1);
$Pagecount = ceil($NewsCount / $Pagesize);
if(!$Pagecount) $Pagecount = 1;
if($_SERVER['REQUEST_METHOD'] == 'POST')					//�ж��Ƿ��ύ���
{
	if($_POST[del_id])										//�ж��Ƿ���ѡ����Ϣ
	{
		foreach($_POST[del_id] as $id)						//ѭ�������Ϣ
			$News->Check($id);
	}
}
?>
  <table width="90%" border="0" align="center" cellspacing="0">
	<tr> 
	  <td colspan="2" class="caption">�� Ϣ �� ��</td>
	</tr>
	<tr> 
	  <td class="stress">��ǰ���<?php echo $Class['F_CLASS_NAME'] ?></td>
	  <td class="stress">&nbsp;</td>
	</tr>
	<tr> 
	  <td colspan="2"> 
		<?php echo Page($Pagecount,$curr_page,$Pagesize); ?>
	  </td>
	</tr>
	<tr> 
	  <td colspan="2"> 
<form name="form1" method="post" action="">
	  <table width="100%" border="0">
          <tr> 
            <th width="23"> <input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
            <th width="543">����</th>
            <th width="121">����</th>
          </tr>
<?php
foreach($List as $key => $news){								//ѭ����ʾ�����Ϣ
	extract($news);
	$bgstr = "bgcolor=" . ($key % 2 ? "#eeeeee" : "#ffffff");			//������ʾ��ɫ˫����ʾ��ɫ
?>
          <tr <?php echo $bgstr ?>> 
            <td align="center"> <?php echo "<input type='checkbox' name='del_id[]' value='$F_ID'>" ?> 
            </td>
            <td> <?php echo $F_NDT_CAPTION ?> </td>
            <td align="center"><a href="<?php echo $F_NDT_CONTENT_URL?>" target="_blank">[�鿴]</a></td>
          </tr>
<?php
}
?>
	<tr> 
	  <th colspan="3">
      <input type="submit" name="Button" value="�ύ���"></th></tr>

        </table>
</form>
		</td>
	</tr>
  </table>
<p> 
<script language="JavaScript">
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
