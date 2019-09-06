<?php
require_once './include/common.inc.php';
require_once './include/tag.func.php';

$head['title'] = $LANG['vote_title'];
$head['keywords'] = $LANG['vote_keywords'];
$head['description'] = $LANG['vote_description'];
$keyid = $keyid ? $keyid : 'phpcms';
$page = isset($page) ? $page : 1;
if(is_numeric($keyid) && $keyid)
{
	$channelid = $keyid;
	$CHA = cache_read('channel_'.$channelid.'.php');
	$channelurl = $CHA['channeldomain'];
}
include template('vote', 'index');
?>