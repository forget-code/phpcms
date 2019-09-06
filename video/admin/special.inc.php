<?php
defined('IN_PHPCMS') or exit('Access Denied');

$submenu[] = array('管理专辑', '?mod='.$mod.'&file='.$file.'&action=manage');
$submenu[] = array('添加专辑', '?mod='.$mod.'&file='.$file.'&action=add');

$menu = admin_menu($CATEGORY[$catid]['catname'].'专辑管理', $submenu);

if(!$action) $action = 'manage';

require_once MOD_ROOT.'include/special.class.php';
$special = new special();

if(!$forward) $forward = '?mod=special&file=special&action=manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$specialid = $special->add($info);
			if($specialid)
			{
				$priv_role->update('specialid', $specialid, $roleids);
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			include admin_tpl('special_add');
		}
		break;

    case 'edit':
		if($dosubmit)
		{
			$result = $special->edit($specialid, $info);
			if($result)
			{
				$priv_role->update('specialid', $specialid, $roleids);
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			$info = $special->get($specialid);
			if(!$info) showmessage('指定的专辑不存在！');
			extract($info);
			$roleids = implode(',', $priv_role->get_roleid('specialid', $specialid));
			include admin_tpl('special_edit');
		}
		break;

    case 'manage':

        $where = '';
        if($q)
	    {
			if($field == 'title') $where .= "AND `title` LIKE '%$q%' ";
			elseif($field == 'description') $where .= "AND `description` LIKE '%$q%' ";
			elseif($field == 'username') $where .= "AND `username`='$q' ";
			elseif($field == 'userid') $where .= "AND `userid`='$q' ";
			elseif($field == 'specialid') $where .= "AND `specialid`='$q' ";
		}
		if($createdate_start)
	    {
			$createtime_start = strtotime($createdate_start.' 00:00:00');
            $where .= "AND `addtime`>=$createtime_start ";
		}
		if($createdate_end)
	    {
			$createtime_end = strtotime($createdate_end.' 23:59:59');
            $where .= "AND `addtime`<=$createtime_end ";
        }
		if($where) $where = substr($where, 3);
        $data = $special->listinfo($where, 'listorder ASC,specialid desc', $page, 10);

		if(!isset($createdate_start)) $createdate_start = date('Y-m').'-01';
		if(!isset($createdate_end)) $createdate_end = date('Y-m-d');
		
		include admin_tpl('special_manage');
		break;

	case 'delete':
		$result = $special->delete($specialid);
		if($result)
		{
			showmessage('操作成功！', '?mod='.$mod.'&file=special&action=manage');
		}
		else
		{
			showmessage('操作失败！');
		}
		break;

    case 'listorder':
		$result = $special->listorder($listorder);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;

    case 'elite':
		$result = $special->elite($specialid, $value);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;

    case 'disable':
		$result = $special->disable($specialid, $value);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;

	case 'block':
		$r = $special->get($specialid);
		if($r) extract($r);
		if(!isset($template) || !$template) $template = 'special';
		include admin_template($mod, $template);
        include admin_tpl('block_ajax', 'phpcms');
		break;

	case 'checkname':
		$sql = '';
		if($specialid)
		{
			$specialid = intval($specialid);
			$sql .= " AND `specialid`!=$specialid";
		}
		$sql .= " AND `filename`='$value'";
		if($special->get_id($sql))
		{
			exit('此文件名已存在！');
		}
		else
		{
			exit('success');
		}
		break;

	case 'manage_content':
		if($dosubmit)
		{
			if(!$specialid) showmessage('参数非法！');
			if(empty($vid)) showmessage('请选择要删除的视频！');
			$special->del_content($specialid, $vid);
			showmessage('删除成功！', $forward);
		}
		else
		{
			$specialid = intval($specialid);
			$r = $special->get($specialid);
			if(!$r) showmessage('指定的专辑不存在！');
			extract($r);
			$infos = $special->list_content($specialid, $page, 20);
			include admin_tpl('manage_content');
		}
	break;
	
	case 'content_listorder':
		//专辑视频排序
		$specialid = intval($specialid);
		$special->content_listorder($specialid,$listorders);
		showmessage("操作成功！",$forward);
		break;
}

function list_type_month_url($typeid = 0)
{
	$year = date('Y');
	$month = date('n');
	$month_start = max($month-2, 1);
	$data = '';
    for($i=$month_start; $i<=$month; $i++)
    {
		$createdate_start = $year.'-'.$i.'-01';
		$createdate_end = $year.'-'.$i.'-'.date('t', strtotime($createdate_start));
        $url = url_par("typeid=$typeid&createdate_start=$createdate_start&createdate_end=$createdate_end");
		if($i > $month_start) $data .= ' | ';
		$data .= "<a href='$url'>{$i}月</a>";
    }
	return $data;
}
?>