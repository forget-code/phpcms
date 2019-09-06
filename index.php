<?php 
require dirname(__FILE__).'/include/common.inc.php';
if($PHPCMS['ishtml'] == 1 && file_exists(PHPCMS_ROOT.'/'.$PHPCMS['index'].'.'.$PHPCMS['fileext']))
{
	header('location:'.$PHPCMS['index'].'.'.$PHPCMS['fileext']);
	exit;
}

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

include template('phpcms', 'index');
phpcache();
?>