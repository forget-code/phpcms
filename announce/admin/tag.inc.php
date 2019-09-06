<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!isset($function)) $function = 'announce';
$action = $action ? $action : 'manage';
require 'admin/tag.class.php';
if(!isset($module)) $module = $mod;
$t = new tag($module);
switch($action)
{
    case 'add':
		if(isset($dosubmit))
		{
			if($tag_config['func'])
			{
				$tag_config['number'] = $tag_config['announcenum'];
				$tag_config['page'] = 0;
				$tag_config['type'] = $mod;
				$tag_config['sql'] = "SELECT * FROM ".DB_PRE."announce ORDER BY announceid DESC";
				$t->update($tagname, $tag_config);	
				showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");		
			}
		}
		else
		{
			if(isset($tag_config)) extract($tag_config);
			include admin_tpl('tag_'.$function.'_add');
		}
	break;

	case "copy":
		if(isset($dosubmit))
		{
			if($tag_config['func'])
			{
				$tag_config['number'] = $tag_config['linknum'];
				$tag_config['page'] = 0;
				$tag_config['type'] = $mod;
				$tag_config['sql'] = "SELECT * FROM ".DB_PRE."announce ORDER BY announceid DESC";
				$t->update($tagname, $tag_config);
				showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
			}
		}else
		{
			$tag_config = $t->get_tag_config($tagname);
			if($tag_config) extract($tag_config);
			include admin_tpl('tag_'.$function.'_copy');	
		}
	break;

	case 'edit':
		if(isset($dosubmit))
		{
			if($tag_config['func'])
			{
				$tag_config['number'] = $tag_config['announcenum'];
				$tag_config['page'] = 0;
				$tag_config['type'] = $mod;
				$tag_config['sql'] = "SELECT * FROM ".DB_PRE."announce ORDER BY announceid DESC";
				$t->update($tagname, $tag_config);
				if($ajax)
				{
					if($template_data) file_put_contents(TPL_ROOT.TPL_NAME.'/'.$module.'/'.$tag_config['template'].'.html', stripslashes($template_data));
					if(strpos($tag_config, '$') !== false)
					{
						echo '<script language="JavaScript">top.right.location.reload();</script>';
					}
					else
					{
						$tagcode = $t->TAG[$tagname];
						eval($tagcode.';');
						$data = ob_get_contents();
						ob_clean();
						echo '<script language="JavaScript">top.right.tag_save("'.$tagname.'", "'.format_js($data, 0).'");</script>';
					}
				}
				else
				{
					showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");
				}	
			}
		}else
		{
			$tag_config = $t->get_tag_config($tagname);
			extract($tag_config);
			$tpl = !$ajax ? 'tag_'.$function.'_edit': 'tag_'.$function.'_ajax_edit';
			include admin_tpl($tpl);
		}
	break;

	case 'manage':
		$page = max(intval($page), 1);
        $tags = $t->listinfo($function, $page, 20);
		include admin_tpl('tag_'.$function.'_manage');
	break;

	case 'preview':
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
		if(!$t->get_tag($tagname))
		{
			if(empty($tag_config['template'])) $tag_config['template'] = 'tag_list';
			$tag_config['sql'] = tag_digg_list($tag_config);
			$tag = $t->preview($tagname, $tag_config);
			$tag['module'] = $mod;
			$vars = get_var($tag['sql']);
			
			if($vars)
			{	
				parse_str(QUERY_STRING, $hiddens);
				include admin_tpl('tag_preview_form', 'phpcms');
			}
			else
			{
				if($ajax)
				{
					tag($tag['module'], $tag['template'], $tag['sql'], $tag['page'], $tag['number'], $tag['var_description']);
					$data = ob_get_contents();
					ob_clean();
					echo '<script language="JavaScript">top.right.tag_preview("'.$tagname.'", "'.format_js($data, 0).'");</script>';
				}
				else
				{
					include admin_tpl('tag_preview', 'phpcms');
				}
			}
		}
		else
		{
			$chk_var = 0;
			$t = new tag($mod);
			$tag_config = $t->get_tag_config($tagname);
			
			$tag = $t->preview($tagname, $tag_config);
			$tag['module'] = $module;
			$sql = $tag['sql'];
			preg_match("/\\$[a-zA-Z0-9]+/i", $sql, $vars);
			if(is_array($vars) && !empty($vars))
			{
				foreach($vars as $var)
				{
					eval("\$var = \"$var\";");
					if(empty($var)) $chk_var = 1;
				}
			}
			$setting = $tag['var_description'];
			
			if(empty($tag['template'])) showmessage('请选择模板');
			eval("\$tag[sql] = \"$tag[sql]\";");
			if($chk_var === 1)
			{	
				parse_str(QUERY_STRING, $hiddens);
				include admin_tpl('tag_preview_form', 'phpcms');
			}
			else
			{
				if($ajax)
				{
					tag($tag['module'], $tag['template'], $tag['sql'], $tag['page'], $tag['number'], $tag['var_description']);
					$data = ob_get_contents();
					ob_clean();
					echo '<script language="JavaScript">top.right.tag_preview("'.$tagname.'", "'.format_js($data, 0).'");</script>';
				}
				else
				{
					include admin_tpl('tag_preview', 'phpcms');
				}
			}
		}
		break;

	case 'delete':
		if($dosubmit)
		{
			$t->delete($tagname);
			showmessage('操作成功！', "?mod=$mod&file=$file&action=manage&module=$module");
		}
		break;
}
?>