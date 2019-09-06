<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!$action) $action = 'manage';

include MOD_ROOT.'include/company.class.php';
$company = new company();

switch($action)
{
	case 'manage':
		if($inputdate_start || $inputdate_end)
		{
			$where = 'a.userid=c.userid AND a.userid=i.userid';
			$moreinfo = 1;
		}
		else
		{
			$where = 'a.userid=c.userid';
			$moreinfo = 0;
		}
		if($field=='userid' || $field=='username')
		{
			$where .= " AND c.`$field`='$q'";
		}
		elseif($field=='companyname')
		{
			$where .= " AND a.`companyname` LIKE '%$q%'";
		}
		if($inputdate_start)
		{
			$where .= " AND i.`regtime`>'".strtotime($inputdate_start)."'";
		}
		if($inputdate_end)
		{
			$where .= " AND i.`regtime`<'".strtotime($inputdate_end)."'";
		}
		$group = intval($group);
		if($group)
		{
			$where .= " AND c.groupid = '{$group}' ";
		}
		$areaname = addcslashes(htmlspecialchars($areaname));
		if($areaname) $where .= " AND areaname = '{$areaname}' ";
		$infos = $company->listinfo($where,'a.userid DESC',$page,20,$moreinfo);
		include admin_tpl('company_manage');
	break;
	case 'delete':
		$company->delete($id);
		showmessage('操作成功！', $forward);
		break;
	case 'elite':
		if(!$id) showmessage('请选择要操作的会员');
		$company->elite($id,$status);
		showmessage('操作成功！', $forward);
		break;
	case 'status':
		if(!$id) showmessage('请选择要操作的会员');
		$company->status($id,$status);
		showmessage('操作成功！', $forward);
		break;
	case 'import':
		header( "Content-type: application/vnd.ms-excel" ); 
		header( "Content-Disposition: attachment; filename=company.csv" ); 
		echo "会员名,公司名称,会员组,状态,服务期截至,所在地区\n";
		if($ordertype == 1)$order = 'm.groupid DESC';
		elseif($ordertype == 2)$order = 'c.areaname DESC';
		else $order = 'c.endtime DESC';
		$infos = $db->select("SELECT c.*,m.username,m.groupid FROM `".DB_PRE."member` `m`, `".DB_PRE."member_company` `c` WHERE c.userid = m.userid ORDER BY {$order}");
		foreach($infos as $info)
		{
			$info['groupid'] = $GROUP[$info['groupid']];
			if($info['status'])$info['status'] = '通过';
			else $info['status'] = '未通过';
			if($info['endtime'])$info['endtime'] = date("Y-m-d",$info['endtime']);
			else $info['endtime'] = '永久';
			if(strpos($info['username'],","))$info['username'] = "\"".$info['username']."\"";
			if(strpos($info['companyname'],","))$info['companyname'] = "\"".$info['companyname']."\"";
			if(strpos($info['groupid'],","))$info['groupid'] = "\"".$info['groupid']."\"";
			if(strpos($info['status'],","))$info['status'] = "\"".$info['status']."\"";
			if(strpos($info['endtime'],","))$info['endtime'] = "\"".$info['endtime']."\"";
			if(strpos($info['areaname'],","))$info['areaname'] = "\"".$info['areaname']."\"";
			echo "{$info['username']},{$info['companyname']},{$info['groupid']},{$info['status']},{$info['endtime']},{$info['areaname']}\n";
		}
	break;
}
?>