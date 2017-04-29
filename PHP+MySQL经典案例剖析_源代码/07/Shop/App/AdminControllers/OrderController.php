<?php
class OrderController extends Core_Controller_Action 
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
		$this->_model = new OrderModel();
		parent::__construct();
	}
	/**
	 * ���ܣ���ʾ�����
	 */
	public function IndexAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//�ж��Ƿ��ύ
		{
			$this->_model->DealOrder($_POST['SelId']);					//�ı䶩��״̬
		}
		$userid = $this->_getParam('UserId');							//ȡ���û�ID
		$type = $this->_getParam('Type');								//ȡ����������
		$start = $this->_getParam('Start');								//ȡ��������ʼʱ��
		$keyword = $this->_getParam('Keyword');							//ȡ�������ؼ���
		$end = $this->_getParam('End');								//ȡ����������ʱ��
		$list = $this->_model->GetOrderList($userid,$type,$start,$end,$keyword);
		$this->_view->assign('date',$this->_model->GetDateOption());
		$this->_view->assign('userid',$userid);
		$this->_view->assign('list',$list);
		$this->_view->display('OrderList.php');
	}
	/**
	 * ���ܣ�����ת��
	 *
	 */
	public function RedirectAction()
	{
		$url = "/Order/Index";
		if($_POST['user'])											//�ж��Ƿ��û�����
		{
			$type = $_POST['type'];
			$url .= "/Type/$type";
			$keyword = urlencode($_POST['keyword']);
			$url .= "/Keyword/$keyword";
		}
		$userid = $this->_getParam('UserId');
		if($userid)													//�ж��Ƿ����û�ID����
			$url .= "/UserId/$userid";
		if($_POST['time'])											//�ж��Ƿ�ʱ������
		{
			$start = mktime(0,0,0,$_POST[start_m],$_POST[start_d],$_POST[start_y]);
			$end = mktime(0,0,0,$_POST[end_m],$_POST[end_d],$_POST[end_y]);
			$url .= "/Start/$start/End/$end";
		}
		$this->_redirect("$url");
	}
	/**
	 * ���ܣ���ʾ��������
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
