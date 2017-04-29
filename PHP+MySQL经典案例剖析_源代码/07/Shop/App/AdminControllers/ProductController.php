<?php
class ProductController extends Core_Controller_Action
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
		$this->_model = new ProductModel();
		$this->_class = new ClassModel();
		$this->_addTmpl = 'ProductAdd.php';
		$this->_editTmpl = 'ProductAdd.php';
		parent::__construct();
	}
	/**
	 * 功能：显示产品列表
	 *
	 */
	public function IndexAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否为提交删除
		{
			$this->_model->DelProduct($_POST['SelId']);
		}
		$classid = $this->_getParam('ClassId');
		$class = $this->_class->getInfo($classid);
		$list = $this->_model->GetProductList($classid);
		$path = WEB_DOMAIN . UPLOAD_DIR;
		$this->_view->assign('path',$path);
		$this->_view->assign('list',$list);
		$this->_view->assign('class',$class);
		$this->_view->display('ProductList.php');
	}
	/**
	 * 功能：显示添加界面
	 *
	 */
	public function AddAction()
	{
		$classid = $this->_getParam('ClassId');
		$class = $this->_class->getInfo($classid);
		$property = array();
		if ($class['F_CLASS_IS_DEFAULT_PROPERTY'])					//判断是否显示默认属性
		{
			$property = $this->_class->GetPropertyList(0);
		}else{
			if ($class['F_CLASS_IS_PARENT_PROPERTY'])				//判断是否继承父属性
			{
				$property = $this->_class->GetPropertyList($class['F_PARENT_ID']);
			}else{
				$property = $this->_class->GetPropertyList($class['F_ID']);
			}
		}
		$this->_view->assign('class',$class);
		$this->_view->assign('property',$property);
		parent::AddAction();
	}
	/**
	 * 功能：显示编辑界面
	 *
	 */	
	public function EditAction()
	{
		$classid = $this->_getParam('ClassId');
		$id = $this->_getParam('Id');
		$class = $this->_class->getInfo($classid);
		$info = $this->_model->getInfo($id);
		$property = array();
		if ($class['F_CLASS_IS_DEFAULT_PROPERTY'])					//判断是否显示默认属性
		{
			$property = $this->_class->GetPropertyList(0);
		}else{
			if ($class['F_CLASS_IS_PARENT_PROPERTY'])				//判断是否继承父属性
			{
				$property = $this->_class->GetPropertyList($class['F_PARENT_ID']);
			}else{
				$property = $this->_class->GetPropertyList($class['F_ID']);
			}
		}
		$property_value = array();
		foreach($property as $key => $value)							//循环组合属性值数组
		{
			$property_value[$key] = $info[$value[F_PROPERTY_FIELDNAME]];
		}
		$this->_view->assign('class',$class);
		$this->_view->assign('property',$property);
		$this->_view->assign('property_value',$property_value);
		$this->_view->assign('info',$info);
		parent::EditAction();
	}
	/**
	 * 功能：处理添加数据
	 *
	 */
	public function InsertAction()
	{
		$data = array();
		$data[F_ID_CLASS_INFO] = $_POST['classid'];
		$data[F_PRODUCT_NAME] = $_POST['name'];
		$data[F_PRODUCT_PRICE] = number_format($_POST['price'],2);
		$data[F_PRODUCT_LOW_PRICE] = number_format($_POST['low_price'],2);
		$data[F_PRODUCT_DESCRIPTION] = htmlspecialchars(addslashes($_POST['content']));
		if($_POST['p_id'])											//判断是否有属性
		{
			foreach($_POST['p_id'] as $key => $field)						//循环付属性值
			{
				$data[$field] = $_POST['value'][$key];
			}
		}
		if($this->_model->insert($data))								//判断是否添加成功
		{
			$this->_redirect('/Product/Index/ClassId/' . $_POST['classid']);
		}
	}
	/**
	 * 功能：显示编辑输出
	 *
	 */	
	public function UpdateAction()
	{
		$data = array();
		$data[F_ID_CLASS_INFO] = $_POST['classid'];
		$data[F_PRODUCT_NAME] = $_POST['name'];
		$data[F_PRODUCT_PRICE] = number_format($_POST['price'],2);
		$data[F_PRODUCT_LOW_PRICE] = number_format($_POST['low_price'],2);
		$data[F_PRODUCT_DESCRIPTION] = htmlspecialchars(addslashes($_POST['content']));
		if($_POST['p_id'])											//判断是否有属性
		{
			foreach($_POST['p_id'] as $key => $field)						//循环付属性值
			{
				$data[$field] = $_POST['value'][$key];
			}
		}
		if($this->_model->update($data,"F_ID = " . $_POST['id']))				//判断是否操作成功
		{
			$this->_redirect('/Product/Index/ClassId/' . $_POST['classid']);
		} else {
			$this->_redirect('/Product/Index/ClassId/' . $_POST['classid']);			
		}
	}
	/**
	 * 功能：设置产品顺序
	 *
	 */
	public function OrderAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否提交操作
		{
			foreach ($_POST['SelId'] as $key => $value)					//循环设置产品顺序
			{
				$data = array();
				$data[F_PRODUCT_ORDER] = $_POST['order'][$key];
				$this->_model->update($data,'F_ID = ' . $value);
			}
		}
		$classid = $this->_getParam('ClassId');
		$list = $this->_model->GetProductList($classid);
		$info = $this->_class->getInfo($classid);
		$this->_view->assign('info',$info);
		$this->_view->assign('classid',$classid);
		$this->_view->assign('list',$list);
		$this->_view->display('ProductOrder.php');
	}
	/**
	 * 功能：产品图片管理
	 *
	 */
	public function PicAction() {
		$pid = $this->_getParam('Id');
		$classid = $this->_getParam('ClassId');
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$msg = array();
			$flag = true;
			if($_FILES['small']['size'] > 0) {
				$result = array();
				$result = Core_Upload::upload($_FILES['small'],UPLOAD_PATH,UPLOAD_MAX_SIZE);
				if($result['errcode'] === 'type_erro') {
					$msg[] = "小图上传文件格式不对，上传文件应该是图片";
					$flag = false;
				}
				if($result['errcode'] === 'type_erro') {
					$msg[] = "小图过大，不能超过" . UPLOAD_MAX_SIZE . "K";
					$flag = false;
				}
				if($flag) {
					$data = array();
					$data[F_PRODUCT_SMALL_IMG] = $result[file_name];
					$this->_model->update($data,"F_ID = " . $_POST[pid]);
				}
			}
			if($_FILES['big']['size'] > 0) {
				$flag = true;
				$result = array();
				$result = Core_Upload::upload($_FILES['big'],UPLOAD_PATH,UPLOAD_MAX_SIZE);
				if($result['errcode'] === 'type_erro') {
					$msg[] = "大图上传文件格式不对，上传文件应该是图片";
					$flag = false;
				}
				if($result['errcode'] === 'type_erro') {
					$msg[] = "大图片过大，不能超过" . UPLOAD_MAX_SIZE . "K";
					$flag = false;
				}
				if($flag) {
					$data = array();
					$data[F_PRODUCT_BIG_IMG] = $result[file_name];
					$this->_model->update($data,"F_ID = " . $_POST[pid]);
				}							
			}
			if($flag) {
				$this->_redirect('/Product/Index/ClassId/' . $classid);
			}
		}		
		$info = $this->_model->getInfo($pid);
		$upload_path = WEB_DOMAIN . UPLOAD_DIR;
		$this->_view->assign('info',$info);
		$this->_view->assign('upload_path',$upload_path);
		$this->_view->assign('msg',$msg);
		$this->_view->display('ProductImg.php');
	}
	/**
	 * 功能：显示新产品列表
	 *
	 */
	public function NewListAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否为提交操作
		{
			$this->_model->DelNew($_POST['SelId']);					//删除所选新产品
		}
		$list = $this->_model->GetNewList();
		$this->_view->assign('list',$list);
		$this->_view->display('NewList.php');
	}
	/**
	 * 功能：添加新产品
	 *
	 */
	public function AddNewAction()
	{
		global $classlist;
		if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否为提交操作
		{
			$this->_model->AddNew($_POST['product_id']);
			$this->_redirect('/Product/NewList');
		}
		$classlist = array();
		$this->_class->GetClassListAll();
		$this->_view->assign('list',$classlist);
		$this->_view->display('AddNew.php');
	}
	/**
	 * 功能：设置新产品顺序
	 *
	 */
	public function NewOrderAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否提交设置
		{
			$this->_model->SetNewOrder($_POST['id'],$_POST['order']);
		}
		$list = $this->_model->GetNewList();
		$this->_view->assign('list',$list);
		$this->_view->display('NewOrder.php');
	}
	/**
	 * 功能：显示新产品列表
	 *
	 */
	public function RecommendListAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否为提交操作
		{
			$this->_model->DelRecommend($_POST['SelId']);				//删除所选推荐产品
		}
		$list = $this->_model->GetRecommendList();
		$this->_view->assign('list',$list);
		$this->_view->display('RecommendList.php');
	}
	/**
	 * 功能：添加新产品
	 *
	 */
	public function AddRecommendAction()
	{
		global $classlist;
		if($_SERVER['REQUEST_METHOD'] == 'POST')						//判断是否为提交操作
		{
			$this->_model->AddRecommend($_POST['product_id']);
			$this->_redirect('/Product/RecommendList');
		}
		$classlist = array();
		$this->_class->GetClassListAll();
		$this->_view->assign('list',$classlist);
		$this->_view->display('AddRecommend.php');
	}
	/**
	 * 功能：设置推荐产品顺序
	 *
	 */
	public function RecommendOrderAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否提交设置
		{
			$this->_model->SetRecommendOrder($_POST['id'],$_POST['order']);
		}
		$list = $this->_model->GetRecommendList();
		$this->_view->assign('list',$list);
		$this->_view->display('RecommendOrder.php');
	}
}
?>
