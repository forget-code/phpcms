<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(isset($job) && $job == 'start') //开始准备发送订阅邮件
{
	if(!isset($startnum) && !isset($total))
	{
		$mailid = isset($mailid) ? $mailid : 0;
		if(!$mailid)  showmessage($LANG['illegal_parameters'],'goback');
		if(!$typeid)  showmessage($LANG['illegal_type_parameter'] ,'goback');
		$maxnum = isset($maxnum) ? intval($maxnum) : 10;
		
		$r = $db->get_one("SELECT count(emailid) as num FROM ".TABLE_MAIL_EMAIL." WHERE disabled=0 AND authcode='' AND typeids like '%,".$typeid.",%' " );
		$total = $r['num'];
		$forward = "?mod=$mod&file=$file&action=$action&job=$job&mailid=$mailid&startnum=0&typeid=$typeid&maxnum=$maxnum&total=$total";
		$db->query("UPDATE ".TABLE_MAIL." SET sendtime='$PHP_TIME' WHERE mailid=$mailid");
		
		showmessage($LANG['prepare_mail_content_and_email']." $total ".$LANG['sending_subscription_mail_waiting']."...",$forward);
	}
	else 
	{
		$startnum = intval($startnum);
		$maxnum = intval($maxnum);
		$typeid = intval($typeid);
		$successnum = ($total-$startnum<$maxnum) ? ($total-$startnum) : $maxnum;
		if($startnum>=$total) showmessage($LANG['subscription_mail_in_this_category_send_success'],"?mod=$mod&file=$file&action=send");		

		$mail = $db->get_one('SELECT mailid,title,content FROM '.TABLE_MAIL.' WHERE mailid='.$mailid.' limit 1');
		if(empty($mail['title']) || empty($mail['content'])) showmessage($LANG['mail_subject_content_not_null'],'goback');
		
		$query = "SELECT email FROM ".TABLE_MAIL_EMAIL." WHERE disabled=0 AND authcode='' AND typeids like '%,".$typeid.",%' limit $startnum,$maxnum" ;
		$result = $db->query($query);
		$tempsendto = '';
		while($r = $db->fetch_array($result))
		{
			$s = $r['email'];
			if($s!='' && is_email($s)) 
			{
				$tempsendto.=$s.',';
			}
		}
		$tempsendto = substr($tempsendto,0,-1);
		$tmp = $startnum;
		$startnum = $startnum + $maxnum;
		$forward = "?mod=$mod&file=$file&action=$action&job=$job&mailid=$mailid&startnum=$startnum&typeid=$typeid&maxnum=$maxnum&total=$total";
		if(sendmail($tempsendto,$mail['title'],stripslashes($mail['content'])))
		{
			showmessage($LANG['sending'].' '.$tmp.' '.$LANG['to'].' '.$startnum.' '.$LANG['email_send_success'].' '.$successnum .$LANG['item'],$forward);
		}
		else 
		{
			showmessage($LANG['sending'].' '.$tmp.' '.$LANG['to'].' '.$startnum.' '.$LANG['email_some_fail_continue'].'......',$forward);
		}			
	}	
}
else 
{
	$page = isset($page) ? intval($page) : 1;
	$offset = ($page-1)*$PHPCMS['pagesize'];
	$result = $db->query("SELECT count(mailid) as num FROM ".TABLE_MAIL);
	$r = $db->fetch_array($result);
	$number = $r['num'];
	$pages = phppages($number,$page,$PHPCMS['pagesize']);
	
	$query ="SELECT mailid,typeid,title,addtime,sendtime,username,period   ".
			"FROM ".TABLE_MAIL.
			" order by period desc limit $offset,".$PHPCMS['pagesize'];
	
	$result = $db->query($query);
	$mails = array();
	while($r = $db->fetch_array($result))
	{
		$subnum = $db->get_one("SELECT count(emailid) as num FROM ".TABLE_MAIL_EMAIL." WHERE typeids like '%,".$r['typeid'].",%' ");
		$r['addtime'] = date('Y-m-d',$r['addtime']);
		$r['sendtime'] = $r['sendtime'] ? date('Y-m-d',$r['sendtime']) : '<font color=red>'.$LANG['not_send'].'</font>';
		$r['subnum'] = $subnum['num'];	
		$mails[] = $r;
	}
	include admintpl('subscription_send');
}
?> 