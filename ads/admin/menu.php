<?php
/*
*####################################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2005-2006 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*####################################################
*/
$modtitle[$mod] = "广告管理";
$menu[$mod][] = array("添加广告","?mod=".$mod."&file=ads&action=add");
$menu[$mod][] = array("广告管理","?mod=".$mod."&file=ads&action=manage");
$menu[$mod][] = array("广告订单管理","?mod=".$mod."&file=ads&action=signlist");
$menu[$mod][] = array("添加广告位","?mod=".$mod."&file=place&action=add");
$menu[$mod][] = array("广告位管理","?mod=".$mod."&file=place&action=manage");
$menu[$mod][] = array("广告模板","?mod=phpcms&file=template&action=manage&module=".$mod);
?>