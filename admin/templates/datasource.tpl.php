<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>数据源管理</caption>
  <tr>
    <th width="10%"><strong>名称</strong></th>
    <th width="20%"><strong>主机</strong></th>
    <th width="10%"><strong>帐号</strong></th>
    <th width="10%"><strong>数据库名</strong></th>
    <th width="10%"><strong>字符集</strong></th>
    <th><strong>管理操作</strong></th>
  </tr>
<?php
foreach($data as $r)
{
?>
   <tr>
    <td class="align_c"><?=$r['name']?></td>
    <td class="align_c"><?=$r['dbhost']?></td>
    <td class="align_c"><?=$r['dbuser']?></td>
    <td class="align_c"><?=$r['dbname']?></td>
    <td class="align_c"><?=$r['dbcharset']?></td>
    <td class="align_c">
	<a href="###" onClick="javascript:$.get('?mod=<?=$mod?>&file=<?=$file?>&action=link', {name: '<?=$r['name']?>'}, function(data){alert(data==1 ? '连接成功' : '连接失败');});">连接测试</a> |
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&name=<?=$r['name']?>">修改</a> |
	<a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&name=<?=urlencode($r['name'])?>','确认删除数据源 <?=$r['name']?> 吗？')">删除</a>
	</td>
  </tr>
<?php
}
?>
</table>
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>提示信息</caption>
  <tr>
    <td>
	如果需要调用本系统之外的数据库，可以通过数据源管理来保存数据库服务器配置信息，调用的时候通过数据源名称就可以进行调用了。<br />
	本功能主要应用于<a href="?mod=phpcms&file=template&action=add">get标签调用远程数据库数据</a>或者<a href="?mod=mail&file=importmail&action=choice">导出远程数据库邮件列表</a>。<br /><br />
	<span style="color:blue">get 标签调用外部数据示例（调用数据源为bbs，分类ID为1的10个最新主题，主题长度不超过25个汉字，显示更新日期）：</span><br />
{get dbsource="bbs" sql="select * from cdb_threads where fid=1 order by dateline desc" rows="10"}<br />
 &nbsp;&nbsp;&nbsp;&nbsp;主题：{str_cut($r[subject], 50)} URL：http://bbs.phpcms.cn/viewthread.php?tid={$r[tid]} 更新日期：{date('Y-m-d', $r[dateline])} <br />
{/get}
	</td>
  </tr>
</table>
</body>
</html>