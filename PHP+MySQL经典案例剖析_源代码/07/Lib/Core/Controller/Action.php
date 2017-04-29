<?php
abstract class Core_Controller_Action extends Zend_Controller_Action 
{
	protected $_view;
	protected $_model;
	protected $_addTmpl = null;
	protected $_editTmpl = null;
	/**
	 * ���ܣ���ʼ�����캯���������ʼ����View����
	 *
	 */
	public function __construct()
	{
        $this->_view = Zend::registry("view");
		parent::__construct();
	}
	/**
	 * ���ܣ�������Controller������ʱ����
	 *
	 */
	public function noRouteAction()
	{
        $this->_redirect('/');
	}
	/**
	 * ���ܣ�ʵ����ӽ������ʾ
	 *
	 */
	public function AddAction(){
		if(null != $this->_addTmpl){							//�ж����ģ������Ƿ���
			$this->_view->assign("action","Insert");				//ָ��ִ����Ӳ�����Action
			$this->_view->display($this->_addTmpl);
		}
	}
	/**
	 * ���ܣ�ʵ�ֱ༭�������ʾ
	 *
	 */
	public function EditAction(){
		if(null != $this->_editTmpl){							//�жϱ༭ģ������Ƿ���
			$this->_view->assign("action","Update");				//ָ��ִ�б༭������Action
			$this->_view->assign("info",$this->_model->getInfo($this->_getParam("Id")));
			$this->_view->display($this->_editTmpl);
		}
	}
	/**
	 * ���ܣ�ʵ��ָ��ID�ļ�¼ɾ��
	 *
	 */
	public function DelAction(){
		$id = $this->_getParam("Id");
		$this->_model->delete("F_ID = ".$id);
		$this->_redirect("/".$this->_action->getControllerName());
	}
	/**
	 * ���ܣ�ʵ�ּ�¼������ɾ��
	 *
	 */
	public function DelSelAction(){
		if (is_array($_POST['SelID'])){
			$strID = implode(",",$_POST['SelID']);		
			$this->_model->delete("F_ID find_in_set ( $strID )");
		}
		$this->_redirect("/".$this->_action->getControllerName());
	}
}
?>
