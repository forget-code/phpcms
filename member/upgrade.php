<?php
require './include/common.inc.php';
if(!$_userid) showmessage($LANG['please_login'], $M['url'].'login.php?forward='.urlencode(URL));
require MOD_ROOT.'include/group.class.php';
$group = new group();

$avatar = avatar($_userid);

switch($action)
{
    case 'view':
		$r = $group->get($groupid);
	    if(!$r) showmessage('会员组不存在！');
		extract($r);
		$head['title'] = '查看会员服务_会员中心_'.$PHPCMS['sitename'];
		include template($mod, 'upgrade_view');
		break;

    case 'pay':
		$r = $group->get($groupid);
	    if(!$r) showmessage('会员组不存在！');
		extract($r);

		if($dosubmit)
	    {
			if(!in_array($unit, array('y', 'm', 'd')) || !preg_match("/^[0-9]+$/", $number) || $number < 1) showmessage('参数错误！');
			$price = $r['price_'.$unit];
			$total = $number*$price;
			$pay_api = load('pay_api.class.php', 'pay', 'api');
			if(!$pay_api->update_exchange('member', $M['paytype'], -$total, "会员升级"))
			{
				showmessage($pay_api->error());
			}
			$group->extend_upgrade($_userid, $groupid, $unit, $number, date('Y-m-d'));
			showmessage('操作成功！', $forward);
		}
		else
	    {
			$balance = $M['paytype'] == 'amount' ? $_amount : $_point;
		    $head['title'] = '会员升级_会员中心_'.$PHPCMS['sitename'];
			include template($mod, 'upgrade_pay');
		}
		break;

    case 'continue':
		$r = $group->extend_get($_userid, $groupid);
	    if(!$r) showmessage('会员组不存在！');

		if($dosubmit)
	    {
			if(!in_array($unit, array('y', 'm', 'd')) || !preg_match("/^[0-9]+$/", $number) || $number < 1) showmessage('参数错误！');
			$price = $r['price_'.$unit];
			$total = $number*$price;
			$pay_api = load('pay_api.class.php', 'pay', 'api');
			if(!$pay_api->update_exchange('member', $M['paytype'], -$total, "会员续费"))
			{
				showmessage($pay_api->error());
			}
			$group->extend_continue($_userid, $groupid, $unit, $number);
			showmessage('操作成功！', $forward);
		}
		else
	    {
			extract($r);
			$balance = $M['paytype'] == 'amount' ? $_amount : $_point;
		    $head['title'] = '会员续费_会员中心_'.$PHPCMS['sitename'];
			include template($mod, 'upgrade_continue');
		}
		break;

    default :
		$data = array();
	    $today = date('Y-m-d');
		$groups = $group->extend_list($_userid);
		$array = $group->listinfo('`issystem`=0 AND disabled=0', '`listorder`');
		foreach($array as $k=>$v)
		{
			$groupid = $v['groupid'];
			$v['iscontinue'] = isset($groups[$groupid]) ? 1 : 0;
			$v['isexpired'] = $groups[$groupid]['enddate'] < $today ? 1 : 0;
			if($v['iscontinue'])
			{
				$v['startdate'] = $groups[$groupid]['startdate'];
				$v['enddate'] = $groups[$groupid]['enddate'];
			}
			$data[$groupid] = $v;
		}

		$head['title'] = '会员升级_会员中心_'.$PHPCMS['sitename'];
	    include template($mod, 'upgrade');
}
?>