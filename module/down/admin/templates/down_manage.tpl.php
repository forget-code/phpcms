<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">下载首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>">管理下载</a> &gt;&gt; <?=$cat_pos?> </td>
    <td class="tablerow" align="right"><?php echo $category_jump; ?><?php if($catid) { ?>&nbsp;<input type="button" value="添加下载" onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=add&catid=<?=$catid?>&channelid=<?=$channelid?>'"><?php } ?>
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
    <th colspan="9">下载管理</th>
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

<td align="left"><? if(!$catid) { ?>[<a href="<?=$CATEGORY[$down['catid']]['linkurl']?>" target="_blank"><?=$CATEGORY[$down['catid']]['catname']?></a>] <? } ?><?php if($down['typeid']) { ?> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>&typeid=<?=$down['typeid']?>"><font color="green"><?=$down['typename']?></font></a> <?php } ?><a href="<?=$down['linkurl']?>" target="_blank"><?=$down['title']?></a>
<?php if($down['thumb']) { ?> <font color="blue">图</font><?php } ?>
<?php if($down['arrposid']) { ?> <font color="green">荐</font><?php } ?>
<?php if($down['arrgroupidview']) { ?> <font color="red">权</font><?php } ?>
<?php if($down['readpoint']) { ?> <font color="blue">点</font><?php } ?>
</td>
<td title="编辑:<?=$down['checker']?>"><a href="<?=$MODULE['member']['linkurl']?>member.php?username=<?=urlencode($down['username'])?>" target="_blank"><?=$down['username']?></a></td>
<td><?=$down['adddate']?></td>
<td><?=$down['hits']?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&downid=<?=$down['downid']?>&catid=<?=$down['catid']?>&referer=<?=$referer?>" title="编辑下载">编辑</a> |
<a href="?mod=comment&file=comment&itemid=<?=$down['downid']?>&keyid=<?=$channelid?>" title="管理评论">评论</a>
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
	<input type='submit' value='更新排序' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=listorder&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
	<input type='submit' value='生成下载' onClick="document.myform.action='?mod=<?=$mod?>&file=createhtml&action=create_show&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;		
	<input type='submit' value='更新地址' onClick="document.myform.action='?mod=<?=$mod?>&file=createhtml&action=update_url&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
	<input type='submit' value='删除下载'		onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=action&job=status&value=-1&channelid=<?=$channelid?>&referer=<?=$referer?>'">&nbsp;
    <input type='submit' value='移动下载' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=move&movetype=1&channelid=<?=$channelid?>'">
    <input type='submit' value='加入专题' onClick="document.myform.action='?mod=<?=$mod?>&file=special&action=add_itemids&channelid=<?=$channelid?>&forward=<?=$referer?>'">
    <input type='submit' value='加入分类=>' onClick="document.myform.action='?mod=<?=$mod?>&file=addtotype&channelid=<?=$channelid?>&forward=<?=$referer?>'">
	<?=type_select('typeid', $LANG['type'])?>
	</td>
  </tr>
</table>
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
	</select>&nbsp;<input name='keywords' type='text' size='20' value='<?if(isset($keywords)){echo $keywords;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<?php echo $category_select; ?>
	<?php echo $type_select?>
	<select name="ordertype">
	<option value="0" <?if($ordertype==0){?>selected<?}?>>按下载排序排序</option>
	<option value="1" <?if($ordertype==1){?>selected<?}?>>按更新时间降序</option>
	<option value="2" <?if($ordertype==2){?>selected<?}?>>按更新时间升序</option>
	<option value="3" <?if($ordertype==3){?>selected<?}?>>按下载次数降序</option>
	<option value="4" <?if($ordertype==4){?>selected<?}?>>按下载次数升序</option>
	<option value="5" <?if($ordertype==5){?>selected<?}?>>按评论次数升序</option>
	<option value="6" <?if($ordertype==6){?>selected<?}?>>按评论次数降序</option>
	</select>&nbsp;
	<input name='pagesize' type='text' size='3' value='<?if(isset($pagesize)){echo $pagesize;}?>' title="每页显示的数据数目,最大值为500" maxlength="3"> 条数据/页
	<input type='submit' value=' 搜索 '></td>
  </tr>
</form>
</table>

</body>
</html>
