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
    <td>
	当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>">回收站管理</a>&gt;&gt;
	<?=$cat_pos?>
    <input name='status' type='radio' value='3' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=3&catid=<?=$catid?>'"  <?if($status==3){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=3&catid=<?=$catid?>">已通过 [<?=$num_3?>]</a>&nbsp;
	<input name='status' type='radio' value='1' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=1&catid=<?=$catid?>'" <?if($status==1){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=1&catid=<?=$catid?>">待审核 [<?=$num_1?>]</a>&nbsp;
	<input name='status' type='radio' value='0' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=0&catid=<?=$catid?>'" <?if(isset($status) && $status==0){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=0&catid=<?=$catid?>">草稿  [<?=$num_0?>]</a>&nbsp;
	<input name='status' type='radio' value='2' onclick="location='?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=2&catid=<?=$catid?>'" <?if($status==2){?>checked<?}?>> <a href="?mod=<?=$mod?>&file=<?=$file?>&action=recycle&channelid=<?=$channelid?>&status=2&catid=<?=$catid?>">退槁  [<?=$num_2?>]</a>&nbsp;
	</td>
    <td align=right><select name='jump' id='jump' onchange="if(this.options[this.selectedIndex].value!=''){location='?mod=picture&file=picture&action=recycle&channelid=<?=$channelid?>&status=<?=$status?>&catid='+this.options[this.selectedIndex].value;}"><option value='0'>跳转栏目至…</option><?=$cat_option?></select></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>回收站图片管理</th>
  </tr>
<tr align=center>
<td width="5%" class="tablerowhighlight">选中</td>
<td width="12%" class="tablerowhighlight">缩略图</td>
<td width="33%" class="tablerowhighlight">标题</td>
<td width="12%" class="tablerowhighlight">栏目</td>
<td width="10%" class="tablerowhighlight">录入</td>
<td width="10%" class="tablerowhighlight">发表时间</td>
<td width="8%" class="tablerowhighlight">点击</td>
</tr>
<form method="post" name="myform">
<? if(is_array($pictures)) foreach($pictures AS $picture) { ?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td height=20><input name='pictureid[]' type='checkbox' id='pictureid[]' value='<?=$picture[pictureid]?>'></td>
<td>
<? if($picture[status]==3) { ?><a href="<?=$picture[url]?>" target="_blank"><img src="<?=$picture[thumb]?>" alt="缩略图" width="80" height="80" border="0"/></a><? } else { ?><a href="?mod=picture&file=picture&action=preview&channelid=<?=$channelid?>&pictureid=<?=$picture[pictureid]?>&referer=<?=$referer?>" target="_self" title="预览文章"><img src="<?=$picture[thumb]?>" alt="缩略图" width="80" height="80" border="0"/></a><? } ?>
</td>
<td height=20 align=left><a href="<?=$picture[url]?>" target="_blank"><?=$picture[title]?></a></td>
<td><a href="<?=$picture[caturl]?>" target="_blank"><?=$_CAT[$picture[catid]][catname]?></a></td>
<td title="编辑:<?=$picture[checker]?>"><a href="<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($picture[username])?>" target="_blank"><?=$picture[username]?></a></td>
<td height=20><?=$picture[adddate]?></td>
<td height=20><?=$picture[hits]?></td>
</tr>
<? } ?>
</table>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td><input name='submit1' type='submit' value='彻底删除选定的图片' onClick="document.myform.action='?mod=picture&file=picture&action=delete&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;&nbsp;&nbsp;&nbsp;
        <input name='submit2' type='submit' value='清空回收站' onClick="document.myform.action='?mod=picture&file=picture&action=deleteall&channelid=<?=$channelid?>&referer=<?=$referer?>'">&nbsp;&nbsp;&nbsp;&nbsp;
        <input name='submit3' type='submit' value='还原选定的图片' onClick="document.myform.action='?mod=picture&file=picture&action=torecycle&value=0&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;&nbsp;&nbsp;&nbsp;
        <input name='submit4' type='submit' value='还原所有图片' onClick="document.myform.action='?mod=picture&file=picture&action=restoreall&channelid=<?=$channelid?>&referer=<?=$referer?>'" >&nbsp;&nbsp;&nbsp;&nbsp;
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