<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>采集任务管理</caption>
    <tr align="center">

		<th width="3%"><strong>选</strong></th>
        <th width="5%"><strong>ID</strong></th>
		<th width="*"><strong>名称</strong></th>
		<th width="8%"><strong>任务描述</strong></th>
		<th width="10%"><strong>所属站点</strong></th>
		<th width="15%"><strong>时间</strong></th>
		<th width="5%"><strong>测试</strong></th>
		<th width="5%"><strong>共享</strong></th>
		<th width="30%"><strong>管理操作</strong></th>

	</tr>
    <?php
	if(is_array($jobs))
	{
		foreach($jobs as $job){
	?>
    <tr>
    	<td class="align_c"><input type="checkbox" id="checkbox" name="jobid[]" value="<?=$job['JobId']?>"></td>
    	<td class="align_c"><?=$job['JobId']?></td>
        <td class="align_c"><A HREF="?mod=<?=$mod?>&file=<?=$file?>&action=modify&jobid=<?=$job['JobId']?>"><?=$job['JobName']?></A></td>
        <td class="align_c"><?=$job['JobDescription']?></td>
        <td class="align_c"><?=$job['SiteName']?></td>
        <td class="align_c">添加:<?=date('y-m-d',$job['CreateOn'])?><br>采集:<?=($job['UpdateOn']==0) ? '尚未采集' : date("y-m-d H:i",$job['UpdateOn']);
?></td>
        <td class="align_c"><a href="javascript:openwinx('?mod=<?=$mod?>&file=<?=$file?>&action=testspider&jobid=<?=$job['JobId']?>','测试采集','830','580')"><font color="Blue">测试</font></a></td>
        <td class="align_c"><a href="http://bbs.phpcms.cn/forum-37-1.html" target="_blank">共享</a></td>
        <td class="align_c">
		<font color=red>采集:</font><a href="?mod=<?=$mod?>&file=collect&action=collecturl&jobid=<?=$job['JobId']?>&auto=true&currenturlid=0"><font color="Blue">采集网址</font></A>|<a href="?mod=<?=$mod?>&file=collect&action=collectcontent&jobid=<?=$job['JobId']?>"><font color="Blue">采集内容</A></font>|<a href="?mod=<?=$mod?>&file=collect&action=manage&jobid=<?=$job['JobId']?>"><font color="Blue">管理内容</font></A>|<font color="Blue"><a href="?mod=<?=$mod?>&file=collect&action=outcontent&jobid=<?=$job['JobId']?>&step=1&channelid=1"><font color="Blue">发布内容</A></font><br><font color=red>任务:</font><a href="?mod=<?=$mod?>&file=<?=$file?>&action=modify&jobid=<?=$job['JobId']?>"><font color="Blue">任务编辑</font></A>|<a href="javascript:if(confirm('确认删除该条记录吗?'))location='?mod=<?=$mod?>&file=<?=$file?>&jobid=<?=$job['JobId']?>&action=delete'"><font color="Blue">任务删除</font></A>|<a href="?mod=<?=$mod?>&file=<?=$file?>&action=jobcopy&jobid=<?=$job['JobId']?>"><font color="Blue">任务复制</font></A>|<a href="?mod=<?=$mod?>&file=<?=$file?>&action=jobout&jobid=<?=$job['JobId']?>&jname=<?=urlencode($job['JobName'])?>"><font color="Blue">任务导出</font></A>

		</td>

    </tr>
    <?php
			}
		}
	?> 
	</table> 
      <div class="button_box">
	 <input type="button" value=" 全选 " onClick="checkall()">
     <input type="button" onClick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&forward=<?=urlencode(URL)?>';myform.submit();" value=" 删除 ">
	 </div>
<div id="pages"><?=$pages?></div>
</form>

<br />
<table cellpadding="2" cellspacing="1" border="0" align=center class="table_info" >
  <tr>
    <caption>操作说明</caption>
  </tr>
  <tr>
    <td class="tablerow">
	  <p>每一次采集都被定义成一个采集任务，在这里进行任务的添加，修改，测试和采集工作</p>    </td>
  </tr>
</table>
</body>
</html>
