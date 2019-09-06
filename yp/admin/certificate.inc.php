<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!$action) $action = 'manage';

include MOD_ROOT.'include/certificate.class.php';
$c = new certificate();
switch($action)
{
	case 'manage':
		$where = "`status`=1";
		if($field=='userid')
		{
			echo $q;
			$where .= " AND `userid`='$q'";
		}
		elseif($field=='username')
		{
			$r = $db->get_one("SELECT `userid` FROM ".DB_PRE."member_cache WHERE `username`='$q'");
			$where .= " AND `userid` ='$r[userid]'";
		}
		elseif($field=='companyname')
		{
			$r = $db->get_one("SELECT `userid` FROM ".DB_PRE."member_company WHERE `companyname`='$q'");
			$where .= " AND `userid` ='$r[userid]'";
		}
		if($inputdate_start)
		{
			$where .= " AND `addtime`>'".strtotime($inputdate_start)."'";
		}
		if($inputdate_end)
		{
			$where .= " AND `addtime`<'".strtotime($inputdate_end)."'";
		}
		$infos = $c->listinfo($where, '`id` DESC', $page, 30, 1);
		include admin_tpl('certificate_manage');
		break;

	case 'edit':
		$id = intval($id);
		if($dosubmit)
		{
			$info['name'] = strip_tags($name);
			$info['organization'] = strip_tags($organization);
			$info['thumb'] = htmlspecialchars($thumb);
			$info['addtime'] = TIME;
			$c->edit($id,$info);
			showmessage('修改成功！', $forward);
		}
		else
		{
			$info = $c->get($id);
			include admin_tpl('certificate_edit');
		}
		break;
		
	 case 'delete':
		$c->delete($id);
		showmessage('操作成功！', $forward);
		break;

}
?>