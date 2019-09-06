<?php
require './include/common.inc.php';
require 'attachment.class.php';

$ads['username'] = $_username;
$ads['placeid'] = intval($ads['placeid']);

$attachment = new attachment($mod);
if(isset($_FILES['thumb']) && !empty($_FILES['thumb']['name']))
{
	$ads['imageurl'] = $c_ads->upload('thumb');
	if(!$ads['imageurl']) showmessage($attachment->error(), 'goback');
	$ads['imageurl'] = UPLOAD_URL.$ads['imageurl'];
}
if(isset($_FILES['thumb1']) && !empty($_FILES['thumb1']['name']))
{
	$ads['s_imageurl'] = $c_ads->upload('thumb1');
	if(!$ads['s_imageurl']) showmessage($attachment->error(), 'goback');
	$ads['s_imageurl'] = UPLOAD_URL.$ads['s_imageurl'];
}
if(isset($_FILES['flash']) && !empty($_FILES['flash']['name']))
{
	$ads['flashurl'] = $c_ads->upload('flash');
	if(!$ads['flashurl']) showmessage($attachment->error(), 'goback');
	$ads['flashurl'] = UPLOAD_URL.$ads['flashurl'];
}
if(!$ads['placeid']) showmessage($LANG['invalid_parameters']);
if(!$c_ads->add($ads)) showmessage($c_ads->msg(), 'goback');
showmessage($LANG['add_success_wait_check'], 'goback');
?>