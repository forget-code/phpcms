<?php 
defined('IN_PHPCMS') or exit('Access Denied');

if(!is_object($ftp) && $PHPCMS['enableftp'] && $PHPCMS['ftphost'] && $PHPCMS['ftpuser'])
{
	require_once PHPCMS_ROOT.'/include/ftp.class.php';
	$ftp = new phpcms_ftp($PHPCMS['ftphost'], $PHPCMS['ftpuser'], $PHPCMS['ftppass'], $PHPCMS['ftpport'], $PHPCMS['ftpwebpath'], 'I', 1);
	if(!$ftp->connected) showmessage($LANG['ftp_option_error']);
    if(!$ftp->is_phpcms()) showmessage($LANG['root_or_relative_ftproot_error']); 
}
?>