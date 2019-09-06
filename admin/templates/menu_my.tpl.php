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
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="8">常用操作管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight" width="6%">删除</td>
<td class="tablerowhighlight" width="8%">排序</td>
<td class="tablerowhighlight" width="30%">名称</td>
<td class="tablerowhighlight" width="41%">链接</td>
<td class="tablerowhighlight" width="15%">打开窗口</td>
</tr>
<?php 
	foreach($menus as $id=>$menu)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><input type="checkbox" name="delete[<?=$id?>]" id="menuid<?=$id?>" value="1" /></td>
<td align="center"><input type="text" name="listorder[<?=$id?>]" value="<?=$menu['listorder']?>" size="3"></td>
<td align="center"><input type="text" name="name[<?=$id?>]" value="<?=$menu['name']?>" size="10" style="width:100px;<?=$menu['style']?>"> <?=style_edit("style[".$id."]", $menu['style'])?></td>
<td align="center"><input type="text" name="url[<?=$id?>]" value="<?=$menu['url']?>" size="50"></td>
<td align="center"><?=target_select('target['.$id.']', $menu['target'])?></td>
</tr>
<?php 
	}
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"></td>
<td align="center"><input type="text" name="newlistorder" value="<?=$newlistorder?>" size="3"></td>
<td align="center"><input type="text" name="newname" value="<?=$newname?>" size="10" style="width:100px;"> <?=style_edit("newstyle", $newstyle)?></td>
<td align="center"><input type="text" name="newurl" value="<?=$newurl?>" size="50"></td>
<td align="center"><?=target_select('newtarget', $newtarget)?></td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input name="dosubmit" type="submit" value=" 更新常用操作 " />
	</td>
  </tr>
</table>
</form>

</body>
</html>