<?php
	if(!defined('MODULE_NAME')){
		die('MODULE_NAME Not defined');
	}
	@define('WEB_DOMAIN','http://test.shop');						//ǰ̨����
	@define('ADMIN_DOMAIN','http://admin.shop');						//��̨����
	@define('ROOT_PATH', dirname(__FILE__) . '/');						//��Ŀ¼
	@define('APP_PATH', ROOT_PATH . 'App/');							//AppĿ¼
	@define('MODEL_PATH', APP_PATH . 'Models/');						//ModelĿ¼
	@define('VIEW_PATH', APP_PATH . MODULE_NAME . 'Views/');			//ViewsĿ¼
	@define('ACTION_PATH', APP_PATH . MODULE_NAME . 'Controllers/');	//ControllersĿ¼
	@define('UPLOAD_PATH', ROOT_PATH . 'Web/upload/');				//�ϴ��ļ�Ŀ¼
	@define('UPLOAD_DIR','/upload/');									//�ϴ��ļ���ʾ·��
	@define('INCLUDE_PATH', APP_PATH . 'Includes/');					//�����ļ�·��
	@define('FONT_PATH', INCLUDE_PATH .'Fonts/');						//�����ļ�·��
	@define('TEMPLATE_PATH', VIEW_PATH);							//ģ���ļ�·��
	@define('TEMPLATE_C_PATH', ROOT_PATH . 'Templates_c/' . MODULE_NAME . '/');
	@define('CONFIG_PATH', APP_PATH . 'Configs/');						//ConfigsĿ¼
	@define('CACHE_PATH', APP_PATH . 'Cache/');						//CachĿ¼
	@define('UPLOAD_MAX_SIZE',200);								//�ϴ�ͼƬ��С����
	$SQL_CONFIG = array('host'=>'127.0.0.1',							//���ݿ���������
					   'username'=>'root',
					   'password'=>'123456',
					   'dbname'=>'shop',
					   'charset'=>'gb2312');
	/**
	 * ���ܣ��Զ��������ļ��������
	 * ������$classΪ������
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
