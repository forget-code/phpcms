<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="6">点数购买设置</th>
  </tr>
<tr align="center">
<td class="tablerowhighlight">删除</td>
<td class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">点数</td>
<td class="tablerowhighlight">价格</td>
</tr>
<?php 
	foreach($points as $id=>$point)
	{ 
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"><input type="checkbox" name="delete[<?=$id?>]" id="typeid<?=$id?>" value="1" /></td>
<td align="center"><?=$id?></td>
<td align="center"><input type="text" name="point[<?=$id?>]" value="<?=$point['point']?>" size="10"> 点</td>
<td align="center"><input type="text" name="price[<?=$id?>]" value="<?=$point['price']?>" size="10"> 元</td>
</tr>
<?php 
	}
?>
<tr align="left" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="center"></td>
<td align="center">增加：</td>
<td align="center"><input type="text" name="newpoint" size="10"> 点</td>
<td align="center"><input type="text" name="newprice" size="10"> 元</td>
</tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="15%">
	<input name='chkall' title="全部选中" type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox' /> 全选/不选
	</td>
	<td>
	<input name="dosubmit" type="submit" value=" 更新点数购买设置 " />
	</td>
  </tr>
</table>
</form>

</body>
</html>