<?php
defined('IN_YP') or exit('Access Denied');
if(!isset($action)) $action = 'manage';

switch($action)
{
	case 'manage':
		if(in_array($_groupid,$M['allow_add_map']))
		{
			$map = $company_user_infos['map'];
			if($map != '')
			{
				$maps = explode('|',$map);
				$x = $maps[0];
				$y = $maps[1];
				$z = $maps[2];
			}
		}
		else showmessage('您所在的用户组不能修改地图标注数据，请和管理员联系','goback');
		
	break;

	case 'update':
			$map = $x.'|'.$y.'|'.$z;
			$db->query("UPDATE `".DB_PRE."member_company` SET map='$map' WHERE userid='$_userid'");
			exit('1');
		break;

}
include template('yp', 'center_map');
?>