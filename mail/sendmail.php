<?php
require './include/common.inc.php';
require_once PHPCMS_ROOT.'/include/form.class.php';
$mail = load('sendmail.class.php');
switch ($action)
{
	case 'ajax':
		if (empty($email) && !empty($contentid) )
		{
			$email = explode(',',$email);
			if(!array_map('is_mail',$email))
			{
				echo '0';
			}
		}
		else
		{
			$email = explode(',',$email);
			if(!array_filter($email, 'is_email'))
			{
				echo '0';
			}
			else
			{
				$email = implode(',',$email);
				$sql = "SELECT `title` , `url` FROM ".DB_PRE."content WHERE contentid = '{$contentid}' AND status=99";
				$row = $db->get_one($sql);
				if(empty($row)) echo '0';
				$content = '<html><a href='.$row[url].' target="_blank">'.$row[title].'</a><br/></html>';
				if( $mail->send($email, $row['title'], $content, $PHPCMS['mail_user']) ) echo '1';
			}
		}
	break;
	default:
		if($dosubmit)
		{
            checkcode($checkcode,$M['ischeckcode']);
			if(empty($mailto)) showmessage($LANG['input_addressee'],"goback");
			if(empty($title)) showmessage($LANG['input_mail_subject'],"goback");
			if(empty($content)) showmessage($LANG['input_mail_content'],"goback");
			$content = stripslashes(filter_xss($content));
			$mailto = filter_xss($mailto);
			if( $mail->send($mailto, $title, $content, $PHPCMS['mail_user'])) showmessage('发送成功');
            else showmessage('发送失败,检查你的邮件设置');
		}
		else
		{
           	$mailto = isset($mailto) ? filter_xss($mailto) : '';
			$title = isset($title) ? $title : '';
			$content = isset($content) ? stripslashes($content) : '';
			$title = htmlspecialchars(stripslashes($title));
			$mailmessage = isset($mailmessage) ? $mailmessage : $LANG['send_email'];
			include template("mail","sendmail");
		}
	break;
}
?>