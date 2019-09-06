 <?php
defined('IN_PHPCMS') or exit('Access Denied');

$keyid = $keyid ? $keyid : 'phpcms';
$action = $action ? $action : 'manage';
$passed = isset($passed)?$passed:1;
$subjectid = intval($subjectid);

if(in_array($action, array('add','edit', 'edit_subject', 'edit_option', 'delete', 'delopt')) && $dosubmit)  update_votejs($subjectid);

switch($action)
{
	case 'add':
	if(isset($dosubmit))
	{
		if(empty($subject)) showmessage($LANG['inout_vote_subject']);

		$vote_subject = array();
		$vote_subject = $subject;
		$userinfo = is_array($userinfo) ? $userinfo : array();
		foreach($userinfo as $key=>$val)
		{
			$userinfo[$key] = $required[$key]?1:0;
		}

		if($save_username)  $voteinfo[allowguest] = 0;

		$userinfo = $userinfo ? addslashes(var_export($userinfo,TRUE)) : '';
		$voteinfo['userinfo'] = $userinfo;

		$voteinfo['parentid'] = $voteinfo['parentid'] ? $voteinfo['parentid'] : $subject['parentid'];
		$voteinfo['parentid'] = ($voteinfo['ismultiple']==1 && $voteinfo['parentid']) ? $voteinfo['parentid'] : 0;

		$voteinfo['groupidsvote'] = $voteinfo['groupidsvote'] ? implode(',',$voteinfo['groups']) : '';
		$voteinfo['addtime'] = TIME;
		$voteinfo['groupidsview'] = $voteinfo['groupidsview'] ? implode(',',$voteinfo['groupidsview']) : '';


		if($voteinfo['ismultiple'])
		{
			$voteinfo['subject'] = trim($voteinfo['title']);
			unset($voteinfo['title']);
			if(!$voteinfo['subject'])   showmessage($LANG['invalid_vote_title'], $forward);

			$subjectid = $admin_vote->add_subject($voteinfo) ;
			if(!$subjectid)  showmessage($LANG['operation_failure']);
			showmessage($LANG['ok_next'],"?mod={$mod}&file=vote&action=edit_subject&subjectid={$subjectid}");
			$admin_vote->add_options(array('option'=>$subject['option'],'image'=>$subject['image']),$newsubjectid);
		}

		if(!$voteinfo['ismultiple'])
		{
			if(count($subject['option'])<2) showmessage($LANG['less_than_two_options']);
			$voteinfo['subject']= $subject['subject'] ;
            if(!$voteinfo['subject'])   showmessage($LANG['invalid_vote_title'], $forward);
			$voteinfo['addtime']=TIME ;
			$voteinfo['minval'] = intval($subject['minval'])  ;
			$voteinfo['maxval'] = intval($subject['maxval']) ;
			$voteinfo['ischeckbox'] = $subject['ischeckbox']	 ;
			if($subject['parentid'])  $voteinfo['parentid']   = $subject['parentid'] ;
			unset($voteinfo['title']);

			$subjectid = $admin_vote->add_subject($voteinfo);
			$admin_vote->add_options(array('option'=>$subject['option'],'image'=>$subject['image']),$subjectid);
		}
		update_votejs($subjectid);
		showmessage($LANG['operation_success'],$forward);
	}
	else
	{
		$fromdate = date("Y-m-d",TIME);
		$todate = date("Y-m-d",TIME+3600*24*30);
        include admin_tpl('add');
   	}
	break;

	case 'manage':
        $passed = isset($passed) ? $passed : '1';
        $today = date("Y-m-d",TIME);
        $timeout = isset($timeout) ? 1 : 0;

		$sql=" 1 " ;
        $sql .= isset($enabled) ? " AND enabled='$enabled' " : "";
        $sql .= $timeout ? " AND todate<'$today' AND todate!='0000-00-00' " : "";
		$sql.= $survey? " AND ismultiple=1 ":"  AND ismultiple<>1 " ;
        if(isset($enbled)) $sql.=' enabled='.intval($enabled);

        $r = $db->get_one("SELECT COUNT(subjectid) AS num FROM ".DB_PRE."vote_subject WHERE $sql and parentid=0");
        $number = $r['num'];
        $pages = pages($number,$page,$pagesize);
        $votes = $db->select("SELECT * FROM  ".DB_PRE."vote_subject WHERE  $sql and  parentid=0 ORDER BY subjectid DESC LIMIT $offset,$pagesize",'subjectid');
        include admin_tpl('manage');
        break;

	case 'edit':
	if(isset($submit))
	{

		$voteinfo['groupidsvote'] = $voteinfo['groupidsvote']?implode(',',$voteinfo['groupidsvote']):'';
		$voteinfo['groupidsview'] = $voteinfo['groupidsview']?implode(',',$voteinfo['groupidsview']):'';
		$userinfo = $userinfo?$userinfo:array();
		foreach($userinfo as $key=>$val)
		{
			$userinfo[$key] = $required[$key]?1:0;
		}
		$userinfo = addslashes(var_export($userinfo,TRUE));
		$voteinfo['userinfo'] = $userinfo;

		$option_data = array('option'=>$subject['option'],'image'=>$subject['image']);
		unset($subject['option'],$subject['image']);
		if(is_array($subject)) $voteinfo = array_merge($voteinfo,$subject);

		$admin_vote->edit_subject($voteinfo,$subjectid);

		$admin_vote->edit_option($option_data);
		$newoption = is_array($newoption)?$newoption:array();

		foreach($newoption as $key=>$option)
		{
			if(!$option) continue ;
			$admin_vote->add_option(array('subjectid'=>$subjectid,'option'=>$option,'image'=>$newpic[$key]));
		}
		if($deloption) $admin_vote->del_option($deloption);
		$admin_vote->set_listorder(DB_PRE.'vote_option','optionid',$listorder);
		$admin_vote->update_number($subjectid);
		update_votejs($subjectid);
		showmessage($LANG['operation_success'],"?mod=vote&file=vote&action=manage&updatejs=1&survey=".$survey);

	} else {
		$subject=$admin_vote->get_subject($subjectid);
		$userinfo = $subject['userinfo']?$subject['userinfo'] : 'array()';
		eval("\$userinfo=$userinfo;");
		@extract($userinfo);
		$options = $admin_vote->get_options($subjectid);
		$todate = $todate>'0000-00-00' ? $todate : "";
		include admin_tpl('edit');
	}
	break;

	case 'edit_subject':
		$parentid=$subjectid;
		if(!$subjectid) showmessage($LANG['illegal_parameters']);
		if($dosubmit)
		{

			$admin_vote->set_listorder(DB_PRE.'vote_subject','subjectid',$subjectorder);
			if(is_array($delsubject)) $admin_vote->del($delsubject);
			$admin_vote->update_number($subjectid);
            update_votejs($subjectid);
			showmessage($LANG['operation_success'],$forward);
		} else {
			$subjects = $admin_vote->get_subjects($subjectid);
			$vote_info = $admin_vote->get_vote($subjectid, 'subject');
			$title=$vote_info['subject'];
			unset($subjects[$subjectid]);
			include  admin_tpl('edit_subject');
		}
		break;
	case 'edit_option':
		if(!$subjectid) showmessage($LANG['illegal_parameters']);
		if($dosubmit)
		{
			$data=array();
			$data['ismultiple']=1;
			$data['ischeckbox'] = intval($ischeckbox);
			$data['subject'] = $subject;
			$data['minval']=intval($minval);
			$data['maxval']=intval($maxval);

			$admin_vote->edit_subject($data,$subjectid);
			$admin_vote->edit_option(array('option'=>$option,'image'=>$image));
			$admin_vote->add_options(array('option'=>$newopt,'image'=>$newpic),$subjectid);
			$admin_vote->set_listorder(DB_PRE.'vote_option','optionid',$listorder);
			$admin_vote->update_number($subjectid);
             update_votejs($subjectid);
			showmessage($LANG['operation_success'],$forward);
		} else {
			$subject = $admin_vote->get_subject($subjectid);
			$subject['options'] = $admin_vote->get_options($subjectid);
			include admin_tpl('edit_option');
		}
		break;
	case 'delete':
		if(empty($subjectids)) showmessage('请选择要删除主题');
		$admin_vote->del($subjectids);
		showmessage($LANG['operation_success'],$forward);
		break;
	case 'delopt':
		$admin_vote->del_option($deloption);
		$admin_vote->update_number($subjectid);
		showmessage($LANG['operation_success'],$forward);
		break;
	case 'pass':
		if(empty($subjectids)) showmessage('请选择要操作的主题','goback');
		if(!ereg('^[0-1]+$',$passed)) showmessage($LANG['illegal_parameters'],$forward);
		$voteids = is_array($subjectids) ? implode(',',$subjectids) : $subjectids;
		$db->query("UPDATE ".DB_PRE."vote_subject SET enabled=$passed WHERE subjectid IN ($voteids)");

		showmessage($LANG['operation_success'],$forward);
	break;

	case 'detail':

		$submenu[]=array($LANG['vote_user_list'] ,'?mod='.$mod.'&file='.$file.'&action=user_list&subjectid='.$subjectid);
		$menu = admin_menu($LANG['vote_manage'],$submenu);

		$vote_data=$admin_vote->get_vote_data($subjectid);
		$subs=$db->select("select subjectid,subject from ".DB_PRE."vote_subject where  (parentid='$subjectid') or (subjectid='$subjectid' and parentid=0) order by listorder desc",'subjectid');
		foreach($subs as $sid=>$data)
		{
			$subs[$sid]['options']=$db->select("select optionid,`option` from ".DB_PRE."vote_option where subjectid='$sid' order by listorder",'optionid');
		}
		$vote_info=$admin_vote->get_vote($subjectid,'subject');
		$title = $vote_info['subject'] ;
		include admin_tpl('detail');
	break;
	case 'reset_data':
		if(!intval($subjectid)) exit($LANG['parameters_error']);
		$admin_vote->reset_data($subjectid);
		exit('success');
		break;
	case 'getcode':

        vote('vote_submit', $voteid,1);
		$voteform =ob_get_contents();
		include admin_tpl('getcode');
	break;

	case 'user_list':

		$number=$db->get_one("select count(ip) as num from ".DB_PRE."vote_data where subjectid='$subjectid'");
		$number=$number['num'];
        $pages = pages($number,$page,$pagesize);
		$voteinfo=$db->get_one("select subject,ismultiple from ".DB_PRE."vote_subject where subjectid='$subjectid'");
		$title=$voteinfo['type']?$voteinfo['title']:$voteinfo['subject'];

		$user_lists=$db->select("select ip,username,userid, time,userinfo from ".DB_PRE."vote_data where subjectid='$subjectid'  limit $offset, $pagesize");
		$pages = pages($number,$page,$pagesize);

		if(!is_array($user_lists)) $user_lists=array();
		include admin_tpl('user_list');
	break;

	case 'user_detail':
		$subs=$db->select("select subjectid,subject from ".DB_PRE."vote_subject where subjectid='$subjectid' or parentid='$subjectid' order by listorder desc",'subjectid');
		foreach($subs as $sid=>$data)
		{
			$subs[$sid]['options']=$db->select("select optionid,`option` from ".DB_PRE."vote_option where subjectid='$sid' order by listorder",'optionid');
		}
		$votedata=$db->get_one("select * from ".DB_PRE."vote_data where time='$time'");

        eval("\$votedata[data] = $votedata[data] ;");

		include admin_tpl('user_detail');
	break;

    case 'useroption':
        $r = $db->get_one("SELECT COUNT(optionid) AS num FROM ".DB_PRE."vote_useroption WHERE optionid='$optionid'");
        $number = $r['num'];
        $pages = pages($number,$page,$pagesize);
        $user_lists = $db->select("select u.*, d.userinfo from ".DB_PRE."vote_useroption u,".DB_PRE."vote_data d  where optionid='$optionid' and u.subjectid=d.subjectid LIMIT $offset,$pagesize ");
        include admin_tpl('useroption');
        break;
}

function update_votejs($voteid)
{
		global $admin_vote;
		$subject_lists = $admin_vote->get_subjects($voteid);
        extract($subject_lists[$voteid]);
        $embed = 1;
		ob_start();
		include template('vote', 'vote_submit');
		$voteform = ob_get_contents();
		ob_clean() ;
		$today = date("Y-m-d", TIME);
        @file_put_contents(PHPCMS_ROOT.'vote/data/vote_'.$voteid.'.js', format_js($voteform));
}
?>