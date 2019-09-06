<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form method="post" name="myform">
<table cellpadding="0" cellspacing="1" border="0" width="100%" height="30" class="tableborder">
  <tr>
    <td  width="40%" class="tablerowhighlight">&nbsp;按任务查看：&nbsp;<?=$selectJobContent?></td>
    <td  class="tablerowhighlight">&nbsp;按任务操作：&nbsp;<?=$deleteJobContent?>
	<input type="submit" name="submitsendjobcontent" value="发布该任务内容" onClick="document.myform.action='?mod=<?=$mod?>&file=collect&action=outcontent&step=1&channelid=1&jobid='+document.getElementById('deleteJobContent').value+''">
	<input type="submit" name="submitdeletejobcontent" value="删除整个任务内容" onClick="if(confirm('确认删除该任务下的全部记录吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=deletejobcontent'"></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=10><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage"><font color="white">采集内容管理</font></a></th>
<tr align="center">
<td colspan="2" class="tablerowhighlight">选</td>
<td width="*" class="tablerowhighlight"><a href="javascript:window.location='?mod=<?=$mod?>&file=collect&action=manage&sortby=Title&desc=<?echo ($desc+1);if(isset($jobid)) echo "&jobid=".$jobid; ?>';"><font color="Blue">文章标题</font></a></td>
<td width="12%" class="tablerowhighlight"><a href="javascript:window.location='?mod=<?=$mod?>&file=collect&action=manage&sortby=<?=TABLE_SPIDER_URLS?>.JobId&desc=<?echo ($desc+1);if(isset($jobid)) echo "&jobid=".$jobid; ?>'"><font color="Blue">所属任务<font color="Blue"></a></td>
<td width="13%" class="tablerowhighlight"><a href="javascript:window.location='?mod=<?=$mod?>&file=collect&action=manage&sortby=CreateOn&desc=<?echo ($desc+1);if(isset($jobid)) echo "&jobid=".$jobid; ?>'"><font color="Blue">链接采集时间</font></a></td>
<td width="42" class="tablerowhighlight"><a href="javascript:window.location='?mod=<?=$mod?>&file=collect&action=manage&sortby=Spidered&desc=<?echo ($desc+1);if(isset($jobid)) echo "&jobid=".$jobid; ?>'"><font color="Blue">已采集</font></a></td>
<td width="28" class="tablerowhighlight">删除</td>
<td width="52" class="tablerowhighlight">是否入库</td>
</tr>
<?php 
if(is_array($contents)){
	foreach($contents as $content){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td colspan="2"><input type="checkbox" name="contentid[]"  id="contentid[]" value="<?=$content['Id']?>"></td>
<td align="left"> <? if($content['Title']!="") echo $content['Title']; else echo "[无标题]"; ?>&nbsp;&nbsp;&nbsp;&nbsp; [<a href="<?=$content['PageUrl']?>" target="_blank">打开原文</a>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=viewcontent&contentid=<?=$content['Id']?>"><? if($content['Spidered']==0) echo "<font color=red>获取内容</font>]"; else echo "<font color=green>查看内容</font>]";?></a>
</td>
<td><?=$content['JobName']?></td>
<td><?=$content['CreateOn']?></td>
<td><? if($content['Spidered']==1) echo "<font color=green>√</font>";else echo "<font color=red>×</font>";?></td>
<td><a href="javascript:if(confirm('确认删除该条记录吗?'))location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&jobid=<?=$jobid?>&contentid=<?=$content['Id']?>'">删除</a></td>
<td><? if($content['IsOut']==1) echo "已入库"; else echo "尚未入库"; ?></td>
</tr>
<?php 
}
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td>
<input type="submit" name="submitsd" value="批量删除" onClick="if(confirm('确认删除选定记录吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">&nbsp;&nbsp;
</td>
  </tr></form>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center><?=$pages?></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	  <p>这里是采集内容（未入库）的列表，您可以删除不需要发布入库的文章，尚未采集的文章在同样可以查看（查看的过程中系统将自动进行采集）</p>    </td>
  </tr>
</table>
</body>
</html>