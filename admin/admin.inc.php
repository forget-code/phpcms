<?php
defined('IN_PHPCMS') or exit('Access Denied');

require PHPCMS_ROOT.'/include/tree.class.php';
$tree= new tree;

function get_sql($field, $ids, $newids)
{
	$newids = implode(',', $newids);
	if($ids)
	{
		$newids = explode(',', $ids.$newids);
		$newids = array_filter(array_unique($newids));
		$newids = ','.implode(',', $newids).',';
	}
	else
	{
		$newids = ','.$newids.',';
	}
	return ",$field='$newids'";
}

$action = $action ? $action : 'manage';

$submenu = array
(
	array($LANG['administrator_list'], '?mod='.$mod.'&file='.$file.'&action=manage'),
	array($LANG['add_admin'], '?mod='.$mod.'&file='.$file.'&action=add')
);

$menu = adminmenu($LANG['admin_option'], $submenu);

switch($action)
{
	case 'add':

		if($dosubmit)
	    {
		    if($grade > 0)
			{
				$purview_module = ($grade == 1 && is_array($module)) ? ','.implode(',',$module).',' : '';
				$purview_channel = is_array($channel) ? ','.implode(',',$channel).',' : '';
			}
			else
			{
                $purview_module = '';
                $purview_channel = '';
			}
			$catids = $grade > 2 ? $catids : '';
			$r = $db->get_one("SELECT userid,username,groupid FROM ".TABLE_MEMBER." WHERE username='$username'");
			if(!$r) showmessage($LANG['username']." $username ".$LANG['not_exist']);
			if($r['groupid'] == 1) showmessage("$username ".$LANG['you_are_administrator']);
            $userid = $r['userid'];
            $username = $r['username'];
		    $db->query("INSERT INTO ".TABLE_ADMIN."(userid,username,grade,modules,channelids,catids) VALUES('$userid','$username','$grade','$purview_module','$purview_channel','$catids')");
			$db->query("UPDATE ".TABLE_MEMBER." SET groupid=1 WHERE userid=$userid");
			showmessage($LANG['add_admin_success'],'?mod='.$mod.'&file='.$file.'&action=manage');
		}
		else
	    {
			if(!isset($username)) $username = '';
			include admintpl('admin_add');
		}
		break;

	case 'edit':
		if($dosubmit)
	    {
		    if($grade > 0)
			{
				$purview_module = ($grade == 1 && is_array($module)) ? ','.implode(',', $module).',' : '';
				$purview_channel = is_array($channel) ? ','.implode(',', $channel).',' : '';
			}
			else
			{
                $purview_module = '';
                $purview_channel = '';
			}
			$catids = $grade > 2 ? $catids : '';
		    $db->query("UPDATE ".TABLE_ADMIN." SET grade='$grade',modules='$purview_module',channelids='$purview_channel',catids='$catids' WHERE userid=$userid");
			showmessage($LANG['edit_authority_success'], '?mod='.$mod.'&file='.$file.'&action=manage');
		}
		else
	    {
			$r = $db->get_one("SELECT m.username,a.* FROM ".TABLE_MEMBER." m,".TABLE_ADMIN." a WHERE m.userid=a.userid AND a.userid=$userid");
			@extract($r);
			$modules = explode(',', $modules);
			$channels = explode(',', $channelids);
			include admintpl('admin_edit');
		}
		break;

	case 'view':

		if(!isset($userid)) $userid = $_userid;
		$r = $db->get_one("SELECT m.username,a.* FROM ".TABLE_MEMBER." m,".TABLE_ADMIN." a WHERE m.userid=a.userid AND a.userid=$userid");
		@extract($r);

		$modules = explode(',', $modules);
		$channels = explode(',', $channelids);

		include admintpl('admin_view');
		break;

	case 'purview_category':
		$tree = new tree;
		$purview = isset($catids) ? array_filter(explode(',', $catids)) : array();
		$categorys = array();
		$result = $db->query("select * from ".TABLE_CATEGORY." where channelid=$channelid and islink=0 order by listorder");
		while($r = $db->fetch_array($result))
		{
			$checked = in_array($r['catid'], $purview) ? 'checked' : '';
			$categorys[$r['catid']] = array('id'=>$r['catid'],'parentid'=>$r['parentid'],'name'=>$r['catname'],'checked'=>$checked);
		}
		$str = "<tr onmouseout=this.style.backgroundColor='#F1F3F5' onmouseover=this.style.backgroundColor='#BFDFFF' bgColor='#F1F3F5'>
			<td align='center'><input name='catid' type='checkbox' id='catid' value='\$id' \$checked></td>
			<td>\$spacer\$name</td>
			</tr>";
		$tree->tree($categorys);
		$categorys = $tree->get_tree(0,$str);
		include admintpl('admin_purview_category');
		break;

	case 'manage':

		$admins = array();
		$result = $db->query("SELECT * FROM ".TABLE_ADMIN." WHERE disabled=0 ORDER BY grade");
		while($r = $db->fetch_array($result))
		{
			$userid = $r['userid'];
			$u = $db->get_one("SELECT m.username,m.lastloginip,m.lastlogintime,m.logintimes,i.truename FROM ".TABLE_MEMBER." m ,".TABLE_MEMBER_INFO." i WHERE m.userid=i.userid AND m.userid=$userid");
			if($u['lastlogintime']) $u['lastlogintime'] = date('Y-m-d H:i:s', $u['lastlogintime']);
			$admins[] = array_merge($r, $u);
		}
		$db->free_result($result);

		include admintpl('admin');
		break;

	case 'delete':
		$db->query("DELETE FROM ".TABLE_ADMIN." WHERE userid=$userid");
		$db->query("UPDATE ".TABLE_MEMBER." SET groupid=5 WHERE userid=$userid");
		showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file.'&action=manage');
		break;
}
?>