<?php require_once('../../config.inc.php'); ?>
<?php require_once('../Check.php');?>
<?php require_once (INCLUDE_PATH . 'News.inc.php'); ?>
<?php
$News = new News();
$img = array();
$img = $News->GetImgList($_GET['id']);
?>
<p align="center"><b>ͼƬ����</b></p>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#999999"><table width="100%" border="0" cellpadding="0" cellspacing="1">
        <tr align="center" bgcolor="#0066FF"> 
          <td width="29%" height="20"><strong><font color="#FFFFFF">Ԥ��ͼ</font></strong></td>
          <td width="30%" height="20"><strong><font color="#FFFFFF">����</font></strong></td>
          <td width="13%" height="20"><strong><font color="#FFFFFF">��С</font></strong></td>
          <td width="9%" height="20"><strong><font color="#FFFFFF">��ͼ</font></strong></td>
          <td width="19%" height="20"><strong><font color="#FFFFFF">����</font></strong></td>
        </tr>
<?php
foreach($img as $i){											//ѭ����ʾͼƬ
	extract($i);
	list($width,$height) = getimagesize("../.." . UPLOAD_DIR . $F_NIG_FILENAME);
	$default = ($F_NIG_DEFAULT) ? "��" : "��";
?>
        <tr align="center" valign="middle" bgcolor="#FFFFFF"> 
          <td><img src="<?php echo UPLOAD_DIR . $F_NIG_FILENAME?>" width="150" height="120"></td>
          <td><?php echo $F_NIG_CAPTION?></td>
          <td><?php echo $width . "*" . $height?></td>
          <td><?php echo $default?></td>
          <td><a href="DelPic.php?id=<?php echo $F_ID?>&NewsId=<?php echo $_GET['id']?>&MenuId=<?php echo $_GET['MenuId']?>" onClick="return confirm('���Ҫɾ����')">ɾ��</a></td>
        </tr>
<?php
}
?>
        <tr bgcolor="#0066FF"> 
          <td height="20" colspan="5">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<form action="Upload.php?id=<?php echo $_GET['id']?>&MenuId=<?php echo $_GET['MenuId']?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return check()">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td bgcolor="#999999"><table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr bgcolor="#0066FF"> 
            <td height="22" colspan="2">&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="27%" height="22" align="right">���⣺</td>
            <td width="73%" height="22"><input name="caption" type="text" id="caption" size="40"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="22" align="right">��ͼ��</td>
            <td height="22"><input type="radio" name="default" value="1">
              ��
              <input type="radio" name="default" value="0">
              �� </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="22" align="right">��ѡ��ͼƬ��</td>
            <td height="22"><input type="file" name="file"></td>
          </tr>
          <tr align="center"> 
            <td height="22" colspan="2" bgcolor="#0066FF"><input type="submit" name="Submit" value="�ϴ�ͼƬ"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<script language="JavaScript" type="text/JavaScript">
function check(){											//������Ϣ
	if($('file').value.trim() == ""){								//�ж��ϴ�ͼƬ�Ƿ�Ϊ��
		alert('��ѡ��ͼƬ')
		$('file').focus()
		return false
	}
return true
}
</script>
