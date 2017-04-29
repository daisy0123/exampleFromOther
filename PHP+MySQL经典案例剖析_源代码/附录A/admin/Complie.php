<?php
require_once('../config.inc.php');
require_once(INCLUDE_PATH . 'lang.inc.php');
$lang = new Lang();
$lang_id = $_GET['id'];
$info = $lang->getInfo($lang_id);
$msgfmt = "/usr/bin/msgfmt ";                            //linux
$msgfmt = "C:\\xampplite\\htdocs\\08\\Bin\\msgfmt.exe "; //windows
$LangCode = $info[F_CODE];
$fileName = $LangCode . '.po';
$LangRoot = LOCALE;
if (!is_dir($LangRoot . $LangCode)){					//�ж�·���Ƿ����,����������·��
	mkdir($LangRoot . $LangCode);
	mkdir($LangRoot . $LangCode . '/' . 'LC_MESSAGES');
}
$LangFullPath = $LangRoot . $LangCode . '/' . 'LC_MESSAGES/';
if (!is_writeable($LangFullPath)){					//�ж�·���Ƿ��д
	throw new Exception($LangFullPath . ' can not be write');
}
$data = $lang->getTransList($lang_id);
$fp = fopen($LangFullPath.$fileName,'w+');
flock($fp,LOCK_EX);
foreach ($data as $row){							//ѭ�������������ֵ�ͷ������ݰ�.po�ļ��ĸ�ʽд��										��.po�ļ�����
	if (isset($row['F_TEXT']) && $row['F_TEXT'] != ''){
		fputs($fp,"msgid \"".str_replace("\\'","'",$row['F_CODE'])."\"\n");
		fputs($fp,"msgstr \"".str_replace("\\'","'",$row['F_TEXT'])."\"\n");
		fputs($fp,"\n");
	}
}
flock($fp,LOCK_UN);
fclose($fp);
$LangFullPath = str_replace("/","\\",$LangFullPath);  //�����windows
$ComplieCmd = $msgfmt . ' -o ' . $LangFullPath . $LangCode . '.mo ' . $LangFullPath . $fileName;
exec($ComplieCmd);							//ִ�б�������
echo "����ɹ�<br>";
echo "<a href='javascript:window.history.back();'>����</a>";
?>
