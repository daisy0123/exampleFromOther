<?php
class ClassController extends Core_Controller_Action 
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
		$this->_model = new ClassModel();							//����ClassModel����
		$this->_addTmpl = "ClassAdd.php";							//������ӹ���ģ��
		$this->_editTmpl = "ClassAdd.php";							//����༭����ģ��
		parent::__construct();
	}
	/**
	 * ���ܣ���ҳ
	 */
	public function IndexAction()
	{
		$this->_view->assign("type",$this->_getParam('Type'));
		$this->_view->display("ClassIndex.php");
	}
	/**
	 * ���ܣ���ʾ�����
	 */
	public function LeftAction()
	{
		global $classlist;
		$type = $this->_getParam('Type');							//��ȡ����
		switch ($type)
		{
			case 1:											//Ϊ1ʱ���ӵ������Ϣҳ��
				$url = "/Class/Info/Id/";
				break;
			case 2:											//Ϊ2ʱ���ӵ���Ʒ�б�ҳ��
				$url = "/Product/Index/ClassId/";
				break;
			default:
				break;
		}
		$classlist = array();
		$deep = 0;
		$this->_model->GetClassListAll();							//ȡ���������
		$this->_view->assign('type',$type);
		$this->_view->assign('url',$url);
		$this->_view->assign('list',$classlist);
		$this->_view->display('ClassLeftMenu.php');
	}
	public function RightAction()
	{
		$this->_view->display('Right.php');		
	}
	/**
	 * ���ܣ���ʾ�����Ϣ
	 * ���ݲ�����Id ���ID
	 */
	public function InfoAction()
	{
		$classid = $this->_getParam('Id');
		$info = $this->_model->getInfo($classid);
		$property = array();
		if ($info['F_CLASS_IS_DEFAULT_PROPERTY'])				//�ж��Ƿ���ʾĬ������
		{
			$property_note = 'ע�������ʹ��Ĭ�ϲ�Ʒ���ԡ�';
			$property = $this->_model->GetPropertyList(0);
		}else{
			if ($info['F_CLASS_IS_PARENT_PROPERTY'])			//�ж��Ƿ�̳и�����
			{
				$property_note = 'ע��������Ʒ�����ǴӸ����̳е�����';
				$property = $this->_model->GetPropertyList($info['F_PARENT_ID']);
			}else{
				$property = $this->_model->GetPropertyList($info['F_ID']);
			}
		}
		$img = $info['F_CLASS_IMG'] ? "<img src='" . WEB_DOMAIN . UPLOAD_DIR . $info['F_CLASS_IMG'] . "' width=100 height=75>" : "��";
		if ($info['F_CLASS_IMG_DEFAULT']){						//�жϷ���ͼƬ�Ƿ���ʾĬ��ֵ
			$img_width = $this->_model->GetDefaultConfig("class_img_width");
			$img_height = $this->_model->GetDefaultConfig("class_img_height");
			$img_display = "$img_width * $img_height";
		}else{
			$img_display = "<font color='red'>{$info['F_CLASS_IMG_WIDTH']} * {$info['F_CLASS_IMG_HEIGHT']}</font>";
		}
		
		if ($info['F_CLASS_SMALL_IMG_DEFAULT']){					//�жϲ�ƷСͼƬ�Ƿ���ʾĬ��ֵ
			$product_small_img_width = $this->_model->GetDefaultConfig("product_small_img_width");
			$product_small_img_height = $this->_model->GetDefaultConfig("product_small_img_height");
			$small_img_display = "$product_small_img_width * $product_small_img_height";
		}else{
			$small_img_display = "<font color='red'>{$info['F_CLASS_SMALL_IMG_WIDTH']} * {$info['F_CLASS_SMALL_IMG_HEIGHT']}</font>";
		}
		
		if ($info['F_CLASS_BIG_IMG_DEFAULT']){					//�жϲ�Ʒ��ͼƬ�Ƿ���ʾĬ��ֵ
			$product_big_img_width = $this->_model->GetDefaultConfig("product_big_img_width");
			$product_big_img_height = $this->_model->GetDefaultConfig("product_big_img_height");
			$big_img_display = "$product_big_img_width * $product_big_img_height";
		}else{
			$big_img_display = "<font color='red'>{$info['F_CLASS_BIG_IMG_WIDTH']} * {$info['F_CLASS_BIG_IMG_HEIGHT']}</font>";
		}
		
		if ($info['F_CLASS_PERLINE_DEFAULT'])					//�ж�ÿ����ʾ��Ʒ���Ƿ�Ĭ��
			$perline = $this->_model->GetDefaultConfig("product_perline");
		else
			$perline = "<font color='red'>{$info['F_CLASS_PERLINE']}</font>";

		if ($info['F_CLASS_PAGESIZE_DEFAULT'])					//�ж�ÿҳ��ʾ��Ʒ���Ƿ�Ĭ��
			$pagesize = $this->_model->GetDefaultConfig("product_pagesize");
		else
			$pagesize = "<font color='red'>{$info['F_CLASS_PAGESIZE']}</font>";
		$product_count = $this->_model->GetProductCount($classid);		//ȡ�ò�Ʒ����
		$sub_class = $this->_model->GetClassList($classid);			//ȡ��������б�
		$sub_count = count($sub_class);
		$this->_view->assign('info',$info);
		$this->_view->assign('property',$property);
		$this->_view->assign('property_note',$property_note);
		$this->_view->assign('img',$img);
		$this->_view->assign('img_display',$img_display);
		$this->_view->assign('small_img_display',$small_img_display);
		$this->_view->assign('big_img_display',$big_img_display);
		$this->_view->assign('perline',$perline);
		$this->_view->assign('pagesize',$pagesize);
		$this->_view->assign('product_count',$product_count);
		$this->_view->assign('sub_class',$sub_class);
		$this->_view->assign('sub_count',$sub_count);
		$this->_view->display('ClassInfo.php');
	}
	/**
	 * ���ܣ������������ʾ
	 *
	 */
	public function AddAction()
	{
		global $classlist;
		$parent = $this->_getParam('ParentId');
		if($parent)												//�ж��Ƿ�����Ӷ������
		{
			$classlist = array();
			$data = array();
			$deep = 0;		
			$this->_model->GetClassListAll();
			foreach($classlist as $value)							//ѭ����������
			{
				$data[$value['id']] = $value['class_name'];
			}
			$this->_view->assign('option',$data);
		}
		$this->_view->assign('class_id',$parent);
		parent::AddAction();
	}
	/**
	 * ���ܣ����༭������ʾ
	 *
	 */
	public function EditAction()
	{
		global $classlist;
		$classlist = array();
		$data = array();
		$deep = 0;		
		$this->_model->GetClassListAll();
		foreach($classlist as $value)								//ѭ����������
		{
			$data[$value['id']] = $value['class_name'];
		}
		$this->_view->assign('option',$data);
		parent::EditAction();
	}
	/**
	 * ���ܣ�������ӹ����ύ������
	 *
	 */
	public function InsertAction()
	{
		$data = array();
		if($this->_model->CheckClassNameExit($_POST['name'],$_POST['class_id']))
		{
			echo "��������ظ�";
			echo "<a href='javascript:window.history.back();'>����</a>";
			exit();
		}
		if($_FILES['size'] > 0)
		{
			$result = Core_Upload::upload($_FILES,UPLOAD_PATH,UPLOAD_MAX_SIZE);
			if($result['errocode'] == 'size_erro')						//�ж�ͼƬ�Ƿ����
			{
				echo "ͼƬ���󣬲��ܳ���" . UPLOAD_MAX_SIZE . "K";
				exit();
			}
			if($result['errocode'] == 'type_erro')						//�ж��ļ������ǲ���ͼƬ
			{
				echo "�ϴ��ļ�����ͼƬ";
				exit();
			}
			$data[F_CLASS_IMG] = $result['file_name'];				//ȡ���ϴ���ַ
		}
		$data[F_CLASS_NAME] = $_POST['name'];
		$data[F_CLASS_NOTE] = $_POST['note'];
		$data[F_PARENT_ID] = $_POST['class_id'];
		$data[F_CLASS_IS_DEFAULT_PROPERTY] = $_POST['use_default'];
		$data[F_CLASS_IS_PARENT_PROPERTY] = $_POST['use_parent_property'];
		if($id = $this->_model->insert($data))						//�ж��Ƿ���ɹ�
		{
			$this->_redirect('/Class/Info/Id/' . $id);
		}
	}
	/**
	 * ���ܣ�����༭�ύ������
	 *
	 */
	public function UpdateAction()
	{
		$data = array();
		if($this->_model->CheckClassNameExit($_POST['name'],$_POST['class_id'],$_POST['id']))
		{													//�ж���������Ƿ��ظ�
			echo "��������ظ�";
			echo "<a href='javascript:window.history.back();'>����</a>";
			exit();
		}
		if($_FILES['size'] > 0)
		{
			$result = Core_Upload::upload($_FILES,UPLOAD_PATH,UPLOAD_MAX_SIZE);
			if($result['errocode'] == 'size_erro')						//�ж�ͼƬ�Ƿ����
			{
				echo "ͼƬ���󣬲��ܳ���" . UPLOAD_MAX_SIZE . "K";
				exit();
			}
			if($result['errocode'] == 'type_erro')						//�ж��ļ������ǲ���ͼƬ
			{
				echo "�ϴ��ļ�����ͼƬ";
				exit();
			}
			$data[F_CLASS_IMG] = $result['file_name'];				//ȡ���ϴ���ַ
		}
		$data[F_CLASS_NAME] = $_POST['name'];
		$data[F_CLASS_NOTE] = $_POST['note'];
		$data[F_PARENT_ID] = $_POST['class_id'];
		$data[F_CLASS_IS_DEFAULT_PROPERTY] = $_POST['use_default'];
		$data[F_CLASS_IS_PARENT_PROPERTY] = $_POST['use_parent_property'];
		if($this->_model->update($data,"F_ID = " . $_POST['id']))			//�ж��Ƿ���ɹ�
		{
			$this->_redirect('/Class/Info/Id/' . $_POST['id']);
		}
	}
	/**
	 * ���ܣ��������˳��
	 *
	 */
	public function OrderAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')				//�ж��Ƿ��ύ����
		{
			$this->_model->SetClassOrder($_POST['SelId'],$_POST['Order']);	
		}
		$id = $this->_getParam('Id');
		$list = $this->_model->GetClassList($id);
		$path = WEB_DOMAIN . UPLOAD_DIR;
		$this->_view->assign(��path��,$path);
		$this->_view->assign('list',$list);
		$this->_view->display('ClassOrder.php');
	}
	/**
	 * ���ܣ�ɾ����������Ϣ
	 *
	 */
	public function DeleteAction()
	{
		$this->_model->Delete($this->_getParam('Id'));
		echo "ɾ���ɹ�";
	}
	/**
	 * ���ܣ�������ʾ����
	 *
	 */
	public function ConfigAction()
	{
		$classid = $this->_getParam('Id');
		if($_SERVER['REQUEST_METHOD'] == 'POST')				//�ж��Ƿ��ύ����
		{
			$data = array();
			$data['F_CLASS_IMG_WIDTH'] = $_POST['img_width'];
			$data['F_CLASS_IMG_HEIGHT'] = $_POST['img_height'];
			$data['F_CLASS_IMG_DEFAULT'] = $_POST['img_default'];
			$data['F_CLASS_SMALL_IMG_WIDTH'] = $_POST['small_width'];
			$data['F_CLASS_SMALL_IMG_HEIGHT'] = $_POST['small_height'];
			$data['F_CLASS_SMALL_IMG_DEFAULT'] = $_POST['small_default'];
			$data['F_CLASS_BIG_IMG_WIDTH'] = $_POST['big_width'];
			$data['F_CLASS_BIG_IMG_HEIGHT'] = $_POST['big_height'];
			$data['F_CLASS_BIG_IMG_DEFAULT'] = $_POST['big_default'];
			$data['F_CLASS_PERLINE'] = $_POST['perline'];
			$data['F_CLASS_PERLINE_DEFAULT'] = $_POST['perline_default'];
			$data['F_CLASS_PAGESIZE'] = $_POST['pagesize'];
			$data['F_CLASS_PAGESIZE_DEFAULT'] = $_POST['pagesize_default'];
			$this->_model->update($data,'F_ID = ' . $classid);
		}
		$class = $this->_model->getInfo($classid);
		$this->_view->assign('info',$class);
		$this->_view->display('ClassConfig.php');
	}
	/**
	 * ���ܣ���ʾ��Ʒ�����б�
	 *
	 */
	public function PropertyAction()
	{
		$classid = $this->_getParam('Id');
		if(!$classid) {
			$classid = 0;
		}
		$property = $this->_model->GetPropertyList($classid);
		$info = $this->_model->getInfo($classid);
		$this->_view->assign('info',$info);
		$this->_view->assign('classid',$classid);
		$this->_view->assign('list',$property);
		$this->_view->display('PropertyList.php');
	}
	/**
	 * ���ܣ���ӱ༭��Ʒ����
	 *
	 */
	public function PropertyAddAction()
	{
		$classid = $this->_getParam('ClassId');
		$id = $this->_getParam('Id');
		if($this->_model->GetPropertyCount($classid) == 10)		//�жϲ�Ʒ�����Ƿ�����
		{
			echo "��Ʒ��������";
			exit();
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST')			//�ж��Ƿ��ύ����
		{
			if($this->_getParam('Id'))
			{				
			if(!$this->_model->UpdateProperty($_POST,$classid,$id))	//�ж��Ƿ�����ɹ�
				{
					echo "���������ظ�";
				}
			}else{
				if(!$this->_model->UpdateProperty($_POST,$classid))
				{										//�ж��Ƿ�����ɹ�
					echo "���������ظ�";
				}
			}			
			$this->_redirect('/Class/Property/Id/' . $classid);
		}
		if($id)											//�ж��Ƿ��Ǳ༭״̬
		{
			$info = $this->_model->GetPropertyInfo($id);
		}
		$class = $this->_model->getInfo($classid);
		$this->_view->assign('class',$class);
		$this->_view->assign('info',$info);
		$this->_view->display('PropertyAdd.php');
	}
	/**
	 * ���ܣ�ɾ����Ʒ����
	 *
	 */
	public function PropertyDelAction()
	{
		$this->_model->DelProperty($this->_getParam('Id'));
		$this->_redirect('/Class/Property/Id/' . $this->_getParam('ClassId'));
	}
	/**
	 * ���ܣ����ò�Ʒ����˳��
	 *
	 */
	public function PropertyOrderAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')			//�ж��Ƿ��ύ����
		{
			$this->_model->SetPropertyOrder($_POST['id'],$_POST['order']);
		}
		if(!$classid) {
			$classid = 0;
		}
		$property = $this->_model->GetPropertyList($classid);
		$this->_view->assign('list',$property);
		$this->_view->display('PropertyOrder.php');
	}

}
?>
