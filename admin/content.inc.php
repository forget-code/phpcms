<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'admin/process.class.php';
require_once 'admin/content.class.php';
require_once 'attachment.class.php';
$c = new content();

if(is_numeric($contentid) && $contentid>0)
{
	$data = $c->get($contentid);
	$catid = $data['catid'];
	$modelid = $CATEGORY[$catid]['modelid'];
}
if(!isset($catid) || !isset($CATEGORY[$catid])) showmessage('缺少 catid 参数!');
extract(cache_read('category_'.$catid.'.php'));

if($type == 2)
{
	if($action == 'manage') $action = 'link';
}
elseif($type == 1)
{
	if($action == 'manage') $action = 'block';
}
else
{
	$allow_manage = $priv_role->check('catid', $catid, 'manage');
	$allow_add = $allow_manage ? true : $priv_role->check('catid', $catid, 'add');
	$allow_check = $allow_manage ? true : $priv_role->check('catid', $catid, 'check');
	$allow_view = $allow_manage ? true : $priv_role->check('catid', $catid, 'view');

	$attachment = new attachment($mod, $catid);
	$p = new process($workflowid);
	$PROCESS = cache_read('process_'.$workflowid.'.php');

	$submenu = $allowprocessids = array();
	if($allow_add)
	{
		$submenu[] = array('<font color="red">发布信息</font>', '?mod='.$mod.'&file='.$file.'&action=add&catid='.$catid);
		$submenu[] = array('我发布的信息', '?mod='.$mod.'&file='.$file.'&action=my&catid='.$catid);
	}
	if($allow_check)
	{
		foreach($PROCESS as $pid=>$processname)
		{
			if($priv_role->check('processid', $pid))
			{
				$allow_processids[] = $pid;
				if($pid==1) $add_status = '&status=3';
				$submenu[] = array($processname, '?mod='.$mod.'&file='.$file.'&action=check&catid='.$catid.'&processid='.$pid.$add_status);
			}
		}
	}
	if($allow_manage)
	{
		$submenu[] = array('管理', '?mod='.$mod.'&file='.$file.'&action=manage&catid='.$catid);
		$submenu[] = array('回收站', '?mod='.$mod.'&file='.$file.'&action=recycle&catid='.$catid);
		$submenu[] = array('碎片', '?mod='.$mod.'&file='.$file.'&action=block&catid='.$catid);
	}
	elseif($allow_view)
	{
		$submenu[] = array('浏览', '?mod='.$mod.'&file='.$file.'&action=browse&catid='.$catid);
	}
	$submenu[] = array('搜索', '?mod='.$mod.'&file='.$file.'&action=search&catid='.$catid);
	$menu = admin_menu($CATEGORY[$catid]['catname'].' 栏目管理', $submenu);

	if(!isset($processid) || !in_array($processid, $allow_processids)) $processid = $allow_processids[0];
}

