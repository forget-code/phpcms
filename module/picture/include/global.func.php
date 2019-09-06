<?php 
defined('IN_PHPCMS') or exit('Access Denied');
function msg($msg, $referer = '', $timeout = 2000)
{
	if(!$referer)
	{
		global $PHP_REFERER; 
		$referer = $PHP_REFERER;
	}
	echo '<table width="100%" cellpadding="0" cellspacing="0"  height="100%" bgcolor="#F1F3F5">';
	echo '<tr><td style="font-size:12px;color:blue;">';
	echo '<a href="'.$referer.'">'.$msg.' Click To Back</a>';
	echo '</td></tr></table>';
	echo '<script>setTimeout("window.location=\''.$referer.'\'", '.$timeout.');</script>';
	exit;
}
function picpage($catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $pagenumber=1, $page=1)
{
	$itemurl = linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime));

	$pages = '<a href="'.linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, 1)).'">|&lt;</a> ';//首页

	$prepageurl = $page<=1 ? linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, 1)) : linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $page-1));//上一页
	$pages .= '<a href="'.$prepageurl.'">&lt;&lt;</a> ';

	if($page%10 == 0)
	{
		$i = $page-9;
		$t = $page;
	}
	else
	{
		$i = intval($page/10)*10+1;
		$t = $i+9;
	}
	if($t > $pagenumber) $t = $pagenumber;
	for(; $i<=$t; $i++)
	{
		$pages .= $page==$i ? '<strong>['.$i.']</strong> ' : '[<a href="'.linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $i)).'">'.$i.'</a>] ';        
	}

	$nextpageurl = $page>=$pagenumber ? linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $pagenumber)) : linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $page+1));//下一页
	$pages .= '<a href="'.$nextpageurl.'">&gt;&gt;</a> ';

	$pages.='<a href="'.linkurl(item_url('url', $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $pagenumber)).'">&gt;|</a> ';//尾页
	if(!$ishtml)
	{
		$pages = '<form action="show.php">'.$pages.'<input type="hidden" name="itemid" value="'.$itemid.'" /><input type="text" size="4" name="page" /></form>';
	}

	return $pages;
}

function update_picture_url($pictureid)
{
	global $db, $channelid;
	$pictureid = intval($pictureid);
	$channelid = intval($channelid);
	if(!$pictureid || !$channelid) return FALSE;
	$picture = $db->get_one("select * from ".channel_table('picture', $channelid)." where pictureid=$pictureid ");
	if(empty($picture))  return FALSE;
	$linkurl = item_url('url', $picture['catid'], $picture['ishtml'], $picture['urlruleid'], $picture['htmldir'], $picture['prefix'], $pictureid, $picture['addtime']);
	$db->query("update ".channel_table('picture', $channelid)." set linkurl='$linkurl' where pictureid=$pictureid ");
	return TRUE;
}
?>