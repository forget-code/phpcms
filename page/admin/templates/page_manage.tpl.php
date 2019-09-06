<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>单网页管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="35" class="tablerowhighlight">选中</td>
<td width="35" class="tablerowhighlight">排序</td>
<td class="tablerowhighlight">标题</td>
<td class="tablerowhighlight">地址</td>
<td width="80" class="tablerowhighlight">更新时间</td>
<td width="120" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($page)) foreach($page AS $page) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>


<td><input type="checkbox" name="pageid[]"  id="pageid[]" value="<?=$page['pageid']?>"></td>

<td><input size="4" name="listorder[<?=$page['pageid']?>]" type="text" value="<?=$page['listorder']?>"></td>

<td align="left"><a href="<?=$page['url']?>" target="_blank"><?=$page['title']?></a><? if(!$page['passed']) { ?> <font color='red'>禁</font><? } ?></td>

<td align="left"><a href="<?=$page['url']?>" target="_blank"><?=$page['url']?></a></td>

<td><?=$page['adddate']?></td>

<td>
<a href='?mod=<?=$mod?>&file=<?=$file?>&action=delete&pageid=<?=$page['pageid']?>&keyid=<?=$keyid?>'>删除</a> | <? if($page['passed']) { ?><a href='?mod=<?=$mod?>&file=<?=$file?>&action=pass&passed=0&pageid=<?=$page['pageid']?>&keyid=<?=$keyid?>'>禁用</a><? } else { ?><a href='?mod=<?=$mod?>&file=<?=$file?>&action=pass&passed=1&pageid=<?=$page['pageid']?>&keyid=<?=$keyid?>'>启用</a><? } ?>| <a href='?mod=<?=$mod?>&file=<?=$file?>&action=edit&pageid=<?=$page['pageid']?>&keyid=<?=$keyid?>'>修改</a></td>

</tr>

<? } ?>

</table>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td>&nbsp;&nbsp;
	    <input type="submit" name="submit" value=" 更新排序 " onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=listorder&keyid=<?=$keyid?>'">&nbsp;&nbsp;
		<input name="submit1" type="submit"  value="生成选定的单网页" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=createhtml&keyid=<?=$keyid?>'">&nbsp;&nbsp;
		<input name="submit2" type="submit"  value="删除选定的单网页" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&keyid=<?=$keyid?>'">&nbsp;&nbsp;
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