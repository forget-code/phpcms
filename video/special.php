<?php
require './include/common.inc.php';
$specialid = intval($specialid);

if($specialid)
{
	require_once MOD_ROOT.'include/special.class.php';
	$special = new special();
	$r = $special->get($specialid);
	if($r) {
		extract($r);
		$head['title'] = $title.'_'.$PHPCMS['sitename'];
		$head['keywords'] = '专辑';
		$head['description'] = $title;
	} else {
		showmessage('专辑不存在');
	}
	$urlrule = $M['url'].$URLRULE[$M['specialUrlRuleid']];
	$urlrule = str_replace('{$specialid}',$specialid,$urlrule);
	$infos = $special->list_content($specialid, $page, 20,$urlrule);
	$pages = $special->contentpages;
	
	$templateid = 'special_list' ;
}
else
{
	$urlrule = $M['url'].$URLRULE[$M['sPageUrlRuleid']];
	$templateid = 'special';
}

$head['title'] = $title;
$ttl = CACHE_PAGE_LIST_TTL;
header('Last-Modified: '.gmdate('D, d M Y H:i:s', TIME).' GMT');
header('Expires: '.gmdate('D, d M Y H:i:s', TIME + $ttl).' GMT');
header('Cache-Control: max-age='.$ttl.', must-revalidate');
include template('video', $templateid);
cache_page($ttl);
?>