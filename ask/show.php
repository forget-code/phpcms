<?php
require './include/common.inc.php';
require PHPCMS_ROOT.'/member/include/global.func.php';
require MOD_ROOT.'/include/global.func.php';

$GROUPS = cache_read('member_group.php');

$askid = intval($askid);
if(!$askid) showmessage($LANG['illegal_parameters']);

$subject = $db->get_one("select * from ".TABLE_ASK." where askid='$askid' and username='$_username'");
if(!$subject) showmessage($LANG['sorry_not_exist_record']);
$subject['addtime'] = date('Y-m-d h:i', $subject['addtime']);

$departmentid = $subject['departmentid'];
extract($departments[$departmentid]);

if(!check_purview($arrgroupid)) showmessage($LANG['you_have_no_permission']);

$memberinfo = get_member_info($subject['username']);
$subject = array_merge($subject, $memberinfo);
$subject['groupname'] = $GROUPS[$subject['groupid']]['groupname'];
$subject['arrgroupname'] = get_arrgroupname($subject['arrgroupid']);


$replys = array();
$result = $db->query("select * from ".TABLE_ASK_REPLY." where askid=$askid");
while($r = $db->fetch_array($result))
{
	$r['addtime'] = date('Y-m-d h:i', $r['addtime']);
	$memberinfo = get_member_info($r['username']);
	$r = array_merge($r, $memberinfo);
	$r['groupname'] = $GROUPS[$r['groupid']]['groupname'];
	$r['arrgroupname'] = get_arrgroupname($r['arrgroupid']);
	$replys[] = $r;
}


$head['title'] = $subject['subject'];

include template($mod, 'show'); 
?>