<?php
require './include/common.inc.php';
if(!$PHPCMS['uc'])  exit('Ucenter client disabled !');
if(!$_userid) showmessage($LANG['please_login'], $M['url'].'login.php?forward='.urlencode(URL));
if(!$forward) $forward = HTTP_REFERER;
$outcredit = cache_read('creditsettings.php');
if(!$outcredit && $_groupid==1) showmessage('没有相关的更新积分兑换方案，请到Ucenter处添加', UC_API);
$avatar = avatar($_userid);

$pay_api = load('pay_api.class.php', 'pay', 'api');
$arr_credit = array(1=>'point', 2=>'amount');
$credit = $arr_credit[$fromcreditid];

switch($action)
{
	case 'checkcredit':
		$orgcredit = $member->get($_userid, $credit);
		if($orgcredit[$credit] < $value)
		{
			exit('超过'.$credit.'的最大值');
		}
		else
		{
			exit('success');
		}
		break;
	default:
		if($dosubmit)
		{
			if(!$member->verfy_password($_userid, $password))
			{
				showmessage('密码不正确', $forward);
			}
			$orgcredit = $member->get($_userid, $credit);
			if($orgcredit[$credit] < $fromcredit)
			{
				showmessage('超过你所有的最大值', $forward);
			}
			$inputCredit = $fromcredit;
			$key = $toappid.'|'.$tocreditid;
			$fromcredit = floor($fromcredit / $outcredit[$key]['ratio']);
			$ucresult = uc_call('uc_credit_exchange_request', array($_userid, $fromcreditid, $tocreditid, $toappid, $fromcredit));
			if(!$ucresult)
			{
				showmessage('API有误，请检查', $forward);
			}
			$pay_api->update_exchange($mod, $arr_credit[$fromcreditid], -$inputCredit, '兑换积分', $_userid);
			showmessage('操作成功', $forward);
		}
		else
		{
			$arr_select[0] = '请选择';
			foreach($outcredit as $keyid=>$item)
			{
				$arr_select[$keyid] = $item['title'];
			}
			include template($mod, 'chancredit');
		}
	break;
}
?>