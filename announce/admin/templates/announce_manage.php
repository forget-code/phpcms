<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=9>公告管理</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="30%" class="tablerowhighlight">标题</td>
<td width="10%" class="tablerowhighlight">开始时间</td>
<td width="10%" class="tablerowhighlight">结束时间</td>
<td width="10%" class="tablerowhighlight">作者</td>
<td width="9%" class="tablerowhighlight">浏览次数</td>
<td width="13%" class="tablerowhighlight">发表时间</td>
<td width="13%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($announces)){ 
    foreach($announces AS $announce) { ?>
<tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' >
<td><input type="checkbox" name="announceid[]"  id="announceid[]" value="<?=$announce[announceid]?>"></td>
<td align="left"><a href="?mod=announce&file=announce&action=view&channelid=<?=$channelid?>&announceid=<?=$announce[announceid]?>&referer=<?=$referer?>" title="后台预览">  <?=$announce[title]?></a></td>
<td ><?=$announce[fromdate]?></td>
<td ><?=$announce[todate]?></td>
<td ><a href='<?=PHPCMS_PATH?>member/member.php?username=<?=$announce[username]?>'><?=$announce[username]?></a></td>
<td ><?=$announce[hits]?></td>
<td ><?=$announce[addtime]?></td>
<td>
<a href='<?=PHPCMS_PATH?>announce/show.php?announceid=<?=$announce[announceid]?>' title="前台预览"  target="_blank">前台</a> | <a href='?mod=announce&file=announce&action=edit&passed=<?=$passed?>&now=<?=$now?>&channelid=<?=$channelid?>&announceid=<?=$announce[announceid]?>' title="修改">修改</a>
</td>
</tr>
<?php 
     }	
}
?>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td>
	<? if($announce[passed]==0){ ?>
    <input name='submit2' type='submit' value='批准选定的公告' onClick="document.myform.action='?mod=announce&file=announce&action=pass&passed=1&channelid=<?=$channelid?>'">&nbsp;&nbsp;
	<? }else{ ?>
    <input name='submit3' type='submit' value='取消批准选定的公告' onClick="document.myform.action='?mod=announce&file=announce&action=pass&passed=0&channelid=<?=$channelid?>'">&nbsp;&nbsp;
	<? } ?>
    <input name="submit1" type="submit"  value="删除选定的公告" onClick="document.myform.action='?mod=announce&file=announce&action=delete&channelid=<?=$channelid?>'">&nbsp;&nbsp;
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