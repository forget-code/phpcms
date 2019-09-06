<?php
defined('IN_PHPCMS') or exit('Access Denied');
$pictureid = intval($pictureid);
$pictureid or showmessage($LANG['picture_id_not_null'],$referer);
@extract($pic->get_one());
$adddate = date('Y-m-d', $addtime);
$enddate = $endtime ? date('Y-m-d', $endtime) : $LANG['no_limit'];
$thumb = imgurl($thumb);
$CAT = cache_read('category_'.$catid.'.php');
$catname = $CAT['catname'];
$urls = explode("\n", $pictureurls);
$urls = array_map("trim", $urls);
$pictureurls = array();
$r = array();
foreach($urls as $k=>$url)
{
	if($url == '' || !strpos($url, "|")) continue;
	$url = explode("|", $url);
	$r['alt'] = $url[0];
	$r['src'] = strpos($url[1], "://") ? $url[1] :  imgurl($PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/'.$url[1]);
	$pictureurls[] = $r;
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