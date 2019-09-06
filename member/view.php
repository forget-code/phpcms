<?php
require './include/common.inc.php';
if(!$forward) $forward = HTTP_REFERER;
$userid = isset($userid) ? $userid : $_userid;
if($userid < 1) return false;
$is_host = ($userid == $_userid) ? 1 : 0;
$memberinfo = $member->get($userid, '*', 1);
if($memberinfo['disabled']) showmessage('该用户已被禁用', $forward);
if(!$memberinfo) showmessage('请选择有效用户', $forward);
if(!class_exists('member_output'))
{
	require CACHE_MODEL_PATH.'member_output.class.php';
}

@extract(new_htmlspecialchars($memberinfo));
$data = $member->get_model_info($userid, $modelid);
$member_output = new member_output($modelid, $userid);
$forminfos = $member_output->get($data);
$avatar = avatar($userid);
if($regtime) $regtime = date('Y-m-d H:m:i', $regtime);
if($lastlogintime) $lastlogintime = date('Y-m-d H:m:i', $lastlogintime);

unset($memberinfo);
include template($mod, 'view');
?>