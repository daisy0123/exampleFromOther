<?php
class OrderController extends Core_Controller_Action
{
	protected $_model;
	protected $_user;
	protected $_cart;
	protected $_product;
	/**
	 * ��ʼ�����캯��
	 *
	 */
	public function __construct()
	{
		$this->_model = new OrderModel();
		$this->_user = new UserModel();
		$this->_cart = new CartModel();
		$this->_product = new ProductModel();
		parent::__construct();
	}
	/**
	 * ���ܣ��¶���
	 *
	 */
    public function IndexAction()
    {
    		if(!isset($_SESSION['User']))								//�ж��Ƿ��Ѿ���½
    		{
    			$msg = "�Բ�����δ��½��";
    			$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='/Login'>���ص�½</a>");
				$this->_view->display("sysmsg.php");
				exit;
    		}
    		if(!isset($_SESSION['User']['SESSION_ID']))					//�ж��Ƿ���SESSION_ID
    		{
    			$ip = $_SERVER["REMOTE_ADDR"];
				$ip1 = $_SERVER["HTTP_X_FORWARDED_FOR"];
				$ip2 = $_SERVER["HTTP_CLIENT_IP"];
				($ip1) ? $ip = $ip1 : null ;
				($ip2) ? $ip = $ip2 : null ;
				$_SESSION['User']['SESSION_ID'] = md5($ip);
				$sessionid = $_SESSION['User']['SESSION_ID'];
    		}else{
    			$sessionid = $_SESSION['User']['SESSION_ID'];
    		}
    		$sum = 0;
    		$list = $this->_cart->GetProductList($sessionid);
    		if($list)												//�жϹ��ﳵ���Ƿ��в�Ʒ
    		{
    			foreach($list as $value)								//���㹺�ﳵ�в�Ʒ�ܼ�
    			{
    				$info = $this->_product->getInfo($value[F_ID_PRODUCT_INFO]);
    				if($info[F_PRODUCT_LOW_PRICE])				//�ж��Ƿ����ۿۼ�
    				{
    					$sum = $sum + $info[F_PRODUCT_PRICE];
    				}else{
    					$sum = $sum + $info[F_PRODUCT_LOW_PRICE];
    				}
    			}
    		}
    		$user = $this->_user->GetUserInfo($_SESSION['User']['F_ID']);
    		$this->_view->assign('info',$user);
    		$this->_view->assign('sum',$sum);
    		$this->_view->assign('list',$list);
    		$this->_view->display('Order.php');
    }
    /**
     * ���ܣ�����������
     *
     */
    public function AddAction()
    {
		if(strtolower($_SESSION['verify_code'])!=strtolower(trim($_POST['verify'])))
		{													//�ж���֤���Ƿ���ȷ
			$msg = "��֤�벻��ȷ��";
			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/Order'>������һҳ</a>");
			$this->_view->display("sysmsg.php");
			exit;
		}
		if(!isset($_SESSION['User']['SESSION_ID']))					//�ж��Ƿ���SESSION_ID
		{
			$ip = $_SERVER["REMOTE_ADDR"];
			$ip1 = $_SERVER["HTTP_X_FORWARDED_FOR"];
			$ip2 = $_SERVER["HTTP_CLIENT_IP"];
			($ip1) ? $ip = $ip1 : null ;
			($ip2) ? $ip = $ip2 : null ;
			$_SESSION['User']['SESSION_ID'] = md5($ip);
			$sessionid = $_SESSION['User']['SESSION_ID'];
		}else{
			$sessionid = $_SESSION['User']['SESSION_ID'];
		}
		if($this->_cart->GetProductList($sessionid))					//�жϹ��ﳵ���Ƿ��в�Ʒ
		{
			if($_POST['store'])									//�ж��Ƿ���Ϊ�û����ϱ���
			{
				$data = array();
				$data['F_USER_TRUENAME'] = $_POST['name'];
				$data['F_USER_ZIPCODE'] = $_POST['zipcode'];
				$data['F_USER_ADDRESS'] = $_POST['address'];
				$data['F_USER_MOBILE'] = $_POST['mobile'];
				$data['F_USER_PHONE'] = $_POST['phone'];
				$data['F_USER_HOME_PHONE'] = $_POST['home_phone'];
				$this->_user->UpdateUserInfo($_SESSION['User']['F_ID'],$data);
			}
			$data = array();
			$data['F_ID_LOGIN_INFO'] = $_SESSION['User']['F_ID'];
			$data['F_ORDER_ZIPCODE'] = $_POST['zipcode'];
			$data['F_ORDER_ADDRESS'] = $_POST['address'];
			$data['F_ORDER_MOBILE'] = $_POST['mobile'];
			$data['F_ORDER_PHONE'] = $_POST['phone'];
			$data['F_ORDER_HOME_PHONE'] = $_POST['home_phone'];
			$data['F_ORDER_NOTE'] = htmlspecialchars(addslashes($_POST['note']));
			$data['F_ORDER_TIME'] = time();
			if($this->_model->InsertCart($data,$sessionid))					//�ж������Ƿ���ɹ�
			{
				$msg = "�����ɹ���";
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='/'>������ҳ</a>");
				$this->_view->display("sysmsg.php");
				exit;
			}else{
				$msg = "����ʧ�ܣ�";
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='/Order'>������һҳ</a>");
				$this->_view->display("sysmsg.php");
				exit;			
			}   		
		}else{
			$msg = "�Բ������Ĺ��ﳵ��û��Ʒ��";
			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/Order'>������һҳ</a>");
			$this->_view->display("sysmsg.php");
			exit;	   		
		}
    }
	/**
	 * ���ܣ�������ѯ
	 */
	public function SearchAction()
	{
	    if(!isset($_SESSION['User']))								//�ж��Ƿ��ѵ�½
    		{
    			$msg = "�Բ�����δ��½��";
    			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/Login'>���ص�½</a>");
			$this->_view->display("sysmsg.php");
			exit;
    		}
		$start = (int)($this->_getParam('Start'));
		$end = (int)($this->_getParam('End'));
		if((strlen($start) == 10) and (strlen($end) == 10))				//�ж����������Ƿ���ȷ
		{
			$userid = $_SESSION['User']['F_ID'];
			$start = $this->_getParam('Start');
			$end = $this->_getParam('End');
			$list = $this->_model->GetOrderList($userid,0,$start,$end,0);
			$this->_view->assign('list',$list);
			$this->_view->assign('action',$this->_getParam('Action'));
		}
		$this->_view->assign('date',$this->_model->GetDateOption());
		$this->_view->display('SearchOrder.php');
	}
	/**
	 * ���ܣ���ѯת��
	 */	
	public function RedirectAction()
	{
		$start = mktime(0,0,0,$_POST[start_m],$_POST[start_d],$_POST[start_y]);
		$end = mktime(0,0,0,$_POST[end_m],$_POST[end_d],$_POST[end_y]);
		$this->_redirect("/Order/Search/Start/$start/End/$end/Action/Search");
	}
	/**
	 * ���ܣ���������
	 */	
	public function ListAction()
	{
		$orderid = $this->_getParam('Id');
		$list = $this->_model->GetOrderProduct($orderid);
		if($list[0][F_ID_LOGIN_INFO] != $_SESSION['User']['F_ID'])		//�ж��û��Ƿ��ǲ鿴�Լ��Ķ���
		{
			$msg = "�Բ�����ֻ�ܲ鿴�Լ��Ķ�����Ϣ��";
    		$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='javascript:window.close();'>�رմ���</a>");
			$this->_view->display("sysmsg.php");
			exit;
		}
		$this->_view->assign('list',$list);
		$this->_view->display('OrderProduct.php');
	}

}
?>
