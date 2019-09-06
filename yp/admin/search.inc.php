<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!$forward) $forward = '?mod='.$mod.'&file='.$file;
require CACHE_MODEL_PATH.'formguide_search_form.class.php';
$formname = $FORMGUIDE[$formid]['name'];
$form = new formguide_search_form($formid);
$where = $form->get_where();
if($dosubmit)
{
	if(!class_exists('member_search'))
	{
		require	CACHE_MODEL_PATH.'formguide_search.class.php';
	}
	$search = new formguide_search($formid);
	$data = $search->data($page, $PHPCMS['search_pagesize']);
	$pages = $search->pages;
	$total = $search->total;
	include admin_tpl('search_result');
}
?>