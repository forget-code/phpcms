<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function showmessage($msg, $url_forward = 'goback', $ms=1250)
{
	global $CONFIG,$PHPCMS,$debuginfo;
	$templatefile = defined('IN_ADMIN') ? PHPCMS_ROOT.'/admin/templates/showmessage.tpl.php' : template('phpcms','showmessage');
	include $templatefile;
    exit;
}

function new_htmlspecialchars($string)
{
    return is_array($string) ? array_map('new_htmlspecialchars', $string) : htmlspecialchars($string,ENT_QUOTES);
}

function new_addslashes($string)
{
	if(!is_array($string)) return addslashes($string);
	foreach($string as $key => $val) $string[$key] = new_addslashes($val);
	return $string;
}

function new_stripslashes($string)
{
	if(!is_array($string)) return stripslashes($string);
	foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
	return $string;
}

function filter_xss($string, $allowedtags = '', $disabledattributes = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'))
{
	if(is_array($string))
	{
		foreach($string as $key => $val) $string[$key] = filter_xss($val, ALLOWED_HTMLTAGS);
	}
	else
	{
		$string = preg_replace('/\s('.implode('|', $disabledattributes).').*?([\s\>])/', '\\2', preg_replace('/<(.*?)>/ie', "'<'.preg_replace(array('/javascript:[^\"\']*/i', '/(".implode('|', $disabledattributes).")[ \\t\\n]*=[ \\t\\n]*[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", strip_tags($string, $allowedtags)));
	}
	return $string;
}

function strip_sql($string)
{
	global $search_arr,$replace_arr;
	return is_array($string) ? array_map('strip_sql', $string) : preg_replace($search_arr, $replace_arr, $string);
}

function strip_textarea($string)
{
	return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($string, ENT_QUOTES)));
}

function strip_js($string, $js = 1)
{
	$string = str_replace(array("\n","\r","\""),array('','',"\\\""),$string);
	return $js==1 ? "document.write(\"".$string."\");\n" : $string;
}

function str_safe($string)
{
	$searcharr = array("/(javascript|jscript|js|vbscript|vbs|about):/i","/on(mouse|exit|error|click|dblclick|key|load|unload|change|move|submit|reset|cut|copy|select|start|stop)/i","/<script([^>]*)>/i","/<iframe([^>]*)>/i","/<frame([^>]*)>/i","/<link([^>]*)>/i","/@import/i");
	$replacearr = array("\\1\n:","on\n\\1","&lt;script\\1&gt;","&lt;iframe\\1&gt;","&lt;frame\\1&gt;","&lt;link\\1&gt;","@\nimport");
	$string = preg_replace($searcharr,$replacearr,$string);
	$string = str_replace("&#","&\n#",$string);
	return $string;
}

function random($length, $chars = '0123456789')
{
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++)
	{
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

function mkcookie($var, $value = '', $time = 0)
{
	global $CONFIG,$PHP_TIME;
	$time = $time > 0 ? $time : (empty($value) ? $PHP_TIME - 3600 : 0);
	$s = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
	$var = $CONFIG['cookiepre'].$var;
	return setcookie($var, $value, $time, $CONFIG['cookiepath'], $CONFIG['cookiedomain'], $s);
}

function getcookie($var)
{
	global $CONFIG;
	$var = $CONFIG['cookiepre'].$var;
	return isset($_COOKIE[$var]) ? $_COOKIE[$var] : FALSE;
}

if(!function_exists('file_put_contents'))
{
	define('FILE_APPEND', 8);
	function file_put_contents($file, $string, $append = '')
	{
		$mode = $append == '' ? 'wb' : 'ab';
		$fp = @fopen($file, $mode) or exit("Can not open file $file !");
		flock($fp, LOCK_EX);
		$stringlen = @fwrite($fp, $string);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $stringlen;
	}
}

function file_down($file, $filename = '')
{
	global $PHP_TIME;
	if(!file_exists($file)) showmessage("The file $file is not exists !");
	$filename = $filename ? $filename : basename($file);
	$filetype = fileext($filename);
	$filesize = filesize($file);
    ob_end_clean();
	@set_time_limit(900);
	header('Cache-control: max-age=31536000');
	header('Expires: '.gmdate('D, d M Y H:i:s', $PHP_TIME + 31536000).' GMT');
	header('Content-Encoding: none');
	header('Content-Length: '.$filesize);
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Type: '.$filetype);
	readfile($file);
	exit;
}

function phpcache($is_js = 0)
{
	global $CONFIG,$cachefiledir,$cachefile;
    if(!$is_js && $CONFIG['phpcache'] != '2') return FALSE;
	$contents = ob_get_clean();
	if($is_js) $contents = strip_js($contents);
	if($CONFIG['phpcache'] == '2' && $cachefiledir && $cachefile)
	{
		dir_create($cachefiledir);
		file_put_contents($cachefile, $contents);
		@chmod($cachefile, 0777);
	}
	header('Expires: Mon, 26 Jul 2000 05:00:00 GMT'); 
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); 
	header('Cache-Control: no-cache, must-revalidate'); 
	header('Pragma: no-cache');
	echo $contents;
}

