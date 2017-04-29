<?php
include_once( 'Zend.php' );
session_start();
@define('MODULE_NAME', 'Admin');									//定义Module名称
include_once( '../Config.ini.php' );
$db = Zend_Db::factory('PDO_MYSQL',$SQL_CONFIG);						//连接数据库
Zend_Db_Table::setDefaultAdapter($db);
Zend::register('db',$db);												//注册数据库访问对象
$db->query("set names 'gb2312'");
$c = Zend_Controller_Front::getInstance();
$c->setControllerDirectory( ACTION_PATH );
$view = new Core_View_Smarty();
Zend::register('view',$view);											//注册视图对象
$tr = new Zend_Mail_Transport_Smtp('mail.xxx.com',25,'127.0.0.1',true,'admin@xxx.com','password');
Zend_Mail::setDefaultTransport($tr);										//设置SMTP服务
try {
	$c->dispatch();
} catch( Zend_Controller_Action_Exception $e ) {
	echo 'Could not dispatch';
}
?>