<?php
defined('IN_YP') or exit('Access Denied');
if(!isset($action)) $action = 'manage';

$r = $db->get_one("SELECT regtime,lastlogintime,logintimes FROM `".DB_PRE."member_info` WHERE userid='$_userid'");
@extract($r);
if(isset($MODULE['guestbook'])) @extract($db->get_one("SELECT count(gid) AS new_guestbook_number FROM `".DB_PRE."yp_guestbook` WHERE userid='$_userid' AND status=0"));
if(isset($MODULE['message'])) @extract($db->get_one("SELECT count(messageid) AS new_message_number FROM `".DB_PRE."message` WHERE send_to_id='$_userid' AND status=0"));
$content = cache_read('yp_announce.php');
$content = $content[0];
if(!$company_user_infos['status'] && !$M['ischeck'])
{
	$db->query("UPDATE `".DB_PRE."member_company` SET `status`=1 WHERE `userid`='$userid'");
}
$r = $db->get_one("SELECT `model` FROM `".DB_PRE."yp_count` WHERE `id`='$userid' AND `model`='company'");
if(!$r) $db->query("INSERT INTO `".DB_PRE."yp_count` (`id`,`model`) VALUES ('$userid','company')");
include template('yp', 'center_panel');
?>