<?php 
defined('IN_PHPCMS') or exit('Access Denied');
require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';
if($CHA['ishtml']==1 && file_exists($PHPCMS['index'].'.'.$PHPCMS['fileext']))
{
	header('location:'.$PHPCMS['index'].'.'.$PHPCMS['fileext']);
	exit;
}
$head['title'] = $CHA['channelname'];
$head['keywords'] = $CHA['seo_keywords'];
$head['description'] = $CHA['seo_description'];

$childcats = subcat($channelid);

$templateid = $CHA['templateid'] ? $CHA['templateid'] : 'index';
include template($mod, $templateid);
phpcache();
?>