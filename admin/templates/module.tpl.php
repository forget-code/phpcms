<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>模块管理</caption>
    <tr>
        <th><strong>模块名称</strong></th>
        <th width="130"><strong>模块目录</strong></th>
        <th width="100"><strong>版本号</strong></th>
        <th width="80"><strong>安装日期</strong></th>
        <th width="80"><strong>更新日期</strong></th>
        <th width="220"><strong>管理操作</strong></th>
    </tr>
<?php 
if(is_array($data)){
	foreach($data as $module){
		$mod_root = PHPCMS_ROOT.$MODULE[$module['module']]['path'];
?>
<tr>
    <td class="align_l"><a href="?mod=phpcms&file=module&action=view&module=<?=$module['module']?>" title="发布日期：<?=$module['publishdate']?><?="\n"?>安装日期：<?=$module['installdate']?>"><?=$module['name']?></a></td>
    <td class="align_l"><?=$module['module']?></td>
    <td class="align_c"><?=$module['version']?></td>
    <td class="align_c"><?=$module['installdate']?></td>
    <td class="align_c"><?=$module['updatedate']?></td>
    <td class="align_c">
    <a href="?mod=phpcms&file=module&action=faq&module=<?=$module['module']?>" title="点击查看使用帮助">帮助</a> | 
    <?php if(file_exists($mod_root.'admin/setting.inc.php')){ ?>
    <a href="?mod=<?=$module['module']?>&file=setting">配置</a>
    <?php }else{ ?>
    <font color="#cccccc">配置</font>
    <?php } ?> | 
    <?php if(file_exists($mod_root.'admin/priv.inc.php')){ ?>
    <a href="?mod=<?=$module['module']?>&file=priv">权限</a>
    <?php }else{ ?>
    <font color="#cccccc">权限</font>
    <?php } ?> | 
    <?php
    if($module['iscore'])
    {
        echo "<font color='#cccccc'>禁止</font> | <font color='#cccccc'>禁止</font>";
    }
    else 
    {
        if($module['disabled'])	echo "<a href=\"?mod=phpcms&file=module&action=disable&value=0&module=".$module['module']."\">启用</a> | ";
        else echo "<a href=\"?mod=phpcms&file=module&action=disable&value=1&module=".$module['module']."\">禁用</a> | ";
    ?>
    <a href="javascript:if(confirm('确认卸载该模块吗？将会删除该模块所有数据')) location='?mod=phpcms&file=module&action=uninstall&module=<?=$module['module']?>'">卸载</a>
    <? } ?>
    </td>
</tr>
<?php 
	}
}
?>
</table>
</body>
</html>