<?php
require dirname(__FILE__).'/include/common.inc.php';
require_once 'attachment.class.php';
require_once 'admin/content.class.php';
require_once CACHE_MODEL_PATH.'content_output.class.php';

$contentid = isset($contentid) ? intval($contentid) : 0;
if($contentid <= 0) showmessage('参数错误！');

$c = new content();
$r = $c->get($contentid);
if(!$r || $r['status'] != 99) showmessage('您要查看的信息不存在或者还未通过审批！');
$allow_priv = true;
if($r['groupids_view'])
{
	if(!$priv_group->check('contentid', $contentid, 'view', $_groupid)) {
		$allow_priv = false;
	}
	if(!$allow_priv) {
		$group_extend_result = $db->query("SELECT * FROM `".DB_PRE."member_group_extend` WHERE `userid`=$_userid");
		while($e_rs = $db->fetch_array($group_extend_result)) {
			if($priv_group->check('contentid', $contentid, 'view', $e_rs['groupid'])) {
				$allow_priv = true;
				break;
			}
		}
	}
} else {
	$allow_priv = false;
	$group_extend_result = $db->query("SELECT * FROM `".DB_PRE."member_group_extend` WHERE `userid`=$_userid");
	while($e_rs = $db->fetch_array($group_extend_result)) {
		$e_groupid = $e_rs['groupid'];
		if($priv_group->check('catid', $r['catid'], 'view', $e_groupid)) {
			$allow_priv = true;
			break;
		}
	}
	if(!$allow_priv && !$priv_group->check('catid', $r['catid'], 'view', $_groupid)) showmessage('您没有浏览该栏目的权限');
}
$C = cache_read('category_'.$r['catid'].'.php');
$attachment = new attachment($mod, $r['catid']);

$out = new content_output();
$data = $out->get($r);
extract($data);

$allow_readpoint = 1;

if($C['defaultchargepoint'] || $r['readpoint'])
{
	$readpoint = $r['readpoint'] ? $r['readpoint'] : $C['defaultchargepoint'];
	$pay = load('pay_api.class.php', 'pay', 'api');
	if($C['repeatchargedays'])
	{
		if($pay->is_exchanged($contentid, $C['repeatchargedays']) === FALSE)
		{
			$allow_readpoint = 0;
		}
	}
	else
	{
		session_start();
		if($_SESSION['pay_contentid'] != $contentid) $allow_readpoint = 0;
	}
}
if(isset($r['paginationtype']))
{
	$paginationtype = $r['paginationtype'];
	$maxcharperpage = $r['maxcharperpage'];
}
$page = $page ? $page : 1;
$pages = $titles = '';
if($paginationtype==1)
{
	if(strpos($content, '[/page]')!==false)
	{
		$content = preg_replace("|\[page\](.*)\[/page\]|U", '', $content);
	}
	if(strpos($content, '[page]')!==false)
	{
		$content = str_replace('[page]', '', $content);
	}
	$content = contentpage($content, $maxcharperpage);
}
elseif($paginationtype==0)
{
	if(strpos($content, '[/page]')!==false)
	{
		$content = preg_replace("|\[page\](.*)\[/page\]|U", '', $content);
	}
	if(strpos($content, '[page]')!==false)
	{
		$content = str_replace('[page]', '', $content);
	}
}
$CONTENT_POS = strpos($content, '[page]');
if($CONTENT_POS !== false)
{
	require_once 'url.class.php';
    $curl = new url();
	$contents = array_filter(explode('[page]', $content));
	$pagenumber = count($contents);
	for($i=1; $i<=$pagenumber; $i++)
	{
		$pageurls[$i] = $curl->show($r['contentid'], $i, $r['catid'], $r['inputtime']);
	}
	if(strpos($content, '[/page]') !== false)
	{
		if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER))
		{
			foreach($m[1] as $k=>$v)
			{
				$p = $k+1;
				$titles .= '<a href="'.$pageurls[$p][0].'">'.$p.'、'.strip_tags($v).'</a>';
			}
		}
	}
	$pages = $curl->show_pages($page, $pagenumber, $pageurls);
	if($CONTENT_POS==0)//判断[page]出现的位置是否在第一位
	{
		$content = $contents[$page];
	}
	else
	{
		$content = $contents[$page-1];
	}
	if($titles)
	{
		list($title, $content) = explode('[/page]', $content);
	}
}
$title = strip_tags($title);
$head['title'] = $title.'_'.$C['catname'].'_'.$PHPCMS['sitename'];
$head['keywords'] = str_replace(' ', ',', $r['keywords']);
$head['description'] = $r['description'];

if(!$template) $template = $C['template_show'];
if(!$C['defaultchargepoint'] && !$r['readpoint'])
{
	header('Last-Modified: '.gmdate('D, d M Y H:i:s', $r['updatetime']).' GMT');
	header('Expires: '.gmdate('D, d M Y H:i:s', $r['updatetime']+CACHE_PAGE_CONTENT_TTL).' GMT');
	header('Cache-Control: max-age='.CACHE_PAGE_CONTENT_TTL.', must-revalidate');
}
include template('phpcms', $template);
cache_page(CACHE_PAGE_CONTENT_TTL);
?>