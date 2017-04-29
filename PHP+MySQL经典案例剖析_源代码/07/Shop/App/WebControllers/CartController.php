<?php
class CartController extends Core_Controller_Action
{
	protected $_model;
	protected $_product;
	/**
	 * 初始化构造函数
	 *
	 */
	public function __construct()
	{
		$this->_model = new CartModel();
		$this->_product = new ProductModel();
		parent::__construct();
	}
	/**
	 * 功能：显示购物车产品列表
	 *
	 */
    public function IndexAction()
    {
    		if(!isset($_SESSION['User']['SESSION_ID']))						//判断是否有SESSION_ID
    		{
    			$ip = $_SERVER["REMOTE_ADDR"];
				$ip1 = $_SERVER["HTTP_X_FORWARDED_FOR"];
				$ip2 = $_SERVER["HTTP_CLIENT_IP"];
				($ip1) ? $ip = $ip1 : null ;
				($ip2) ? $ip = $ip2 : null ;
				$_SESSION['User']['SESSION_ID'] = md5($ip);
				$sessionid = $_SESSION['User']['SESSION_ID'];
    		} else {
				$sessionid = $_SESSION['User']['SESSION_ID'];
			}
   			$sum = 0;
    		$list = $this->_model->GetProductList($sessionid);
    		if($list)													//判断购物车里是否有产品
    		{
    			foreach($list as $value)									//循环计算总价格
    			{
    				$info = $this->_product->getInfo($value[F_ID_PRODUCT_INFO]);
    				if($info[F_PRODUCT_LOW_PRICE])					//判断是否有折扣价
    				{
    					$sum = $sum + $info[F_PRODUCT_PRICE];
    				}else{
    					$sum = $sum + $info[F_PRODUCT_LOW_PRICE];
    				}
    			}
    		}
    		$this->_view->assign('sum',$sum);
    		$this->_view->assign('list',$list);
    		$this->_view->display('CartList.php');
    }
    /**
     * 功能：把产品加入购物车
     *
     */
    public function AddCartAction()
    {
    		$id = (int)($this->_getParam('Id'));
    		$info = $this->_product->getInfo($id);
    		if(!$info)												//判断该产品是否存在
    		{
				$msg = "无此产品";
				$this->_view->assign("img","/images/erro.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='javascript:window.close();'>关闭窗口</a>");
				$this->_view->display("sysmsg.php");
				exit;
    		}
    		if(!isset($_SESSION['User']['SESSION_ID']))					//判断SESSION_ID是否存在
    		{
    			$ip = $_SERVER["REMOTE_ADDR"];
				$ip1 = $_SERVER["HTTP_X_FORWARDED_FOR"];
				$ip2 = $_SERVER["HTTP_CLIENT_IP"];
				($ip1) ? $ip = $ip1 : null ;
				($ip2) ? $ip = $ip2 : null ;
				$_SESSION['User']['SESSION_ID'] = md5($ip);
				$sessionid = $_SESSION['User']['SESSION_ID'];
    		} else{
    			$sessionid = $_SESSION['User']['SESSION_ID'];
    		}
    		if (isset($_SESSION['User']['F_ID'])) {						//判断是否已登陆
    			$userid = $_SESSION['User']['F_ID'];
    		}else{
    			$userid = 0;
    		}
    		$this->_model->AddToCart($sessionid,$userid,$id);
    		$this->_redirect('/Cart');
    }
    /**
     * 功能：清空购物车
     *
     */
    public function TruncateAction()
    {
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
    		$this->_model->Truncate($sessionid);
    		$this->_redirect("/Cart");
    }
    /**
     * 功能：更新购物车产品数量
     *
     */
    public function UpdateCountAction()
    {
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
    		$this->_model->UpdateCount($sessionid,$_POST['id'],$_POST['count']);
    		$this->_redirect("/Cart");
    }
    /**
     * 功能：删除购物车中指定产品
     *
     */
    public function DelProductAction()
    {
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
    		$id = (int)($this->_getParam('Id'));
    		$this->_model->DelProduct($id,$sessionid);
    		$this->_redirect('/Cart');
    }

}
?>
