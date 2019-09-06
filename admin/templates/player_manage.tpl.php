<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_form">
	<tr>
    	<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage" title="管理播放器">管理播放器</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=add" title="添加播放器">添加播放器</a></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>播放器管理</caption>
    <tr>
    	<th width="5%"><strong>ID</strong></th>
        <th><strong>播放器名称</strong></th>
        <th width="20%"><strong>管理操作</strong></th>
    </tr>
    <?php 
	if(is_array($result)){
		foreach($result as $info){
	?>
    <tr>
    	<td><?=$info['playerid']?></td>
        <td><?=$info['subject']?></td>
        <td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&playerid=<?=$info['playerid']?>" title="修改">修改</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=disabled&playerid=<?=$info['playerid']?>&disabled=<?=$info['disabled']?0:1?>"><?=$info['disabled']?'<font color=#ff0000>启用</font>':'禁用'?></a> | <a href="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&playerid=<?=$info['playerid']?>', '是否删除该播放器')" title="删除">删除</a></td>
    </tr>
    <?php
		}
	}
	?>
</table>
</body>
</html>