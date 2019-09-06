<?php
defined('IN_PHPCMS') or exit('Access Denied');


if($dosubmit)
{
	if($mail)
	{		
		foreach ($mail as $m)
		{
			$filename = PHPCMS_ROOT.'/data/mail/data/'.trim($m);
			if(!preg_match("/^[0-9a-z_]+\.txt$/i",$m)) showmessage($LANG['illegal_file']);
			if(file_exists($filename))
			{
				@unlink($filename);
			}
		}
		showmessage($LANG['delete_maillist_file_success'],"?mod=$mod&file=$file&action=manage");	
	}
	else 
	{
		showmessage($LANG['cannot_find_maillist_file'],"?mod=$mod&file=$file&action=manage");	
	}
}	
else
{
	if(!isset($filename)) showmessage($LANG['illegal_parameters'],'goback');
	if(!preg_match("/^[0-9a-z_]+\.txt$/i",$filename)) showmessage($LANG['illegal_file']);
	if(file_exists(PHPCMS_ROOT.'/data/mail/data/'.$filename))
	{
		@unlink(PHPCMS_ROOT.'/data/mail/data/'.$filename);
		showmessage($LANG['maillist_file']." $filename ".$LANG['delete_success'],"?mod=$mod&file=$file&action=manage");
	}
	showmessage($LANG['maillist_file']." $filename ".$LANG['delete_fail'],"?mod=$mod&file=$file&action=manage");
}
?>