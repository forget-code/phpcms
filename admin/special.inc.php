<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/admin/include/special.class.php';
require_once PHPCMS_ROOT.'/include/tree.class.php';

$tree = new tree;

if(is_numeric($keyid))
{
	$channelid = intval($keyid);
	$module = $CHANNEL[$channelid]['module'];
	require_once PHPCMS_ROOT.'/include/channel.inc.php';
}
else
{
	$module = $keyid;
}

require_once PHPCMS_ROOT.'/'.moduledir($module).'/include/tag.func.php';

$submenu = array
(
	array($LANG['manage_index'], '?mod='.$mod.'&file=special&action=manage&keyid='.$keyid),
	array($LANG['add_special'], '?mod='.$mod.'&file=special&action=add&keyid='.$keyid),
	array($LANG['update_special_link'], '?mod='.$mod.'&file=special&action=update_linkurl&keyid='.$keyid),
	array($LANG['update_special_html'], '?mod='.$mod.'&file=special&action=createhtml&keyid='.$keyid),
);

$menu = adminmenu($LANG['specail_manage'], $submenu);

$specialid = isset($specialid) ? intval($specialid) : 0;

$spe = new special($keyid, $specialid);

$action = $action ? $action : 'manage';

switch($action)
{
	case 'add':
		if($dosubmit)
		{
		    if(!$special['specialname']) showmessage($LANG['specail_topic_name_no_null']);
			if(!$subspecialname[0]) showmessage($LANG['one_child_category_at_least']);

			$special['addtime'] = $PHP_TIME;

			$specialid = $spe->add($special);
			$specialids = $spe->add_subspecial($subspecialname);
			createhtml('special_show', PHPCMS_ROOT);
			foreach($specialids as $specialid)
			{
				createhtml('special_show', PHPCMS_ROOT);
			}

			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$templateid = showtpl($CHA['module'], 'special_show', 'special[templateid]');
			$skinid = showskin('special[skinid]');

			include admintpl('special_add');
		}
		break;

	case 'edit':
		if($dosubmit)
		{
		    if(!$special['specialname']) showmessage($LANG['specail_topic_name_no_null']);

			$spe->edit($special);

			$newsubspecialname = isset($newsubspecialname) ? $newsubspecialname : array();
			$delete = isset($delete) ? $delete : array();

			$spe->update_subspecial($subspecialname, $newsubspecialname, $delete);
			createhtml('special_show', PHPCMS_ROOT);

			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$special = $spe->get_info();
			if(!$special) showmessage($LANG['not_exist_specail']);

			@extract(new_htmlspecialchars($special));

			$templateid = showtpl($CHA['module'], 'special_show', 'special[templateid]', $templateid);
			$skinid = showskin('special[skinid]', $skinid);

			include admintpl('special_edit');
		}
		break;

	case 'manage':
		$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 10;
		$page = isset($page) ? intval($page) : 1;
		$offset = $page == 1 ? 0 : ($page-1)*$pagesize;

		$pages = phppages($spe->get_count('parentid=0'), $page, $pagesize);

		$specials = $spe->get_list('parentid=0', $offset, $pagesize);

		include admintpl('special');
		break;

	case 'listorder':
		$spe->listorder($listorder);
		showmessage($LANG['operation_success'],$forward);
		break;

	case 'elite':
		$spe->elite($value);
		showmessage($LANG['operation_success'],$forward);
		break;

	case 'close':
		$spe->close($value);
		showmessage($LANG['operation_success'],$forward);
		break;

	case 'update_linkurl':
		$spe->update_linkurl();
		showmessage($LANG['operation_success'], $forward);
		break;

	case 'createhtml':
        createhtml('special_index', PHPCMS_ROOT);
        createhtml('special_list', PHPCMS_ROOT);

		$specials = $spe->get_list('disabled=0');
		foreach($specials as $specialid=>$special)
		{
			createhtml('special_show', PHPCMS_ROOT);
		}
		showmessage($LANG['operation_success'], $forward);
		break;

	case 'recycle':
		$specialid = intval($specialid);
		if(!$specialid) showmessage($LANG['illegal_parameters']);

		$special = $spe->get_info();

		createhtml('special_show');

		if(is_numeric($special['keyid']))
		{
			$special['channelid'] = intval($special['keyid']);
			$special['module'] = $CHANNEL[$special['channelid']]['module'];
		}
		else
		{
			$special['channelid'] = 0;
			$special['module'] =  $special['keyid'];
		}

		$forward = '?mod='.$special['module'].'&file=special&action=delete&channelid='.$special['channelid'].'&specialid='.$specialid.'&forward='.urlencode('?mod=phpcms&file=special&action=manage&keyid='.$keyid);
		showmessage($LANG['operation_success'], $forward);

		break;

	case 'delete':
		$specialid = intval($specialid);
		if(!$specialid) showmessage($LANG['illegal_parameters']);

		$special = $spe->get_info();
		$spe->delete();

		createhtml('special_index');

		if(is_numeric($special['keyid']))
		{
			$special['channelid'] = intval($special['keyid']);
			$special['module'] = $CHANNEL[$special['channelid']]['module'];
		}
		else
		{
			$special['channelid'] = 0;
			$special['module'] =  $special['keyid'];
		}

		$forward = '?mod='.$special['module'].'&file=special&action=delete&channelid='.$special['channelid'].'&specialid='.$specialid.'&forward='.urlencode('?mod=phpcms&file=special&action=manage&keyid='.$keyid);
		showmessage($LANG['operation_success'], $forward);
		break;
}

?>