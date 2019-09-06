<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/member_admin.class.php';
$member = new member_admin();

require_once MOD_ROOT.'admin/include/model_member.class.php';
$model = new member_model;

require_once MOD_ROOT.'admin/include/model_member_field.class.php';
require_once 'attachment.class.php';
$attachment = new attachment($mod);

require_once MOD_ROOT.'admin/include/group_admin.class.php';
$group_admin = new group_admin();

if(!$forward) $forward = "?mod=$mod&file=$file&action=manage";
$ext_group = cache_read('member_group_extend.php');

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			if(!$member->add($info)) showmessage($member->msg());
			showmessage('添加成功', '?mod=member&file=member&action=manage');
		}
		else
		{
			if($PHPCMS['uc']) showmessage('已经开启Ucenter整合，请到Ucenter处添加用户', $PHPCMS['uc_api']);
			unset($GROUP['1']);
			include admin_tpl('member_add');
		}
		break;

    case 'edit':
		if(!class_exists('member_input'))
		{
			require CACHE_MODEL_PATH.'member_input.class.php';
		}
		if(!class_exists('member_update'))
		{
			require CACHE_MODEL_PATH.'member_update.class.php';
    	}
		if($dosubmit)
		{
			$member_input = new member_input($info['modelid']);
			if(!$info['groupid']) $info['groupid'] = $groupid;
			$inputinfo = $member_input->get($info);
			$userid = $member->edit_user($info);
			if(!$userid) showmessage($member->msg(), $forward);
			$modelinfo = $inputinfo['model'];
			if($modelinfo)
			{	
				$modelinfo['userid'] = $info['userid'];
				$member_update = new member_update($info['modelid'], $info['userid']);
    			$member_update->update($modelinfo);
				$member->edit_model($info['modelid'], $modelinfo);
			}
			if($MODEL[$info['modelid']]['tablename'] == 'company')
			{
				$endtime = strtotime($endtime);
				$db->query("UPDATE ".DB_PRE."member_company SET `endtime`='$endtime' WHERE `userid`='$userid'");
			}
			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			require CACHE_MODEL_PATH.'member_form.class.php';
			$GROUP['0'] = '请选择';
			unset($GROUP['1']);
			ksort($GROUP);
			$memberinfo = $member->get($userid, '*', 1);
			@extract(new_htmlspecialchars($memberinfo));
			$data = $member->get_model_info($userid, $modelid, $fields = '*');
			$member_form = new member_form($modelid);
			$forminfos = $member_form->get($data);
			include admin_tpl('member_edit');
		}
		break;

    case 'model_edit':
    	if ($dosubmit)
    	{
			if(!$tomodelid) showmessage('请选择要移至的会员模型', $forward);
			if(!$info['modelid']) $info['modelid'] = $tomodelid;
			if($exmodeild == $info['modelid']) showmessage('选择模型与原模型一致，不用修改', $forward);
			if(!$member->edit_user($info))
			{
				showmessage($member->msg, $forward);
			}
    		showmessage($LANG['operation_success'], $forward);
    	}
    	else
    	{
			$memberinfo = $member->get($userid, '*');
			@extract($memberinfo);
    		include admin_tpl('member_model_edit');
    	}
    	break;

    case 'view':
    	$array = array();
        if(trim($username))
        {
            $userid = $member->get_userid($username);
        }
		$arr_ext_group = $group_admin->extend_list($userid);
		$memberinfo = $member->get($userid, '*', 1);
        if($memberinfo['regtime']) $memberinfo['regtime'] = date('Y-m-d H:i:s', $memberinfo['regtime']);
		if($memberinfo['lastlogintime']) $memberinfo['lastlogintime'] = date('Y-m-d H:i:s', $memberinfo['lastlogintime']);
		@extract(new_htmlspecialchars($memberinfo));
		$data = $member->get_model_info($userid, $modelid);
		if(!class_exists('member_output'))
		{
			require CACHE_MODEL_PATH.'member_output.class.php';
		}
		$member_output = new member_output($modelid, $userid);
		$forminfos = $member_output->get($data);
		$avatar = avatar($userid);
		$arr_menu = $member->memeber_view_menu($userid);
		$ip_area = load('ip_area.class.php');
		$regarea = $ip_area->get($regip);
		$loginarea = $ip_area->get($lastloginip);
		include admin_tpl('member_view');

		break;

    case 'delete':
		if(!isset($userid)) showmessage($LANG['select_member_id']);
		if(is_array($userid))
		{
			if(in_array($_userid, $userid))
			{
				showmessage('非法操作', $forward);
			}
			$result = array_intersect($userid, $arr_founder);
			if(!empty($result))
			{
				showmessage('非法操作', $forward);
			}
		}
		elseif($userid == $_userid || in_array($userid, $arr_founder))
		{
			showmessage('非法操作', $forward);
		}
		$member->delete($userid);
		showmessage($LANG['operation_success'], '?mod=member&file=member&action=manage');

		break;

    case 'manage':
		$page = max(intval($page), 1);
		$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
		$offset = ($page-1)*$pagesize;
		$frommoney = isset($frommoney) ? intval($frommoney) : 0;
		$tomoney = isset($tomoney) ? intval($tomoney) : 0;
		$frompoint = isset($frompoint) ? intval($frompoint) : 0;
		$topoint = isset($topoint) ? intval($topoint) : 0;
        $groupid = isset($groupid) ? intval($groupid) : 0;
		$disabled = isset($disabled) ? intval($disabled) : '';
		$modelid = isset($modelid) ? intval($modelid) : 0;
		if($modelid && $issearch)
		{
			if(!class_exists('member_search'))
			{
				require	CACHE_MODEL_PATH.'member_search.class.php';
			}
			$member_search = new member_search($modelid);
			$data = $member_search->data($page, $PHPCMS['search_pagesize']);
			foreach($data as $v)
			{
				$arr_userid[] = $v['userid'];
			}
			$userids = implode(',', $arr_userid);
			$userids = $userids ? $userids : "''";
			unset($arr_userid);
		}
        if(!isset($username)) $username = '';
        $condition = '';
		$condition .= ($modelid && $issearch) ? " AND m.userid IN ($userids)" : '';
		$condition .= ($extgroup) ? " AND m.userid IN ($ext_userid)" : '';
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
		$condition .= (isset($disabled) && ($disabled != -1) && !empty($disabled)) ? " AND m.disabled=$disabled" : '';
		$r = $db->get_one("SELECT count(*) as num FROM ".DB_PRE."member_cache m WHERE 1 $condition");
		$pages = pages($r['num'], $page, $pagesize);
		$order = $orderby ? $orderby : 'm.userid DESC';
		$members = $member->listinfo($condition, $order, $page, $pagesize);
		$GROUP['0'] = '请选择';
		ksort($GROUP);
		include admin_tpl('member_manage');
		break;

	case 'check':
        if($dosubmit)
	    {
            $member->check($userid);
            showmessage($LANG['operation_success'], $forward);
		}
		else
	    {
			$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 30;
			$page = max(intval($page), 1);
			$offset = ($page-1)*$pagesize;
			$condition .= " AND m.groupid=5";
			$r = $db->get_one("SELECT count(*) as num FROM ".DB_PRE."member_cache m,".DB_PRE."member_info i WHERE m.userid=i.userid $condition ");
			$pages = pages($r['num'], $page, $pagesize);
			$order = $orderby ? $orderby : 'm.userid ASC';
			$members = $member->listinfo($condition, $order, $page, $pagesize);
			include admin_tpl('member_check');
		}
		break;

    case 'lock':
		if(!isset($userid)) showmessage($LANG['select_account'], $forward);
		if(is_array($userid))
		{
			if(in_array($_userid, $userid))
			{
				showmessage('非法操作', $forward);
			}
			$result = array_intersect($userid, $arr_founder);
			if(!empty($result))
			{
				showmessage('非法操作', $forward);
			}
		}
		elseif($userid == $_userid || in_array($userid, $arr_founder))
		{
			showmessage('非法操作', $forward);
		}
		if(is_array($userid))
		{
			foreach($userid as $id)
			{
				$member->lock($id, $val);
			}
			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			if($member->lock($userid, $val)) showmessage($LANG['operation_success'], $forward);
		}
		break;

    case 'note':
		if($dosubmit)
		{
			$db->query("UPDATE ".DB_PRE."member_info SET note='$note' WHERE userid=$userid");
			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$r = $member->get($userid, 'm.username, i.note', 1);
			@extract($r);
			include admin_tpl('member_note');
		}
	break;

	case 'checkuser':
		if(!$member->is_username($value) || !$member->username_exists($value, $userid))
		{
			exit($member->msg());
		}
		else
		{
			exit('success');
		}
	break;

	case 'checkemail':
		if(!is_email($value))
		  {
				exit($LANG['input_valid_email']);
		  }
		  elseif(!$M['allowemailduplicate'] && $member->email_exists($value, $userid))
		  {
				exit($member->msg());
		  }
		  else
		  {
				exit('success');
		  }
	break;

	case 'search':
		if($modelid)
		{
			require CACHE_MODEL_PATH.'member_search_form.class.php';
			if(!$modelid) $modelid = 10;
			$modelname = $MODEL[$modelid]['name'];
			$form = new member_search_form($modelid);
			$where = $form->get_where();
		}
		$GROUP[0] = $ext_group[0] = '请选择';
		ksort($ext_group);
		ksort($GROUP);
		include admin_tpl('member_search');
		break;

	case 'move':
		$userids = is_array($userid) ? implode(',', $userid) : $userid;
	    if(!$userids) showmessage($LANG['select_account'], $forward);

		if($dosubmit)
	    {
			$groupid = intval($groupid);
	        if(!$groupid) showmessage($LANG['select_group'], $forward);
	        $member->move($userids, $groupid);
			showmessage($LANG['operation_success'], $forward);
		}
		else
	    {
			$arr_member = array();
			unset($GROUP['1']);
			$result = $db->query("SELECT userid,username FROM ".DB_PRE."member_cache WHERE userid IN($userids)");
			while($r = $db->fetch_array($result))
			{
				$arr_member[$r['userid']] = $r['username'];
			}
			include admin_tpl('member_move');
		}
		break;
	case 'model_move':
		if($dosubmit)
		{
			$touserid = $member->model_move($frommodelid, $tomodelid);
			showmessage('操作成功');
		}
		else
		{
			unset($member->MODEL[$frommodelid]);
			foreach($member->MODEL as $k_model=>$v_model)
			{
				$arr_model[$k_model] = $v_model['name'];
			}
			include admin_tpl('move_model_member');
		}
		break;
	case 'compare_uc':
		$sameserver = 0;
		if($uc_dbhost == DB_HOST && $uc_dbuser == DB_USER && $uc_dbpwd == DB_PW)
		{
			$sameserver = 1;
			$sqldb = &$db;
			if ($uc_dbname != DB_NAME)
			{
				$sqldb->select_db($uc_dbname);
			}
		}
		else
		{
			$sqldb = new db_mysql();
			if(!$sqldb->connect($uc_dbhost, $uc_dbuser, $uc_dbpwd, $uc_dbname, 0, $uc_charset))
			{
				exit('链接不上服务器');
			}
		}
		$dbpre = $uc_dbpre;
		$sql = "SELECT count(uid) as num_ucmember FROM ".$dbpre."members";
		$arr_num = $sqldb->get_one($sql);
		$uc_num = $arr_num['num_ucmember'];
		if($sameserver) $sqldb->select_db(DB_NAME);
		unset($sqldb);
		$r = $db->get_one("SELECT count(*) as num FROM ".DB_PRE."member_cache m");
		$mem_num = $r['num'];
		if($uc_num < $mem_num)
		{
			echo 'not_compare';
		}
		else
		{
			exit('ok');
		}
		break;
	case 'import_uc':
		if($dosubmit)
		{
			if(!$total)
			{
				$r = $db->get_one("SELECT count(*) as num FROM ".DB_PRE."member_cache m");
				$total = $r['num'];
			}
			$sameserver = 0;
			$finished = 0;
			$offset = max(intval($offset), 1);
			$query = $db->query("SELECT * FROM ".DB_PRE."member_cache m, ".DB_PRE."member_info i WHERE m.userid=i.userid LIMIT $offset, 100");
			$exportnum = $db->num_rows($query);
			while($r = $db->fetch_array($query)) 
			{
				$data['salt'] = rand(100000, 999999);
				$data['password'] = md5($r['password'].$salt);
				$data['username'] = addslashes($r['username']);
				$data['email'] = $r['email'];
				$data['regtime'] = $r['regtime'];
				$s[] = $data;
			}
			if($uc_dbhost == DB_HOST && $uc_dbuser == DB_USER && $uc_dbpwd == DB_PW && $uc_charset == DB_CHARSET)
			{
				$sameserver = 1;
				$sqldb = &$db;
				if ($uc_dbname != DB_NAME)
				{
					$sqldb->select_db($uc_dbname);
				}
			}
			else
			{
				$sqldb = new db_mysql();
				if(!$sqldb->connect($uc_dbhost, $uc_dbuser, $uc_dbpwd, $uc_dbname, 0, $uc_charset))
				{
					showmessage('连接不上服务器', '?mod=phpcms&file=setting&tab=7');
				}
			}
			$dbpre = $uc_dbpre;
			$maxuid = getmaxuid();
			foreach($s as $val)
			{
				$queryuc = $sqldb->query("SELECT count(*) FROM ".$dbpre."members WHERE username='$val[username]'");
				$userexist = $sqldb->result($queryuc, 0);
				if(!$userexist) 
				{
					$sqldb->query("INSERT LOW_PRIORITY INTO ".$dbpre."members SET uid='$val[userid]', username='$val[username]', password='$val[password]', email='$val[email]', regip='$val[regip]', regdate='$val[regtime]', salt='$val[salt]'", 'SILENT');
					$sqldb->query("INSERT LOW_PRIORITY INTO ".$dbpre."memberfields SET uid='$val[userid]'",'SILENT');
				}
				else 
				{
					$sqldb->query("REPLACE INTO ".$dbpre."mergemembers SET appid='".$uc_apiid."', username='$val[username]'", 'SILENT');
				}
				$lastuid = $val['userid'] += $maxuid;
			}
			$sqldb->query("ALTER TABLE ".$dbpre."members AUTO_INCREMENT=".($lastuid + 1));
			if($sameserver) $sqldb->select_db(DB_NAME);
			if(!$sameserver) $sqldb->close();
			$newoffset = $offset + 100;
			if($exportnum < 100) $finished = 1;
			$start = $offset + 1;
			$end = $finished ? ($offset + $exportnum) : $newoffset;
			$forward = $finished ? "?mod=phpcms&file=setting&tab=7" : "?mod=$mod&file=$file&action=$action&name=$name&type=$type&offset=$newoffset&total=$total&uc_dbhost=$uc_dbhost&uc_dbuser=$uc_dbuser&uc_dbpwd=$uc_dbpwd&uc_charset=$uc_charset&uc_dbpre=$uc_dbpre&uc_dbname=$uc_dbname&uc_apiid=$uc_appid&dosubmit=1";
			showmessage($LANG['total_import'].$total.$LANG['record'].'<br />'.$LANG['from'].$start.$LANG['to'].$end.$LANG['load_data_success'], $forward);
		}
		else
		{
				include admin_tpl('member_export_uc');
		}
	default :
}

function getmaxuid() 
{
	global $sqldb, $dbpre;
	$query = $sqldb->query("SHOW CREATE TABLE ".$dbpre."members");
	$data = $sqldb->fetch_array($query);
	$data = $data['Create Table'];
	if(preg_match('/AUTO_INCREMENT=(\d+?)[\s|$]/i', $data, $a)) {
		return $a[1] - 1;
	} else {
		return 0;
	}
}

?>