<?php
defined('IN_PHPCMS') or exit('Access Denied');


require_once PHPCMS_ROOT.'/include/upload.class.php';
if($dosubmit)
{
	$upfile_size='2000000';
	$upfile_type='txt';
	$fileArr = array(
		'file'=>$_FILES['uploadfile']['tmp_name'],
		'name'=>$_FILES['uploadfile']['name'],
		'size'=>$_FILES['uploadfile']['size'],
		'type'=>$_FILES['uploadfile']['type'],
		'error'=>$_FILES['uploadfile']['error']
		);
	if(!@preg_match("/^[0-9a-z_]+\.txt$/i",$fileArr['name']))
		showmessage($LANG['illegal_filename']);

	$tmpext=strtolower(fileext($fileArr['name']));
	if($fileArr['type']!='text/plain' || $tmpext!=$upfile_type)
		showmessage($LANG['file_format_error_maillist_externsion_must_txt']);

	$savepath = $mail_datadir;
	dir_create($savepath);

	$upload = new upload($fileArr,'',$savepath,$upfile_type,1,$upfile_size);
	if($upload->up())
		showmessage($LANG['maillist_file']." <a href=\"".$mail_datadir.$upload->savename."\" >{$upload->savename}</a> ".$LANG['upload_success_send_group']."<br />".'<a href="?mod='.$mod.'&file=send&type=3&filename='.urlencode($upload->savename).'" title="'.$LANG['view'].'" >[  '.$LANG['yes'].' 	]</a>&nbsp;&nbsp;&nbsp;<a href="?mod='.$mod.'&file='.$file.'&action=manage" title="" >[  '.$LANG['no'].'  ]</a>');
	else
		showmessage($LANG['cannot_upload_errorinfo'].$upload->errmsg());
}
?>