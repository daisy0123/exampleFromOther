<link href="/Style/Index.css" rel="stylesheet" type="text/css">
<script language='javascript' src='/Js/Base.js'></script>
<script language='javascript' src='/Js/Date.js'></script>
<form name="form1" method="post" action="/Order/Redirect">
<table cellspacing="0" cellpadding="0" width="100%" border="0">
    <tr>
      <td><h4 class="bule">订单查询</h4></td>
    </tr>
    <tr>
      <td><p>
        <select id="start_y" name="start_y">
	  {*$date[Year]*}
	  </select>
        年
	    <select id="start_m" onChange="javascript:register_buildDay(this.value,'start_y','start_d');" name="start_m">
	  {*$date[Month]*}  		
	  </select>
	    月
	    <select id="start_d" name="start_d">
	  {*$date[Day]*} 
	  </select>
	    日
	  至
      <select id="end_y" name="end_y">
	  {*$date[Year]*}  
	  </select>
      年
      <select id="end_m" onChange="javascript:register_buildDay(this.value,'end_y','end_d');" name="end_m">
	  {*$date[Month]*}  
	  </select>
      月
      <select id="end_d" name="end_d">
	  {*$date[Day]*}
	  </select>
      日
        <input type="submit" value="查询" name="button" />
      </p>
      </td>
    </tr>
</table>
{*if $action=='Search' *}
<table width="100%" border="0">
  <tr>
    <td><p><p>查询结果：</p></p></td>
  </tr>
</table>
<table cellspacing="1" cellpadding="0" width="100%" align="center" 
      bgcolor="#003366" border="0">
  <tbody>
    <tr>
      <td class="STYLE3" valign="center" align="middle" width="15%" 
          bgcolor="#ddf3ff" height="25">时间</td>
      <td class="STYLE3" valign="center" align="middle" width="25%" 
          bgcolor="#ddf3ff" height="25">联系地址</td>
      <td class="STYLE3" valign="center" align="middle" width="16%" 
          bgcolor="#ddf3ff">邮政编码</td>
      <td class="STYLE3" valign="center" align="middle" width="20%" 
          bgcolor="#ddf3ff">联系电话</td>
      <td class="STYLE3" valign="center" align="middle" width="11%" 
          bgcolor="#ddf3ff">状态</td>
      <td class="STYLE3" valign="center" align="middle" width="13%" 
          bgcolor="#ddf3ff">操作</td>
    </tr>
	{*foreach item=uu from=$list[data]*}
    <tr>
      <td valign="center" bgcolor="#FFFFFF">{*$uu[F_ORDER_TIME]|date:'Y-m-d'*}</td>
      <td bgcolor="#FFFFFF">{*$uu[F_ORDER_ADDRESS]*}</td>
      <td bgcolor="#FFFFFF">{*$uu[F_ORDER_ZIPCODE]*}</td>
      <td bgcolor="#FFFFFF">{*$uu[F_ORDER_PHONE]*}</td>
      <td bgcolor="#FFFFFF">{*if $uu[F_ORDER_STATUS] == 1*}
		已处理
		{*else*}
		未处理{*/if*}</td>
      <td bgcolor="#FFFFFF"><a href="/Order/List/Id/{*$uu[F_ID]*}" target="_blank">[查看详情]</a></td>
    </tr>
	{*/foreach*}
  </tbody>
</table>
<table width="100%" border="0">
  <tr>
    <td>{*$list[JumpBar]*}</td>
  </tr>
</table>
{*/if*}
</form>
