<?php
include admintpl('header');
$referer=urlencode("?".$PHP_QUERYSTRING); 
?>
<body>
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

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" >
  <tr>
    <td>当前位置：<a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=recycle&channelid=<?php echo $channelid; ?>" ><?php echo $headtitle; ?></a> &gt;&gt; <?php echo $cat_pos; ?>

<input type="radio" name="value" value="1" onClick="self.location.href='?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=recycle&value=0&channelid=<?php echo $channelid; ?>'" <?php if(isset($value) && $value==0) echo 'checked="checked"';?> /><a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=recycle&value=0&channelid=<?php echo $channelid; ?>">草稿</a><?php if($num_0) echo '['.$num_0.']'; ?>

<input type="radio" name="value" value="0" onClick="self.location.href='?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=recycle&value=1&channelid=<?php echo $channelid; ?>'" <?php if($value==1) echo 'checked="checked"';?>/><a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=recycle&value=1&channelid=<?php echo $channelid; ?>">待审核</a><?php if($num_1) echo '['.$num_1.']'; ?>

<input type="radio" name="value" value="1" onClick="self.location.href='?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=recycle&value=3&channelid=<?php echo $channelid; ?>'" <?php if($value==3) echo 'checked="checked"';?> /><a href="?mod=<?php echo $mod; ?>&file=<?php echo $mod; ?>&action=recycle&value=3&channelid=<?php echo $channelid; ?>">已通过</a><?php if($num_3) echo '['.$num_3.']'; ?>

	  </td>
    <td align="right">
	<?php echo $cat_jump; ?>
	</td>
  </tr>
</table>

<form name="form1" id="form1" method="post" action="">
  <table width="100%" align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan="7"><?php echo $headtitle; ?></th>
<?php 	
if($downs)
{
?>
    <tr align="center">
      <td width="5%" class="tablerowhighlight">选中</td>
      <td width="5%" class="tablerowhighlight">ID</td>
      <td width="49%" class="tablerowhighlight">标题</td>
      <td width="13%" class="tablerowhighlight">栏目</td>
      <td width="10%" class="tablerowhighlight">录入</td>
      <td width="10%" class="tablerowhighlight">添加时间</td>
      <td width="8%" class="tablerowhighlight">下载次数</td>
    </tr>
	<?php
		foreach( $downs as $key=>$down)
		{

	?>
    <tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgcolor="#F1F3F5"> 
      <td>
	  <input name="downid[]" id="down<?php echo $down['downid']; ?>" type="checkbox" value="<?php echo $down['downid']; ?>" >	  </td>
      <td onMouseDown="document.getElementById('down<?php echo $down['downid']; ?>').checked = (document.getElementById('down<?php echo $down['downid']; ?>').checked ? false : true);">
	  <?php echo $down['downid']; ?></td>
      <td align="left" onMouseDown="document.getElementById('down<?php echo $down['downid']; ?>').checked = (document.getElementById('down<?php echo $down['downid']; ?>').checked ? false : true);"><a href="<?php echo $down['url']; ?>" title="<?php echo $down['atitle']; ?>" target="_blank"><?php echo $down['title']; ?></a>	  <?php echo $down['property']; ?></td>
      <td onMouseDown="document.getElementById('down<?php echo $down['downid']; ?>').checked = (document.getElementById('down<?php echo $down['downid']; ?>').checked ? false : true);"><a href="<?=$down['caturl']?>" target="_blank"><?php echo $down['catname']; ?></a></td>
	  <td onMouseDown="document.getElementById('down<?php echo $down['downid']; ?>').checked = (document.getElementById('down<?php echo $down['downid']; ?>').checked ? false : true);">
	  <?php echo $down['username']; ?>	  </td>
      <td onMouseDown="document.getElementById('down<?php echo $down['downid']; ?>').checked = (document.getElementById('down<?php echo $down['downid']; ?>').checked ? false : true);"><?php echo $down['addtime']; ?></td>
      <td onMouseDown="document.getElementById('down<?php echo $down['downid']; ?>').checked = (document.getElementById('down<?php echo $down['downid']; ?>').checked ? false : true);">
	  <?php echo $down['hits']; ?>	  </td>
    </tr>
	<?php 
		}
	}
	else
	{
	?>
	<tr><td colspan="7" align="center" class="tablerow"><strong><?php echo $noinfo; ?></strong></td>
	</tr>
	<?php 
	}
	?>
</table>
<?php 	
if($downs)
{
?>
  <table width="100%" border="0" cellpadding="2" cellspacing="1">
    <tr>
      <td>
	  <input type="checkbox" name="chkall" id="chkall" value="checkbox" onClick="checkall(this.form)" />全选/不选
	  <input name="delete" type="submit" id="delete" onClick="if(confirm('确实要删除所选择的信息吗？')) this.form.action='?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=delete&channelid=<?php echo $channelid; ?>&submit=1&referer=<? echo $referer; ?>'" value="彻底删除选定信息" />
	  <input name='clearall' type="submit" id="clearall" onClick="if(confirm('确实要清空回收站吗？删除以后将不可恢复！')) this.form.action='?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=deleteall&channelid=<?php echo $channelid; ?>&submit=1&referer=<? echo $referer; ?>'" value="清空回收站" >
	  <input name="restore" type="submit" id="restore" onClick="if(confirm('确实要还原选定的信息吗？')) this.form.action='?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=torecycle&value=0&channelid=<?php echo $channelid; ?>&submit=1&referer=<? echo $referer; ?>'" value="还原选定的信息" />
	  <input name="restoreall" type="submit" id="restoreall" onClick="if(confirm('确实要还原所有信息吗？')) this.form.action='?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=restoreall&channelid=<?php echo $channelid; ?>&submit=1&referer=<? echo $referer; ?>'" value="还原所有信息" /></td>
    </tr>
    <?php if($pages) { ?>
    <tr>
      <td><?php echo $pages; ?> </td>
    </tr>
    <?php } ?>
  </table>
<?php 
}
?>
</form>

</body>
</html>