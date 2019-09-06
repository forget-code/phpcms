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
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=4><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>"><font color="white">作者管理</font></a></th>
  </tr>


<tr align="center">
<td width="50" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight" width="200">头像</td>
<td class="tablerowhighlight">相关</td>
<td width="40" class="tablerowhighlight">管理</td>
</tr>
<?php 
if(is_array($authors)){
	foreach($authors as $author){
?>
<tr align="center"  align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><?=$author['id']?></td>
<td><img src="<?if($author['face']) { echo $author['face']; } else { echo $rootpath."images/nopic.gif"; } ?>"></td>
<td align="left" valign="top" style="line-height:180%;">
<b>作者姓名</b>:<?=$author['name']?>  <?if($author['elite']) { ?>&nbsp;<font color='red'>荐</font> <? } ?><br>
<b>文章数目</b>:<?=$author['articlenum']?><br>
<b>加入日期</b>:<?=$author['updatetime']?><br>
<b>所属栏目</b>:<?if($author['catid']){echo $_CAT[$author['catid']]['catname'];} else {echo '频道作者';}?><br>
<b>作者简介</b>:<?=$author['introduction']?>
</td>
<td valign="top">
<br>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&id=<?=$author['id']?>&catid=<?=$author['catid']?>&channelid=<?=$channelid?>">编辑</a><br><br>
<?if($author['elite']) { ?>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=elite&elite=0&id=<?=$author['id']?>&channelid=<?=$channelid?>" title="取消推荐">取消</a><br><br>
<? } else {?>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=elite&elite=1&id=<?=$author['id']?>&channelid=<?=$channelid?>">推荐</a><br><br>
<?}?>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&id=<?=$author['id']?>&channelid=<?=$channelid?>">删除</a></td>
</tr>
<?php 
	}
}
?>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
<tr align="center">
<form method="post" name="search">
<td class="tablerow">
关键字：<input name='key' type='text' size='20' value='<?=$key?>'>&nbsp;
<select name='catid'>
<option value='0'>所属栏目</option>
<?=$cat_option?>
</select>

<input type="checkbox" class="radio" name="elite" value="1" > 推荐作者&nbsp;
<input type="checkbox" class="radio" name="chan" value="1" > 频道作者&nbsp;

<select name="ordertype">
<option value="0" >结果排序方式</option>
<option value="1" >更新时间降序</option>
<option value="2" >更新时间升序</option>
<option value="3" >文章总数降序</option>
<option value="4" >文章总数升序</option>
</select>
<input name='submit' type='submit' value='作者搜索'>
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