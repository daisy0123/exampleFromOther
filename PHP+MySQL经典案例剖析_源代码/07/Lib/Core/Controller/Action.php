<?php
abstract class Core_Controller_Action extends Zend_Controller_Action 
{
	protected $_view;
	protected $_model;
	protected $_addTmpl = null;
	protected $_editTmpl = null;
	/**
	 * 功能：初始化构造函数，里面初始化了View对象
	 *
	 */
	public function __construct()
	{
        $this->_view = Zend::registry("view");
		parent::__construct();
	}
	/**
	 * 功能：当请求Controller不存在时调用
	 *
	 */
	public function noRouteAction()
	{
        $this->_redirect('/');
	}
	/**
	 * 功能：实现添加界面的显示
	 *
	 */
	public function AddAction(){
		if(null != $this->_addTmpl){							//判断添加模板变量是否定义
			$this->_view->assign("action","Insert");				//指定执行添加操作的Action
			$this->_view->display($this->_addTmpl);
		}
	}
	/**
	 * 功能：实现编辑界面的显示
	 *
	 */
	public function EditAction(){
		if(null != $this->_editTmpl){							//判断编辑模板变量是否定义
			$this->_view->assign("action","Update");				//指定执行编辑操作的Action
			$this->_view->assign("info",$this->_model->getInfo($this->_getParam("Id")));
			$this->_view->display($this->_editTmpl);
		}
	}
	/**
	 * 功能：实现指定ID的记录删除
	 *
	 */
	public function DelAction(){
		$id = $this->_getParam("Id");
		$this->_model->delete("F_ID = ".$id);
		$this->_redirect("/".$this->_action->getControllerName());
	}
	/**
	 * 功能：实现记录的批量删除
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
