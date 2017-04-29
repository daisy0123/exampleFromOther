<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once(INCLUDE_PATH . 'News.inc.php');?>
<?php require_once(INCLUDE_PATH . 'function.inc.php');?>
<?php
$News = new News();
if (!$_GET['Page']) $curr_page = 1;								//�ж��Ƿ���ҳ��,Ĭ��Ϊ1
$Class = $News->getInfo($_GET['id'],"EM_CLASS_INFO");
$Pagesize = 10;
$List = array();
$List = $News->GetNewsList($_GET['id'], $curr_page,$Pagesize,$_GET['keyword']);
$NewsCount = $News->GetNewsCount($_GET['id'],$_GET['keyword']);
$Pagecount = ceil($NewsCount / $Pagesize);
If(!$Pagecount) $Pagecount = 1;
$class_list = array();
$News->GetClassListAll();
?>
  <table width="100%" border="0" cellspacing="0">
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
            <th width="33"> <input name="allbox" type="checkbox" id="allbox" onClick="CA();" value="1"></th>
            <th width="490">����</th>
            <th width="219">����</th>
          </tr>
<?php
foreach($List as $key => $value){									//ѭ����ʾ��Ϣ�б�
	$bgstr = "bgcolor=" . ($key % 2 ? "#eeeeee" : "#ffffff");				//��������ʾ��ɫ,˫����ɫ
	$time = date("Y-m-d H:i",$value['F_NDT_TIME']);
?>
          <tr <?php echo $bgstr ?>> 
            <td align="center"> <?php echo "<input type='checkbox' name='del_id[]' value='{$value[F_ID]}'>" ?> 
            </td>
            <td> <?php echo $value[F_NDT_CAPTION] ?> </td>
            <td align="center"><a href="NewsAdd.php?id=<?php echo $value[F_ID] ?> &ClassId=<?php echo $_GET['id'] ?>&MenuId=<?php echo $_GET['MenuId']?>">[�޸�]</a>
              <a href="PicList.php?id=<?php echo $value[F_ID] ?>&MenuId=<?php echo $_GET['MenuId']?>">[ͼƬ����]</a> <a href="<?php echo $value['F_NDT_CONTENT_URL']?>" target="_blank">[�鿴]</a></td>
          </tr>
          <?php
}
?>
		<tr> 
	  <th colspan="3"><input type="button" name="Button" value="����ɾ��" onClick="javascript:del_news_()">
        &nbsp;
<input name="cmdDel" type="button" id="cmdAdd22" value="ɾ������" onClick="javascript:del_news()"> 
		&nbsp; <input name="cmdAdd" type="button" id="cmdAdd" value="�������" onClick="add_news(<?php echo $_GET['id'] ?>)">
&nbsp;
        <input type="button" name="Button" value="��������" onClick="gen_content(<?php echo $_GET['id'] ?>)"></th>
	</tr>
        </table></form>
	</td>
	</tr>
  </table>
<p> 
<script language="JavaScript">
/**
 * ���ܣ�ת�������Ϣҳ��
 */
function add_news(ID){
	if (ID == 0)
		alert("��ĿID��Ч")
	else
		window.location="NewsAdd.php?ClassId=" + ID + "&MenuId=<?php echo $_GET['MenuId']?>"
}
/**
 * ���ܣ�ʵ��ȫѡЧ��
 */
function CA(){
	for(var i=0;i<document.form1.elements.length;i++){					//������Ԫ��
		var e=document.form1.elements[i];
		if(e.name!='allbox') e.checked=document.form1.allbox.checked;	//�жϸø�ѡ���Ƿ���ȫѡ��
	}
}
/**
 * ���ܣ��ύ��ɾ���ļ�,�������վ
 */
function del_news(){
	document.form1.action = "DelNews.php?Type=1&ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $_GET['MenuId']?>";
	document.form1.submit();
}
/**
 * ���ܣ��ύ��ɾ���ļ�,����ɾ��
 */
function del_news_(){
	document.form1.action = "DelNews.php?Type=2&ClassId=<?php echo $_GET['id']?>&MenuId=<?php echo $_GET['MenuId']?>";
	document.form1.submit();
}
/**
 * ���ܣ��ύ���������ļ�
 */
function gen_content(ID){
	document.form1.action = "GenContent.php?ClassId=" + ID + "&MenuId=<?php echo $_GET['MenuId']?>";
	document.form1.submit();
}
</script>
</p>
<form name="form2" method="GET" action="">
  <table width="584" border="0" align="left">
	<tr> 
	  <td width="80" align="right" class="caption">��������</td>
	  <td width="80" align="right">������Ŀ��</td>
	  <td width="120"> 
		<?php
		echo "<select name='id' id='id'>";
		foreach($class_list as $class)								//ѭ����ʾ��Ŀ�б�
		{
			echo "<option value='{$class['id']}'";
			if($class['id'] == $_GET['id'])							//��ʾĬ��ѡ��
				echo " selected='selected'";
			echo ">{$class['class']}</option>";
		}
		echo "</select>";
		?>
	  </td>
	  <td width="56" align="right">�ؼ���</td>
	  <td width="151"><input name="keyword" type="text" id="keyword"></td>
	  <td width="71"><input name="cmdSearch" type="submit" id="cmdSearch" value="����">
      <input name="MenuId" type="hidden" id="MenuId" value="<?php echo $_GET['MenuId']?>" /></td>
	</tr>
  </table>
</form>
