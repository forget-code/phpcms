<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';

$letter = isset($letter) ? $letter : 0;
$catid = isset($catid) ? intval($catid) : 0;

$position = '';
if(!$letter)
{
	$letters = array('A','B','C','D','E','F','G','H','I','G','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$templateid = 'letter';
}
else
{
	$letters = array(''.$letter.'');
	$templateid = 'letter_list';
}

$head['title'] = ($letter ? strtoupper($letter).'-' : '').$CHA['channelname'];
$head['keywords'] = $CHA['seo_keywords'];
$head['description'] = $CHA['seo_description'];

include template($mod, $templateid);
?>