<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'tree.class.php';
require_once 'admin/area.class.php';

$areaid = isset($areaid) ? intval($areaid) : 0;

$tree = new tree;
$are = new area();
if(!isset($forward)) $forward = '?mod=phpcms&file=area&action=manage';

$action = $action ? $action : 'manage';

switch($action)
{
	case 'add':

		if($dosubmit)
		{
		    if(!$info['name']) showmessage($LANG['area_name_not_null']);
			$names = explode("\n", trim($info['name']));
			foreach($names as $name)
			{
				$name = trim($name);
				if(!$name) continue;
				$info['name'] = $name;
				$are->add($info);
			}
	        showmessage($LANG['operation_success'], $forward);
		}
		else
	    {
		    include admin_tpl('area_add');
		}
		break;

	case 'edit':
		$areaid = intval($areaid);
		if(!$areaid) showmessage($LANG['illegal_parameters']);
		if($areaid == $info['parentid']) showmessage('当前地区不能与上级地区相同');
		if($dosubmit)
		{
		    if(!$info['name']) showmessage($LANG['area_name_not_null']);

            $are->edit($areaid, $info);
			showmessage($LANG['operation_success'], $forward);
		}
		else
	    {
			$area = $are->get($areaid);
            @extract(new_htmlspecialchars($area));
		    include admin_tpl('area_edit');
		}
		break;

     case 'repair':
        $are->repair();
        showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=manage");
		break;

     case 'delete':
		 $areaid = intval($areaid);
         $are->delete($areaid);
		 showmessage($LANG['operation_success'], $forward);
		 break;

    case 'listorder':
		$are->listorder($listorder);
		showmessage($LANG['operation_success'], $forward);
        break;

	case 'updatecache':
		cache_area();
		showmessage($LANG['area_cache_update_success'], "?mod=$mod&file=$file&action=manage");
		break;

	case 'manage':

		$list = $are->listinfo();

		if(is_array($list))
	    {
			$areas = array();
			foreach($list as $areaid => $area)
			{
				$areas[$area['areaid']] = array('id'=>$area['areaid'],'parentid'=>$area['parentid'],'name'=>$area['name'],'listorder'=>$area['listorder'],'style'=>$area['style'],'mod'=>$mod,'file'=>$file,'keyid'=>$keyid);
			}
			
			$str = "<tr>
						<td style='text-align:center'><input name='listorder[\$id]' type='text' size='3' value='\$listorder'></td>
						<td style='text-align:center'>\$id</td>
						<td align='left'>\$spacer<span class='\$style'>\$name</span></td>
						<td style='text-align:center'><a href='?mod=\$mod&file=\$file&action=add&areaid=\$id&keyid=\$keyid'>".$LANG['add_child_area']."</a> | <a href='?mod=\$mod&file=\$file&action=edit&areaid=\$id&parentid=\$parentid&keyid=\$keyid'>".$LANG['edit']."</a> | <a href=javascript:confirmurl('?mod=\$mod&file=\$file&action=delete&areaid=\$id&keyid=\$keyid','".$LANG['confirm_delete_area']."')>".$LANG['delete']."</a></td></tr>";
			$tree->tree($areas);
			$areas = $tree->get_tree(0,$str);
		}
		include admin_tpl('area');
		break;
}
?>