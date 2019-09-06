<?php
function template_edit_compile($module, $template, $istag = 0)
{
	$tplfile = TPL_ROOT.TPL_NAME.'/'.$module.'/'.$template.'.html';
	$content = @file_get_contents($tplfile);
	if($content === false) showmessage("$tplfile is not exists!");
	$compiledtplfile = TPL_CACHEPATH.$module.'_'.$template.'.edit.php';
	$content = ($istag || substr($template, 0, 4) == 'tag_') ? '<?php function _tag_'.$module.'_'.$template.'($data, $number, $rows, $count, $page, $pages, $setting){ global $PHPCMS,$MODULE,$M,$CATEGORY,$TYPE,$AREA,$GROUP,$MODEL,$templateid,$_userid,$_username;@extract($setting);?>'.template_edit_parse($content, 1).'<?php } ?>' : template_edit_parse($content);
	$strlen = file_put_contents($compiledtplfile, $content);
	@chmod($compiledtplfile, 0777);
	return $strlen;
}

function template_edit_parse($str, $istag = 0)
{
	global $file, $action;
	$str = preg_replace("/([\n\r]+)\t+/s","\\1",$str);
	$str = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}",$str);
	$str = preg_replace("/\{template\s+(.+)\}/","<?php include admin_template(\\1); ?>",$str);
	$str = preg_replace("/\{include\s+(.+)\}/","<?php include \\1; ?>",$str);
	$str = preg_replace("/\{php\s+(.+)\}/","<?php \\1?>",$str);
	$str = preg_replace("/\{if\s+(.+?)\}/","<?php if(\\1) { ?>",$str);
	$str = preg_replace("/\{else\}/","<?php } else { ?>",$str);
	$str = preg_replace("/\{elseif\s+(.+?)\}/","<?php } elseif (\\1) { ?>",$str);
	$str = preg_replace("/\{\/if\}/","<?php } ?>",$str);
	$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\}/","<?php if(is_array(\\1)) foreach(\\1 AS \\2) { ?>",$str);
	$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/","<?php if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>",$str);
	$str = preg_replace("/\{\/loop\}/","<?php } ?>",$str);
	$str = preg_replace("/\{\/get\}/","<?php } unset(\$DATA); ?>",$str);
    if($file.'-'.$action == 'template-tag')
	{
		$str = preg_replace("/\{tag_([^}]+)\}/e", "get_edit_tag('\\1')", $str);
		$str = preg_replace("/\{block\((.+)\)\}/e", "get_block('\\1')", $str);
	}
	else
	{
		$str = preg_replace("/\{tag_([^}]+)\}/e", "get_edit_tag('\\1')", $str);
		$str = preg_replace("/\{block\((.+)\)\}/", "{block_edit(\\1)}", $str);
	}
	$str = preg_replace("/\{get\s+([^}]+)\}/e", "get_edit_parse('\\1')", $str);
	$str = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "addquote_edit('<?php echo \\1;?>')",$str);
	$str = preg_replace("/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>",$str);
	if(!$istag) $str = "<?php defined('IN_PHPCMS') or exit('Access Denied'); ?>".$str;
	return $str;
}

function template_edit_block($blockid)
{
	$tplfile = TPL_ROOT.TPL_NAME.'/phpcms/block/'.$blockid.'.html';
	$compiledtplfile = TPL_CACHEPATH.'phpcms_block_'.$blockid.'.tpl.php';
	if(TPL_REFRESH && (!file_exists($compiledtplfile) || @filemtime($tplfile) > @filemtime($compiledtplfile)))
	{
		$str = file_get_contents($tplfile);
		$str = template_edit_parse($str);
		$strlen = file_put_contents($compiledtplfile, $str);
		@chmod($compiledtplfile, 0777);
	}
	return $compiledtplfile;
}

