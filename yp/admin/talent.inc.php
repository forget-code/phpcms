<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!$action) $action = 'manage';

include MOD_ROOT.'include/apply.class.php';
$c = new apply();

switch($action)
{
	case 'manage':
		if($station)
		{
			$where = "`station`='$station'";
		}
		else
		{
			$where = "1";
		}
		if($field=='userid' || $field=='applyid')
		{
			$where .= " AND `$field`='$q'";
		}
		elseif($field=='school' || $field=='specialty')
		{
			$where .= " AND `$field` LIKE '%$q%'";
		}
		elseif($field=='username')
		{
			$r = $db->get_one("SELECT `userid` FROM ".DB_PRE."member_cache WHERE `username`='$q'");
			$where .= " AND `userid` ='$r[userid]'";
		}
		
		if($inputdate_start)
		{
			$where .= " AND `inputtime`>'".strtotime($inputdate_start)."'";
		}
		if($inputdate_end)
		{
			$where .= " AND `inputtime`<'".strtotime($inputdate_end)."'";
		}
	
		$infos = $c->listinfo($where, '`applyid` DESC', $page, 30, 1);
		include admin_tpl('talent_manage');
		break;

	case 'edit':
		$applyid = intval($applyid);
		if($dosubmit)
		{
			$info = new_htmlspecialchars($info);
			$info['edittime'] = TIME;
			$byear = intval($byear);
			$byear = $byear==19 ? '0000' : $byear;
			$bmonth = intval($bmonth);
			$bday = intval($bday);
			$info['birthday'] = $byear.'-'.$bmonth.'-'.$bday;
			$c->edit($applyid,$info);
			showmessage('简历更新成功',$forward);
		}
		else
		{
			$r = $c->get($applyid);
			extract($r);
			$birthday = explode("-", $birthday);
			$byear = $birthday[0]=="0000" ? "19" : $birthday[0];
			$bmonth = $birthday[1];
			$bday = $birthday[2];
			$montharr = array('01','02','03','04','05','06','07','08','09','10','11','12');
			$dayarr = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
			foreach($TYPE AS $typeid=>$t)
			{
				$selected = '';
				if($typeid==$station) $selected = 'selected';
				$station .= "<option value='$typeid' $selected>$t[name]</option>";
			}
			include admin_tpl('talent_edit');
		}
		break;
		
	 case 'delete':
		$c->delete($id);
		showmessage('操作成功！', $forward);
		break;
	case 'elite':
		if(!$id) showmessage('你没有选择任何招聘');
		$c->elite($id,$status);
		showmessage('操作成功！', $forward);
		break;
	case 'status':
		if($id=='') showmessage('请选择要批准的内容');
		$c->status($id, 99);
		showmessage('操作成功！', $forward);
		break;
}
?>