<?php
defined('IN_PHPCMS') or exit('Access Denied');
$types = array('content'=>'内容','category'=>'栏目','special'=>'专题','type'=>'类别','area'=>'地区');

require 'admin/tag.class.php';
if(!isset($module)) $module = $mod;
$t = new tag($module);
switch($action)
{
    case 'add':
		if($type == 'content')
	    {
			require CACHE_MODEL_PATH.'content_tag_form.class.php';
			$content_tag_form = new content_tag_form($modelid);
			$forminfos = $content_tag_form->get();
			$fields = $orderfields = $selectfields = array();
			foreach($content_tag_form->fields as $field=>$v)
			{
				$fields[$field] = $v['name'];
				if($v['isselect']) $selectfields[] = $field;
				if($v['isorder'])
				{
					$orderfields[$field.' ASC'] = $v['name'].' 升序';
					$orderfields[$field.' DESC'] = $v['name'].' 降序';
				}
			}
			$selectfields = implode(',', $selectfields);
		}
		if(isset($tag_config)) extract($tag_config, EXTR_SKIP);
		header("Cache-control: private");
		include admin_tpl('tag_'.$type.'_add');
	break;

	case 'edit':
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
		$tag_config = $t->get_tag_config($tagname);
		$tempmodelid = $modelid;
		if($tag_config) extract(new_htmlspecialchars($tag_config));
		
		if($tempmodelid) $modelid = $tempmodelid;
		$tpl = 'tag_'.$type.'_edit';
		if($type == 'content')
	    {
			if($modelid) $tag_config['modelid'] = $modelid;
			require CACHE_MODEL_PATH.'content_tag_form.class.php';
			$content_tag_form = new content_tag_form($modelid);
			$forminfos = $content_tag_form->get($where);
			$fields = $orderfields = array();
			foreach($content_tag_form->fields as $field=>$v)
			{
				$fields[$field] = $v['name'];
				if($v['isorder'])
				{
					$orderfields[$field.' ASC'] = $v['name'].' 升序';
					$orderfields[$field.' DESC'] = $v['name'].' 降序';
				}
			}
			$selectfields = implode(',', $selectfields);
		}
		elseif($type == 'category')
		{
		}
		
		if($ajax) $tpl = 'tag_'.$type.'_edit_ajax';
		include admin_tpl($tpl);
		break;
	case 'copy':
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
		$tag_config = $t->get_tag_config($tagname);
		if($tag_config) extract(new_htmlspecialchars($tag_config));
		if($type == 'content')
	    {
			if($modelid) $tag_config['modelid'] = $modelid;
			require CACHE_MODEL_PATH.'content_tag_form.class.php';
			$content_tag_form = new content_tag_form($modelid);
			$forminfos = $content_tag_form->get($where);
			$fields = $orderfields = array();
			foreach($content_tag_form->fields as $field=>$v)
			{
				$fields[$field] = $v['name'];
				if($v['isorder'])
				{
					$orderfields[$field.' ASC'] = $v['name'].' 升序';
					$orderfields[$field.' DESC'] = $v['name'].' 降序';
				}
			}
			$selectfields = implode(',', $selectfields);
		}
		include admin_tpl('tag_'.$type.'_copy');
		break;
	case 'manage':
		$page = max(intval($page), 1);
        $tags = $t->listinfo($type, $page, 20);
		include admin_tpl('tag_manage');
		break;
	case 'update':
		$tag_config['type'] = $type;
		if($isadd && isset($t->TAG[$tagname])) showmessage('该标签已经存在');
		$tagname = trim($tagname);
		if(preg_match('/([\'"${}\(\)\\/,;])/',$tagname)) showmessage('标签不能含有下面字符\' " $ { } ( ) \ / , ;');
		if($type == 'content')
	    {
			if(!$tag_config['mode'])
			{
				$tag_config['where'] = $info;
				require CACHE_MODEL_PATH.'content_tag.class.php';
				$content_tag = new content_tag($modelid);
				$tag_config['sql'] = $content_tag->get($tag_config['selectfields'], $info, $tag_config['orderby']);
			}
			$tag_config['modelid'] = $modelid;			
			$t->update($tagname, $tag_config);
		}
		elseif($type == 'category')
	    {
			$tag_config['sql'] = '';
			$tag_config['page'] = 0;
			if(!$tag_config['number']) $tag_config['number'] = 0;
			$t->update($tagname, $tag_config, array('module'=>$tag_config['module'], 'catid'=>$tag_config['catid']));
		}
		elseif($type == 'special')
	    {
			extract($tag_config);
			$where = '';
			if($typeid) $where .= "AND `typeid`='$typeid' ";
			if($elite) $where .= "AND `elite`='$elite' ";
			if($where) $where = 'WHERE '.substr($where, 3);
			$tag_config['sql'] = "SELECT * FROM `".DB_PRE."special` $where ORDER BY $orderby";
			$t->update($tagname, $tag_config);
		}
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
			showmessage('操作成功！', $forward);
		}
		break;

		case 'listtag':
		if($dosubmit)
	    {
			$arr_tag = include PHPCMS_ROOT.'templates/'.TPL_NAME.'/tag.inc.php';
			$content = stripslashes($content);
			preg_match_all("/[{]tag_([^}]+)[}]/", $content, $m);
			foreach ($m[1] as $k=>$v)
			{
				$tag = $arr_tag[$v];
				if(preg_match("/^(tag\(')?([a-z0-9]+)/i", $tag, $t))
				{
					$r['tagname'] = $v;
					$r['module'] = $t[2];
					$array[] = $r;
				}
				else
				{
					$r['tagname'] = $v;
					$un_tag[] = $r;
				}
			}
		    include admin_tpl('tag_list','phpcms');
		}
		else
	    {
			$message = '<form name="myform" method="post" action="?mod=phpcms&file=tag&action=listtag&module='.$module.'&template='.$template.'&templatename='.$templatename.'&dosubmit=1"><input type="hidden" name="content"></form><script type="text/javascript">myform.content.value=window.opener.document.myform.content.value;myform.submit();</script>';
			showmessage($message);
		}
	break;

	case 'preview':
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
		if(!isset($tag_config) && $t->get_tag($tagname))
		{
			$chk_var = 0;
			preg_match("/^(tag\(')?([a-z0-9]+)/i", $t->get_tag($tagname), $m);
			$module = $m[2];
			$t = new tag($module);
			$tag_config = $t->get_tag_config($tagname);
			if(isset($info['catid']) || $tag_config['catid'] == '$catid')
			{
				preg_match("/\\$[a-zA-Z0-9]+/i", $tag_config['module'], $module_vars);
				preg_match("/\\$[a-zA-Z0-9]+/i", $tag_config['catid'], $cat_vars);			
				if(!empty($module_vars) || !empty($cat_vars))
				{
					$vars = array_merge($module_vars, $cat_vars);
				}
				if(is_array($vars) && !empty($vars))
				{
					foreach($vars as $var)
					{
						eval("\$var = \"$var\";");
						if(empty($var)) $chk_var = 1;
					}
				}
				if($chk_var === 0)
				{
					eval("\$catid = \"$catid\";");
					eval("\$module = \"$module\";");

					$tag = $t->preview($tagname, $tag_config, array('module'=>$module, 'catid'=>$catid));
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
				else
				{
					include admin_tpl('tag_preview_form', 'phpcms');
				}
			}
			else
			{
				$tag = $t->preview($tagname, $tag_config);
				
				$tag['module'] = $module;
				$sql = $tag['sql'];
				preg_match("/\\$[a-zA-Z0-9]+/i", $sql, $vars);
				if(strpos($sql, 'get_sql_catid') && !in_array('$catid', $vars)) $vars[] = '$catid';

				if(is_array($vars) && !empty($vars))
				{
					foreach($vars as $var)
					{
						eval("\$var = \"$var\";");
						if(empty($var)) $chk_var = 1;
					}
				}
				if(empty($tag['template'])) showmessage('请选择模板');
				eval("\$tag[sql] = \"$tag[sql]\";");
				if($chk_var === 0)
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
				else
				{
					include admin_tpl('tag_preview_form', 'phpcms');
				}
			}
		}
		else
		{
			$tag_config['type'] = $type;
			if($type == 'content')
			{
				if(!$tag_config['mode'])
				{
					$tag_config['where'] = $info;
					require CACHE_MODEL_PATH.'content_tag.class.php';
					$content_tag = new content_tag($modelid);
					$tag_config['sql'] = $content_tag->get($tag_config['selectfields'], $info, $tag_config['orderby']);
				}
				$tag_config['modelid'] = $modelid;
			}

			if(isset($info['catid']) || $type == 'category')
			{
				preg_match("/^(tag\(')?([a-z0-9]+)/i", $t->get_tag($tagname), $m);
				$module = $m[2];
				$t = new tag($module);
				
				if($tag_config['sql'])
				{
					$sql = $tag_config['sql'];
					preg_match("/\\$[a-zA-Z0-9]+/i", $sql, $vars);
					if(strpos($sql, 'get_sql_catid') && !in_array('$catid', $vars)) $vars[] = '$catid';
				}
				else
				{
					preg_match("/\\$[a-zA-Z0-9]+/i", $tag_config['module'], $module_vars);
					preg_match("/\\$[a-zA-Z0-9]+/i", $tag_config['catid'], $cat_vars);
					if(!empty($module_vars) || !empty($cat_vars))
					{
						$vars = array_merge($module_vars, $cat_vars);
					}
				}

				if(is_array($vars) && !empty($vars))
				{
					foreach($vars as $var)
					{
						eval("\$var = \"$var\";");
						if(empty($var))
						{
							$chk_var = 1;
							break;
						}
					}
				}

				if($chk_var == 0)
				{
					eval("\$catid = \"$catid\";");
					eval("\$module = \"$module\";");

					$tag = $t->preview($tagname, $tag_config, array('module'=>$module, 'catid'=>$catid));
					if($ajax)
					{
						tag($tag['module'], $tag['template'], $tag['sql'], $tag['page'], $tag['number'], $tag['var_description']);
						$data = ob_get_contents();
						ob_clean();
						echo '<script language="JavaScript">top.right.tag_preview("'.$tagname.'", "'.format_js($data, 0).'");</script>';
					}
					else
					{
						eval("\$tag[sql] = \"$tag[sql]\";");
						include admin_tpl('tag_preview', 'phpcms');
					}
				}
				else
				{
					$hiddens = $info;
					include admin_tpl('tag_preview_form', 'phpcms');
				}
			}
			else
			{
				if(!$tag_config['mode'])
				{
					$tag_config['where'] = $info;
					if($module == 'member')
					{
						require CACHE_MODEL_PATH.'member_tag.class.php';
						$member_tag = new member_tag($modelid);
						$tag_config['sql'] = $member_tag->get($tag_config['selectfields'], $info, $tag_config['orderby']);
					}
					elseif($module == 'content')
					{
						require CACHE_MODEL_PATH.'content_tag.class.php';
						$content_tag = new content_tag($modelid);
						$tag_config['sql'] = $member_tag->get($tag_config['selectfields'], $info, $tag_config['orderby']);
					}
				}

				$tag_config['modelid'] = $modelid;
				$tag = $t->preview($tagname, $tag_config);
				
				$tag['module'] = $module;
				if(empty($tag['template'])) showmessage('请选择模板');
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
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", $tagname);
        $t->delete($tagname);
		showmessage('操作成功！', "?mod=$mod&file=$file&action=manage&module=$module&type=$type");
		break;
	case 'ajax_category':
		$parentid = max(intval($parentid), 0);
		echo form::select_category($module, $parentid, 'category[parentid]', 'parentid', '不限', $catid, 'onchange="myform.catid.value=this.value;"');
		break;
	case 'quickoperate':
		if($type == 'content')
	    {
			require CACHE_MODEL_PATH.'content_tag_form.class.php';
			$content_tag_form = new content_tag_form($modelid);
			$forminfos = $content_tag_form->get();
			$fields = $orderfields = $selectfields = array();
			foreach($content_tag_form->fields as $field=>$v)
			{
				$fields[$field] = $v['name'];
				if($v['isselect']) $selectfields[] = $field;
				if($v['isorder'])
				{
					$orderfields[$field.' ASC'] = $v['name'].' 升序';
					$orderfields[$field.' DESC'] = $v['name'].' 降序';
				}
			}
			$selectfields = implode(',', $selectfields);
		}
		if(isset($tag_config)) extract($tag_config, EXTR_SKIP);
		include admin_tpl('tag_'.$type.'_add');
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

function get_var($string)
{
	return preg_match_all("/\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+/", $string, $m) ? $m[0] : 0;
}

function is_defined($vars)
{
	@extract($GLOBALS);
	if(is_array($vars))
	{
		foreach($vars as $var)
		{
			$isset = 0;
			eval("\$isset = isset($var);");
			if(!$isset) return FALSE;
		}
	}
	else
	{
		$isset = 0;
		eval("\$isset = isset($vars);");
		if(!$isset) return FALSE;
	}
	return TRUE;
}
?>