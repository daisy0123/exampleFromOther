<?php
class ConfigController extends Core_Controller_Action 
{
	/**
	 * ���ܣ���ʼ�����캯��
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
	 * ���ܣ���ʾ�����б�
	 *
	 */
	public function IndexAction()
	{
		$this->_view->assign('list',$this->_model->listAll());
		$this->_view->display('Config.php');
	}
	/**
	 * ���ܣ��༭���ݴ���
	 *
	 */
	public function UpdateAction()
	{
		$data = array();
		$data[F_CONFIG_NOTE] = $_POST[note];
		$data[F_CONFIG_VALUE] = $_POST[value];
		if($this->_model->update($data,'F_ID = ' . $_POST[id]))				//�ж��Ƿ�����ɹ�
		{
			$this->_redirect('/Config');
		}
	}

}
?>
