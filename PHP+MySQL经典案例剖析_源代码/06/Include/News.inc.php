<?php
class News extends DBSQL 
{
	public $type;
	public function __construct()
	{
		$this->type = array('php','html','shtml');
		parent::__construct();
	}
	/**
	 * 功能：提取栏目列表
	 */
	public function GetClassListAll(){
		$deep = 0;
		$this->_GetClassList(0);	
	}
	/**
	 * 功能：提取指定父ID的栏目列表
	 * 参数：$parent_id 父ID
	 * 返回：数组
	 */
	public function GetClassList($parent_id = 0){
		$sql = "SELECT F_ID,F_CLASS_NAME,F_PARENT_ID,F_CLASS_PATH FROM EM_CLASS_INFO WHERE F_PARENT_ID = $parent_id";
		return $this->select($sql);
	}
	/**
	 * 功能：采用递归算法提取栏目列表
	 * 参数：$parent_id 父ID
	 */
	public function _GetClassList($parent_id){
		GLOBAL $deep,$class_list;
		$deep++;
		$c_list = $this->GetClassList($parent_id);
		$cur_class_num = count($class_list);
		if ($cur_class_num > 0)										//判断该栏目下是否有子栏目
			$class_list[count($class_list) - 1][sub_num] = count($c_list);
		foreach($c_list as $class){										//循环提取栏目信息
			$p_id = $class[F_ID];
			$p_name = $class[F_CLASS_NAME];
			$p_path = $class[F_CLASS_PATH];
			for ($i = 0,$prev = "";$i < $deep - 1;$i++)	$prev .= "　";			//循环生成显示时的间隔
			if($class[F_PARENT_ID] > 0)								//判断是否是顶层栏目
				$class_list[] = array("class" =>  $prev ."|-".$p_name,"id" => $p_id,"parent_id" => $class[F_PARENT_ID],"path" => $p_path,"class_name" => $p_name);
			else
				$class_list[] = array("class" => $prev . $p_name,"id" => $p_id,"parent_id" => $class[F_PARENT_ID],"path" => $p_path,"class_name" => $p_name);
			$this->_GetClassList($p_id);								//递归调用自身
		}
		$deep--;
	}
	/**
	 * 功能：删除栏目信息
	 * 参数：$id 栏目ID
	 * 返回：-1,-2,1,0
	 */
	public function DelClass($id)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_NEWS_DETAIL WHERE F_ID_CLASS_INFO = $id";
		$r = $this->select($sql);
		if ($r[0][0])												//判断是否此栏目下有无信息
			return -1;
		
		$sql = "SELECT COUNT(F_ID) FROM EM_CLASS_INFO WHERE F_PARENT_ID = $id";
		$r = $this->select($sql);									//判断此栏目下是否有子栏目
		if ($r[0][0])
			return -2;
		
