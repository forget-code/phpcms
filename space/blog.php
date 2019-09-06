<?php
require './include/common.inc.php';
$member = load('member.class.php', 'member', 'include');
$userid = isset($userid) ? $userid : $_userid;
if($userid < 1) return false;
$memberinfo = $member->get($userid, $fields = '*', 1);
$memberinfo['avatar'] = avatar($userid);
@extract(new_htmlspecialchars($memberinfo));
$spaceinfo = $space->get_space($userid);
@extract(new_htmlspecialchars($spaceinfo));
unset($spaceinfo);
$head['title'] = !empty($spacename) ? $spacename: $username.$LANG['personal_space'];
include template('space', 'blog');
?>