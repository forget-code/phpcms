<?php
require './include/common.inc.php';


$head['title'] = $LANG['send_email'];
$head['keywords'] = $LANG['online_send_email'];
$head['description'] = $LANG['send_email'];

if($dosubmit)
{
      if(empty($mailto)) showmessage($LANG['input_addressee'],"goback");
      if(empty($title)) showmessage($LANG['input_mail_subject'],"goback");
      if(empty($content)) showmessage($LANG['input_mail_content'],"goback");
      
      if($MOD['ischeckcode'])
      {
	      if(empty($checkcodestr)) showmessage($LANG['input_checkcode'],"goback");
			checkcode($checkcodestr, $MOD['ischeckcode'], $PHP_REFERER);
      }
      $content = stripslashes(str_safe($content));
	  if(sendmail($mailto,$title,stripslashes($content)))
	  {      
	      showmessage($LANG['email_send_success'],"close");
	  }
	  else 
	  {
		showmessage($LANG['sendmail_to']." $mailto ".$LANG['failed_contract_administrator'],'goback');
	  }
}
else
{
	 $mailto = isset($mailto) ? $mailto : '';
	 $title = isset($title) ? $title : '';
	 $content = isset($content) ? $content : '';
     $mailmessage = isset($mailmessage) ? $mailmessage : $LANG['send_email'];
     include template("mail","sendmail");
}
?>