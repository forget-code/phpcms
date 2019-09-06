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
$out = new content_output();

$data = $out->get($r);
extract($data);
if(empty($GLOBALS['array_images'])) showmessage('此信息没有组图',$forward);
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

$head['title'] = $title;
$head['keywords'] = $r['keywords'];
$head['description'] = $r['description'];
$array_images = $GLOBALS['array_images'];
$images_number = $GLOBALS['images_number'];

include template('phpcms', 'more_pic');
?>