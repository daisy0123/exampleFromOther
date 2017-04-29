<?php                                       
define("UserName", "root");								//数据库连接用户名
define("PassWord", "123456");								//数据库连接密码
define("ServerName", "localhost");							//数据库服务器的名称
define("DBName","blog");									//数据库名称
define("ERRFILE","err.php");								//错误处理显示文件
define("ROOT_PATH",dirname(__FILE__) . '/');					//根目录路径
define("INCLUDE_PATH",ROOT_PATH . "include/");			//包含文件路径
define("UPLOAD_PATH",ROOT_PATH . "upload/");				//上传文件路径
define("UPLOAD_DIR","/upload/");				//上传文件查看路径
define("TEMPLATE_PATH","skins/");			//模板路径
define("MAX_UPLOAD_SIZE","200")						//上传文件大小
?>
