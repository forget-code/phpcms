<?php
require './include/common.inc.php';
if(!$_userid) showmessage('');
if($dosubmit)
{
	$aids = $attachment->upload('preview', 'jpg|jpeg|gif|bmp|png', UPLOAD_MAXSIZE, 1);
	if(!$aids) exit($attachment->error());
	$member->edit(array('avatar'=>$aids[0]));
	$avatar = avatar($_userid);
	echo $avatar;
}
else
{
	$avatar = avatar($_userid);
	include template($mod, 'upload');
}
?>