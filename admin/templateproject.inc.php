<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/template.func.php';

if(!isset($project)) $project = $CONFIG['defaulttemplate'];

$submenu = array
(
	array($LANG['skin_manage'], '?mod='.$mod.'&file=templateproject&action=manage'),
	array($LANG['template_manage'], '?mod='.$mod.'&file=template&action=manage&project='.$project),
	array($LANG['style_manage'], '?mod='.$mod.'&file=skin&action=manage&project='.$project),
);
$menu = adminmenu($LANG['style_manage'],$submenu);

$projectdir = PHPCMS_ROOT.'/templates/';

@include_once $projectdir.'templateprojectnames.php';

$action = $action ? $action : 'manage';

switch($action)
{
	case 'edit':
		if(!$project) showmessage($LANG['illegal_parameters']);
		if($save)
		{
			file_put_contents($projectdir.$project.'/style.css',stripslashes($content));
	        showmessage($LANG['operation_success'],$forward);
		}
		else
	    {
			$projectname = $projectnames[$project];
			$filepath = PHPCMS_ROOT.'/templates/'.$project.'/projects/'.$project.'/style.css';
			$filemtime = date('Y-m-d H:i:s',filemtime($filepath));
			$content = file_get_contents($filepath);
		    include admintpl('project_edit');
		}
		break;

    case 'delete':
		if(!$project) showmessage($LANG['illegal_parameters']);
        $f->delete($projectdir.$project);
        showmessage($LANG['operation_success'], $forward);
        break;

	case 'manage':
        $list = glob($projectdir.'*');
        $files = glob($projectdir.'*.*');
        $dirs = array_diff($list, $files);

        $templateprojects = array();
		foreach($dirs as $d)
	    {
			$templateproject['dir'] = basename($d);
            $templateproject['name'] = isset($templateprojectnames[$templateproject['dir']]) ? $templateprojectnames[$templateproject['dir']] : '';
			$templateproject['isdefault'] = $CONFIG['defaulttemplate'] == $templateproject['dir'] ? 1 : 0;
			$templateproject['mtime'] = date('Y-m-d H:i:s',filemtime($d));
			$templateprojects[$templateproject['dir']] = $templateproject;
		}
		ksort($templateprojects);
    	include admintpl('templateproject');
		break;

	case 'update':
		array_save($templateprojectname,'$templateprojectnames',$projectdir.'templateprojectnames.php');
	    showmessage($LANG['skin_name_update_success'], $forward);
		break;

	case 'setdefault':
		if(!$templateproject) showmessage($LANG['illegal_parameters']);
	    set_config(array('defaulttemplate'=>$templateproject));
		$CONFIG['defaulttemplate'] = $templateproject;
		template_cache();
		showmessage($LANG['operation_success'],$forward);
		break;
}
?>