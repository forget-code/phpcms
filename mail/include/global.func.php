<?php
function comparetime($time)
{
    return TIME-intval($time)>30*24*60*60;
}

/**
 *	根据用户id,查找用户的订阅邮箱
 *	@params
 *	@return
 */

function get_mail($userid){
	global $db;
	$sql = "SELECT `email` FROM ".DB_PRE."mail_email WHERE `userid` = '{$userid}' ";
	return $db->get_one($sql);
}

/**
 *	
 *	@params
 *	@return
 */

?>