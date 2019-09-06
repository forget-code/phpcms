<?php include admintpl('header');?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>&specialid=<?=$specialid?>"><?=$specialname?></a> >> <?php if(isset($subspecialid)){ ?><font color="red"><?=$subspecial[$subspecialid]['specialname']?></font><?php } ?>
	</td>
	<td align="right" class="tablerow">
	<? if(is_array($subspecial)) foreach($subspecial AS $subspecialid=>$sub) { ?>
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>&specialid=<?=$specialid?>&subspecialid=<?=$subspecialid?>"><?=$sub['specialname']?></a> | 
	<? } ?>
	&nbsp;</td>
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
    <th colspan="9">[专题]<?=$specialname?> 文章管理</th>
  </tr>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="40" class="tablerowhighlight">排序</td>
<td class="tablerowhighlight">标题</td>
<td width="70" class="tablerowhighlight">录入</td>
<td width="80" class="tablerowhighlight">发表时间</td>
<td width="50" class="tablerowhighlight">点击</td>
<td width="70" class="tablerowhighlight">管理操作</td>
</tr>

<? if(is_array($articles)) foreach($articles AS $article) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' title="文章ID:<?=$article['articleid']?>&#10;添加时间:<?=$article['addtime']?>&#10;审核:<?=$article['checker']?>&#10;审核时间:<?=$article['checktime']?>&#10;编辑:<?=$article['editor']?>&#10;编辑时间:<?=$article['edittime']?>" ondblclick="$('article_<?=$article['articleid']; ?>').checked = ($('article_<?=$article['articleid']; ?>').checked ? false : true);">

<td><input name="articleids[]" type="checkbox" value="<?=$article['articleid']?>" id="article_<?=$article['articleid']?>"></td>

<td><?=$article['articleid']?></td>

<td><input name='listorders[<?=$article['articleid']?>]' type='input' value='<?=$article['listorder']?>' size="3" /></td>

<td align="left"><? if(!$catid) { ?>[<a href="<?=$CATEGORY[$article['catid']]['linkurl']?>" target="_blank"><?=$CATEGORY[$article['catid']]['catname']?></a>] <? } ?><a href="<?=$article['linkurl']?>" target="_blank"><?=$article['title']?></a></td>


<td title="编辑:<?=$article['checker']?>"><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($article['username'])?>" target="_blank"><?=$article['username']?></a></td>
<td><?=$article['adddate']?></td>
<td><?=$article['hits']?></td>
<td>
<a href="?mod=<?=$mod?>&file=article&action=edit&channelid=<?=$channelid?>&articleid=<?=$article['articleid']?>&catid=<?=$article['catid']?>&referer=<?=$forward?>" title="编辑文章">编辑</a> |
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
		<input type='submit' value='移出专题' style="color:red;" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete_itemids&channelid=<?=$channelid?>&specialid=<?=$specialid?>&referer=<?=$forward?>'" >&nbsp;
	</td>
  </tr>
</table>

</body>
</html>
