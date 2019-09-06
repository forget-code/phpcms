<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>外部数据导入管理</caption>
	<tr>
    	<th><strong>配置名称</strong></th>
        <th><strong>配置说明</strong></th>
        <th><strong>修改时间</strong></th>
        <th><strong>上次导入时间</strong></th>
        <th><strong>上次导入最大ID</strong></th>
        <th><strong>管理操作</strong></th>
    </tr>
    <?php
		if(is_array($info) && !empty($info))
		{
			foreach($info as $k=>$v)
			{
				$key = key($v);
	?>
    <tr>
    	<td class="align_c"><?=$v[$key]['name']?></td>
        <td class="align_c"><?=$v[$key]['note']?></td>
        <td class="align_c"><?=$v[$key]['edittime'] ? date('Y-m-d H:i:s', $v[$key]['edittime']) : ''?></td>
        <td class="align_c"><?=$v[$key]['importtime'] ? date('Y-m-d H:i:s', $v[$key]['importtime']) : ''?></td>
        <td class="align_c"><?=$v[$key]['maxid']?></td>
        <td class="align_c"><a href="#" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=import&name=<?=$v[$key]['name']?>&type=<?=$type?>','确认开始导入数据吗？')">执行</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=choice&name=<?=$v[$key]['name']?>&type=<?=$type?>">修改</a> | <a href="#" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&name=<?=$v[$key]['name']?>&type=<?=$type?>','确认删除配置文件么？此操作不可恢复')">删除</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&name=<?=$v[$key]['name']?>">下载配置</a></td>
    </tr>
    <?php
			}
		}
	?>
    <tr>
    </tr>
</table>
</body>
</html>