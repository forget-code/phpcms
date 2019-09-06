<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/subscription.class.php';
$subscription = new subscription();
$submenu=array(
	array('管理期刊','?mod='.$mod.'&file=subscription&action=list'),
	array('<font color="red">群发期刊</font>','?mod='.$mod.'&file='.$file.'&action=send'),
    array('<font color="red">添加期刊</font>','?mod='.$mod.'&file='.$file.'&action=add'),
	);
$menu=admin_menu('管理期刊',$submenu);
$referer= isset($referer) ? $referer : HTTP_REFERER;
$action = $action ? $action : 'list';
$filearray = array('add','edit','delete','list','send');
in_array($action,$filearray) or showmessage($LANG['illegal_action'],$referer);
switch($action)
{
	case 'list':
		$page = isset($page) ? intval($page) : 1;
		$pagesize = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 10;
		$mails = $subscription->get_list( $condition, $page, $pagesize );
		$pages = $mails['pages'];
		include admin_tpl('subscription_manage');
	break;
	case 'edit';
		if($dosubmit)
		{
			if($subscription->update($setting , $mailid))
			{
				showmessage($LANG['operation_success'], '?mod=mail&file=subscription&action=list');
			}
		}
		else
		{
            $mail = $subscription->get_one_list($mailid);
			include admin_tpl('subscription_edit');
		}
	break;
	case 'delete':
		$mailid = intval($mailid);
		if (isset($mailid))
		{
			$subscription->drop($mailid) ? showmessage($LANG['operation_success'], '?mod=mail&file=subscription&action=list') : showmessage($LANG['delete_fail'], '?mod=mail&file=subscription&action=list') ;
		}
	break;
	case 'add':
		if(isset($dosubmit))
		{
			$setting['addtime'] = TIME;
			$setting['username'] = trim($_username);
            $setting['userid'] = trim($_userid);
			if($subscription->add($setting))
			{
				showmessage($LANG['operation_success'], '?mod=mail&file=subscription&action=list');
			}
		}
		else
		{
            $mailtype = subtype('mail');
			include admin_tpl('subscription_add');
		}
	break;
	case 'send':
		if (isset($job) && $job == 'start')
		{
			if (!isset($startnum) && !isset($total))
			{
				$maxnum = isset($maxnum) ? $maxnum: 10 ;
				$total = $subscription->get_mail_num($typeid);
				//$maxnum = $maxnum + $start;
				$url = "?mod=$mod&file=$file&action=$action&job=$job&mailid=$mailid&startnum=0&typeid=$typeid&maxnum=$maxnum&total=$total";
				showmessage('开始准备邮件内容和待发送的邮件地址，共找到订阅该分类邮件'." $total ".'个!正在发送订阅邮件，请等待...', $url);
			}
			else
			{
				$startnum = intval($startnum);//start send num
				$maxnum = intval($maxnum); // at a time send mail num
				$typeid = intval($typeid);//mail type id

				if($startnum >= $total)
				{
					if($subscription->update_send($mailid))
					{
						showmessage('邮件发送完成', '?mod=mail&file=subscription&action=send');
					}
				}
				if($subscription->send_m_mail($typeid, $startnum, $maxnum, $mailid) == FALSE)
				{
					showmessage('发送失败！','?mod=mail&file=subscription&action=send');
				}
			}
		}
		$page       = isset($page) ? intval($page) : 1;
		$pagesize   = $PHPCMS['pagesize'] ? $PHPCMS['pagesize'] : 10;
		$mails      = $subscription->get_message( $condition, $page, $pagesize );
        $pages      = $mails['pages'];
		include admin_tpl('subscription_send');
	break;
}
?>