<?php
defined('IN_PHPCMS') or exit('Access Denied');

require 'admin/tag.class.php';
if(!isset($module)) $module = $mod;
$t = new tag($module);

switch($action)
{
    case 'add':
		if(isset($tag_config)) extract($tag_config);
		include admin_tpl('tag_add');
	break;
	case 'edit':
		$tag_config = $t->get_tag_config($tagname);
		if($tag_config) extract($tag_config);
		$tpl = '';
		if($ajax) $tpl = '_ajax';
		include admin_tpl('tag_edit'.$tpl);
		break;
	case 'copy':
		$tag_config = $t->get_tag_config($tagname);
		if($tag_config) extract($tag_config);
		include admin_tpl('tag_copy');
		break;
	case 'manage':
		$page = max(intval($page), 1);
        $tags = $t->listinfo('', $page, 20);
		include admin_tpl('tag_manage','phpcms');
		break;
	case 'update':
		extract($tag_config);
		$where = '';
		if($typeid) $where .= "AND `typeid`='$typeid' ";
		if($elite) $where .= "AND `elite`='$elite' ";
		if($where) $where = 'WHERE '.substr($where, 3);
		$tag_config['sql'] = "SELECT * FROM `".DB_PRE."special` $where ORDER BY $orderby";
		$t->update($tagname, $tag_config);
		showmessage('操作成功！', $forward);
		break;
	case 'delete':
        $t->delete($tagname);
		showmessage('操作成功！', "?mod=$mod&file=$file&action=manage&module=$module");
		break;
	case 'preview':
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
	
		if(!isset($tag_config) && $t->get_tag($tagname))
		{
			$chk_var = 0;
			preg_match("/^(tag\(')?([a-z0-9]+)/i", $t->get_tag($tagname), $m);
			$module = $m[2];
			$tag = $t->get_tag_config($tagname);
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
			if(empty($tag['template'])) showmessage('请选择模板');
			eval("\$tag[sql] = \"$tag[sql]\";");
			foreach($tag['var_name'] as $i=>$key)
			{
				if($key) $setting[$key] = $tag['var_value'][$i];
			}
			$tag['var_description'] = $setting;
			if($chk_var === 0)
			{	
				include admin_tpl('tag_preview', 'phpcms');
			}
			else
			{
				parse_str(QUERY_STRING, $hiddens);
				include admin_tpl('tag_preview_form', 'phpcms');
			}
		}
		else
		{
			extract($tag_config);
			$where = '';		
			if($typeid) $where .= "AND `typeid`='$typeid' ";
			if($elite) $where .= "AND `elite`='$elite' ";
			if($where) $where = 'WHERE '.substr($where, 3);
			$tag_config['sql'] = "SELECT * FROM `".DB_PRE."special` $where ORDER BY $orderby";
			$tag = $t->preview($tagname, $tag_config);
			foreach($tag_config['var_name'] as $i=>$key)
			{
				if($key) $setting[$key] = $tag_config['var_value'][$i];
			}
			$tag['var_description'] = $setting;
			$tag['module'] = $module;
			if(empty($tag['template'])) showmessage('请选择模板');
			if(empty($tag['sql'])) showmessage('没有SQL语句');
			include admin_tpl('tag_preview', 'phpcms');
		}
		break;
}

function get_var($string)
{
	return preg_match_all("/\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+/", $string, $m) ? $m[0] : 0;
}

?>