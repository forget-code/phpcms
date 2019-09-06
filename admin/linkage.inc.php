<?php 
defined('IN_PHPCMS') or exit('Access Denied');
error_reporting(7);
require_once 'linkage.class.php';
$linkage = new linkage();

if(!$action) $action = 'manage';
if(!$forward) $forward = '?mod='.$mod.'&file='.$file.'&action=mange';


$submenu[] = array('管理联动菜单首页', '?mod='.$mod.'&file='.$file.'&action=manage');
$menu = admin_menu(' 联动菜单管理', $submenu);

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			$result = $linkage->add($info);
			if($result)
			{
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			header("Location: ?mod=phpcms&file=linkage&action=manage");
		}
		break;
		//添加子菜单
	 case 'addsub':
		if($dosubmit)
		{
			$result = $linkage->add($info);
			if($result)
			{
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			header("Location: ?mod=phpcms&file=linkage&action=manage");
		}
		break;
    case 'edit':
		if($dosubmit)
		{
			$result = $linkage->edit($linkageid, $info);

			if($result)
			{
				showmessage('操作成功！', $forward);
			}
			else
			{
				showmessage('操作失败！');
			}
		}
		else
		{
			$info = $linkage->get($linkageid);
			if(!$info) showmessage('联动菜单管理不存在！');
			include admin_tpl('linkage_edit');
		}
		break;
    case 'manage':
        $infos = $linkage->listinfo();
		include admin_tpl('linkage_manage');
		break;
    case 'manage_submenu':
		$r = $linkage->get($keyid,'name');
		$keyname = $r['name'];
		$linkageid = intval($linkageid);
		$keyid = intval($keyid);
		require_once 'tree.class.php';
		$tree = new tree;

        $infos = $linkage->submenulist($keyid);
		$areas = array();
				foreach($infos as $areaid => $area)
				{
					$areas[$area['linkageid']] = array('id'=>$area['linkageid'],'parentid'=>$area['parentid'],'name'=>$area['name'],'listorder'=>$area['listorder'],'style'=>$area['style'],'mod'=>$mod,'file'=>$file,'keyid'=>$keyid,'description'=>$area['description']);
				}
				
				$str = "<tr>
							<td style='text-align:center'><input name='listorder[\$id]' type='text' size='3' value='\$listorder'></td>
							<td style='text-align:center'>\$id</td>
							<td align='left'>\$spacer<span class='\$style'>\$name</span></td>
							<td align='left'>\$description</td>
							<td style='text-align:center'><a href='?mod=phpcms&file=linkage&action=manage_submenu&keyid=\$keyid&linkageid=\$id#addsubmunu'>添加子菜单</a> | <a href='?mod=\$mod&file=\$file&action=edit&linkageid=\$id&parentid=\$parentid&keyid=\$keyid'>".$LANG['edit']."</a> | <a href=javascript:confirmurl('?mod=\$mod&file=\$file&action=delete&linkageid=\$id&keyid=\$keyid','确认要删除该菜单吗？')>".$LANG['delete']."</a></td></tr>";
				$tree->tree($areas);
				$infos = $tree->get_tree(0,$str);
		include admin_tpl('submenulist_manage');
		break;
		
    case 'delete':
		$keyid = intval($keyid);
		$linkageid = intval($linkageid);
		$result = $linkage->delete($linkageid,$keyid);
		if($result)
		{
			$forward = $keyid ? '?mod=phpcms&file=linkage&action=manage_submenu&keyid='.$keyid : '?mod=phpcms&file=linkage&action=manage';
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
    case 'listorder':
		$result = $linkage->listorder($listorder);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;
	case 'select_id':
		$infos = $linkage->listinfo();
		include admin_tpl('linkage_select_id');
		break;
}
?>