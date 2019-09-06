<?php
define('YP_ROOT_DIR', str_replace("\\", '/', dirname(__FILE__)));
require YP_ROOT_DIR.'/include/common.inc.php';
require PHPCMS_ROOT.'/languages/'.$CONFIG['adminlanguage'].'/yp_admin.lang.php';
if(!$_userid) showmessage($LANG['please_login'],$PHPCMS['siteurl'].'member/login.php?forward='.$PHP_URL);
require YP_ROOT_DIR.'/web/admin/include/common.inc.php';
if(isset($action) && $action == 'logout')
{
	mkcookie('auth', '');
	showmessage($LANG['logout_success']);
}
if(!isset($file)) $file = 'index';
preg_match("/^[0-9A-Za-z_]+$/",$file) or showmessage('Invalid Request.');
$filepath = YP_ROOT_DIR.'/web/admin/'.$file.'.inc.php';
if(!@include $filepath) showmessage($LANG['illegal_operation']);
?>