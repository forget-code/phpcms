<?php include admintpl('header');?>
<?php echo $downmenu; ?>
<form name="searchform" id="searchform" method="get" action="?">
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
	  <td class="tablerow">&nbsp;</td>
	<td class="tablerow">
		<select name="field">
		<option value="title" <?php if($type=='title') echo 'selected="selected"' ?>>标题</option>
		<option value="introduce" <?php if($type=='intorduce') echo 'selected="selected"' ?>>简介</option>
		<option value="username" <?php if($type=='username') echo 'selected="selected"' ?>>录入者</option>
		<option value="checker" <?php if($type=='checker') echo 'selected="selected"' ?>>审核者</option>
		<option value="editor" <?php if($type=='editor') echo 'selected="selected"' ?>>编辑者</option>
		</select>
	<input name="keywords" type="text" value="<?php echo $keywords; ?>" size="40" title="请输入关键字" onmouseover="this.select();"/>
	<?php echo $cat_serach; ?>
	<select name="order">
	<option value="addtime desc" <?php if($order=='addtime desc') echo 'selected="selected"' ?>>添加时间降序</option>
	<option value="addtime asc" <?php if($order=='addtime asc') echo 'selected="selected"' ?>>添加时间升序</option>
	<option value="edittime desc" <?php if($order=='edittime desc') echo 'selected="selected"' ?>>更新时间降序</option>
	<option value="edittime asc" <?php if($order=='edittime asc') echo 'selected="selected"' ?>>更新时间升序</option>
	<option value="hits desc" <?php if($order=='hits desc') echo 'selected="selected"' ?>>浏览次数降序</option>
	<option value="hits asc" <?php if($order=='hits asc') echo 'selected="selected"' ?>>浏览次数升序</option>
	</select>
&nbsp;
<input name="ontop" type="checkbox" id="ontop" value="1" onClick="self.location.href='<?php echo $topurl; ?>'" <?php echo $topcheckded; ?> /><a href="<?php echo $topurl; ?>">置顶</a>
&nbsp;
<input name="elite" type="checkbox" id="elite" value="1" onClick="self.location.href='<?php echo $eliteurl; ?>'" <?php echo $elitecheckded; ?> /><a href="<?php echo $eliteurl; ?>">推荐</a>
	<input name="mod" type="hidden" value="<?php echo $mod; ?>" />
	<input name="file" type="hidden" value="<?php echo $file; ?>" />
	<input name="action" type="hidden" value="<?php echo $action; ?>" />
	<input name="channelid" type="hidden" value="<?php echo $channelid; ?>" />
	<input name="search" type="submit" value=" 搜 索 ">
	</td>
	</tr>
</table>
</form>

<form method="post" name="myform">
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td>当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=special&channelid=<?=$channelid?>">专题文章管理</a> &gt;&gt; <?=$specialname?> </td>
    <td align=right>
	<?=$special_select?>
	</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>专题下载管理</th>
  </tr>
<tr align=center>
<td width="5%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="32%" class="tablerowhighlight">标题</td>
<td width="20%" class="tablerowhighlight">专题</td>
<td width="10%" class="tablerowhighlight">录入</td>
<td width="10%" class="tablerowhighlight">发表时间</td>
<td width="6%" class="tablerowhighlight">点击</td>
<td width="12%" class="tablerowhighlight">管理操作</td>
</tr>

<? if(is_array($downs)) foreach($downs AS $down) { ?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input name='downid[]' type='checkbox' id='downid<?=$down[downid]?>' value='<?=$down[downid]?>'></td>
<td onMouseDown="document.getElementById('downid<?=$down[downid]?>').checked = (document.getElementById('downid<?=$down[downid]?>').checked ? false : true);"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&downid=<?=$down[downid]?>" target="_blank" title="预览文章"><?=$down[downid]?></a></td>
<td align=left><a href="<?=$down[url]?>" target="_blank"><?=$down[title]?></a>
<? if($down[ontop]) { ?><font color=red> 顶</font><? } ?>
<? if($down[elite]) { ?><font color=blue> 荐</font><? } ?>
</td>
<td align=left><a href="<?=$down[specialurl]?>" target="_blank"><?=$down[specialname]?></a></td>
<td title="编辑:<?=$down[checker]?>"><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($down['username'])?>" target="_blank"><?=$down['username']?></a></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>&time=<?=$down[adddate]?>"><?=$down[adddate]?></a></td>
<td><?=$down[hits]?></td>
<td>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&downid=<?=$down[downid]?>&catid=<?=$down[catid]?>&referer=<?=$referer?>" title="编辑文章">编辑</a> |
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
<?php if($_CHA['htmlcreatetype']){ ?><input name='submit1' type='submit' value='生成文章' onClick="document.myform.action='?mod=<?=$mod?>&file=tohtml&action=downid&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp; <?php } ?>
        <input name='submit2' type='submit' value='移出专题' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=specialout&value=1&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
		<input name='submit2' type='submit' value='推荐下载' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&value=1&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
        <input name='submit3' type='submit' value='取消推荐' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&value=0&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
        <input name='submit4' type='submit' value='置顶下载' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=ontop&value=1&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;
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
