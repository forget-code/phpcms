<?php
defined('IN_PHPCMS') or exit('Access Denied');

$action = $action ? $action : 'manage';
$job = $job ? $job : 'manage';
$jobs = array("manage"=>"status=3 ", "check"=>"status=1", "recycle"=>"status=-1");
array_key_exists($job, $jobs) or showmessage($LANG['illegal_action'], 'goback');
$submenu = array(
	array($LANG['manage_company'],"?mod=$mod&file=$file&action=manage&job=manage"),
	array($LANG['check_company'],"?mod=$mod&file=$file&action=manage&job=check"),
	array($LANG['recycle'],"?mod=$mod&file=$file&action=manage&job=recycle"),
);
$submenu = $menu = adminmenu($LANG['manage_company'],$submenu);
switch($action)
{
	case 'manage':
		$TRADE = cache_read('trades_trade.php');
		if($job == 'manage')
		{
			$status = 3;
		}
		elseif($job == 'check')
		{
			$status = 1;
		}
		else
		{
			$status = -1;
		}
		$pagesize = $PHPCMS['pagesize'];
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;
		$srchtype = isset($srchtype) ? intval($srchtype) : 0;
		$typeid = isset($typeid) ? trim($typeid) : 0;
		$ordertype = isset($ordertype) ? intval($ordertype) : 0;
		$type_select = "<select name='typeid' ><option value='0'>请选择企业性质</option>";
		$types = explode("\n",$MOD['type']);
		foreach($types AS $t)
		{
			$selected = '';
			if($typeid==$t) $selected = 'selected';
			$type_select .= "<option value='$t' $selected>$t</option>";
		}
		$type_select .= "</select>";
		$condition = '';
		$condition .= $catid ? 'AND catid='.$catid.' ' : '';
		$condition .= $typeid ? "AND typeid like '%".$typeid."%' " : "";
		if(isset($elite)) $condition = ' AND elite='.intval($elite);
		if(isset($keyword))
		{
			$keyword = trim($keyword);
			$keyword = str_replace(' ','%',$keyword);
			$keyword = str_replace('*','%',$keyword);
			if($srchtype)
			{
				$condition .= " AND username = '$keyword' ";
			}
			else
			{
				$condition .= " AND companyname LIKE '%$keyword%' ";
			}
		}
		$r = $db->get_one("SELECT COUNT(companyid) AS num FROM ".TABLE_MEMBER_COMPANY." WHERE status=$status $condition");
		$number = $r['num'];
		$pages = phppages($number,$page,$pagesize);
		$companys = array();
		$result = $db->query("SELECT * FROM ".TABLE_MEMBER_COMPANY." WHERE status=$status $condition ORDER BY listorder DESC,companyid DESC LIMIT $offset,$pagesize");
		while($r = $db->fetch_array($result))
		{
			$r['addtime'] = date('Y-m-d',$r['addtime']);
			$r['edittime'] = date('Y-m-d H:i:s',$r['edittime']);
			$r['checktime'] = date('Y-m-d H:i:s',$r['checktime']);
			$companys[] = $r;
		}
	include admintpl('company_'.$job);
	break;

case 'listorder':
	if(empty($listorder) || !is_array($listorder))
	{
		showmessage($LANG['illegal_parameters']);
	}

	foreach($listorder as $key=>$val)
	{
		$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET `listorder`='$val' WHERE companyid=$key ");
	}
	showmessage($LANG['update_success'],$forward);
break;

case 'elite' :
	if(empty($companyid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	if(!ereg('^[0-1]+$',$elite))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$companyids = is_array($companyid) ? implode(',',$companyid) : $companyid;
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET elite=$elite WHERE companyid IN ($companyids)");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;

case 'status' :
	if(empty($companyid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	if(!is_numeric($status))
	{
		showmessage($LANG['illegal_parameters']);
	}
	$companyids = is_array($companyid) ? implode(',',$companyid) : $companyid;
	$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET status=$status WHERE companyid IN ($companyids)");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;
case 'truncate':
	$db->query("DELETE FROM ".TABLE_MEMBER_COMPANY." WHERE status='-1'");
	showmessage($LANG['operation_success'],$forward);
	break;
case 'delete':
	if(empty($companyid))
	{
		showmessage($LANG['illegal_parameters']);
	}
	foreach($companyid AS $id)
	{
		if($MOD['enableSecondDomain'])
		{
			@extract($db->get_one("SELECT sitedomain FROM ".TABLE_MEMBER_COMPANY." WHERE companyid=$id"));
			$_userdir = substr($sitedomain,0,2);
		}
		else
		{
			$_userdir = substr($id,0,2);
			$sitedomain = $id;
		}
		$filepath = PHPCMS_ROOT.'/yp/web/userdata/'.$_userdir.'/'.$sitedomain.'/';
		dir_delete($filepath);
	}
	$companyids = is_array($companyid) ? implode(',',$companyid) : $companyid;
	$db->query("DELETE FROM ".TABLE_MEMBER_COMPANY." WHERE companyid IN ($companyids)");
	if($db->affected_rows()>0)
	{
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		showmessage($LANG['operation_failure']);
	}
	break;
case 'edit':
	require PHPCMS_ROOT.'/include/field.class.php';
	$field = new field($CONFIG['tablepre'].'member_company');
	if($dosubmit)
	{
		$field->check_form();
		$patternString = '';
		foreach($pattern AS $v)
		{
			$patternString .= $v.'|';
		}
		$patternString = substr($patternString,0,-1);
		$regtime = strtotime($regtime);
		$vip = strtotime($vip);
		$nowtime = date('Y-m-d',$PHP_TIME);
		$nowtime = strtotime($nowtime);
		$viptime = '';
		if($nowtime != $vip) $viptime = ",`vip` = $vip";

		if($MOD['enableSecondDomain'])
		{
			$linkurl = 'http://'.$sitedomain.'.'.$MOD['secondDomain'];
		}
		else
		{
			@extract($db->get_one("SELECT m.userid FROM ".TABLE_MEMBER." m, ".TABLE_MEMBER_COMPANY." c WHERE c.companyid='$companyid' AND c.username=m.username"),EXTR_OVERWRITE);
			$linkurl = $PHPCMS['siteurl']."yp/?".$userid;
		}
		$sitedomain = empty($sitedomain) ? '' : ",`sitedomain` = '$sitedomain'";
		
		$db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET `companyname` = '$companyname',`areaid` = '$areaid',`tradeid` = '$tradeid',`pattern` = '$patternString', `typeid` = '$typeid',`product` = '$product',`regtime` = '$regtime',`employnum` = '$employnum',`linkurl`='$linkurl',`turnover` = '$turnover' $viptime $sitedomain ,`linkman` = '$linkman',`telephone` = '$telephone',`fax`='$fax',`postid` = '$postid',`email` = '$email',`address` = '$address',`homepage` = '$homepage' WHERE companyid='$companyid'");
		$field->update("companyid=$companyid");
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		$TRADE = cache_read('trades_trade.php');
		require_once PHPCMS_ROOT.'/yp/include/trade.func.php';
		@extract($db->get_one("SELECT * FROM ".TABLE_MEMBER_COMPANY." WHERE companyid='$companyid'"),EXTR_OVERWRITE);
		$fields = $field->get_form('<tr><td class="tablerow">$title</td><td class="tablerow">$input $tool $note</td></tr>');
		$fromdate = date('Y-m-d',$regtime);
		$vip = $vip ? date('Y-m-d',$vip) : date('Y-m-d',$PHP_TIME);
		$patterns = $editpattern = '';
		$postid = $postid ? $postid : '';
		$patterns = explode('|',$MOD['pattern']);
		foreach($patterns AS $v)
		{
			$checked = '';
			$pos = strpos($pattern,$v);
			if($pos !== false) $checked = 'checked="checked"';
			$editpattern .= '<input name="pattern[]" type="checkbox" value="'.$v.'" '.$checked.'> '.$v;
		}
		$type_selected = "<select name='typeid' ><option value='0'>".$LANG['please_choose_type']."</option>";
		$types = explode("\n",$MOD['type']);
		foreach($types AS $t)
		{
			$selected = '';
			if($typeid==$t) $selected = 'selected';
			$type_selected .= "<option value='$t' $selected>$t</option>";
		}
		$type_selected .= "</select>";
		require_once PHPCMS_ROOT.'/include/tree.class.php';
		$tree = new tree;
		$AREA = cache_read('areas_'.$mod.'.php');
		require_once PHPCMS_ROOT.'/include/area.func.php';
		include admintpl('company_edit');
	}
	break;

	case 'move':
		if($dosubmit)
		{
			$targetcatid = isset($targetcatid) ? intval($targetcatid) : 0;
			$targetcatid or showmessage($LANG['distinct_category_not_null'],'goback');
			$CAT = cache_read("category_$targetcatid.php");
			if($CAT['child'] && !$CAT['enableadd']) showmessage($LANG['not_allowed_to_add_in_this_category'],'goback');

			if($movetype==1)
			{
				!empty($companyid) or showmessage($LANG['illegal_parameters'],'goback');
				$companyid=is_array($companyid) ? implode(',',$companyid) : $companyid;
				if($targetcatid) $db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET catid='$targetcatid' WHERE companyid IN ($companyid) ");
			}
			else
			{
				!empty($batchcatid) or showmessage($LANG['source_category_not_null'],'goback');
				$batchcatids = is_array($batchcatid) ? implode(",",$batchcatid) : $batchcatid;
				if($targetcatid) $db->query("UPDATE ".TABLE_MEMBER_COMPANY." SET catid='$targetcatid' WHERE catid IN ($batchcatids) ");
			}
			showmessage($LANG['move_success'],$referer);
		}
		else
		{
			$referer = isset($referer) ? $referer : "?mod=$mod&file=$file&action=move";
			$companyid = (isset($companyid) ? $companyid : '') ;
			$companyid = is_array($companyid) ? implode(',',$companyid) : $companyid;
			$category_select = str_replace("<select name='catid' ><option value='0'></option>",'',category_select('catid'));
			include admintpl('company_move');
		}
	break;
}
?>