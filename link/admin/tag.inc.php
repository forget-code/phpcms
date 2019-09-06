<?php
defined('IN_PHPCMS') or exit('Access Denied');
if(!isset($function)) $function = 'link';
$action = $action ? $action : 'manage';
require 'admin/tag.class.php';
if(!isset($module)) $module = $mod;
$t = new tag($module);
$template = $template ? $template : 'tag_link';
switch($action)
{
    case 'add':		
		if(isset($dosubmit))
		{
			if($isadd && isset($t->TAG[$tagname])) showmessage('该标签已经存在');
			if($tag_config['func'])
			{
				$sql = " WHERE linktype='$tag_config[linktype]' and passed=1";
				if(!empty($tag_config['typeid']) && ($tag_config['typeid'] != 0))
				{		
					$sql .= " AND typeid='$tag_config[typeid]'";
				}
				if(!empty($tag_config['elite']))
				{
					$sql .=" AND elite=$tag_config[elite]";
				}
				$tag_config['number'] = $tag_config['linknum'];
				$tag_config['page'] = 0;
				$tag_config['type'] = $mod;
				$tag_config['sql'] = "SELECT * FROM ".DB_PRE."link".$sql;
				$t->update($tagname, $tag_config, array('typeid'=>$tag_config['typeid']));
				showmessage($LANG['operation_success'],"?mod=$mod&file=$file&action=manage");		
			}
		}
		else
		{
			$tag_config = $t->get_tag_config($tagname);
			if(isset($tag_config)) extract($tag_config);
			include admin_tpl('tag_'.$function.'_add');
		}
	break;

	case "copy":
		if(isset($dosubmit))
		{
			if($isadd && isset($t->TAG[$tagname])) showmessage('该标签已经存在');
			if($tag_config['func'])
			{
				$sql = " where linktype='$tag_config[linktype]' and passed=1";
				if(!empty($tag_config['typeid']) && ($tag_config['typeid'] != 0))
				{		
					$sql .= " AND typeid='$tag_config[typeid]'";
				}	
				$tag_config['number'] = $tag_config['linknum'];
				$tag_config['page'] = 0;
				$tag_config['type'] = $mod;
				$tag_config['sql'] = "SELECT * FROM ".DB_PRE."link ".$sql;
				$t->update($tagname, $tag_config, array('typeid'=>$tag_config['typeid']));
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
				$sql = " where linktype='$tag_config[linktype]' and passed=1";
				if(!empty($tag_config['typeid']) && ($tag_config['typeid'] != 0))
				{		
					$sql .= " AND typeid='$tag_config[typeid]'";
				}	
				if(!empty($tag_config['elite']))
				{
					$sql .=" AND elite=$tag_config[elite]";
				}
				$tag_config['number'] = $tag_config['linknum'];
				$tag_config['page'] = 0;
				$tag_config['type'] = $mod;
				$tag_config['sql'] = "SELECT * FROM ".DB_PRE."link".$sql;
				$t->update($tagname, $tag_config, array('typeid'=>$tag_config['typeid']));
				if($ajax)
				{
					if($template_data) file_put_contents(TPL_ROOT.TPL_NAME.'/'.$mod.'/'.$tag_config['template'].'.html', stripslashes($template_data));
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
			if($tag_config) extract($tag_config);
			$tpl = !$ajax ? 'tag_'.$function.'_edit': 'tag_'.$function.'_ajax_edit';
			include admin_tpl($tpl);
		}
	break;

	case 'manage':
		$page = max(intval($page), 1);
        $tags = $t->listinfo($function, $page, 10);
		include admin_tpl('tag_'.$function.'_manage');
	break;

	case 'delete':
        $t->delete($tagname);
		showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=manage&module=$module");
		break;

	case 'preview':
		if(!isset($tag_config) && $t->get_tag($tagname))
		{
			$tag = $t->get_tag_config($tagname);
			$tag['module'] = $module;			
		}
		else
		{
			$sql = " where linktype='$tag_config[linktype]' and passed=1";
			if(!empty($tag_config['typeid'])) $sql .= " AND typeid='$tag_config[typeid]'";
			$tag_config['number'] = $tag_config['linknum'];
			$tag_config['page'] = 0;
			$tag_config['type'] = $mod;
			$tag_config['sql'] = "SELECT * FROM ".DB_PRE."link".$sql;
			$tag = $t->preview($tagname, $tag_config);
			$tag['module'] = $module;
		}
		if(empty($tag['template'])) showmessage('请选择模板');
		if(empty($tag['sql'])) showmessage('没有SQL语句');
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
	break;	
	
	case 'checktag':
		if(isset($t->TAG[$value]))
		{
			exit('该标签已经存在');
		}
		else
		{
			exit('success');
		}
	break;
}
?>