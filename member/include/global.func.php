<?php
defined('IN_PHPCMS') or exit('Access Denied');

function is_badword($string)
{
	$badwords = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n","#");
	foreach($badwords as $value)
	{
	    if(strpos($string,$value) !== FALSE)
		{ 
	        return TRUE; 
	    }
	}
	return FALSE;
}

function get_member_info($username)
{
	global $db;
	if(!$username) return FALSE;
	return $db->get_one("SELECT * FROM ".TABLE_MEMBER." m,".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid and username='$username' limit 0,1");
}
?>