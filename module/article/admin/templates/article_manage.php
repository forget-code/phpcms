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

<form method="post" name="myform">
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td>当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>">文章管理</a> &gt;&gt; <?=$cat_pos?> </td>
    <td align=right>
	<select name='jump' id='jump' onchange="if(this.options[this.selectedIndex].value!=''){location='?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>&catid='+this.options[this.selectedIndex].value;}">
	<option value='0'>请选择栏目进行管理</option>
	<?=$cat_option?>
	</select>
	</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>文章管理</th>
  </tr>
<tr align=center>
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">标题</td>
<td width="100" class="tablerowhighlight">栏目</td>
<td width="70" class="tablerowhighlight">录入</td>
<td width="70" class="tablerowhighlight">发表时间</td>
<td width="60" class="tablerowhighlight">点击</td>
<td width="80" class="tablerowhighlight">管理操作</td>
</tr>

<? if(is_array($articles)) foreach($articles AS $article) { ?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input name='articleid[]' type='checkbox' id='articleid<?=$article[articleid]?>' value='<?=$article[articleid]?>'></td>
<td onMouseDown="document.getElementById('articleid<?=$article[articleid]?>').checked = (document.getElementById('articleid<?=$article[articleid]?>').checked ? false : true);"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&articleid=<?=$article[articleid]?>" target="_blank" title="预览文章"><?=$article[articleid]?></a></td>
<td align=left><a href="<?=$article[url]?>" target="_blank"><?=$article[title]?></a>
<? if($article[ontop]) { ?><font color=red> 顶</font><? } ?>
<? if($article[elite]) { ?><font color=blue> 荐</font><? } ?>
</td>
<td align=left><a href="<?=$article[catdir]?>" target="_blank"><?=$_CAT[$article[catid]][catname]?></a></td>
<td title="编辑:<?=$article[checker]?>"><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($article['username'])?>" target="_blank"><?=$article['username']?></a></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>&time=<?=$article[adddate]?>"><?=$article[adddate]?></a></td>
<td><?=$article[hits]?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&articleid=<?=$article[articleid]?>&catid=<?=$article[catid]?>&referer=<?=$referer?>" title="编辑文章">编辑</a> |
<a href="?mod=comment&file=comment&action=manage&item=articleid&itemid=<?=$article['articleid']?>&channelid=<?=$channelid?>&articleid=<?=$article['articleid']?>" title="管理评论">评论</a>
</td>
</tr>
<? } ?>


<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
<?php if($_CHA['htmlcreatetype']){ ?><input name='submit1' type='submit' value='生成文章' onClick="document.myform.action='?mod=<?=$mod?>&file=tohtml&action=articletohtml&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp; <?php } ?>
        <input name='submit2' type='submit' value='推荐文章' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&value=1&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
        <input name='submit3' type='submit' value='取消推荐' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&value=0&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
        <input name='submit4' type='submit' value='置顶文章' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=ontop&value=1&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
        <input name='submit5' type='submit' value='取消置顶' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=ontop&value=0&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
		<input name='submit7' type='submit' value='删除文章'		onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=torecycle&value=1&channelid=<?=$channelid?>&referer=<?=$referer?>'">&nbsp;
        <input name='submit8' type='submit' value='批量移动' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=move&movetype=1&channelid=<?=$channelid?>'"></td>
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
