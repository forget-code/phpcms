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

<form method="post" name="myform">
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td>当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=check&channelid=<?=$channelid?>">图片审核</a>  &gt;&gt;
	<?=$cat_pos?></td>
    <td></td>
    <td align=right>
	<select name='jump' id='jump' onchange="if(this.options[this.selectedIndex].value!=''){location='?mod=<?=$mod?>&file=<?=$file?>&action=check&channelid=<?=$channelid?>&status=<?=$status?>&catid='+this.options[this.selectedIndex].value;}"><option value='' selected>请选择栏目进行管理</option><?=$cat_option?></select>
	</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>图片审核管理</th>
  </tr>
<tr align=center>
<td width="6%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="12%" class="tablerowhighlight">缩略图</td>
<td width="35%" class="tablerowhighlight">标题</td>
<td width="10%" class="tablerowhighlight">栏目</td>
<td width="7%" class="tablerowhighlight">录入</td>
<td width="10%" class="tablerowhighlight">发表时间</td>
<td width="15%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform">
<? if(is_array($pictures)) foreach($pictures AS $picture) { ?>
<tr align=center onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td>
<input name='pictureid[]' type='checkbox' id='pictureid[]' value='<?=$picture[pictureid]?>'>
</td>
<td>
<?=$picture[pictureid]?>
</td>
<td>
<a href="?mod=picture&file=picture&action=preview&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&referer=<?=$referer?>"><img src="<?=$picture[thumb]?>" alt="缩略图" width="80" height="80" border="0"/></a>
</td>
<td align=left>
<a href="?mod=picture&file=picture&action=preview&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&referer=<?=$referer?>" target="_self" title="预览图片"><?=$picture[title]?></a>
</td>
<td>
<a href="<?=$picture[caturl]?>" target="_blank"><?=$_CAT[$picture[catid]][catname]?></a>
</td>
<td title="编辑:<?=$picture[checker]?>"><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($picture[username])?>" target="_blank"><?=$picture[username]?></a></td>
<td><?=$picture[adddate]?></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&catid=<?=$picture[catid]?>&specialid=<?=$picture[specialid]?>&titlefonttype=<?=$picture[titlefonttype]?>&titlefontcolor=<?=$picture[titlefontcolor]?>&templateid=<?=$picture[templateid]?>&skinid=<?=$picture[skinid]?>&referer=<?=urlencode($PHP_URL)?>" title="编辑文章">编辑</a>| <a href="?mod=<?=$mod?>&file=<?=$file?>&action=sendback&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&referer=<?=urlencode($PHP_URL)?>" >退稿</a></td>
</tr>

<? } ?>

<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中
	</td>
    <td>
	<input name='submit1' type='submit' value='通过审核' 
	onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=pass&pass=3&channelid=<?=$channelid?>&referer=<?=$referer?>'">&nbsp;&nbsp;
	<input name='submit2' type='submit' value='删除图片' 
	onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=torecycle&value=1&channelid=<?=$channelid?>&referer=<?=$referer?>'" >
 </td>
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