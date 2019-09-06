<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<form action="" method="post" name="myform" >
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=7>询盘留言查看</th>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">内容</td>
<td width="50" class="tablerowhighlight">用户名</td>
<td class="tablerowhighlight">所在单位</td>
<td width="120" class="tablerowhighlight">询价时间</td>
<td width="50" class="tablerowhighlight">状态</td>
</tr>
<? if(is_array($guestbooks)) foreach($guestbooks AS $guestbook) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'  ondblclick="$('guestbook_<?=$guestbook['gid']; ?>').checked = ($('guestbook_<?=$guestbook['gid']; ?>').checked ? false : true);">

<td><input name="gid[]" type="checkbox" value="<?=$guestbook['gid']?>" id="guestbook_<?=$guestbook['gid']?>"></td>

<td><?=$guestbook['gid']?></td>
<td align="left"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&gid=<?=$guestbook['gid']?>"><?=$guestbook['content']?></a></td>

<td><?=$guestbook['username']?></td>

<td><?=$guestbook['unit']?></td>
<td><?=$guestbook['addtime']?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&gid=<?=$guestbook['gid']?>"><?php if($guestbook['status']) echo '已读'; else echo "<font color='#FF0000'>未查看</font>";?></a>
</td>
</tr>
<? } ?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1">
   <tr>
    <td width="100"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
		<input type='submit' value='删除留言' onClick="document.myform.action='?file=<?=$file?>&action=delete'">
</td>
  </tr>
</table>
</form>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
</form>
<br />
<table width="100%" cellpadding="0" cellspacing="0" class="tableborder">
<form method="get" name="search" action="?">
  <tr>
    <td height="30" class="tablerow" align="center">
	<input name='file' type='hidden' value='<?=$file?>'>
	<input name='action' type='hidden' value='<?=$action?>'>
	<input name='keywords' type='text' size='20' value='<?if(isset($keywords)){echo $keywords;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<select name="searchtype">
	<option value="username" <?if($searchtype=='username'){?>selected<?}?>>按用户名</option>
	<option value="content" <?if($searchtype=='content'){?>selected<?}?>>按内容</option>
	<option value="unit" <?if($searchtype=='unit'){?>selected<?}?>>按单位</option>
	</select>&nbsp;
	<input name='pagesize' type='text' size='3' value='<?if(isset($pagesize)){echo $pagesize;}?>' title="每页显示的数据数目,最大值为500" maxlength="3"> 条数据/页
	<input type='submit' value=' 搜索 '></td>
  </tr>
</form>
</table>

</body>
</html>
