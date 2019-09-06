<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center> 留言搜索 </td>
  </tr>
<form method="post" name="search">
  <tr>
    <td class="tablerow">
	&nbsp;<a href="?mod=guestbook&file=guestbook&action=manage&keyid=<?=$keyid?>"><b>管理首页</b></a>&nbsp;
	<input name='passed' type='radio' value='1' onclick="location='?mod=guestbook&file=guestbook&action=manage&passed=1&keyid=<?=$keyid?>'" <? if($passed==1) { ?>checked<? } ?>><a href='?mod=guestbook&file=guestbook&action=manage&passed=1&keyid=<?=$keyid?>'>已审核的留言</a>&nbsp;<input name='passed' type='radio' value='0' onclick="location='?mod=guestbook&file=guestbook&action=manage&passed=0&keyid=<?=$keyid?>'" <? if(!$passed) { ?>checked<? } ?>><a href='?mod=guestbook&file=guestbook&action=manage&passed=0&keyid=<?=$keyid?>'>未审核的留言</a>&nbsp;<input name='keyid' type='hidden' value='<?=$keyid?>'>
	关键字：<input name='keyword' type='text' size='20' value='<?=$keyword?>'>&nbsp;
     <input type="radio" name="srchtype" value="0" <?if(!$srchtype){?>checked<?}?>> 标题 	
	<input type="radio" name="srchtype" value="1" <?if($srchtype==1){?>checked<?}?>> 内容	
	<input type="radio" name="srchtype" value="2" <?if($srchtype==2){?>checked<?}?>> 会员
	<input name='submit' type='submit' value='留言搜索'></td>
  </tr>
</form>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=9>留言管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="35" class="tablerowhighlight">选中</td>
<td width="80" class="tablerowhighlight">姓名</td>
<td class="tablerowhighlight">内容</td>
<td width="130" class="tablerowhighlight">发表时间</td>
<td width="40" class="tablerowhighlight">审核</td>
<td width="40" class="tablerowhighlight">回复</td>
<td width="130" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($guestbooks)) foreach($guestbooks AS $guestbook) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="gid[]"  id="gid[]" value="<?=$guestbook['gid']?>"></td>
<td align="center"><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($guestbook['username'])?>" target="_blank"><?=$guestbook['username']?></a></td>
<td align="left"><a href="<?=PHPCMS_PATH?>guestbook/?keyid=<?=$guestbook['keyid']?>&gid=<?=$guestbook['gid']?>" target="_blank"><?=$guestbook['title']?></a></td>
<td><?=$guestbook['addtime']?></td>
<td><? if($guestbook['passed']) { ?>√<? } else { ?><font color="red">×</font><? } ?></td>
<td><? if($guestbook['reply']) { ?>√<? } else { ?><font color="red">×</font><? } ?></td>
<td><a href='?mod=guestbook&file=guestbook&action=reply&gid=<?=$guestbook['gid']?>&keyid=<?=$keyid?>'>回复</a> | <a href='?mod=guestbook&file=guestbook&ip=<?=$guestbook['ip']?>&keyid=<?=$keyid?>' title="IP：<?=$guestbook['ip']?> - <?=$guestbook['gip']['country']?> 
点击查看来自该ip的所有留言"> IP </a> | <? if($guestbook['passed']) { ?><a href='?mod=guestbook&file=guestbook&action=pass&passed=0&gid=<?=$guestbook['gid']?>&keyid=<?=$keyid?>'>取消</a><? } else { ?><a href='?mod=guestbook&file=guestbook&action=pass&passed=1&gid=<?=$guestbook['gid']?>&keyid=<?=$keyid?>'>批准</a> <? } ?>| <a href='?mod=guestbook&file=guestbook&action=delete&gid=<?=$guestbook['gid']?>&keyid=<?=$keyid?>'>删除</a></td>
</tr>

<? } ?>

</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td>
        <input name='submit2' type='submit' value='批准选定的留言' onClick="document.myform.action='?mod=guestbook&file=guestbook&action=pass&passed=1&keyid=<?=$keyid?>&forward=<?=$forward?>'">&nbsp;&nbsp;
        <input name='submit3' type='submit' value='取消批准选定的留言' onClick="document.myform.action='?mod=guestbook&file=guestbook&action=pass&passed=0&keyid=<?=$keyid?>&forward=<?=$forward?>'">&nbsp;&nbsp;
		<input name="submit1" type="submit"  value="删除选定的留言" onClick="document.myform.action='?mod=guestbook&file=guestbook&action=delete&keyid=<?=$keyid?>&forward=<?=$forward?>'">&nbsp;&nbsp;
</td>
  </tr>
</table>
</form>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td height="20" align="center"><?=$pages?></td>
  </tr>
</table>

</body>
</html>