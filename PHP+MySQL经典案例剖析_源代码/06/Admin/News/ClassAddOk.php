<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
if ($News->CheckClassName($_POST['parent_id'],$_POST['name'])){		//���ͬһ��Ŀ�������Ƿ����
	echo "��Ŀ�����ظ�,���޸�<br><a href='javascript:history.back()'>����</a>";
}else{
	if(!$_POST['parent_id']){										//�ж��Ƿ�����Ӷ�����Ŀ
		$path = "../../{$_POST['url']}";
		if(file_exists($path))										//�ж�Ŀ¼�Ƿ����
		{
			echo "Ŀ¼�Դ���<br>";
			echo "<a href='javascript:window.history.back()'>����</a>";
			exit;
		}
		if(!mkdir($path,0777)){									//�ж��Ƿ��ܴ���Ŀ¼
			echo "���ܴ�����Ŀ¼<br>";
			echo "<a href='javascript:window.history.back()'>����</a>";
			exit;
		}
		$path = "/{$_POST['url']}" . "/";
		$sub_path = "../../{$_POST['url']}/_content";
		if(!mkdir($sub_path,0777)){								//�ж��Ƿ��ܴ���Ŀ¼
			echo "���ܴ�������Ŀ¼<br>";
			echo "<a href='javascript:window.history.back()'>����</a>";
			exit;
		}
		$rss = "../../{$_POST['url']}/rss";
		if(!mkdir($rss,0777)){										//�ж��Ƿ��ܴ���Ŀ¼
			echo "���ܴ�������Ŀ¼<br>";
			echo "<a href='javascript:window.history.back()'>����</a>";
			exit;
		}
	}else{
		$sql = "SELECT F_CLASS_PATH FROM EM_CLASS_INFO WHERE F_ID = {$_POST['parent_id']}";
		$par_url = $News->select($sql);
		$path = "../..".$par_url[0][0] . $_POST['url'];
		if(file_exists($path))										//�ж�Ŀ¼�Ƿ����
		{
			echo "Ŀ¼�Դ���<br>";
			echo "<a href='javascript:window.history.back()'>����</a>";
			exit;
		}
		if(!mkdir($path,0777)){									//�ж��Ƿ��ܴ���Ŀ¼
			echo "���ܴ�����Ŀ¼<br>";
			echo "<a href='javascript:window.history.back()'>����</a>";
			exit;
		}
		$path = $par_url[0][0] . $_POST['url'] . "/";
		$sub_path = "../..$path/_content";
		if(!mkdir($sub_path,0777)){								//�ж��Ƿ��ܴ���Ŀ¼
			echo "���ܴ�������Ŀ¼<br>";
			echo "<a href='javascript:window.history.back()'>����</a>";
			exit;
		}
		$rss = "../..$path/rss";
		if(!mkdir($rss,0777)){										//�ж��Ƿ��ܴ���Ŀ¼
			echo "���ܴ�������Ŀ¼<br>";
			echo "<a href='javascript:window.history.back()'>����</a>";
			exit;
		}
	}
	if(!$_POST['parent_id']) $_POST['parent_id'] = 0;					//����޸�IDĬ��Ϊ0
	$index_name = trim($_POST['front']) . "." . trim($_POST['back']);
	$data['F_PARENT_ID'] = $_POST['parent_id'];
	$data['F_CLASS_NAME'] = $_POST['name'];
	$data['F_CLASS_NOTE'] = $_POST['note'];
	$data['F_CLASS_URL_NAME'] = $_POST['url'];
	$data['F_CLASS_PATH'] = $path;
	$data['F_CLASS_TEMPLATE_URL'] = $_POST['template_url'];
	$data['F_CLASS_LIST_STYLE'] = $_POST['list_style'];
	$data['F_CLASS_NEWS_COUNT'] = $_POST['news_count'];
	$data['F_CLASS_NEWS_ROW'] = $_POST['news_row'];
	$data['F_CLASS_SIGN_IMAGE'] = $_POST['img'];
	$data['F_CLASS_CAP_LEN'] = $_POST['cap_len'];
	$data['F_CLASS_CON_LEN'] = $_POST['con_len'];
	$data['F_CLASS_NEWS_TEMPLATE'] = $_POST['news_template'];	
	$data['F_CLASS_INDEX_NAME'] = $index_name;
	$data['F_CLASS_RSS_STYLE'] = $_POST['xml'];
	if($_POST['id'])												//�ж��Ƿ��Ǳ༭״̬
	{
		$News->updateData("EM_CLASS_INFO",$_POST['id'],$data);
		$msg = "�����³ɹ�";
		echo "<script language='javascript'>
		parent.frames('left').location.reload();
		</script>";
		$id = $_POST['id'];
	}else{
		$id = $News->insertData("EM_CLASS_INFO",$data);
		$msg = "�������ӳɹ�";
	}
	echo "$msg<br><a href='ClassInfo.php?id=$id&MenuId={$_GET['MenuId']}'>�����б�</a>";
}
?>
