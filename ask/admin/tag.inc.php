<?php
defined('IN_PHPCMS') or exit('Access Denied');
$submenu = array
(
	array($LANG['ask_label'], '?mod='.$mod.'&file='.$file.'&action=manage&function=ask'),
	array($LANG['credit_label'], '?mod='.$mod.'&file='.$file.'&action=manage&function=credit'),
);
$menu = admin_menu($LANG['ask_label_manage'],$submenu);
if(!isset($function)) $function = 'ask';
$functions = array('ask' => $LANG['ask_label'],'credit' => $LANG['credit_label']);
$functions = array('ask' => $LANG['tag_ask'],'credit' => $LANG['tag_credit']);

require MOD_ROOT.'admin/include/tag.func.php';
require 'admin/tag.class.php';
if(!isset($module)) $module = $mod;
$t = new tag($module);
$orderfields['askid DESC'] = $LANG['orderby_id_desc'];
$orderfields['askid ASC'] = $LANG['orderby_id_asc'];
$orderfields['hits DESC'] = $LANG['orderby_hits_desc'];
$orderfields['hits ASC'] = $LANG['orderby_hits_asc'];

switch($action)
{
    case 'add':
		if(isset($tag_config)) extract($tag_config);
		include admin_tpl('tag_'.$function.'_add');
	break;
	case 'edit':
		$tag_config = $t->get_tag_config($tagname);
		if($tag_config) extract($tag_config);
		$tpl_ajax = '';
		if($ajax) $tpl_ajax = '_ajax';
		
		include admin_tpl('tag_'.$type.'_edit'.$tpl_ajax);
		break;
	case 'manage':
		$page = max(intval($page), 1);
        $tags = $t->listinfo($function, $page, 20);
		include admin_tpl('tag_manage');
		break;
	case 'copy':
		$tag_config = $t->get_tag_config($tagname);
		if($tag_config) extract($tag_config);

		include admin_tpl('tag_'.$function.'_copy');
		break;
	case 'update':
		$sql = '';
		$tag_config['type'] = $function;
		if($function == 'ask')
		{	
			$tag_config['sql'] = tag_ask($tag_config);
			$t->update($tagname, $tag_config, array('catid'=>$tag_config['catid'],'userid'=>$tag_config['userid'],'flag'=>$tag_config['flag'],'action'=>'$action','urlruleid'=>$M['categoryUrlRuleid']));	

		}
		elseif($function == 'credit')
		{
			if(!$tag_config['mode'])
			{
				$tag_config['sql'] = tag_credit($tag_config);
			}		
			$t->update($tagname, $tag_config, array(''));
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
	case 'delete':
        $t->delete($tagname);
		showmessage($LANG['operation_success'], "?mod=$mod&file=$file&action=manage&module=$module");
		break;
	
	case 'preview':
		$tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));

		if(!isset($tag_config) && $t->get_tag($tagname))
		{
			$chk_var = 0;
			$t = new tag($mod);
			$tag_config = $t->get_tag_config($tagname);
			$tag = $t->preview($tagname, $tag_config);
			$sql = $tag['sql'];
			$tag['module'] = $module;
			$setting = $tag['var_description'];
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
			if($chk_var === 1)
			{	
				parse_str(QUERY_STRING, $hiddens);
				include admin_tpl('tag_preview_form', 'phpcms');
			}
			else
			{
			
				if($ajax)
				{
					echo tag($tag['module'], $tag['template'], $tag['sql'], $tag['page'], $tag['number'], $tag['var_description']);
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
			if(empty($tag_config['template']))
			{
				$tag_config['template'] = 'tag_'.$function;
			}

			if($function == 'ask')
			{
				$tag_config['sql'] = tag_ask($tag_config);
			}
			else
			{
				$tag_config['sql'] = tag_credit($tag_config);
			}
			$tag = $t->preview($tagname, $tag_config);
			$tag['module'] = $mod;
			if(empty($tag['sql'])) showmessage('没有SQL语句');
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
		
	break;	
}
function get_var($string)
{
	return preg_match_all("/\\$[a-zA-Z0-9_\[\]\"\$\x7f-\xff]+/", $string, $m) ? $m[0] : 0;
}
?>