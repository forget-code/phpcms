<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!isset($project)) $project = TPL_NAME;
$projects = cache_read('name.inc.php', TPL_ROOT);
$projectname = $projects[$project] ? $projects[$project] : $project;
$skindir = TPL_ROOT.TPL_NAME.'/skins/';
$names = cache_read('name.inc.php', $skindir);

$action = $action ? $action : 'manage';

switch($action)
{
    case 'delete':
		if(!$skin) showmessage($LANG['illegal_parameters']);
        dir_delete($skindir.$skin);
        unset($names[$skin]);
		cache_write('name.inc.php', $names, $skindir);
        showmessage($LANG['operation_success'], $forward);
        break;

	case 'manage':
        $list = glob($skindir.'*');
        $files = glob($skindir.'*.*');
        $dirs = array_diff($list, $files);
        $skins = array();
		foreach($dirs as $d)
	    {
			$skin['dir'] = basename($d);
            $skin['name'] = $names[$skin['dir']];
			$skin['isdefault'] = TPL_CSS == $skin['dir'] ? 1 : 0;
            if($skin['isdefault']) $skinname = $skin['name'];
			$skin['mtime'] = date('Y-m-d H:i:s', filemtime($d.'/phpcms.css'));
			$skins[$skin['dir']] = $skin;
		}
		ksort($skins);
    	include admin_tpl('skin');
		break;

	case 'update':
		cache_write('name.inc.php', $skinname, $skindir);
	    showmessage($LANG['style_name_update_complete'],$forward);
		break;

	case 'setdefault':
		if(!$skin) showmessage($LANG['illegal_parameters']);
	    set_config(array('TPL_CSS'=>$skin));
		showmessage($LANG['operation_success'], $forward);
		break;
}
?>