<?php
class ProductController extends Core_Controller_Action
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
		$this->_model = new ProductModel();
		$this->_class = new ClassModel();
		$this->_addTmpl = 'ProductAdd.php';
		$this->_editTmpl = 'ProductAdd.php';
		parent::__construct();
	}
	/**
	 * ���ܣ���ʾ��Ʒ�б�
	 *
	 */
	public function IndexAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//�ж��Ƿ�Ϊ�ύɾ��
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
	 * ���ܣ���ʾ��ӽ���
	 *
	 */
	public function AddAction()
	{
		$classid = $this->_getParam('ClassId');
		$class = $this->_class->getInfo($classid);
		$property = array();
		if ($class['F_CLASS_IS_DEFAULT_PROPERTY'])					//�ж��Ƿ���ʾĬ������
		{
			$property = $this->_class->GetPropertyList(0);
		}else{
			if ($class['F_CLASS_IS_PARENT_PROPERTY'])				//�ж��Ƿ�̳и�����
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
	 * ���ܣ���ʾ�༭����
	 *
	 */	
	public function EditAction()
	{
		$classid = $this->_getParam('ClassId');
		$id = $this->_getParam('Id');
		$class = $this->_class->getInfo($classid);
		$info = $this->_model->getInfo($id);
		$property = array();
		if ($class['F_CLASS_IS_DEFAULT_PROPERTY'])					//�ж��Ƿ���ʾĬ������
		{
			$property = $this->_class->GetPropertyList(0);
		}else{
			if ($class['F_CLASS_IS_PARENT_PROPERTY'])				//�ж��Ƿ�̳и�����
			{
				$property = $this->_class->GetPropertyList($class['F_PARENT_ID']);
			}else{
				$property = $this->_class->GetPropertyList($class['F_ID']);
			}
		}
		$property_value = array();
		foreach($property as $key => $value)							//ѭ���������ֵ����
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
	 * ���ܣ������������
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
		if($_POST['p_id'])											//�ж��Ƿ�������
		{
			foreach($_POST['p_id'] as $key => $field)						//ѭ��������ֵ
			{
				$data[$field] = $_POST['value'][$key];
			}
		}
		if($this->_model->insert($data))								//�ж��Ƿ���ӳɹ�
		{
			$this->_redirect('/Product/Index/ClassId/' . $_POST['classid']);
		}
	}
	/**
	 * ���ܣ���ʾ�༭���
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
		if($_POST['p_id'])											//�ж��Ƿ�������
		{
			foreach($_POST['p_id'] as $key => $field)						//ѭ��������ֵ
			{
				$data[$field] = $_POST['value'][$key];
			}
		}
		if($this->_model->update($data,"F_ID = " . $_POST['id']))				//�ж��Ƿ�����ɹ�
		{
			$this->_redirect('/Product/Index/ClassId/' . $_POST['classid']);
		} else {
			$this->_redirect('/Product/Index/ClassId/' . $_POST['classid']);			
		}
	}
	/**
	 * ���ܣ����ò�Ʒ˳��
	 *
	 */
	public function OrderAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//�ж��Ƿ��ύ����
		{
			foreach ($_POST['SelId'] as $key => $value)					//ѭ�����ò�Ʒ˳��
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
	 * ���ܣ���ƷͼƬ����
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
					$msg[] = "Сͼ�ϴ��ļ���ʽ���ԣ��ϴ��ļ�Ӧ����ͼƬ";
					$flag = false;
				}
				if($result['errcode'] === 'type_erro') {
					$msg[] = "Сͼ���󣬲��ܳ���" . UPLOAD_MAX_SIZE . "K";
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
					$msg[] = "��ͼ�ϴ��ļ���ʽ���ԣ��ϴ��ļ�Ӧ����ͼƬ";
					$flag = false;
				}
				if($result['errcode'] === 'type_erro') {
					$msg[] = "��ͼƬ���󣬲��ܳ���" . UPLOAD_MAX_SIZE . "K";
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
	 * ���ܣ���ʾ�²�Ʒ�б�
	 *
	 */
	public function NewListAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//�ж��Ƿ�Ϊ�ύ����
		{
			$this->_model->DelNew($_POST['SelId']);					//ɾ����ѡ�²�Ʒ
		}
		$list = $this->_model->GetNewList();
		$this->_view->assign('list',$list);
		$this->_view->display('NewList.php');
	}
	/**
	 * ���ܣ�����²�Ʒ
	 *
	 */
	public function AddNewAction()
	{
		global $classlist;
		if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ�Ϊ�ύ����
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
	 * ���ܣ������²�Ʒ˳��
	 *
	 */
	public function NewOrderAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//�ж��Ƿ��ύ����
		{
			$this->_model->SetNewOrder($_POST['id'],$_POST['order']);
		}
		$list = $this->_model->GetNewList();
		$this->_view->assign('list',$list);
		$this->_view->display('NewOrder.php');
	}
	/**
	 * ���ܣ���ʾ�²�Ʒ�б�
	 *
	 */
	public function RecommendListAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//�ж��Ƿ�Ϊ�ύ����
		{
			$this->_model->DelRecommend($_POST['SelId']);				//ɾ����ѡ�Ƽ���Ʒ
		}
		$list = $this->_model->GetRecommendList();
		$this->_view->assign('list',$list);
		$this->_view->display('RecommendList.php');
	}
	/**
	 * ���ܣ�����²�Ʒ
	 *
	 */
	public function AddRecommendAction()
	{
		global $classlist;
		if($_SERVER['REQUEST_METHOD'] == 'POST')						//�ж��Ƿ�Ϊ�ύ����
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
	 * ���ܣ������Ƽ���Ʒ˳��
	 *
	 */
	public function RecommendOrderAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')					//�ж��Ƿ��ύ����
		{
			$this->_model->SetRecommendOrder($_POST['id'],$_POST['order']);
		}
		$list = $this->_model->GetRecommendList();
		$this->_view->assign('list',$list);
		$this->_view->display('RecommendOrder.php');
	}
}
?>
