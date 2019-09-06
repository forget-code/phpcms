<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array(
	array($LANG['system_sendmail_setting'],'?mod=phpcms&file=setting&tab=5'),
	array($LANG['obtain_maillist'],'?mod='.$mod.'&file=maillist&action=get'),
	array($LANG['maillist_manage'],'?mod='.$mod.'&file=maillist&action=manage')
	);
$forward= isset($forward) ? $forward : $PHP_REFERER;
$type = isset($type) ? $type : 1;
$menu = adminmenu($LANG['manual_send_mail_interface'],$submenu);

$mail_datadir = "data/mail/data/";
$fmail = glob(PHPCMS_ROOT.'/'.$mail_datadir."*.txt");
$fnumber = count($fmail);
if($fnumber>0)
{
	foreach( $fmail as $key=>$val)
	{
		$mailfiles[$key] = basename($val);
	}
}
$filename = isset($filename) ? $filename:'';

if($dosubmit)
{
	
	$start = isset($start) ? intval($start) : 0;
	$fromemail = isset($fromemail) ? $fromemail : '';
	if($start>0 && $type==3 && file_exists(PHPCMS_CACHEDIR.'mail_cache.php'))
	{
		$mailcontent = cache_read('mail_cache.php');
		extract($mailcontent);
	}			
	if($fromemail!='' && !is_email($fromemail))
		showmessage($LANG['illegal_addresser_email'],'goback');
	if(empty($title) || empty($content))
		showmessage($LANG['mail_subject_content_not_null'],'goback');
	
	if($type=='1') //单收件人
	{
			if(!is_email(trim($SingleEmail))) showmessage($LANG['illegal_addressee_email'],'goback');
			$toEmail  = $SingleEmail;
			if(sendmail($SingleEmail,$title,stripslashes($content),$fromemail))
			{
				showmessage($LANG['send_mail_to']. $toEmail.' '.$LANG['success'],'goback');
			}
			else 
			{
				showmessage($LANG['send_mail_to'].$SingleEmail.' '.$LANG['fail_check_system_sendmail_setting'],'goback');
			}
	}
	else if($type=='2') //多收件人
	{
			$maxnum = isset($maxnum) ? intval($maxnum) : 10; 
			$MultiEmail = str_replace("\r","",$MultiEmail);
			$MultiEmail = str_replace("\n",",",$MultiEmail);
			
			$MultiEmail = explode(",",$MultiEmail);
			$toemail = array();
			//$j = 0;
			foreach($MultiEmail as $email)
			{
				//$i=0;
				if($email == '' || !is_email($email)) continue;
				else 
				{
					$toemail[] = $email;
				}			
			}
			$toemail = implode(',',$toemail);
			$emaillist = $toemail;
			if(sendmail($toemail,$title,stripslashes($content),$fromemail))
			{
				showmessage($LANG['send_mail_to'].$emaillist.' '.$LANG['success'],'goback');
			}
			else 
			{
				showmessage($LANG['send_mail_to'].$emaillist.' '.$LANG['fail_check_system_sendmail_setting'],'goback');
			}
		
	}
	else if($type=='3') //从邮件列表
	{
			if($start==0)
			{
				$savetofile['title'] = $title;
				$savetofile['content'] = $content;
				$savetofile['maxnum'] = $maxnum;
				$savetofile['fromemail'] = $fromemail;
				cache_write('mail_cache.php',$savetofile);		
			}
			
			@set_time_limit(1600);
			$maxnum = isset($maxnum) ? intval($maxnum) : 10; 
			
			$maillistfile = isset($maillistfile) ? $maillistfile : $filename;
			$sendto = file(PHPCMS_ROOT.'/'.$mail_datadir.$maillistfile);
			$totalnum = count($sendto);
			if($totalnum>0)
			{
					if($start>=$totalnum) 
					{			
						$okmsg = $LANG['send_all_email_success'];
						@unlink(PHPCMS_CACHEDIR.'mail_cache.php');
						showmessage($okmsg,"?mod=$mod&file=maillist&action=manage");
					}
					else
					{	
						$sendnum = 0;
						$tempsendto = '';
						for($i = $start; $i<$start+$maxnum; $i++)
						{
							if($i>=$totalnum) break;
							$s = trim($sendto[$i]);
							if($s!='' && is_email($s)) 
							{
								$tempsendto.=$s.',';
							}
						}	
						$tempsendto = substr($tempsendto,0,-1);					
						$tmp = $start+1;
						$start = $start+$maxnum;
						$url="?mod=".$mod."&file=send&type=$type&filename=$maillistfile&dosubmit=1";
						if(sendmail($tempsendto,$title,stripslashes($content),$fromemail))
						{
							showmessage($LANG['sending'].' '.$tmp.' '.$LANG['to'].' '.$start.$LANG['email_send_success'].' '.$maxnum.$LANG['item'],$url.'&start='.$start);
						}
						else 
						{
							showmessage($LANG['sending'].' '.$tmp.' '.$LANG['to'].' '.$start.' '.$LANG['email_some_fail_continue'].'......',$url.'&start='.$start);
						}						
					}
			}
			else
			{
				showmessage($LANG['read_email_error'],$forward);
			}		
	}	
}
else
{
	include admintpl('send');
}
?>