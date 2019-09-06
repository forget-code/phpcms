<?php include admintpl('header');?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>

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
	<select name="srchtype">
	<option value="0" <?if($srchtype==0){?>selected<?}?>> 标题 </option>
	<option value="1" <?if($srchtype==1){?>selected<?}?>> 内容 </option>
	<option value="2" <?if($srchtype==2){?>selected<?}?>> 作者 </option>
	<option value="3" <?if($srchtype==3){?>selected<?}?>> 会员 </option>
	</select>&nbsp;
	<input name='keywords' type='text' size='50' value='<?=$keywords?>'>&nbsp;
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
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=mypicture&channelid=<?=$channelid?>">我添加的图片</a> &gt;&gt;
	<?=$cat_pos?>
	<input name='status' type='radio' value='3' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=3&catid=<?=$catid?>'"  <?if($status==3){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=3&catid=<?=$catid?>">已通过 [<?=$num_3?>]</a>&nbsp;
	<input name='status' type='radio' value='1' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=1&catid=<?=$catid?>'" <?if($status==1){?> checked <?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=1&catid=<?=$catid?>">待审核 [<?=$num_1?>]</a>&nbsp;
	<input name='status' type='radio' value='0' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=0&catid=<?=$catid?>'" <?if($status==0){?> checked <?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=0&catid=<?=$catid?>">草稿 [<?=$num_0?>]</a>&nbsp;
	<input name='status' type='radio' value='2' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=2&catid=<?=$catid?>'" <?if($status==2){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=2&catid=<?=$catid?>">退槁 [<?=$num_2?>]</a>&nbsp;

</td>
    <td align='right'><select name='jump' id='jump' onchange="if(this.options[this.selectedIndex].value!=''){location='?mod=<?=$mod?>&file=<?=$file?>&action=myitem&channelid=<?=$channelid?>&status=<?=$status?>&catid='+this.options[this.selectedIndex].value;}"><option value='' selected>请选择栏目进行管理</option><?=$cat_option?></select></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>我添加的图片</th>
  </tr>
<tr align=center>
<td width="4%" class="tablerowhighlight">ID</td>
<td width="12%" class="tablerowhighlight">缩略图</td>
<td width="34%" class="tablerowhighlight">标题</td>
<td width="9%" class="tablerowhighlight">栏目</td>
<td width="11%" class="tablerowhighlight">发表时间</td>
<td width="9%" class="tablerowhighlight">点击</td>
<td width="21%" class="tablerowhighlight">管理操作</td>
</tr>

<? if(is_array($pictures)) foreach($pictures AS $picture) { ?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td>
  <div align="center"><a href="?mod=picture&file=picture&action=preview&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&referer=<?=$referer?>" target="_blank" title="预览图片">
    <?=$picture[pictureid]?>
    </a>
  </div></td>
<td>
<? if($picture[status]==3) { ?><a href="<?=$picture[url]?>" target="_blank"><img src="<?=$picture[thumb]?>" alt="缩略图" width="80" height="80" border="0"/></a><? } else { ?><a href="?mod=picture&file=picture&action=preview&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&referer=<?=$referer?>" target="_self" title="预览文章"><img src="<?=$picture[thumb]?>" alt="缩略图" width="80" height="80" border="0"/></a><? } ?>
</td>
<td align=left>
<? if($picture[status]==3) { ?><a href="<?=$picture[url]?>" target="_blank"><?=$picture[title]?></a><? } else { ?><a href="?mod=picture&file=picture&action=preview&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&referer=<?=$referer?>" target="_self" title="预览文章"><?=$picture[title]?></a><? } ?>
<? if($picture[ontop]) { ?><font color=red> 固</font><? } ?>
<? if($picture[elite]) { ?><font color=blue> 荐</font><? } ?></td>
<td>
<a href="<?=$picture[caturl]?>" target="_blank"><?=$_CAT[$picture[catid]][catname]?></a>
</td>
<td><?=$picture[adddate]?></td>
<td><?=$picture[hits]?></td>
<td>
<?if($picture[status]==3){?>
<font color='#C0C0C0'>编辑 | 删除</font>
<?} else {?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&catid=<?=$picture[catid]?>&specialid=<?=$picture[specialid]?>&titlefonttype=<?=$picture[titlefonttype]?>&titlefontcolor=<?=$picture[titlefontcolor]?>&templateid=<?=$picture[templateid]?>&skinid=<?=$picture[skinid]?>&groupview=<?=$picture[groupview]?>&referer=<?=$referer?>" title="编辑文章">编辑</a> | <?if($picture[status]!=1){?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=send&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&referer=<?=$referer?>">投稿</a> | <?}?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=torecycle&value=1&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>">删除</a><?}?></td>
</tr>
<? } ?>
</table>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
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