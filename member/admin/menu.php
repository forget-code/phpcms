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
$modtitle[$mod] = "会员管理";
$menu[$mod][] = array("审核新会员","?mod=".$mod."&file=member&action=check");
$menu[$mod][] = array("会员管理","?mod=".$mod."&file=member&action=manage");
$menu[$mod][] = array("会员组管理","?mod=".$mod."&file=usergroup&action=manage");
$menu[$mod][] = array("财务管理","?mod=".$mod."&file=finance&action=manage");
$menu[$mod][] = array("充值卡管理","?mod=".$mod."&file=paycard&action=manage");
$menu[$mod][] = array("充值管理","?mod=".$mod."&file=exchange&action=manage");
$menu[$mod][] = array("站内信件","?mod=".$mod."&file=pm&action=manage");
$menu[$mod][] = array("参数设置","?file=module&action=setting&module=".$mod);
?>