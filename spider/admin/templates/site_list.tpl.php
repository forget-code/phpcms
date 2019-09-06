<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>采集站点管理</caption>
    <tr align="center">
		<th width="5%"><strong>选</strong></th>
        <th width="5%"><strong>ID</strong></th>
		<th width="*"><strong>站点名称</strong></th>
		<th width="15%"><strong>站点URL</strong></th>
		<th width="20%"><strong>站点描述</strong></th>
		<th width="30%"><strong>相关操作</strong></th>
	</tr>
    <?php
	if(is_array($sites)){
		foreach($sites as $site){
	?>
    <tr>
    	<td class="align_c"><input type="checkbox" id="checkbox" name="siteid[]" value="<?=$site['Id']?>"></td>
    	<td class="align_c"><?=$site['Id']?></td>
        <td class="align_c"><A HREF="?mod=spider&file=sitemgr&action=modify&siteid=<?=$site['Id']?>" title="编辑该站点规则"><?=$site['SiteName']?></A></td>
        <td class="align_c"><a href="<?=$site['SiteUrl']?>" target="_blank"><?=$site['SiteUrl']?></a></td>
        <td class="align_c"><?=$site['Description']?></td>
        <td class="align_c"><a href="http://bbs.phpcms.cn/forum-37-1.html" target="_blank">共享</a>
<A HREF="?mod=spider&file=sitemgr&action=modify&siteid=<?=$site['Id']?>">编辑</A>
<A HREF="javascript:if(confirm('确认删除该站点吗?')) location='?mod=spider&file=sitemgr&action=delete&siteid=<?=$site['Id']?>'">删除</A>
<a href="?mod=<?=$mod?>&file=sitemgr&action=siteout&siteid=<?=$site['Id']?>&sname=<?=urlencode($site['SiteName'])?>">导出站点规则</A>
<A HREF="?mod=spider&file=jobmgr&action=add&loadsiterule=<?=$site['Id']?>"><font color='blue'>添加任务</font></A></td>
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
<table cellpadding="2" cellspacing="1" class="table_info">
<tr>
    <caption>操作说明</caption>
  <tr> 
      <td>采集站点管理是方便您对采集的来源站进行分类管理，先建立采集站点再在其下面建立采集任务！
       </td>
    </tr>
  </table>

</body>
</html>