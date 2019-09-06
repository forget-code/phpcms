<?php
require './include/common.inc.php';
require MOD_ROOT.'include/video.class.php';
require_once CACHE_MODEL_PATH.$mod.'_output.class.php';

$vid = isset($vid) ? intval($vid) : 0;
if($vid <= 0) showmessage('参数错误！');

$c = new video();
//更新访问统计
require MOD_ROOT.'include/stats.class.php';
$ST = new stats();
$ST->hits($vid);
$r = $c->get($vid,3);
$vmsvid = $r['vmsvid'];
$style_projectid = $M['style_projectid'];

if(!$r || $r['status'] != 99) showmessage('您要查看的信息不存在或者还未通过审批！');
$allow_priv = true;
if($r['groupids_view'])
{
	if(!$priv_group->check('vid', $vid, 'view', $_groupid)) $allow_priv = false;
}
$C = cache_read('category_'.$r['catid'].'.php');

if(!$priv_group->check('catid', $r['catid'], 'view', $_groupid)) showmessage('您没有浏览权限');
$out = new model_output();
$data = $out->get($r);
extract($data);
//读取评论数
$comments = $c->get_comment_number($vid);
$allow_readpoint = 1;

if($C['defaultchargepoint'] || $r['readpoint'])
{
	$readpoint = $r['readpoint'] ? $r['readpoint'] : $C['defaultchargepoint'];
	$pay = load('pay_api.class.php', 'pay', 'api');
	if($C['repeatchargedays'])
	{
		if($pay->is_exchanged($vid, $C['repeatchargedays']) === FALSE)
		{
			$allow_readpoint = 0;
		}
	}
	else
	{
		session_start();
		if($_SESSION['pay_vid'] != $vid) $allow_readpoint = 0;
	}
}
if(isset($r['paginationtype']))
{
	$paginationtype = $r['paginationtype'];
	$maxcharperpage = $r['maxcharperpage'];
}
$page = $page ? $page : 1;
$title = strip_tags($title);
$head['title'] = $title.'_'.$C['catname'].'_'.$PHPCMS['sitename'];
$head['keywords'] = str_replace(' ', ',', $r['keywords']);
$head['description'] = $r['description'];

$template = $r['template'] ? $r['template'] : 'show';
if(!$C['defaultchargepoint'] && !$r['readpoint'])
{
	header('Last-Modified: '.gmdate('D, d M Y H:i:s', $r['updatetime']).' GMT');
	header('Expires: '.gmdate('D, d M Y H:i:s', $r['updatetime']+CACHE_PAGE_CONTENT_TTL).' GMT');
	header('Cache-Control: max-age='.CACHE_PAGE_CONTENT_TTL.', must-revalidate');
}
$week_time = TIME-86400*7;
$month_time = TIME-86400*30;
$day_time = TIME-86400;
$menu_selectid = $M['menu_selectid'];

//如果是专辑  则显示专辑信息
require_once MOD_ROOT.'include/special.class.php';
$special = new special();
$specialid = $specialid ? intval($specialid) : 0;
$specialid = $special->get_specialid($vid);
if($specialid)
{
	$r_special = $special->get($specialid);
	$where = '';
	$specialdata = $special->video_ajax_pages($specialid, 1, 10);
	$specialpages = $special->ajaxpages;
}

header('Last-Modified: '.gmdate('D, d M Y H:i:s', TIME).' GMT');
header('Expires: '.gmdate('D, d M Y H:i:s', TIME + CACHE_PAGE_CONTENT_TTL).' GMT');
header('Cache-Control: max-age='.CACHE_PAGE_CONTENT_TTL.', must-revalidate');
include template($mod, $template);
cache_page(CACHE_PAGE_CONTENT_TTL);
?>