<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!ACTION_TEMPLATE && 'cache' != $action)
{
    $message = "<font color=\"red\">对不起，出于系统安全考虑，管理员关闭了该功能，如需要打开请自行修改 config.inc.php 文件内对应的相关安全配置信息。<br />（将define('ACTION_TEMPLATE', '0');替换为define('ACTION_TEMPLATE', '1');）</font>";
    include admin_tpl('message');
    exit();
}
if($action != 'tag' && $action != 'preview') require_once 'template.func.php';
$module = isset($module) ? $module : 'phpcms';
$project = isset($project) ? $project : TPL_NAME;
$templatedir = TPL_ROOT.$project.'/'.$module.'/';
$projects = cache_read('name.inc.php', TPL_ROOT);
$projectname = $projects[$project] ? $projects[$project] : $project;
$names = cache_read('name.inc.php', $templatedir);
$variable = array('0'=>'请选择类型','PHPCMS'=>'$PHPCMS', 'CATEGORY'=>'$CATEGORY', 'MODULE'=>'$MODULE','MODEL'=>'$MODEL', 'member'=>'用户变量');
$action = $action ? $action : 'manage';

$log = new log();
$template = trim($template);
switch($action)
{
	case 'add':
		if($dosubmit)
		{
			if(!preg_match("/^[0-9a-z_-]+$/",$template)) showmessage('模板文件名不符合要求！');
			$filename = $template.'.html';
			$filepath = $templatedir.$filename;
         	if(file_exists($filepath)) showmessage("模板 $filepath 已存在！");

		    if($createtype)
			{
				require_once 'upload.class.php';
				$temp = 'data/temp/';
			    $upload = new upload('uploadfile', $temp, '', 'html', '4096000', 1);
				$files = $upload->up();
				if($files)
				{
					$content = file_get_contents($files[0]['saveto']);
				    @unlink($files[0]['saveto']);
					@chmod($filepath, 0777);
				}
				else
				{
					showmessage($upload->error());
				}
			}
			file_put_contents($filepath, new_stripslashes($content));
			template_compile($module, $template);
			$names[$filename] = $templatename;
		    cache_write('name.inc.php', $names, $templatedir);
			$data = addslashes($content);
			$log->set($filename);
			$log->add($data);
			$arr_log = array('data'=>$data);
			$log->add($arr_log);
	        showmessage('操作成功！', "?mod=$mod&file=$file&action=manage&modeule=$module");
		}
		else
	    {
			$tagtype = tag_types();
	    	$modname[0] = '请选择模块';
	    	foreach ($MODULE as $k=>$m)
	    	{
	    		if(file_exists(PHPCMS_ROOT.'templates/'.TPL_NAME.'/'.$m['module'].'/tag_config.inc.php'))
	    		{
	    			$modname[$k] = $m['name'];
	    		}
	    	}
	    	include admin_tpl('template_add');
		}
		break;

	case 'edit':
		if(!isset($template) || empty($template)) showmessage('请选择模板！');
		
		$filename = $template.'.html';
		$filepath = $templatedir.$filename;
		$templatenames = include TPL_ROOT.$project.'/'.$module.'/'.'name.inc.php';
		if(!is_writeable($filepath)) showmessage('模板目录 '.$filepath.' 不可写！请先通过FTP设置为 777，再进行在线编辑。');
		if($dosubmit)
		{
			file_put_contents($filepath, new_stripslashes($content));
			template_compile($module, $template);
			$names[$filename] = $templatename;
		    cache_write('name.inc.php', $names, $templatedir);
			$data = addslashes($content);
			$arr_log = array('data'=>$data); 
			$log->set($filename);
			$log->add($arr_log);
	        showmessage('模板修改成功！', $forward);
		}
		else
	    {
	    	$modname[0] = '请选择模块';
	    	foreach ($MODULE as $k=>$m)
	    	{
	    		if(file_exists(PHPCMS_ROOT.'templates/'.TPL_NAME.'/'.$m['module'].'/tag_config.inc.php'))
	    		{
	    			$modname[$k] = $m['name'];
	    		}
	    	}
	    	$tagtype = tag_types();
	    	$content = file_get_contents($filepath);
		    $filename = basename($filepath);
		    $templatename = $templatenames[$filename];
			$filemtime = date('Y-m-d H:i:s', filemtime($filepath));
	    	include admin_tpl('template_edit');
		}
		break;

	case 'tag':
		$mod = $module;
		if($mod == 'yp')
		{
			$where = '1';
			$prowhere = '1';
			$news_where = '1';
			require_once PHPCMS_ROOT."yp/include/output.func.php";
		}
		include admin_template($module, $template);
		$data = ob_get_contents();
		if(strpos($data, 'jquery') === false)
	    {
			echo '<script type="text/javascript" src="images/js/jquery.min.js"></script>';
		}
		
        include admin_tpl('block_ajax', 'phpcms');
		break;

	case 'data_ajax':
		echo htmlspecialchars(@file_get_contents($templatedir.$template.'.html'));
		break;

    case 'down':
		if(!$template) showmessage($LANG['illegal_parameters']);
		$filename = $template.'.html';
		$filepath = $templatedir.$filename;
        file_down($filepath);
		break;

    case 'delete':
		if(!$template) showmessage('非法参数！');
		$filename = $template.'.html';
		$filepath = $templatedir.$filename;
		@unlink($filepath);
		unset($names[$filename]);
		cache_write('name.inc.php', $names, $templatedir);
	    showmessage('操作成功！');
		break;

	case 'manage':
	    $files = glob($templatedir.'*.html');
        $templates = array();
		foreach($files as $tpl)
	    {
			$template['file'] = basename($tpl);
            $template['name'] = isset($names[$template['file']]) ? $names[$template['file']] : '';
			if($keyword)
			{
				if(($searchtype == 'templatename' && strpos($template['name'], $keyword) === false) || ($searchtype == 'filename' && strpos($template['file'], $keyword) === false) || ($searchtype == 'data' && strpos(file_get_contents($template['file']), $keyword) === false)) continue;
			}
			if(isset($istag))
			{
				if(($istag && strpos($template['file'], 'tag_') !== 0) || (!$istag && strpos($template['file'], 'tag_') === 0)) continue;
			}
			$template['template'] = substr($template['file'], 0, -5);
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
		include admin_tpl('template');
		break;

	 case 'preview':
		if($dosubmit)
	    {
		    require_once 'template_edit.func.php';
		    $content = stripslashes($content);
			$content = template_parse($content);
			$tempfile = PHPCMS_ROOT.'data/temp/templatepreview.tpl.php';
			file_put_contents($tempfile, $content);
			include $tempfile;
		}
		else
	    {
			$message = '<form name="myform" method="post" action="?mod=phpcms&file=template&action=preview&module='.$module.'&template='.$template.'&templatename='.$templatename.'&dosubmit=1"><input type="hidden" name="content"></form><script type="text/javascript">myform.content.value=window.opener.document.myform.content.value;myform.submit();</script>';
			showmessage($message);
		}
		break;

	case 'update':
		$names = cache_read('name.inc.php', $templatedir);
		$templatename = array_merge($names, $templatename);
		cache_write('name.inc.php', $templatename, $templatedir);
	    showmessage('模板名称更新成功！', $forward);
		break;

	case 'cache':
        template_cache();
		showmessage('模板缓存更新完成','goback');
		break;

	case 'showtags':
		$tags = include PHPCMS_ROOT.'templates/'.TPL_NAME.'/'.$module.'/tag_config.inc.php';
		foreach ($tags as $tagname=>$tag)
		{
			$arr_tagname .= $tagname.',';
		}
		if(empty($arr_tagname)) exit('null');
		$arr_tagname = substr($arr_tagname, 0, -1);
		echo $arr_tagname;
		break;

	/**
	 *	获得editor_data表里模板的信息
	 **/
	case 'gettemplate':
		$page = max(intval($page), 1);
		$pagesize = 10;
		$log->set($filename);
		$data = $log->listinfo($where, $page, $pagesize);
		foreach($data as $item)
		{
			$item['id'] = $item['logid'];;
			$item['created_time'] = $item['time'];
			$array[] = $item;
		}
		echo json_encode($array);
		break;

	case 'gettemplatedata':
		$log->set($filename);
		$result = $log->get($id, 'data');
		@extract($result);
		echo new_stripslashes($data['data']);
		break;

	case 'showvar':
			$strvar = strtolower($strvar);
			if($strvar == 'phpcms')
			{
				foreach ($PHPCMS as $k=>$v)
				{
					$arr_phpcms .= '$PHPCMS['.$k.'],';
				}
				$arr_phpcms = substr($arr_phpcms, 0 ,-1);
			}
			elseif ($strvar == 'module')
			{
				foreach ($MODULE as $k=>$v)
				{
					foreach ($MODULE[$k]  as $sub_k=>$sub_v)
					{
						$arr_module .= '$MODULE['.$k.']['.$sub_k.'],';
					}
				}
				$arr_module = substr($arr_module, 0, -1);
			}
			elseif($strvar == 'category')
			{
				$i = 0;
				foreach ($CATEGORY as $k=>$v)
				{
					if($i == 0)
					{
						foreach ($CATEGORY[$k] as $sub_k=>$sub_v)
						{
							$arr_category .= '$CATEGORY[$catid]['.$sub_k.'],';
						}
						$i++;
					}
				}
			}

			$arr_var = array('member'=>('$_userid,$_areaid,$_groupid,$_modelid,$_amount,$_point,$_message,$_email'),
							'phpcms'=>$arr_phpcms,
							'module'=>$arr_module,
							'model'=>('$MODEL[$modelid][modelid],$MODEL[$modelid][name],$MODEL[$modelid][tablename],$model[$modelid][itemname],$MODEL[$modelid][workflowid]'),
							'category'=>$arr_category);
			echo $arr_var[$strvar];
		break;

	case 'gettag':
		$arr_tag = include PHPCMS_ROOT.'templates/'.TPL_NAME.'/tag.inc.php';
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
		$tag = $arr_tag[$tagname];
		preg_match("/^tag\('([a-z0-9_]+)'/i", $tag, $m);
		$module = $m[1];
		if(!isset($MODULE[$module]))
		{
			showmessage('该标签不存在');
			exit;
		}
		$arr_type = include PHPCMS_ROOT.'templates/'.TPL_NAME.'/'.$module.'/tag_config.inc.php';
		$type = $arr_type[$tagname]['type'];
		header('location:?mod='.$module.'&file=tag&action='.$operate.'&module='.$module.'&type='.$type.'&tagname='.urlencode($tagname).'&forward='.urlencode($forward));
		break;

	case 'get_db_source':
		$datasource = load('datasource.class.php', 'phpcms', 'include/admin');
		$data = $datasource->listinfo();
		echo json_encode($data);
		break;

	case 'get_ajax_db_table':
        header('Content-type: text/html; charset=utf-8');
		$datasource = load('datasource.class.php', 'phpcms', 'include/admin');
		if(empty($name))$name = 'MM_LOCALHOST';
		$file_table = cache_read(str_replace('MM_LOCALHOST', 'phpcms',$name).'.php',PHPCMS_ROOT.'data/datasource/');
		foreach ($file_table as $key=>$val)
		{
			$key = str_replace('phpcms_', DB_PRE, $key);
			$file_table[$key] = $val;
		}
		if(!empty($name) && $name != 'MM_LOCALHOST')
		{
			$r = cache_read('db_'.$name.'.php');
			$s = $datasource->tables($r['dbhost'], $r['dbuser'], $r['dbpw'], $r['dbname'], $r['dbcharset']);
			foreach ($s as $key=>$val)
			{
				$table_list[$val]['tablename'] = $val;
				if (isset($file_table[$val])) {
					$table_list[$val]['nickname'] = $file_table[$val];
				}
			}
			echo json_encode($table_list);
		}
		elseif ($name == 'MM_LOCALHOST')
		{
			$r = $db->tables();
			foreach ($r as $key=>$val)
			{
				if(isset($file_table[$val]))
				{
					$db_table[$val]['nickname'] = $file_table[$val];
				}
				$db_table[$val]['tablename'] = $val;
			}
			echo json_encode($db_table);
		}
		break;

	case 'get_fields':
        header('Content-type: text/html; charset=utf-8');
		$datasource = load('datasource.class.php', 'phpcms', 'include/admin');
		$tables_last_name = str_replace(DB_PRE,'phpcms_', $tables);
		$file_table = cache_read(str_replace('MM_LOCALHOST', 'phpcms',$name).'_'.$tables_last_name.'.php',PHPCMS_ROOT.'data/datasource/');
		if(!empty($name) && $name!='MM_LOCALHOST')
		{
			$s = cache_read('db_'.$name.'.php', '', 1);
			@extract($s);
			$fields = $datasource->get_fields($dbhost, $dbuser, $dbpw, $dbname, $dbcharset, $tables);
			foreach ($fields as $key=>$val)
			{
				if (isset($file_table[$val['field']])) {
					$fields[$key]['nickname'] = $file_table[$val['field']];
				}
			}
		}
		elseif ($name == 'MM_LOCALHOST')
		{
			$r = $db->query("SHOW COLUMNS FROM $tables");
			while($s = $db->fetch_array($r))
			{
				$d = $datasource->format_fields($s);
				if (isset($file_table[$d['field']])) {
					$d['nickname'] = $file_table[$d['field']];
				}
				$fields[$d['field']] = $d;
			}
		}
		echo json_encode($fields);
		break;
}
?>