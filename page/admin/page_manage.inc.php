<?php
defined('IN_PHPCMS') or exit('Access Denied');
$page = isset($page) ? $page : 1;
$offset = $page ? ($page-1)*$pagesize : 0;
$r = $db->get_one("SELECT COUNT(pageid) AS number FROM ".TABLE_PAGE." WHERE keyid='$keyid'");
$number = $r['number'];
$pages = phppages($number, $page, $pagesize);

$result = $db->query("SELECT * FROM ".TABLE_PAGE." WHERE keyid='$keyid' ORDER by listorder DESC LIMIT $offset,$pagesize");
$page = array();
while($r = $db->fetch_array($result))
{
	$r['adddate'] = date("Y-m-d", $r['addtime']);
	$r['url'] = $r['linkurl'] ? $r['linkurl'] : linkurl($r['filepath'],1);
	$page[] = $r;
}
$referer = urlencode("?mod=$mod&file=$file&action=manage&keyid=$keyid&page=$page");
include admintpl('page_manage');
cache_definedpage($keyid);
function cache_definedpage($keyid = 'phpcms')
{
	global $db;
	$pages = array();
	$page = array();
	$result = $db->query("SELECT title,linkurl,filepath FROM ".TABLE_PAGE." WHERE keyid='$keyid' AND passed=1 ORDER by listorder DESC ");
	while($r = $db->fetch_array($result))
	{
		$page['title'] = $r['title'];
		$page['url'] = $r['linkurl'] ? $r['linkurl'] : linkurl($r['filepath'],1);
		$pages[]=$page;
	}
	cache_write('definedpage_'.$keyid.'.php', $pages);
}
?>