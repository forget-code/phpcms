<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';

$typeid = isset($typeid) ? intval($typeid) : 0;
$catid = isset($catid) ? intval($catid) : 0;
$TYPE = cache_read('type_'.$channelid.'.php');

if($typeid)
{
    extract($TYPE[$typeid]);
    $templateid = 'type_list';
	if(!isset($page)) $page = 1;
	$head['title'] = $name;
	$head['keywords'] = $name;
	$head['description'] = $name;
}
else
{
    $templateid = 'type';
	$head['title'] = $LANG['class'];
	$head['keywords'] = '';
	$head['description'] = '';
}

$position = '';

include template($mod, $templateid);
?>