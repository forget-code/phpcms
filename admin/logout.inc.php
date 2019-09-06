<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'member/include/member.class.php';
$member = new member();
$member->logout();
showmessage($LANG['logout_success'], SITE_URL);
?>