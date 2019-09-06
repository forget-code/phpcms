<?php
function msg($MS)
{
	global $PHPCMS;
	include template('yp', 'message');
	exit;
}

function get_modelid()
{
	global $db;
	$r = $db->get_one("SELECT modelid FROM `".DB_PRE."model` WHERE `modeltype`=2 AND `tablename`='company'");
	return $r['modelid'];
}

function yp_catpos($catid, $type)
{
	global $CATEGORY;
	if(!isset($CATEGORY[$catid])) return '';
	$pos = '';
	$arrparentid = array_filter(explode(',', $CATEGORY[$catid]['arrparentid'].','.$catid));
	foreach($arrparentid as $catid)
	{
		$pos .= '<a href="yp/'.$type.'.php?catid='.$catid.'">'.$CATEGORY[$catid]['catname'].'</a>';
	}
	return $pos;
}

function group_icon($userid)
{
	global $db,$M;
	$userid = intval($userid);
	$r = $db->get_one("SELECT groupid FROM `".DB_PRE."member_cache` WHERE `userid`='$userid'");
	return "<img src='".$M['groupimg'][$r['groupid']]."'>";
}
?>