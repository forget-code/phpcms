<?php include admintpl('header');?>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">影片首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&job=recycle&catid=<?=$catid?>&channelid=<?=$channelid?>">回收站</a> &gt;&gt; <?=$cat_pos?> </td>
    <td class="tablerow" align="right"><?php echo $category_jump; ?>
	</td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="8">回收站</th>
  </tr>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td class="tablerowhighlight">标题</td>
<td width="70" class="tablerowhighlight">录入</td>
<td width="80" class="tablerowhighlight">发表时间</td>
<td width="50" class="tablerowhighlight">点击</td>
<td width="70" class="tablerowhighlight">管理操作</td>
</tr>

<? if(is_array($movies)) foreach($movies AS $movie) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>

<td><input name='movieids[]' type='checkbox' value='<?=$movie['movieid']?>'></td>

<td><?=$movie['movieid']?></td>

<td align="left"><? if(!$catid) { ?>[<a href="<?=$CATEGORY[$movie['catid']]['linkurl']?>" target="_blank"><?=$CATEGORY[$movie['catid']]['catname']?></a>] <? } ?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&movieid=<?=$movie['movieid']?>&referer=<?=$referer?>"><?=$movie['title']?></a></td>

<td title="编辑:<?=$movie['checker']?>"><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($movie['username'])?>" target="_blank"><?=$movie['username']?></a></td>
<td><?=$movie['adddate']?></td>
<td><?=$movie['hits']?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channelid?>&movieids=<?=$movie['movieid']?>&referer=<?=$referer?>">删除</a> |
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=action&job=status&value=3&channelid=<?=$channelid?>&movieids=<?=$movie['movieid']?>&referer=<?=$referer?>">还原</a>
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
		<input type='button' value='清空回收站' onClick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
        <input name='submit2' type='submit' value='删除影片' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
        <input name='submit3' type='submit' value='还原影片' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=action&job=status&value=3&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;</td>
  </tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
</form>

<table width="100%" cellpadding="0" cellspacing="0" class="tableBorder">
<form method="get" name="search" action="?">
  <tr>
    <td height="30" class="tablerow" align="center">
	<input name='mod' type='hidden' value='<?=$mod?>'>
	<input name='file' type='hidden' value='<?=$file?>'>
	<input name='action' type='hidden' value='<?=$action?>'>
	<input name='job' type='hidden' value='<?=$job?>'>
	<input name='channelid' type='hidden' value='<?=$channelid?>'>
	<input name='catid' type='hidden' value='<?=$catid?>'>
	<select name="srchtype">
	<option value="0" <?if($srchtype==0){?>selected<?}?>> 按标题 </option>
	<option value="1" <?if($srchtype==1){?>selected<?}?>> 按摘要 </option>
	<option value="2" <?if($srchtype==2){?>selected<?}?>> 按作者 </option>
	<option value="3" <?if($srchtype==3){?>selected<?}?>> 按会员 </option>
	</select>&nbsp;<input name='keywords' type='text' size='30' value='<?if(isset($keywords)){echo $keywords;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<?php echo $category_select; ?>
	<?php echo $pos_select?>
	<select name="ordertype">
	<option value="0" <?if($ordertype==0){?>selected<?}?>>按影片排序排序</option>
	<option value="1" <?if($ordertype==1){?>selected<?}?>>按更新时间降序</option>
	<option value="2" <?if($ordertype==2){?>selected<?}?>>按更新时间升序</option>
	<option value="3" <?if($ordertype==3){?>selected<?}?>>按影片次数降序</option>
	<option value="4" <?if($ordertype==4){?>selected<?}?>>按影片次数升序</option>
	</select>&nbsp;
	<input name='pagesize' type='text' size='3' value='<?if(isset($pagesize)){echo $pagesize;}?>' title="每页显示的数据数目,最大值为500" maxlength="3"> 条数据/页
	<input type='submit' value=' 搜索 '></td>
  </tr>
</form>
</table>

</body>
</html>
