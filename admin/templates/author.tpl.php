<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>

<?php if($select) { ?>
	<table cellpadding="2" cellspacing="1" class="tableborder">
	  <tr>
		<th colspan=6>常用作者列表</th>
	  </tr>
	
	<tr align="center">
	<td width="50" class="tablerowhighlight">ID</td>
	<td class="tablerowhighlight">作者</td>
	<td width="80" class="tablerowhighlight">作品数量</td>
	<td width="80" class="tablerowhighlight">更新日期</td>
	</tr>
	<?php 
	if(is_array($authors)){
		foreach($authors as $author){
	?>
	<tr align="center" align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' onclick="window.returnValue='<?=$author['name']?>';window.close();" height="22" style="cursor:pointer">
	<td><?=$author['id']?></td>
	<td align="left">&nbsp;&nbsp;<?=$author['name']?></td>
	<td><?=$author['items']?></td>
	<td><?=$author['updatetime']?></td>
	</tr>
	<?php 
		}
	}
	?>
	</table>
<?php } else { ?>
	<table cellpadding="2" cellspacing="1" class="tableborder">
	  <tr>
		<th colspan=6><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&keyid=<?=$keyid?>"><font color="white">作者管理</font></a></th>
	  </tr>
	<form method="post" name='myform' action="?mod=<?=$mod?>&file=<?=$file?>&action=update&keyid=<?=$keyid?>">
	<input type="hidden" name="referer" value="<?=$referer?>">
	<tr align="center">
	<td width="50" class="tablerowhighlight">删除</td>
	<td width="50" class="tablerowhighlight">ID</td>
	<td class="tablerowhighlight">作者</td>
	<td class="tablerowhighlight">备注</td>
	<td width="80" class="tablerowhighlight">作品数量</td>
	<td width="80" class="tablerowhighlight">更新日期</td>
	</tr>
	<?php 
	if(is_array($authors)){
		foreach($authors as $author){
	?>
	<tr align="center"  align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
	<td><input name='id[]' type='checkbox' id='id[]' value='<?=$author['id']?>'></td>
	<td><?=$author['id']?></td>
	<td align="left">&nbsp;&nbsp;<input size=20 name="name[<?=$author['id']?>]" type="text" value="<?=$author['name']?>"></td>
	<td align="left">&nbsp;&nbsp;<input size=50 name="note[<?=$author['id']?>]" type="text" value="<?=$author['note']?>"></td>
	<td title="提示:修改作品数量可以使作者在文章添加时靠前显示!"><input size=8 name="items[<?=$author['id']?>]" type="text" value="<?=$author['items']?>"></td>
	<td><?=$author['updatetime']?></td>
	</tr>
	<?php 
		}
	}
	?>
	</table>

	<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="175"  align="center">
	<input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中
	</td>
	<td>&nbsp;&nbsp;
	<input name='submit1' type='submit' value=' 删除选中作者 ' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&keyid=<?=$keyid?>'" >&nbsp;&nbsp;
	<input type="submit" name="submit" value=" 更新作者信息 ">
	</td>
	</tr>
	</table>
	</form>

	<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
	<tr align="center">
	<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add&keyid=<?=$keyid?>">
	<td class="tablerow">
	<input type="hidden" name="referer" value="<?=$referer?>">
	作者：<input name='author' type='text' size='20' value=''>&nbsp;
	备注：<input name='note' type='text' size='20' value=''>&nbsp;
	<input name='submit' type='submit' value='添 加'>
	</td>
	</form>
	<form method="post" name="search">
	<td class="tablerow">
	作者：<input name='key' type='text' size='20' value='<?=$key?>'>&nbsp;
	<select name="ordertype">
	<option value="0" >结果排序方式</option>
	<option value="1" >更新时间降序</option>
	<option value="2" >更新时间升序</option>
	<option value="3" >作品数量降序</option>
	<option value="4" >作品数量升序</option>
	</select>
	<input name='submit' type='submit' value='搜 索'>
	</td>
	</form>
	</tr>
	</table>

	<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td align=center><?=$pages?></td>
	  </tr>
	</table>
<?php } ?>
</body>
</html>