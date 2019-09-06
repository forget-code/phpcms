<?php
defined('IN_PHPCMS') or exit('Access Denied');
require MOD_ROOT.'include/ads_place.class.php';

$submenu = array
(
	array('<font color="red">'.$LANG['add_advertisement'].'</font>', '?mod='.$mod.'&file='.$file.'&action=add'),
	array($LANG['manage_advertisement'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['manage_the_order_of_advertisement'], '?mod='.$mod.'&file=ads&action=manage'),
	array($LANG['update_html_and_js'], '?mod='.$mod.'&file=ads_place&action=createhtml'),
);

$menu = admin_menu($LANG['manage_advertisement'], $submenu);

$action = $action ? $action : 'manage';

$adsplace = new ads_place();
switch($action)
{
	case 'manage':
        //error_reporting(E_ALL);
        $condition = array();
        if($passed >=0 && isset($passed))	$condition[] = "`passed` = '$passed' " ;
        if(trim($field))
        {
            $field = trim($field);
            $q = trim($q);
            if(in_array($field,array('introduce','placename')) )
            {
                $condition[] = "`$field` LIKE '%$q%' " ;//广告介绍/名称
            }
            else
            {
                $condition[] = "`$field` = '$q' " ;//广告ID
            }
        }
		$places = array();
        $page = isset($page) ? intval($page) : 1;
		$infos = $adsplace->get_list($condition, $page, $pagesize);
        $passed = isset($passed) ?$passed:-1;
        $places = $infos['info'];
        $pages = $infos['pages'];
		include admin_tpl('ads_place_manage');
	break;
	case 'add':
		if($dosubmit)
		{
			$id = $adsplace->add($place);
			if(!$id) showmessage($adsplace->msg(), 'goback');
			$priv_group->update('p_adsid', $id, $priv_groupid);
			$priv_role->update('p_adsid', $id, $priv_roleid);

			showmessage($LANG['opration_completed'], '?mod=ads&file=ads_place&action=manage');
		}
		else
		{
			if(!$priv_role->check('p_adsid', $placeid, 'input', $roleid)) showmessage($LANG['not_add_rights'], 'goback');
			$groups = $GROUP;
			$roles = $ROLE;
			unset($GROUP, $ROLE);
			include admin_tpl('ads_place_add');
		}
	break;
	case 'edit':
        if($dosubmit)
        {
            $placeid = intval($placeid);
            if(!$priv_role->check('p_adsid', $placeid, 'manage', $roleid)) showmessage($LANG['not_edit_rights'], 'goback');
            if(!$placeid) showmessage($LANG['illegal_move_parameters']);
            $where = ' `placeid`='.$placeid;
            if(!$adsplace->edit($place, $where)) showmessage($adsplace->msg(), '?mod=ads&file=ads_place');
            $priv_group->update('p_adsid', $placeid, $priv_groupid);
            $priv_role->update('p_adsid', $placeid, $priv_roleid);
            showmessage($LANG['opration_successd_advertising_content_has_been_modified'], '?mod=ads&file=ads_place');
        }
        else
        {
            $placeid = intval($placeid);
            if(!$placeid) showmessage($LANG['illegal_move_parameters']);
            $groups = $GROUP;
            $roles = $ROLE;
            $place = $adsplace->get($placeid);
            unset($GROUP, $ROLE);
            include admin_tpl('ads_place_edit');
        }
        break;
	case 'lock':
        if(empty($placeid)) showmessage('请选择要操作的广告位');
        if($adsplace->lock($placeid, $val)) showmessage($LANG['opration_completed'], '?mod=ads&file=ads_place');
        break;

        case 'delete':
        if(empty($placeid)) showmessage('请选择要操作的广告位');
        if($adsplace->delete($placeid)) showmessage($LANG['opration_completed'], '?mod=ads&file=ads_place');
        break;
	case 'createhtml':
        $places = array();
        $places = $db->select("SELECT * FROM ".DB_PRE."ads_place WHERE passed=1 ORDER BY placeid");
        foreach($places as $place)
        {
            if(!$priv_role->check('p_adsid', $place['placeid'], 'manage', $roleid)) continue;
            $adsplace->createhtml($place['placeid'], 0, $place['option']);
            $adsplace->createhtml($place['placeid'], 1, $place['option']);
        }
        showmessage($LANG['opration_completed'], '?mod=ads&file=ads_place');
        break;
	case 'view':
        $placeid = intval($placeid);
        if(!$priv_role->check('p_adsid', $placeid, 'view', $roleid)) showmessage($LANG['not_view_rights'], 'goback');
        if(!$placeid) showmessage($LANG['incorrect_parameters'], 'goback');
        $place = $db->get_one("SELECT * FROM ".DB_PRE."ads_place WHERE placeid=$placeid");
        echo "<SCRIPT LANGUAGE=\"JavaScript\">";
        $adsplace->view($placeid, $place['option']);
        echo "</script>";
        break;
    case 'loadjs':
        $placeid = intval($placeid);
        if(!$priv_role->check('p_adsid', $placeid, 'view', $roleid)) showmessage($LANG['not_view_rights'], 'goback');
        if(!$placeid) showmessage($LANG['incorrect_parameters'], 'goback');
        $loadadsplace = $db->get_one("SELECT * FROM ".DB_PRE."ads_place WHERE placeid=$placeid");
        if(!$loadadsplace) showmessage($LANG['incorrect_parameters']);
        $referer = urlencode($referer);
        include admin_tpl('adsplace_loadjs');
        break;
}

?>