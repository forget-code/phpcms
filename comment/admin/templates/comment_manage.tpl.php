<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<br />
<table cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
  <tr>
    <td class="submenu"> 选择频道/模块进行管理 </td>
  </tr>
  <tr>
    <td class='pagemenu'>
<?=$link?>
	</td>
  </tr>
</table><br/>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center> 评论搜索 </td>
  </tr>
<form method="post" name="search">
  <tr>
    <td class="tablerow">
	&nbsp;<a href="?mod=comment&file=comment&action=manage&keyid=<?=$keyid?>"><b>管理首页</b></a>&nbsp;
	<input name='passed' type='radio' value='1' onclick="location='?mod=comment&file=comment&action=manage&passed=1&keyid=<?=$keyid?>'" <? if($passed==1) { ?>checked<? } ?>>
	<a href='?mod=comment&file=comment&action=manage&passed=1&keyid=<?=$keyid?>'>已审核的评论</a>&nbsp;
	<input name='passed' type='radio' value='0' onclick="location='?mod=comment&file=comment&action=manage&passed=0&keyid=<?=$keyid?>'" <? if(!$passed) { ?>checked<? } ?>>
	<a href='?mod=comment&file=comment&action=manage&passed=0&keyid=<?=$keyid?>'>未审核的评论</a>&nbsp;
	关键字：<input name='keywords' type='text' size='20' value='<?=$keywords?>'>&nbsp;
	<select name="srchfrom">
	<option value="0">时间段</option>
	<option value="1" <? if($srchfrom==1) { ?>selected<? } ?>>1 天内</option>
	<option value="2" <? if($srchfrom==2) { ?>selected<? } ?>>2 天内</option>
	<option value="3" <? if($srchfrom==3) { ?>selected<? } ?>>3 天内</option>
	<option value="7" <? if($srchfrom==7) { ?>selected<? } ?>>1 周内</option>
	<option value="14" <? if($srchfrom==14) { ?>selected<? } ?>>2 周内</option>
	<option value="30" <? if($srchfrom==30) { ?>selected<? } ?>>1 月内</option>
	<option value="60" <? if($srchfrom==60) { ?>selected<? } ?>>2 月内</option>
	<option value="90" <? if($srchfrom==90) { ?>selected<? } ?>>3 月内</option>
	<option value="180" <? if($srchfrom==180) { ?>selected<? } ?>>6 月内</option>
	<option value="365" <? if($srchfrom==365) { ?>selected<? } ?>>1 年内</option>
	</select>
	<input name='submit' type='submit' value='评论搜索'></td>
  </tr>
</form>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>评论管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="25" class="tablerowhighlight">选</td>
<td width="80" class="tablerowhighlight">用户名</td>
<td class="tablerowhighlight">内容</td>
<td width="50" class="tablerowhighlight">鲜花数</td>
<td width="50" class="tablerowhighlight">鸡蛋数</td>
<td width="90" class="tablerowhighlight">评论时间</td>
<td width="150" class="tablerowhighlight">管理操作</td>
</tr>
<?php
foreach($comments AS $comment)
{
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="cid[]"  id="cid" value="<?=$comment['cid']?>"></td>
<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($comment['username'])?>" class="member_url"><?=$comment['username']?></a></td>
<td align="left" style="width:450px;WORD-WRAP: break-word;"><?=$comment['content']?></td>
<td ><?=$comment['support']?></td>
<td ><?=$comment['against']?></td>
<td title="<?=$comment['addtime']?>"><?=$comment['adddate']?></td>
<td><a href='?mod=comment&file=comment&ip=<?=$comment['ip']?>&keyid=<?=$keyid?>' title="IP：<?=$comment['ip']?> - <?=$comment['gip']['country']?> 
点击查看来自该ip的所有评论"> IP </a> | <a href='<?=$comment['url']?>' target='_blank' title="该评论所属文章">原文</a> | <a href='?mod=comment&file=comment&itemid=<?=$comment['itemid']?>&keyid=<?=$keyid?>' title="与该评论所属文章相同的评论">相关评论</a></td>
</tr>

<? } ?>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td  align="center">
        <?php if($passed == 0){ ?><input name='submit2' type='submit' value='批准选定的评论' onClick="document.myform.action='?mod=comment&file=comment&action=pass&passed=1&keyid=<?=$keyid?>&referer=<?=$referer?>'">&nbsp;&nbsp;
        <?php }else{ ?><input name='submit3' type='submit' value='取消批准选定的评论' onClick="document.myform.action='?mod=comment&file=comment&action=pass&passed=0&keyid=<?=$keyid?>&referer=<?=$referer?>'">&nbsp;&nbsp;
		<?php } ?>
		<input name="submit1" type="submit"  value="删除选定的评论" onClick="document.myform.action='?mod=comment&file=comment&action=delete&keyid=<?=$keyid?>&referer=<?=$referer?>'">&nbsp;&nbsp;
</td>
  </tr>
</table>
</form>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td height="20" align="center"><?=$pages?></td>
  </tr>
</table>
</body>
</html>