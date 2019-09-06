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
    <th colspan=5><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>"><font color="white">关联链接管理</font></a></th>
  </tr>
<form method="post" name='myform' action="?mod=<?=$mod?>&file=<?=$file?>&action=update&channelid=<?=$channelid?>&referer=<?=$referer?>">
<tr align="center">
<td width="50" class="tablerowhighlight">删除</td>
<td width="50" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">名称</td>
<td class="tablerowhighlight">地址</td>
<td width="100" class="tablerowhighlight">是否通过</td>
</tr>
<?php 
if(is_array($keylinks)){
	foreach($keylinks as $keylink){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input name='id[]' type='checkbox' id='id[]' value='<?=$keylink['linkid']?>'></td>
<td><?=$keylink['linkid']?></td>
<td align="left">&nbsp;<input size=25 name="linktext[<?=$keylink['linkid']?>]" type="text" value="<?=$keylink['linktext']?>"></td>
<td align="left">&nbsp;<input size=30 name="linkurl[<?=$keylink['linkid']?>]" type="text" value="<?=$keylink['linkurl']?>"></td>
<td align="left"><input name='passed[<?=$keylink['linkid']?>]' type='radio' value='1' <? if($keylink['passed']==1) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;<input name='passed[<?=$keylink['linkid']?>]' type='radio' value='0' <? if(!$keylink['passed']) { ?>checked<? } ?>> 否</td>
</tr>
<?php 
	}
}
?>
</table>


<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="center">
<input name='submit1' type='submit' value=' 删除选中链接 ' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;&nbsp;
<input type="submit" name="submit" value=" 更新链接信息 ">
</td>
</tr>
</table>
</form>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
<tr align="center">
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add&channelid=<?=$channelid?>&referer=<?=$referer?>">
<td class="tablerow">
名称：<input name='linktext' type='text' size='15' value=''>
地址：<input name='linkurl' type='text' size='20' value='http://'>
<input name='submit' type='submit' value='添 加'>
</td>
</form>
<form method="post" name="search">
<td class="tablerow">
关键字:<input name='key' type='text' size='18' value='<?=$key?>' title='提示:可以填写名称或者地址'>
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


</body>
</html>