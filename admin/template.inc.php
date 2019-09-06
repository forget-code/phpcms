<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/template.func.php';

$module = $channelid ? $CHANNEL[$channelid]['module'] : (isset($module) ? $module : 'phpcms');
$project = isset($project) ? $project : $CONFIG['defaulttemplate']; 
$templatedir = PHPCMS_ROOT.'/templates/'.$project.'/'.$module.'/';

@include_once PHPCMS_ROOT.'/templates/templateprojectnames.php';

$projectname = $templateprojectnames[$project] ? $templateprojectnames[$project] : $project;

$forward = isset($forward) ? $forward : $PHP_REFERER;

$submenu = array
(
	array($LANG['add_template'], '?mod='.$mod.'&channelid='.$channelid.'&file=template&action=add&module='.$module.'&project='.$project),
	array($LANG['template_manage'], '?mod='.$mod.'&channelid='.$channelid.'&file=template&action=manage&module='.$module.'&project='.$project),
	array($LANG['update_template_cache'], '?mod='.$mod.'&channelid='.$channelid.'&file=template&action=updatecache&module='.$module.'&project='.$project ,$LANG['update_all_template_cache_in_default_skin']),
);
$menu = adminmenu($MODULE[$module]['name'].$LANG['module_template_manage'], $submenu);

$modules = array();
foreach($MODULE as $key=>$m)
{
	if(is_dir(PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$key)) $modules[$key] = $m['name'];		    
}

$action = $action ? $action : 'manage';

