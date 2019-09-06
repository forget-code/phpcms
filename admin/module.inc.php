<?php
defined('IN_PHPCMS') or exit('Access Denied');

if($_grade > 0 ) showmessage($LANG['you_have_no_permission']);

require_once PHPCMS_ROOT."/include/template.func.php";

$action = $action ? $action : 'manage';

$submenu = array
(
    array($LANG['install_module'], "?mod=".$mod."&file=".$file."&action=install"),
    array($LANG['module_manage'], "?mod=".$mod."&file=".$file."&action=manage"),
    array($LANG['new_module'], "?mod=".$mod."&file=".$file."&action=add", $LANG['only_for_php_programmer']),
);

$menu = adminmenu($LANG['module_manage'],$submenu);
$chas = glob(PHPCMS_ROOT.'/module/*');
$chas = array_map('basename', $chas);
if(!isset($module)) $module = '';
if(in_array($module, $chas)) $installdir = 'module/'.$install;

switch($action)
{
	case 'install':
		if(isset($confirminstall) && $confirminstall)
		{			
			require_once PHPCMS_ROOT."/".$installdir."/install/config.php";
			
			$r = $db->get_one("SELECT moduleid From ".TABLE_MODULE." WHERE module='$module'");
			if($r) showmessage($LANG['installed_module_unstall_it_then_continue']);			
			
			if($PHPCMS['enableftp'])
			{
				require_once PHPCMS_ROOT.'/include/ftp.inc.php';
			}			

			if(file_exists(PHPCMS_ROOT."/".$installdir."/install/mysql.sql"))
			{
				$sql = file_get_contents(PHPCMS_ROOT."/".$installdir."/install/mysql.sql");
				sql_execute($sql);
			}
			if(file_exists(PHPCMS_ROOT."/".$installdir."/install/extension.php"))
			{
				@include (PHPCMS_ROOT."/".$installdir."/install/extension.php");
			}
			if(file_exists(PHPCMS_ROOT."/".$installdir."/install/chmod.txt"))
			{
				$files = file(PHPCMS_ROOT."/".$installdir."/install/chmod.txt");
				$files = array_filter($files);
				foreach($files as $file)
				{
					dir_chmod(PHPCMS_ROOT.'/'.$file);
				}
			}
			if(file_exists(PHPCMS_ROOT."/".$installdir."/install/templates/"))
			{
				dir_copy(PHPCMS_ROOT."/".$installdir."/install/templates/", PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$module.'/');
			}
			if(file_exists(PHPCMS_ROOT."/".$installdir."/install/languages/"))
			{
				dir_copy(PHPCMS_ROOT.'/'.$installdir.'/install/languages/', PHPCMS_ROOT.'/languages/');
			}
			cache_all();
			showmessage($LANG['module_install_success'], "?mod=".$mod."&file=module&action=updatecache");
		}
		else
		{
			if(isset($confirm) && $confirm==1)
			{
				if(!is_dir(PHPCMS_ROOT."/".$installdir."/install/"))
				{
					showmessage($LANG['module_install_dir_not_exist']);
				}
			    require_once PHPCMS_ROOT."/".$installdir."/install/config.php";
				if(array_key_exists($module, $MODULE)) showmessage($LANG['installed_module_unstall_it_then_continue']);
				$enablecopy = $enablecopy ? $LANG['yes'] : $LANG['no'] ;
				$isshare = $isshare ? $LANG['yes']  : $LANG['no'] ;
			    include admintpl('module_install_confirm');
			}
			else
			{
			    include admintpl('module_install');
			}
		}
		break;
		
	case 'uninstall':
		if(!isset($modulename)) showmessage($LANG['illegal_operation']);
		if(in_array($modulename, $chas))
		{
			if(file_exists(PHPCMS_ROOT.'/module/'.$modulename."/uninstall/extension.php"))
			{
				@include (PHPCMS_ROOT.'/module/'.$modulename."/uninstall/extension.php");
			}
		}
		else 
		{
			if(file_exists(PHPCMS_ROOT.'/'.$modulename."/uninstall/mysql.sql"))
			{
				$sql = file_get_contents(PHPCMS_ROOT.'/'.$modulename."/uninstall/mysql.sql");
				sql_execute($sql);
			}
            if(file_exists(PHPCMS_ROOT.'/'.$modulename."/uninstall/delete.txt"))
			{
				$delete = file_get_contents(PHPCMS_ROOT.'/'.$modulename."/uninstall/delete.txt");				
				$deletearr = explode("\n",str_replace("\r","",$delete));
	    		$deletearr = array_filter($deletearr);
	    		foreach($deletearr as $del)
	    		{
					$del = PHPCMS_ROOT.'/'.$del;
	    		 	if(is_dir($del)) dir_delete($del);
	    		 	else if(file_exists($del)) @unlink($del);
	    		}

			}
			if(file_exists(PHPCMS_ROOT.'/'.$modulename."/uninstall/extension.php"))
			{
				@include (PHPCMS_ROOT.'/'.$modulename."/uninstall/extension.php");
			}			
		}
		@unlink(PHPCMS_ROOT.'/languages/'.$CONFIG['language'].'/'.$modulename.'.lang.php');
		@unlink(PHPCMS_ROOT.'/languages/'.$CONFIG['adminlanguage'].'/'.$modulename.'_admin.lang.php');
		dir_delete(PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$modulename.'/');
		cache_all();
		$modules = array();
		foreach($MODULE as $module=>$v)
		{
			if($module != $modulename) $modules[] = $module;
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
		    if(!preg_match("/^[a-z0-9]+$/",$module) || strlen($module) > 20) showmessage($LANG['template_dir_not_over_20char'], "goback");
			if(!$name || !$moduledir || !$version || !$author || !$email || !$introduce) showmessage($LANG['modulename_version_etc_not_null'].$name.$moduledir.$introduce, "goback");
            if(array_key_exists($module,$MODULE)) showmessage($LANG['module_name_cannot_repeat'], "goback");
            if($iscopy) $moduledomain = '';
		    $db->query("INSERT INTO ".TABLE_MODULE."(name,module,moduledir,moduledomain,iscopy,isshare,version,author,site,email,introduce,license,faq) VALUES('$name','$module','$moduledir','$moduledomain','$iscopy','$isshare','$version','$author','$site','$email','$introduce','$license','$faq')");
            showmessage($LANG['operation_success'], $forward);
		}
		else
	    {
			include admintpl('module_add');
		}
		break;

	case 'view':
		$r = $db->get_one("select * from ".TABLE_MODULE." where moduleid='$moduleid'");
		@extract($r);
		include admintpl('module_view', 'phpcms');
		break;

	case 'faq':
		$r = $db->get_one("select name,faq from ".TABLE_MODULE." where moduleid='$moduleid'");
		@extract($r);
		if(!$faq) $faq=$LANG['no_help'];
 		include admintpl('module_faq');
		break;

	case 'disable':
		if(empty($moduleid)) showmessage($LANG['illegal_parameters'],"goback");

		$moduleids = is_array($moduleid) ? implode(',',$moduleid) : $moduleid;
		$db->query("UPDATE ".TABLE_MODULE." SET disabled=$value WHERE moduleid IN ($moduleids)");
		if($db->affected_rows()>0)
		{
			cache_common();
			showmessage($LANG['operation_success'], '?mod='.$mod.'&file='.$file);
		}
		else
		{
			showmessage($LANG['operation_failure']);
		}
		break;

	case 'manage':
		  $result=$db->query("select * from ".TABLE_MODULE." order by moduleid");
		  while($r=$db->fetch_array($result))
		  {
			  $r['admin'] = admin_users('modules', $r['module']);
			  $modules[] = $r;
		  }
		  include admintpl('module');
}
?>