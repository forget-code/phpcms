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

$parentpath = realpath("../");
$mod = "member";

require_once $parentpath."/common.php";
require_once PHPCMS_ROOT."/class/date.php";
require_once MOD_ROOT."/include/functions.php";
require_once MOD_ROOT."/extension.php";

$date = new phpcms_date;

@include_once PHPCMS_CACHEDIR."usergroup.php";

if($_groupid) @include_once(PHPCMS_CACHEDIR."usergroup_".$_groupid.".php");
if($_userid && $_chargetype)
{
	if($_enddate=="0000-00-00") 
	{
		$validdatenum = "<font color='blue'>无限期</font>";
	}
	else
	{
		$validdatenum = $date->get_diff($_enddate,date("Y-m-d"));
		$validdatenum = $validdatenum <= 0 ? "<font color='red'>".$validdatenum."</font>天" : $validdatenum."天";
	}
}
?>