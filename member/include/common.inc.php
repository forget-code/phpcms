<?php 
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));

$mod = 'member';
require substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';
require MOD_ROOT.'/include/member.class.php';
require MOD_ROOT.'/include/global.func.php';
require PHPCMS_ROOT.'/include/date.class.php';

$username = isset($username) ? $username : ($_username ? $_username : '');

$date = new phpcms_date;
$member = new member($username);

$head['title'] = $LANG['member_center'];
$head['keywords'] = $LANG['member_center'];
$head['description'] = $LANG['member_center'];

$genders = array(0 => $LANG['female'], 1 => $LANG['male']);
if(!isset($checkcodestr)) $checkcodestr = '';
?>