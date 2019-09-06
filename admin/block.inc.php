<?php 
require_once 'block.class.php';

$block = new block();

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$blockid = $block->add($info, $roleids);
			if($blockid)
			{
				header('location:?mod='.$mod.'&file='.$file.'&action=update&ajax='.$ajax.'&func=add_block&blockid='.$blockid.'&forward='.urlencode($forward));
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			$listorder = $block->get_max_listorder($pageid, $blockno);
			$tpl = $ajax ? 'block_add_ajax' : 'block_add';
			include admin_tpl($tpl);
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $block->edit($blockid, $info, $roleids);
			if($result)
			{
				header('location:'.$forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			$info = $block->get($blockid);
			if(!$info) showmessage('指定的碎片不存在！');
			@extract($info);
			$roleids = implode(',', $priv_role->get_roleid('blockid', $blockid));
			include admin_tpl('block_edit');
		}
		break;

    case 'update':
		if(!$priv_role->check('blockid', $blockid)) showmessage('您没有此碎片的修改权限！');

		$r = $block->get($blockid);
		if(!$r) showmessage('指定的碎片不存在！');

		if($dosubmit)
		{
			if($ajax)
			{
				if(CHARSET != 'utf8')
				{
					$data = iconv('utf-8', CHARSET, $data);
					if($template) $template = iconv('utf-8', CHARSET, $template);
				}
				if($template) $block->set_template($blockid, $template);
				$result = $block->update($blockid, $data);
				echo $result ? '1' : '0';
			}
			else
			{
				if(is_array($data)) $block->set_template($blockid, $template);
				$result = $block->update($blockid, $data);
				if($result)
				{
					showmessage('操作成功！', $forward);
				}
				else
				{
					showmessage('操作失败！');
				}
			}
		}
		else
		{
			extract($r);
			$template = $block->get_template($blockid);
			$logs = $block->logs($blockid);
			$actions = array('add'=>'添加', 'edit'=>'修改', 'update'=>'更新','delete'=>'删除','post'=>'更新');
            if(!str_exists($forward, '?')) $forward = URL;
			$tpl = $ajax ? 'block_update_ajax' : 'block_update';
			include admin_tpl($tpl);
		}
		break;

	case 'restore':
		echo $block->restore($logid);
		break;

    case 'delete':
		$result = $block->delete($blockid);
		if($result)
		{
			showmessage('操作成功！', '?mod=phpcms&file=block&action=manage');
		}
		else
		{
			showmessage('操作失败！');
		}
		break;

    case 'listorder':
		$result = $block->listorder($info);
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
		$result = $block->disable($blockid, $disabled);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;

	case 'refresh':
        @set_time_limit(600);
	    $block->refresh();
		showmessage('操作成功！', $forward);
		break;

	case 'post':
		require_once 'template.func.php';
        if($func == 'dosave')
	    {
			$block->set_template($blockid, $template);
			$block->update($blockid, $data);
			$data = $block->get_html($blockid);
		}
		else
	    {
			$name = new_stripslashes($name);
			$data = new_stripslashes($data);
			$data = $block->strip_data($data);
			$template = new_stripslashes($template);
			$tpldata = template_parse($template);
			$tplfile = TPL_CACHEPATH.'block_'.$blockid.'.preview.php';
			file_put_contents($tplfile, $tpldata);
			include $tplfile;
			@unlink($tplfile);
			$data = ob_get_contents();
			ob_clean();
		}
		echo '<script language="JavaScript">parent.'.$func.'('.$blockid.', "'.format_js($data, 0).'");</script>';
		break;

	case 'index':
		include admin_template('phpcms', 'index');
        include admin_tpl('block_ajax', 'phpcms');
		break;

	case 'get_template_example':
		if($example)
	    {
		    echo htmlspecialchars($block->get_template_example($example));
		}
		else
		{
			$data = $block->get_template_example();
			echo form::select($data, 'example', 'example', '', '1', '', 'style="width:100px;" onchange="$(\'#template\').load(\'?mod=phpcms&file=block&action=get_template_example&example=\'+this.value)"');
		}
		break;

	case 'block_search':
		if(CHARSET != 'utf-8')
		{
			$keyword = iconv('utf-8', DB_CHARSET, $keyword);
		}
		$where = '';
	    if(isset($keyword) && !empty($keyword)) $where .= " AND (title LIKE '%$keyword%' OR keywords LIKE '%$keyword%' OR description LIKE '%$keyword%') ";
        if(isset($catid) && !empty($catid)) $where .= get_sql_catid($catid);
        if(isset($starttime) && !empty($starttime)) $where .= " AND inputtime>='".strtotime($starttime.' 00:00:00')."' ";
        if(isset($stoptime) && !empty($stoptime)) $where .= " AND inputtime<='".strtotime($stoptime.' 23:59:59')."' ";
		$rows = max(intval($rows), 1);
		$data = array();
		$result = $db->query("SELECT `title`,`url`,`thumb`,`inputtime`,`description` FROM `".DB_PRE."content` WHERE status=99 $where ORDER BY updatetime DESC LIMIT $rows");
		while($r = $db->fetch_array($result))
		{
			$r['title'] = str_cut($r['title'], 40);
			$r['inputtime'] = date('Y-m-d', $r['inputtime']);
			$data[] = $r;
		}
		$db->free_result($result);
		if(strtolower(CHARSET) != 'utf-8') $data = str_charset(CHARSET, 'utf-8', $data);
		echo json_encode($data);
	break;

    case 'list':
        require_once 'tree.class.php';
        $tree = new tree;
		foreach($CATEGORY as $catid=>$c)
		{
			if($c['type'] == 2 || $c['module'] != 'phpcms') continue;
			if($c['type'])
			{
				$type = '单网页';
				$show = "<font color='#cccccc'>内容页</font>";
			}
			else
			{
				$type = $MODEL[$c['modelid']]['name'];
				$show = "<a href='?mod=phpcms&file=content&action=block&catid=$catid&tpl=show'>内容页</a>";
			}
			$categorys[$catid] = array('id'=>$catid, 'parentid'=>$c['parentid'], 'name'=>$c['catname'], 'type'=>$type, 'url'=>$c['url'], 'mod'=>$mod, 'show'=>$show);
		}
		$str = "<tr>
					<td class='align_c'>\$id</td>
					<td>\$spacer<a href='\$url'><span class='\$style'>\$name</span></a></td>
					<td class='align_c'>\$type</td>
					<td class='align_c'><a href='?mod=\$mod&file=content&action=block&catid=\$id&tpl=category'>栏目页</a> | \$show</td>
				</tr>";
		$tree->tree($categorys);
		$categorys = $tree->get_tree(0, $str);

		include admin_tpl('block_list');
	break;

    default :
        $data = $block->listinfo('', $page, 20);
		include admin_tpl('block_manage');
}
?>