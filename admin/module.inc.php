<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once 'template.func.php';
require 'admin/module.class.php';

$m = new module();

switch($action)
{
	case 'install':
		if(isset($confirminstall) && $confirminstall)
		{
			
			require_once PHPCMS_ROOT.$installdir."/install/config.inc.php";
			
			$r = $db->get_one("SELECT module From ".DB_PRE."module WHERE module='$installdir'");
			if($r) showmessage($LANG['installed_module_unstall_it_then_continue']);					
			
			if(file_exists(PHPCMS_ROOT.$installdir."/install/mysql.sql"))
			{
				$sql = file_get_contents(PHPCMS_ROOT.$installdir."/install/mysql.sql");
				sql_execute($sql);
			}
			if(file_exists(PHPCMS_ROOT.$installdir."/install/extention.inc.php"))
			{
				@extract($db->get_one("SELECT menuid AS member_0 FROM ".DB_PRE."menu WHERE keyid='member_0'"));
				@extract($db->get_one("SELECT menuid AS member_1 FROM ".DB_PRE."menu WHERE keyid='member_1'"));
				@include (PHPCMS_ROOT.$installdir."/install/extention.inc.php");
			}
			if(FTP_ENABLE)
			{
				require_once PHPCMS_ROOT.'include/ftp.class.php';
				$ftp = new ftp(FTP_HOST, FTP_PORT, FTP_USER, FTP_PW, FTP_PATH);
				if(file_exists(PHPCMS_ROOT.$installdir."/install/chmod.txt"))
				{
					$files = file(PHPCMS_ROOT.$installdir."/install/chmod.txt");
					$files = array_filter($files);
					foreach($files as $file)
					{
						$ftp->dir_chmod(PHPCMS_ROOT.$file);
					}
				}
			}

			if(file_exists(PHPCMS_ROOT.$installdir."/install/templates/"))
			{
				dir_copy(PHPCMS_ROOT.$installdir."/install/templates/", PHPCMS_ROOT.'templates/'.TPL_NAME.'/'.$module.'/');
			}
			if(file_exists(PHPCMS_ROOT.$installdir."/install/languages/"))
			{
				dir_copy(PHPCMS_ROOT.$installdir.'/install/languages/', PHPCMS_ROOT.'languages/'.LANG.'/');
			}
			cache_all();
			tags_update();
			showmessage($LANG['module_install_success'], "?mod=".$mod."&file=module&action=updatecache");
		}
		else
		{
			if(isset($confirm) && $confirm==1)
			{
				if(!is_dir(PHPCMS_ROOT.$installdir."/install/"))
				{
					showmessage($LANG['module_install_dir_not_exist']);
				}
				
			    require_once PHPCMS_ROOT.$installdir."/install/config.inc.php";
				if(array_key_exists($module, $MODULE)) showmessage($LANG['installed_module_unstall_it_then_continue']);
			    include admin_tpl('module_install_confirm');
			}
			else
			{
			    include admin_tpl('module_install');
			}
		}
		break;
		
	case 'uninstall':
		if(!isset($module)) showmessage($LANG['illegal_operation']);
		if(in_array($module, $chas))
		{
			if(file_exists(PHPCMS_ROOT.'module/'.$module."/uninstall/extention.php"))
			{
				@include (PHPCMS_ROOT.'module/'.$module."/uninstall/extention.php");
			}
		}
		else 
		{
			if(file_exists(PHPCMS_ROOT.$module."/uninstall/extention.inc.php"))
			{
				@include (PHPCMS_ROOT.$module."/uninstall/extention.inc.php");
			}
			if(file_exists(PHPCMS_ROOT.$module."/uninstall/mysql.sql"))
			{
				$sql = file_get_contents(PHPCMS_ROOT.$module."/uninstall/mysql.sql");
				sql_execute($sql);
			}	
            if(file_exists(PHPCMS_ROOT.$module."/uninstall/delete.txt"))
			{
				$delete = file_get_contents(PHPCMS_ROOT.$module."/uninstall/delete.txt");				
				$deletearr = explode("\n",str_replace("\r","",$delete));
	    		$deletearr = array_filter($deletearr);
	    		foreach($deletearr as $del)
	    		{
					$del = PHPCMS_ROOT.$del;
	    		 	if(is_dir($del)) dir_delete($del);
	    		 	else if(file_exists($del)) @unlink($del);
	    		}
			}			
		}
		@unlink(PHPCMS_ROOT.'languages/'.LANG.'/'.$module.'.lang.php');
		@unlink(PHPCMS_ROOT.'languages/'.LANG.'/'.$module.'_admin.lang.php');
		dir_delete(PHPCMS_ROOT.'templates/'.TPL_NAME.'/'.$module.'/');
		require_once 'menu.class.php';
		$menu = new menu();
		$menuid = $menu->menuid($module);
		$menu->delete($menuid);
		$db->query("DELETE FROM `".DB_PRE."module` WHERE `module`='$module';");
		$db->query("DELETE FROM `".DB_PRE."menu` WHERE `keyid`='$module';");
		cache_all();
		$modules = array();
		foreach($MODULE as $module=>$v)
		{
			if($module != $module) $modules[] = $module;
		}
		tags_update($modules);
		showmessage($LANG['module_uninstall_success'],"?mod=".$mod."&file=module");
		break;

	case 'updatecache':
		tags_update();
        template_cache();
		showmessage($LANG['all_cache_update_success'], '?mod='.$mod.'&file=module');
		break;

	case 'add':
		if($dosubmit)
	    {
		    if(!$m->add($info)) showmessage($m->msg());
            showmessage($LANG['operation_success'], $forward);
		}
		else
	    {
			include admin_tpl('module_add');
		}
		break;

	case 'view':
		$r = $m->get($module);
		@extract($r);
		include admin_tpl('module_view');
		break;

	case 'faq':
		$r = $m->get($module);
		@extract($r);
 		include admin_tpl('module_faq');
		break;

	case 'disable':
		if($m->disable($module, $value))
		{
			showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
		break;

	default:
        $data = $m->listinfo();
		include admin_tpl('module');
}
?>