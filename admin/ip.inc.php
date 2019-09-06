<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$action = $action ? $action : 'manage';

$submenu=array(
array($LANG['ip_record_manage'], "?mod=".$mod."&file=ip&action=manage"),
array($LANG['out_of_date_record_clear'], "?mod=".$mod."&file=ip&action=clear")
);
$menu=adminmenu($LANG['ip_manage'], $submenu);


switch($action)
{
  case 'clear':
        $db->query("delete from ".TABLE_BANIP." where overtime<=$PHP_TIME");
	    if($db->affected_rows())
		{
			cache_banip();
		}
		showmessage($LANG['operation_success'], $forward);
  break;

  case 'add':
	
	if($submit)
	{
		$day = $day>0 ? $day : 10;
		$overtime = $day? $day*86400+$PHP_TIME : 10*86400 +$PHP_TIME;
		if(!preg_match("/^([0-9]{1,3}|[*])\.([0-9]{1,3}|[*])\.([0-9]{1,3}|[*])\.([0-9]{1,3}|[*])$/i",$userip))
			showmessage($LANG['illegal_ip_address']);
		$ifban=$ifban?$ifban:1;
		$sql="select id from ".TABLE_BANIP." where ip='$userip'";
		$query=$db->query($sql);
		$num=$db->num_rows($query);
		if($num>0)
		{
			$rs=$db->fetch_array($query);
			$id=$rs['id'];
			$sql="update ".TABLE_BANIP." set ifban='$ifban',overtime='$overtime' where id='$id'";
			$query=$db->query($sql);
		}
		else
		{			
			$query=$db->query("insert into ".TABLE_BANIP."(ip,ifban,username,overtime) values('$userip','$ifban','$_username','$overtime')");
		}
		cache_banip();
		showmessage($LANG['operation_success'], $forward);
	}
	break;

	case 'banip':
		$db->query("update ".TABLE_BANIP." set ifban='$ifban' where id='$ipid'");
	    if($db->affected_rows())
		{
			cache_banip();
			showmessage($LANG['operation_success'], $forward);
		}
	break;

	case 'delete':
		$ipids=is_array($ipid) ? implode(',',$ipid) : $ipid;
		$db->query("DELETE FROM ".TABLE_BANIP." WHERE id IN ($ipids)");
	    if($db->affected_rows())
		{
			cache_banip();
			showmessage($LANG['operation_success'], $forward);
		}
	break;

	default:
		require_once PHPCMS_ROOT.'/include/ip.class.php';
		$iplocation = new ip;

		if(!isset($ip)) $ip = ''; 
		if(!isset($day)) $day = 10; 
		if(!isset($sip)) $sip = ''; 
		if(!isset($username)) $username = ''; 

        $condition = '';
		if($sip && preg_match("/^([0-9]{1,3}|[*])\.([0-9]{1,3}|[*])\.([0-9]{1,3}|[*])\.([0-9]{1,3}|[*])$/i",$sip)) $condition .= " and ip='$sip' ";
		if($username) $condition .= " and username='$username' ";

		$r = $db->get_one("select count(id) as num from ".TABLE_BANIP." where 1 $condition ");
		$number = $r['num'];	
		$pagesize = $PHPCMS['pagesize']>0 ? $PHPCMS['pagesize']:20;
		$page = isset($page) ? intval($page) : 1;
		$offset = ($page-1)*$pagesize;

        $userips = array();
		$query = $db->query("select * from ".TABLE_BANIP." where 1 $condition order by id desc limit $offset,$pagesize");
		while($rs=$db->fetch_array($query))
		{
			if(strpos($rs['ip'],'*')!==false)
			{
				$rs['location']=$LANG['ip_address_area'];
			}
			else
			{
				$iploc = $iplocation->getlocation($rs['ip']);
				$rs['location'] = $iploc['country'];
				if($iploc['area']) $rs['location'] .= '/'.$iploc['area'];
			}
			$rs['overtime']=date('Y-m-d',$rs['overtime']);
			$userips[]=$rs;
		}		
		$pages = phppages($number,$page,$pagesize);
			
		include admintpl('ip_manage');
}
?>