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
    <th colspan="9">[专题]<?=$specialname?> 下载管理</th>
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

<? if(is_array($downs)) foreach($downs AS $down) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' title="下载ID:<?=$down['downid']?>&#10;添加时间:<?=$down['addtime']?>&#10;审核:<?=$down['checker']?>&#10;审核时间:<?=$down['checktime']?>&#10;编辑:<?=$down['editor']?>&#10;编辑时间:<?=$down['edittime']?>" ondblclick="$('down_<?=$down['downid']; ?>').checked = ($('down_<?=$down['downid']; ?>').checked ? false : true);">

<td><input name="downids[]" type="checkbox" value="<?=$down['downid']?>" id="down_<?=$down['downid']?>"></td>

<td><?=$down['downid']?></td>

<td><input name='listorders[<?=$down['downid']?>]' type='input' value='<?=$down['listorder']?>' size="3" /></td>

<td align="left"><? if(!$catid) { ?>[<a href="<?=$CATEGORY[$down['catid']]['linkurl']?>" target="_blank"><?=$CATEGORY[$down['catid']]['catname']?></a>] <? } ?><a href="<?=$down['linkurl']?>" target="_blank"><?=$down['title']?></a></td>


<td title="编辑:<?=$down['checker']?>"><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($down['username'])?>" target="_blank"><?=$down['username']?></a></td>
<td><?=$down['adddate']?></td>
<td><?=$down['hits']?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&downid=<?=$down['downid']?>&catid=<?=$down['catid']?>&referer=<?=$forward?>" title="编辑下载">编辑</a> |
<a href="?mod=comment&file=comment&action=manage&item=downid&itemid=<?=$down['downid']?>&channelid=<?=$channelid?>&downid=<?=$down['downid']?>" title="管理评论">评论</a>
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
		<input type='submit' value='更新排序' onClick="document.myform.action='?mod=<?=$mod?>&file=down&action=listorder&channelid=<?=$channelid?>&referer=<?=$forward?>'" >&nbsp;
		<input type='submit' value='更新排序' onClick="document.myform.action='?mod=<?=$mod?>&file=down&action=listorder&channelid=<?=$channelid?>&referer=<?=$forward?>'" >&nbsp;
		<input type='submit' value='生成下载' onClick="document.myform.action='?mod=<?=$mod?>&file=createhtml&action=create_show&channelid=<?=$channelid?>&referer=<?=$forward?>'" >&nbsp;		
		<input type='submit' value='更新地址' onClick="document.myform.action='?mod=<?=$mod?>&file=createhtml&action=update_url&channelid=<?=$channelid?>&referer=<?=$forward?>'" >&nbsp;
		<input type='submit' value='删除下载'		onClick="document.myform.action='?mod=<?=$mod?>&file=down&action=action&job=status&value=-1&channelid=<?=$channelid?>&referer=<?=$forward?>'">&nbsp;
        <input type='submit' value='移动下载' onClick="document.myform.action='?mod=<?=$mod?>&file=down&action=move&movetype=1&channelid=<?=$channelid?>'">
        <input type='submit' value='加入专题' onClick="document.myform.action='?mod=phpcms&file=special&action=add_itemids&channelid=<?=$channelid?>'">
	</td>
  </tr>
</table>

</body>
</html>
