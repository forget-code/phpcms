<?php
$modtitle[$mod] = "会员管理";
$menu[$mod][] = array("审核新会员","?mod=".$mod."&file=member&action=check");
$menu[$mod][] = array("会员管理","?mod=".$mod."&file=member&action=manage");
$menu[$mod][] = array("会员组管理","?mod=".$mod."&file=group&action=manage");
$menu[$mod][] = array("自定义字段","?mod=phpcms&file=field&action=manage&module=".$mod."&tablename=".$CONFIG['tablepre']."member_info");
$menu[$mod][] = array("会员数据导入","?mod=".$mod."&file=import");
$menu[$mod][] = array("模块配置","?mod=".$mod."&file=setting");
?>