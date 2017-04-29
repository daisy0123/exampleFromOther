<?php
require_once("config.inc.php");
require_once(INCLUDE_PATH . "Chat.inc.php");
session_start();
$chat = new Chat();
if($_SERVER['REQUEST_METHOD'] == 'POST')					//判断是否提交登陆信息
{
	if($id=$chat->CheckUser($_POST['name'],$_POST['pwd']))			//验证用户登陆信息
	{
		$_SESSION['UserId'] = $id;
		$_SESSION['Nick'] = $_POST['name'];
		header("Location:Index.php");							//转向聊天室页面
		exit();
	}else{
		$msg = "用户名或密码错误！";							//显示提示信息
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>聊天室</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
</head>
<body>
<form name="form1" id="form1" method="post" action="">
<table width="722" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><img src="/images/index_r2_c2.jpg" width="722" height="12" /></td>
      </tr>
      <tr>
        <td background="/images/index_r3_c2.jpg" height="230">&nbsp;       
        </td>
      </tr>
      <tr>
        <td>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
              <td width="14"><img src="/images/index_r4_c2.jpg" width="14" height="62" /></td>
              <td width="220" align="center"><table width="148" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="59"><img src="/images/index_r6_c4.jpg" width="59" height="45" /></td>
                  <td width="89%"><table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left">用户名称：</td>
                    </tr>
                    <tr>
                      <td>
					  <input id="name" maxlength="20" name="name" 

onmouseover="this.style.background='#ffffff';" 
                              style="BORDER-RIGHT: #f7f7f7 0px solid; BORDER-TOP: #f7f7f7 0px solid; FONT-SIZE: 9pt; BORDER

-LEFT: #f7f7f7 0px solid; WIDTH: 110px; BORDER-BOTTOM: #c0c0c0 1px solid; HEIGHT: 16px; BACKGROUND-COLOR: #f7f7f7" 
                              onfocus="this.select(); " 
                              onmouseout="this.style.background='#F7F7F7'" />					  </td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
              <td width="220" align="center"><table width="148" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50"><img src="/images/index_r6_c8.jpg" width="50" height="51" /></td>
                  <td width="89%"><table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left">用户密码：</td>
                      </tr>
                      <tr>
                        <td>
						<input id="pwd" type="password" maxlength="20" name="pwd" 

onmouseover="this.style.background='#ffffff';" 
                              style="BORDER-RIGHT: #f7f7f7 0px solid; BORDER-TOP: #f7f7f7 0px solid; FONT-SIZE: 9pt; BORDER

-LEFT: #f7f7f7 0px solid; WIDTH: 110px; BORDER-BOTTOM: #c0c0c0 1px solid; HEIGHT: 16px; BACKGROUND-COLOR: #f7f7f7" 
                              onfocus="this.select(); " 
                              onmouseout="this.style.background='#F7F7F7'" />						

</td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
              <td width="250"><div align="left" style="float:left;width:60px;">
                <input type="image" name="imageField2" src="/images/login.gif" />
              </div>
			  <div align="left" style="float:left;width:60px;">
                  <a href="register.html"><img src="/images/register.gif" width="40" height="38" /></a>                

</div>
                <table width="115" border="0" align="right" cellpadding="0" cellspacing="0">
                <tr>
                  <td><font color="Red"><?php echo $msg?></font></td>
                </tr>
              </table>
</td>
              <td width="18"><img src="/images/index_r4_c14.jpg" width="18" height="62" /></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td><img src="/images/index_r9_c2.jpg" width="722" height="13" /></td>
      </tr>
    </table>
</form>
</body>
</html>