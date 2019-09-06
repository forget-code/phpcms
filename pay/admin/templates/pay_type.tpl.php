<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">

<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="6">财务操作类型管理</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">删除</td>
<td class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">排序</td>
<td class="tablerowhighlight">操作名称</td>
<td class="tablerowhighlight">资金操作方式</td>
</tr>
<?php 
	foreach($types as $id=>$type)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><input type="checkbox" name="delete[<?=$id?>]" id="typeid<?=$id?>" value="1" /></td>
<td align="center"><?=$id?></td>
<td align="center"><input type="text" name="listorder[<?=$id?>]" value="<?=$type['listorder']?>" size="3"></td>
<td align="center"><input type="text" name="name[<?=$id?>]" value="<?=$type['name']?>" size="20"></td>
<td align="center">
<input type="radio" name="operation[<?=$id?>]" value="+" <?php if($type['operation'] == '+'){ ?>checked<?php } ?>> 入款&nbsp;&nbsp;
<input type="radio" name="operation[<?=$id?>]" value="-" <?php if($type['operation'] == '-'){ ?>checked<?php } ?>> 扣款&nbsp;&nbsp;
<input type="radio" name="operation[<?=$id?>]" value="" <?php if($type['operation'] == ''){ ?>checked<?php } ?>> 不变
</td>
</tr>
<?php 
	}
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"></td>
<td align="center">增加：</td>
<td align="center"><input type="text" name="newlistorder" value="<?=$newlistorder?>" size="3"></td>
<td align="center"><input type="text" name="newname" size="20"></td>
<td align="center">
<input type="radio" name="newoperation" value="+"> 入款&nbsp;&nbsp;
<input type="radio" name="newoperation" value="-"> 扣款&nbsp;&nbsp;
<input type="radio" name="newoperation" value="" checked> 不变
</td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input name="dosubmit" type="submit" value=" 更新财务操作类型 " />
	</td>
  </tr>
</table>
</form>

</body>
</html>