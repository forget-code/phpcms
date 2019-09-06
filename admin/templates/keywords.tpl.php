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
		<th colspan=6>常用关键字列表</th>
	  </tr>
	
	<tr align="center">
	<td width="50" class="tablerowhighlight">ID</td>
	<td class="tablerowhighlight">关键字</td>
	<td width="80" class="tablerowhighlight">使用频率</td>
	<td width="80" class="tablerowhighlight">更新日期</td>
	</tr>
	<?php 
	if(is_array($keywords)){
		foreach($keywords as $keywords){
	?>
	<tr align="center" align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' onclick="window.returnValue='<?=$keywords['keywords']?>';window.close();" height="22" style="cursor:pointer">
	<td><?=$keywords['id']?></td>
	<td align="left">&nbsp;&nbsp;<?=$keywords['keywords']?></td>
	<td><?=$keywords['hits']?></td>
	<td><?=$keywords['updatetime']?></td>
	</tr>
	<?php 
		}
	}
	?>
	</table>



<?php } else { ?>

	<table cellpadding="2" cellspacing="1" class="tableborder">
	  <tr>
		<th colspan=6><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&keyid=<?=$keyid?>"><font color="white">关键字管理</font></a></th>
	  </tr>
	<form method="post" name='myform' action="?mod=<?=$mod?>&file=<?=$file?>&action=update&keyid=<?=$keyid?>">
	<input type="hidden" name="referer" value="<?=$referer?>">
	<tr align="center">
	<td width="50" class="tablerowhighlight">删除</td>
	<td width="50" class="tablerowhighlight">ID</td>
	<td class="tablerowhighlight">关键字</td>
	<td width="80" class="tablerowhighlight">使用频率</td>
	<td width="80" class="tablerowhighlight">更新日期</td>
	</tr>
	<?php 
	if(is_array($keywords)){
		foreach($keywords as $keywords){
	?>
	<tr align="center" align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
	<td><input name='id[]' type='checkbox' id='id[]' value='<?=$keywords['id']?>'></td>
	<td><?=$keywords['id']?></td>
	<td align="left">&nbsp;&nbsp;<input size=60 name="keywords[<?=$keywords['id']?>]" type="text" value="<?=$keywords['keywords']?>"></td>
	<td title="提示:修改使用频率可以使关键字在文章添加时靠前显示!"><input size=8 name="hits[<?=$keywords['id']?>]" type="text" value="<?=$keywords['hits']?>"></td>
	<td><?=$keywords['updatetime']?></td>
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
	<input name='submit1' type='submit' value=' 删除选中关键字 ' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&keyid=<?=$keyid?>'" >&nbsp;&nbsp;
	<input type="submit" name="submit" value=" 更新关键字信息 ">
	</td>
	</tr>
	</table>
	</form>

	<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
	<tr align="center">
	<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add&keyid=<?=$keyid?>">
	<td class="tablerow">
	<input type="hidden" name="referer" value="<?=$referer?>">
	关键字：<input name='keywords' type='text' size='20' value=''>&nbsp;
	<input name='submit' type='submit' value='关键字添加'>
	</td>
	</form>
	<form method="post" name="search">
	<td class="tablerow">
	关键字：<input name='key' type='text' size='20' value='<?=$key?>'>&nbsp;
	<select name="ordertype">
	<option value="0" >结果排序方式</option>
	<option value="1" >更新时间降序</option>
	<option value="2" >更新时间升序</option>
	<option value="3" >使用频率降序</option>
	<option value="4" >使用频率升序</option>
	</select>
	<input name='submit' type='submit' value='关键字搜索'>
	</td>
	</form>
	</tr>
	</table>


	<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td align="center"><?=$pages?></td>
	  </tr>
	</table>

<?php } ?>
</body>
</html>