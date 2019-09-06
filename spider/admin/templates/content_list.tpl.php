<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" name="myform">
<table cellpadding="0" cellspacing="1" border="0" width="100%" height="30" class="table_list">
  <tr align="center">
    <th  width="20%" class="tablerowhighlight">&nbsp;查看：&nbsp;<?=$selectJobContent?></th>
    <th  class="tablerowhighlight">&nbsp;按任务操作：&nbsp;<?=$deleteJobContent?>
	<input type="submit" name="submitsendjobcontent" value="发布" onClick="document.myform.action='?mod=<?=$mod?>&file=collect&action=outcontent&step=1&jobid='+document.getElementById('deleteJobContent').value+''">
	<input type="button" name="submitdeletejobcontent" value="删除" onClick="if(confirm('确认删除该任务下的全部记录吗？')) { document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=deletejobcontent';document.myform.submit();}">
	<input type="button" name="submitclearUrlcache" value="删网址缓存" onClick="if(confirm('删除网址缓存后，以后可以重复采集该网址内容，确认删除网址缓存记录吗？')){ document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=clearUrlcache';document.myform.submit();}">
	<input type="button" name="submitclearTitlecache" value="删标题缓存" onClick="if(confirm('删除标题缓存后，以后可以重复发布该标题内容，确认删除标题缓存记录吗？')){ document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=clearTitlecache';document.myform.submit();}"></th>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="table_list">
  <caption><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">采集内容管理</a></caption>
<tr align="center">
<td width="3%" colspan="2" class="tablerowhighlight">选</td>
<td width="*" class="tablerowhighlight"><a href="javascript:window.location='?mod=<?=$mod?>&file=collect&action=manage&sortby=Title&desc=<?echo ($desc+1);if(isset($jobid)) echo "&jobid=".$jobid; ?>';"><font color="Blue">文章标题</font></a></td>
<td width="12%" class="tablerowhighlight"><a href="javascript:window.location='?mod=<?=$mod?>&file=collect&action=manage&sortby=<?=TABLE_SPIDER_URLS?>.JobId&desc=<?echo ($desc+1);if(isset($jobid)) echo "&jobid=".$jobid; ?>'"><font color="Blue">所属任务<font color="Blue"></a></td>
<td width="40" class="tablerowhighlight"><a href="javascript:window.location='?mod=<?=$mod?>&file=collect&action=manage&sortby=Spidered&desc=<?echo ($desc+1);if(isset($jobid)) echo "&jobid=".$jobid; ?>'"><font color="Blue">已采集</font></a></td>
<td width="12%" class="tablerowhighlight"><a href="javascript:window.location='?mod=<?=$mod?>&file=collect&action=manage&sortby=SpiderOn&desc=<?echo ($desc+1);if(isset($jobid)) echo "&jobid=".$jobid; ?>'"><font color="Blue">采集时间</font></a></td>
<td width="52" class="tablerowhighlight">已入库</td>
<td width="28" class="tablerowhighlight">删除</td>
</tr>
<?php 
if(is_array($contents))
{
	foreach($contents as $content)
	{
?>
<tr align="center">
<td colspan="2"><input type="checkbox" id="checkbox" name="contentid[]" value="<?=$content['Id']?>"></td>
<td align="left"> <? if($content['Title']!="") echo $content['Title']; else echo "[无标题]"; ?>&nbsp;&nbsp;&nbsp;&nbsp; [<a href="<?=$content['PageUrl']?>" target="_blank">打开原文</a>
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=viewcontent&contentid=<?=$content['Id']?>"><? if($content['Spidered']==0) echo "<font color=red>获取内容</font>"; else echo "<font color=green>查看内容</font>";?></a>]
</td>
<td><?=$content['JobName']?></td>

<td><? if($content['Spidered']==1){?><a href="javascript:if(confirm('设置该条记录为未采集状态吗?'))location='?mod=<?=$mod?>&file=<?=$file?>&action=Spidered&jobid=<?=$jobid?>&contentid=<?=$content['Id']?>&status=0'" title="采集日期<?=date('Y-m-d H:i:s',$content['CreateOn'])?>,点击切换为未采集状态！"><span color=green>√</span></a><?}else{?><a href="?mod=<?=$mod?>&file=<?=$file?>&action=viewcontent&contentid=<?=$content['Id']?>" title="点击获取内容！"><font color=red>×</font></a><?}?></td>
<td align="center"><span title="<?=($content['SpiderOn']>0)?date('Y-m-d H:i:s',$content['SpiderOn']):'尚未采集'?>"><?=($content['SpiderOn']>0)?date('Y-m-d H:i',$content['SpiderOn']):'<font color=red>×</font>'?></td>
<td><? if($content['IsOut']==1){?><a href="javascript:if(confirm('设置该条记录为未入库状态吗?'))location='?mod=<?=$mod?>&file=<?=$file?>&action=IsOut&jobid=<?=$jobid?>&contentid=<?=$content['Id']?>&status=0'" title="点击切换为未入库状态！"><font color="red">已入库</font></a><?}else{?><a href="javascript:if(confirm('设置该条记录为已入库状态吗?'))location='?mod=<?=$mod?>&file=<?=$file?>&action=IsOut&jobid=<?=$jobid?>&contentid=<?=$content['Id']?>&status=1'" title="点击切换为已入库状态！">未入库</a><?}?></td>
<td><a href="javascript:if(confirm('确认删除该条记录吗?'))location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&jobid=<?=$jobid?>&contentid=<?=$content['Id']?>'">删除</a></td>
</tr>
<?php 
	}
}
?>
</table>
      <div class="button_box">
	 <input type="button" value=" 全选 " onClick="checkall()">
	 <input type="button" onClick="if(confirm('确认删除选定记录吗？'))document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&forward=<?=urlencode(URL)?>';myform.submit();" value=" 删除 ">
	  <input type="button" onClick="if(confirm('确认删除选定记录吗？'))document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=deleteUrlcache&forward=<?=urlencode(URL)?>';myform.submit();" id="clearUrlcache" value="删网址缓存" >
	  <input type="button" onClick="if(confirm('确认删除选定记录吗？'))document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=deleteTitlecache&forward=<?=urlencode(URL)?>';myform.submit();" id="clearUrlcache" value="删标题缓存" >
	  <input type="button" onClick="if(confirm('设置该条记录为已入库状态吗'))document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=IsOut&status=1&forward=<?=urlencode(URL)?>';myform.submit();" id="clearUrlcache" value="已入库" >
	  <input type="button" onClick="if(confirm('设置该条记录为未入库状态吗'))document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=IsOut&status=0&forward=<?=urlencode(URL)?>';myform.submit();" id="clearUrlcache" value="未入库" >
<!--	  <input type="button" onClick="if(confirm('设置该条记录为已采集状态吗'))document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=Spidered&status=1&forward=<?=urlencode(URL)?>';myform.submit();" id="clearUrlcache" value="已采集" >
!-->
	  <input type="button" onClick="if(confirm('设置该条记录为未采集状态吗'))document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=Spidered&status=0&forward=<?=urlencode(URL)?>';myform.submit();" id="clearUrlcache" value="未采集" >

	 </div>
<div id="pages"><?=$pages?></div>
</form>


<table cellpadding="2" cellspacing="1" border="0" align=center class="table_info" >
<caption>提示信息</caption>
  <tr>
    <td class="tablerow">
	  <p>这里是采集内容（未入库）的列表，您可以删除不需要发布入库的文章，尚未采集的文章在同样可以查看（查看的过程中系统将自动进行采集）</p>    </td>
  </tr>
</table>
</body>
</html>