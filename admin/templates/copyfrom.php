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
    <th colspan=7><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>"><font color="white">文章来源管理</font></a></th>
  </tr>
<form method="post" name='myform' action="?mod=<?=$mod?>&file=<?=$file?>&action=update&channelid=<?=$channelid?>&referer=<?=$referer?>">
<tr align="center">
<td width="50" class="tablerowhighlight">删除</td>
<td width="50" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">名称</td>
<td class="tablerowhighlight">地址</td>
<td width="80" class="tablerowhighlight">使用频率</td>
<td width="100" class="tablerowhighlight">点击访问</td>
<td width="80" class="tablerowhighlight">更新日期</td>
</tr>
<?php 
if(is_array($copyfroms)){
	foreach($copyfroms as $copyfrom){
?>
<tr align="center"  align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input name='id[]' type='checkbox' id='id[]' value='<?=$copyfrom['id']?>'></td>
<td><?=$copyfrom['id']?></td>
<td align="left">&nbsp;<input size=25 name="name[<?=$copyfrom['id']?>]" type="text" value="<?=$copyfrom['name']?>"></td>
<td align="left">&nbsp;<input size=30 name="url[<?=$copyfrom['id']?>]" type="text" value="<?=$copyfrom['url']?>"></td>
<td><input size=8 name="hits[<?=$copyfrom['id']?>]" type="text" value="<?=$copyfrom['hits']?>"></td>
<td align="left"><a href="<?=$copyfrom['url']?>" target="_blank"><?=$copyfrom['name']?></a></td>
<td><?=$copyfrom['updatetime']?></td>
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
<input name='submit1' type='submit' value=' 删除选中来源 ' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;&nbsp;
<input type="submit" name="submit" value=" 更新来源信息 ">
</td>
</tr>
</table>
</form>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
<tr align="center">
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=add&channelid=<?=$channelid?>&referer=<?=$referer?>">
<td class="tablerow">
名称：<input name='name' type='text' size='15' value=''>
地址：<input name='url' type='text' size='20' value='http://'>
<input name='submit' type='submit' value='添 加'>
</td>
</form>
<form method="post" name="search">
<td class="tablerow">
关键字:<input name='key' type='text' size='18' value='<?=$key?>' title='提示:可以填写名称或者地址'>
<select name="ordertype">
<option value="0" >结果排序方式</option>
<option value="1" >更新时间降序</option>
<option value="2" >更新时间升序</option>
<option value="3" >使用频率降序</option>
<option value="4" >使用频率升序</option>
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


</body>
</html>