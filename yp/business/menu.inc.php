<?php
defined('IN_YP') or exit('Access Denied');
if(!isset($action)) $action = 'manage';

switch($action)
{
	case 'manage':
		//首页 公司介绍 产品展示  商机 人才招聘 在线留言 联系方式 
		if($dosubmit)
		{
			if($newcatname)
			{
				$number = count($usermenu['catname']);
				$usermenu['catname'][] = $newcatname;
				$usermenu['linkurl'][] = $linkurl;
				$usermenu['use'][$number] = 1;
			}
			
			$arraymenu['system'] = $system;
			foreach($usermenu['linkurl'] AS $_key=>$_value)
			{
				if(trim($_value))
				{
					$usermenu_temp['linkurl'][] = $_value;
					$usermenu_temp['catname'][] = $usermenu['catname'][$_key];
				}
			}
			$arraymenu['usermenu'] = $usermenu_temp;
			$menustring = array2string($arraymenu);
			$db->query("UPDATE `".DB_PRE."member_company` SET `menu`='$menustring' WHERE `userid`='$_userid'");
			showmessage('菜单更新成功','?file=menu');
		}
		else
		{
			if(empty($company_user_infos['menu']))
			{
				$arraymenu = cache_read('menu.inc.php',MOD_ROOT.'include/');
			}
			else
			{
				$arraymenu = string2array($company_user_infos['menu']);
			}
			$system = $arraymenu['system'];
			$usermenu = $arraymenu['usermenu'];
			
			foreach($system['catname'] AS $k=>$v)
			{
				$checked = '';
				if($system['use'][$k]) $checked = 'checked';
				$strings .= '
					<tr>
					<td class="align_c"><input type="checkbox" value="1" name="system[use]['.$k.']" '.$checked.'> </td>
					<td class="align_c"><input name="system[catname]['.$k.']" type="text" size="15" maxlength="20" require="true" datatype="limit" min="1" max="50"  msg="字符长度范围必须为1到50位"  mode="1" value="'.$system['catname'][$k].'"></td>
					<td class="align_c"></td>
				</tr>';
			}
			foreach($usermenu['catname'] AS $k=>$v)
			{
				$checked = '';
				if($usermenu['use'][$k]) $checked = 'checked';
				$strings .= '
					<tr>
					<td class="align_c"><input type="checkbox" value="1" name="usermenu[use]['.$k.']" '.$checked.'> </td>
					<td class="align_c"><input name="usermenu[catname]['.$k.']" type="text" size="15" maxlength="20" value="'.$usermenu['catname'][$k].'"></td>
					<td class="align_c"><input name="usermenu[linkurl]['.$k.']" type="text" size="55" maxlength="20" value="'.$usermenu['linkurl'][$k].'"></td>
				</tr>';
			}
			//$number = count($usermenu['catname']);
		}
	break;

	case 'update':
			
		break;

}
include template('yp', 'center_menu');
?>