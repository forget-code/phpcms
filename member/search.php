<?php
require './include/common.inc.php';
if(!$forward) $forward = HTTP_REFERER;

if((isset($G) && !$G['allowsearch']) || (!isset($G) && !$GROUP['3']['allowsearch'])) showmessage('你所在的用户组不允许搜索');
foreach($MODEL as $model)
{
	if($model['modeltype'] == 2)
	{
		$submenu[] = $model;
	}
}

require CACHE_MODEL_PATH.'member_search_form.class.php';
$modelname = $MODEL[$modelid]['name'];
$form = new member_search_form($modelid);
$where = $form->get_where();
$order = $form->get_order();
if(!class_exists('member_search'))
{
	require	CACHE_MODEL_PATH.'member_search.class.php';
}

if($dosubmit)
{
	if($modelid)
	{
		$search = new member_search($modelid);
		
		$data = $search->data($page, $PHPCMS['search_pagesize']);
		$pages = $search->pages;
		$total = $search->total;
	}
	else
	{
		$condition = '';
		$condition .= $username ? " AND m.username like '%$username%'" : '';
		$condition .= $groupid ? " AND m.groupid='$groupid'" : '';
		$condition .= $email ? " AND m.email='$email'" : '';
		$condition .= $frommoney ? " and m.amount>='$frommoney'" : '';
		$condition .= $tomoney ? " AND m.amount<='$tomoney'" : '';
		$condition .= $frompoint ? " AND m.point>='$frompoint'" : '';
		$condition .= $topoint ? " AND m.point<='$topoint'" : '';
		$condition .= $fromcredit ? " AND m.credit>='$fromcredit'" : '';
		$condition .= $tocredit ? " AND m.credit<='$tocredit'" : '';
		$condition .= $modelid ? " AND m.modelid='$modelid'" : '';
		$condition .= $areaid ? " AND m.areaid='$areaid'" : '';
		$condition .= (isset($disabled) && ($disabled != -1) && !empty($disabled)) ? " AND m.disabled='$disabled'" : '';
		$order = 'm.userid ASC';
		$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 10;
		$data = $member->listinfo($condition, $order, $page, $pagesize, 1);
		if($data) $total = count($data);
	}
}

include template($mod, 'search_index');
?>