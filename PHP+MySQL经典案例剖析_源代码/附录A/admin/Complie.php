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
if (!is_dir($LangRoot . $LangCode)){					//判断路径是否存在,不存在则建立路径
	mkdir($LangRoot . $LangCode);
	mkdir($LangRoot . $LangCode . '/' . 'LC_MESSAGES');
}
$LangFullPath = $LangRoot . $LangCode . '/' . 'LC_MESSAGES/';
if (!is_writeable($LangFullPath)){					//判断路径是否可写
	throw new Exception($LangFullPath . ' can not be write');
}
$data = $lang->getTransList($lang_id);
$fp = fopen($LangFullPath.$fileName,'w+');
flock($fp,LOCK_EX);
foreach ($data as $row){							//循环将语言数据字典和翻译数据按.po文件的格式写入										到.po文件里面
	if (isset($row['F_TEXT']) && $row['F_TEXT'] != ''){
		fputs($fp,"msgid \"".str_replace("\\'","'",$row['F_CODE'])."\"\n");
		fputs($fp,"msgstr \"".str_replace("\\'","'",$row['F_TEXT'])."\"\n");
		fputs($fp,"\n");
	}
}
flock($fp,LOCK_UN);
fclose($fp);
$LangFullPath = str_replace("/","\\",$LangFullPath);  //如果是windows
$ComplieCmd = $msgfmt . ' -o ' . $LangFullPath . $LangCode . '.mo ' . $LangFullPath . $fileName;
exec($ComplieCmd);							//执行编译命令
echo "编译成功<br>";
echo "<a href='javascript:window.history.back();'>返回</a>";
?>
