<?php
class Core_Upload
{	
	/**
	 * ���ܣ��ݹ鴴���ļ���
	 * ������$param �ļ�·��
	 */
	static public function mkdirsByPath($param){
		if(! file_exists($param)) {						//�жϸ��ļ��Ƿ����
			self::mkdirsByPath(dirname($param));			//�ݹ鴴��
			@mkdir($param);
		}
		return realpath($param);
	}
	/**
	 * ���ܣ������ϴ��ļ�
	 * ������$file_info �ϴ��ļ���Ϣ,$path �ϴ��ļ���,$max_file_size �ϴ��ļ��������
	 * ���أ�����
	 */
	static public function upload($file_info,$path,$max_file_size){
		extract($file_info);
		if ($size == 0){								//�ж��ϴ��ļ���С�Ƿ�Ϊ0
			$result[errcode] = "zero";
			return $result;
		}
		$a = pathinfo($name);
		$ext = strtolower($a['extension']);
		$result = array();
		if (substr($type,0,5) != 'image'){					//�ж��ϴ��ļ��Ƿ���ͼƬ
			$result[errcode] = "type_erro";
			return $result;
		}
		$size = $size / 1024;
		if ($size > $max_file_size){					//�ж��ϴ��ļ���С�Ƿ񳬹�����
			$result[errcode] = "size_erro";
			return $result;
		}
		$f_name = date("YmdHis") . "." . $ext;
		$sub_path = date("Ymd") . "/";
		$path = $path . $sub_path;
		$target = $path . $f_name;
		$i = 1;
		while(file_exists($target)){						//ѭ���ж��ļ��Ƿ��Ѵ���
			$f_name = date("YmdHis") . ($i++) . "." . $ext;
			$target = $path . $f_name;
		}
		if(!file_exists($target))						//�������򴴽�·��
			self::mkdirsByPath(dirname($target));
		$result['errcode'] = move_uploaded_file($tmp_name,$target);
		list($width,$height) = getimagesize("$path$f_name");
		$result['file_name'] = $sub_path . $f_name;
		$result['width'] = $width;
		$result['height'] = $height;
		$result['size'] = $size;
		$result['type'] = $type;
		return $result;
	}
}
?>
