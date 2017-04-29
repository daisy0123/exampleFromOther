<?php
	if(!defined('MODULE_NAME')){
		die('MODULE_NAME Not defined');
	}
	@define('WEB_DOMAIN','http://test.shop');						//前台域名
	@define('ADMIN_DOMAIN','http://admin.shop');						//后台域名
	@define('ROOT_PATH', dirname(__FILE__) . '/');						//根目录
	@define('APP_PATH', ROOT_PATH . 'App/');							//App目录
	@define('MODEL_PATH', APP_PATH . 'Models/');						//Model目录
	@define('VIEW_PATH', APP_PATH . MODULE_NAME . 'Views/');			//Views目录
	@define('ACTION_PATH', APP_PATH . MODULE_NAME . 'Controllers/');	//Controllers目录
	@define('UPLOAD_PATH', ROOT_PATH . 'Web/upload/');				//上传文件目录
	@define('UPLOAD_DIR','/upload/');									//上传文件显示路径
	@define('INCLUDE_PATH', APP_PATH . 'Includes/');					//包含文件路径
	@define('FONT_PATH', INCLUDE_PATH .'Fonts/');						//字体文件路径
	@define('TEMPLATE_PATH', VIEW_PATH);							//模板文件路径
	@define('TEMPLATE_C_PATH', ROOT_PATH . 'Templates_c/' . MODULE_NAME . '/');
	@define('CONFIG_PATH', APP_PATH . 'Configs/');						//Configs目录
	@define('CACHE_PATH', APP_PATH . 'Cache/');						//Cach目录
	@define('UPLOAD_MAX_SIZE',200);								//上传图片大小限制
	$SQL_CONFIG = array('host'=>'127.0.0.1',							//数据库连接数组
					   'username'=>'root',
					   'password'=>'123456',
					   'dbname'=>'shop',
					   'charset'=>'gb2312');
	/**
	 * 功能：自动加载类文件或调用类
	 * 参数：$class为类名称
	 */
	function __autoload($class)
    	{
		$Module = explode('_',$class);
		if ($Module[0] == 'Zend' || $Module[0] == 'Core')
			Zend::loadClass($class);
		else
			Zend::loadFile($class.'.php',MODEL_PATH);
    }
?>
