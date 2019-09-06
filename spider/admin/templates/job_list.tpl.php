<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder"><form method="post" name="myform">
  <tr>
    <th colspan=14><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage"><font color="white">采集任务管理</font></a></th>
  </tr>
<tr align="center">
<td width="3%" class="tablerowhighlight">选</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="*" class="tablerowhighlight">任务名称</td>
<td width="8%" class="tablerowhighlight">任务描述</td>
<td width="10%" class="tablerowhighlight">所属站点</td>
<td width="84" class="tablerowhighlight">添加更新时间</td>
<td width="84" class="tablerowhighlight">采集时间</td>
<td width="26" class="tablerowhighlight">测试</td>
<td width="26" class="tablerowhighlight">共享</td>
<td width="34%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($jobs)){
	foreach($jobs as $job){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="jobid[]"  id="jobid[]" value="<?=$job['JobId']?>"></td>
<td><?=$job['JobId']?></td>
<td> <A HREF="?mod=<?=$mod?>&file=<?=$file?>&action=modify&jobid=<?=$job['JobId']?>"><?=$job['JobName']?></A></td>
<td><?=$job['JobDescription']?></td>
<td><?=$job['SiteName']?></td>
<td><?=$job['CreateOn']?></td>
<td><?=$job['UpdateOn']?></td>
<td><a href="javascript:openwinx('?mod=<?=$mod?>&file=<?=$file?>&action=testspider&jobid=<?=$job['JobId']?>','测试采集','830','580')"><font color="Blue">测试</font></a></td>
<td><a href="javascript:openwinx('?mod=<?=$mod?>&file=<?=$file?>&action=catchinfo&jobid=<?=$job['JobId']?>&jobname=<?=$job['JobName']?>&sitename=<?=$job['SiteName']?>','共享任务规则','830','580')">共享</a></td>

<td align='left'>
<font color=red>采集操作:</font><a href="?mod=<?=$mod?>&file=collect&action=collecturl&jobid=<?=$job['JobId']?>&auto=true&currenturlid=0"><font color="Blue">采集网址</font></A>|<a href="?mod=<?=$mod?>&file=collect&action=collectcontent&jobid=<?=$job['JobId']?>"><font color="Blue">采集内容</A></font>|<a href="?mod=<?=$mod?>&file=collect&action=manage&jobid=<?=$job['JobId']?>"><font color="Blue">管理内容</font></A>|<font color="Blue"><a href="?mod=<?=$mod?>&file=collect&action=outcontent&jobid=<?=$job['JobId']?>&step=1&channelid=1"><font color="Blue">发布内容</A></font><br>
<font color=red>任务操作:</font><a href="?mod=<?=$mod?>&file=<?=$file?>&action=modify&jobid=<?=$job['JobId']?>"><font color="Blue">任务编辑</font></A>|<a href="javascript:if(confirm('确认删除该条记录吗?'))location='?mod=<?=$mod?>&file=<?=$file?>&jobid=<?=$job['JobId']?>&action=delete'"><font color="Blue">任务删除</font></A>|<a href="?mod=<?=$mod?>&file=<?=$file?>&action=jobcopy&jobid=<?=$job['JobId']?>"><font color="Blue">任务复制</font></A>|<a href="?mod=<?=$mod?>&file=<?=$file?>&action=jobout&jobid=<?=$job['JobId']?>&jname=<?=urlencode($job['JobName'])?>"><font color="Blue">任务导出</font></A>
</td>
</tr>
<?php 
	}
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td><input type="submit" name="submit" value="批量删除" onClick="if(confirm('确认删除选定的记录吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">      &nbsp;&nbsp;
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
	每一次采集都被定义成一个采集任务，在这里进行任务的添加，修改，测试和采集工作
	</td>
  </tr>
</table>
</body>
</html>