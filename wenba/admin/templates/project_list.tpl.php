<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table width="100%" cellpadding="3" cellspacing="1" align="center" class="tableborder">
	<tr>
		<th colspan="7">会员头衔管理</th>
	</tr>
	<tr>
		<td width="4%" align="center" valign="middle" class="tablerowhighlight">选</td>
		<td width="10%" align="center" valign="middle" class="tablerowhighlight">ID</td>
		<td width="14%" align="center" valign="middle" class="tablerowhighlight">所属系列</td>
		<td width="10%" align="center" valign="middle" class="tablerowhighlight">等级</td>
		<td width="18%" align="center" valign="middle" class="tablerowhighlight">头衔名称</td>
		<td width="30%" align="center" valign="middle" class="tablerowhighlight">积分</td>
		<td width="15%" align="center" valign="middle" class="tablerowhighlight">管理操作</td>
	</tr>
		<form action="?mod=<?=$mod?>&file=<?=$file?>&action=delete" method="post">
<?php
	foreach ($actors as $actor) {
?>
		<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
		   <td align="center" valign="middle"><input type="checkbox" name="id[]"  id="id" value="<?=$actor['id']?>"></td>
			<td align="center" valign="middle"><?=$actor['id']?></td>
			<td align="center" valign="middle"><?=$TYPES[$actor['typeid']]?></td>
			<td align="center" valign="middle"><?=$actor['grade']?></td>
			<td align="center" valign="middle"><?=$actor['actor'];?></td>
			<td align="center" valign="middle"><?=$actor['min'];?>&nbsp;--&nbsp;<?=$actor['max']?></td>
			<td align="center" valign="middle"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&id=<?=$actor['id']?>&typeid=<?=$actor['typeid']?>">修改</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&id=<?=$actor['id']?>&typeid=<?=$actor['typeid']?>" onclick="return confirm('您确定要删除此项吗？')">删除</a>
			</td>
		</tr>
<?php
}
?>		
</tbody>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="100%" align="left" height="40" valign="middle" colspan="8"><input name='chkall' id="chkall" type='checkbox' onclick='checkall(this.form);' value='checkbox'>&nbsp;全部选中&nbsp;&nbsp;<input type="hidden" name="dosubmit" value="submitted">
		<input type="submit" name="dosubmit" value="删除选定" onclick="return confirm('您确定要删除吗？')"></td>
	</tr>
</table>
</form>
<div style="text-align:center"><?=$pages?></div>
</body>
</html>