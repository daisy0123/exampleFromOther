<?php
session_start();
require_once('config.inc.php');
require_once(INCLUDE_PATH . 'chat.inc.php');
$chat = new Chat();
if(!$_SESSION['UserId']) {
	header('Location:./Login.php');
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>聊天室</title>
<link type="text/css" rel="stylesheet" href="/style/style.css">
<script language="javascript" src="./js/Ajax.js"></script>
<script language="javascript" src="./js/Base.js"></script>
<style type="text/css">
#Layer1 {
	display:none;
	position:absolute;
	width:318px;
	height:auto !important;
	height:76px;
	min-height:76px;
	z-index:1;
	left: 358px;
	top: 413px;
	border:1px #0000FF solid;
	background-color:#FFFFFF;
}
</style>
</head>

<body leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<table width="1080" border="0">
  <tr>
    <td width="190" valign="top" bgcolor="#000000">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="22" background="images/top.jpg"><div style="padding-left:40px;color:#FFFFFF;">聊天室成员</div></td>
  </tr>
  <tr>
    <td height="20" bgcolor="B5C6CD">&nbsp;昵称</td>
  </tr>
  <tr>
    <td height="440" valign="top" bgcolor="ECFDFF"><iframe name="info" id="info" height="440" width="100%" scrolling="no" src="UserList.html" style="border:0px;margin:0px;" frameborder="0"></iframe></td>
  </tr>
</table>
	</td>
    <td width="890"><form id="frm_write" name="frm_write" method="post" action="">
      <table width="872" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><iframe name="info" id="info" height="380" width="100%" scrolling="no" src="GetMsg.html" style="border:0px;margin:0px;" frameborder="0"></iframe></td>
        </tr>
        <tr>
          <td height="32" colspan="2" background="images/bg.jpg">　
		    <select name="name" id="name">
              <option value="0">所有人</option>
            </select>
            &nbsp;
            <select   onchange="if(this.options[this.selectedIndex].value!=''){showcolor(this.options[this.selectedIndex].value);this.options[0].selected=true;}else {this.selectedIndex=0;}" name="color">
        <option 
        style="COLOR: #6495ed; BACKGROUND-COLOR: #6495ed" value="#6495ED" 
        selected="selected">#6495ED</option>
              <option 
        style="COLOR: #fff8dc; BACKGROUND-COLOR: #fff8dc" 
        value="#FFF8DC">#FFF8DC</option>
              <option 
        style="COLOR: #dc143c; BACKGROUND-COLOR: #dc143c" 
        value="#DC143C">#DC143C</option>
              <option 
        style="COLOR: #00ffff; BACKGROUND-COLOR: #00ffff" 
        value="#00FFFF">#00FFFF</option>
              <option 
        style="COLOR: #00008b; BACKGROUND-COLOR: #00008b" 
        value="#00008B">#00008B</option>
              <option 
        style="COLOR: #008b8b; BACKGROUND-COLOR: #008b8b" 
        value="#008B8B">#008B8B</option>
              <option 
        style="COLOR: #b8860b; BACKGROUND-COLOR: #b8860b" 
        value="#B8860B">#B8860B</option>
              <option 
        style="COLOR: #a9a9a9; BACKGROUND-COLOR: #a9a9a9" 
        value="#A9A9A9">#A9A9A9</option>
              <option 
        style="COLOR: #006400; BACKGROUND-COLOR: #006400" 
        value="#006400">#006400</option>
              <option 
        style="COLOR: #bdb76b; BACKGROUND-COLOR: #bdb76b" 
        value="#BDB76B">#BDB76B</option>
            </select>
            &nbsp;<a href="#" onclick="javascript:document.getElementById('Layer1').style.display = 'block';" ><img src="images/3.jpg" alt="表情" /></a>
            &nbsp;	
<select name="opt" id="opt" onchange="if(this.options[this.selectedIndex].value!= 0){
if(this.options[this.selectedIndex].value == 4) { 
	Do(this.options[this.selectedIndex].value, 0);
	this.options[0].selected=true;
}
if(document.frm_write.name.options[document.frm_write.name.selectedIndex].value != 0) { Do(this.options[this.selectedIndex].value, document.frm_write.name.options[document.frm_write.name.selectedIndex].value);
this.options[0].selected=true;
} else {
	this.selectedIndex=0;
}
}">	
              <option value="0">常用功能</option>
              <option value="1">屏蔽发言</option>
              <option value="2">解除屏蔽</option>
			  <?php
			  if($chat->CheckIsAdmin($_SESSION['UserId'])) {
			  ?>
              <option value="3">踢人</option>
			  <?php
			  }
			  ?>
			<option value="4">查看聊天记录</option>
            </select>
            <div id="Layer1">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <?php
			for($i = 0;$i <= 95;$i++)							//循环显示表情图片
			{
				if($i % 16 == 0)								//每16个一行
				{
			?>
                <tr>
              <?php
				}
			?>
                  <td><a href="#" onclick="javascript:showface('images/face/<?php echo $i?>.gif');"><img src="images/face/<?php echo $i?>.gif" width="20" height="20" /></a>				</td>
              <?php
				if($i % 16 == 15)
				{
			?>
                </tr>
              <?php
				}
			}
			?>
              </table>
            </div></td>
        </tr>
        <tr>
          <td  span="2" height="46"><textarea name="content" cols="110" id="content" style="border:1px;height:46px;"></textarea>
            <a href="#" onclick="javascript:AddMsg();"><img src="images/send.jpg" width="40" height="38" /> </a></td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
</table>
</body>
</html>