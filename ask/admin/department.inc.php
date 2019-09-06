<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$submenu = array(
	  array($LANG['add_department'], '?mod='.$mod.'&file='.$file.'&action=add'),
	  array($LANG['department_manage'], '?mod='.$mod.'&file='.$file.'&action=manage'),
);
$menu = adminmenu($LANG['department_manage'], $submenu);

switch($action)
{
    case 'add':
		if($dosubmit)
		{
			if(empty($department)) showmessage($LANG['department_name_not_null']);
			$arrgroupid = isset($arrgroupid) ? implode(',', $arrgroupid) : '';
			$db->query("INSERT INTO ".TABLE_ASK_DEPARTMENT."(department,note,arrgroupid,point,admin) VALUES('$department','$note','$arrgroupid','$point','$admin')");
			cache_department();
			showmessage($LANG['operation_success'], $forward);
        }
		else
	    {
			$showgroup = showgroup('checkbox','arrgroupid[]');
			$forward = urlencode($PHP_REFERER);
			include admintpl('department_add');
		}
    break;

    case 'edit':
		if($dosubmit)
		{
			if(empty($department)) showmessage($LANG['department_name_not_null']);
			$arrgroupid = isset($arrgroupid) ? implode(',', $arrgroupid) : '';
			$db->query("UPDATE ".TABLE_ASK_DEPARTMENT." SET department='$department',note='$note',arrgroupid='$arrgroupid',point='$point',admin='$admin' WHERE departmentid=$departmentid");
			cache_department();
			showmessage($LANG['operation_success'], $forward);
        }
		else
	    {
			$departmentid = intval($departmentid);
			$r = $db->get_one("SELECT * FROM ".TABLE_ASK_DEPARTMENT." WHERE departmentid=$departmentid");

			@extract($r);

			$showgroup = showgroup('checkbox','arrgroupid[]',$arrgroupid);
			$forward = urlencode($PHP_REFERER);

			include admintpl('department_edit');
		}
    break;

    default :
		if($dosubmit)
		{
			if(isset($department) && is_array($department))
			{
				foreach($department as $id=>$v)
				{
					if(isset($delete[$id]))
					{
						$db->query("delete from ".TABLE_ASK_DEPARTMENT." where departmentid='$id'");
						$db->query("delete from ".TABLE_ASK." where departmentid='$id'");
					}
					else
					{
						$db->query("update ".TABLE_ASK_DEPARTMENT." set department='$v',point='$point[$id]',listorder='$listorder[$id]' where departmentid='$id'");
					}
				}
			}

			cache_department();
			showmessage($LANG['operation_success'],$PHP_REFERER);
		}
		else
		{
			$result = $db->query("select * from ".TABLE_ASK_DEPARTMENT." where 1");
			while($r = $db->fetch_array($result))
			{
				$r['arrgroupname'] = get_arrgroupname($r['arrgroupid']);
				$departments[$r['departmentid']] = $r;
			}

			include admintpl('department');
		}
}
?>