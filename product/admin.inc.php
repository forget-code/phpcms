<?php
defined('IN_PHPCMS') or exit('Access Denied');

define('MOD_ROOT',PHPCMS_ROOT."/".$mod);

$CATEGORY = cache_read("categorys_".$mod.".php");
require PHPCMS_ROOT."/include/module.func.php";
require MOD_ROOT.'/include/urlrule.inc.php';
require MOD_ROOT.'/include/global.func.php';

$childcats = subcat($mod);
if(is_array($childcats))
{
	foreach($childcats as $i=>$cat)
	{
		$subcats[$i] = subcat($mod,$cat['catid']);
	}
}

if(!@include_once(MOD_ROOT."/admin/".$file.".inc.php")) showmessage($LANG['illegal_operation']);
?>