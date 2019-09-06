<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if(!$CHA['ishtml']) return FALSE;

if(!isset($page)) $page = 1;

$count = $spe->get_count('disabled=0');
$pagesize = $PHPCMS['pagesize'];
$pagenumber = ceil($count/$pagesize);

$head['title'] = $CHA['channelname'];
$head['keywords'] = $CHA['seo_keywords'];
$head['description'] = $CHA['seo_description'];

$position = '';

for($page = 1; $page <= $pagenumber; $page++)
{
	$filename = PHPCMS_ROOT.'/'.special_listurl('path', $page);
	ob_start();
	include template($module, 'special_list');
	$data = ob_get_contents();
	ob_clean();
	file_put_contents($filename, $data);
}
return TRUE;
?>