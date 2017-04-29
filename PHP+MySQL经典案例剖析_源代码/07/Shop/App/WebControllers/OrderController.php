<?php
class OrderController extends Core_Controller_Action
{
	protected $_model;
	protected $_user;
	protected $_cart;
	protected $_product;
	/**
	 * 初始化构造函数
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
	 * 功能：下订单
	 *
	 */
    public function IndexAction()
    {
    		if(!isset($_SESSION['User']))								//判断是否已经登陆
    		{
    			$msg = "对不起，您未登陆！";
    			$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='/Login'>返回登陆</a>");
				$this->_view->display("sysmsg.php");
				exit;
    		}
    		if(!isset($_SESSION['User']['SESSION_ID']))					//判断是否有SESSION_ID
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
    		if($list)												//判断购物车中是否有产品
    		{
    			foreach($list as $value)								//计算购物车中产品总价
    			{
    				$info = $this->_product->getInfo($value[F_ID_PRODUCT_INFO]);
    				if($info[F_PRODUCT_LOW_PRICE])				//判断是否有折扣价
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
     * 功能：处理订单数据
     *
     */
    public function AddAction()
    {
		if(strtolower($_SESSION['verify_code'])!=strtolower(trim($_POST['verify'])))
		{													//判断验证码是否正确
			$msg = "验证码不正确！";
			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/Order'>返回上一页</a>");
			$this->_view->display("sysmsg.php");
			exit;
		}
		if(!isset($_SESSION['User']['SESSION_ID']))					//判断是否有SESSION_ID
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
		if($this->_cart->GetProductList($sessionid))					//判断购物车中是否有产品
		{
			if($_POST['store'])									//判断是否作为用户资料保存
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
			if($this->_model->InsertCart($data,$sessionid))					//判断数据是否处理成功
			{
				$msg = "操作成功！";
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='/'>返回首页</a>");
				$this->_view->display("sysmsg.php");
				exit;
			}else{
				$msg = "操作失败！";
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='/Order'>返回上一页</a>");
				$this->_view->display("sysmsg.php");
				exit;			
			}   		
		}else{
			$msg = "对不起，您的购物车里没产品！";
			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/Order'>返回上一页</a>");
			$this->_view->display("sysmsg.php");
			exit;	   		
		}
    }
	/**
	 * 功能：订单查询
	 */
	public function SearchAction()
	{
	    if(!isset($_SESSION['User']))								//判断是否已登陆
    		{
    			$msg = "对不起，您未登陆！";
    			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='/Login'>返回登陆</a>");
			$this->_view->display("sysmsg.php");
			exit;
    		}
		$start = (int)($this->_getParam('Start'));
		$end = (int)($this->_getParam('End'));
		if((strlen($start) == 10) and (strlen($end) == 10))				//判断搜索参数是否正确
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
	 * 功能：查询转向
	 */	
	public function RedirectAction()
	{
		$start = mktime(0,0,0,$_POST[start_m],$_POST[start_d],$_POST[start_y]);
		$end = mktime(0,0,0,$_POST[end_m],$_POST[end_d],$_POST[end_y]);
		$this->_redirect("/Order/Search/Start/$start/End/$end/Action/Search");
	}
	/**
	 * 功能：订单详情
	 */	
	public function ListAction()
	{
		$orderid = $this->_getParam('Id');
		$list = $this->_model->GetOrderProduct($orderid);
		if($list[0][F_ID_LOGIN_INFO] != $_SESSION['User']['F_ID'])		//判断用户是否是查看自己的订单
		{
			$msg = "对不起，您只能查看自己的订单信息！";
    		$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='javascript:window.close();'>关闭窗口</a>");
			$this->_view->display("sysmsg.php");
			exit;
		}
		$this->_view->assign('list',$list);
		$this->_view->display('OrderProduct.php');
	}

}
?>
