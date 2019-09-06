<?php
require './include/common.inc.php';
if(QUERY_STRING && !isset($userid) && !isset($username)) $userid = intval(QUERY_STRING);
if(!$forward) $forward = HTTP_REFERER;

$member_api = load('member_api.class.php', 'member', 'api');

if (isset($username) && !empty($username))
{
	$userid = $member_api->get_userid($username);
}
if(!intval($userid)) $userid = $_userid;
$is_host = (isset($_userid) && ($userid == $_userid)) ? 1 : 0;
if($userid < 1) showmessage('请选择你想查看的用户');
$result = $member_api->get($userid, array('m.userid', 'disabled'));
if(!$result) showmessage('所查看的用户不存在');
if($result['disabled']) showmessage('该用户已被禁用', $forward);

$blockinfo = $space->get_block($userid);
$memberinfo = $member_api->get($userid, array('username', 'groupid', 'lastlogintime'));
$memberinfo['avatar'] = avatar($userid);
@extract(new_htmlspecialchars($memberinfo));
unset($memberinfo);
$spaceinfo = $space->get_space($userid);
@extract(new_htmlspecialchars($spaceinfo));
unset($spaceinfo);

$head['title'] = !empty($spacename) ? $spacename: $username.$LANG['personal_space'];
$head['keywords'] = $PHPCMS['meta_keywords'];
$head['description'] = $PHPCMS['meta_description'];
if(!$spacename) $spacename = $username;
include template($mod, 'index');
?>