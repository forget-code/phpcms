<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function listpages($catid, $total, $page=1, $perpage=20)
{
	global $LANG;
	$goto = '"'.linkurl(cat_url('url', $catid, '"+$("page").value+"')).'"';
	$page = $page > 0 ? $page : 1;
	$pages = ceil($total/$perpage);
	$page = min($pages,$page);
	$prepg = $page-1;
	$nextpg = $page==$pages ? 0 : ($page+1);
	if($total<1) return false;
	$pagenav = $LANG['total'].'<b>'.$total.'</b>&nbsp;&nbsp;&nbsp;&nbsp;';
	$pagenav.= $prepg ? "<a href='".linkurl(cat_url('url', $catid, 0))."'>".$LANG['first']."</a>&nbsp;<a href='".linkurl(cat_url('url', $catid, $prepg))."'>".$LANG['previous']."</a>&nbsp;" : $LANG['first']."&nbsp;".$LANG['previous']."&nbsp;";
	$pagenav.= $nextpg ? "<a href='".linkurl(cat_url('url', $catid, $nextpg))."'>".$LANG['next']."</a>&nbsp;<a href='".linkurl(cat_url('url', $catid, $pages))."'>".$LANG['last']."</a>&nbsp;" : $LANG['next']."&nbsp;".$LANG['last']."&nbsp;";
	$pagenav.= $LANG['page'].": <b><font color=red>$page</font>/$pages</b>&nbsp;&nbsp;<input type='text' name='page' id='page' class='page' size='3' onKeyDown='if(event.keyCode==13) {window.location=$goto; return false;}'> <input type='button' value='GO' class='gotopage' style='width:30px' onclick='window.location=$goto'>\n";
	return $pagenav;
}

function specialpages($total, $page=1, $perpage=20)
{
	global $LANG;
	$goto = '"'.linkurl(special_listurl('url', '"+$("page").value+"')).'"';
	$page = $page > 0 ? $page : 1;
	$pages = ceil($total/$perpage);
	$page = min($pages,$page);
	$prepg = $page-1;
	$nextpg = $page==$pages ? 0 : ($page+1);
	if($total<1) return false;
	$pagenav = $LANG['total']."<b>$total</b>&nbsp;&nbsp;&nbsp;&nbsp;";
	$pagenav.= $prepg ? "<a href='".linkurl(special_listurl('url', 0))."'>".$LANG['first']."</a>&nbsp;<a href='".linkurl(special_listurl('url', $prepg))."'>".$LANG['previous']."</a>&nbsp;" : $LANG['first']."&nbsp;".$LANG['previous']."&nbsp;";
	$pagenav.= $nextpg ? "<a href='".linkurl(special_listurl('url', $nextpg))."'>".$LANG['next']."</a>&nbsp;<a href='".linkurl(special_listurl('url', $pages))."'>".$LANG['last']."</a>&nbsp;" : $LANG['next']."&nbsp;".$LANG['last']."&nbsp;";
	$pagenav.= $LANG['page'].": <b><font color=red>$page</font>/$pages</b>&nbsp;&nbsp;<input type='text' name='page' id='page' class='page' size='3' onKeyDown='if(event.keyCode==13) {window.location=$goto; return false;}'> <input type='button' value='GO' class='gotopage' style='width:30px' onclick='window.location=$goto'>\n";
	return $pagenav;
}

function channel_url($type = 'url')
{
	global $CHA,$PHPCMS,$channelid;
	if($CHA['channelid'] != $channelid) channel_setting($channelid);
	$filename = $PHPCMS['index'].'.'.$PHPCMS['fileext'];
	return $type == 'url' ? ($CHA['channeldomain'] ? $CHA['channeldomain'] : $CHA['channeldir']) : $CHA['channeldir']."/".$filename;
}

