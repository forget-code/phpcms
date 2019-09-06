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
	if(!$priv_group->check('contentid', $contentid, 'view', $_groupid)) $allow_priv = false;
}
$C = cache_read('category_'.$r['catid'].'.php');
$attachment = new attachment($mod, $r['catid']);
if(!$priv_group->check('catid', $r['catid'], 'view', $_groupid)) showmessage('您没有浏览权限');
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
$page = max(intval($page), 1);
$pages = $titles = '';
if(strpos($content, '[page]') !== false)
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
				$titles .= '<a href="'.$pageurls[$p].'">'.$p.'、'.$v.'</a>';
			}
		}
	}
	$pages = $curl->show_pages($page, $pagenumber, $pageurls);
	$content = $contents[$page];
	if($titles)
	{
		list($title, $content) = explode('[/page]', $content);
	}
}
$title = strip_tags($title);
$head['title'] = $title.'_'.$C['catname'].'_'.$PHPCMS['sitename'];
$head['keywords'] = $r['keywords'];
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