<?php
defined('IN_PHPCMS') or exit('Access Denied');

function card_type()
{
	global $db;
	$types = array();
	$result = $db->query("SELECT `ptypeid`,`name` FROM ".DB_PRE."pay_pointcard_type ORDER BY `ptypeid` DESC");
	while($r = $db->fetch_array($result))
	{
		$types[$r['ptypeid']] = $r['name'];
	}
	$db->free_result($result);
	return $types;
}

function get_mod(){
	global $MODULE;
	$mods = array('0' => '模块选择');
	foreach($MODULE as $k=>$v)
	{
		$mods[$k] = $v['name'];
	}
	return $mods;
}

/**
 *	取得系统的支付方式
 *	@params
 *	@return
 */
function get_payType($typeid = 0)
{
	global $db;
	$sql = "SELECT `pay_name` FROM ".DB_PRE."pay_payment WHERE `enabled` = '1' AND `is_online` = '{$typeid}' ORDER BY `pay_order` DESC";
	$result = $db->query($sql);
	$paytype = array();
	while($row = $db->fetch_array($result))
	{
		$paytype[] = $row;
	}
	return $paytype;
}

/**
 *	根据用户id或用户名称 得出用户的信息
 *	@params
 *	@return
 */

function get_user($userid , $username='')
{
	global $db;
    $username = trim($username);
	if ('0' == $userid) {
		$sql = "SELECT `username` , `userid`, `amount`, `point` FROM ".DB_PRE."member WHERE `username` = '{$username}'" ;
	}else {
		$userid = intval($userid);
		$sql = "SELECT `username` , `userid`, `amount`, `point` FROM ".DB_PRE."member WHERE `userid` = '{$userid}'" ;
	}
	return $db->get_one($sql);
}

?>