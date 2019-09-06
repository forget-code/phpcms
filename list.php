<?php
require dirname(__FILE__).'/include/common.inc.php';

$catid = intval($catid);
if(!isset($CATEGORY[$catid])) showmessage('访问的栏目不存在！');

$C = cache_read('category_'.$catid.'.php');
extract($C);

if($db->get_one("SELECT * FROM `".DB_PRE."member_group_priv` WHERE `field`='catid' AND `value`='$catid' AND `priv`='view'"))
{
	$allow_priv = false;
	$group_extend_result = $db->query("SELECT * FROM `".DB_PRE."member_group_extend` WHERE `userid`=$_userid");
	while($e_rs = $db->fetch_array($group_extend_result)) {
		if($priv_group->check('catid', $catid, 'browse', $e_rs['groupid'])) {
			$allow_priv = true;
			break;
		}
	}
	if(!$allow_priv && !$priv_group->check('catid', $catid, 'browse', $_groupid)) showmessage('您没有浏览权限');
}
if($type == 0)
{
	$page = max(intval($page), 1);
	if($child == 1)
	{
		$arrchildid = subcat('phpcms',$catid);
		$template = $template_category;
	}
	else
	{
		$template = $template_list;
	}
}
elseif($type == 2)
{
	header('location:'.$url);
}

$catlist = submodelcat($modelid);
$arrparentid = explode(',', $arrparentid);
$parentid = $arrparentid[1];

$head['title'] = $catname.'_'.($meta_title ? $meta_title : $PHPCMS['sitename']);
$head['keywords'] = $meta_keywords;
$head['description'] = $meta_description;

$ttl = $child == 1 ? CACHE_PAGE_CATEGORY_TTL : CACHE_PAGE_LIST_TTL;
header('Last-Modified: '.gmdate('D, d M Y H:i:s', TIME).' GMT');
header('Expires: '.gmdate('D, d M Y H:i:s', TIME + $ttl).' GMT');
header('Cache-Control: max-age='.$ttl.', must-revalidate');

include template('phpcms', $template);
cache_page($ttl);
?>