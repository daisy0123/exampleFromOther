<?php
class Core_Upload
{	
	/**
	 * 功能：递归创建文件夹
	 * 参数：$param 文件路径
	 */
	static public function mkdirsByPath($param){
		if(! file_exists($param)) {						//判断该文件是否存在
			self::mkdirsByPath(dirname($param));			//递归创建
			@mkdir($param);
		}
		return realpath($param);
	}
	/**
	 * 功能：处理上传文件
	 * 参数：$file_info 上传文件信息,$path 上传文件夹,$max_file_size 上传文件最大限制
	 * 返回：数组
	 */
	static public function upload($file_info,$path,$max_file_size){
		extract($file_info);
		if ($size == 0){								//判断上传文件大小是否为0
			$result[errcode] = "zero";
			return $result;
		}
		$a = pathinfo($name);
		$ext = strtolower($a['extension']);
		$result = array();
		if (substr($type,0,5) != 'image'){					//判断上传文件是否是图片
			$result[errcode] = "type_erro";
			return $result;
		}
		$size = $size / 1024;
		if ($size > $max_file_size){					//判断上传文件大小是否超过限制
			$result[errcode] = "size_erro";
			return $result;
		}
		$f_name = date("YmdHis") . "." . $ext;
		$sub_path = date("Ymd") . "/";
		$path = $path . $sub_path;
		$target = $path . $f_name;
		$i = 1;
		while(file_exists($target)){						//循环判断文件是否已存在
			$f_name = date("YmdHis") . ($i++) . "." . $ext;
			$target = $path . $f_name;
		}
		if(!file_exists($target))						//不存在则创建路径
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
