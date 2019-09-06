<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/maillist.class.php';
$maillist = new maillist();
//目录参数设置
$mail_setdir = PHPCMS_ROOT.'data/mail/';
$mail_datadir = PHPCMS_ROOT.'data/mail/data/';
switch ($action)
{
	case 'list':
        $dir = 'data/mail/data/';
		$mailfiles = $maillist->get_list();
		include admin_tpl('maillist_manage');
	break;
	case 'down':
		if(!isset($filename))
        {
            showmessage($LANG['illegal_parameters'],'goback');
        }
        else
        {
		    file_down($mail_datadir.$filename);
        }
	break;
	case 'delete':
		if ($dosubmit)
		{
			if (!empty($mail))
			{
				if($maillist->drop($mail))
				showmessage($LANG['maillist_file']." $filename ".$LANG['delete_success'],"?mod=$mod&file=$file&action=list");
			}
			showmessage('请选择要删除的对象',"?mod=$mod&file=$file&action=list");
		}
		else
		{
			if(!isset($filename)) showmessage($LANG['illegal_parameters'],'goback');
			if(!preg_match("/^[0-9a-z_]+\.txt$/i",$filename)) showmessage($LANG['illegal_file']);
			if($maillist->drop($filename))
				showmessage($LANG['maillist_file']." $filename ".$LANG['delete_success'],"?mod=$mod&file=$file&action=list");
		}
	break;
	case 'upload':
        $maillist->uploadfile();
	break;

}
?>