function get_edit_tag($tagname)
{
	global $TAG, $file, $action, $module;
    if(!isset($TAG)) $TAG = cache_read('tag.inc.php', TPL_ROOT.TPL_NAME.'/');
	if(isset($TAG[$tagname]))
	{
		preg_match("/^tag\(\'([0-9a-z_-]+)\'/", $TAG[$tagname], $m);
		$module = $m[1];
		if($file.'-'.$action == 'template-tag' && strpos($TAG[$tagname], '$') !== false)
		{
			$data = '<div class="show_tag" module="'.$module.'" tagname="'.$tagname.'" forward="'.urlencode(URL).'">{tag_'.$tagname.'}</div>';
		}
		else
		{
			preg_match("/select(.*)\"/i",$TAG[$tagname],$mn);
			$data = "<div id='tag_$tagname'>";
			if(strpos($mn[0], '$')===false)
			{
				$data .= '<?php echo '.$TAG[$tagname].';?>';
			}
			else
			{
				preg_match_all("/(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/", $TAG[$tagname], $matches, PREG_PATTERN_ORDER);
				$vars = '';
				foreach($matches[1] as $var)
				{
					if($var !== '$page') $vars .= "&& isset($var)";
				}
				$vars = substr($vars, 3);
				$data .= '<?php if('.$vars.') echo '.$TAG[$tagname].';?>';
			}
			$data .= "</div><div class='tag_float_div' id='tag_float_div_$tagname' tagname='$tagname' module='$module' title='点击修改中文标签“{tag_".$tagname."}”'></div>";
		}
	}
	else
	{
		$data = '{tag_'.$tagname.'}';
	}
	return $data;
}

function addquote_edit($var)
{
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}

function get_edit_parse($str)
{
	preg_match_all("/([a-z]+)\=\"([^\"]+)\"/i", stripslashes($str), $matches, PREG_SET_ORDER);
	foreach($matches as $v)
	{
		$r[$v[1]] = $v[2];
	}
	extract($r);
	if(!isset($dbsource)) $dbsource = '';
	if(!isset($dbname)) $dbname = '';
	if(!isset($sql)) $sql = '';
	if(!isset($rows)) $rows = 0;
	if(!isset($return) || !preg_match("/^\w+$/i", $return)) $return = 'r';
	if(isset($page))
	{
	    $str = "<?php \$ARRAY = get(\"$sql\", $rows, $page, \"$dbname\", \"$dbsource\");\$DATA=\$ARRAY['data'];\$total=\$ARRAY['total'];\$count=\$ARRAY['count'];\$pages=\$ARRAY['pages'];unset(\$ARRAY);foreach(\$DATA AS \$n=>\${$return}){\$n++;?>";
	}
	else
	{
		$str = substr($str, -1) == '/' ? "<?php \${$return} = get(\"$sql\", -1, 0, \"$dbname\", \"$dbsource\");?>" : "<?php \$DATA = get(\"$sql\", $rows, 0, \"$dbname\", \"$dbsource\");foreach(\$DATA AS \$n => \${$return}) { \$n++;?>";
	}
	return $str;
}

function get_block($str)
{
	$str = stripslashes($str);
	if(strpos($str, '$') !== false) return '<div class="show_block">block('.$str.')</div>';
	return "{block_edit($str)}";
}

function block_edit($pageid, $blockno)
{
	global $db,$priv_role;
	$array = array();
	$result = $db->query("SELECT * FROM `".DB_PRE."block` WHERE `pageid`='$pageid' AND `blockno`='$blockno' AND `disabled`=0 ORDER BY `listorder`");
	while($r = $db->fetch_array($result))
	{
		if($r['isarray']) $r['data'] = string2array($r['data']);
		$array[] = $r;
	}
	$db->free_result($result);
	foreach($array as $r)
	{
		$is_priv = $priv_role->check('blockid', $r['blockid']);
		if($is_priv) echo '<div id="block_'.$r['blockid'].'">';
		block_edit_data($r);
        if($is_priv) echo '</div><div id="float_div_'.$r['blockid'].'" class="block_float_div jqModal" style="display:none" blockid="'.$r['blockid'].'" blockname="'.htmlspecialchars($r['name']).'" forward="'.urlencode(URL).'" title="点击修改碎片“'.$r['name'].'”"></div>';
	}
	echo '<div id="block_add_'.$pageid.'_'.$blockno.'" class="block_add" pageid="'.$pageid.'" blockno="'.$blockno.'">添加碎片</div>';
}

function block_edit_data($r)
{
	if(!is_array($r)) return false;
	extract($r);
	if($isarray)
	{
		include template_edit_block($blockid);
	}
	else
	{
		echo $data;
	}
}
?>