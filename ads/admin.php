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
defined("IN_PHPCMS") or exit ("Access Denied");
define("MOD_ROOT", PHPCMS_ROOT."/".$mod);

require PHPCMS_ROOT."/class/date.php";
require MOD_ROOT."/config.php";
require MOD_ROOT."/include/functions.php";
require MOD_ROOT."/extension.php";

$date = new phpcms_date;

require MOD_ROOT."/admin/".$file.".php";
?>