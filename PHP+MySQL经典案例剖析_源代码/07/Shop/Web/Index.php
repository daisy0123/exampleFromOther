<?php
include_once( 'Zend.php' );
@define('MODULE_NAME', 'Web');										//����Module����
require_once( '../Config.ini.php' );
session_start();
$c = Zend_Controller_Front::getInstance();
$c->setControllerDirectory( ACTION_PATH );								//���õ���Controller·��s
$db = Zend_Db::factory('PDO_MYSQL',$SQL_CONFIG);						//����Mysql
Zend_Db_Table::setDefaultAdapter($db);
$view = new Core_View_Smarty();
Zend::register('view',$view);											//ע����ͼ����
Zend::register('db',$db);												//ע�����ݿ����
$db->query("set names 'gb2312'");
$tr = new Zend_Mail_Transport_Smtp('mail.xxx.com',25,'127.0.0.1',true,'admin@xxx.com','password');
Zend_Mail::setDefaultTransport($tr);										//����SMTP����
try {
	$c->dispatch();	
} catch( Zend_Controller_Action_Exception $e ) {							//�����쳣
	echo 'Could not dispatch';
}
?>