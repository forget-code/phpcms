<?php

require_once './include/common.inc.php';
$voteid = intval($voteid);

if(!$voteid) showmsg($LANG['illegal_parameters']);
$info = $admin_vote->check($voteid);

if(!is_array($info) && $info<=0) showmsg($LANG[$errmsg[$info]] ,SITE_URL.'vote/show.php?voteid='.$voteid);

if(!$info['allowguest'] && !$_userid) showmsg($LANG['anonymous_cant_not_vote'],SITE_URL.'member/login.php?forward='.urlencode(SITE_URL.SCRIPT_NAME).'?'.QUERY_STRING);

$votable = TRUE;
if(!is_array($info))
{
	$votable = FALSE;
	$vote_msg=$LANG[$errmsg[$info]];
}

$vote_config = $admin_vote->get_vote($voteid);
$subject_lists = $subjects = $admin_vote->get_subjects($voteid);
if(!$vote_config)   showmsg($LANG['illegal_parameters'], $forward);
if($dosubmit)
{

    if(!is_array($info))   showmessage($LANG[$errmsg[$info]]);

	checkcode($checkcode,$info['enablecheckcode'],$forward);
	$newdata=array();
	if(!is_array($votedata)) showmessage($LANG['submit_data_invalid'].$LANG['operation_failure'],$forward);

	$_userinfo = is_array($vote_config['userinfo'])?($vote_config['userinfo']):array();

	if((!$_userinfo && is_array($userinfo))) showmessage($LANG['submit_data_invalid'].$LANG['operation_failure'],$forward);
    if(count($_userinfo)!=count($userinfo)) showmessage($LANG['submit_data_invalid'].$LANG['operation_failure'],$forward);
    $userinfo = is_array($userinfo)?$userinfo:array();
    foreach($userinfo as $key=>$val)
	{
        if($key=='sex') continue ;
		if(!isset($_userinfo[$key])) showmessage($LANG['submit_data_invalid'].$LANG['operation_failure'].$key,$forward);
		if($_userinfo[$key] && !trim($val)) showmessage($LANG[$key].$LANG['sign_invalid'] , $forward);
		check_vote_field($key,$val);
	}

    $optiondata = array();
	foreach($votedata as $sid=>$data)
	{
		$newdata[$sid]=array();
		$min=max(intval($subjects[$sid]['minval']),1);
		$max = intval($subjects[$sid]['maxval']);
		$max = $max<$min?count($subjects[$sid]['options']):$max;
		$count = count($votedata[$sid]);

		if($subjects[$sid]['ismultiple'])
		{

			if(!($count>=$min && $count<=$max))  showmessage($LANG['operation_failure'].'multi', $forward);
		}

		foreach($data as $optionid){
			if(!$admin_vote->check_optionid($optionid)) showmessage($LANG['operation_failure'], $forward);
			$optiondata[$sid][$optionid]=1;
		}
	}

    $admin_vote->vote_submit($voteid, array_keys($votedata), $optiondata, $userinfo);
	showmessage($LANG['vote_success'],PHPCMS_PATH.'vote/show.php?voteid='.$voteid);
}
extract($vote_config);

$template =$template ? $template : 'vote';
$head['title']=$LANG['vote_subject'].' '.$title.' - '.$PHPCMS['sitename'];

if($action=='js')
{
	ob_clean();
	ob_start();

	$template = ($template =='vote')?'vote_submit' : $template ;
    $embed = 1 ;
	include template('vote',$template);
	$data=ob_get_contents();
	ob_clean();
	exit(format_js($data));
}
include template('vote', 'vote');


function showmsg($msg,$forward='') {
    global $action;
    if($action=='js')
        echo format_js($msg);
    else
        showmessage($msg, $forward);
}
?>