switch($action)
{
    case 'add':
		if(!$priv_role->check('catid', $catid, 'add') && !$allow_manage) showmessage('无发布权限！');

		if($dosubmit)
		{
			$info['status'] = ($status == 2 || $status == 3) ? $status : ($allow_manage ? 99 : 3);
			if(isset($info['inputtime'])) $info['updatetime'] = $info['inputtime'];
			$contentid = $c->add($info,$cat_selected);
			if($contentid) showmessage('发布成功！', '?mod=phpcms&file=content&action=add&catid='.$catid);
		}
		else
		{
			$data['catid'] = $catid;
			$data['template'] = isset($template_show) ? $template_show :$MODEL[$modelid]['template_show'];

			require CACHE_MODEL_PATH.'content_form.class.php';
			$content_form = new content_form($modelid);
			$forminfos = $content_form->get($data);
            require_once 'tree.class.php';
            foreach($CATEGORY as $cid=>$c)
            {
				if($c['module'] != $mod || $c['type'] > 0) continue;
				$checkbox = $c['child'] ? '' : '<input type="checkbox" name="cat_selected[]" value="'.$cid.'">';
				$cats[$cid] = array('id'=>$cid, 'parentid'=>$c['parentid'], 'name'=>$c['catname'], 'checkbox'=>$checkbox);
            }
			$str = "<tr><td style='height:22px;padding:0 0 0 10px;'>\$spacer\$name</td><td>\$checkbox</td></tr>";
			$tree = new tree($cats);
			$categorys = $tree->get_tree(0, $str);
            $pagetitle = $CATEGORY[$catid]['catname'].'-发布';
			header("Cache-control: private");
			include admin_tpl('content_add');
		}
		break;

    case 'edit':

		if($dosubmit)
		{
			$info['status'] = ($status == 2 || $status == 3) ? $status : 99;
			$c->edit($contentid, $info);

			showmessage('修改成功！', $forward);
		}
		else
		{
			require CACHE_MODEL_PATH.'content_form.class.php';
			$content_form = new content_form($modelid);
			$forminfos = $content_form->get($data);

			include admin_tpl('content_edit');
		}
		break;

	case 'view':
		if(!$priv_role->check('catid', $catid, 'view') && !$allow_manage) showmessage('无查看权限！');

		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$coutput = new content_output();
		$info = $coutput->get($data);

		include admin_tpl('content_view');
		break;

	case 'log_list':
		$ACTION = array('add'=>'发布', 'edit'=>'修改', 'delete'=>'删除');
	    $content = $c->get($contentid);
		extract($content);
	    $log->set('contentid', $contentid);
		$data = $log->listinfo($where, $page, 20);
		include admin_tpl('content_log');
	    break;

    case 'my':
		if(!$allow_add) showmessage('无发布权限！');
		$c->set_userid($_userid);
	    $status = isset($status) ? intval($status) : -1;
		$where = "`catid`=$catid ";
	    if($status != -1) $where .= " AND `status`='$status'";
        $infos = $c->listinfo($where, 'listorder DESC,contentid DESC', $page, 20);
		$pagetitle = '我的信息-管理';
		include admin_tpl('content_my');
		break;

    case 'my_contribute':
		$c->set_userid($_userid);
	    $contentid = $c->contentid($contentid, array(0, 1, 2));
		$c->status($contentid, 3);
		showmessage('操作成功！', $forward);
		break;

    case 'my_cancelcontribute':
		$c->set_userid($_userid);
	    $contentid = $c->contentid($contentid, array(3));
		$c->status($contentid, 2);
		showmessage('操作成功！', $forward);
		break;

    case 'my_edit':
		$c->set_userid($_userid);
	    $contentid = $c->contentid($contentid, array(0, 1, 2, 3));

		if($dosubmit)
		{
			$c->edit($contentid, $info);
			showmessage('修改成功！', $forward);
		}
		else
		{
			require CACHE_MODEL_PATH.'content_form.class.php';
			$content_form = new content_form($modelid);
			$forminfos = $content_form->get($data);

			include admin_tpl('content_edit');
		}
		break;

    case 'my_delete':
		$c->set_userid($_userid);
	    $contentid = $c->contentid($contentid, array(0, 1, 2, 3));
		$c->delete($contentid);
		showmessage('操作成功！', $forward);
		break;

	case 'my_view':
		$c->set_userid($_userid);
	    $contentid = $c->contentid($contentid, array(0, 1, 2, 3));

		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$coutput = new content_output();
		$info = $coutput->get($data);

		include admin_tpl('content_view');
		break;

	case 'check':
		$allow_status = $p->get_process_status($processid);
		if(!isset($status) || !in_array($status, $allow_status)) $status = -1;
		$where = "`catid`=$catid ";
		$where .= $status == -1 ? " AND `status` IN(".implode(',', $allow_status).")" : " AND `status`='$status'";
        $infos = $c->listinfo($where, 'listorder DESC,contentid DESC', $page, 20);
		$process = $p->get($processid, 'passname,passstatus,rejectname,rejectstatus');
		extract($process);

        $pagetitle = $CATEGORY[$catid]['catname'].'-审核';
		include admin_tpl('content_check');
		break;
	
	case 'check_title':
		if(CHARSET=='gbk') $c_title = iconv('utf-8', 'gbk', $c_title);
		if($c->get_contentid($c_title))
		{	
			echo '此标题已存在！';
		}
		else
		{
			echo '标题不存在！';
		}
		break;

    case 'browse':
		$where = "`catid`=$catid AND `status`=99";
        $infos = $c->listinfo($where, 'listorder DESC,contentid DESC', $page, 20);
		include admin_tpl('content_browse');
		break;

    case 'search':
		if($dosubmit)
		{
			require CACHE_MODEL_PATH.'content_search.class.php';
			$content_search = new content_search();
			$infos = $content_search->data($page, 20);
			include admin_tpl('content_search_list');
		}
		else
		{
			require CACHE_MODEL_PATH.'content_search_form.class.php';
			$content_search_form = new content_search_form();
			$forminfos = $content_search_form->get_where();
			$orderfields = $content_search_form->get_order();

            $pagetitle = $CATEGORY[$catid]['catname'].'-搜索';
			include admin_tpl('content_search');
		}
		break;

    case 'recycle':
		if(!$allow_manage) showmessage('无管理权限！');
        $infos = $c->listinfo("catid=$catid AND status=0", 'listorder DESC,contentid DESC', $page, 20);

        $pagetitle = $CATEGORY[$catid]['catname'].'-回收站';
		include admin_tpl('content_recycle');
		break;

    case 'pass':
		if(!$priv_role->check('catid', $catid, 'check') && !$allow_manage) showmessage('无审核权限！');
		$allow_status = $p->get_process_status($processid);
		if($contentid=='') showmessage('请选择要批准的内容');
	    $contentid = $c->contentid($contentid, 0, $allow_status);
		$process = $p->get($processid, 'passstatus');
		$c->status($contentid, $process['passstatus']);
		showmessage('操作成功！', $forward);
		break;

    case 'reject':
		if(!$priv_role->check('catid', $catid, 'check') && !$allow_manage) showmessage('无审核权限！');
		$allow_status = $p->get_process_status($processid);
		if($contentid=='') showmessage('请选择要批准的内容');
	    $contentid = $c->contentid($contentid, 0, $allow_status);
		$process = $p->get($processid, 'rejectstatus');
		$c->status($contentid, $process['rejectstatus']);
		showmessage('操作成功！', $forward);
		break;

	case 'cancel':
		if(!$allow_manage) showmessage('无管理权限！');
		$c->status($contentid, 0);
		showmessage('操作成功！', $forward);
		break;

    case 'delete':
		if(!$allow_manage) showmessage('无管理权限！');
		$c->delete($contentid);
		showmessage('操作成功！', $forward);
		break;

    case 'clear':
		if(!$allow_manage) showmessage('无管理权限！');
		$c->clear();
		showmessage('操作成功！', $forward);
		break;

    case 'restore':
		if(!$allow_manage) showmessage('无管理权限！');
		$c->restore($contentid);
		showmessage('操作成功！', $forward);
		break;

    case 'restoreall':
		if(!$allow_manage) showmessage('无管理权限！');
		$c->restoreall();
		showmessage('操作成功！', $forward);
		break;

    case 'listorder':
		$result = $c->listorder($listorders);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;

	case 'link':
		if($dosubmit)
		{
			require_once 'admin/category.class.php';
			$cat = new category($mod);
			$cat->link($catid, $category);

			showmessage('操作成功！', $forward);
		}
		else
		{
			include admin_tpl('content_link');
        }
		break;

	case 'block':
		if($type == 0)
		{
			$page = max(intval($page), 1);
			if($tpl == 'category')
			{
				if($child == 1)
				{
					$arrchildid = subcat('phpcms', $catid);
					$template = $template_category;
				}
				else
				{
					$template = $template_list;
				}
			}
			elseif($tpl == 'show')
			{
				$template = $MODEL[$modelid]['template_show'];
			}
			else
			{
				$template = $template_list;
			}
		}
		elseif($type == 2)
		{
			header('location:'.$url);
		}

		$catlist = submodelcat($modelid);
		$arrparentid = explode(',', $arrparentid);
		$parentid = $arrparentid[1];

		$head['title'] = $catname;
		$head['keywords'] = $meta_keywords;
		$head['description'] = $meta_description;
		include admin_template('phpcms', $template);
        include admin_tpl('block_ajax', 'phpcms');
		break;

	case 'category':
		$catid = intval($catid);
		if(!isset($CATEGORY[$catid])) showmessage('访问的栏目不存在！');
		$C = cache_read('category_'.$catid.'.php');
		extract($C);
		if($type == 1)
		{
			$template = $C['template'];
		}
		elseif($type == 2)
		{
			header('location:'.$url);
		}
		else
		{
			$page = max(intval($page), 0);
			if($page == 0)
			{
				$template = $C['template_category'];
				$categorys = $child ? subcat('phpcms', $catid, 0) : array();
			}
			else
			{
				$template = $C['template_list'];
			}
		}
		$head['title'] = $catname;
		$head['keywords'] = $meta_keywords;
		$head['description'] = $meta_description;

		define('BLOCK_EDIT', 1);
		include template('phpcms', $template);
		break;

	case 'posid':
		if(!$posid) showmessage('不存在此推荐位！');
		if(!$contentid) showmessage('没有被推荐的信息！');
		if(!$priv_role->check('posid', $posid)) showmessage('您没有此推荐位的权限！');
		foreach($contentid as $cid)
		{
			if($c->get_posid($cid, $posid)) continue;
			$c->add_posid($cid, $posid);
		}
		showmessage('批量推荐成功！', '?mod='.$mod.'&file='.$file.'&action=manage&catid='.$catid);
		break;

	case 'typeid':
		if(!$typeid) showmessage('不存在此类别！');
		if(!$contentid) showmessage('没有信息被选中！');
		foreach($contentid as $cid)
		{
			$c->add_typeid($cid, $typeid);
		}
		showmessage('批量加入类别到成功！', '?mod='.$mod.'&file='.$file.'&action=manage&catid='.$catid);
		break;

	default:
		require_once 'admin/model_field.class.php';
        $model_field = new model_field($modelid);
		
	    $where = "`catid`=$catid AND `status`=99 ";
	    if($typeid) $where .= " AND `typeid`='$typeid' ";
	    if($areaid) $where .= " AND `areaid`='$areaid' ";
	    if($inputdate_start) $where .= " AND `inputtime`>='".strtotime($inputdate_start.' 00:00:00')."'"; else $inputdate_start = date('Y-m-01');
	    if($inputdate_end) $where .= " AND `inputtime`<='".strtotime($inputdate_end.' 23:59:59')."'"; else $inputdate_end = date('Y-m-d');
		if($q)
	    {
			if($field == 'title')
			{
				$where .= " AND `title` LIKE '%$q%'";
			}
			elseif($field == 'userid')
			{
				$userid = intval($q);
				if($userid)	$where .= " AND `userid`=$userid";
			}
			elseif($field == 'username')
			{
				$userid = userid($q);
				if($userid)	$where .= " AND `userid`=$userid";
			}
			elseif($field == 'contentid')
			{
				$contentid = intval($q);
				if($contentid) $where .= " AND `contentid`=$contentid";
			}
		}
        $infos = $c->listinfo($where, '`listorder` DESC,`contentid` DESC', $page, 20);

        $pagetitle = $CATEGORY[$catid]['catname'].'-管理';
		foreach($POS AS $key => $p)
		{
			if($priv_role->check('posid', $key))
			{
				$POSID[$key] = $p;
			}
		}
		$POS = $POSID;
		$POS[0] = '不限推荐位';

		include admin_tpl('content_manage');
}
?>