<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')							//判断是否是提交操作
{
	if($blog->BlogSet($blogid,$_POST))									//判断是否设置成功
	{
		echo "设置成功";
	}
}
$info = $blog->GetBlogInfo($blogid);
$list = $blog->GetSkinsList();
?>
<div class="wrap">
<FORM action="Index.php?Action=BlogSet" name="form1" method=post onsubmit=’return check();’>
  <TABLE width="80%">
  <TR vAlign=top>
    <TH width="16%">Blog 标题:</TH>
    <TD width="84%"><INPUT id=blogname value="<?php echo $info['F_BLOG_NAME']?>" name=blogname></TD></TR>
  <TR vAlign=top>
    <TH>Blog描述:</TH>
    <TD><textarea name="description" cols="50" rows="6"><?php echo $info['F_BLOG_DESCRIPTION']?></textarea></TD>
  </TR>
  <TR vAlign=top>
    <TH>Blog关键字:</TH>
    <TD><INPUT id=keyword size=40 value="<?php echo $info['F_BLOG_KEYWORDS']?>" name=keyword>
      （多个关键字之间用逗号隔开）</TD>
  </TR>
  <TR vAlign=top>
    <TH>Blog模板:</TH>
    <TD><select name="skins" id="skins">
<?php
foreach($list as $value)												//循环输出模板
{
	echo "<option value='" . $value['F_SKINS_FILE'] . "'";
	if($info['F_BLOG_DEFAULT_SKINS'] == $value['F_SKINS_FILE'])			//设置默认选项
	{
		echo " selected='selected'";
	}
	echo ">" . $value['F_SKINS_NAME'] . "</option>";
}
?>
    </select>
    </TD>
  </TR>
  <TR vAlign=top>
    <TH>评论状态:</TH>
    <TD>
    <?php 
    echo "<INPUT name=comment type=checkbox id=comment value=1";
    if($info['F_BLOG_PERM_COMMENTS'] == 1)							//判断Blog允许评论
    	echo " checked";
    echo ">";
    ?>
      允许评论</TD>
  </TR>
  <TR vAlign=top>
    <TH>Blog状态:</TH>
    <TD>    
    <?php 
    echo "<INPUT name=lock type=checkbox id=lock value=1";
    if($info['F_BLOG_IS_LOCKED'] == 1)								//判断Blog的状态是否锁定
    	echo " checked";
    echo ">";
    ?>
      锁定</TD>
  </TR>
  <TR vAlign=top>
    <TH scope=row>Blog密码:</TH>
    <TD><input name="password" type="password" id="password"></TD>
  </TR>
  <TR vAlign=top>
    <TH scope=row>确认密码:</TH>
    <TD><input name="confirm" type="password" id="confirm"></TD>
  </TR>
  </TABLE>
  <P><INPUT type=submit value="提交设置" name=Submit></P>
</FORM>
<script language="javascript">
function check()
{
	if(document.form1.blogname.value == '')								//判断名称是否为空
	{
		alert('请填写名称');											//为空则提示
		document.form1.blogname.focus();								//焦点定位到名称输入框
		return false;
	}
	
	if(!checkByteLength(document.form1.blogname.value,1,50))				//判断名称长度是否合法
	{
		alert('名称长度不正确，长度为1-50个字符'); 						//为空则提示
		document.form1.blogname.focus();								//焦点定位到名称输入框
		return false;
	}
	
	if(document.form1.description.value != '')								//判断描述是否为空
	{
		if(!checkByteLength(document.form1.description.value,1,200))			//不为空判断长度是否合法
		{
			alert('描述长度不正确，长度为1-200个字符');					//不合法则提示
			document.form1.description.focus();							//焦点定位到描述输入框
			return false;		
		}
	}
	if(document.form1.password.value != '')								//判断密码是否为空
	{
		if(!checkByteLength(document.form1.password.value,6,16))			//不为空则判断长度是否合法
		{
			alert('密码长度不正确，长度为6-16个字符');					//不合法则提示
			document.form1.password.focus();							//焦点定位到密码输入框
			return false;		
		}
		
		if(document.form1.password.value != document.form1.confirm.value)	//判断两次密码输入是否一致
		{
			alert('密码输入前后不一致');								//不一致则提示
			document.form1.password.focus();							//焦点定位到密码输入框
			return false;
		}
	}
	return true;
}
</script>
</div>