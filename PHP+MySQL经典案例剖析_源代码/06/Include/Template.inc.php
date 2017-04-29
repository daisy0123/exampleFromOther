<?php
class Temp extends DBSQL 
{
	public $code = array("[template_caption]" => "文章标题","[template_keywords]" => "文章关键字","[template_from]" => "文章来源",
					"[template_nav]" => "文章当前位置","[template_img]" => "文章图片URL","[template_f_caption]" => "文章副标题",
					"[template_class]" => "文章所属栏目名称","[template_news_id]" => "文章ID","[template_link]" => "文章URL",
					"[template_other]" => "文章相关连接","[template_page]" => "文章分页","[template_submit_time]" => "文章发布时间",
					"[template_author]" => "文章作者","[template_content]" => "文章内容","[template_host]" => "文章所在域名",
					"[template_list]" => "栏目列表","[template_nav]" => "栏目导航","[template_page]" => "栏目列表分页");													//定义代码查询选项
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 功能：提取模块列表
	 * 参数：$id 栏目ID
	 * 返回：数组
	 */
	public function GetTempList($id)
	{
		$sql = "SELECT * FROM EE_TEMPLATE_INFO WHERE F_ID_CLASS_INFO = $id";
		return $this->select($sql);
	}
		/**
	 * 功能：添加编辑模快信息
	 * 参数：$id 模块信息ID,$arr 提交的表单信息
	 * 返回：TRUE OR FALSE
	 */	
	public function AddTemplate($id=0,$arr)
	{
		extract($arr);
		$List = array();
		$where = "";
		if($recommend)									//判断是否推荐,增加信息提取条件
			$where .= " AND F_NDT_IS_RECOMMEND = 1";
		if($hot)											//判断是否热点,增加信息提取条件
			$where .= " AND F_NDT_IS_HOT = 1";
		if($new)											//判断是否快讯,增加信息提取条件
			$where .= " AND F_NDT_IS_NEW = 1";
		$sql = "SELECT * FROM EE_NEWS_DETAIL WHERE F_ID_CLASS_INFO = $news_class AND F_NDT_IS_CHECK = 1 AND F_NDT_IS_DEL = 0";
		$sql .= $where . " ORDER BY F_NDT_TIME LIMIT 0,$news_count";
		$List = $this->select($sql);							//提取信息
		$class_info = $this->getInfo($class_id,"EM_CLASS_INFO");
		extract($class_info);
		if($way)											//判断是否是HTML方式
		{
			$str = "<table width='100%'  border='0' cellpadding='0' cellspacing='0'>";
			$width = (int)(100 / $news_row) . "%";
			$i = 1;
			if($branch == 0)								//判断是否分行
			{
				$str .= "<tr>";
				$count = ceil(count($List)/$news_row);
			}
			foreach($List as $key => $l)						//循环显示信息
			{
				extract($l);
				if($type == 0)								//判断是否是图片类型
				{
					$sql = "SELECT * FROM EE_NEWS_IMG WHERE F_ID_NEWS_INFO = $F_ID and F_NIG_IS_DEFAULT = 1";
					$img = $this->select($sql);
				}
				if($branch == 1)							//判断是否分行
				{
					if($key % $news_row == 0)				//判断是否是行的开始
					{
						$str .= "<tr>";
					}
					$str .= "<td width='$width'>";
				}else{
					if($key % $count == 0)					//判断是否是列的开始
					{
						$str .= "<td width='$width'>";
					}
				}
				$ndt_caption = mb_substr($F_NDT_CAPTION,0,$cap_len);
				$ndt_content = mb_substr(strip_tags($F_NDT_CONTENT),0,$con_len);
				$ndt_f_caption = mb_substr($F_NDT_F_CAPTION,0,$con_len);
				$html = file_get_contents("../..$template_url");
				$html = str_replace("[template_img]",UPLOAD_DIR . $img[F_NIG_FILENAME],$html);
				$html = str_replace("[template_caption]",$ndt_caption,$html);
				$html = str_replace("[template_link]",$F_NDT_CONTENT_URL,$html);
				$html = str_replace("[template_f_caption]",$ndt_f_caption,$html);
				if($i <= $con_count)							//判断是否显示信息内容
				{
					$html = str_replace("[template_content]",$ndt_content,$html);
				}
				$ndt_submit_time = substr(date("Y-m-d H:i:s",$F_NDT_TIME),5,5);
				$html = str_replace("[template_submit_time]",$ndt_submit_time,$html);
				$html = str_replace("[template_class]",$class_info['F_CLASS_NAME'],$html);
				$str .= $html;
				if($branch == 1)							//判断是否分行
				{
					$str .= "</td>";
					if($key % $news_row == $news_row - 1)		//判断是否到行的结束
					{
						$str .= "</tr>";
					}
				}else{
					if($key % $count == $count - 1)				//判断是否到列结束
					{
						$str .= "</td>";
					}
				}
				$i++;
			}
			if($branch == 1)								//判断是否分行
			{
				if($key % $news_row < $news_row - 1)			//判断是否到行的结束
				{
					for(;$key % $news_row < $news_row - 1;$key++)
						$str .= "<td width='$width'>&nbsp;</td>";	//循环补足列
					$str .= "</tr>"; 
				}
			}else{
				if($key % $count < $count - 1)					//判断是否到列的结束
				{
						$str .= "</td>";
				}
				$str .= "</tr>"; 
			}
			$str .= "</table>";
		}else{
			$str = "document.write(\"<table width='100%'  border='0' cellpadding='0' cellspacing='0'>\");";
			$width = (int)(100 / $news_row) . "%";
			$i = 1;
			if($branch == 0)								//判断是否分行
			{
				echo "document.write(\"<tr>\")\n";
				$count = ceil(count($List)/$news_row);
			}
			foreach($List as $key => $l)						//循环显示信息
			{
				extract($l);
				$html = "";
				if($type == 0)								//判断是否是图片信息
				{
					$sql = "SELECT * FROM EE_NEWS_IMG WHERE F_ID_NEWS_INFO = $F_ID and F_NIG_IS_DEFAULT = 1";
					$img = $this->select($sql);
				}
				if($branch == 1)							//判断是否分行
				{
					if($key % $news_row == 0)				//判断是否是行的开始
					{
						$str .= "document.write(\"<tr>\");\n";
					}
					$str .= "document.write(\"<td width='$width'>\");\n";
				}else{
					if($key % $count == 0)					//判断是否是列的开始
					{
						$str .= "document.write(\"<td width='$width'>\");\n";
					}
				}
$ndt_caption = mb_substr($F_NDT_CAPTION,0,$cap_len);
				$ndt_content = mb_substr(strip_tags($F_NDT_CONTENT),0,$con_len);
				$ndt_f_caption = mb_substr($F_NDT_F_CAPTION,0,$con_len);
				$html = file_get_contents("../..$template_url");
				$html = str_replace("[template_img]",UPLOAD_DIR . $img[F_NIG_FILENAME],$html);
				$html = str_replace("[template_caption]",$ndt_caption,$html);
				$html = str_replace("[template_link]",$ndt_content_url,$html);
				$html = str_replace("[template_f_caption]",$ndt_f_caption,$html);
				if($i <= $con_count)
				{
					$html = str_replace("[template_content]",$ndt_content,$html);
				}
				$ndt_submit_time = substr(date("Y-m-d H:i:s",$F_NDT_TIME),5,5);
				$html = str_replace("[template_submit_time]",$ndt_submit_time,$html);
				$html = str_replace("[template_class]",$class_info['F_CLASS_NAME'],$html);
				$str .= "document.write(\"$html\");";
				if($branch == 1)							//判断是否分行
				{
					$str .= "document.write(\"</td>\");\n";
					if($key % $news_row == $news_row - 1)		//判断是否是行的结束
					{
						$str .= "document.write(\"</tr>\");\n";
					}
				}else{
					if($key % $count == $count - 1)				//判断是否是列的结束
					{
						$str .= "document.write(\"</td>\");\n";
					}
				}
				$i++;
			}
			if($branch == 1)								//判断是否分行
			{
				if($key % $news_row < $news_row - 1)			//判断是否行结束
				{
					for(;$key % $news_row < $news_row - 1;$key++)	//补足列
						$str .= "document.write(\"<td width='$width'>&nbsp;</td>\");\n";
					$str .= "document.write(\"</tr>\");\n"; 
				}
			}else{
				if($key % $count < $count - 1)					//判断是否是列的结束
				{
					$str .= "document.write(\"</td>\");\n";
				}
				$str .= "document.write(\"</tr>\");\n"; 
			}
			$str .= "document.write(\"</table>\")";
		}
		$str = addslashes($str);
		$data['F_ID_CLASS_INFO'] = $class_id;
		$data['F_NEWS_CLASS'] = $news_class;
		$data['F_TMP_WAY'] = $way;
		$data['F_TMP_TYPE'] = $type;
		$data['F_TMP_NAME'] = $name;
		$data['F_TMP_NEWS_COUNT'] = $news_count;
		$data['F_TMP_NEWS_ROW'] = $news_row;
		$data['F_TMP_CAP_LEN'] = $cap_len;
		$data['F_TMP_CON_LEN'] = $con_len;
		$data['F_TMP_CON_COUNT'] = $con_count;
		$data['F_TMP_URL'] = $template_url;
		$data['F_TMP_RECOMMEND'] = $recommend;
		$data['F_TMP_HOT'] = $hot;
		$data['F_TMP_IS_NEW'] = $new;
		$data['F_TMP_STATUS'] = $state;
		$data['F_TMP_NOTE'] = $note;
		$data['F_TMP_CODE'] = $str;
		$data['F_TMP_IS_BRANCH'] = $branch;
		if($id > 0)											//判断是否是编辑状态
		{
			return $this->updateData("EE_TEMPLATE_INFO",$id,$data);
		}else{
			return $this->insertData("EE_TEMPLATE_INFO",$data);
		}
	}

}
?>
