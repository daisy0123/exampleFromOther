<?php require_once('config.inc.php')?>
<?php require_once(INCLUDE_PATH . 'db.inc.php')?>
<?php
$db = new DBSQL();
$arr = array("INSERT INTO em_menu_info VALUES(1,0,'管理员管理','管理员管理','');",
"INSERT INTO em_menu_info VALUES(2,1,'新增管理员','新增管理员','AddAdmin.php');",
"INSERT INTO em_menu_info VALUES(3,1,'管理员管理','管理员管理','AdminList.php');",
"INSERT INTO em_menu_info VALUES(4,1,'组管理','组管理','GroupList.php');",
"INSERT INTO em_menu_info VALUES(5,1,'修改密码','修改密码','EditPwd.php');",
"INSERT INTO em_menu_info VALUES(6,0,'信息管理','信息管理','');",
"INSERT INTO em_menu_info VALUES(7,6,'栏目管理','栏目管理','ClassList.php');",
"INSERT INTO em_menu_info VALUES(8,6,'信息管理','信息管理','NewsList.php');",
"INSERT INTO em_menu_info VALUES(9,6,'栏目审核','栏目审核','CheckList.php');",
"INSERT INTO em_menu_info VALUES(10,6,'评论管理','评论管理','CommentsList.php');",
"INSERT INTO em_menu_info VALUES(11,6,'常用链接管理','常用链接管理','LinkList.php');",
"INSERT INTO em_menu_info VALUES(12,6,'回收站','回收站','ReloadList.php');",
"INSERT INTO em_menu_info VALUES(13,6,'文件管理','文件管理','javascript:file_list();');",
"INSERT INTO em_menu_info VALUES(14,0,'模板管理','模板管理','');",
"INSERT INTO em_menu_info VALUES(15,14,'全能模块','全能模块','TemplateList.php');",
"INSERT INTO em_menu_info VALUES(16,14,'代码查询','代码查询','CodeSearch.php');",
"INSERT INTO em_menu_info VALUES(17,0,'批量刷新','批量刷新','');",
"INSERT INTO em_menu_info VALUES(18,17,'批量刷新信息页面','批量刷新信息页面','PubMain.php');",
"INSERT INTO em_menu_info VALUES(19,17,'批量刷新栏目页面','批量刷新栏目页面','GenAllList.php');",
"INSERT INTO em_menu_info VALUES(20,17,'批量刷新XML页面','批量刷新XML页面','GenAllRss.php');"
);
foreach($arr as $value) {
	$db->insert($value);
}
?>
