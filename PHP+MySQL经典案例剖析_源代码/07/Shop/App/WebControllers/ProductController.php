<?php
class ProductController extends Core_Controller_Action
{
	protected $_model;
	protected $_class;
	protected $_login;
	/**
	 * ��ʼ�����캯��
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
	 * ���ܣ���ʾ�²�Ʒ
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
		if(count($list['data']) % $perline < $_perline)			//�жϲ�Ʒ��ʾ���һ���Ƿ�պ���$perline
		{											//ѭ���������һ��
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
     * ���ܣ������Ʒ�б�
     *
     */
    public function ListAction()
    {
		$classid = (int)($this->_getParam('Id'));
		$info = $this->_class->getInfo($classid);
		if ($info['F_CLASS_SMALL_IMG_DEFAULT']){			//�ж�Сͼ��С�Ƿ�ΪϵͳĬ��
			$width = $this->_class->GetDefaultConfig("product_small_img_width");
			$height = $this->_class->GetDefaultConfig("product_small_img_height");
		}else{
			$width = $info['F_CLASS_SMALL_IMG_WIDTH'];
			$height = $info['F_CLASS_SMALL_IMG_HEIGHT'];
		}	
		if ($info['F_CLASS_PERLINE_DEFAULT'])			//�ж�ÿ����ʾ�Ƿ�ΪϵͳĬ��
			$perline = $this->_class->GetDefaultConfig("product_perline");
		else
			$perline = $info['F_CLASS_PERLINE'];
		if ($info['F_CLASS_PAGESIZE_DEFAULT'])			//�ж�ÿҳ��ʾ�Ƿ�ΪϵͳĬ��
			$pagesize = $this->_class->GetDefaultConfig("product_pagesize");
		else
			$pagesize = $info['F_CLASS_PAGESIZE'];
		$td_width = (int)(100/$perline) . "%"; 
		$_perline = $perline - 1;
		$list = $this->_model->GetProducts($classid,$pagesize);
		$path = UPLOAD_DIR;
		$data = array();
		if(count($list['data']) % $perline < $_perline) 			//�жϲ�Ʒ��ʾ���һ���Ƿ�պ���$perline
		{											//ѭ���������һ��
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
     * ���ܣ���Ʒ����
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
		if(count($list['data']) % $perline < $_perline) 			//�жϲ�Ʒ��ʾ���һ���Ƿ�պ���$perline
		{											//ѭ���������һ��
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
     * ���ܣ�����ת��
     *
     */
    public function RedirectAction()
    {
		$classid = (int)($_POST['class_id']);
		$keyword = urlencode($_POST['keyword']);
		$this->_redirect("/Product/Search/Id/$classid/Keyword/$keyword");
    }
    /**
     * ���ܣ���Ʒ��ϸ��Ϣ
     *
     */
    public function InfoAction()
    {
		if($_SESSION['User']['F_ID'])								//�ж��Ƿ��½
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
		if($property)											//�ж��Ƿ�������
		{
			foreach ($property as $key => $value)							//ѭ��������������
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
     * ���ܣ����ͷ�����Ϣ
     *
     */
    public function SendMessageAction()
    {
		$backurl = $this->_getParam('Back');
		$verify = $this->_login->checkVerify();
		if($verify['VRFY_ERR'])									//�ж���֤�Ƿ���ȷ
		{
			$msg = "��֤�����";
			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='$backurl'>������һҳ</a>");
			$this->_view->display("sysmsg.php");
			exit;
		}
		if($_SESSION['User']['F_ID'])								//�ж��Ƿ��½
		{
			$content = htmlspecialchars(addslashes($_POST[content]));
			$this->_model->AddMessage($_POST['id'],$_SESSION['User']['F_ID'],$_POST[content]);
			$msg = "�����ɹ���";
			$this->_view->assign("img","/images/info.gif");
			$this->_view->assign("msg",$msg);
			$this->_view->assign("url","<a href='$backurl'>������һҳ</a>");
			$this->_view->display("sysmsg.php");
			exit;   		
		}else{
			if($this->_login->doLogin())							//�ж��û����������Ƿ���ȷ
			{
				$content = htmlspecialchars(addslashes($_POST[content]));
				$this->_model->AddMessage($_POST['id'],$_SESSION['User']['F_ID'],$_POST[content]);
				$msg = "�����ɹ���";
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='$backurl'>������һҳ</a>");
				$this->_view->display("sysmsg.php");
				exit;
			}else{
				$msg = "�û������������";
				$this->_view->assign("img","/images/info.gif");
				$this->_view->assign("msg",$msg);
				$this->_view->assign("url","<a href='$backurl'>������һҳ</a>");
				$this->_view->display("sysmsg.php");
				exit;
			}
		}
    }

}
?>
