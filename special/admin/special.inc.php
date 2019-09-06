<?php
defined('IN_PHPCMS') or exit('Access Denied');

$action = trim($action);
if($action != 'select_content')
{
	require_once MOD_ROOT.'include/special.class.php';
    require_once MOD_ROOT.'include/html.class.php';
    $html = new html();
	$special = new special();
}


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
				if($info['disabled'] == 0)
				{
					$html->index();
					$html->type($info['typeid']);
					$html->show($specialid, $info['filename'], $info['typeid']);
				}
				$forward = '?mod=special&file=special&action=block&specialid='.$specialid.'&forward='.urlencode($forward);
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			$forward = '?mod=special&file=special&action=manage';
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
				if($info['disabled'] == 0)
				{
					$html->index();
					$html->type($info['typeid']);
					$html->show($specialid, $info['filename'], $info['typeid']);
				}
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
			if(!$info) showmessage('指定的专题不存在！');
			extract($info);
			$roleids = implode(',', $priv_role->get_roleid('specialid', $specialid));
			include admin_tpl('special_edit');
		}
		break;

    case 'manage':
		$types = subtype('special');
		$submenu = array();
		$submenu[] = array('全部', '?mod=special&file=special&action=manage');
		foreach($types as $id=>$type)
		{
			$submenu[] = array($type['name'], '?mod=special&file=special&action=manage&typeid='.$id);
		}
		$menu = admin_menu('专题分类', $submenu);

        $where = '';
        if($typeid) $where .= "AND `typeid`='$typeid' ";
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
            $where .= "AND `createtime`>=$createtime_start ";
		}
		if($createdate_end)
	    {
			$createtime_end = strtotime($createdate_end.' 23:59:59');
            $where .= "AND `createtime`<=$createtime_end ";
        }
		if($where) $where = substr($where, 3);
        $data = $special->listinfo($where, 'listorder desc,specialid desc', $page, 20);

		if(!isset($createdate_start)) $createdate_start = date('Y-m').'-01';
		if(!isset($createdate_end)) $createdate_end = date('Y-m-d');
		include admin_tpl('special_manage');
		break;

	case 'delete':
		$result = $special->delete($specialid);
		if($result)
		{
			showmessage('操作成功！', '?mod=special&file=special&action=manage');
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

    case 'list':
		$types = subtype('special');
        $where = '';
        if($typeid) $where .= "AND `typeid`='$typeid' ";
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
            $where .= "AND `createtime`>=$createtime_start ";
		}
		if($createdate_end)
	    {
			$createtime_end = strtotime($createdate_end.' 23:59:59');
            $where .= "AND `createtime`<=$createtime_end ";
        }
		if($where) $where = substr($where, 3);
        $data = $special->listinfo($where, 'listorder desc,specialid desc', $page, 20);
        $year = date('Y');
        $month = date('n');
        $month_start = max($month-3, 1);

		if(!isset($createdate_start)) $createdate_start = date('Y-m').'-01';
		if(!isset($createdate_end)) $createdate_end = date('Y-m-d');
		include admin_tpl('special_list');
		break;

    case 'select_content':
        if($dosubmit)
        {
            $specialid = intval($specialid);
            if(!$specialid) showmessage('指定的专题不存在！');
            if(empty($contentid)) showmessage('请选择要插入的信息！');
            require_once MOD_ROOT.'include/special.class.php';
            $special = new special();
            $special->select_content($contentid, $specialid);

			require_once MOD_ROOT.'include/html.class.php';
			$html = new html();
			$html->show($specialid);

            showmessage('操作成功!', $forward);
        }
        else
        {
            $specialid = intval($specialid);
            if(!$specialid) showmessage('指定的专题不存在！');

			require_once 'admin/content.class.php';
            $c = new content();

            $status = isset($status) ? intval($status) : 99;
            $where .= " `status`=$status";

            if($typeid) $where .= " AND `typeid`=0 ";
            if($areaid) $where .= " AND `areaid`='$areaid' ";
            if($inputdate_start) $where .= " AND `inputtime`>='".strtotime($inputdate_start.' 00:00:00')."'"; else $inputdate_start = date('Y-m-01');
            if($inputdate_end) $where .= " AND `inputtime`<='".strtotime($inputdate_end.' 23:59:59')."'"; else $inputdate_end = date('Y-m-d');
            if($q != '')
            {
                if($catid) $where .= " AND catid='$catid'";
                if($field == 'title')
                {
                    $where .= " AND `title` LIKE '%$q%'";
                }
                elseif($field == 'userid')
                {
					$userid = userid($q);
                    if($userid) $where .= " AND `userid`=$userid";
                }
                elseif($field == 'contentid')
                {
                    $where .= " AND `contentid`='$q'";
                }
            }

            $infos = $c->listinfo($where, '`listorder` DESC,`contentid` DESC', $page, 20);
            $pagetitle = '添加专题信息';

            include admin_tpl('select_content');
        }
        break;

        case 'manage_content':
            if($dosubmit)
            {
                if(!$specialid) showmessage('参数非法！');
                if(empty($contentid)) showmessage('请选择要删除的文章！');
				$special->del_content($specialid, $contentid);
				$html->show($specialid);
                showmessage('删除成功！', $forward);
            }
            else
            {
                $specialid = intval($specialid);
				$r = $special->get($specialid);
				if(!$r) showmessage('指定的专题不存在！');
				extract($r);
                $infos = $special->list_content($specialid, $page, 20);
                include admin_tpl('manage_content');
            }
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