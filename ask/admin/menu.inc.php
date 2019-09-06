<?php
$modtitle[$mod] = '咨询管理';
$menu[$mod][] = array('咨询管理', '?mod='.$mod.'&file=ask');
if($_grade == 0)
{
	$menu[$mod][] = array('部门设置', '?mod='.$mod.'&file=department');
	$menu[$mod][] = array('模块配置', '?mod='.$mod.'&file=setting');
}
?>