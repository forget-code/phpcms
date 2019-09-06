<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once 'template.func.php';

$projects = cache_read('name.inc.php', TPL_ROOT);
if(!isset($project)) $project = TPL_NAME;

$projectdir = TPL_ROOT;

$action = $action ? $action : 'manage';

switch($action)
{
    case 'delete':
		if(!$project) showmessage('参数错误！');
        dir_delete($projectdir.$project);
        showmessage('操作成功！', $forward);
        break;

	case 'manage':
        $list = glob($projectdir.'*');
        $files = glob($projectdir.'*.*');
        $dirs = array_diff($list, $files);
        $templateprojects = array();
		foreach($dirs as $d)
	    {
			$templateproject['dir'] = basename($d);
            $templateproject['name'] = isset($projects[$templateproject['dir']]) ? $projects[$templateproject['dir']] : '';
			$templateproject['isdefault'] = TPL_NAME == $templateproject['dir'] ? 1 : 0;
			$templateproject['mtime'] = date('Y-m-d H:i:s',filemtime($d));
			$templateprojects[$templateproject['dir']] = $templateproject;
		}
		ksort($templateprojects);
    	include admin_tpl('templateproject');
		break;

	case 'update':
		cache_write('name.inc.php', $templateprojectname, TPL_ROOT);
	    showmessage('方案名称保存成功！', $forward);
		break;

	case 'setdefault':
		if(!$templateproject) showmessage('参数错误！');
	    set_config(array('TPL_NAME'=>$templateproject));
		showmessage('操作成功！开始更新模板缓存 ...', '?mod=phpcms&file=template&action=cache&forward='.urlencode($forward));
		break;
}
?>