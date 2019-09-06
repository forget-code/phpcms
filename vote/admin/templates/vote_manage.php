<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?> 
<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>投票管理</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="30%" class="tablerowhighlight">标题</td>
<td width="10%" class="tablerowhighlight">开始时间</td>
<td width="10%" class="tablerowhighlight">结束时间</td>
<td width="10%" class="tablerowhighlight">作者</td>
<td width="15%" class="tablerowhighlight">发表时间</td>
<td width="20%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($votes))
{
    foreach($votes as $vote) {
?>
<tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="voteid[]"  id="voteid[]" value="<?=$vote['voteid']?>"></td>
<td align="left">
<a href="<?=PHPCMS_PATH?>vote/show.php?voteid=<?=$vote[voteid]?>" target="_blank"><?=$vote['subject']?></a></td>
<td><?=$vote['fromdate']?></td>
<td><?=$vote['todate']?></td>
<td><a href='<?=PHPCMS_PATH?>member/member.php?username=<?=urlencode($vote['username'])?>' target='_blank'><?=$vote['username']?></a></td>
<td><?=$vote['addtime']?></td>
<td><a href='?mod=vote&file=vote&action=edit&voteid=<?=$vote['voteid']?>&channelid=<?=$channelid?>' title="编辑">编辑</a> | <a href='?mod=vote&file=vote&action=getcode&voteid=<?=$vote['voteid']?>&channelid=<?=$channelid?>' title="js调用">获取调用代码</a></td>
</tr>
<?php 
	}
 }
?>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td align="left">
    <?php if(!$passed){ ?><input name='submit2' type='submit' value='批准选定的投票' onClick="document.myform.action='?mod=vote&file=vote&action=pass&passed=1&channelid=<?=$channelid?>&referer=<?=$referer?>'">&nbsp;&nbsp;<?php }else{ ?>
    <input name='submit3' type='submit' value='取消批准选定的投票' onClick="document.myform.action='?mod=vote&file=vote&action=pass&passed=0&channelid=<?=$channelid?>&referer=<?=$referer?>'">&nbsp;&nbsp;<?php } ?>
    <input name="submit1" type="submit"  value="删除选定的投票" onClick="document.myform.action='?mod=vote&file=vote&action=delete&channelid=<?=$channelid?>&referer=<?=$referer?>'">&nbsp;&nbsp;
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