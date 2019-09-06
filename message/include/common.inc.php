<?php
$mod = 'message';
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));
require substr(MOD_ROOT, 0, -1-strlen($mod)).'include/common.inc.php';
require MOD_ROOT.'include/message.class.php';
$message = new message;
$new_message = $message->count_message($where = " status=1 AND send_to_id=$_userid");
$new_out_message = $message->count_message($where = " status=2 AND send_from_id=$_userid");

if(!is_a($member, 'member'))
{
	$member = new member();
}
$num_message = $new_message + $new_out_message;

if($num_message < 1 && $_userid)
{
	$arr_msg = array('userid'=>$_userid, 'message'=>0);
	$member->edit($arr_msg);
}
?>