<?php
require './include/common.inc.php';
require MOD_ROOT.'/include/mails.class.php';
$m = new mails();
$auth = trim($auth);
$tm = trim($tm);
$checktime = $tm+72*60*60;
if(empty($auth) || empty($tm)) showmessage('验证失败!');
$newtime = (TIME - $checktime);
if($newtime > 0 ) showmessage('验证失败!');
$action = array('check','del','activate');
if(!in_array($ac, $action)) showmessage('非法的参数！');
switch($ac)
{
    case 'check':
        if($auth)
        {
            $md5 = AUTH_KEY.$em.'1'.$tp.$tm;
            if($auth == md5($md5) && is_email($em))
            {
                $m->checkMailType($em,$tp);
                showmessage('订阅成功!');
            }
            else
            {
                showmessage('验证失败!');
            }
        }
        else
        {
            showmessage('参数非法!');
        }
    break;
    case 'del':
        if($auth)
        {
           $md5 = AUTH_KEY.$em.'0'.$tp;
            if($ui)
            {
                $md5 .= $ui;
            }
            if( $auth == md5($md5) && is_email($em))
            {
				$m->delTpyeMail($em,$tp);
				showmessage('退订成功!');
            }
            else
            {
                showmessage('验证失败!');
            }
        }
        else
        {
            showmessage('参数非法!');
        }
        break;
        case 'activate':
            $em = trim($em);
			$om = trim($om);
            if(is_email($em) && is_email($om))
            {
                if($m->setActivation($em, $om, $auth))
                {
                    showmessage('验证成功!');
                }
                else
                {
                    showmessage($m->error());
                }
            }
            else
            {
                showmessage('验证失败!');
            }
        break;
}

?>