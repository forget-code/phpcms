<?php
$modtitle[$mod] = "投票管理";
$menu[$mod][] = array("<font color='0000ff'>更新链接</a>","?mod=".$mod."&file=vote&action=getcode&updatejs=1");
$menu[$mod][] = array("投票管理","?mod=".$mod."&file=vote&action=manage");
$menu[$mod][] = array("审核投票","?mod=".$mod."&file=vote&action=manage&passed=0");
$menu[$mod][] = array("模块配置","?mod=".$mod."&file=setting");
$menu[$mod][] = array("标签调用管理","?mod=".$mod."&file=tag");
?>