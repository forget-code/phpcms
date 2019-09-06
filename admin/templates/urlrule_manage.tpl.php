<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>URL规则管理</caption>
    <tr>
        <th width="8%">模块</th>
        <th width="10%">名称</th>
        <th width="5%">HTML</th>
        <th>URL规则</th>
        <th>URL示例</th>
        <th width="10%">管理操作</th>
    </tr>
<?php
if(is_array($data)){
	foreach($data as $r){
?>
    <tr>
        <td class="align_c"><?=$MODULE[$r['module']]['name']?></td>
        <td><?=$r['file']?></td>
        <td class="align_c"><?=($r['ishtml'] ? '<font color="red">√</font>' : '×')?></td>
        <td><?=$r['urlrule']?></td>
        <td><?=$r['example']?></td>
        <td class="align_c">
        <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&urlruleid=<?=$r['urlruleid']?>">修改</a>
        | <a href="#" onClick="confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&urlruleid=<?=$r['urlruleid']?>', '是否删除该规则')">删除</a></td>
    </tr>
<?php
	}
}
?>
</table>
<div id="pages"><?=$urlrule->pages?></div>
</body>
</html>