<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
if(!$_GET['id'])
	$id = 0;
else 
	$id = $_GET['id'];
$News = new News();
$class_list = array();
$News->GetClassListAll();
$class_id = $_GET['ClassId'];
if($id)														//�ж��Ƿ��б༭��ĿID
{
	$info = $News->getInfo($id,'EM_CLASS_INFO');
	list($front,$back) = explode(".",$info['F_CLASS_INDEX_NAME']);
}
?>
<script language="javascript" src="/Js/Base.js"></script>
<form name="frmClass" method="post" action="ClassAddOk.php?MenuId=<?php echo $_GET['MenuId']?>" onsubmit="return check_data()">
  <table width=90% align="center" cellpadding=4 cellspacing=1>
	<tbody>
	  <td align="center"><font color="#6699FF"><strong>������Ŀ - ������Ŀ����</strong></font></td>
	</tr>
	<td height="15"> <table width="85%" border="0" align="center" bordercolorlight="#5598DA" bordercolordark="#ffffff" bgcolor="#eeeeee">
	  <tr>
        <td height="25" align="right">������Ŀ</td>
        <td height="25">
        <?php
		if($class_id)													//�ж��Ƿ��и�ID
		{ 
			echo "<select name='parent_id' id='parent_id'>";
			echo "<option value='0'>��ѡ��</option>";
			foreach($class_list as $class)								//ѭ����ʾ��Ŀ�б�
			{
				echo "<option value='{$class['id']}'";
				if($class['id'] == $class_id)									//��ʾĬ��ѡ��
					echo " selected='selected'";
				echo ">{$class['class']}</option>";
			}
			echo "</select>";
		}else	{
			echo "<font color='red'>�����</font>";
		}
		?>
		</td>
	    </tr>
          <tr> 
            <td width="256" height="25" align="right">��Ŀ����</td>
            <td width="435" height="25"><input name="name" type="text" id="name" size="20" maxlength="12" value="<?php echo $info['F_CLASS_NAME']?>"></td>
          </tr>
          <tr> 
            <td height="25" align="right">˵��</td>
            <td height="25"><input name="note" type="text" id="note" size="30" maxlength="25" value="<?php echo $info['F_CLASS_NOTE']?>"> 
            </td>
          </tr>
          <tr>
            <td height="25" align="right">��ĿĿ¼����</td>
            <td height="25"><input name="url" type="text" id="url" value="<?php echo $info['F_CLASS_URL_NAME']?>">
            (Ӣ��)</td>
          </tr>
          <tr>
            <td height="25" align="right">��Ŀ��ҳ�ļ���</td>
            <td height="25"><input name="front" type="text" id="front" size="8" value="<?php echo $front?>">
              .
              <input name="back" type="text" id="back" size="8" value="<?php echo $back?>"></td>
          </tr>
          <tr>
            <td height="25" align="right">��Ŀ��ҳģ��·��</td>
            <td height="25"><input name="template_url" type="text" id="template_url" size="40" value="<?php echo $info['F_CLASS_TEMPLATE_URL']?>"><input type="button" name="Submit" value="ѡ��ģ��.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_template()"></td>
          </tr>
          <tr>
            <td height="25" align="right">��Ŀ��Ϣҳģ��</td>
            <td height="25"><input name="news_template" type="text" id="news_template" size="40" value="<?php echo $info['F_CLASS_NEWS_TEMPLATE']?>"><input type="button" name="Submit" value="ѡ��ģ��.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_news()"></td>
          </tr>
          <tr>
            <td height="25" align="right">��Ŀ�б���ʽģ��·��</td>
            <td height="25"><input name="list_style" type="text" id="list_style" size="40" value="<?php echo $info['F_CLASS_LIST_STYLE']?>"><input type="button" name="Submit" value="ѡ��ģ��.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_list_style()"></td>
          </tr>
          <tr>
            <td height="25" align="right">��ĿXMLģ��·��</td>
            <td height="25"><input name="xml" type="text" id="xml" size="40" value="<?php echo $info['F_CLASS_RSS_STYLE']?>"><input type="button" name="Submit" value="ѡ��ģ��.." style="BORDER-TOP-WIDTH: 1px; BORDER-LEFT-WIDTH: 1px; BORDER-BOTTOM-WIDTH: 1px; BORDER-RIGHT-WIDTH: 1px" onClick="select_xml()"></td>
          </tr>
          <tr>
            <td height="25" align="right">ÿҳ��ȡ��������</td>
            <td height="25"><input name="news_count" type="text" id="news_count" size="20" value="<?php echo $info['F_CLASS_NEWS_COUNT']?>"></td>
          </tr>
          <tr>
            <td height="25" align="right">��Ϣ����</td>
            <td height="25">
			<?php
			for($i=1;$i<=4;$i++)										//ѭ����ʾ����ѡ��
			{
				echo "<input type='radio' name='news_row' value='$i'";
				if($info['F_CLASS_NEWS_ROW'])						//�ж��Ƿ��Ǳ༭״̬
				{
					if($i == $info['F_CLASS_NEWS_ROW'])				//����Ĭ��ѡ��
						echo " checked";
				}else{
					if($i == 1)										//����Ĭ��ѡ��
						echo " checked";
				}
				echo ">$i";
			}
			?>
			</td>
          </tr>
          <tr>
            <td height="25" align="right">�Ƿ���ͼƬ��Ŀ</td>
            <td height="25"><input name="img" type="radio" value="1"<?php if($info['F_CLASS_SIGN_IMAGE'] == 1) echo " checked"?>>
              ��
              <input name="img" type="radio" value="0"<?php if(!$info['F_CLASS_SIGN_IMAGE']) echo " checked"?>>
              ��</td>
          </tr>
          <tr>
            <td height="25" align="right">���ű����ַ���</td>
            <td height="25"><input name="cap_len" type="text" id="cap_len" size="20" value="<?php echo $info['F_CLASS_CAP_LEN']?>"></td>
          </tr>
          <tr>
            <td height="25" align="right">���������ַ���</td>
            <td height="25"><input name="con_len" type="text" id="con_len" size="20" value="<?php echo $info['F_CLASS_CON_LEN']?>"></td>
          </tr>
        </table></td>
	</tr>
	<tr> 
	  <td height="15" align="center"><input name="cmdSubmit" type="submit" id="cmdSubmit" value="�ύ"> &nbsp; 
	  <input name="cmdReset" type="reset" id="cmdReset" value="����"><input type="hidden" name="class_id" id="class_id" value="<?php echo $class_id?>"></td></tr>
  </table>
