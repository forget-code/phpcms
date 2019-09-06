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
$modtitle[$mod] = "留言管理";
$menu[$mod][] = array("留言审核","?mod=".$mod."&file=guestbook&action=manage&passed=0");
$menu[$mod][] = array("留言管理","?mod=".$mod."&file=guestbook&action=manage");
$menu[$mod][] = array("模板类型","?mod=phpcms&file=templatetype&action=manage&module=guestbook");
$menu[$mod][] = array("模板管理","?mod=phpcms&file=template&action=manage&module=guestbook");
?>