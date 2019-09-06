<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<form name="myform" method="post" action="?mod=<?=$mod?>&file=department">

<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="8">部门管理</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">删除</td>
<td width="4%" class="tablerowhighlight">ID</td>
<td width="6%" class="tablerowhighlight">排序</td>
<td width="15%" class="tablerowhighlight">部门名称</td>
<td width="8%" class="tablerowhighlight">提问点数</td>
<td width="42%" class="tablerowhighlight">提问会员组</td>
<td width="15%" class="tablerowhighlight">管理员</td>
<td width="5%" class="tablerowhighlight">操作</td>
</tr>
<?php 
	foreach($departments as $id=>$department)
	{ 
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="delete[<?=$id?>]" value="1" /></td>
<td><?=$id?></td>
<td><input type="text" name="listorder[<?=$id?>]" value="<?=$department['listorder']?>" size="3"></td>
<td><input type="text" name="department[<?=$id?>]" value="<?=$department['department']?>" size="15"></td>
<td><input type="text" name="point[<?=$id?>]" value="<?=$department['point']?>" size="4"></td>
<td><?=$department['arrgroupname']?></td>
<td><?=$department['admin']?></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&departmentid=<?=$id?>">修改</a></td>
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
	<input name="dosubmit" type="submit"  value=" 更新设置 " />
	</td>
  </tr>
</table>
</form>

</body>
</html>