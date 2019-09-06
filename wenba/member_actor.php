<?php
require './include/common.inc.php';

if($dosubmit)
{
	$actor = intval($actor);
	$db->query("UPDATE ".TABLE_MEMBER." SET actortype=$actor WHERE userid=$_userid");
	showmessage($LANG['edit_success'], $PHP_REFERER);
}
$r = $db->get_one("SELECT actortype FROM ".TABLE_MEMBER." WHERE userid=$_userid");
@extract($r);
$TYPES = explode("\n", $MOD['vote_give_actor']);
$actors = cache_read('actors.php');
include template($mod, 'member_actor');
?>