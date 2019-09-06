<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>

<form name="myform" method="post" action="?mod=phpcms&file=province">

<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="4">省市管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">删除</td>
<td class="tablerowhighlight">序号</td>
<td class="tablerowhighlight">市/区</td>
<td class="tablerowhighlight">区/县</td>
</tr>
<?php 
	foreach($provinces as $id=>$province)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><input type="checkbox" name="delete[<?=$id?>]" value="1" /></td>
<td align="center"><?=$id?></td>
<td align="center"><input type="hidden" name="oldprovince[<?=$id?>]" value="<?=$province['province']?>" size="25"><input type="text" name="province[<?=$id?>]" value="<?=$province['province']?>" size="25"></td>
<td align="center"><a href="?mod=phpcms&file=city&province=<?=urlencode($province['province'])?>">市/区/县管理</a></td>
</tr>
<?php 
	}
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"></td>
<td align="center">增加：</td>
<td align="center"><input type="text" name="newprovince" size="25"></td>
<td align="center"><input type="hidden" name="newcountry" value="中华人民共和国"></td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="35%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input name="submit" type="submit"  value=" 更新省市信息 " />
	</td>
  </tr>
</table>
</form>

</body>
</html>