function cache_read($file, $mode = 'i')
{
	$cachefile = PHPCMS_CACHEDIR.$file;
	if(!file_exists($cachefile)) return array();
	return $mode == 'i' ? include $cachefile : file_get_contents($cachefile);
}

function cache_write($file, $string, $type = 'array')
{
	if(is_array($string))
	{
		$type = strtolower($type);
		if($type == 'array')
		{
			$string = "<?php\n return ".var_export($string,TRUE).";\n?>";
		}
		elseif($type == 'constant')
		{
			$data='';
			foreach($string as $key => $value) $data .= "define('".strtoupper($key)."','".addslashes($value)."');\n";
			$string = "<?php\n".$data."\n?>";
		}
	}
	$strlen = file_put_contents(PHPCMS_CACHEDIR.$file, $string);
	chmod(PHPCMS_CACHEDIR.$file, 0777);
	return $strlen;
}

function cache_delete($file)
{
	return @unlink(PHPCMS_CACHEDIR.$file);
}

function phpcms_auth($txt, $operation = 'ENCODE', $key = '')
{
	$key = $key ? $key : $GLOBALS['phpcms_auth_key'];
	require_once PHPCMS_ROOT.'/include/auth.func.php';
    return $operation=='ENCODE' ? phpcms_encode($txt, $key) : phpcms_decode($txt, $key);
}

function createhtml($filename, $mod_root = '')
{
    global $TEMP;
	if(!defined('CREATEHTML')) define('CREATEHTML', 1);
    @extract($GLOBALS, EXTR_SKIP);
	if(!$mod_root) $mod_root = defined('MOD_ROOT') ? MOD_ROOT : PHPCMS_ROOT;
    include $mod_root.'/include/createhtml/'.$filename.'.php';
}

function template($module = 'phpcms', $template = 'index')
{
	global $CONFIG;
	$compiledtplfile = $CONFIG['templatescachedir'].$module.'_'.$template.'.tpl.php';
	if($CONFIG['templaterefresh'])
	{
        $tplfile = PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/'.$module.'/'.$template.'.html';
        if(!file_exists($compiledtplfile) || @filemtime($tplfile) > @filemtime($compiledtplfile))
		{
			require_once PHPCMS_ROOT.'/include/template.func.php';
			template_refresh($tplfile, $compiledtplfile);
		}
	}
	return $compiledtplfile;
}

