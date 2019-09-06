<?php 
require './include/common.inc.php';

require_once MOD_ROOT.'include/deliver.class.php';
$deliver = new deliver();
if(!$forward) $forward = HTTP_REFERER;

switch($action)
{
    case 'add':
		$deliverid = $deliver->add($d);
	    showmessage('操作成功！', $forward);
		break;

    case 'edit':
		if($dosubmit)
	    {
			$deliver->edit($deliverid, $d);
			showmessage('操作成功！', $forward);
		}
		else
	    {
			$r = $deliver->get($deliverid);
			extract($r);
			include template($mod, 'deliver_edit');
		}
		break;

    case 'delete':
		$deliver->delete($deliverid, $_userid);
		showmessage('操作成功！', $forward);
		break;

    default :
		$forward = $M['url'];
		$delivers = $deliver->listinfo($_userid);
	    if(!$delivers)
	    {
			$member_api = load('member_api.class.php', 'member', 'api');
			$memberinfo = $member_api->get_model_info($_userid);
			if($memberinfo) extract($memberinfo);
		}
		if($_areaid) $areaid = $_areaid;
		$head['title'] = '在线下单_'.$M['name'].'_'.$PHPCMS['sitename'];
		include template($mod, 'deliver');
}
?>