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
$modtitle[$mod] = "邮件列表";

$menu[$mod][] = array("获取邮件列表","?mod=".$mod."&file=mail&action=config");
$menu[$mod][] = array("管理邮件列表","?mod=".$mod."&file=mail&action=list");
$menu[$mod][] = array("群发邮件","?mod=".$mod."&file=mail&action=send");
$menu[$mod][] = array("发送邮件","?mod=".$mod."&file=mail&action=sendmail");
?>