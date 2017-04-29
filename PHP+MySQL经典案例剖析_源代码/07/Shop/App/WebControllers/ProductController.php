<?php
class ProductController extends Core_Controller_Action
{
	protected $_model;
	protected $_class;
	protected $_login;
	/**
	 * 初始化构造函数
	 *
	 */
	public function __construct()
	{
		$this->_model = new ProductModel();
		$this->_class = new ClassModel();
		$this->_login = new LoginModel();
		parent::__construct();
	}
	/**
	 * 功能：显示新产品
	 *
	 */
    public function IndexAction()
    {
		$perline = $this->_class->GetDefaultConfig('product_index_perline');
		$pagesize = $this->_class->GetDefaultConfig('product_index_pagesize');
		$width = $this->_class->GetDefaultConfig('product_small_img_width');
		$height = $this->_class->GetDefaultConfig('product_small_img_height'); 
		$td_width = (int)(100/$perline) . "%"; 
		$_perline = $perline - 1;
		$list = $this->_model->GetNewProducts($pagesize);
		$path = UPLOAD_DIR;
		$data = array();
		if(count($list['data']) % $perline < $_perline)			//判断产品显示最后一行是否刚好是$perline
		{											//循环补足最后一行
			for($i = count($list['data']),$j = 0;$i % $perline < $_perline;$i++,$j++)
				$data[$j] = "<td width='$td_width'>&nbsp;</td>";
			$data[$j] = "</tr>";
		}
		$this->_view->assign('td_width',$td_width);
		$this->_view->assign('path',$path);
		$this->_view->assign('width',$width);
		$this->_view->assign('height',$height);
		$this->_view->assign('perline',$perline);
		$this->_view->assign('_perline',$_perline);
		$this->_view->assign('list',$list);
		$this->_view->assign('data',$data);
		$this->_view->display('NewProduct.php');
    }
    /**
     * 功能：分类产品列表
     *
     */
    public function ListAction()
    {
		$classid = (int)($this->_getParam('Id'));
		$info = $this->_class->getInfo($classid);
		if ($info['F_CLASS_SMALL_IMG_DEFAULT']){			//判断小图大小是否为系统默认
			$width = $this->_class->GetDefaultConfig("product_small_img_width");
			$height = $this->_class->GetDefaultConfig("product_small_img_height");
		}else{
			$width = $info['F_CLASS_SMALL_IMG_WIDTH'];
			$height = $info['F_CLASS_SMALL_IMG_HEIGHT'];
		}	
		if ($info['F_CLASS_PERLINE_DEFAULT'])			//判断每行显示是否为系统默认
			$perline = $this->_class->GetDefaultConfig("product_perline");
		else
			$perline = $info['F_CLASS_PERLINE'];
		if ($info['F_CLASS_PAGESIZE_DEFAULT'])			//判断每页显示是否为系统默认
			$pagesize = $this->_class->GetDefaultConfig("product_pagesize");
		else
			$pagesize = $info['F_CLASS_PAGESIZE'];
		$td_width = (int)(100/$perline) . "%"; 
		$_perline = $perline - 1;
		$list = $this->_model->GetProducts($classid,$pagesize);
		$path = UPLOAD_DIR;
		$data = array();
		if(count($list['data']) % $perline < $_perline) 			//判断产品显示最后一行是否刚好是$perline
		{											//循环补足最后一行
			for($i = count($list['data']),$j = 0;$i % $perline < $_perline;$i++,$j++)
				$data[$j] = "<td width='$td_width'>&nbsp;</td>";
			$data[$j] = "</tr>";
		}
		$this->_view->assign('td_width',$td_width);
		$this->_view->assign('path',$path);
		$this->_view->assign('width',$width);
		$this->_view->assign('height',$height);
		$this->_view->assign('perline',$perline);
		$this->_view->assign('_perline',$_perline);
		$this->_view->assign('info',$info);
		$this->_view->assign('list',$list);
		$this->_view->assign('data',$data);
		$this->_view->display('List.php');
    }
    /**
     * 功能：产品搜索
     *
     */
    public function SearchAction()
    {
		global $classlist;
		$classlist = array();
		$deep = 0;
		$this->_class->GetClassListAll();
		$options = array();
		foreach ($classlist as $value) {
			$options[$value[id]] = $value[prev] . $value[class_name];
		}
		$classid = (int)($this->_getParam('Id'));
		$keyword = $this->_getParam('Keyword');
		$width = $this->_class->GetDefaultConfig("product_small_img_width");
		$height = $this->_class->GetDefaultConfig("product_small_img_height");
		$perline = $this->_class->GetDefaultConfig("product_perline");
		$pagesize = $this->_class->GetDefaultConfig("product_pagesize");
		$td_width = (int)(100/$perline) . "%"; 
		$_perline = $perline - 1;
		$list = $this->_model->GetProducts($classid,$pagesize,$keyword);
		$path = UPLOAD_DIR;
		$data = array();
		if(count($list['data']) % $perline < $_perline) 			//判断产品显示最后一行是否刚好是$perline
		{											//循环补足最后一行
			for($i = count($list['data']),$j = 0;$i % $perline < $_perline;$i++,$j++)
				$data[$j] = "<td width='$td_width'>&nbsp;</td>";
			$data[$j] = "</tr>";
		}
		$this->_view->assign('option',$options);
		$this->_view->assign('path',$path);
		$this->_view->assign('width',$width);
		$this->_view->assign('height',$height);
		$this->_view->assign('perline',$perline);
		$this->_view->assign('_perline',$_perline);
		$this->_view->assign('info',$info);
		$this->_view->assign('list',$list);
		$this->_view->assign('data',$data);
		$this->_view->display('Search.php');
    }
    /**
     * 功能：搜索转向
     *
     */
    public function RedirectAction()
    {
		$classid = (int)($_POST['class_id']);
		$keyword = urlencode($_POST['keyword']);
		$this->_redirect("/Product/Search/Id/$classid/Keyword/$keyword");
    }
    /**
     * 功能：产品详细信息
     *
     */
    public function InfoAction()
    {
		if($_SESSION['User']['F_ID'])								//判断是否登陆
		{
			$isLogin = 1;
		}else{
			$isLogin = 0;
		}
		$id = (int)($this->_getParam('Id'));
		$info = $this->_model->getInfo($id);
		extract($info);
		$property = $this->_class->GetPropertyList($info[F_ID_CLASS_INFO]);
		$pro = array();
		if($property)											//判断是否有属性
		{
			foreach ($property as $key => $value)							//循环重组属性数组
			{
				extract($value);
				$pro[$key]['F_CAPTION'] = $F_PROPERTY_NAME;
				$pro[$key]['F_VALUE'] = $$F_PROPERTY_FIELDNAME;
			}
		}
		$path = UPLOAD_DIR;
		$this->_view->assign('isLogin',$isLogin);
		$this->_view->assign('path',$path);
		$this->_view->assign('info',$info);
		$this->_view->assign('id',$id);
		$this->_view->assign('property',$pro);
		$this->_view->display('ProductInfo.php');
    }
    /**
     * 功能：发送反馈信息
     *
     */
    public function SendMessageAction()
    {
		$backurl = $this->_getParam('Back');
		$verify = $this->_login->checkVerify();
		if($verify['VRFY_ERR'])									//判断验证是否正确
		{
			$msg = "验证码错误！";
			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='$backurl'>返回上一页</a>");
			$this->_view->display("sysmsg.php");
			exit;
		}
		if($_SESSION['User']['F_ID'])								//判断是否登陆
		{
			$content = htmlspecialchars(addslashes($_POST[content]));
			$this->_model->AddMessage($_POST['id'],$_SESSION['User']['F_ID'],$_POST[content]);
			$msg = "操作成功！";
			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='$backurl'>返回上一页</a>");
			$this->_view->display("sysmsg.php");
			exit;   		
		}else{
			if($this->_login->doLogin())							//判断用户名和密码是否正确
			{
				$content = htmlspecialchars(addslashes($_POST[content]));
				$this->_model->AddMessage($_POST['id'],$_SESSION['User']['F_ID'],$_POST[content]);
				$msg = "操作成功！";
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='$backurl'>返回上一页</a>");
				$this->_view->display("sysmsg.php");
				exit;
			}else{
				$msg = "用户名或密码错误！";
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='$backurl'>返回上一页</a>");
				$this->_view->display("sysmsg.php");
				exit;
			}
		}
    }

}
?>
