<?php
defined('IN_YP') or exit('Access Denied');
if(!isset($action)) $action = 'manage';
require_once MOD_ROOT.'include/yp.class.php';
require_once MOD_ROOT.'include/apply.class.php';
$c = new yp();
$c->set_model('job');

$a = new apply();
$a->set_userid($_userid);
switch($action)
{
	case 'manage':		
	$page = intval($page);
	if(!$page)$page = 1;
	$applys = $a->get_job_stock_list($_userid,$page);
	$pages = pages($applys['number'],$page,15);
	break;
	
	case 'showapply':
	$stockid = intval($stockid);
	if(!$stockid)exit("error");
	else
	{
		$r = $a->get_stock_by_id($stockid);		
		if($r)
		{
			if(!$r['status'])$a->show_apply($stockid);
			header("location:../apply.php?applyid={$r['applyid']}");
			exit();
		}
		else exit('error');
	}
	break;
	
	case 'invite':
	$stockid = intval($stockid);
	if(!$stockid)exit('0');
	else
	{
		$r = $a->get_stock_by_id($stockid);		
		if($r)
		{
			if($r['status'] != 2)
			{
				$a->show_apply($stockid,2);
				$t = $a->get_userid_by_applyid($r['applyid']);
				$j = $a->get_userid_by_jobid($r['jobid']);
				$subject = "面试通知";
				$content = "{$r['username']}你好，感谢你应聘 {$j['companyname']} 的 {$j['title']} 职位，现邀请您前来参加面试。请您做好面试准备，我们将在近期电话联系您！";			
				require_once(PHPCMS_ROOT."message/include/message.class.php");
				$message = new message();
				$message->send_new($t['userid'], $j['userid'], $subject,$content);	
				if($t['email'])
				{
					require_once(PHPCMS_ROOT."include/sendmail.class.php");
					$sendmail = new sendmail();
					$sendmail->smtp($t['email'], $subject, $content);			
				}
			}
			echo '1';
			exit();
		}else exit('0');
	}
	break;
}
include template('yp', 'center_apply');

?>