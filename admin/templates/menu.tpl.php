<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
  <tr>
    <td class='pagemenu'>按菜单位置浏览：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage" class="pagelink">全部</a>
<?php 
foreach($POSITION as $k=>$v)
{
	echo ' | <a href="?mod='.$mod.'&file='.$file.'&action=manage&position='.$k.'" class="pagelink">'.$v.'</a>';
}
?>
	
	</td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="8">导航菜单管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight" width="6%">删除</td>
<td class="tablerowhighlight" width="6%">ID</td>
<td class="tablerowhighlight" width="8%">排序</td>
<td class="tablerowhighlight" width="12%">名称</td>
<td class="tablerowhighlight" width="35%">链接</td>
<td class="tablerowhighlight" width="13%">打开窗口</td>
<td class="tablerowhighlight" width="15%">位置</td>
<td class="tablerowhighlight" width="5%">操作</td>
</tr>
<?php 
	foreach($menus as $id=>$menu)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><input type="checkbox" name="delete[<?=$id?>]" id="menuid<?=$id?>" value="1" /></td>
<td align="center"><?=$id?></td>
<td align="center"><input type="text" name="listorder[<?=$id?>]" value="<?=$menu['listorder']?>" size="3"></td>
<td align="center"><input type="text" name="name[<?=$id?>]" value="<?=$menu['name']?>" size="10" style="width:80px;<?=$menu['style']?>"></td>
<td align="center"><input type="text" name="url[<?=$id?>]" value="<?=$menu['url']?>" size="35"></td>
<td align="center"><?=target_select('target['.$id.']', $menu['target'])?></td>
<td align="center"><?=$POSITION[$menu['position']]?></td>
<td align="center"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&menuid=<?=$menu['menuid']?>">修改</a></td>
</tr>
<?php 
	}
?>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input name="dosubmit" type="submit" value=" 更新导航菜单 " />
	</td>
  </tr>
</table>
</form>

</body>
</html>