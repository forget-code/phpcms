<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!isset($project)) $project = $CONFIG['defaulttemplate'];

$submenu = array
(
	array($LANG['skin_manage'], '?mod='.$mod.'&file=templateproject&action=manage'),
	array($LANG['template_manage'], '?mod='.$mod.'&file=template&action=manage&project='.$project),
	array($LANG['style_manage'], '?mod='.$mod.'&file=skin&action=manage&project='.$project),
);
$menu = adminmenu($LANG['style_manage'],$submenu);

$skindir = PHPCMS_ROOT.'/templates/'.$project.'/skins/';

@include_once PHPCMS_ROOT.'/templates/templateprojectnames.php';

$projectname = $templateprojectnames[$project] ? $templateprojectnames[$project] : $project;

@include_once $skindir.'skinnames.php';

$action = $action ? $action : 'manage';

switch($action)
{
	case 'edit':
		if(!$skin) showmessage($LANG['illegal_parameters']);
		if($dosubmit)
		{
			file_put_contents($skindir.$skin.'/style.css', stripslashes($content));
	        showmessage($LANG['operation_success'],$forward);
		}
		else
	    {
			$skinname = $skinnames[$skin];
			$filepath = PHPCMS_ROOT.'/templates/'.$project.'/skins/'.$skin.'/style.css';
			$filemtime = date('Y-m-d H:i:s',filemtime($filepath));
			$content = file_get_contents($filepath);
		    include admintpl('skin_edit');
		}
		break;

    case 'delete':
		if(!$skin) showmessage($LANG['illegal_parameters']);
        $f->delete($skindir.$skin);
        showmessage($LANG['operation_success'],$forward);
        break;

	case 'manage':
        $list = glob($skindir.'*');
        $files = glob($skindir.'*.*');
        $dirs = array_diff($list, $files);
        $skins = array();
		foreach($dirs as $d)
	    {
			$skin['dir'] = basename($d);
            $skin['name'] = $skinnames[$skin['dir']];
			$skin['isdefault'] = $CONFIG['defaultskin'] == $skin['dir'] ? 1 : 0;
            if($skin['isdefault']) $skinname = $skin['name'];
			$skin['mtime'] = date('Y-m-d H:i:s',filemtime($d.'/style.css'));
			$skins[$skin['dir']] = $skin;
		}
		ksort($skins);
    	include admintpl('skin');
		break;

	case 'update':
		array_save($skinname,'$skinnames',$skindir.'skinnames.php');
	    showmessage($LANG['style_name_update_complete'],$forward);
		break;

	case 'setdefault':
		if(!$skin) showmessage($LANG['illegal_parameters']);
	    set_config(array('defaultskin'=>$skin));
		showmessage($LANG['operation_success'],$forward);
		break;
}
?>