		$sql = "DELETE FROM EM_CLASS_INFO WHERE F_ID = $id";
		if($this->delete($sql))									//判断是否删除成功
			return 1;
		else 
			return 0;	
	}
	/**
	 * 功能：生成栏目首页
	 * 参数：$id 栏目ID,$isBatch是否是批量,$start批量时记录开始位置,$end批量时记录结束位置
	 * 返回：1
	 */
	public function GenList($id,$isBatch=0,$start=0,$end=0){
		if($isBatch)											//判断是否是批量生成
		{
			$sql = "SELECT * FROM EM_CLASS_INFO LIMIT $start,$end";
			$r = $this->select($sql);
			$class_info = $r[0];
			$id = $class_info['F_ID'];
		}else{
			$class_info = $this->getInfo($id,'EM_CLASS_INFO');
		}
		if($class_info) {
		$sql = "SELECT t.* FROM EE_TEMPLATE_INFO t,EM_CLASS_INFO c WHERE t.F_NEWS_CLASS = '$id' or (c.F_PARENT_ID = '$id' and  t.F_NEWS_CLASS = c.F_ID)";
		$tmp = $this->select($sql);
		$html_nav = "<a href='/'>首页</a> — ";
		if($class_info['F_PARENT_ID']){							//判断是否有父ID
			$arr = array();
			$parent = $this->getInfo($class_info['F_PARENT_ID'],'EM_CLASS_INFO');
			$arr[] = array("class_name" => $parent['F_CLASS_NAME'],"path" => $parent['F_CLASS_PATH']);
			$parent_id = $parent['F_PARENT_ID'];
			while($parent_id)										//循环生成栏目树数组
			{
				$parent = $this->getInfo($class_info['F_PARENT_ID'],'EM_CLASS_INFO');
				$arr[] = array("class_name" => $parent['F_CLASS_NAME'],"path" => $parent['F_CLASS_PATH']);
				$parent_id = $parent['F_PARENT_ID'];
			}
			for($i=count($arr)-1;$i >= 0;$i--)							//循环生成导航连接
			{
				extract($arr[$i]);
				$html_nav .= "<a href='$path'>$class_name</a>";
				$html_nav .= " — ";
			}
		}
		$html_nav .= "{$class_info['F_CLASS_NAME']}";
		$path = $class_info['F_CLASS_PATH'];
		if($class_info['F_CLASS_LIST_STYLE'])							//判断是否有列表样式
		{
			$pages = $class_info['F_CLASS_NEWS_COUNT'];
			$i = 1;
			$start = ($i - 1) * $pages;
			$sql_fields = "F_ID,F_NDT_CAPTION,F_NDT_CONTENT,F_NDT_AUTHOR,F_NDT_CONTENT_URL,F_NDT_IS_CLASS,F_NDT_IS_NEW,F_NDT_TIME,F_NDT_IS_IMG,F_NDT_IS_HOT";
			$sql_from = "EE_NEWS_DETAIL";
			$sql_where = "F_ID_CLASS_INFO = $id AND F_NDT_IS_DEL = 0 AND F_NDT_IS_CHECK = 1";
			$sql_order = "F_ID DESC";
			$sql = "SELECT $sql_fields FROM $sql_from WHERE $sql_where ORDER BY $sql_order LIMIT $start,$pages";
			$list = $this->select($sql);
			$sql = "SELECT COUNT(F_ID) FROM EE_NEWS_DETAIL WHERE $sql_where";
			$r = $this->select($sql);
			$count = $r[0][0];
			$pagecount = ceil($r[0][0] / $pages);
			if(!$pagecount) $pagecount = 1;
			if($pagecount > 15) $pagecount = 15;						//判断页码是否大于15
			list($front,$back) = explode(".",$ncs_index_name);
			for(;$i <= $pagecount;$i++){								//按页码循环生成静态页面
				$str = "";
				$width = (int)(100 / $class_info['F_CLASS_NEWS_ROW']) . "%";
				$str .= "<table width='100%'  border='0' cellpadding='0' cellspacing='0'>";
				foreach($list as $key => $r){
					extract($r);
					if($key % $class_info['F_CLASS_NEWS_ROW'] == 0)	//判断是否是行的开始
					{
						$str .= "<tr>";
					}
					$html = file_get_contents("../..{$class_info['F_CLASS_LIST_STYLE']}");
					$subtime = substr(date("Y-m-d H:i:s",$F_NDT_TIME),5,11);
					$F_NDT_CONTENT = str_replace("[NextPage]","",$F_NDT_CONTENT);
					$F_NDT_CONTENT = mb_substr(strip_tags($F_NDT_CONTENT),0,$class_info['F_CLASS_CON_LEN']);
					$F_NDT_CAPTION = mb_substr($F_NDT_CAPTION,0,$class_info['F_CLASS_CAP_LEN']);
					if($class_info['F_CLASS_SIGN_IMAGE'])				//判断是否是图片栏目
					{
						$sql = "SELECT * FROM EE_NEWS_DETAIL WHERE F_ID_NEWS_INFO = '$F_ID' and F_NIG_IS_DEFAULT = 1";
						$img = $this->select($sql);
						$html = str_replace("[template_img]",UPLOAD_DIR . $img[0][F_NIG_FILENAME],$html);
					}
					$html = str_replace("[template_caption]",$F_NDT_CAPTION,$html);
					$html = str_replace("[template_from]",$F_NDT_FROM,$html);
					$html = str_replace("[template_author]",$F_NDT_AUTHOR,$html);
					$html = str_replace("[template_content]",$F_NDT_CONTENT,$html);
					$html = str_replace("[template_link]",$F_NDT_CONTENT_URL,$html);
					$html = str_replace("[template_submit_time]",$subtime,$html);
					$html = str_replace("[template_class]",$class_info['F_CLASS_NAME'],$html);
					$str .= "<td width='$width'>$html</td>";
					if($key % $class_info['F_CLASS_NEWS_ROW'] == $class_info['F_CLASS_NEWS_ROW'] - 1)								//判断是否是行结束
					{
						$str .= "</tr>";
					}
				}
				if($key % $class_info['F_CLASS_NEWS_ROW'] < $class_info['F_CLASS_NEWS_ROW'] - 1)
				{												//判断是否到行结束
					for(;$key % $class_info['F_CLASS_NEWS_ROW'] < $class_info['F_CLASS_NEWS_ROW'] - 1;$key++)
						$str .= "<td width='$width'>&nbsp;</td>";			//循环补足列
					$str .= "</tr>"; 
				}
				$str .= "</table>";
				$html = file_get_contents("../..{$class_info['F_CLASS_TEMPLATE_URL']}");
				$html = str_replace("[template_list]",$str,$html);
				foreach($tmp as $t)									//循环替换模块
				{
					extract($t);
					$replace = "[".$tmp_name."]";
					$html = str_replace($replace,$tmp_code,$html);
				}
				$page = "";
				if($pagecount >= 1){									//判断页数是否大于等于1
					$page_str = "";
					for($j = 1;$j <= $pagecount;$j++)					//循环生成翻页导航
					{
						if($j == 1)									//判断是否是第一页
							$url = "{$class_info['F_CLASS_INDEX_NAME']}";
						else
							$url = $front . "$j" . ".$back";
						$page_str .= "<option value='$url'";
						if($j == $i)									//设置跳转默认选项
							$page_str .= " selected";
						$page_str .= ">$j</option>";
					}
					$page .= "<table width='100%'  border='0' cellpadding='0' cellspacing='0'><tr>";
					$page .= "<td width='66%'>共{$count}条新闻 页次 $i" ." / " . "$pagecount 每页 $pages</td><td width='34%' align='right'>转到：<select name='url' id='url' onChange='javascript:location.href=this.options[selectedIndex].value'>";
					$page .= "$page_str</select>页</td></tr></table>";
				}
				$html = str_replace("[template_page]",$page,$html);
				$html = str_replace("[template_nav]",$html_nav,$html);
				if($i == 1){											//判断是否第一页
					$filename = "{$class_info['F_CLASS_PATH']}{$class_info['F_CLASS_INDEX_NAME']}";
				}else{
					$filename = "{$class_info['F_CLASS_PATH']}$front" . $j . ".$back";
				}
			$handle = @fopen("../..$filename","w");
			@fwrite($handle,$html);
			@fclose($handle);
			}
		}else{
			$html = file_get_contents("../..{$class_info['F_CLASS_TEMPLATE_URL']}");
			foreach($tmp as $t)										//循环替换模块
			{
				extract($t);
				$html = str_replace("[" .$tmp_name."]",$tmp_code,$html);
			}
			$html = str_replace("[template_nav]",$html_nav,$html);
			$filename = "../..{$class_info['F_CLASS_PATH']}{$class_info['F_CLASS_INDEX_NAME']}";
			$handle = @fopen($filename,"w");
			@fwrite($handle,$html);
			@fclose($handle);
		}
		}
		return 1;
	}
	/**
	 * 功能：生成RRS格式的XML页面
	 * 参数：$id 栏目ID,$isBatch是否是批量,$start批量时记录开始位置,$end批量时记录结束位置
	 * 返回：1
	 */
	function GenXml($id,$isBatch=0,$start=0,$end=0)
	{
		if($isBatch)													//判断是否是批量生成
		{
			$sql = "SELECT * FROM EM_CLASS_INFO LIMIT $start,$end";
			$r = $this->select($sql);
			$info = $r[0];
			$id = $info['F_ID'];
		}else{
			$info = $this->getInfo('EM_CLASS_INFO',$id);
		}
		if($info) {
			$path = $info['F_CLASS_PATH'];
			$list = array();
			$sql = "SELECT * FROM EE_NEWS_DETAIL WHERE F_ID_CLASS_INFO = '$id' AND F_NDT_IS_DEL = 0 AND F_NDT_IS_CHECK = 1 ORDER BY F_NDT_TIME DESC LIMIT 0,30";
			$list = $this->select($sql);
			$str = "";
			foreach($list as $l)												//循环生成item元素
			{
				extract($l);
				$content = strip_tags($F_NDT_CONTENT);
				$content = mb_substr($F_NDT_CONTENT,80);
				$str .= "<item>\n";
				$str .= "<title>$F_NDT_CAPTION</title>\n";
				$str .= "<description>$content</description>\n";
				$str .= "<link>http://www.xxx.com" . "$F_NDT_CONTENT_URL</link>\n";
				$str .= "<category>{$info['F_CLASS_NAME']}</category>\n";
				$str .= "<author>{$F_NDT_AUTHOR}</author>\n";
				$str .= "<pubDate>" . date(DATE_RFC822,$F_NDT_TIME) . "</pubDate>\n";
				$str .= "</item>\n";
			}
			$html = file_get_contents("../..{$info['F_CLASS_RSS_STYLE']}");
			$html = str_replace("[template_class]",$info['F_CLASS_NAME'],$html);			//替换栏目名称
			$html = str_replace("[template_note]",$info['F_CLASS_NOTE'],$html);		//替换栏目描述
			$html = str_replace("[template_url]","http://www.xxx.com" . $path,$html);		//栏目首页路径
			$html = str_replace("[template_list]",$str,$html);						//替换item元素部分
			$filename = $path . "rss/" . $info['F_CLASS_URL_NAME'] . ".xml";
			$handle = fopen("../..$filename","w");
			@fwrite($handle,$html);
		}
		return 1;
	}
	/**
	 * 功能：提取信息列表
	 * 参数：$class_id 栏目ID,$page 当前页码,$pagesize 每页提取信息数
	 *		$keyword 搜索关键字,$ischeck是否审核,$isdel是否删除
	 * 返回：数组
	 */
	public function GetNewsList($class_id,$page = 1,$pagesize,$keyword='',$ischeck=0,$isdel=0)
	{
		$start = ($page - 1) * $pagesize;
		$sql_fields = "F_ID,F_NDT_CAPTION,F_NDT_CONTENT,F_NDT_AUTHOR,F_NDT_CONTENT_URL,F_NDT_IS_CLASS,F_NDT_IS_NEW,F_NDT_TIME,F_NDT_IS_IMG,F_NDT_IS_HOT";
		$sql_from = "EE_NEWS_DETAIL";
		$sql_where = "";
		if($class_id)											//判断是否有栏目ID
		{
			$sql_where .= "F_ID_CLASS_INFO = $class_id AND F_NDT_IS_DEL = 0";
			if($ischeck)										//判断是否是提取未审核列表
				$sql_where .= " AND F_NDT_IS_CHECK = 0";
		}
		if($isdel)												//判断是否提取回收站信息
		{
			$sql_where = "F_NDT_IS_DEL = 1";
		}
		if($keyword)											//判断是否有搜索关键字
			$sql_where .= " AND F_NDT_CAPTION LIKE '%$keyword%'";
		$sql_order = "F_ID DESC";
		$sql = "SELECT $sql_fields FROM $sql_from WHERE $sql_where ORDER BY $sql_order LIMIT $start,$pagesize";
		return $this->select($sql);
	}
	/**
	 * 功能：提取信息条数
	 * 参数：$class_id 栏目ID,$keyword 搜索关键字
	 * 返回：信息条数
	 */	
	public function GetNewsCount($class_id,$keyword='',$ischeck=0,$isdel=0)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_NEWS_DETAIL WHERE F_ID_CLASS_INFO = $class_id AND F_NDT_IS_DEL = 0";
		$sql_where = "";
		if($class_id)											//判断是否有栏目ID
		{
			$sql_where = "F_ID_CLASS_INFO = $class_id AND F_NDT_IS_DEL = 0";
			if($ischeck)										//判断是否提取未审核列表
				$sql_where = " AND F_NDT_IS_CHECK = 0";
		}
		if($isdel)												//判断是否提取回收站列表
		{
			$sql_where = "F_NDT_IS_DEL = 1";
		}
		if($keyword)											//判断是否有搜索关键字
			$sql .= " AND F_NDT_CAPTION LIKE '%$keyword%'";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：删除信息
	 * 参数：$arr ID数组,$type 执行类型(1为放入回收站,2为彻底删除,3为恢复信息)
	 * 返回：TRUE OR FALSE
	 */
	function DelNews($arr,$type)
	{
		if($arr)
		{
			$this->begintransaction();								//开始事务处理
			try{
			foreach($arr as $id)									//循环执行操作
			{
				switch($type)
				{
					case 1:									//放入回收站
						$sql = "UPDATE EE_NEWS_DETAIL SET F_NDT_IS_DEL = 1 WHERE F_ID = $id";
						$this->update($sql);
						break;
					case 2:									//彻底删除信息
						$sql = "DELETE FROM EE_NEWS_DETAIL WHERE F_ID = $id";
						$this->delete($sql);
						$sql = "DELETE FROM EE_REMARK_INFO WHERE F_ID_NEWS_INFO = $id";
						$this->delete($sql);
						$sql = "DELETE FROM EE_NEWS_IMG WHERE F_ID_NEWS_INFO = $id";
						$this->delete($sql);
						break;
					case 3:									//恢复信息
						$sql = "UPDATE EE_NEWS_DETAIL SET F_NDT_IS_DEL = 0 WHERE F_ID = $id";
						$this->update($sql);
						break;
				}
			}
			}catch (Exception $e){								//捕获异常
				echo $e;
				$this->rollback();								//回滚
				return false;
			}
			$this->commit();									//提交
		}
		return true;
	}
	/**
	 * 功能：生成内容信息页面
	 * 参数：$arr信息ID数组,$isbatch是否是批量,$classid栏目ID
	 * 		$start批量时记录开始位置,$end批量时记录结束位置
	 * 返回：true;
	 */
	public function GenContent($arr,$isbatch=0,$classid,$start,$end){
		if($isbatch)											//判断是否是批量生成页面
		{
			$sql = "SELECT F_ID FROM EE_NEWS_DETAIL";
			if($class_id)										//判断是否指定栏目
				$sql .= " WHERE F_ID_CLASS_INFO = '$class_id'";
			$sql .= " LIMIT $start,$end";
			$r = $this->select($sql);
			$arr = array();
			$arr = $r[0];
		}
		foreach($arr as $id){										//循环生成页面
			$info = $this->getInfo($id,"EE_NEWS_DETAIL");
			extract($info);
			$class = $this->getInfo($F_ID_CLASS_INFO,"EM_CLASS_INFO");
			$from = "来源：$F_NDT_FROM";
			$sql = "SELECT * FROM EE_NEWS_IMG WHERE F_ID_NEWS_INFO = $F_ID";
			$img = $this->select($sql);
			$image = "<table width='100%' border='0'>";
			foreach($img as $i){									//生成上传图片列表
				extract($i);
				$image .= "<tr><td align='center'><img src='" . UPLOAD_DIR . "$F_NIG_FILENAME'></td></tr>";
				$image .= "<tr><td align='center'>$F_IMG_CAPTION</td></tr>";
			}
			$image .= "</table>";
			$html_nav = "<a href='/'>首页</a> — ";
			if($class[F_PARENT_ID]){							//生成导航信息
				$arr = array();
				$parent = $this->getInfo($class[F_PARENT_ID],'EM_CLASS_INFO');
				$parent_id = $parent['F_PARENT_ID'];
				$arr[] = array("class_name" => $parent['F_CLASS_NAME'],"path" => $parent['F_CLASS_PATH']);
				while($parent_id)								//循环生成父栏目树
				{
					$parent = $this->getInfo($class[F_PARENT_ID],'EM_CLASS_INFO');
					$parent_id = $parent['F_PARENT_ID'];
					$arr[] = array("class_name" => $parent['F_CLASS_NAME'],"path" => $parent['F_CLASS_PATH']);
				}
				for($i=count($arr)-1;$i >= 0;$i--)					//循环生成导航信息
				{
					extract($arr[$i]);
					$html_nav .= "<a href='$path'>$class_name</a>";
					if($i > 0)
						$html_nav .= " — ";
				}
				$html_nav .= " — <a href='$ncs_path'>$ncs_name</a>";
			}else{
				$html_nav .= "<a href='$path'>$ncs_name</a>";
			}
			$a = array();
			$a = explode(",",$F_NDT_KEYWORDS);
			$condition = "";
			if($F_NDT_KEYWORDS){							//生成查询相关信息条件
				for($i = 0;$i < count($a);$i++){
					$condition .= "find_in_set('$a[$i]',F_NDT_KEYWORDS)";
					if($a[$i+1])
						$condition .= " or ";
					else
						break;
				}
			}
			if($condition)
			{
				$where = "(" . $condition . ") and F_ID <> '$id'";
				$sql = "SELECT * FROM EE_NEWS_DETAIL WHERE $where ORDER BY F_ID desc limit 0,10";
				$news = $this->select($sql); 
				if($news){										//判断是否有相关信息
					$link = "<ul>";
					foreach($news as $n){						//循环生成替换字符串
						$link .= "<li>?<a href='$n[F_NDT_CONTENT_URL]}' target='_blank'>{$n[F_NDT_CAPTION]}</a></li>";
		   			}
		   			$link .= "</ul>";
		   		}else{
					$link = "";
				}
			}
		  	$str = explode("[NextPage]",$F_NDT_CONTENT);
			$page = count($str);
			$page_str = "";
			for($i = 0;$i < $page;$i++)								//做分页处理
			{
				$content = $str[$i];
				if($page > 1)
				{
					$page_str = "分页:";
					for($j = 1;$j <= $page;$j++)					//循环生成分页连接
					{
						$url = substr($F_NDT_CONTENT_URL,strrpos($F_NDT_CONTENT_URL,"/")+1,strlen($F_NDT_CONTENT_URL));
					   list($front,$back) = explode(".",$url);
					   $filename = $front . "$j" . "." .$back;
					   $filename = str_replace("$url","$filename",$F_NDT_CONTENT_URL);
						if($j == $i+1)							//判断是否是当前页面
						{
							$page_str .= "[$j] ";
						}else	{
							if($j - 1 == 0)
								$page_str .= "<a href='$F_NDT_CONTENT_URL'>[$j]</a>";
							else
								$page_str .= "<a href='$filename'>[$j]</a> ";
						}
					}
				}
				$sql = "SELECT * FROM EM_LINK_INFO";
				$news_link = $this->select($sql);
				if($news_link)
				{
					foreach($news_link as $n)					//循环替换常用连接
					{
						extract($n);
						$search = "<a href=\"".$F_LINK_URL."\" target='_blank'><font color='".$F_LINK_COLOR."'>" . $F_LINK_NAME . "</font></a>";
						$content = str_replace($F_LINK_NAME,$search,$content);
					}
				}
			   $html = file_get_contents("../..{$class['F_CLASS_NEWS_TEMPLATE']}");
			   $html = str_replace("[template_nav]",$html_nav,$html);
			   $html = str_replace("[template_caption]",$F_NDT_CAPTION,$html);
			   $html = str_replace("[template_from]",$from,$html);
			   $html = str_replace("[[template_img]]",$image,$html);
			   $html = str_replace("[template_content]",$content,$html);
			   $html = str_replace("[template_other]",$link,$html);
			   $html = str_replace("[template_news_id]",$F_ID,$html);
			   $html = str_replace("[template_page]",$page_str,$html);
			   $html = str_replace("[template_class]",$class['F_CLASS_NAME'],$html);
			   $html = str_replace("[template_keywords]",$F_NDT_KEYWORD,$html);
			   $html = str_replace("[template_link]",$F_NDT_CONTENT_URL,$html);
			   $submit_time = date("Y年m月d日 H:i",$F_NDT_TIME);
			   $html = str_replace("[template_submit_time]",$submit_time,$html);
			   if($i == 0)										//判断是否是第一页
			   {
				   $handle =fopen("../..$F_NDT_CONTENT_URL","w");
				   @fwrite($handle,$html);						//生成页面
				   fclose($handle);
			   }else{
				   $url = substr($F_NDT_CONTENT_URL,strrpos($F_NDT_CONTENT_URL,"/")+1,strlen($F_NDT_CONTENT_URL));
				   list($front,$back) = explode(".",$url);
				   $k = $i+1;
				   $filename = $front . $k . "." .$back;
				   $filename = str_replace("$url","$filename",$F_NDT_CONTENT_URL);
				   $handle =fopen("../..$filename","w");
				   @fwrite($handle,$html);						//生成页面
				   fclose($handle);
			   }
		   }
		}
		return true;
	}
	/**
	 * 功能：提取图片列表
	 * 参数：$id 信息ID
	 * 返回：数组
	 */
	public function GetImgList($id)
	{
		$sql = "SELECT * FROM EE_NEWS_IMG WHERE F_ID_NEWS_INFO = $id";
		return $this->select($sql);
	}
	/**
	 * 功能：删除图片信息
	 * 参数：$id 图片信息ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelPic($id)
	{
		$sql = "DELETE FROM EE_NEWS_IMG WHERE F_ID = $id";
		return $this->delete($sql);
	}
	/**
	 * 功能：审核信息
	 * 参数：$id 信息ID
	 * 返回：TRUE OR FALSE
	 */
	public function Check($id)
	{
		$sql = "UPDATE EE_NEWS_DETAIL SET F_NDT_IS_CHECK = 1 WHERE F_ID = $id";
		return $this->update($sql);
	}
	/**
	 * 功能：提取评论列表
	 * 参数：$page 当前页码,$pagesize 每页显示条数
	 * 返回：数组
	 */
	public function GetRemarkList($page = 1,$pagesize)
	{
		$start = ($page - 1) * $pagesize;
		$sql = "SELECT * FROM EE_REMARK_INFO LIMIT $start,$pagesize";
		$list = $this->select($sql);
		$data = array();
		foreach ($list as $key => $value)							//重新组合数组,添加新闻标题
		{
			foreach($value as $key_1 => $val)
			{
				$data[$key][$key_1] = $val;
				if($key_1 == 'F_ID_NEWS_INFO')					//判断是不是信息ID项
				{
					$r = $this->getInfo($val,"EE_NEWS_INFO");		//是则增加信息标题项
					$data[$key]['F_NDT_CAPTION'] = $r['F_NDT_CAPTION'];
				}
			}
		}
		return $data;
	}
	/**
	 * 功能：提取评论条数
	 * 返回：评论条数
	 */
	public function GetRemarkCount()
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_REMARK_INFO";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：删除评论信息
	 * 参数：$id 评论ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelComments($id)
	{
		$sql = "DELETE FROM EE_REMARK_INFO WHERE F_ID = $id";
		return $this->delete($sql);
	}
	/**
	 * 功能：提取常用连接列表
	 * 参数：$page 当前页码,$pagesize 每页提取数
	 * 返回：数组
	 */
	public function GetLinkList($page=1,$pagesize)
	{
		$start = ($page - 1) * $pagesize;
		$sql = "SELECT * FROM EM_LINK_INFO LIMIT $start,$pagesize";
		return $this->select($sql);
	}
	/**
	 * 功能：提取常用连接条数
	 * 返回：常用连接条数
	 */
	public function GetLinkCount()
	{
		$sql = "SELECT COUNT(F_ID) FROM EM_LINK_INFO";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：删除常用连接
	 * 参数：$id 常用连接ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelLink($id)
	{
		$sql = "DELETE FROM EM_LINK_INFO WHERE F_ID = $id";
		return $this->delete($sql);
	}
	/**
	 * 功能：恢复信息
	 * 参数：$id 信息ID
	 * 返回：TRUE OR FALSE
	 */
	public function ReloadNews($id)
	{
		$sql = "UPDATE EE_NEWS_DETAIL SET F_NDT_IS_DEL = 0 WHERE F_ID = $id";
		$this->update($sql);
	}
	/**
	 * 功能：生成首页页面
	 * 返回：1
	 */
	public function GenIndex()
	{
		$sql = "SELECT * FROM EM_INDEX_INFO";
		$info = $this->select($sql);
		$url = "../.." . $info['F_INDEX_TEMPLATE_URL'];
		$html = file_get_contents($url);
		$sql = "SELECT * FROM EE_TEMPLATE_INFO";
		$list = $this->select($sql);
		foreach($list as $l)										//循环替换首页模块
		{
			extract($l);
			$str = "[" . $F_TMP_NAME . "]";
			$html = str_replace($str,$F_TMP_CODE,$html);
		}
		$handle = fopen("../../{$info['F_INDEX_NAME']}","w");
		@fwrite($handle,$html);									//生成文件
		echo "<a href='../../{$info['F_INDEX_NAME']}' target='_blank'>../../{$info['F_INDEX_NAME']}</a>内容已刷新";
		return 1;
	}
	/**
	 * 功能：提取栏目条数
	 * 返回：栏目条数
	 */
	public function GetClassCount()
	{
		$sql = "SELECT COUNT(F_ID) FROM EM_CLASS_INFO";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：检测栏目名称是否重复
	 * 返回：TRUE OR FALSE
	 */
	public function CheckClassName($parent_id,$name) {
		$sql = "SELECT F_ID FROM EM_CLASS_INFO WHERE F_PARENT_ID = $parent_id AND F_CLASS_NAME = '$name'";
		$r = $this->select($sql);
		if($r[0][0]) {
			return true;
		} else {
			return false;
		}
	}
}
?>
