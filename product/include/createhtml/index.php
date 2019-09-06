<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if($MOD['ishtml']==0) return FALSE;

$head['title'] = $MOD['seo_title'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];

$childcats = subcat($mod);

$templateid = $MOD['templateid'] ? $MOD['templateid'] : 'index';
$filename = PHPCMS_ROOT.'/'.$mod.'/'.$PHPCMS['index'].'.'.$PHPCMS['fileext'];
ob_start();
include template($mod, $templateid);
$data = ob_get_contents();
ob_clean();
file_put_contents($filename, $data);
return TRUE;
?>