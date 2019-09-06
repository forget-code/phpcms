<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
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
	if($('#var_<?=$varname?>').val()=='')
	{
		alert('<?=$var?> 的值不能为空！');
		$('#var_<?=$varname?>').focus();
		return false;
	}
<?php } ?>
	return true;
}
</script>

<body>
<form name="myform" method="get" action="?" onSubmit="javascript:return doCheck();">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>{tag_<?=$tagname?>} 标签变量赋值</caption>
  <tr>
    <th width="30%"><strong>变量名</strong></th>
    <td width="60%">变量值</td>
  </tr>
 <input type="hidden" name="tagname" value="<?=$tagname?>">
 <input type="hidden" name="mod" value="<?=$mod?>">
 <input type="hidden" name="file" value="<?=$file?>">
 <input type="hidden" name="action" value="<?=$action?>">
 <input name="ajax" type="hidden" value="<?=$ajax?>">
<?php 
foreach($vars as $k=>$var)
{
	$varname = str_replace('$','',$var);
	$varname = str_replace("'",'',$varname);
?>
<tr>
    <th><strong><?=$var?>：</strong></th>
    <td><input type="text" name="<?=$varname?>" id="var_<?=$varname?>" size="20"></td>
  </tr>
<?php
}
?>
<tr>
<th></th>
<td><input type="submit" name="dosubmit" value=" 预览 ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="返回上一步" onClick="javascript:history.back();"></td>
</tr>
</table>
</form>
<br/>
<table cellpadding="0" cellspacing="1" class="table_info" >
  <caption>提示信息</caption>
  <tr>
    <td>
如果标签中存在变量，预览的时候必须先给这些变量赋值才能预览，可以根据实际情况临时赋值。<p>
<font color="red">常用标签变量：</font><br />
<font color="blue">$mod</font> ：一般用来表示模型ID （0 表示不限模型）<br />
<font color="blue">$catid</font> ：一般用来表示栏目ID （0 表示不限栏目）<br />
<font color="blue">$specialid</font> ：一般用来表示专题ID （0 表示不限专题）<br />
<font color="blue">$typeid</font> ：一般用来表示类别ID （0 表示不限类别）<br />
<font color="blue">$page</font> ：一般用来表示页数 （1 表示第一页）<br />
	</td>
  </tr>
</table>
</body>
</html>