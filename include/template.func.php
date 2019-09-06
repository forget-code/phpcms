<?php
function template_compile($module, $template, $istag = 0)
{
	$tplfile = TPL_ROOT.TPL_NAME.'/'.$module.'/'.$template.'.html';
	$content = @file_get_contents($tplfile);
	if($content === false) showmessage("$tplfile is not exists!");
	$compiledtplfile = TPL_CACHEPATH.$module.'_'.$template.'.tpl.php';
	$content = ($istag || substr($template, 0, 4) == 'tag_') ? '<?php function _tag_'.$module.'_'.$template.'($data, $number, $rows, $count, $page, $pages, $setting){ global $PHPCMS,$MODULE,$M,$CATEGORY,$TYPE,$AREA,$GROUP,$MODEL,$templateid,$_userid,$_username;@extract($setting);?>'.template_parse($content, 1).'<?php } ?>' : template_parse($content);
	$strlen = file_put_contents($compiledtplfile, $content);
	@chmod($compiledtplfile, 0777);
	return $strlen;
}

function template_refresh($tplfile, $compiledtplfile)
{
	$str = file_get_contents($tplfile);
	$str = template_parse($str);
	$strlen = file_put_contents($compiledtplfile, $str);
	@chmod($compiledtplfile, 0777);
	return $strlen;
}

function template_module($module)
{
	$files = glob(TPL_ROOT.TPL_NAME.'/'.$module.'/*.html');
	if(is_array($files))
	{
		foreach($files as $tpl)
		{
			$template = str_replace('.html', '', basename($tpl));
			template_compile($module, $template);
		}
	}
	return TRUE;
}

function template_cache()
{
    global $MODULE;
	foreach($MODULE as $module=>$m)
    {
        template_module($module);
	}
	return TRUE;
}

function template_block($blockid)
{
	$tplfile = TPL_ROOT.TPL_NAME.'/phpcms/block/'.$blockid.'.html';
	$compiledtplfile = TPL_CACHEPATH.'phpcms_block_'.$blockid.'.tpl.php';
	if(TPL_REFRESH && (!file_exists($compiledtplfile) || @filemtime($tplfile) > @filemtime($compiledtplfile)))
	{
		template_refresh($tplfile, $compiledtplfile);
	}
	return $compiledtplfile;
}

function template_parse($str, $istag = 0)
{
	$str = preg_replace("/([\n\r]+)\t+/s","\\1",$str);
	$str = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}",$str);
	$str = preg_replace("/\{template\s+(.+)\}/","<?php include template(\\1); ?>",$str);
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
	$str = preg_replace("/\{tag_([^}]+)\}/e", "get_tag('\\1')", $str);
	$str = preg_replace("/\{get\s+([^}]+)\}/e", "get_parse('\\1')", $str);
	$str = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "addquote('<?php echo \\1;?>')",$str);
	$str = preg_replace("/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>",$str);
	if(!$istag) $str = "<?php defined('IN_PHPCMS') or exit('Access Denied'); ?>".$str;
	return $str;
}

function get_tag($tagname)
{
	global $TAG;
    if(!isset($TAG)) $TAG = cache_read('tag.inc.php', TPL_ROOT.TPL_NAME.'/');
	return isset($TAG[$tagname]) ? '<?php echo '.$TAG[$tagname].';?>' : '{tag_'.$tagname.'}';
}

function addquote($var)
{
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}

function get_parse($str)
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
	if(!isset($urlrule)) $urlrule = '';
	if(!isset($catid)) $catid = 0;
	if(!isset($distinctfield)) $distinctfield = '';
	if(!isset($return) || !preg_match("/^\w+$/i", $return)) $return = 'r';
	if(isset($page))
	{
	    $str = "<?php \$ARRAY = get(\"$sql\", $rows, $page, \"$dbname\", \"$dbsource\", \"$urlrule\",\"$distinctfield\",\"$catid\");\$DATA=\$ARRAY['data'];\$total=\$ARRAY['total'];\$count=\$ARRAY['count'];\$pages=\$ARRAY['pages'];unset(\$ARRAY);foreach(\$DATA AS \$n=>\${$return}){\$n++;?>";
	}
	else
	{
		$str = substr($str, -1) == '/' ? "<?php \${$return} = get(\"$sql\", -1, 0, \"$dbname\", \"$dbsource\");?>" : "<?php \$DATA = get(\"$sql\", $rows, 0, \"$dbname\", \"$dbsource\");foreach(\$DATA AS \$n => \${$return}) { \$n++;?>";
	}
	return $str;
}
?>