<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/admin/include/channel.class.php';

$submenu = array
(
	array($LANG['manage_index'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['add_channel'], '?mod='.$mod.'&file='.$file.'&action=add'),
);
$menu = adminmenu($LANG['channel_admin'], $submenu);

$menu = $_grade > 0 ? '<br />' : $menu;

$action = $action ? $action : 'manage';

$channelid = isset($channelid) ? intval($channelid) : 0;

$cha = new channel($channelid);

switch($action)
{
	case 'add':
		if($dosubmit)
		{
		    if(!$channel['channelname']) showmessage($LANG['channel_name_not_null']);
			if(!$channel['islink'] && !$channel['channeldir']) showmessage($LANG['channel_dir_not_null']);
			if($channel['islink'] && !$channel['linkurl']) showmessage($LANG['external_linkurl_not_null']);
			
			if(!$channel['islink'])
			{
				if(!preg_match("/^[0-9a-z_-]+$/i",$channel['channeldir'])) showmessage($LANG['channel_dir_num_alpha']);
				$r = $db->get_one("select channelid from ".TABLE_CHANNEL." where channeldir='".$channel['channeldir']."'");
		        if($r) showmessage($LANG['channel_dir_not_repeat']);
				if(!dir_create(PHPCMS_ROOT.'/'.$channel['channeldir'])) showmessage($LANG['channel_dir_cannot_establish_777']);
			}

			$channelid = $cha->add($channel);

			$db->query("INSERT INTO ".TABLE_MENU." (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_make', '".$channel['channelname'].$LANG['index']."', '".$LANG['generate'].$channel['channelname'].$LANG['index']."', '?mod=".$channel['module']."&file=createhtml&action=index&channelid=".$channelid."', '_self', '', 1, '1', '', '')");
			$db->query("INSERT INTO ".TABLE_MENU." (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_make', '".$channel['channelname']."html', '".$LANG['generate'].$channel['channelname'].$LANG['category'].$LANG['manage_index']."', '?mod=".$channel['module']."&file=createhtml&channelid=".$channelid."', '_self', '', 5, '1', '', '')");
			$db->query("INSERT INTO ".TABLE_MENU." (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_add', '".$LANG['add'].$channel['channelname']."', '".$channel['channelname'].$LANG['manage_index']."', '?mod=".$channel['module']."&file=".$channel['module']."&action=main&channelid=".$channelid."', '_self', '', 0, '1', '', '')");

	        showmessage($LANG['operation_success'], '?mod=phpcms&file=channel&action=updatecache&forward='.urlencode($forward));
		}
		else
	    {
			$modules = array();
		    foreach($MODULE as $module)
			{
				if($module['iscopy'] == 1) $modules[] = $module;
		    }
			$cat_html_urlrule = urlrule_select('channel[cat_html_urlruleid]','html','cat');
			$item_html_urlrule = urlrule_select('channel[item_html_urlruleid]','html','item');
			$special_html_urlrule = urlrule_select('channel[special_html_urlruleid]','html','special');
			$cat_php_urlrule = urlrule_select('channel[cat_php_urlruleid]','php','cat');
			$item_php_urlrule = urlrule_select('channel[item_php_urlruleid]','php','item');
			$special_php_urlrule = urlrule_select('channel[special_php_urlruleid]','php','special');
			$page_select = '';
			$module = isset($module) ? $module : 'article';
		    $skinid = showskin('channel[skinid]');
			$arrgroupid_browse = showgroup('checkbox', 'arrgroupid_browse[]');
		    include admintpl('channel_add');
		}
		break;

	case 'edit':
		if(!$channelid) showmessage($LANG['illegal_parameters']);

		if($dosubmit)
		{
		    if(!$channel['channelname']) showmessage($LANG['channel_name_not_null'], "goback");

            $channel['arrgroupid_browse'] = isset($arrgroupid_browse) && is_array($arrgroupid_browse) ? implode(",",$arrgroupid_browse) : "";

			$cha->edit($channel);

			if($createtype_application)
			{
				$ishtml = $channel['ishtml'];
				if($ishtml)
				{
					$cat_urlruleid = $channel['cat_html_urlruleid'];
					$item_urlruleid = $channel['item_html_urlruleid'];
					$special_urlruleid = $channel['special_html_urlruleid'];
				}
				else
				{
					$cat_urlruleid = $channel['cat_php_urlruleid'];
					$item_urlruleid = $channel['item_php_urlruleid'];
					$special_urlruleid = $channel['special_php_urlruleid'];
				}
				$item_html_urlruleid = $channel['item_html_urlruleid'];
				$item_php_urlruleid = $channel['item_php_urlruleid'];
				$db->query("UPDATE ".TABLE_CATEGORY." SET ishtml=$ishtml,urlruleid=$cat_urlruleid,item_html_urlruleid=$item_html_urlruleid,item_php_urlruleid=$item_php_urlruleid WHERE channelid=$channelid");
				$db->query("UPDATE ".channel_table($CHANNEL[$channelid]['module'], $channelid)." SET ishtml=$ishtml,urlruleid=$item_urlruleid WHERE 1");
				foreach($CATEGORY as $catid=>$cat)
				{
					cache_category($catid);
				}
				$forward = '?mod=phpcms&file=linkurl&action=updatechannel&channelid='.$channelid;
			}
			else
			{
				$forward = $_grade >0 ? '' : $forward;
			}

	        showmessage($LANG['operation_success'], '?mod=phpcms&file=channel&action=updatecache&forward='.urlencode($forward));
		}
		else
	    {
			$channel = $cha->get_info($channelid);
			if(!$channel) showmessage($LANG['channel_not_exsited'], "goback");
            @extract(new_htmlspecialchars($channel));

			foreach($MODULE as $m => $v)
			{
				if($v['iscopy']) $modules[$m] = $v;
			}
			$cat_html_urlrule = urlrule_select('channel[cat_html_urlruleid]','html','cat',$cat_html_urlruleid);
			$item_html_urlrule = urlrule_select('channel[item_html_urlruleid]','html','item',$item_html_urlruleid);
			$special_html_urlrule = urlrule_select('channel[special_html_urlruleid]','html','special',$special_html_urlruleid);
			$cat_php_urlrule = urlrule_select('channel[cat_php_urlruleid]','php','cat',$cat_php_urlruleid);
			$item_php_urlrule = urlrule_select('channel[item_php_urlruleid]','php','item',$item_php_urlruleid);
			$special_php_urlrule = urlrule_select('channel[special_php_urlruleid]','php','special',$special_php_urlruleid);
			$page_select = '';
		    $skinid = showskin('channel[skinid]', $skinid);
			$arrgroupid_browse = showgroup("checkbox", "arrgroupid_browse[]", $arrgroupid_browse);
		    include admintpl('channel_edit');
		}
		break;

    case 'disabled':
		if(!$channelid) showmessage($LANG['illegal_parameters'], "goback");

	    $result = $cha->disable($value);

		showmessage($LANG['operation_success'], $forward);
        break;

    case 'delete':
		if(!$channelid) showmessage($LANG['illegal_parameters']);

        $r = $db->get_one("select channelid,channelname from ".TABLE_CHANNEL." where channelid='$channelid'");
        if(!$r) showmessage($LANG['channel_not_exsited']);
		$db->query("DELETE FROM ".TABLE_MENU." WHERE name='".$r['channelname'].$LANG['index']."' OR name='".$r['channelname']."html' OR name='".$LANG['add'].$r['channelname']."' ");

		$cha->delete();

		$forward = '?mod=phpcms&file=channel&action=manage';
		showmessage($LANG['operation_success'], '?mod=phpcms&file=channel&action=updatecache&forward='.urlencode($forward));
        break;

	case 'recreate':
		$cha->create_dir();

		showmessage($LANG['operation_success'], $forward);
		break;

    case 'listorder':

		$cha->listorder($listorder);

		showmessage($LANG['operation_success'], $forward);
        break;

	case 'updatecache':
		cache_common();
		cache_channel();

		createhtml('index');
		createhtml('search');

		showmessage($LANG['channel_cache_update_success'], $forward);
		break;

	case 'manage':

		$list = $cha->get_list();

		if(is_array($list))
	    {
			$channels = array();
			foreach($list as $channel)
			{
				$channelid = $channel['channelid'];
			    $channel['admin'] = admin_users('channelids', $channelid);
				$channel['channeldir'] = $channel['islink'] ? $channel['linkurl'] : $channel['channeldir'];
				$channel['status'] = $channel['disabled'] ? "<font color='red'>".$LANG['banned']."</font>" : $LANG['normal'];
				$channels[] = $channel;
			}
		}
		include admintpl('channel');
		break;
}
?>