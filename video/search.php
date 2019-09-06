<?php
error_reporting(E_ALL);
require dirname(__FILE__).'/include/common.inc.php';

$GROUP = cache_read('member_group.php');
if((isset($G) && !$G['allowsearch']) || (!isset($G) && !$GROUP['3']['allowsearch'])) showmessage('你所在的用户组不允许搜索');

require CACHE_MODEL_PATH.'video_search_form.class.php';

$form = new model_search_form($modelid);
$where = $form->get_where();
$order = $form->get_order();

if($dosubmit)
{
	require CACHE_MODEL_PATH.'video_search.class.php';
	$search = new model_search($modelid);
	$data = $search->data($page, 20);
	$pages = $search->pages;
	$total = $search->total;
	
}
$head['title'] = '视频搜索';
include template($mod, 'search');
?>