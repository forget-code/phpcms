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
define('MOD_ROOT',dirname(__FILE__));
$mod = "ads";

require "../common.php";
require PHPCMS_ROOT."/class/date.php";

require MOD_ROOT."/config.php";
require MOD_ROOT."/include/functions.php";
require MOD_ROOT."/extension.php";

$date = new phpcms_date;
?>