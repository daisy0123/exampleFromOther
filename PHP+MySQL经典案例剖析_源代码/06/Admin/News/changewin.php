<HTML>
<HEAD>
<TITLE>后台管理</TITLE>
<META content="text/html; charset=gb2312" http-equiv=content-type>
<STYLE type=text/css>
.point {
	BACKGROUND-COLOR: #dddddd; COLOR: #000000; CURSOR: hand; FONT-FAMILY: Webdings; FONT-SIZE: 12px; POSITION: absolute
}
</STYLE>
<SCRIPT language=javascript>
/**
 * 功能：隐藏或显示做导航条
 */
function changeWin(){
	if(parent.forum.cols!="10,*")										//判断是否已经隐藏
	{															//不是则隐藏
		parent.forum.cols="10,*";
		document.all.menuSwitch.innerHTML="<font class=point>4</font>";
	}else	
	{															//是则显示
		parent.forum.cols="170,*";
		document.all.menuSwitch.innerHTML="<font class=point>3</font>";
	}
}
</SCRIPT>
</HEAD>
<BODY leftMargin=0 topMargin=0 marginwidth="0" marginheight="0">
<TABLE border=0 cellPadding=0 cellSpacing=0 height="100%" width="100%">
  <TBODY>
  <TR>
    <TD width="100%" height=400><IFRAME frameBorder=0 src="ClassList.php?Type=<?php echo $_GET[Type]?>&MenuId=<?php echo $_GET[MenuId]?>" 
      style="HEIGHT: 100%; VISIBILITY: inherit; WIDTH: 100%"></IFRAME></TD>
    <TD bgColor=#aaaaaa><IMG height=1 src="images/doc.gif" 
width=1></TD>
    <TD bgColor=#dddddd>
      <TABLE border=0 cellPadding=0 cellSpacing=0 height="100%" width="100%">
        <TBODY>
        <TR>
          <TD height=1 onclick=changeWin()><IMG height=1 
            src="images/dot.gif" width=10></TD></TR>
        <TR>
          <TD height="100%" id=menuSwitch onclick=changeWin()><FONT 
            class=point>3</FONT>
          </TD>
        </TR>
    	</TBODY>
      </TABLE>
    </TD>
  </TR>
</TBODY>
</TABLE>
</BODY>
</HTML>
