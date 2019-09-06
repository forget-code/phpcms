<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!$action) $action = 'manage';

include MOD_ROOT.'include/yp.class.php';
$c = new yp();
$c->set_model('job');
foreach($MODEL AS $modelid=>$value)
{
	if($value['modeltype']==9 && $value['tablename'] == 'job') break;
}
$c->modelid = $modelid;

switch($action)
{
	case 'manage':
		if($job=='check')
		{
			$where = '`status`=1';
		}
		else
		{
			$where = '`status`=99';
		}
		if($station) $where .= " AND `station`='$station'";
		if($field=='userid' || $field=='id')
		{
			$where .= " AND `$field`='$q'";
		}
		elseif($field=='title')
		{
			$where .= " AND `$field` LIKE '%$q%'";
		}
		elseif($field=='companyname')
		{
			$r = $db->get_one("SELECT `userid` FROM ".DB_PRE."member_company WHERE `companyname`='$q'");
			$where .= " AND `userid` ='$r[userid]'";
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

		$infos = $c->listinfo($where, '`id` DESC', $page, 30, 1);
		include admin_tpl('job_manage');
		break;

	case 'edit':
		if($id=='') showmessage('请选择要修改的招聘');
		if($dosubmit)
		{
			$secondcatid = intval($secondcatid);
			$thirdcatid = intval($thirdcatid);
			if($thirdcatid)
			{
				$info['catid'] = $thirdcatid;
			}
			elseif($secondcatid)
			{
				$info['catid'] = $secondcatid;
			}
			else
			{
				$info['catid'] = $catid;
			}
			require_once 'attachment.class.php';
			$attachment = new attachment($mod, $catid);
			$c->edit($id, $info);
			showmessage('修改成功！', $forward);
		}
		else
		{
			require CACHE_MODEL_PATH.'yp_form.class.php';
			$content_form = new content_form($modelid);
			$data = $c->get($id);
			$forminfos = $content_form->get($data);
			include admin_tpl('job_edit');
		}
		break;

	case 'listorder':
		if($dosubmit)
		{
			$result = $c->listorder($info);
			if($result)
			{
				showmessage('操作成功！', "?mod=yp&file=job&action=manage");
			}
		}
		else
		{
			if(!$id) showmessage('你没有选择任何招聘',$forward);
			$ids = implodeids($id);
			$where = "id IN ($ids)";
			$infos = $c->listinfo($where, '', 0, 50);
			include admin_tpl('listorder');
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

	case 'move':
		if($dosubmit)
		{
			if($targetcatid=='') showmessage('目标栏目不能为空',$forward);
			if(!$fromtype)
			{
				if(empty($id)) showmessage('指定的ID不能为空');
				if(!preg_match("/^[0-9]+(,[0-9]+)*$/",$id)) showmessage($LANG['illegal_parameters']);
				$c->move($id,$targetcatid,$fromtype);
			}
			else
			{
				if(in_array($targetcatid,$batchcatid)) showmessage('源栏目和目标栏目不能相同', $forward);
				if($CATEGORY[$targetcatid]['child']) showmessage('目标栏目含有子栏目，不允许添加信息', $forward);
				$c->move($batchcatid,$targetcatid,$fromtype);
			}
			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$id = is_array($id) ? implode(',',$id) : $id;
			$category_select = form::select_category($mod, 0,'catid','catid','',$catid);
			$category_select = str_replace(array("<select name='catid' id='catid' >","<option value='0'></option>"),'',$category_select);
			include admin_tpl('move');
		}
	break;
}
?>