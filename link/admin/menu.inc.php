<?php
$modtitle[$mod] = "友情链接";
$menu[$mod][] = array("<font color='0000ff'>更新链接</a>","?mod=".$mod."&file=createhtml");
$menu[$mod][] = array("添加链接","?mod=".$mod."&file=link&action=add");
$menu[$mod][] = array("审核链接","?mod=".$mod."&file=link&action=manage&passed=0");
$menu[$mod][] = array("链接管理","?mod=".$mod."&file=link&action=manage");
$menu[$mod][] = array("类别管理","?mod=phpcms&file=type&action=manage&keyid=".$mod);
$menu[$mod][] = array("模块配置","?mod=".$mod."&file=setting");
$menu[$mod][] = array("标签调用管理","?mod=".$mod."&file=tag");
?>