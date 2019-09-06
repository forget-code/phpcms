<?php
require './include/common.inc.php';
if( !$_userid) showmessage('请登陆', $MODULE['member']['url'].'login.php?forward='.urlencode(URL));
require MOD_ROOT.'/include/mails.class.php';
$mails = new mails();
$action = $action ? $action:'do';
switch ($action)
{
	case 'add':
		if(!$mails->addTypeMail($mail, $newmail, $typeid))
		{
			showmessage($mails->error(),"mail/");
		}
		else
		{
			if(empty($typeid))
			{
				showmessage('请选择订阅类型！','mail/subscription.php?action=send&state=1');
			}
			showmessage("订阅成功！","mail/subscription.php?action=do");
		}
	break;
	case 'send':
        $title = '我要订阅';
        if($_userid)
        {
            $mail = $mails->get_mail();
            if(!empty($em) && is_email($em))
            {
                $mail['newemail'] = $em;
            }
            elseif(empty($mail['email']))
            {
                $mail['newemail'] = $_email;
            }
            else
            {
                $mail['newemail'] = $mail['email'];
            }

            if (empty($mail['email']) )
            {
                $mail['email'] = $_email;
            }
        }
        $box = $mails->creatInput();
		include template($mod,"subscription_view");
	break;
	case 'do'://我的订阅
        $title = '我的订阅';
		$stuts = 'no';
        //用户没有订阅的类别
        $mail = $mails->get_mail();
        $typeids = $mails->getTypeMail();
        if(empty($typeids))
        {
            if(!empty($em) && is_email($em))
            {
                header("Location: subscription.php?action=send&state=1&em=$em");
                $state = 1;
            }
            else
            {
                header("Location: subscription.php?action=send&state=1");
            }
        }
        else
        {
            if(!empty($em) && is_email($em))
            {
                $mail['newemail'] = $em;
            }
            else
            {
                $mail['newemail'] = $mail['email'];
            }
            if (empty($mail['email']) )
            {
                $mail['email'] = $_email;
            }
        }
        $box = $mails->creatInput();
        include template($mod,"subscription_view");
	break;
    case 'delall':
        if($dosubmit)
        {
            if( !$mails->dropAll($email) )
            {
                showmessage($mails->error());
            }
            showmessage("退订成功","mail/");
        }
        else
        {
            $mail = $mails->get_mail();
            $data = $mails->myType();
            include template($mod,"subscription_del");
        }
    break;
    case 'activation':
        if(is_email($newemail))
        {
            $mails->sendActivation($newemail);
        }
    break;
}
?>
