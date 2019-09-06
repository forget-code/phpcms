<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($CHA['ishtml']==0) return FALSE;

$head['title'] = $CHA['channelname'];
$head['keywords'] = $CHA['seo_keywords'];
$head['description'] = $CHA['seo_description'];

$childcats = subcat($channelid);

$templateid = $CHA['templateid'] ? $CHA['templateid'] : 'index';
$filename = PHPCMS_ROOT.'/'.$CHA['channeldir'].'/'.$PHPCMS['index'].'.'.$PHPCMS['fileext'];
ob_start();
include template($mod, $templateid);
$data = ob_get_contents();
ob_clean();
file_put_contents($filename, $data);
chmod($filename, 0777);
return TRUE;
?>