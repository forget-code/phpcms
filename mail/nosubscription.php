<?php
require './include/common.inc.php';
require MOD_ROOT.'/include/mails.class.php';
require PHPCMS_ROOT.'/include/form.class.php';
$mails = new mails();
$action = empty($action) ? "do" : $action;
switch ($action)
{
    case 'del':
        if ($dosubmit)//退订邮箱列表
		{
            if ( !empty($typeid) || is_email($newmail))
			{
				if(!$mails->send($mail, $typeid))
				{
					showmessage($mails->error());
				}
                else
                {
				    showmessage(sprintf('退订申请已经发送到你的邮箱(%s)</BR>请点进入邮箱点击连接确定退订',$mail));
                }
			}
            else
            {
                showmessage("请选择订阅类型或者正确的邮箱!","mail/nosubscription.php?action=do");
            }
		}
        else
        {
            $types = subtype($mod);
            include template($mod,"nosubscription_del");
        }
    break;
	case 'do'://订阅
        if ($dosubmit)
		{
			if ( !empty($typeid))
			{
				if(!$mails->send($mail, $typeid,1))
				{
					showmessage($mails->error());
				}
                else
                {
				    showmessage(sprintf('订阅申请已经发送到你的邮箱(%s)</BR>请点进入邮箱点击连接确定订阅',$mail));
                }
			}
            else
            {
                showmessage("请选择订阅类型!","mail/nosubscription.php?action=do");
            }
		}
        else
        {
            if(!empty($em))
            {
                if(!is_email($em))
                {
                    showmessage('E-mail格式不正确！');
                }
            }
            $title = '订阅申请';
            $types = subtype($mod);
            include template($mod,"nosubscription_view");
        }
	break;
	default:
	break;
}
?>
