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
<input type="hidden" name="keyid" value="<?=$keyid?>" />
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="9">附属分类管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">删除</td>
<td class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">排序</td>
<td class="tablerowhighlight">分类名称</td>
<td class="tablerowhighlight">样式</td>
<td class="tablerowhighlight">英文名</td>
<td class="tablerowhighlight">分类说明</td>
<td class="tablerowhighlight">item数</td>
<td class="tablerowhighlight">是否启用</td>
</tr>
<?php 
	foreach($types as $id=>$type)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'  <?if($type['disabled']) echo " style='color:#888888;'";?> title="单击√×启用或禁用该分类"> 
<td align="center"><input type="checkbox" name="delete[<?=$id?>]" id="typeid<?=$id?>" value="1" /></td>
<td align="center"><?=$id?></td>
<td align="center"><input type="text" name="listorder[<?=$id?>]" value="<?=$type['listorder']?>" size="3"></td>
<td align="center"><input type="text" name="name[<?=$id?>]" value="<?=$type['name']?>" size="16" style="width:150px;<?=$type['style']?>"></td>
<td align="center"><?=$type['style_edit']?></td>
<td align="center"><input type="text" name="type[<?=$id?>]" value="<?=$type['type']?>" size="12"></td>
<td align="center"><input type="text" name="introduce[<?=$id?>]" value="<?=$type['introduce']?>" size="25"></td>
<td align="center"><?=$type['items']?></td>
<td align="center">
<?php if($type['disabled']){ ?>
<a href="?mod=phpcms&file=type&action=disabled&keyid=<?=$keyid?>&typeid=<?=$id?>">×</a>
<?php } else { ?>
<a href="?mod=phpcms&file=type&action=disabled&keyid=<?=$keyid?>&typeid=<?=$id?>">√</a>
<?php } ?></td>
</tr>
<?php 
	}
?>
  <tr  bgcolor="#F1F3F5">
    <td colspan="10">&nbsp;
	</td>
  </tr>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center" colspan="2">增加：</td>
<td align="center"><input type="text" name="newlistorder" value="<?=$newlistorder?>" size="3"></td>
<td align="center"><input type="text" name="newname" size="16" style="width:150px;"></td>
<td align="center"><?=$style_edit?></td>
<td align="center"><input type="text" name="newtype" size="12"></td>
<td align="center"><input type="text" name="newintroduce" size="25"></td>
<td align="center"></td>
<td align="center">√</td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="35%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input name="dosubmit" type="submit" value=" 更新附属分类 " />
	</td>
  </tr>
</table>
</form>

</body>
</html>