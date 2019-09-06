<?php 
defined('IN_PHPCMS') or exit('Access Denied');

defined('IN_FRONT') && !isset($CHANNEL[$channelid]) && showmessage("The channelid $channelid is not exists or access denied !");
if(!$CHANNEL[$channelid]['islink'])
{
    require_once PHPCMS_ROOT.'/include/channel.func.php';
    require_once PHPCMS_ROOT.'/include/urlrule.inc.php';
    $CHA = $TEMP['cha'][$channelid] = cache_read('channel_'.$channelid.'.php');
    $CATEGORY = $TEMP['category'][$channelid] = cache_read('categorys_'.$channelid.'.php');
	$uploadpath = $CHA['uploaddir'] ? PHPCMS_PATH.$CHA['channeldir'].'/'.$CHA['uploaddir'].'/' : $uploadpath;
	$skindir = $CHA['skinid'] ? PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$CHA['skinid'] : $skindir;
	$channelname = $CHA['channelname'];
    $channelurl = $CHA['linkurl'];
}
?>