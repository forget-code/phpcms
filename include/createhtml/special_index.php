<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if(!$CHA['ishtml']) return FALSE;

$head['title'] = $CHA['channelname'];
$head['keywords'] = $CHA['seo_keywords'];
$head['description'] = $CHA['seo_description'];

$position = '';
if(!isset($page)) $page = 1;

$filename = PHPCMS_ROOT.'/'.special_indexurl('path');
ob_start();
include template($module, 'special_index');
$data = ob_get_contents();
ob_clean();
file_put_contents($filename, $data);
return TRUE;
?>