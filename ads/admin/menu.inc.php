<?php

$modtitle[$mod] = "广告管理";
$menu[$mod][] = array("广告位管理","?mod=".$mod."&file=adsplace&action=manage");
$menu[$mod][] = array("广告订单管理","?mod=".$mod."&file=ads&action=manage");
$menu[$mod][] = array("广告模板","?mod=phpcms&file=template&action=manage&module=".$mod);
$menu[$mod][] = array("模块配置","?mod=".$mod."&file=setting");
?>