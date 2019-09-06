<?php
defined('IN_PHPCMS') or exit('Access Denied');

$forward = isset($forward) ? $forward : $PHP_REFERER;
$groupid = isset($groupid) ? intval($groupid) : 0;

$submenu = array
(
	array($LANG['manage_index'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid.'&action=manage'),
	array($LANG['add_member_group'], '?mod='.$mod.'&file='.$file.'&channelid='.$channelid.'&action=add'),
);

$menu = adminmenu($LANG['member_group_manage'], $submenu);

$action=$action ? $action : 'manage';

switch($action)
{
    case 'manage':
		$groups = array();
        $result = $db->query("SELECT * FROM ".TABLE_MEMBER_GROUP." order by groupid", "CACHE");
		while($r = $db->fetch_array($result))
		{
			$r['charge'] = $r['chargetype'] ? ($r['defaultvalidday']==-1 ? $LANG['no_limit_time'] : $r['defaultvalidday'].$LANG['day']): $r['defaultpoint'].$LANG['point'];
			$r['chargetype'] = $r['chargetype'] ? $LANG['valid_period'] : $LANG['subtract_point'];
			$r['enableaddalways'] = $r['enableaddalways'] ? '<font color="red">'.$LANG['yes'].'</font>' : $LANG['no'];
			$r['type'] = $r['grouptype']=='system' ? $LANG['system_group'] : $LANG['user_defined'];
			$groups[]=$r;
		}
		include admintpl('group_manage');
	break;

	case 'add':
		if($dosubmit)
		{
			$db->query("INSERT INTO ".TABLE_MEMBER_GROUP."(groupname,introduce,grouptype,chargetype,defaultpoint,defaultvalidday,discount,enableaddalways) values('$groupname','$introduce','$grouptype','$chargetype','$defaultpoint','$defaultvalidday','$discount','$enableaddalways')");
			if($db->affected_rows()>0)
			{
				cache_member_group();
				showmessage($LANG['operation_success'], $forward);
			}
			else
			{
				showmessage($LANG['operation_failure'], 'goback');
			}
		}
		else
		{
			include admintpl('group_add');
		}
	break;

	case 'edit':
		if($dosubmit)
		{
			$db->query("UPDATE ".TABLE_MEMBER_GROUP." SET groupname='$groupname',introduce='$introduce',chargetype='$chargetype',defaultpoint='$defaultpoint',defaultvalidday='$defaultvalidday',discount='$discount',enableaddalways='$enableaddalways' WHERE groupid=$groupid");
			if($db->affected_rows()>0)
			{
				cache_member_group();
				showmessage($LANG['operation_success'], $forward);
			}
			else
			{
				showmessage($LANG['operation_failure'], 'goback');
			}
		}
		else
		{
			$r = $db->get_one("SELECT * FROM ".TABLE_MEMBER_GROUP." WHERE groupid=$groupid");
			@extract($r);
			include admintpl('group_edit');
		}
	break;

	case 'delete':
		if(!$groupid) showmessage($LANG['illegal_parameters'], $forward);

	    $db->query("DELETE FROM ".TABLE_MEMBER_GROUP." WHERE groupid=$groupid");
		cache_member_group();
		showmessage($LANG['operation_success'], $forward);
}
?>