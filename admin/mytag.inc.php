<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once PHPCMS_ROOT.'/include/template.func.php';

function mytag_compile($tagname)
{
	global $db;
	$result = $db->query("select tagname,content from ".TABLE_MYTAG." where tagname='$tagname' ");
	while($r = $db->fetch_array($result))
	{
		$r['content'] = template_parse($r['content']);
		file_put_contents(PHPCMS_ROOT.'/data/mytag/'.urlencode($r['tagname']).'.php', $r['content']);
	}
	return $db->num_rows($result);
}

$submenu = array
(
	array($LANG['add_my_label'], "?mod=".$mod."&file=".$file."&action=add&channelid=".$channelid),
	array($LANG['mylabel_manage'], "?mod=".$mod."&file=".$file."&action=manage&channelid=".$channelid)
);
$menu = adminmenu($LANG['module_manage'], $submenu);

require_once PHPCMS_ROOT.'/admin/include/tag.class.php';
$tag = new tag($mod);

$tag_funcs = array(
	'phpcms_mytag'=>'$mytagname'
);

$functions = array('phpcms_mytag'=>$LANG['mylable']);

$function = isset($function) ? $function : 'phpcms_mytag';
if(!$action) $action = 'manage';
switch($action)
{
	case 'add':
		if($dosubmit)
		{
			$tagname or showmessage($LANG['lable_name_not_null']);
			if($tag->exists($tagname)) showmessage($LANG['label']." $tagname ".$LANG['exist_change_name'],"goback");
			$tag_config['mytagname'] = $tagname;
			$tag->update($tagname , $tag_config, $function.'('.$tag_funcs[$function].')');
			
			$db->query("INSERT INTO ".TABLE_MYTAG." (tagname, content) VALUES ('$tagname', '$content')");
			$tagid = $db->insert_id();
			mytag_compile($tagname);
			showmessage($LANG['add_mylabel_success'],"?mod=".$mod."&file=".$file."&action=manage&channelid=".$channelid);
		}
		else
		{
			include admintpl('mytag_add');
		}
		break;

	case 'edit':
		if($dosubmit)
		{
			if(empty($content))
			{
				showmessage($LANG['fillin_completely'],"?mod=".$mod."&file=".$file."&action=manage&channelid=".$channelid);
			}
			$tagname or showmessage($LANG['lable_name_not_null'],"goback");
			if(!$tag->exists($tagname)) showmessage($LANG['label']." $tagname ".$LANG['exist_change_name'],"goback");
			$tag_config['mytagname'] = $tagname;
			$tag->update($tagname , $tag_config, $function.'('.$tag_funcs[$function].')');

			$db->query("UPDATE ".TABLE_MYTAG." SET content='$content' WHERE tagname='$tagname'");
			mytag_compile($tagname);
			showmessage($LANG['edit_mylabel_success'],"?mod=".$mod."&file=".$file."&action=manage&channelid=".$channelid);
		}
		else
		{
			$tag_config = $tag->get_tag_config($tagname);
			$r = $db->get_one("select * from ".TABLE_MYTAG." where tagname='$tagname'");
			@extract($r);
			include admintpl('mytag_edit');
		}
		break;

	default:
		if($action == 'delete') $db->query("DELETE FROM ".TABLE_MYTAG." WHERE tagname='$tagname'");
		include PHPCMS_ROOT.'/admin/tag.inc.php';
}
?>