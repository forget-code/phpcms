<?php
require './include/common.inc.php';
if(!$_userid) showmessage('您还没有登陆，请登陆',$MODULE['member']['url'].'login.php');

if(!$action) $action = 'manage';
$TYPE = subtype('yp');
require_once MOD_ROOT.'include/apply.class.php';

$a = new apply();
$a->set_userid($_userid);
$avatar = avatar($_userid);
switch($action)
{
	case 'add':
		$r = $a->get_userapply($_userid, 'applyid');
		if($r)
		{
			header("Location: myjob.php?action=edit");
			exit;
		}
		if($dosubmit)
		{
			$info['userid'] = $_userid;
			$info['status'] = 3;
			$info['addtime'] = TIME;
			$byear = intval($byear);
			$byear = $byear==19 ? '0000' : $byear;
			$bmonth = intval($bmonth);
			$bday = intval($bday);
			$info['birthday'] = $byear.'-'.$bmonth.'-'.$bday;
			
			$a->add($info);
			
			$MS['title'] = '恭喜！您的简历已经添加成功了！';
			$MS['description'] = '接着您可以做下面的事情';
			$MS['urls'][0] = array(
				'name'=>'修改完善我的简历',
				'url'=>'?action=edit',
				);
			$MS['urls'][1] = array(
				'name'=>'查看与我相关的招聘信息',
				'url'=>'job.php?station='.urlencode($info['station']),
				);
			msg($MS);

		}
		else
		{
			$montharr = array('01','02','03','04','05','06','07','08','09','10','11','12');
			$dayarr = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
			$station = '';
			foreach($TYPE AS $typeid=>$t)
			{
				$station .= "<option value='$typeid'>$t[name]</option>";
			}
		}
		break;
		
		case 'edit':
			if($dosubmit)
			{
				$applyid = intval($applyid);
				$info['edittime'] = TIME;
					$byear = intval($byear);
					$byear = $byear==19 ? '0000' : $byear;
					$bmonth = intval($bmonth);
					$bday = intval($bday);
					$info['birthday'] = $byear.'-'.$bmonth.'-'.$bday;
		
				//echo $info['birthday'];exit;
				$a->edit($applyid,$info);
				$MS['title'] = '恭喜！您的简历已经修改成功了！';
				$MS['description'] = '接着您可以做下面的事情';
				$MS['urls'][0] = array(
					'name'=>'修改完善我的简历',
					'url'=>'?action=edit',
					);
				$MS['urls'][1] = array(
					'name'=>'查看与我相关的招聘信息',
					'url'=>'job.php?station='.urlencode($info['station']),
					);
				msg($MS);
			}
			else
			{
				$r = $a->get_userapply($_userid, '*');
				if($r)
				{
					extract($r);
					$birthday = explode("-", $birthday);
					$byear = $birthday[0]=="0000" ? "19" : $birthday[0];
					$bmonth = $birthday[1];
					$bday = $birthday[2];
				}
				else
				{
					header("Location: myjob.php?action=add");
					exit;
				}
				$montharr = array('01','02','03','04','05','06','07','08','09','10','11','12');
				$dayarr = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
				foreach($TYPE AS $typeid=>$t)
				{
					$selected = '';
					if($typeid==$station) $selected = 'selected';
					$station .= "<option value='$typeid' $selected>$t[name]</option>";
				}
			}

		break;
		
		case 'update':
		$r = $a->get_userapply($_userid, 'applyid');
		if(!$r)
		{
			echo '-1';
		}
		elseif($a->refresh($applyid))
		{
			echo '1';
		}
		else
		{
			echo '0！';
		}
		exit();
		break;
		
		case 'manage':
		
		if(!$page) $page = 1;
		$r = $a->get_userapply($_userid, 'applyid');
		if(!$r)
		{
			showmessage('请先完成我的简历','?action=add');
		}		
		else extract($r);
		if($dosubmit)
		{
			if(is_array($stockid))
			{
				foreach($stockid as $p)
				{
					$p = intval($p);
					$a->del_favor_job($p,$applyid);
				}
			}
		}
		$stocks = $a->get_stock_list(intval($label),$applyid,$page);	
		$pages = pages($stocks['number'],$page,15);
		break;
		
		case 'postapply':
		if(!$jobid)exit('-2');
		if(!$ran)header('location:job.php?action=show&jobid='.$jobid);
		require_once MOD_ROOT.'include/yp.class.php';
		$yp = new yp();
		$yp->set_model('job');
		$r = $yp->get($jobid);
		if($r['updatetime']+3600*24*$r['period'] < time())
		exit('-3');
		$r = $a->get_userapply($_userid, 'applyid');
		if($r)
		{
			$t = $a->is_post_apply($jobid,$r['applyid']);
			if($t)exit('0');
			else
			{
				if($a->post_apply($jobid,$r))
				exit('1');
				else exit('-2');
			}
		}
		else exit('-1');
		break;
		
		case 'favorapply':
		if(!$jobid)exit('-2');
		if(!$ran)header('location:job.php?action=show&jobid='.$jobid);
		$r = $a->get_userapply($_userid, 'applyid');
		if($r)
		{
			$t = $a->is_post_apply($jobid,$r['applyid'],0);
			if($t)exit('0');
			else
			{
				if($a->favor_job($jobid,$r))
				exit('1');
				else exit('-2');
			}
		}
		else exit('-1');
		break;
}
include template('yp','myjob');
?>