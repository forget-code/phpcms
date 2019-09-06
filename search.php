<?php 
require dirname(__FILE__).'/include/common.inc.php';

$GROUP = cache_read('member_group.php');
if((isset($G) && !$G['allowsearch']) || (!isset($G) && !$GROUP['3']['allowsearch'])) showmessage('你所在的用户组不允许搜索');

require 'form.class.php';
require CACHE_MODEL_PATH.'content_search_form.class.php';

$form = new content_search_form();
$where = $form->get_where();
$order = $form->get_order();

if($dosubmit)
{
	require CACHE_MODEL_PATH.'content_search.class.php';
	$search = new content_search();
	$data = $search->data($page, $PHPCMS['search_pagesize']);
	$pages = $search->pages;
	$total = $search->total;
}
$head['title'] = '搜索-'.$CATEGORY[$catid]['catname'];
include template($mod, 'search');
?>