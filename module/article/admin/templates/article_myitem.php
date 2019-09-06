<?php include admintpl('header');?>
<?=$menu?>
<table width="100%" cellpadding="0" cellspacing="0" class="tableBorder">
<form method="get" name="search" action="?">
  <tr>
    <td height="30" class="tablerow" align="center">
	<input name='mod' type='hidden' value='<?=$mod?>'>
	<input name='file' type='hidden' value='<?=$file?>'>
	<input name='action' type='hidden' value='<?=$action?>'>
	<input name='channelid' type='hidden' value='<?=$channelid?>'>
	<input name='catid' type='hidden' value='<?=$catid?>'>
	<input name='status' type='hidden' value='<?=$status?>'>
	<select name="srchtype">
	<option value="0" <?if($srchtype==0){?>selected<?}?>> 标题 </option>
	<option value="1" <?if($srchtype==1){?>selected<?}?>> 内容 </option>
	<option value="2" <?if($srchtype==2){?>selected<?}?>> 作者 </option>
	<option value="3" <?if($srchtype==3){?>selected<?}?>> 会员 </option>
	</select>&nbsp;
	<input name='keywords' type='text' size='40' value='<?=$keywords?>'>&nbsp;
	<select name='catid'>
	<option value='0'>请选择栏目</option>
	<?=$cat_option?>
	</select>
	<input type="checkbox" class="radio" name="elite" value="1" <?if($elite==1){?>checked<?}?>> 推荐
	<input type="checkbox" class="radio" name="ontop" value="1" <?if($ontop==1){?>checked<?}?>> 置顶
	<select name="ordertype">
	<option value="1" <?if($ordertype==1){?>selected<?}?>>更新时间降序</option>
	<option value="2" <?if($ordertype==2){?>selected<?}?>>更新时间升序</option>
	<option value="3" <?if($ordertype==3){?>selected<?}?>>浏览次数降序</option>
	<option value="4" <?if($ordertype==4){?>selected<?}?>>浏览次数升序</option>
	</select>
	<input name='submit' type='submit' value=' 搜索 '></td>
  </tr>
</form>
</table>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td>当前位置：
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>">我添加的文章</a> &gt;&gt;
	<?=$cat_pos?>
	<input name='status' type='radio' value='3' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=3&catid=<?=$catid?>'"  <?if($status==3){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=3&catid=<?=$catid?>">已通过 [<?=$num_3?>]</a>
	<input name='status' type='radio' value='1' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=1&catid=<?=$catid?>'" <?if($status==1){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=1&catid=<?=$catid?>">待审核 [<?=$num_1?>]</a>
	<input name='status' type='radio' value='0' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=0&catid=<?=$catid?>'" <?if($status==0){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=0&catid=<?=$catid?>">草稿 [<?=$num_0?>]</a>
	<input name='status' type='radio' value='2' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=2&catid=<?=$catid?>'" <?if($status==2){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=2&catid=<?=$catid?>">退槁 [<?=$num_2?>]</a>

</td>
    <td align='right'><select name='jump' id='jump' onchange="if(this.options[this.selectedIndex].value!=''){location='?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=<?=$status?>&catid='+this.options[this.selectedIndex].value;}"><option value='' selected>请选择栏目查看</option><?=$cat_option?></select></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>我添加的文章</th>
  </tr>
<tr align=center>
<td width="40" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">标 题</td>
<td width="100" class="tablerowhighlight">栏目</td>
<td width="70" class="tablerowhighlight">发表时间</td>
<td width="60" class="tablerowhighlight">点击</td>
<td width="120" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform">
<? if(is_array($articles)) foreach($articles AS $article) { ?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' height='22'>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&articleid=<?=$article[articleid]?>" target="_blank" title="预览文章"><?=$article[articleid]?></a></td>
<td align=left><? if($article[status]==3) { ?><a href="<?=$article[url]?>" target="_blank"><?=$article[title]?></a><? } else { ?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&articleid=<?=$article[articleid]?>&referer=<?=$referer?>" target="_blank" title="预览文章"><?=$article[title]?></a><? } ?>
<? if($article[ontop]) { ?><font color=red> 顶</font><? } ?>
<? if($article[elite]) { ?><font color=blue> 荐</font><? } ?>
</td>
<td align=left><a href="<?=$article[catdir]?>" target="_blank"><?=$_CAT[$article[catid]][catname]?></a></td>
<td><?=$article[adddate]?></td>
<td><?=$article[hits]?></td>
<td><?if($article[status]==3){?>
<font color='#C0C0C0'>编辑 | 删除</font>
<?} else {?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&articleid=<?=$article[articleid]?>&catid=<?=$article[catid]?>&referer=<?=$referer?>" title="编辑文章">编辑</a> | <?if($article[status]!=1){?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=send&channelid=<?=$channelid?>&articleid=<?=$article[articleid]?>&referer=<?=$referer?>">投稿</a> | <?}?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=torecycle&value=1&channelid=<?=$channelid?>&articleid=<?=$article[articleid]?>&referer=<?=$referer?>">删除</a><?}?></td>
</tr>
<? } ?>
</table>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
</form>
</body>
</html>