function cat_url($type, $catid, $page = 0)
{
	global $CHA,$CATEGORY,$PHPCMS,$urlrule,$channelid;
	if($CHA['channelid'] != $channelid) channel_setting($channelid);
	$fileext = $PHPCMS['fileext'];
	$index = $PHPCMS['index'];
	$htmldir = $CATEGORY[$catid]['htmldir'];
	$prefix = $CATEGORY[$catid]['prefix'];
	$catdir = $CATEGORY[$catid]['catdir'];
	$parentdir = $CATEGORY[$catid]['parentdir'];
	$urlruleid = $CATEGORY[$catid]['urlruleid'];
	$html = $CATEGORY[$catid]['ishtml'] ? 'html' : 'php';
	$rule = $urlrule[$html]['cat'][$urlruleid];
	$rule = $page ? $rule['page'] : $rule['index'];
    eval("\$url = \"$rule\";");
	return ($type == 'url' && $CHA['channeldomain']) ? $CHA['channeldomain'].$url : $CHA['channeldir'].$url;
}

function item_url($type, $catid, $ishtml, $urlruleid, $htmldir, $prefix, $itemid, $addtime, $page = 0)
{
	global $CHA,$CATEGORY,$PHPCMS,$urlrule,$channelid;
	if($CHA['channelid'] != $channelid) channel_setting($channelid);
	$fileext = $PHPCMS['fileext'];
	$catdir = $CATEGORY[$catid]['catdir'];
	$parentdir = $CATEGORY[$catid]['parentdir'];
	$year = date("Y", $addtime);
	$month = date("m", $addtime);
	$day = date("d", $addtime);
	$html = $ishtml ? 'html' : 'php';
	$rule = $urlrule[$html]['item'][$urlruleid];
	$rule = $page == 0 ? $rule['index'] : $rule['page'];
    eval("\$url = \"$rule\";");
	$urlpre = ($type == 'url' && $CHA['channeldomain']) ? $CHA['channeldomain'] : $CHA['channeldir'];
	return $urlpre.$url;
}

function special_indexurl($type = 'url')
{
	global $CHA,$PHPCMS,$channelid;
	if($CHA['channelid'] != $channelid) channel_setting($channelid);
	$filename = $PHPCMS['index'].'.'.$PHPCMS['fileext'];
	return (($type == 'url' && $CHA['channeldomain']) ? $CHA['channeldomain'] : $CHA['channeldir']).'/special/'.$filename;
}

function special_listurl($type, $page = 0)
{
	global $PHPCMS,$CHA,$urlrule,$channelid;
	if($CHA['channelid'] != $channelid) channel_setting($channelid);
	if($CHA['ishtml'])
	{
		$html = 'html';
		$urlruleid = $CHA['special_html_urlruleid'];
	    $fileext = $PHPCMS['fileext'];
	}
	else
	{
		$html = 'php';
		$urlruleid = $CHA['special_php_urlruleid'];
	}
	$rule = $urlrule[$html]['special'][$urlruleid];
	$rule = $page ? $rule['list'] : $rule['index'];
    eval("\$url = \"$rule\";");
	$urlpre = ($type == 'url' && $CHA['channeldomain']) ? $CHA['channeldomain'] : $CHA['channeldir'];
	return $urlpre.$url;
}

function special_showurl($type, $specialid, $addtime, $prefix = 'special_')
{
	global $PHPCMS,$CHA,$urlrule,$channelid;
	if($CHA['channelid'] != $channelid) channel_setting($channelid);
	$year = date('Y', $addtime);
	$month = date('m', $addtime);
	$day = date('d', $addtime);
	if($CHA['ishtml'])
	{
		$html = 'html';
		$urlruleid = $CHA['special_html_urlruleid'];
	    $fileext = $PHPCMS['fileext'];
	}
	else
	{
		$html = 'php';
		$urlruleid = $CHA['special_php_urlruleid'];
	}
	$rule = $urlrule[$html]['special'][$urlruleid]['show'];
    eval("\$url = \"$rule\";");
	$urlpre = ($type == 'url' && $CHA['channeldomain']) ? $CHA['channeldomain'] : $CHA['channeldir'];
	return $urlpre.$url;
}
?>