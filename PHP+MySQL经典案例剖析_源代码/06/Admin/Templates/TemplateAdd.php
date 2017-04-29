<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'Template.inc.php'); ?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$Temp = new Temp();
$News = new News();
$class_list = array();
$News->GetClassListAll();
$html = " checked";
$character = " checked";
$rec_no = " checked";
$hot_no = " checked";
$new_no = " checked";
$branch_no = " checked";
$status_yes = " checked";
if($_GET['Id'])													//�ж��Ƿ��Ǳ༭״̬
{
	$info = $Temp->getInfo($_GET['Id'],"EE_TEMPLATE_INFO");
	if($info['F_TMP_WAY'] == 0)						 			//�������ɷ�ʽ��Ĭ��ѡ��
	{
		$js = " checked";
		$html = "";
	}
	if($info['F_TMP_TYPE'] == 0)									//����ģ�����͵�Ĭ��ѡ��
	{
		$pic = " checked";
		$character = "";
	}
	if($info['F_TMP_RECOMMEND'] == 1)							//�����Ƽ���Ĭ��ѡ��
	{
		$rec_yes = " checked";
		$rec_no = "";
	}
	if($info['F_TMP_HOT'] == 1)									//�����ȵ��Ĭ��ѡ��
	{
		$hot_yes = " checked";
		$hot_no = "";
	}
	if($info['F_TMP_IS_NEW'] == 1)								//���ÿ�Ѷ��Ĭ��ѡ��
	{
		$new_no = "";
		$new_yes = " checked";
	}
	if($info['F_TMP_IS_BRANCH'] == 1)								//���÷��е�Ĭ��ѡ��
	{
		$branch_no = "";
		$branch_yes = " checked";
	}
	if($info['F_TMP_STATUS'] == 1)								//����ģ��״̬��Ĭ��ѡ��
	{
		$status_yes = "";
		$status_no = " checked";
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ�Ϊ�ύ����
{
	if($Temp->AddTemplate($_GET['Id'],$_POST))						//�ж��Ƿ�����ɹ�
	{
		echo "�����ɹ�<br>";
		echo "<a href='TemplateList.php?id={$_GET['ClassId']}&MenuId={$_GET['MenuId']}'>�����б�</a>";
		exit();
	}
}
?>
<script lanuage='javascript' src='/Js/Base.js'></script>
<p align="center"><b>���ģ��<b></p>
<form name="form1" method="post" action="" onSubmit="return check()">
  <table width="80%"  border="0" align="center">
    <tr>
      <td bgcolor="#CCCCCC"><table width="100%"  border="0">
        <tr>
          <td width="22%" align="right">ģ�����ɷ�ʽ</td>
          <td colspan="2"><input name="way" type="radio" value="1"<?php echo $html?>>
            HTML
              <input type="radio" name="way" value="0"<?php echo $js?>>
            JS</td>
        </tr>
        <tr>
          <td align="right">ģ������</td>
          <td colspan="2"><input name="type" type="radio" value="1"<?php echo $character?>>
            ����
            <input type="radio" name="type" value="0"<?php echo $pic?>>
            ͼƬ(����)</td>
        </tr>
        <tr>
          <td align="right">�������</td>
          <td colspan="2">
          <?php
			echo "<select name='news_class' id='news_class'>";
			echo "<option value='0'>��ѡ��</option>";
			foreach($class_list as $class)								//ѭ����ʾ��Ŀ�б�
			{
				echo "<option value='{$class['id']}'";
				if($class['id'] == $info['F_NEWS_CLASS'])					//��ʾĬ��ѡ��
					echo " selected='selected'";
				echo ">{$class['class']}</option>";
			}
			echo "</select>";  
		  ?>
          </td>
        </tr>
        <tr>
          <td align="right">ģ������</td>
          <td colspan="2"><input name="name" type="text" id="name" size="30" value="<?php echo $info['F_TMP_NAME']?>"></td>
        </tr>
        <tr>
          <td align="right">��ʾ��Ϣ����</td>
          <td colspan="2"><input name="news_count" type="text" id="news_count" size="10" value="<?php echo $info['F_TMP_NEWS_COUNT']?>">
            ��</td>
        </tr>
        <tr>
          <td align="right">��Ϣ����</td>
          <td colspan="2"><select name="news_row" id="news_row">
			<?php
			for($i = 1;$i <= 10;$i++)									//��ʾ��Ϣ����ѡ��
			{
				echo "<option value='$i'";
				if($i == $info['F_TMP_NEWS_ROW'])					//����Ĭ��ѡ��
					echo " selected";
				echo ">$i</option>";
			}
			?>
          </select>
            ��</td>
        </tr>
        <tr>
          <td align="right">��ʾ���ⳤ��</td>
          <td colspan="2"><input name="cap_len" type="text" id="cap_len" value="<?php echo $info['F_TMP_CAP_LEN']?>">
            �ַ�</td>
        </tr>
        <tr>
          <td align="right">��ʾ���ݳ���</td>
          <td width="31%"><input name="con_len" type="text" id="con_len" value="<?php echo $info['F_TMP_CON_LEN']?>">
            �ַ�</td>
          <td width="47%">ǰ
            <input name="con_count" type="text" id="con_count" value="<?php echo $info['F_TMP_CON_COUNT']?>">
            ����ʾ</td>
          </tr>
        <tr>
          <td align="right">���ļ�</td>
          <td colspan="2"><input name="template_url" type="text" id="template_url" size="40" value="<?php echo $info['F_TMP_URL']?>">
            <input type="button" name="Submit" value="��ѡ��.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_template()"></td>
          </tr>
        <tr>
          <td align="right">�Ƽ�</td>
          <td colspan="2"><input name="recommend" type="radio" value="0"<?php echo $rec_no?>>
            ��
            <input type="radio" name="recommend" value="1"<?php echo $rec_yes?>>
            ��</td>
        </tr>
        <tr>
          <td align="right">�ȵ�</td>
          <td colspan="2"><input name="hot" type="radio" value="0"<?php echo $hot_no?>>
            ��
            <input type="radio" name="hot" value="1"<?php echo $hot_yes?>>
            ��</td>
        </tr>
        <tr>
          <td align="right">��Ѷ</td>
          <td colspan="2"><input name="new" type="radio" value="0"<?php echo $new_no?>>
            ��
            <input type="radio" name="new" value="1"<?php echo $new_yes?>>
            ��</td>
        </tr>
        <tr>
          <td align="right">����</td>
          <td colspan="2"><input name="branch" type="radio" value="0"<?php echo $branch_no?>>
            ��
            <input type="radio" name="branch" value="1"<?php echo $branch_yes?>>
            ��</td>
          </tr>
        <tr>
          <td align="right">״̬</td>
          <td colspan="2"><input name="state" type="radio" value="1"<?php echo $status_yes?>>
            ��������
            <input type="radio" name="state" value="0"<?php echo $status_no?>>
            ����</td>
          </tr>
        <tr>
          <td align="right" valign="top">ģ��˵��</td>
          <td colspan="2"><textarea name="note" cols="40" rows="6" id="note"><?php echo $info['F_TMP_NOTE']?></textarea></td>
          </tr>
        <tr>
          <td colspan="3" align="center" valign="top"><input type="submit" name="Submit" value=" �ύ ">&nbsp;
            <input type="reset" name="Submit" value=" ��� "><input type='hidden' name='class_id' value='<?php echo $_GET['ClassId']?>'></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<script language="JavaScript" type="text/JavaScript">
function check()
{
	if($('news_class').value == 0)								//�ж�������Ŀ�Ƿ�Ϊ��
	{
		alert("��ѡ��������Ŀ")
		$('class_id').focus()
		return false
	}
	if($('name').value.trim() == '')								//�ж�ģ�������Ƿ�Ϊ��
	{
		alert("����дģ������")
		$('name').focus()
		return false
	}
	if($('news_count').value.trim() == '')							//�ж���Ϣ�����Ƿ�Ϊ��
	{
		alert("����д��Ϣ����")
		$('news_count').focus()
		return false
	}
	if($('cap_len').value.trim == '')								//�жϱ��ⳤ���Ƿ�Ϊ��
	{
		alert("����д���ⳤ��")
		$('cap_len').focus()
		return false
	}
	if($('template_url').value.trim == '')							//�жϰ��ļ��Ƿ�Ϊ��
	{
		alert("��ѡ����ļ�")
		$('template_url').focus()
		return false
	}
return true
}
/**
 * ����ģ��ѡ��Ի���
 */
function select_template(){
	var w	=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("Select.php",null,theDes);
	if(rv){
		document.form1.template_url.value = rv;
	}
}
</script>
