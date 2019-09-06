<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript">
function doCheck()
{
<?php 
foreach($vars as $var)
{
	$varname = str_replace('$','',$var);
	$varname = str_replace("'",'',$varname);
?>
	if($F('var_<?=$varname?>')=='')
	{
		alert('<?=$var?> 的值不能为空！');
		$('var_<?=$varname?>').focus();
		return false;
	}
<?php } ?>
	return true;
}
</script>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<form name="myform" method="get" action="?" onsubmit="javascript:return doCheck();">
<?php 
foreach($hiddens as $k=>$v)
{
	echo "<input type='hidden' name='$k' value='$v'>\n";
}
?>
<table cellpadding="2" cellspacing="1" border="0" class="tableBorder">
  <tr>
    <th colspan=2>{tag_<?=$tagname?>} 标签变量赋值</th>
  </tr>
  <tr>
    <td align="right" class="tablerowhighlight" width="30%">变量名</td>
    <td align="left" class="tablerowhighlight" width="60%">变量值</td>
  </tr>
<?php 
foreach($vars as $var)
{
	$varname = str_replace('$','',$var);
	$varname = str_replace("'",'',$varname);
?>
  <tr>
    <td class="tablerow" align="right"><?=$var?>：</td>
    <td class="tablerow"><input type="text" name="<?=$varname?>" id="var_<?=$varname?>" size="20"></td>
  </tr>
<?php } ?>
<tr>
<td class="tablerow"></td>
<td class="tablerow"><input type="submit" name="dosubmit" value=" 预览 ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="返回上一步" onclick="javascript:history.back();"></td>
</tr>
</table>
</form>
<br/>
<table cellpadding="2" cellspacing="1" border="0" class="tableBorder" >
  <tr>
    <td class="submenu" align="center">提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
如果标签中存在变量，预览的时候必须先给这些变量赋值才能预览，可以根据实际情况临时赋值。<p>
<font color="red">常用标签变量：</font><br />
<font color="blue">$channelid</font> ：一般用来表示频道ID （不得为 0）<br />
<font color="blue">$catid</font> ：一般用来表示栏目ID （0 表示不限栏目）<br />
<font color="blue">$specialid</font> ：一般用来表示专题ID （0 表示不限专题）<br />
<font color="blue">$typeid</font> ：一般用来表示类别ID （0 表示不限类别）<br />
<font color="blue">$page</font> ：一般用来表示页数 （1 表示第一页）<br />
	</td>
  </tr>
</table>
</body>
</html>