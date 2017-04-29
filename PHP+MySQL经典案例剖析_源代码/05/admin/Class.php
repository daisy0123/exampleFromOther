<?php
$cat = $blog->GetCatList($blogid);
$title = "��ӷ���";
$url = "Index.php?Action=Class";
if($_GET['CatId'])										//�ж��Ƿ��з���ID,�����Ǳ༭����״̬
{
	$info = $blog->getInfo($_GET['CatId'],'EE_BLOG_CATEGORIES');
	if(!$info)											//�ж��Ƿ�˷���ID����
	{
		echo "�÷��಻����";
		exit();
	}
	$title = "�༭����";
	$url = "Index.php?Action=Class&CatId={$_GET['CatId']}";
}
if($_SERVER['REQUEST_METHOD'] == 'POST')				//�ж��Ƿ�Ϊ�ύ����
{
	$data = array();
	$data['F_ID_BLOG_INFO'] = $blogid;
	$data['F_CATEGORIES_NAME'] = $_POST['cat_name'];
	$data['F_CATEGORIES_DESCRIPTION'] = $_POST['description'];
	if($_GET['CatId'])									//�ж��Ƿ�Ϊ�༭״̬
	{
		$blog->updateData('EE_BLOG_CATEGORIES',$_GET['CatId'],$data);
		header("Location:Index.php?Action=Class");
		exit();
	}else{
		$blog->insertData('EE_BLOG_CATEGORIES',$data);
		header("Location:Index.php?Action=Class");
		exit();
	}
}
?>
<div id=main>
<?php
if(!$_GET['CatId'])										//�ж��Ƿ�Ϊ�༭״̬,��������ʾ�����б�
{
?>
<div class="wrap">
<h2>���� (<A href="#addcat">����·���</A>) </h2>
<table>
  <tr>
    <th>ID<th/>
    <th>����</th>
    <th>����</th>
    <th>����</th>
    <th colspan="2">����</th>
  </tr>
<?php
foreach($cat as $value)
{
?>
  <tr>
    <th><?php echo $value['F_ID']?></th>
    <th><?php echo $value['F_CATEGORIES_NAME']?></th>
    <th><?php echo $value['F_CATEGORIES_DESCRIPTION']?></th>
    <th><a href="Index.php?CatId=<?php echo $value['F_ID']?>&Action=Class">�༭</a></th>
    <th>
    <?php
    if($value['F_CATEGORIES_DEFAULT'] == 1)								//�ж��Ƿ�ΪĬ�Ϸ�,������ʾĬ��
    	echo "Ĭ��";
    else{											//��������ʾɾ������
    	echo "<a href=\"Index.php?CatId={$value['F_ID']}&Action=ClassDel\"";
    	echo " onclick=\"javascript:confirm('���Ҫɾ����')\">ɾ��</a>";
	}
    ?>
	</th>
  </tr>
<?php
 }
?>
</table>
</div>
<div class="wrap">
<p><strong>ע��</strong>: <br />
  ɾ��һ�����ಢ����ɾ�����е���ǩ����ɾ�������е��������½���ת�Ƶ�Ĭ�Ϸ����С�</p>
</div>
<?php
}
?>
<div class=wrap>
<H2><?php echo $title?></H2>
<form id=addcat name=addcat action="<?php echo $url?>" method=post onsubmit="javascript:return check();" >
<table class=editform cellSpacing=2 cellPadding=5 width="80%">
  <tr>
    <th>��������:</th>
    <td><input id=cat_name size=40 name=cat_name value="<?php echo $info['F_CATEGORIES_NAME']?>"></td>
  </tr>
  
  <tr>
    <th vAlign=top scope=row>����:(��ѡ)</th>
    <td><textarea id=description name=description rows=5 cols=50><?php echo $info['F_CATEGORIES_DESCRIPTION']?></textarea></td>
	</tr>
</table>
<P><input type=submit value="<?php echo $title?>" name=submit></P>
<script language="javacript">
/**
 *���ܣ������ύ����
 *
 */
function check()
{
	if(document.addcat.cat_name.value == '')							//�жϷ��������Ƿ�Ϊ��
	{
		alert('����д��������');									//Ϊ������ʾ
		document.addcat.cat_name.focus();							//��λ���㵽�������������
		return false;		
	}
	if(!checkByteLength(document.addcat.cat_name.value,1,50))			//�жϷ������Ƴ����Ƿ�Ϸ�
	{
		alert('�������Ƴ��Ȳ���ȷ������Ϊ1-50���ַ�');				//���Ϸ�����ʾ
		document.addcat.cat_name.focus();							//��λ���㵽�������������
		return false;
	}
	if(document.addcat.description.value != '')							//�ж������Ƿ�Ϊ��
	{
		if(!checkByteLength(document.addcat.description.value,1,100))	//��Ϊ�����жϳ����Ƿ�Ϸ�
		{
			alert('�����������Ȳ���ȷ������Ϊ1-100���ַ�');			//���Ϸ�����ʾ
			document.addcat.description.focus();					//��λ���㵽�������������
			return false;
		}
	}
	return true;
}
</script>
</form>
</div>
