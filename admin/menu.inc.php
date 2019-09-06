<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'menu.inc.php';
require_once 'menu.class.php';
$m = new menu();

if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=manage';

switch($action)
{
    case 'add':
		if($dosubmit)
		{
		    $info['roleids'] = implode(',', $roleids);
		    $info['groupids'] = implode(',', $groupids);
			$menuid = $m->add($info);
			if($menuid)
			{
				$priv_role->update('menuid', $menuid, $roleids);
				$priv_group->update('menuid', $menuid, $groupids);
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			if(!isset($parentid)) $parentid = 0;
			if(!isset($target)) $target = 'right';
			include admin_tpl('menu_add');
		}
		break;

    case 'edit':
		if($dosubmit)
		{
		    $info['roleids'] = implode(',', $roleids);
		    $info['groupids'] = implode(',', $groupids);
			$result = $m->edit($menuid, $info);
			if($result)
			{
				$priv_role->update('menuid', $menuid, $roleids);
				$priv_group->update('menuid', $menuid, $groupids);
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			$info = $m->get($menuid);
			if(!$info) showmessage('指定的推荐位不存在！');
			extract($info);
			if($parentid)
			{
				$parent = $m->get($parentid);
				$parentname = $parent['name'];
			}
			else
			{
				$parentname = '无';
			}
			$roleids = $priv_role->get_roleid('menuid', $menuid);
			$groupids = $priv_group->get_groupid('menuid', $menuid);
			$roleids = implode(',', $roleids);
			$groupids = implode(',', $groupids);
			include admin_tpl('menu_edit');
		}
		break;

    case 'manage':
		if(!isset($parentid)) $parentid = 0;
	    if($parentid)
	    {
			$r = $m->get($parentid);
			$parentname = $r['name'];
		}
	    $forward = URL;
	    $where = "`parentid` = '$parentid'";
        $infos = $m->listinfo($where, 'listorder, menuid', $page, 20);
		include admin_tpl('menu_manage');
		break;

    case 'delete':
		$result = $m->delete($menuid);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;

    case 'listorder':
		$result = $m->listorder($listorder);
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
		$result = $m->disable($menuid, $disabled);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;

	case 'getchild':
		$array = array();
        $infos = $m->listinfo("parentid='$parentid'", 'listorder, menuid', $page, 20);
	    foreach($infos as $k=>$v)
	    {
			$array[$v['menuid']] = $v['name'];
	    }
		if(!$parentid || $array)
	    {
			$array[0] = $parentid ? '请选择' : '无';
			ksort($array);
			echo form::select($array, 'setparentid', 'setparentid', $parentid, 1, '', 'onchange="if(this.value>0){getchild(this.value);myform.parentid.value=this.value;this.disabled=true;}"');
		}
		break;

    case 'add_mymenu':
		if(!isset($target) || empty($target)) $target = 'right';
		if(CHARSET != 'utf-8') $name = iconv('utf-8', DB_CHARSET, $name);
		$info = array('parentid'=>'99', 'name'=>$name, 'url'=>urldecode($url), 'target'=>$target);
		echo $m->add($info) ? 1 : 0;
		break;

	case 'get_menu_list':
		$data = $m->get_child($menuid);
		$data = str_charset(CHARSET, 'utf-8', $data);
		$max = array_slice($data, -1);
		$data['max'] = $max[0]['menuid'];
		$data = json_encode($data);
		header('Content-type: text/html; charset=utf-8');
		echo $data;
	break;

	case 'menu_pos':
		$data = $m->get_parent($menuid);
		krsort($data);
		$html = '';
		$i=0;
		foreach($data as $val)
		{
			$target = '';
			if($val['isfolder'])
			{
				$href = "javascript:get_menu('".$val['menuid']."','tree_".$val['menuid']."',$i)";
			}
			else
			{
				$href = $val['url'];
				$target = " target='".$val['target']."'";
			}
			$html .= "<a href=\"$href\" $target>".$val['name']."</a>";
			$i++;
		}
		echo '<strong>当前位置：</strong>'.$html;
	break;

	case 'ajax_menu':
		if(CHARSET != 'utf-8') $menuname = iconv('utf-8', DB_CHARSET, $menuname);
		$data = $m->listinfo("`name` like '%$menuname%'");
	    foreach ($data as $key=>$val)
		{
			if($val['name'] && $val['url'] && $val['isfolder']!=1)
			{
				$d[$key]['name'] = iconv(CHARSET, 'utf-8',$val['name']);
				$d[$key]['url'] = iconv(CHARSET, 'utf-8',$val['url']);
			}
		}
		$data = json_encode($d);
		header('Content-type: text/html; charset=utf-8');
		echo $data;
	break;
}
?>