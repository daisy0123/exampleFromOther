<?php
include_once( 'Zend.php' );
@define('MODULE_NAME', 'Web');										//定义Module名称
require_once( '../Config.ini.php' );
session_start();
$c = Zend_Controller_Front::getInstance();
$c->setControllerDirectory( ACTION_PATH );								//设置调用Controller路径s
$db = Zend_Db::factory('PDO_MYSQL',$SQL_CONFIG);						//连接Mysql
Zend_Db_Table::setDefaultAdapter($db);
$view = new Core_View_Smarty();
Zend::register('view',$view);											//注册视图对象
Zend::register('db',$db);												//注册数据库对象
$db->query("set names 'gb2312'");
$tr = new Zend_Mail_Transport_Smtp('mail.xxx.com',25,'127.0.0.1',true,'admin@xxx.com','password');
Zend_Mail::setDefaultTransport($tr);										//设置SMTP服务
try {
	$c->dispatch();	
} catch( Zend_Controller_Action_Exception $e ) {							//捕获异常
	echo 'Could not dispatch';
}
?>