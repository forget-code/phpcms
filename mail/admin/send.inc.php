<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/send.class.php';
$send = new send();
$type = isset($type) ? $type : '1' ;
$filename = isset($filename) ? $filename : $PHPCMS['mail_user'];
if($dosubmit)
{
    $type = trim($type);
	switch ($type)
	{
		case '1':
			if(!is_email(trim($SingleEmail))) showmessage($LANG['illegal_addressee_email'],'goback');
            if(empty($title)) showmessage('请输入标题!');
            if($send->send_one($SingleEmail, stripslashes($title), stripslashes($content), $PHPCMS['mail_user']))
			{
				showmessage('发送成功！',$forward);
			}
			else
			{
				showmessage('发送失败'.$LANG['fail_check_system_sendmail_setting']);
			}
		break;
		case '2':
            if(empty($title)) showmessage('请输入标题!');
			if( $send->send_many($maxnum , $MultiEmail, stripslashes($title), stripslashes($content), $fromemail))
			{
				showmessage('发送成功！');
			}
			else
			{
				showmessage('发送失败'.$LANG['fail_check_system_sendmail_setting']);
			}
		break;
		case '3':
            if($start == 0)
            {
                if(empty($title) || empty($content)) showmessage($LANG['mail_subject_content_not_null'],'goback');
                $savetofile['title']        = $title;
                $savetofile['content']      = $content;
                $savetofile['maxnum']       = $maxnum;
                $savetofile['fromemail']    = $fromemail;
                $send->set_cache($savetofile);
            }
            if($send->send_file($maillistfile, $start) == FALSE)
            {
                showmessage('全部发送完成!','?mod=mail&file=send');
            }
		break;
	}
}
else
{
    $mailfiles = $send->getFileMail();
	include admin_tpl('send');
}
?>