<?php
defined('IN_PHPCMS') or exit('Access Denied');

if(!isset($filename) && $file == 'tag' && $action != 'clear')
{
	require_once PHPCMS_ROOT.'/include/tag.func.php';
	require_once PHPCMS_ROOT.'/include/formselect.func.php';

	$action = $action ? $action : 'manage';
	$actions = array('add','edit','copy','delete','manage','save', 'preview', 'checkname', 'list','category_select', 'quickoperate','listtag','specialid_select');
	if(!in_array($action, $actions)) showmessage($LANG['illegal_action']);

	$function = isset($function) ? $function : 'phpcms_cat';
	$functions = array('phpcms_cat'=>$LANG['category'], 'phpcms_type'=>$LANG['type'], 'phpcms_special_list'=>$LANG['specail_list'], 'phpcms_special_slide'=>$LANG['specail_slide']);
	if(!array_key_exists($function, $functions)) showmessage($LANG['not_exist']." $function ".$LANG['function_label'], "goback");

	$referer = isset($referer) ? $referer : "?mod=$mod&file=$file";

	$tag_funcs = array(
		'phpcms_cat'=>'$templateid,$keyid,$catid,$child,$showtype,$open',
		'phpcms_type'=>'$templateid,$keyid',
		'phpcms_special_list'=>'$templateid,$keyid,$page,$specialnum,$specialnamelen,$descriptionlen,$iselite,$datenum,$showtype,$imgwidth,$imgheight,$cols',
		'phpcms_special_slide'=>'$templateid,$keyid,$specialnum,$specialnamelen,$iselite,$datenum,$imgwidth,$imgheight,$timeout,$effectid',
	);

	$submenu = array();
	foreach($functions as $func=>$name)
	{
		$submenu[] = array($name.$LANG['label'], "?mod=$mod&file=$file&action=manage&function=$func");
	}
	$menu = adminmenu($LANG['label_manage'], $submenu);

	require_once PHPCMS_ROOT."/include/tree.class.php";
	$tree = new tree();

	require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
	$tag = new tag($mod);

	if(!$tag->writeable()) showmessage($LANG['template_dir_not_writeable']);
    if($action == 'add' || $action == 'edit' || $action == 'copy')
	{
		if(!isset($keyid)) $keyid = 1;
		require PHPCMS_ROOT.'/admin/'.$file.'_'.$action.'.inc.php';
		exit;
	}
}

switch($action)
{
    case 'list':
		$modules = array();
		foreach($MODULE as $key=>$m)
		{
			if(file_exists(PHPCMS_ROOT.'/'.moduledir($key).'/admin/tag.inc.php')) $modules[$key] = $m['name'];
		}
        require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/tags.php';
	    include admintpl('tag_list');
	    break;

	case 'quickoperate':
        require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/tags.php';
	    $tagname = preg_replace("/^[^{]*[{]?tag_([^}]+)[}]?.*/", "\\1", trim($tagname));
        if(!isset($tags[$tagname])) showmessage($LANG['label'].$LANG['not_exist'], $PHP_REFERER);
		$tag = $tags[$tagname];
		preg_match("/^(([a-z0-9]+)[_][a-z0-9_]*)[(]/", $tag, $m);
		$function = $m[1];
		$mod = $m[2];
		header('location:?mod='.$mod.'&file=tag&action='.$operate.'&function='.$function.'&job='.$job.'&tagname='.urlencode($tagname));
		break;

	case 'listtag':
		if($dosubmit)
	    {
			require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/tags.php';
			$content = stripslashes($content);
			preg_match_all("/[{]tag_([^}]+)[}]/", $content, $m);
			$listtags = $m[1];
			$listtags1 = $listtags2 = array();
			foreach($listtags as $tagname)
			{
				isset($tags[$tagname]) ? $listtags2[] = $tagname : $listtags1[] = $tagname;
			}
			$templateinfo = $templatename.($templatename ? '/' : '').$template;
		    include admintpl('tag_listtag','phpcms');
		}
		else
	    {
			$message = '<form name="myform" method="post" action="?mod=phpcms&file=tag&action=listtag&module='.$module.'&template='.$template.'&templatename='.$templatename.'&dosubmit=1"><input type="hidden" name="content"></form><script type="text/javascript">myform.content.value=window.opener.document.myform.content.value;myform.submit();</script>';
			showmessage($message);
		}
		break;

	case 'manage':
		$tags = $tag->get_tags_config($function);
		include admintpl('tag_manage','phpcms');
	    break;

	case 'preview':
		if($tag->exists($tagname) && !isset($tag_config))
		{
			$tag_config = $tag->get_tag_config($tagname);
			$eval = $tag_config['longtag'].';';
			$vars = get_var($eval);
			if($vars === 0 || is_defined($vars))
			{
		        include admintpl('tag_preview', 'phpcms');
			}
			else
			{
				parse_str($PHP_QUERYSTRING, $hiddens);
            	include admintpl('tag_preview_form', 'phpcms');
			}
		}
		else
		{
			$function or showmessage($LANG['function_name_not_null']);
			$tagname or showmessage($LANG['label_name_not_null']);
			@extract($tag_config);
			strpos($catid, '$catid') === FALSE or showmessage($LANG['contain_catid_cannot_preview'], 'goback');
			$eval = $function.'('.$tag_funcs[$function].');';
			include admintpl('tag_preview', 'phpcms');
		}
	    break;

	case 'delete':
		if(!$tag->exists($tagname)) showmessage($LANG['label']." $tagname ".$LANG['not_exist']);
		$tag->update($tagname , '');
		showmessage($LANG['operation_success'], "?mod=$mod&file=$file&channelid=$channelid&function=$function");
	    break;

	case 'checkname':
		if(empty($tagname))
		{
			$message = '<font color="red">'.$LANG['input_label_name'].'</font>';
		}
		else
		{
			if($tag->exists($tagname))
			{
				$message = '<font color="red">'.$LANG['label_name_exist_cannot_use_it'].'</font>';
			}
			else
			{
				$message = '<font color="blue">'.$LANG['label_name_not_exist_can_use'].'</font>';
			}
		}
		include admintpl('tag_checkname', 'phpcms');
	    break;

    case 'clear':

		dir_delete(PHPCMS_ROOT.'/data/tagscache/', 0);

		showmessage($LANG['label_cache_update_success']);
		break;

	case 'category_select':
		if($keyid && strpos($keyid, '$') === FALSE)
	    {
		    $catid = isset($catid) ? intval($catid) : 0;
			$CATEGORY = cache_read('categorys_'.$keyid.'.php');
			echo category_select('setcatid', '', $catid, 'onchange="myform.catid.value=this.value"');
		}
		else
	    {
			echo '<select name="setcatid"><option value="0"></option></select>';
		}
		break;

	case 'specialid_select':
	if($keyid && strpos($keyid, '$') === FALSE)
	    {	
			echo str_replace('<option value=\'0\'>1</option>','<option value="0">不限专题</option><option value=\'$specialid\'>$specialid</option>',special_select($keyid, 'specialid','1','','onchange="$(\'specialid\').value=this.value"'));
		}
		else
	{
				echo '<select name="setcatid" onchange="$(\'specialid\').value=this.value"><option value="0">不限专题</option><option value=\'$specialid\'>$specialid</option></select>';
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
			if(!$isset || ($var = '$channelid' && (!isset($CHANNEL[$channelid]) || ($MODULE[$mod]['iscopy'] && $CHANNEL[$channelid]['module'] != $mod)))) return FALSE;
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