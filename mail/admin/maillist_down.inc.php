<?php
defined('IN_PHPCMS') or exit('Access Denied');


if(!isset($filename)) showmessage($LANG['illegal_parameters'],'goback');
include_once PHPCMS_ROOT.'/include/filedown.class.php';
$down = new filedown();
$down->down(PHPCMS_ROOT.'/data/mail/data/'.$filename);
?>