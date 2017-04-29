<?php
class CartController extends Core_Controller_Action
{
	protected $_model;
	protected $_product;
	/**
	 * ��ʼ�����캯��
	 *
	 */
	public function __construct()
	{
		$this->_model = new CartModel();
		$this->_product = new ProductModel();
		parent::__construct();
	}
	/**
	 * ���ܣ���ʾ���ﳵ��Ʒ�б�
	 *
	 */
    public function IndexAction()
    {
    		if(!isset($_SESSION['User']['SESSION_ID']))						//�ж��Ƿ���SESSION_ID
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
    		if($list)													//�жϹ��ﳵ���Ƿ��в�Ʒ
    		{
    			foreach($list as $value)									//ѭ�������ܼ۸�
    			{
    				$info = $this->_product->getInfo($value[F_ID_PRODUCT_INFO]);
    				if($info[F_PRODUCT_LOW_PRICE])					//�ж��Ƿ����ۿۼ�
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
     * ���ܣ��Ѳ�Ʒ���빺�ﳵ
     *
     */
    public function AddCartAction()
    {
    		$id = (int)($this->_getParam('Id'));
    		$info = $this->_product->getInfo($id);
    		if(!$info)												//�жϸò�Ʒ�Ƿ����
    		{
				$msg = "�޴˲�Ʒ";
				$this->_view->assign("img","/images/erro.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='javascript:window.close();'>�رմ���</a>");
				$this->_view->display("sysmsg.php");
				exit;
    		}
    		if(!isset($_SESSION['User']['SESSION_ID']))					//�ж�SESSION_ID�Ƿ����
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
    		if (isset($_SESSION['User']['F_ID'])) {						//�ж��Ƿ��ѵ�½
    			$userid = $_SESSION['User']['F_ID'];
    		}else{
    			$userid = 0;
    		}
    		$this->_model->AddToCart($sessionid,$userid,$id);
    		$this->_redirect('/Cart');
    }
    /**
     * ���ܣ���չ��ﳵ
     *
     */
    public function TruncateAction()
    {
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
    		$this->_model->Truncate($sessionid);
    		$this->_redirect("/Cart");
    }
    /**
     * ���ܣ����¹��ﳵ��Ʒ����
     *
     */
    public function UpdateCountAction()
    {
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
    		$this->_model->UpdateCount($sessionid,$_POST['id'],$_POST['count']);
    		$this->_redirect("/Cart");
    }
    /**
     * ���ܣ�ɾ�����ﳵ��ָ����Ʒ
     *
     */
    public function DelProductAction()
    {
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
    		$id = (int)($this->_getParam('Id'));
    		$this->_model->DelProduct($id,$sessionid);
    		$this->_redirect('/Cart');
    }

}
?>
