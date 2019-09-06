<?php
defined('IN_PHPCMS') or exit('Access Denied');
function template_compile($module,$template)
{
	global $CONFIG;
	$content = file_get_contents(PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$module.'/'.$template.'.html');
	$content = template_parse($content);
	$compiledtplfile = $CONFIG['templatescachedir'].$module.'_'.$template.'.tpl.php';
	$strlen = file_put_contents($compiledtplfile, $content);
	@chmod($compiledtplfile, 0777);
	return $strlen;
}

function template_refresh($tplfile,$compiledtplfile)
{
	$str = file_get_contents($tplfile);
	$str = template_parse($str);
	$strlen = file_put_contents($compiledtplfile, $str);
	@chmod($compiledtplfile, 0777);
	return $strlen;
}

function template_module($module)
{
	global $CONFIG;
	$files = glob(PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$module.'/*.html');
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

function template_parse($str)
{
	$str = preg_replace("/([\n\r]+)\t+/s","\\1",$str);
	$str = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}",$str);
	$str = preg_replace("/\{template\s+(.+)\}/","\n<?php include template(\\1); ?>\n",$str);
	$str = preg_replace("/\{include\s+(.+)\}/","\n<?php include \\1; ?>\n",$str);
	$str = preg_replace("/\{php\s+(.+)\}/","\n<?php \\1?>\n",$str);
	$str = preg_replace("/\{if\s+(.+?)\}/","<?php if(\\1) { ?>",$str);
	$str = preg_replace("/\{else\}/","<?php } else { ?>",$str);
	$str = preg_replace("/\{elseif\s+(.+?)\}/","<?php } elseif (\\1) { ?>",$str);
	$str = preg_replace("/\{\/if\}/","<?php } ?>",$str);
	$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\}/","<?php if(is_array(\\1)) foreach(\\1 AS \\2) { ?>",$str);
	$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/","\n<?php if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>",$str);
	$str = preg_replace("/\{\/loop\}/","\n<?php } ?>\n",$str);
	$str = preg_replace("/\{tag_([^}]+)\}/e", "get_tag('\\1')", $str);
	$str = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "addquote('<?php echo \\1;?>')",$str);
	$str = preg_replace("/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>",$str);
	$str = "<?php defined('IN_PHPCMS') or exit('Access Denied'); ?>".$str;
	return $str;
}

function get_tag($tagname)
{
	global $tags,$html,$CONFIG;
    if(!$tags) require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/tags.php';
    if(!$html) require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/html.php';
	if(!isset($tags[$tagname])) return '{tag_'.$tagname.'}';
	$code = isset($html[$tagname]) ? 'tag_read('.$html[$tagname].')' : $tags[$tagname];	
	return "<?php echo $code;?>";	
}

function addquote($var)
{
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}
?>