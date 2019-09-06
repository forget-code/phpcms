<?php
defined('IN_PHPCMS') or exit('Access Denied');

function check_vote_field($key,$val) {
	global $LANG,$forward,$PHCPMS;
    static $keyfields = array(
	'truename'=>'/^.{1,9}$/',
	'sex'=>'/^(0|1)$/',
	'age'=>'/^\d{2}$/',
	'email'=>'/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',
	'addr'=>'/^.{1,}$/',
	'postizp'=>'/^[1-9][0-9]{5}$/',
	'id'=>'/^\d{15,18}x?$/',
	'comment'=>'/^.{1,}$/'
	);

	if(!array_key_exists($key,$keyfields)) return ;
	if(''==$val) return ;
	if(!preg_match($keyfields[$key],$val)) showmessage($LANG['submit_data_invalid'].' <strong>'.$LANG[$key].'</strong>',$forward, 4000);
}
?>