switch($action)
{
	case 'add':
		if($dosubmit)
		{
			if(!preg_match("/^[0-9a-z_-]+$/",$template)) showmessage($LANG['template_name_non_compliant']);
			$filename = $template.'.html';
			$filepath = $templatedir.$filename;
            if(file_exists($filepath)) showmessage($LANG['template_exist_return']);

		    if($createtype)
			{
	            require_once PHPCMS_ROOT.'/include/upload.class.php';

	            $fileArr = array('file'=>$_FILES['uploadfile']['tmp_name'],'name'=>$_FILES['uploadfile']['name'],'size'=>$_FILES['uploadfile']['size'],'type'=>$_FILES['uploadfile']['type'],'error'=>$_FILES['uploadfile']['error']);
				$temp = 'data/temp/';
			    $upload = new upload($fileArr,'',$temp,'html',1,'4096000');
				if($upload->up())
				{
					$content = file_get_contents($upload->saveto);
				    @unlink($upload->saveto);
				}
				else
				{
					showmessage($upload->errmsg(),$PHP_REFERER);
				}
			}
			file_put_contents($filepath, stripslashes($content));
			template_compile($module, $template);

			require $templatedir.'templatenames.php';
			$templatenames[$filename] = $templatename;
		    array_save($templatenames, '$templatenames', $templatedir.'templatenames.php');

	        showmessage($LANG['operation_success'], $forward);
		}
		else
	    {
            require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/tags.php';
			foreach($tags AS $tagname=>$tag)
			{
				preg_match("/^(([a-z0-9]+)[_][^(]+)[(][^,]+(,([^,]+))?/", $tag, $m);
				$function = $m[1];
				$tagmod = $m[2];
				$k = $tagmod;
				if($MODULE[$tagmod]['iscopy'] && is_numeric($m[4]))
				{
					$k = $m[4];
					$taglist2[$k][] = $tagname;
				}
				elseif($MODULE[$k]['iscopy'])
				{
					$taglist1[$k][] = $tagname;
				}
				elseif($k == 'phpcms')
				{
					$taglist['phpcms'][] = $tagname;
				}
				else
				{
					$taglist3[$k][] = $tagname;
				}
			}
			foreach($CHANNEL as $channelid=>$c)
			{
	            if($c['islink']) continue;
				$channels[$channelid] = $c;
			}

		    include admintpl('template_add');
		}
		break;

	case 'edit':
		if(!isset($template) && !isset($templateid)) showmessage($LANG['illegal_parameters']);

		require $templatedir.'templatenames.php';
		
	    $template = isset($template) ? $template : $templateid;
		$filename = $template.'.html';
		$filepath = $templatedir.$filename;
		if(!is_writeable($filepath)) showmessage($LANG['template'].' '.$filepath.$LANG['cannot_write_edit_online']);

		if($dosubmit)
		{
			file_put_contents($filepath,stripslashes($content));
			template_compile($module, $template);

			$templatenames[$filename] = $templatename;
		    array_save($templatenames, '$templatenames', $templatedir.'templatenames.php');

	        showmessage($LANG['operation_success'], $forward);
		}
		else
	    {
            require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/tags.php';
			foreach($tags AS $tagname=>$tag)
			{
				preg_match("/^(([a-z0-9]+)[_][^(]+)[(][^,]+(,([^,]+))?/", $tag, $m);
				$function = $m[1];
				$tagmod = $m[2];
				$k = $tagmod;
				if($MODULE[$tagmod]['iscopy'] && is_numeric($m[4]))
				{
					$k = $m[4];
					$taglist2[$k][] = $tagname;
				}
				elseif($MODULE[$k]['iscopy'])
				{
					$taglist1[$k][] = $tagname;
				}
				elseif($k == 'phpcms')
				{
					$taglist['phpcms'][] = $tagname;
				}
				else
				{
					$taglist3[$k][] = $tagname;
				}
			}
			foreach($CHANNEL as $channelid=>$c)
			{
	            if($c['islink']) continue;
				$channels[$channelid] = $c;
			}
			$filename = basename($filepath);
			$templatename = $templatenames[$filename];
			$content = file_get_contents($filepath);
			$filemtime = date('Y-m-d H:i:s',filemtime($filepath));
		    include admintpl('template_edit');
		}
		break;

    case 'down':
		if(!$template) showmessage($LANG['illegal_parameters']);
		$filename = $template.'.html';
		$filepath = $templatedir.$filename;
        file_down($filepath);
		break;

    case 'delete':
		if(!$template) showmessage($LANG['illegal_parameters']);
		$filename = $template.'.html';
		$filepath = $templatedir.$filename;
		@unlink($filepath);
        @include_once $templatedir.'templatenames.php';
		unset($templatenames[$filename]);
		array_save($templatenames,'$templatenames',$templatedir.'templatenames.php');
	    showmessage($LANG['operation_success'], $forward);
		break;

	case 'manage':
        @include_once $templatedir.'templatenames.php';

	    $files = glob($templatedir.'*.html');
        $templates = array();
		foreach($files as $tpl)
	    {
			$template['file'] = basename($tpl);
            $template['name'] = isset($templatenames[$template['file']]) ? $templatenames[$template['file']] : '';
			if($keyword)
			{
				if(($searchtype == 'templatename' && strpos($template['name'], $keyword) === FALSE) || ($searchtype == 'filename' && strpos($template['file'], $keyword) === FALSE)) continue;
			}
			$template['template'] = str_replace('.html','',$template['file']);
			$pos = strpos($template['template'],'-');
			if($pos)
			{
				$template['type'] = substr($template['file'],0,$pos);
			}
			else
			{
				$template['type'] = $template['template'];
			}
			$template['isdefault'] = $template['type'] == $template['template'] ? 1 : 0;
			$template['mtime'] = filemtime($tpl);
			$templates[$template['template']] = $template;
		}
		ksort($templates);
		include admintpl('template');
		break;

	 case 'preview':
		if($dosubmit)
	    {
		    $content = stripslashes($content);
			$content = preg_replace("/\{template\s+(.+)\}/", "\n<?php include template(\\1); ?>\n", $content);
	        $content = preg_replace("/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>", $content);
			$tempfile = PHPCMS_ROOT.'/data/temp/templatepreview.tpl.php';
			file_put_contents($tempfile, $content);
			include $tempfile;
		}
		else
	    {
			$message = '<form name="myform" method="post" action="?mod=phpcms&file=template&action=preview&module='.$module.'&template='.$template.'&templatename='.$templatename.'&dosubmit=1"><input type="hidden" name="content"></form><script type="text/javascript">myform.content.value=window.opener.document.myform.content.value;myform.submit();</script>';
			showmessage($message);
		}
		break;

	 case 'showselect':
		header('content-type:text/html;charset='.$CONFIG['charset']); 
        echo showtpl($module,$type,$name,$templateid);
		break;

	case 'update':
		array_save($templatename, '$templatenames', $templatedir.'templatenames.php');
	    showmessage($LANG['template_update_complate'],$forward);
		break;

	case 'updatecache':
		tags_update();
		if(isset($template) && is_array($template))
	    {
			foreach($template as $tpl)
			{
				template_compile($module,$tpl) or showmessage($LANG['fail_to_compile_template']);
			}
		}
		else
	    {
            template_cache();
		}
		showmessage($LANG['operation_success'], $forward);
		break;
}
?>