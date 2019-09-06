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

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=5><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage"><font color="white">字符过滤管理</font></a></th>
  </tr>
<form method="post" name='myform' action="?mod=<?=$mod?>&file=<?=$file?>&action=update">
<input type="hidden" name="referer" value="<?=$referer?>">
<tr align="center">
<td width="50" class="tablerowhighlight">删除</td>
<td width="50" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">过滤文字</td>
<td class="tablerowhighlight">替换文字</td>
<td width="100" class="tablerowhighlight">是否启用</td>
</tr>
<?php 
if(is_array($rewords)){
	foreach($rewords as $reword){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input name='rid[]' type='checkbox' id='rid[]' value='<?=$reword['rid']?>'></td>
<td><?=$reword['rid']?></td>
<td align="left">&nbsp;<input size=25 name="word[<?=$reword['rid']?>]" type="text" value="<?=$reword['word']?>"></td>
<td align="left">&nbsp;<input size=30 name="replacement[<?=$reword['rid']?>]" type="text" value="<?=$reword['replacement']?>"></td>
<td align="left"><input name='passed[<?=$reword['rid']?>]' type='radio' value='1' <? if($reword['passed']==1) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;<input name='passed[<?=$reword['rid']?>]' type='radio' value='0' <? if(!$reword['passed']) { ?>checked<? } ?>> 否</td>
</tr>
<?php 
	}
}
?>
</table>


<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="center">
<input type="submit" name="submit" value=" 更新文字信息 ">
<input name='submit1' type='submit' value=' 删除选中文字 ' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'" >&nbsp;&nbsp;
<font color='red'>Tips:</font><font color='blue'>此功能要在相应模块设置里开启后方可使用</font>
</td>
</tr>
</table>
</form>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
<tr align="center">
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add">
<input type="hidden" name="referer" value="<?=$referer?>">
<td class="tablerow">
过滤文字：<input name='word' type='text' size='15' value=''>
替换文字：<input name='replacement' type='text' size='20' value=''> <font color='red'>Tips:</font>若直接过滤请留空替换文字
<input name='submit' type='submit' value='添 加'>
</td>
</form>
<form method="post" name="search">
<td class="tablerow">
关键字:<input name='keywords' type='text' size='18' value='<?=$keywords?>'>
<input name='submit' type='submit' value='搜 索'>
</td>
</form>
</tr>
</table>


<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>


</body>
</html>