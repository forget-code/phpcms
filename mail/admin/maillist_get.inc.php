<?php
defined('IN_PHPCMS') or exit('Access Denied');


if($dosubmit)
{		
	if($newdata['dbfrom']==2)
	{
		if(empty($newdata['dbhost']))
			showmessage($LANG['input_database_host'],'goback');
		if(empty($newdata['dbuser']))
			showmessage($LANG['input_database_username'],'goback');
		if(empty($newdata['dbname']))
			showmessage($LANG['input_database_name'],'goback');		
	}
	if(empty($newdata['table']))
		showmessage($LANG['input_source_table'],'goback');
	if(empty($newdata['field']))
		showmessage($LANG['input_table_email_field'],'goback');

	if(!preg_match("/^[0-9a-z_]+$/i",$newdata['file']))
		showmessage($LANG['illegal_filename'],'goback');
	if(intval($newdata['number'])<1)
		showmessage($LANG['pick_up_one_data_every_time'],'goback');
	$newdata['file']=$newdata['file'].'.txt';

	if(file_exists($mail_datadir.$newdata['file']))
		showmessage($newdata['file'].$LANG['exist_refill'],'goback');
	
	$newdata = "<?php\n return ".var_export($newdata,TRUE).";\n?>";
	file_put_contents(PHPCMS_ROOT.'/'.$mail_setdir.'mail.php',$newdata);
	$forward='?mod='.$mod.'&file=maillist&action=getlist';
	showmessage($LANG['save_setting_success'].' ... ',$forward);
}
else
{
	if(file_exists($mail_setdir.'mail.php'))
	{
		$data = include(PHPCMS_ROOT."/".$mail_setdir.'mail.php');
		$data['file'] = substr($data['file'],0,-4);
	}
	$data['table'] = $data['table'] ? $data['table'] : $CONFIG['tablepre']."member";
	$data['field'] = $data['field'] ? $data['field'] : "email";

	include admintpl('maillist_get');
}
?>