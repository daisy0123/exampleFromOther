<?php
class Temp extends DBSQL 
{
	public $code = array("[template_caption]" => "���±���","[template_keywords]" => "���¹ؼ���","[template_from]" => "������Դ",
					"[template_nav]" => "���µ�ǰλ��","[template_img]" => "����ͼƬURL","[template_f_caption]" => "���¸�����",
					"[template_class]" => "����������Ŀ����","[template_news_id]" => "����ID","[template_link]" => "����URL",
					"[template_other]" => "�����������","[template_page]" => "���·�ҳ","[template_submit_time]" => "���·���ʱ��",
					"[template_author]" => "��������","[template_content]" => "��������","[template_host]" => "������������",
					"[template_list]" => "��Ŀ�б�","[template_nav]" => "��Ŀ����","[template_page]" => "��Ŀ�б��ҳ");													//��������ѯѡ��
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * ���ܣ���ȡģ���б�
	 * ������$id ��ĿID
	 * ���أ�����
	 */
	public function GetTempList($id)
	{
		$sql = "SELECT * FROM EE_TEMPLATE_INFO WHERE F_ID_CLASS_INFO = $id";
		return $this->select($sql);
	}
		/**
	 * ���ܣ���ӱ༭ģ����Ϣ
	 * ������$id ģ����ϢID,$arr �ύ�ı���Ϣ
	 * ���أ�TRUE OR FALSE
	 */	
	public function AddTemplate($id=0,$arr)
	{
		extract($arr);
		$List = array();
		$where = "";
		if($recommend)									//�ж��Ƿ��Ƽ�,������Ϣ��ȡ����
			$where .= " AND F_NDT_IS_RECOMMEND = 1";
		if($hot)											//�ж��Ƿ��ȵ�,������Ϣ��ȡ����
			$where .= " AND F_NDT_IS_HOT = 1";
		if($new)											//�ж��Ƿ��Ѷ,������Ϣ��ȡ����
			$where .= " AND F_NDT_IS_NEW = 1";
		$sql = "SELECT * FROM EE_NEWS_DETAIL WHERE F_ID_CLASS_INFO = $news_class AND F_NDT_IS_CHECK = 1 AND F_NDT_IS_DEL = 0";
		$sql .= $where . " ORDER BY F_NDT_TIME LIMIT 0,$news_count";
		$List = $this->select($sql);							//��ȡ��Ϣ
		$class_info = $this->getInfo($class_id,"EM_CLASS_INFO");
		extract($class_info);
		if($way)											//�ж��Ƿ���HTML��ʽ
		{
			$str = "<table width='100%'  border='0' cellpadding='0' cellspacing='0'>";
			$width = (int)(100 / $news_row) . "%";
			$i = 1;
			if($branch == 0)								//�ж��Ƿ����
			{
				$str .= "<tr>";
				$count = ceil(count($List)/$news_row);
			}
			foreach($List as $key => $l)						//ѭ����ʾ��Ϣ
			{
				extract($l);
				if($type == 0)								//�ж��Ƿ���ͼƬ����
				{
					$sql = "SELECT * FROM EE_NEWS_IMG WHERE F_ID_NEWS_INFO = $F_ID and F_NIG_IS_DEFAULT = 1";
					$img = $this->select($sql);
				}
				if($branch == 1)							//�ж��Ƿ����
				{
					if($key % $news_row == 0)				//�ж��Ƿ����еĿ�ʼ
					{
						$str .= "<tr>";
					}
					$str .= "<td width='$width'>";
				}else{
					if($key % $count == 0)					//�ж��Ƿ����еĿ�ʼ
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
				if($i <= $con_count)							//�ж��Ƿ���ʾ��Ϣ����
				{
					$html = str_replace("[template_content]",$ndt_content,$html);
				}
				$ndt_submit_time = substr(date("Y-m-d H:i:s",$F_NDT_TIME),5,5);
				$html = str_replace("[template_submit_time]",$ndt_submit_time,$html);
				$html = str_replace("[template_class]",$class_info['F_CLASS_NAME'],$html);
				$str .= $html;
				if($branch == 1)							//�ж��Ƿ����
				{
					$str .= "</td>";
					if($key % $news_row == $news_row - 1)		//�ж��Ƿ��еĽ���
					{
						$str .= "</tr>";
					}
				}else{
					if($key % $count == $count - 1)				//�ж��Ƿ��н���
					{
						$str .= "</td>";
					}
				}
				$i++;
			}
			if($branch == 1)								//�ж��Ƿ����
			{
				if($key % $news_row < $news_row - 1)			//�ж��Ƿ��еĽ���
				{
					for(;$key % $news_row < $news_row - 1;$key++)
						$str .= "<td width='$width'>&nbsp;</td>";	//ѭ��������
					$str .= "</tr>"; 
				}
			}else{
				if($key % $count < $count - 1)					//�ж��Ƿ��еĽ���
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
			if($branch == 0)								//�ж��Ƿ����
			{
				echo "document.write(\"<tr>\")\n";
				$count = ceil(count($List)/$news_row);
			}
			foreach($List as $key => $l)						//ѭ����ʾ��Ϣ
			{
				extract($l);
				$html = "";
				if($type == 0)								//�ж��Ƿ���ͼƬ��Ϣ
				{
					$sql = "SELECT * FROM EE_NEWS_IMG WHERE F_ID_NEWS_INFO = $F_ID and F_NIG_IS_DEFAULT = 1";
					$img = $this->select($sql);
				}
				if($branch == 1)							//�ж��Ƿ����
				{
					if($key % $news_row == 0)				//�ж��Ƿ����еĿ�ʼ
					{
						$str .= "document.write(\"<tr>\");\n";
					}
					$str .= "document.write(\"<td width='$width'>\");\n";
				}else{
					if($key % $count == 0)					//�ж��Ƿ����еĿ�ʼ
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
				if($branch == 1)							//�ж��Ƿ����
				{
					$str .= "document.write(\"</td>\");\n";
					if($key % $news_row == $news_row - 1)		//�ж��Ƿ����еĽ���
					{
						$str .= "document.write(\"</tr>\");\n";
					}
				}else{
					if($key % $count == $count - 1)				//�ж��Ƿ����еĽ���
					{
						$str .= "document.write(\"</td>\");\n";
					}
				}
				$i++;
			}
			if($branch == 1)								//�ж��Ƿ����
			{
				if($key % $news_row < $news_row - 1)			//�ж��Ƿ��н���
				{
					for(;$key % $news_row < $news_row - 1;$key++)	//������
						$str .= "document.write(\"<td width='$width'>&nbsp;</td>\");\n";
					$str .= "document.write(\"</tr>\");\n"; 
				}
			}else{
				if($key % $count < $count - 1)					//�ж��Ƿ����еĽ���
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
		if($id > 0)											//�ж��Ƿ��Ǳ༭״̬
		{
			return $this->updateData("EE_TEMPLATE_INFO",$id,$data);
		}else{
			return $this->insertData("EE_TEMPLATE_INFO",$data);
		}
	}

}
?>
