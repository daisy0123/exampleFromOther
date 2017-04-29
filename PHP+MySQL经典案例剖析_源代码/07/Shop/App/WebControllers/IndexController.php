<?php
class IndexController extends Core_Controller_Action 
{
	function __construct()
	{
		$this->_class = new ClassModel();
		$this->_model = new OrderModel();
		parent::__construct();
	}

	public function IndexAction()
	{
		global $classlist;
		$classlist = array();
		$deep = 0;
		$this->_class->GetClassListAll();
		$options = array();
		foreach ($classlist as $value) {
			$options[$value[id]] = $value[prev] . $value[class_name];
		}
		$this->_view->assign('date',$this->_model->GetDateOption());
		$this->_view->assign('class',$classlist);
		$this->_view->assign('option',$options);
		$this->_view->display('Index.php');
	}

    public function noRouteAction()
    {
        $this->_redirect('/');
    }
    
	public function GetVerifyImgAction()
	{
		header('Cache-control: private, no-cache'); 
		$_SESSION['verify_code'] = Core_Security_Verify::getVerify();
		Core_Security_Verify::GetImage($_SESSION['verify_code']);
	}
}
?>
