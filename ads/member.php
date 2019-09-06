<?php
require './include/common.inc.php';
require PHPCMS_ROOT.'include/form.class.php';

if(!$_userid) showmessage($LANG['login_website'], $MODULE['member']['url'].'login.php?forward='.urlencode(URL));
$action = $action ? $action : 'manage';
$avatar = avatar($_userid);
switch($action)
{
	case 'manage':
	$page = $page ? intval($page) : 1;
	$pagesize = $pagesize ? intval($pagesize) : 20;
	$pages = $c_ads->page($page, 1, 0, $pagesize, $_username);
	$offset = ($page-1)*$pagesize;
	$adses = array();
	$adses = $c_ads->manage($offset, $pagesize);
	include template($mod, 'member');
	break;

	case 'edit':
	if($dosubmit)
	{
		require_once 'attachment.class.php';
		$attachment = new attachment($mod);
		if(isset($_FILES['thumb']) && !empty($_FILES['thumb']['name']))
		{
			$ads['imageurl'] = $c_ads->upload('thumb');
			if(!$ads['imageurl']) showmessage($attachment->error(), 'goback');
			$ads['imageurl'] = UPLOAD_URL.$ads['imageurl'];
		}
		if(isset($_FILES['thumb1']) && !empty($_FILES['thumb1']['name']))
		{
			$ads['s_imageurl'] = $c_ads->upload('thumb1');
			if(!$ads['s_imageurl']) showmessage($attachment->error(), 'goback');
			$ads['s_imageurl'] = UPLOAD_URL.$ads['s_imageurl'];
		}
		if(isset($_FILES['flash']) && !empty($_FILES['flash']['name']))
		{
			$ads['flashurl'] = $c_ads->upload('flash');
			if(!$ads['flashurl']) showmessage($attachment->error(), 'goback');
			$ads['flashurl'] = UPLOAD_URL.$ads['flashurl'];
		}
		if(!$c_ads->edit($ads, $adsid, $_username)) showmessage($c_ads->msg(), 'goback');
		showmessage($LANG['edit_ads_success'], '?mod=ads&file=ads');
	}
	else
	{
		$adsid = intval($adsid);
		$_ads = $places = array();
		$_ads = $c_ads->get_info($adsid, $_username);
		$places = $c_ads->get_places();
		$placeid = form::select($places, 'ads[placeid]', 'placeid', $_ads['placeid']);
		$thumb = form::file("thumb", 'thumb', 50);
		$thumb1 = form::file("thumb1", 'thumb1', 50);
		$flash = form::file('flash', 'flash');
		$code = form::editor('code');
		$formdate = form::date('ads[fromdate]',date('Y-m-d', $_ads['fromdate']));
		$todate = form::date('ads[todate]', date('Y-m-d', $_ads['todate']));
		include template($mod, 'edit');
	}
	break;

	case 'status':

	$val = intval($val);
	if(!in_array($val, array('0', '1'))) showmessage($LANG['illegal_operation'], 'goback');
	if($c_ads->status($adsid, $val, $_username)) showmessage($LANG['operation_success'], '?mod=ads&file=ads');
	break;

	case 'delete':
        if(empty($adsid))  showmessage('请选择要删除的广告', 'goback');
        if($c_ads->delete($adsid, $_username)) showmessage($LANG['operation_success'], '?mod=ads&file=ads');
	break;

	case 'view':
	$adsid = intval($adsid);
	echo "<base href='".SITE_URL."' /><SCRIPT LANGUAGE=\"JavaScript\">";
	$c_ads->view($adsid, $_username);
	echo "</script>";
	break;
}

?>