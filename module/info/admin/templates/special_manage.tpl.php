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
    <th colspan="9">[专题]<?=$specialname?> 信息管理</th>
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

<? if(is_array($infos)) foreach($infos AS $info) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' title="信息ID:<?=$info['infoid']?>&#10;添加时间:<?=$info['addtime']?>&#10;审核:<?=$info['checker']?>&#10;审核时间:<?=$info['checktime']?>&#10;编辑:<?=$info['editor']?>&#10;编辑时间:<?=$info['edittime']?>" ondblclick="$('info_<?=$info['infoid']; ?>').checked = ($('info_<?=$info['infoid']; ?>').checked ? false : true);">

<td><input name="infoids[]" type="checkbox" value="<?=$info['infoid']?>" id="info_<?=$info['infoid']?>"></td>

<td><?=$info['infoid']?></td>

<td><input name='listorders[<?=$info['infoid']?>]' type='input' value='<?=$info['listorder']?>' size="3" /></td>

<td align="left"><? if(!$catid) { ?>[<a href="<?=$CATEGORY[$info['catid']]['linkurl']?>" target="_blank"><?=$CATEGORY[$info['catid']]['catname']?></a>] <? } ?><a href="<?=$info['linkurl']?>" target="_blank"><?=$info['title']?></a></td>


<td title="编辑:<?=$info['checker']?>"><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($info['username'])?>" target="_blank"><?=$info['username']?></a></td>
<td><?=$info['adddate']?></td>
<td><?=$info['hits']?></td>
<td>
<a href="?mod=<?=$mod?>&file=info&action=edit&channelid=<?=$channelid?>&infoid=<?=$info['infoid']?>&catid=<?=$info['catid']?>&referer=<?=$forward?>" title="编辑信息">编辑</a> |
<a href="?mod=comment&file=comment&action=manage&item=infoid&itemid=<?=$info['infoid']?>&channelid=<?=$channelid?>&infoid=<?=$info['infoid']?>" title="管理评论">评论</a>
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
