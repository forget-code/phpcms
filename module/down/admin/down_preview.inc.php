<?php
defined('IN_PHPCMS') or exit('Access Denied');
$downid = intval($downid);
$downid or showmessage($LANG['id_download_not_air'] ,$referer);
@extract($d->get_one());
$adddate=date('Y-m-d', $addtime);
$thumb = imgurl($thumb);
$CAT = cache_read('category_'.$catid.'.php');
$catname = $CAT['catname'];
$urls = explode("\n", $downurls);
$urls = array_map("trim", $urls);
$downurls = array();
$r = array();
foreach($urls as $k=>$url)
{
	if($url == '' || !strpos($url, "|")) continue;
	$url = explode("|", $url);
	$r['name'] = $url[0];
	$r['url'] = $url[1];
	$downurls[] = $r;
}
$myfields = cache_read('phpcms_'.$mod.'_'.$channelid.'_fields.php');
$fields = array();
if(is_array($myfields))
{
	foreach($myfields as $k=>$v)
	{
		$myfield = $v['name'];
		$fields[] = array('title'=>$v['title'],'value'=>$$myfield);
	}
}
include admintpl($mod.'_preview');
?>