</form>
<script language='javascript'>
/**
 * ���ܣ�������
 */
function check_data(){
	if ($('name').trim().value == ""){									//�ж���Ŀ�����Ƿ�Ϊ��
		alert("��Ŀ���Ʋ���Ϊ��")
		$('name').focus()
		return false
	}
	if ($('url').trim().value == ""){									//�ж���ĿĿ¼�����Ƿ�Ϊ��
		alert("��ĿĿ¼���Ʋ���Ϊ��")
		$('url').focus()
		return false
	}
	if ($('front').trim().value == ""){									//�ж���Ŀ��ҳ�ļ����Ƿ�Ϊ��
		alert("��Ŀ��ҳ�ļ�������Ϊ��")
		frmClass.front.focus()
		return false
	}
	if ($('back').trim().value == ""){									//�ж���Ŀ��ҳ�ļ����Ƿ�Ϊ��
		alert("��Ŀ��ҳ�ļ�������Ϊ��")
		$('back').focus()
		return false
	}
	if ($('template_url').trim().value == ""){							//�ж���Ŀ��ҳģ���ļ�·��
		alert("��Ŀ��ҳģ���ļ�·������Ϊ��")
		$('template_url').focus()
		return false
	}
	if(!($('list_style').trim().value == ""))								//�ж���Ŀ�б�ģ���Ƿ�Ϊ��
	{														//��Ϊ��
		var regu = /^[-]{0,1}[0-9]{1,}$/;
		if(!regu.test($('news_count').value))							//�ж����������Ƿ�Ϊ����
		{
			alert("ÿҳ��ȡ��������ӦΪ����")
			$('news_count').focus()
			return false
		}
		
		if(!regu.test($('cap_len').value)) 							//�ж����ű����ַ����Ƿ�Ϊ����
		{
			alert("���ű����ַ���ӦΪ����")
			$('cap_len').focus()
			return false
		}
		
		if(!regu.test($('con_len').value)) 							//�ж����������ַ����Ƿ�Ϊ����
		{
			alert("���������ַ���ӦΪ����")
			$('con_len').focus()
			return false
		}
	}
	return true
}
/**
 * ���ܣ�������ҳģ��ѡ���
 */
function select_template(){
	var w=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("../Templates/Select.php",null,theDes);
	if(rv){														//�ж��Ƿ��з���ֵ
		document.frmClass.template_url.value = rv;
	}
}
/**
 * ���ܣ�������Ϣҳģ��ѡ���
 */
function select_news(){
	var w=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("../Templates/Select.php",null,theDes);
	if(rv){ 													//�ж��Ƿ��з���ֵ
		document.frmClass.news_template.value = rv;
	}
}
/**
 * ���ܣ������б�ҳģ��ѡ���
 */
function select_list_style(){
	var w	=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("../Templates/Select.php",null,theDes);
	if(rv){ 													//�ж��Ƿ��з���ֵ
		document.frmClass.list_style.value = rv;
	}
}
/**
 * ���ܣ�����RSSҳģ��ѡ���
 */
function select_xml(){
	var w	=650;h=550;
	var theDes	="status:no;center:yes;help:no;minimize:yes;maximize:yes;dialogWidth:"+w+"px;scroll:auto;dialogHeight:"+h+"px;border:think";
	var rv	=window.showModalDialog("../Templates/Select.php",null,theDes);
	if(rv){ 													//�ж��Ƿ��з���ֵ
		document.frmClass.xml.value = rv;
	}
}
</script>