function str_cut($string, $length, $dot = ' ...')
{
	global $CONFIG;
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	$string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;'), array(' ', '&', '"', "'", '“', '”', '—', '<', '>'), $string);
	$strcut = '';
	if(strtolower($CONFIG['charset']) == 'utf-8')
	{
		$n = $tn = $noc = 0;
		while($n < $strlen)
		{
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) break;
		}
		if($noc > $length) $n -= $tn;
		$strcut = substr($string, 0, $n);
	}
	else
	{
		$dotlen = strlen($dot);
		$maxi = $length - $dotlen - 1;
		for($i = 0; $i < $maxi; $i++)
		{
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	$strcut = str_replace(array('&', '"', "'", '<', '>'), array('&amp;', '&quot;', '&#039;', '&lt;', '&gt;'), $strcut);
	return $strcut.$dot;
}

function reword($content)
{
	global $TEMP;
	if(!isset($TEMP['rewords']['enable']))
	{
		$rewords = cache_read('cache_reword.php');
		$TEMP['rewords']['enable'] = $rewords ? 1 : 0;
	    if(!$TEMP['rewords']['enable']) return $content;
		$word = $replacement = array();
		foreach($rewords as $v)
		{
			$word[] = $v['word'];
			$replacement[] = $v['replacement'];
		}
        $TEMP['rewords']['word'] = $word;
        $TEMP['rewords']['replacement'] = $replacement;
	}
	if(!$TEMP['rewords']['enable']) return $content;
	return str_replace($TEMP['rewords']['word'], $TEMP['rewords']['replacement'], $content);
}

function keylink($content)
{
	return substr(preg_replace_callback("/>([^><]+)</", "keylink_callback", '>'.$content.'<'), 1, -1);
}

function keylink_callback($matches) 
{
	global $TEMP;
	if(!isset($TEMP['keylinks']['enable']))
	{
		$keylinks = cache_read('cache_keylink.php');
		$TEMP['keylinks']['enable'] = $keylinks ? 1 : 0;
	    if(!$TEMP['keylinks']['enable']) return '>'.$matches[1].'<';
		$word = $replacement = array();
		foreach($keylinks as $v)
		{
			$word[] = $v['linktext'];
			$replacement[] = '<a href="'.$v['linkurl'].'" target="_blank" class="keylink">'.$v['linktext'].'</a>';
		}
        $TEMP['keylinks']['word'] = $word;
        $TEMP['keylinks']['replacement'] = $replacement;
	}
	if(!$TEMP['keylinks']['enable']) return '>'.$matches[1].'<';
	return '>'.str_replace($TEMP['keylinks']['word'], $TEMP['keylinks']['replacement'], $matches[1]).'<';
}

function ip_banned($ip)
{
	global $PHP_TIME;
	$ipbanneds = cache_read('banip.php');
	if(!is_array($ipbanneds)) return FALSE;
	foreach($ipbanneds as $v)
	{
		if($v['overtime'] < $PHP_TIME) return FALSE;
		if($ip == $v['ip'] || preg_match("/^".str_replace('.', '[.]', $v['ip'])."$/", $ip)) return TRUE;
	}
}

function is_email($email)
{
	return strlen($email) > 8 && preg_match("/^[-_+.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+([a-z]{2,4})|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email);
}

function is_date($date, $sep='-') 
{
	if(empty($date)) return FALSE;
	if(strlen($date) > 10)  return FALSE;
	list($year, $month, $day) = explode($sep, $date);
	return @checkdate($month, $day, $year);
}

function numberval($number, $precision = 2)
{
	if(!is_numeric($number) || substr_count($number, '.') > 1) return FALSE;
	return sprintf('%.'.$precision.'f', round(floatval($number), $precision));
}

function dir_path($dirpath)
{
	$dirpath = str_replace('\\', '/', $dirpath);
	if(substr($dirpath, -1) != '/') $dirpath = $dirpath.'/';
	return $dirpath;
}

function dir_create($path, $mode = 777)
{
    global $PHPCMS, $ftp;
	if(is_dir($path)) return TRUE;
    if($PHPCMS['enableftp'] && !is_object($ftp)) require_once PHPCMS_ROOT.'/include/ftp.inc.php';
	$dir = str_replace(PHPCMS_ROOT.'/', '', $path);
	$dir = dir_path($dir);
    $temp = explode('/', $dir);
    $cur_dir = PHPCMS_ROOT.'/';
	$max = count($temp) - 1;
    for($i=0; $i<$max; $i++)
    {
        $cur_dir .= $temp[$i].'/';
        if(is_dir($cur_dir)) continue;
		if($PHPCMS['enableftp'])
		{
		    $ftp->mkdir($cur_dir);
		}
		else
		{
		    mkdir($cur_dir);
			@chmod($cur_dir, 0777);
		}
    }
	return $PHPCMS['enableftp'] ? TRUE : is_dir($path);           
}

function phppages($total, $page = 1, $perpage = 20, $url = '')
{
	global $PHP_URL,$LANG;
	if(!$url) $url = preg_replace("/(.*)([&?]page=[0-9]*)(.*)/i", "\\1\\3", $PHP_URL);
	$s = strpos($url, '?') === FALSE ? '?' : '&';
	$pages = ceil($total/$perpage);
	$page = min($pages,$page);
	$prepg = $page-1;
	$nextpg = $page == $pages ? 0 : ($page+1);
	if($total < 1) return FALSE;
	$pagenav = $LANG['total']."<b>$total</b>&nbsp;&nbsp;&nbsp;&nbsp;";
	$pagenav .= $prepg ? "<a href='$url{$s}page=1'>".$LANG['first']."</a>&nbsp;<a href='$url{$s}page=$prepg'>".$LANG['previous']."</a>&nbsp;" : $LANG['first']."&nbsp;".$LANG['previous']."&nbsp;";
	$pagenav .= $nextpg ? "<a href='$url{$s}page=$nextpg'>".$LANG['next']."</a>&nbsp;<a href='$url{$s}page=$pages'>".$LANG['last']."</a>&nbsp;" : $LANG['next']."&nbsp;".$LANG['last']."&nbsp;";
	$pagenav .= $LANG['page'].": <b><font color=red>$page</font>/$pages</b>&nbsp;&nbsp;<input type='text' name='page' id='page' class='page' size='2' onKeyDown=\"if(event.keyCode==13) {window.location='{$url}{$s}page='+this.value; return false;}\"> <input type='button' value='GO' class='gotopage' style='width:30px' onclick=\"window.location='{$url}{$s}page='+$('page').value\">\n";
	return $pagenav;
}

function fileext($filename)
{
	return trim(substr(strrchr($filename, '.'), 1));
}

function channel_table($name, $channelid)
{
	global $CONFIG;
	return $CONFIG['tablepre'].$name.'_'.$channelid;
}

function show_type($keyid, $typeid)
{
	global $CHANNEL, $MODULE, $TYPE, $TEMP;
	if(!$typeid) return '';
	if(!isset($TYPE[$typeid])) $TYPE = isset($TEMP['type'][$keyid]) ? $TEMP['type'][$keyid] : $TEMP['type'][$keyid] = cache_read('type_'.$keyid.'.php');
	$linkurl = is_numeric($keyid) ? $CHANNEL[$keyid]['linkurl'] : $MODULE[$keyid]['linkurl'];
	return '<a href="'.linkurl($linkurl).'type.php?typeid='.$typeid.'">'.style($TYPE[$typeid]['name'], $TYPE[$typeid]['style']).'</a>';
}

function channel_setting($channelid)
{
	global $CHA, $CATEGORY, $TEMP;
	if(isset($TEMP['cha'][$channelid]) && isset($TEMP['category'][$channelid]))
	{
		$CHA = $TEMP['cha'][$channelid];
		$CATEGORY = $TEMP['category'][$channelid];
	}
	else
	{
		$CHA = $TEMP['cha'][$channelid] = cache_read('channel_'.$channelid.'.php');
		$CATEGORY = $TEMP['category'][$channelid] = cache_read('categorys_'.$channelid.'.php');
	}
}

function linkurl($linkurl, $isabs = 0)
{
	global $PHP_SITEURL;
	if(strpos($linkurl, '://') !== FALSE || $linkurl[0] == '?') return $linkurl;
    if($isabs || defined('SHOWJS'))
	{
		return strpos($linkurl, PHPCMS_PATH) === 0 ? $PHP_SITEURL.substr($linkurl, strlen(PHPCMS_PATH)) : $PHP_SITEURL.$linkurl;
	}
	else
	{
		return strpos($linkurl, PHPCMS_PATH) === 0 ? $linkurl : PHPCMS_PATH.$linkurl;
	}
}

function imgurl($imgurl = '', $isabs = 0)
{
	$imgurl = $imgurl == '' ? 'images/nopic.gif' : $imgurl;
	return linkurl($imgurl, $isabs);
}

function style($title, $style = '')
{
	return $style == '' ? $title : "<samp style=\"$style\">$title</samp>";
}

function checkcode($checkcode, $enable = 1, $forward = '')
{
	global $LANG, $session;
	if(!$enable) return TRUE;
	if(!is_object($session)) $session = new phpcms_session();
	if(!isset($_SESSION['checkcode'])) showmessage($LANG['do_not_refresh'], $forward);
	if(strtolower($_SESSION['checkcode']) != strtolower($checkcode))
	{
		unset($_SESSION['checkcode']);
		showmessage($LANG['checkcode_error'], $forward);
	}
	unset($_SESSION['checkcode']);
}

function editor($textareaid = 'content', $toolbar = 'phpcms', $width = 500, $height = 400, $editorName = 'editor')
{
	global $CONFIG, $channelid, $mod, $iseditorinit,$PHPCMS,$CHA;
	if(!$PHPCMS['enableeditor']) return FALSE;
	$module = $mod ? $mod : 'phpcms';
	if($toolbar == 'editor')
	{
		$editorKeyid = $channelid ? $channelid : $module;
		$editorCss = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$CONFIG['defaultskin'].'/style.css';
		if(substr($width,-1) == '%') $width = 550;
		if($width < 380) $width = 380;
		include PHPCMS_ROOT.'/editor/'.$editorName.'.php';
	}
	else
	{
		$editorinit = '';
		if(!$iseditorinit)
		{
			$iseditorinit = 1;
			$module = $mod ? $mod : 'phpcms';
			$channelid = $channelid ? $channelid : 0;
			$editorinit = "var Module = \"".$module."\"; var ChannelId = ".$channelid.";";
		}
		return "\n<script language=\"JavaScript\" type=\"text/JavaScript\">".$editorinit."document.getElementById('".$textareaid."').style.display=\"none\";</script>
				<input type=\"hidden\" id=\"".$textareaid."___Config\" value=\"FullPage=false\" style=\"display:none\" />
				<iframe id=\"".$textareaid."___Frame\" src=\"".PHPCMS_PATH."fckeditor/editor/fckeditor.html?InstanceName=".$textareaid."&amp;Toolbar=".$toolbar."\" width=\"".$width."\" height=\"".$height."\" frameborder=\"no\" scrolling=\"no\"></iframe>\n";
	}
}
function date_select($name, $value = '', $format = '%Y-%m-%d')
{
	global $iscalendarinit;
	if($value == '0000-00-00 00:00:00') $value = '';
	$id = str_replace(array('[',']'), array('',''), $name);
	if($format == '%Y-%m-%d')
	{
		$size = 10;
		$showsTime = 'false';
	}
	else
	{
		$size = 20;
		$showsTime = 'true';
	}
	$str = '';
	if(!$iscalendarinit)
	{
		$iscalendarinit = 1;
		$str .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".PHPCMS_PATH."include/calendar/calendar-blue2.css\" title=\"system\" />";
		$str .= "<script type=\"text/javascript\" src=\"".PHPCMS_PATH."include/calendar/calendar.js\"></script>";
		$str .= "<script type=\"text/javascript\" src=\"".PHPCMS_PATH."include/calendar/calendar-zh.js\"></script>";
		$str .= "<script type=\"text/javascript\" src=\"".PHPCMS_PATH."include/calendar/calendar-setup.js\"></script>";
	}
	$str .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" size="'.$size.'" readonly>&nbsp;';
	$str .= '<script language="javascript" type="text/javascript">date = new Date();document.getElementById ("'.$id.'").value="'.$value.'";
    Calendar.setup({
        inputField     :    "'.$id.'",
        ifFormat       :    "'.$format.'",
        showsTime      :    '.$showsTime.',
        timeFormat     :    "24"
    });</script>';
	return $str;
}

function subcat($keyid = 1, $catid = 0, $type = 'menu')
{
	global $CATEGORY, $TEMP;
	if(!isset($CATEGORY) || !isset($TEMP['category'][$keyid]))
	{
		$_CATEGORY = isset($TEMP['category'][$keyid]) ? $TEMP['category'][$keyid] : $TEMP['category'][$keyid] = cache_read('categorys_'.$keyid.'.php');
	}
	else
	{
		$_CATEGORY = $CATEGORY;
	}
	if(!$_CATEGORY) return array();
	$subcat = array();
	foreach($_CATEGORY as $id=>$cat)
	{
		if($cat['parentid'] == $catid)
		{
			if(!$cat['ismenu']) continue;
			if(defined('SHOWJS')) $cat['linkurl'] = linkurl($cat['linkurl']);
			if($type == 'menu')
			{
				$subcat[] = $cat; 
			}
			elseif($type == 'list')
			{
				if(!$cat['islink'] && $cat['islist']) $subcat[] = $cat; 
			}
		}
	}
	return $subcat;
}

function catpos($catid, $s = ' >> ')
{
	global $CATEGORY, $MODULE, $channelid, $mod;
	if(!isset($CATEGORY[$catid]))
	{
		$keyid = $MODULE[$mod]['iscopy'] ? $channelid : $mod;
		$CATEGORY = isset($TEMP['category'][$keyid]) ? $TEMP['category'][$keyid] : $TEMP['category'][$keyid] = cache_read('categorys_'.$keyid.'.php');
	}
    $arrparentid = $CATEGORY[$catid]['arrparentid'];
	$arrparentid = explode(',', $arrparentid);
	if($catid) $arrparentid[] = $catid;
	$pos = '';
	foreach($arrparentid as $pcatid)
	{
		if($pcatid == 0 || !isset($CATEGORY[$pcatid])) continue;
		$catname = $CATEGORY[$pcatid]['catname'];
		$linkurl = $CATEGORY[$pcatid]['linkurl'];
		$pos .= '<a href="'.$linkurl.'">'.$catname.'</a>'.$s;
	}
	return $pos;
}

function menu($module, $position, $username = '')
{
	global $db,$_groupid,$_arrgroupid,$_grade;
	$sql = $username ? " AND username='$username' " : '';
	$menus = array();
	$result = $db->query("SELECT * FROM ".TABLE_MENU." WHERE position='$position' $sql ORDER BY listorder", "CACHE",86400);
	while($r = $db->fetch_array($result))
	{
		if($r['arrgroupid'])
		{
			$arrgroupid = explode(',', $r['arrgroupid']);
			if(!in_array($_groupid, $arrgroupid) && !array_intersect($_arrgroupid, $arrgroupid)) continue;
		}
		if(defined('IN_ADMIN') && $r['arrgrade'] !== '')
		{
			$arrgrade = explode(',', $r['arrgrade']);
			if(!in_array($_grade, $arrgrade)) continue;
		}
		$r['url'] = linkurl($r['url']);
		$menus[] = $r;
	}
	$db->free_result($result);
	include template($module, $position);
}

function moduledir($module)
{
	global $MODULE;
	if($module == 'phpcms') return '';
	return ($MODULE[$module]['iscopy'] ? 'module/' : '').$MODULE[$module]['moduledir'];
}

function tag_write($keyid, $name)
{
	global $mod,$channelid;
	ob_start();
	tag_data($keyid, $name);
	$data = ob_get_contents();
	ob_clean();
	$dir = PHPCMS_ROOT.'/data/tagscache/'.$keyid.'/';
	$file = $dir.$mod.'_'.$channelid.'_'.urlencode($name).'.html';
	dir_create($dir);
	file_put_contents($file, $data);
	@chmod($file, 0777);
	return $data;
}

function tag_read($keyid, $name)
{
	global $CONFIG,$PHP_TIME;
	if(!isset($keyid) || !$keyid) return '<span style="color:red">$keyid undefined</span>';
	if(defined('CREATEHTML') || $CONFIG['phpcache'] != '1') return tag_data($keyid, $name);
	$file = PHPCMS_ROOT.'/data/tagscache/'.$keyid.'/'.urlencode($name).'.html';
	if(!file_exists($file) || (filemtime($file) < $PHP_TIME - $CONFIG['phpcacheexpires'])) return tag_write($keyid, $name);
	include $file;
}

function tag_data($keyid, $name)
{
	global $tags,$mod,$MODULE,$CHANNEL,$CONFIG;
    if(!$tags) require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/tags.php';
    if(is_numeric($keyid))
	{
		$channelid = intval($keyid);
		$module = $CHANNEL[$channelid]['module'];
	}
	else
	{
		$channelid = $GLOBALS['channelid'];
		$module = $keyid;
	}
    if(isset($MODULE[$module]))
	{
		require_once PHPCMS_ROOT.'/'.moduledir($module).'/include/tag.func.php';
		eval($tags[$name].';');
	}
}

function itemurl($keyid, $itemid)
{
	global $db,$CONFIG,$CHANNEL;
    if(is_numeric($keyid))
	{
		$channelid = intval($keyid);
		$module = $CHANNEL[$channelid]['module'];
		$table = $CONFIG['tablepre'].$module.'_'.$channelid;
	}
	else
	{
		$module = $keyid;
		$table = $CONFIG['tablepre'].$module;
	}
	$idfield = $module.'id';
	$r = $db->get_one("SELECT linkurl FROM $table WHERE $idfield=$itemid");
	return linkurl($r['linkurl']);
}

function tpl_data($module = 'phpcms', $template = 'index')
{
	@extract($GLOBALS, EXTR_SKIP);
	ob_start();
	include template($module, $template);
	$data = ob_get_contents();
	ob_clean();
	return $data;
}

function check_purview($groupids = '')
{
	global $_groupid,$_arrgroupid;
	if(empty($groupids) || $_groupid == 1) return TRUE;
	$groupids = explode(',', $groupids);
	return in_array($_groupid, $groupids) || array_intersect($_arrgroupid, $groupids);
}

function phpcms_error($errno, $errmsg, $filename, $linenum, $vars)
{
	$filename = str_replace(PHPCMS_ROOT, '.', $filename);
    $filename = str_replace("\\", '/', $filename);
    if(!defined('E_STRICT')) define('E_STRICT', 2048);
	$dt = date('Y-m-d H:i:s');
	$errortype = array (
					   E_ERROR           => 'Error',
					   E_WARNING         => 'Warning',
					   E_PARSE           => 'Parsing Error',
					   E_NOTICE          => 'Notice',
					   E_CORE_ERROR      => 'Core Error',
					   E_CORE_WARNING    => 'Core Warning',
					   E_COMPILE_ERROR   => 'Compile Error',
					   E_COMPILE_WARNING => 'Compile Warning',
					   E_USER_ERROR      => 'User Error',
					   E_USER_WARNING    => 'User Warning',
					   E_USER_NOTICE     => 'User Notice',
					   E_STRICT          => 'Runtime Notice'
			           );
	$user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
	$err = "<errorentry>\n";
	$err .= "\t<datetime>" . $dt . "</datetime>\n";
	$err .= "\t<errornum>" . $errno . "</errornum>\n";
	$err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
	$err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
	$err .= "\t<scriptname>" . $filename . "</scriptname>\n";
	$err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";
	if (in_array($errno, $user_errors))
	{
	   $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
	}
	$err .= "</errorentry>\n\n";
	echo $err;
	error_log($err, 3, PHPCMS_ROOT.'/data/php_error_log.xml');
	chmod(PHPCMS_ROOT.'/data/php_error_log.xml', 0777);
}

function debuginfo()
{
	global $db,$CONFIG,$phpcms_starttime,$debuginfo;
	if(!$CONFIG['debug'] || defined('CREATEHTML')) return FALSE;
	$mtime = explode(' ', microtime());
	$debuginfo = array('time' => number_format(($mtime[1] + $mtime[0] - $phpcms_starttime), 6), 'queries' => $db->querynum);
	return TRUE;
}


function style_edit($name = 'style', $style = '')
{
	global $styleid,$LANG;
	if(!$styleid) $styleid = 1; else $styleid++;
    $colorarr = array('#000000','#FFFFFF','#008000','#800000','#808000','#000080','#800080','#808080','#FFFF00','#00FF00','#00FFFF','#FF00FF','#FF0000','#0000FF','#008080');
	
	$color = $strong = '';
	if($style)
	{
		if(preg_match("/color:([#0-9a-z]+);/i",$style,$matchs)) $color = strtoupper($matchs[1]);
		if(preg_match("/font-weight:([a-z]+);/i",$style,$matchs)) $strong = $matchs[1];
	}
	$styleform = "<option value=\"\">".$LANG['color']."</option>\n";
	foreach($colorarr as $key=>$val)
	{
	    $styleform .= "<option value=\"color:".$val.";\" ".($color == $val ? "selected=\"selected\"" : "")." style=\"background-color:".$val.";align:center\"></option>\n";
	}
	$styleform = "<select name=\"style_color$styleid\" id=\"style_color$styleid\" onchange=\"document.all.style_id$styleid.value=document.all.style_color$styleid.value;if(document.all.style_strong$styleid.checked)document.all.style_id$styleid.value += document.all.style_strong$styleid.value;\">\n".$styleform."</select>\n";
	$styleform .= " <input type=\"checkbox\" name=\"style_strong$styleid\" id=\"style_strong$styleid\" value=\"font-weight:bold;\" ".($strong == "bold" ? "checked=\"checked\"" : "")." onclick=\"document.all.style_id$styleid.value=document.all.style_color$styleid.value;if(document.all.style_strong$styleid.checked)document.all.style_id$styleid.value += document.all.style_strong$styleid.value;\"> ".$LANG['bold'];
	$styleform .= "<input type=\"hidden\" name=\"".$name."\" id=\"style_id$styleid\" value=\"".$style."\">";
	return $styleform;
}
?>