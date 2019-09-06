<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$channels = array();
$channels['article'] = $channels['down'] = $channels['picture'] = $channels['info']= array();
foreach($CHANNEL as $v)
{
	$module = $v['module'];
	if($v['islink'] == 0 && $MODULE[$module]['iscopy'] == 1) $channels[$module][$v['channelid']] = $v;
}

$head['title'] = $PHPCMS['seo_title'];
$head['keywords'] = $PHPCMS['seo_keywords'];
$head['description'] = $PHPCMS['seo_description'];

$channelid = 0;
$filename = PHPCMS_ROOT.'/'.$PHPCMS['index'].'.'.$PHPCMS['fileext'];
ob_start();
include template('phpcms', 'index');
$data = ob_get_contents();
ob_clean();
file_put_contents($filename, $data);
return TRUE;
?>