<?php require_once('config.inc.php')?>
<?php require_once(INCLUDE_PATH . 'db.inc.php')?>
<?php
$db = new DBSQL();
$arr = array("INSERT INTO em_menu_info VALUES(1,0,'����Ա����','����Ա����','');",
"INSERT INTO em_menu_info VALUES(2,1,'��������Ա','��������Ա','AddAdmin.php');",
"INSERT INTO em_menu_info VALUES(3,1,'����Ա����','����Ա����','AdminList.php');",
"INSERT INTO em_menu_info VALUES(4,1,'�����','�����','GroupList.php');",
"INSERT INTO em_menu_info VALUES(5,1,'�޸�����','�޸�����','EditPwd.php');",
"INSERT INTO em_menu_info VALUES(6,0,'��Ϣ����','��Ϣ����','');",
"INSERT INTO em_menu_info VALUES(7,6,'��Ŀ����','��Ŀ����','ClassList.php');",
"INSERT INTO em_menu_info VALUES(8,6,'��Ϣ����','��Ϣ����','NewsList.php');",
"INSERT INTO em_menu_info VALUES(9,6,'��Ŀ���','��Ŀ���','CheckList.php');",
"INSERT INTO em_menu_info VALUES(10,6,'���۹���','���۹���','CommentsList.php');",
"INSERT INTO em_menu_info VALUES(11,6,'�������ӹ���','�������ӹ���','LinkList.php');",
"INSERT INTO em_menu_info VALUES(12,6,'����վ','����վ','ReloadList.php');",
"INSERT INTO em_menu_info VALUES(13,6,'�ļ�����','�ļ�����','javascript:file_list();');",
"INSERT INTO em_menu_info VALUES(14,0,'ģ�����','ģ�����','');",
"INSERT INTO em_menu_info VALUES(15,14,'ȫ��ģ��','ȫ��ģ��','TemplateList.php');",
"INSERT INTO em_menu_info VALUES(16,14,'�����ѯ','�����ѯ','CodeSearch.php');",
"INSERT INTO em_menu_info VALUES(17,0,'����ˢ��','����ˢ��','');",
"INSERT INTO em_menu_info VALUES(18,17,'����ˢ����Ϣҳ��','����ˢ����Ϣҳ��','PubMain.php');",
"INSERT INTO em_menu_info VALUES(19,17,'����ˢ����Ŀҳ��','����ˢ����Ŀҳ��','GenAllList.php');",
"INSERT INTO em_menu_info VALUES(20,17,'����ˢ��XMLҳ��','����ˢ��XMLҳ��','GenAllRss.php');"
);
foreach($arr as $value) {
	$db->insert($value);
}
?>
