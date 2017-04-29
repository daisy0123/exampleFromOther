<?php
class OrderController extends Core_Controller_Action 
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
		$this->_model = new OrderModel();
		parent::__construct();
	}
	/**
	 * 功能：显示类别数
	 */
	public function IndexAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否提交
		{
			$this->_model->DealOrder($_POST['SelId']);					//改变订单状态
		}
		$userid = $this->_getParam('UserId');							//取得用户ID
		$type = $this->_getParam('Type');								//取得搜索类型
		$start = $this->_getParam('Start');								//取得搜索开始时间
		$keyword = $this->_getParam('Keyword');							//取得搜索关键字
		$end = $this->_getParam('End');								//取得搜索结束时间
		$list = $this->_model->GetOrderList($userid,$type,$start,$end,$keyword);
		$this->_view->assign('date',$this->_model->GetDateOption());
		$this->_view->assign('userid',$userid);
		$this->_view->assign('list',$list);
		$this->_view->display('OrderList.php');
	}
	/**
	 * 功能：搜索转向
	 *
	 */
	public function RedirectAction()
	{
		$url = "/Order/Index";
		if($_POST['user'])											//判断是否按用户搜索
		{
			$type = $_POST['type'];
			$url .= "/Type/$type";
			$keyword = urlencode($_POST['keyword']);
			$url .= "/Keyword/$keyword";
		}
		$userid = $this->_getParam('UserId');
		if($userid)													//判断是否有用户ID参数
			$url .= "/UserId/$userid";
		if($_POST['time'])											//判断是否按时间搜索
		{
			$start = mktime(0,0,0,$_POST[start_m],$_POST[start_d],$_POST[start_y]);
			$end = mktime(0,0,0,$_POST[end_m],$_POST[end_d],$_POST[end_y]);
			$url .= "/Start/$start/End/$end";
		}
		$this->_redirect("$url");
	}
	/**
	 * 功能：显示订单详情
	 *
	 */
	public function ListAction()
	{
		$orderid = $this->_getParam('Id');
		$list = $this->_model->GetOrderProduct($orderid);
		$this->_view->assign('list',$list);
		$this->_view->display('OrderProduct.php');
	}

}
?>
