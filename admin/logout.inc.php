<?php
defined('IN_PHPCMS') or exit('Access Denied');

unset($_SESSION['admin_grade'], $_SESSION['admin_modules'], $_SESSION['admin_channelids'], $_SESSION['admin_catids'], $_SESSION['admin_specialids'], $_SESSION['admin_purviewids']);

showmessage($LANG['logout_success'], $PHP_SITEURL);
?>