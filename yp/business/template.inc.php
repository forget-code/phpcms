<?php
defined('IN_YP') or exit('Access Denied');
if(!isset($action)) $action = 'manage';
$companytpl_config = include PHPCMS_ROOT.'templates/'.TPL_NAME.'/yp/companytplnames.php';
foreach($companytpl_config AS $_k=>$_v)
{
	$_array_group = explode(',',$_v['groupid']);
	if(!in_array($_groupid,$_array_group)) unset($companytpl_config[$_k]);
}
switch($action)
{
	case 'manage':
		$diy = $company_user_infos['diy'];
		$tplname = $company_user_infos['tplname'];

		include template('yp', 'center_template');
	break;

	case 'preview':
		extract($company_user_infos);
		if(empty($menu))
		{
			$menu = cache_read('menu.inc.php',MOD_ROOT.'include/');
		}
		else
		{
			$menu = string2array($menu);
		}
		$system_name = array();
		foreach($menu['system']['catname'] AS $_k=>$_v)
		{
			if($menu['system']['use'][$_k])
			{
				$m_system[$_k]['catname'] = $_v;
				$m_system[$_k]['url'] = $m_s_url[$_k];
			}
			$system_name[$system_action[$_k]] = $_v;
		}
		foreach($menu['usermenu']['catname'] AS $_k=>$_v)
		{
			if($menu['usermenu']['use'][$_k])
			{
				$m_user[$_k]['catname'] = $_v;
				$m_user[$_k]['url'] = $menu['usermenu']['linkurl'][$_k];
			}
		}

		$position = "<a href='$siteurl'>$system_name[index]</a> > $system_name[$category]";
		if($map)
		{
			$maps = explode('|',$map);
			$x = $maps[0];
			$y = $maps[1];
			$z = $maps[2];
		}
		$keys = array_keys($companytpl_config);
		if(!in_array($style,$keys)) showmessage("风格不存在！");
		define('TPL', $companytpl_config[$style]['tplname']);
		define('WEB_SKIN', 'templates/'.TPL_NAME.'/yp/css/');
		define('SKIN_DIY', WEB_SKIN.$companytpl_config[$style]['style']);
		$banner = $banner ? $banner : 'yp/images/banner.jpg';
		include template('yp','com_'.TPL.'-index');
		break;

	case 'use':
		$keys = array_keys($companytpl_config);
		if(!in_array($style,$keys)) showmessage("风格不存在！");
		$db->query("UPDATE `".DB_PRE."member_company` SET `tplname`='$style',`diy`=0 WHERE `userid`='$_userid'");
		showmessage('成功启用“'.$companytpl_config[$style]['filename'].'”',$forward);
		break;
}

?>