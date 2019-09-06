<?php 
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/module/'.$mod.'/include/common.inc.php';

if(!isset($page)) $page = 1;
$position = '';

$head['title'] = $CHA['channelname'];
$head['keywords'] = $CHA['seo_keywords'];
$head['description'] = $CHA['seo_description'];


include template($mod, 'special_list');
?>