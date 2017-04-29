<?php
class ClassController extends Core_Controller_Action 
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
		$this->_model = new ClassModel();							//定义ClassModel对象
		$this->_addTmpl = "ClassAdd.php";							//定义添加功能模板
		$this->_editTmpl = "ClassAdd.php";							//定义编辑功能模板
		parent::__construct();
	}
	/**
	 * 功能：首页
	 */
	public function IndexAction()
	{
		$this->_view->assign("type",$this->_getParam('Type'));
		$this->_view->display("ClassIndex.php");
	}
	/**
	 * 功能：显示类别数
	 */
	public function LeftAction()
	{
		global $classlist;
		$type = $this->_getParam('Type');							//获取参数
		switch ($type)
		{
			case 1:											//为1时连接到类别信息页面
				$url = "/Class/Info/Id/";
				break;
			case 2:											//为2时连接到产品列表页面
				$url = "/Product/Index/ClassId/";
				break;
			default:
				break;
		}
		$classlist = array();
		$deep = 0;
		$this->_model->GetClassListAll();							//取得类别数组
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
	 * 功能：显示类别信息
	 * 传递参数：Id 类别ID
	 */
	public function InfoAction()
	{
		$classid = $this->_getParam('Id');
		$info = $this->_model->getInfo($classid);
		$property = array();
		if ($info['F_CLASS_IS_DEFAULT_PROPERTY'])				//判断是否显示默认属性
		{
			$property_note = '注：此类别使用默认产品属性。';
			$property = $this->_model->GetPropertyList(0);
		}else{
			if ($info['F_CLASS_IS_PARENT_PROPERTY'])			//判断是否继承父属性
			{
				$property_note = '注：此类别产品属性是从父类别继承得来。';
				$property = $this->_model->GetPropertyList($info['F_PARENT_ID']);
			}else{
				$property = $this->_model->GetPropertyList($info['F_ID']);
			}
		}
		$img = $info['F_CLASS_IMG'] ? "<img src='" . WEB_DOMAIN . UPLOAD_DIR . $info['F_CLASS_IMG'] . "' width=100 height=75>" : "无";
		if ($info['F_CLASS_IMG_DEFAULT']){						//判断分类图片是否显示默认值
			$img_width = $this->_model->GetDefaultConfig("class_img_width");
			$img_height = $this->_model->GetDefaultConfig("class_img_height");
			$img_display = "$img_width * $img_height";
		}else{
			$img_display = "<font color='red'>{$info['F_CLASS_IMG_WIDTH']} * {$info['F_CLASS_IMG_HEIGHT']}</font>";
		}
		
		if ($info['F_CLASS_SMALL_IMG_DEFAULT']){					//判断产品小图片是否显示默认值
			$product_small_img_width = $this->_model->GetDefaultConfig("product_small_img_width");
			$product_small_img_height = $this->_model->GetDefaultConfig("product_small_img_height");
			$small_img_display = "$product_small_img_width * $product_small_img_height";
		}else{
			$small_img_display = "<font color='red'>{$info['F_CLASS_SMALL_IMG_WIDTH']} * {$info['F_CLASS_SMALL_IMG_HEIGHT']}</font>";
		}
		
		if ($info['F_CLASS_BIG_IMG_DEFAULT']){					//判断产品大图片是否显示默认值
			$product_big_img_width = $this->_model->GetDefaultConfig("product_big_img_width");
			$product_big_img_height = $this->_model->GetDefaultConfig("product_big_img_height");
			$big_img_display = "$product_big_img_width * $product_big_img_height";
		}else{
			$big_img_display = "<font color='red'>{$info['F_CLASS_BIG_IMG_WIDTH']} * {$info['F_CLASS_BIG_IMG_HEIGHT']}</font>";
		}
		
		if ($info['F_CLASS_PERLINE_DEFAULT'])					//判断每行显示产品数是否默认
			$perline = $this->_model->GetDefaultConfig("product_perline");
		else
			$perline = "<font color='red'>{$info['F_CLASS_PERLINE']}</font>";

		if ($info['F_CLASS_PAGESIZE_DEFAULT'])					//判断每页显示产品数是否默认
			$pagesize = $this->_model->GetDefaultConfig("product_pagesize");
		else
			$pagesize = "<font color='red'>{$info['F_CLASS_PAGESIZE']}</font>";
		$product_count = $this->_model->GetProductCount($classid);		//取得产品个数
		$sub_class = $this->_model->GetClassList($classid);			//取得子类别列表
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
	 * 功能：添加类别界面显示
	 *
	 */
	public function AddAction()
	{
		global $classlist;
		$parent = $this->_getParam('ParentId');
		if($parent)												//判断是否是添加顶层类别
		{
			$classlist = array();
			$data = array();
			$deep = 0;		
			$this->_model->GetClassListAll();
			foreach($classlist as $value)							//循环重组数组
			{
				$data[$value['id']] = $value['class_name'];
			}
			$this->_view->assign('option',$data);
		}
		$this->_view->assign('class_id',$parent);
		parent::AddAction();
	}
	/**
	 * 功能：类别编辑界面显示
	 *
	 */
	public function EditAction()
	{
		global $classlist;
		$classlist = array();
		$data = array();
		$deep = 0;		
		$this->_model->GetClassListAll();
		foreach($classlist as $value)								//循环重组数组
		{
			$data[$value['id']] = $value['class_name'];
		}
		$this->_view->assign('option',$data);
		parent::EditAction();
	}
	/**
	 * 功能：处理添加功能提交的数据
	 *
	 */
	public function InsertAction()
	{
		$data = array();
		if($this->_model->CheckClassNameExit($_POST['name'],$_POST['class_id']))
		{
			echo "类别名称重复";
			echo "<a href='javascript:window.history.back();'>返回</a>";
			exit();
		}
		if($_FILES['size'] > 0)
		{
			$result = Core_Upload::upload($_FILES,UPLOAD_PATH,UPLOAD_MAX_SIZE);
			if($result['errocode'] == 'size_erro')						//判断图片是否过大
			{
				echo "图片过大，不能超过" . UPLOAD_MAX_SIZE . "K";
				exit();
			}
			if($result['errocode'] == 'type_erro')						//判断文件类型是不是图片
			{
				echo "上传文件不是图片";
				exit();
			}
			$data[F_CLASS_IMG] = $result['file_name'];				//取得上传地址
		}
		$data[F_CLASS_NAME] = $_POST['name'];
		$data[F_CLASS_NOTE] = $_POST['note'];
		$data[F_PARENT_ID] = $_POST['class_id'];
		$data[F_CLASS_IS_DEFAULT_PROPERTY] = $_POST['use_default'];
		$data[F_CLASS_IS_PARENT_PROPERTY] = $_POST['use_parent_property'];
		if($id = $this->_model->insert($data))						//判断是否处理成功
		{
			$this->_redirect('/Class/Info/Id/' . $id);
		}
	}
	/**
	 * 功能：处理编辑提交的数据
	 *
	 */
	public function UpdateAction()
	{
		$data = array();
		if($this->_model->CheckClassNameExit($_POST['name'],$_POST['class_id'],$_POST['id']))
		{													//判断类别名称是否重复
			echo "类别名称重复";
			echo "<a href='javascript:window.history.back();'>返回</a>";
			exit();
		}
		if($_FILES['size'] > 0)
		{
			$result = Core_Upload::upload($_FILES,UPLOAD_PATH,UPLOAD_MAX_SIZE);
			if($result['errocode'] == 'size_erro')						//判断图片是否过大
			{
				echo "图片过大，不能超过" . UPLOAD_MAX_SIZE . "K";
				exit();
			}
			if($result['errocode'] == 'type_erro')						//判断文件类型是不是图片
			{
				echo "上传文件不是图片";
				exit();
			}
			$data[F_CLASS_IMG] = $result['file_name'];				//取得上传地址
		}
		$data[F_CLASS_NAME] = $_POST['name'];
		$data[F_CLASS_NOTE] = $_POST['note'];
		$data[F_PARENT_ID] = $_POST['class_id'];
		$data[F_CLASS_IS_DEFAULT_PROPERTY] = $_POST['use_default'];
		$data[F_CLASS_IS_PARENT_PROPERTY] = $_POST['use_parent_property'];
		if($this->_model->update($data,"F_ID = " . $_POST['id']))			//判断是否处理成功
		{
			$this->_redirect('/Class/Info/Id/' . $_POST['id']);
		}
	}
	/**
	 * 功能：设置类别顺序
	 *
	 */
	public function OrderAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')				//判断是否提交设置
		{
			$this->_model->SetClassOrder($_POST['SelId'],$_POST['Order']);	
		}
		$id = $this->_getParam('Id');
		$list = $this->_model->GetClassList($id);
		$path = WEB_DOMAIN . UPLOAD_DIR;
		$this->_view->assign(‘path’,$path);
		$this->_view->assign('list',$list);
		$this->_view->display('ClassOrder.php');
	}
	/**
	 * 功能：删除类别及相关信息
	 *
	 */
	public function DeleteAction()
	{
		$this->_model->Delete($this->_getParam('Id'));
		echo "删除成功";
	}
	/**
	 * 功能：设置显示参数
	 *
	 */
	public function ConfigAction()
	{
		$classid = $this->_getParam('Id');
		if($_SERVER['REQUEST_METHOD'] == 'POST')				//判断是否提交设置
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
	 * 功能：显示产品属性列表
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
	 * 功能：添加编辑产品属性
	 *
	 */
	public function PropertyAddAction()
	{
		$classid = $this->_getParam('ClassId');
		$id = $this->_getParam('Id');
		if($this->_model->GetPropertyCount($classid) == 10)		//判断产品属性是否已满
		{
			echo "产品属性已满";
			exit();
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST')			//判断是否提交处理
		{
			if($this->_getParam('Id'))
			{				
			if(!$this->_model->UpdateProperty($_POST,$classid,$id))	//判断是否操作成功
				{
					echo "属性名称重复";
				}
			}else{
				if(!$this->_model->UpdateProperty($_POST,$classid))
				{										//判断是否操作成功
					echo "属性名称重复";
				}
			}			
			$this->_redirect('/Class/Property/Id/' . $classid);
		}
		if($id)											//判断是否是编辑状态
		{
			$info = $this->_model->GetPropertyInfo($id);
		}
		$class = $this->_model->getInfo($classid);
		$this->_view->assign('class',$class);
		$this->_view->assign('info',$info);
		$this->_view->display('PropertyAdd.php');
	}
	/**
	 * 功能：删除产品属性
	 *
	 */
	public function PropertyDelAction()
	{
		$this->_model->DelProperty($this->_getParam('Id'));
		$this->_redirect('/Class/Property/Id/' . $this->_getParam('ClassId'));
	}
	/**
	 * 功能：设置产品属性顺序
	 *
	 */
	public function PropertyOrderAction()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')			//判断是否提交设置
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
