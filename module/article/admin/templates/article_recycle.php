<?php include admintpl('header');?>
<?=$menu?>
<form method="post" name="myform">
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td>当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>">回收站管理</a>&gt;&gt;
	<?=$cat_pos?>
    <input name='status' type='radio' value='3' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=3&catid=<?=$catid?>'"  <?if($status==3){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=3&catid=<?=$catid?>">已通过 [<?=$num_3?>]</a>
	<input name='status' type='radio' value='1' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=1&catid=<?=$catid?>'" <?if($status==1){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=1&catid=<?=$catid?>">待审核 [<?=$num_1?>]</a>
	<input name='status' type='radio' value='0' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=0&catid=<?=$catid?>'" <?if($status==0){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=0&catid=<?=$catid?>">草稿  [<?=$num_0?>]</a>
	<input name='status' type='radio' value='2' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=2&catid=<?=$catid?>'" <?if($status==2){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=2&catid=<?=$catid?>">退槁  [<?=$num_2?>]</a>
</td>
    <td align=right><select name='jump' id='jump' onchange="if(this.options[this.selectedIndex].value!=''){location='?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=<?=$status?>&catid='+this.options[this.selectedIndex].value;}"><option value='0'>请选择栏目进行管理</option><?=$cat_option?></select></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>回收站管理</th>
  </tr>
<tr align=center>
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">标题</td>
<td width="100" class="tablerowhighlight">栏目</td>
<td width="70" class="tablerowhighlight">录入</td>
<td width="70" class="tablerowhighlight">发表时间</td>
<td width="80" class="tablerowhighlight">点击</td>
</tr>

<? if(is_array($articles)) foreach($articles AS $article) { ?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input name='articleid[]' type='checkbox' id='articleid<?=$article[articleid]?>' value='<?=$article[articleid]?>'></td>
<td onMouseDown="document.getElementById('articleid<?=$article[articleid]?>').checked = (document.getElementById('articleid<?=$article[articleid]?>').checked ? false : true);"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&articleid=<?=$article[articleid]?>" target="_blank" title="预览文章"><?=$article[articleid]?></a></td>
<td align=left>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&catid=<?=$article[catid]?>&articleid=<?=$article[articleid]?>" target="_blank" title="预览文章"><?=$article[title]?></a></td>
<td align=left><a href="<?=$article[catdir]?>" target="_blank"><?=$_CAT[$article[catid]][catname]?></a></td>
<td><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($article[username])?>" target="_blank"><?=$article[username]?></a></td>
<td><?=$article[adddate]?></td>
<td><?=$article[hits]?></td>
</tr>
<? } ?>
</table>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td><input name='submit1' type='submit' value='彻底删除选定的文章' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;&nbsp;&nbsp;&nbsp;
        <input name='submit2' type='submit' value='清空回收站' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=deleteall&channelid=<?=$channelid?>&referer=<?=$referer?>'">&nbsp;&nbsp;&nbsp;&nbsp;
        <input name='submit3' type='submit' value='还原选定的文章' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=torecycle&value=0&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;&nbsp;&nbsp;&nbsp;
        <input name='submit4' type='submit' value='还原所有文章' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=restoreall&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;&nbsp;&nbsp;&nbsp;
 </td>
  </tr>
</table>
<table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>
</form>
</body>
</html>