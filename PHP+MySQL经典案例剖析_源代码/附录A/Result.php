<?php
require_once('Smarty/class.template.php');
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'view.inc.php');
require_once(INCLUDE_PATH . 'dict.inc.php');
require_once(INCLUDE_PATH . 'lang.inc.php');
require_once(INCLUDE_PATH . 'core.inc.php');
$lang_code = Core::getLanguage();
Core::setLanguage();
$view = new View($lang_code);
$lang = new Lang();
$list = $lang->getList();
$sql = "SELECT F_ID FROM ZD_LANGUAGE WHERE F_CODE = '$lang_code'";
$r = $lang->select($sql);
$lang_id = $r[0][0];
$sql = "SELECT D.F_CODE,T.F_TEXT FROM ZD_LANGUAGE_DICT D,ZD_LANGUAGE_TRANS T WHERE D.F_ID = T.F_ID_DICT AND T.F_ID_LANG = '$lang_id'";
$data = $lang->select($sql);
$show = array();
foreach ($data as $key => $value) {
	$show[$key][F_CODE] = $value[F_CODE];
	$show[$key][F_TEXT] = $value[F_TEXT];
}
$view->assign('lan',$list);
$view->assign('item',$show);
$view->display('result.php');
?>