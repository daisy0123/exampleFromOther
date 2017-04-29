<?php
class ConfigController extends Core_Controller_Action 
{
	/**
	 * 功能：初始化构造函数
	 */
	public function __construct()
	{
		if(!$_SESSION['admin'])
		{
			$this->_redirect('/Index/Login');
		}
		$this->_model = new ConfigModel();
		$this->_editTmpl = 'ConfigAdd.php';
		parent::__construct();
	}
	/**
	 * 功能：显示配置列表
	 *
	 */
	public function IndexAction()
	{
		$this->_view->assign('list',$this->_model->listAll());
		$this->_view->display('Config.php');
	}
	/**
	 * 功能：编辑数据处理
	 *
	 */
	public function UpdateAction()
	{
		$data = array();
		$data[F_CONFIG_NOTE] = $_POST[note];
		$data[F_CONFIG_VALUE] = $_POST[value];
		if($this->_model->update($data,'F_ID = ' . $_POST[id]))				//判断是否操作成功
		{
			$this->_redirect('/Config');
		}
	}

}
?>
