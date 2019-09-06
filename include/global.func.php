<?php
function new_htmlspecialchars($string)
{
	return is_array($string) ? array_map('new_htmlspecialchars', $string) : htmlspecialchars($string, ENT_QUOTES);
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

function filter_xss($string, $allowedtags = '', $disabledattributes = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload','iframe'))
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

function safe_replace($string)
{
	$string = str_replace('%20','',$string);
	$string = str_replace('%27','',$string);
	$string = str_replace('*','',$string);
	$string = str_replace('"','&quot;',$string);
	$string = str_replace("'",'',$string);
	$string = str_replace("\"",'',$string);
	$string = str_replace('//','',$string);
	$string = str_replace(';','',$string);
	$string = str_replace('<','&lt;',$string);
	$string = str_replace('>','&gt;',$string);
	$string = str_replace('(','',$string);
	$string = str_replace(')','',$string);
	$string = str_replace("{",'',$string);
	$string = str_replace('}','',$string);
	return $string;
}

function filter_word($data = '')
{
	global $PHPCMS;
	$filter_word = trim($PHPCMS['filter_word']);
	if(!$filter_word || (!$data && !$_GET && !$_POST)) return false;
	$filter_word = array_filter(array_map('trim', explode("\n", $filter_word)));
    if(!$filter_word) return false;
	$pattern = str_replace('\*', '.*', implode('|', array_map('preg_quote', $filter_word)));
	$data = array2string($_REQUEST);
	if($pattern && preg_match("/($pattern)/", $data, $m))
	{
		$pattern_word = $m[0];
		define('ILLEGAL_WORD', $pattern_word);
		unset($m[0]);
		$word = implode(' ', $m);
		$logdata = array(TIME, IP, $word, $pattern_word);
		$logfile = PHPCMS_ROOT.'data/filterlog/'.date('Ym', TIME).'.csv';
		$fp = fopen($logfile, 'a');
		fputcsv($fp, $logdata);
		fclose($fp);
		return true;
	}
	return false;
}

function format_textarea($string)
{
	return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($string)));
}

function format_js($string, $isjs = 1)
{
	$string = addslashes(str_replace(array("\r", "\n"), array('', ''), $string));
	return $isjs ? 'document.write("'.$string.'");' : $string;
}

if(!function_exists('file_put_contents'))
{
	define('FILE_APPEND', 8);
	function file_put_contents($file, $data, $append = '')
	{
		$mode = $append == '' ? 'wb' : 'ab';
		$fp = @fopen($file, $mode) or exit("Can not open file $file !");
		flock($fp, LOCK_EX);
		$len = @fwrite($fp, $data);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $len;
	}
}

if(!function_exists('http_build_query'))
{
    function http_build_query($data, $prefix = null, $sep = '', $key = '')
	{
        $ret = array();
		foreach((array)$data as $k => $v)
		{
			$k = urlencode($k);
			if(is_int($k) && $prefix != null)
			{
				$k = $prefix.$k;
			}
			if(!empty($key)) {
				$k = $key."[".$k."]";
			}
			if(is_array($v) || is_object($v))
			{
				array_push($ret,http_build_query($v,"",$sep,$k));
			}
			else
			{
				array_push($ret,$k."=".urlencode($v));
			}
		}
        if(empty($sep))
		{
            $sep = ini_get("arg_separator.output");
        }
        return implode($sep, $ret);
    }
}

if(!function_exists('image_type_to_extension'))
{
    function image_type_to_extension($type, $dot = true)
    {
        $e = array ( 1 => 'gif', 'jpeg', 'png', 'swf', 'psd', 'bmp' ,'tiff', 'tiff', 'jpc', 'jp2', 'jpf', 'jb2', 'swc', 'aiff', 'wbmp', 'xbm');
        $type = intval($type);
        if (!$type)
		{
            trigger_error( 'File Type is null...', E_USER_NOTICE );
            return null;
        }
        if(!isset($e[$type]))
		{
            trigger_error( 'Image type is wrong...', E_USER_NOTICE );
            return null;
        }
        return ($dot ? '.' : '') . $e[$type];
    }
}

if(!function_exists('array_intersect_key'))
{
	function array_intersect_key($isec, $keys)
	{
		$argc = func_num_args();
		if ($argc > 2)
		{
			for ($i = 1; !empty($isec) && $i < $argc; $i++)
			{
				$arr = func_get_arg($i);
				foreach (array_keys($isec) as $key)
				{
					if (!isset($arr[$key]))
					{
						unset($isec[$key]);
					}
				}
			}
			return $isec;
		}
		else
		{
			$res = array();
			foreach (array_keys($isec) as $key)
			{
				if (isset($keys[$key]))
				{
					$res[$key] = $isec[$key];
				}
			}
			return $res;
		}
	}
}

if(!function_exists('json_encode'))
{
	function json_encode($string)
	{
		require_once 'json.class.php';
		$json = new json();
		return $json->encode($string);
	}
}

if(!function_exists('json_decode'))
{
	function json_decode($string,$type = 1)
	{
		require_once 'json.class.php';
		$json = new json();
		return $json->decode($string,$type);
	}
}

if(!function_exists('iconv'))
{
	function iconv($in_charset, $out_charset, $str)
	{
		if(function_exists('mb_convert_encoding'))
		{
			return mb_convert_encoding($str, $out_charset, $in_charset);
		}
		else
		{

			require_once 'iconv.func.php';
			$in_charset = strtoupper($in_charset);
			$out_charset = strtoupper($out_charset);
			if($in_charset == 'UTF-8' && ($out_charset == 'GBK' || $out_charset == 'GB2312'))
			{
				return utf8_to_gbk($str);
			}
			if(($in_charset == 'GBK' || $in_charset == 'GB2312') && $out_charset == 'UTF-8')
			{
				return gbk_to_utf8($str);
			}
			return $str;
		}
	}
}

function str_charset($in_charset, $out_charset, $str_or_arr)
{
	if(is_array($str_or_arr))
	{
		foreach($str_or_arr as $k=>$v)
		{
			$str_or_arr[$k] = str_charset($in_charset, $out_charset, $v);
		}
	}
	else
	{
		$str_or_arr = iconv($in_charset, $out_charset, $str_or_arr);
	}
	return $str_or_arr;
}

function stripstr($str)
{
	return str_replace(array('..', "\n", "\r"), array('', '', ''), $str);
}

if(!function_exists('fputcsv'))
{
	function fputcsv(&$fp, $array, $delimiter = ',', $enclosure = '"')
	{
		$data = $enclosure.implode($enclosure.$delimiter.$enclosure, $array).$enclosure."\n";
		return fwrite($fp, $data);
	}
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

function set_cookie($var, $value = '', $time = 0)
{
	$time = $time > 0 ? $time : ($value == '' ? PHP_TIME - 3600 : 0);
	$s = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
	$var = COOKIE_PRE.$var;
	$_COOKIE[$var] = $value;
	if(is_array($value))
	{
		foreach($value as $k=>$v)
		{
			setcookie($var.'['.$k.']', $v, $time, COOKIE_PATH, COOKIE_DOMAIN, $s);
		}
	}
	else
	{
		setcookie($var, $value, $time, COOKIE_PATH, COOKIE_DOMAIN, $s);
	}
}

function get_cookie($var)
{
	$var = COOKIE_PRE.$var;
	return isset($_COOKIE[$var]) ? $_COOKIE[$var] : false;
}

function content_set($contentid, $field, $data)
{
	return @file_put_contents(content_file($contentid, $field), $data);
}

function content_get($contentid, $field)
{
	return @file_get_contents(content_file($contentid, $field));
}

function content_del($contentid, $field)
{
	return @unlink(content_file($contentid, $field));
}

function content_file($contentid, $field)
{
	$id = str_pad($contentid, 4, '0', STR_PAD_LEFT);
	return CONTENT_ROOT.$field.'/'.substr($id, 0, 2).'/'.substr($id, 2, 2).'/'.$contentid.'.txt';
}

function content_init($field)
{
	@set_time_limit(300);
	@mkdir(CONTENT_ROOT.$field, 0777);
	for($i=1; $i<=9999; $i++)
	{
		$id = str_pad($i, 4, '0', STR_PAD_LEFT);
		$dir1 = CONTENT_ROOT.$field.'/'.substr($id, 0, 2);
		$dir2 = $dir1.'/'.substr($id, 2, 2);
		@mkdir($dir1, 0777);
		@mkdir($dir2, 0777);
	}
	return true;
}

function menu($parentid, $code = '')
{
	global $db, $_userid, $_roleid, $_groupid;
	$code = str_replace('"', '\"', $code);
	$where = $parentid == 99 ? "AND userid=$_userid" : '';
	$menus = $db->select("SELECT * FROM `".DB_PRE."menu` WHERE `parentid`='$parentid' $where ORDER BY `listorder`,`menuid`", 'menuid');
	if($code)
	{
		foreach($menus as $m)
		{
			extract($m);
			if(($roleids && defined('IN_ADMIN') && !check_in($_roleid, $roleids)) || ($groupids && !defined('IN_ADMIN') && !check_in($_groupid, $groupids))) continue;
			eval("\$menu .= \"$code\";");
		}
		$menus = $menu;
	}
	return $menus;
}

function url($url, $isabs = 0)
{
	if(strpos($url, '://') !== FALSE || $url[0] == '?') return $url;
	if($isabs || defined('SHOWJS'))
	{
		$url = strpos($url, PHPCMS_PATH) === 0 ? SITE_URL.substr($url, strlen(PHPCMS_PATH)) : SITE_URL.$url;
	}
	else
	{
		$url = strpos($url, PHPCMS_PATH) === 0 ? $url : PHPCMS_PATH.$url;
	}
	return $url;
}

function is_ie()
{
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if((strpos($useragent, 'opera') !== false) || (strpos($useragent, 'konqueror') !== false)) return false;
	if(strpos($useragent, 'msie ') !== false) return true;
	return false;
}

function is_websearch()
{
	if(!defined('IS_WEBSEARCH'))
	{
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$browsers = 'msie|netscape|opera|konqueror|mozilla';
		$spiders = 'bot|spider|google|isaac|surveybot|baiduspider|yahoo|sohu-search|yisou|3721|qihoo|daqi|ia_archiver|p.arthur|fast-webcrawler|java|microsoft-atl-native|turnitinbot|webgather|sleipnir|msn';
		if(preg_match("/($browsers)/", $_SERVER['HTTP_USER_AGENT']))
		{
			define('IS_WEBSEARCH', FALSE);
		}
		elseif(preg_match("/($spiders)/", $_SERVER['HTTP_USER_AGENT']))
		{
			define('IS_WEBSEARCH', TRUE);
		}
		else
		{
			define('IS_WEBSEARCH', FALSE);
		}
	}
	return IS_WEBSEARCH;
}

function is_date($ymd, $sep='-')
{
	if(empty($ymd)) return FALSE;
	list($year, $month, $day) = explode($sep, $ymd);
	return checkdate($month, $day, $year);
}

function is_email($email)
{
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

function str_exists($haystack, $needle)
{
	return !(strpos($haystack, $needle) === FALSE);
}

function file_down($filepath, $filename = '')
{
	if(!$filename) $filename = basename($filepath);
	if(is_ie()) $filename = rawurlencode($filename);
	$filetype = fileext($filename);
	$filesize = sprintf("%u", filesize($filepath));
	if(ob_get_length() !== false) @ob_end_clean();
	header('Pragma: public');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: pre-check=0, post-check=0, max-age=0');
	header('Content-Transfer-Encoding: binary');
	header('Content-Encoding: none');
	header('Content-type: '.$filetype);
	header('Content-Disposition: attachment; filename="'.$filename.'"');
	header('Content-length: '.$filesize);
	readfile($filepath);
	exit;
}

function fileext($filename)
{
	return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}

function implodeids($array, $s = ',')
{
	if(empty($array)) return '';
	return is_array($array) ? implode($s, $array) : $array;
}

function check_submit($var)
{
	if(empty($GLOBALS[$var])) return false;
	if(empty($_SERVER['HTTP_REFERER'])) return true;
	return strpos($_SERVER['HTTP_REFERER'], DOMAIN) === 7;
}

function check_in($id, $ids = '', $s = ',')
{
	if(!$ids) return false;
	$ids = explode($s, $ids);
	return is_array($id) ? array_intersect($id, $ids) : in_array($id, $ids);
}

function ip()
{
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown'))
	{
		$ip = getenv('HTTP_CLIENT_IP');
	}
	elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
	{
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown'))
	{
		$ip = getenv('REMOTE_ADDR');
	}
	elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : 'unknown';
}

function ip_banned($ip)
{
	$ips = cache_read('ipbanned.php');
	if(!$ips) return false;
	foreach($ips as $k=>$v)
	{
		if($v < TIME) continue;
		if($ip == $k) return true;
		if(strpos($k, '*'))
		{
			$k = str_replace(array('.', '*'), array('\.', '[0-9]{1,3}'), $k);
		    if(preg_match("/$v/", $ip)) return true;
		}
	}
	return false;
}

function str_cut($string, $length, $dot = '...')
{
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	$string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array(' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
	$strcut = '';
	if(strtolower(CHARSET) == 'utf-8')
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

function cache_page_start()
{
	define('CACHE_PAGE_ID', md5(RELATE_URL));
	define('CACHE_PAGE_DIR', CACHE_PAGE_PATH.substr(CACHE_PAGE_ID, 0, 2).'/');
	define('CACHE_PAGE_FILE', CACHE_PAGE_DIR.CACHE_PAGE_ID.'.html');
	$contents = @file_get_contents(CACHE_PAGE_FILE);
	if($contents && intval(substr($contents, 15, 25)) > TIME)
	{
		echo substr($contents, 29);
		exit;
	}
	return true;
}

function cache_page($ttl = CACHE_PAGE_TTL, $isjs = 0)
{
	if($ttl == 0 || !defined('CACHE_PAGE_FILE')) return false;
	$contents = ob_get_contents();
	if($isjs) $contents = format_js($contents);
	dir_create(CACHE_PAGE_DIR);
	$contents = "<!--expiretime:".(TIME + $ttl)."-->\n".$contents;
	file_put_contents(CACHE_PAGE_FILE, $contents);
	@chmod(CACHE_PAGE_FILE, 0777);
}

function cache_page_clear()
{
	@set_time_limit(600);
	$dirs = glob(CACHE_PAGE_PATH.'*');
	foreach($dirs as $dir)
	{
		$files = glob($dir.'/*');
		foreach($files as $file)
		{
			@unlink($file);
		}
		@rmdir($dir);
	}
}

function cache_count($sql)
{
	global $db, $TEMP;
	$id = md5($sql);
	if(!isset($TEMP['count'][$id]))
	{
		if(CACHE_COUNT_TTL)
		{
			$r = $db->get_one("SELECT `count`,`updatetime` FROM `".DB_PRE."cache_count` WHERE `id`='$id'");
			if(!$r || $r['updatetime'] < TIME - CACHE_COUNT_TTL)
			{
				$r = $db->get_one($sql);
				$TEMP['count'][$id] = $r['count'];
				$db->query("REPLACE INTO `".DB_PRE."cache_count`(`id`, `count`, `updatetime`) VALUES('$id', '".$r['count']."', '".TIME."')");
			}
		}
		else
		{
			$r = $db->get_one($sql);
		}
		$TEMP['count'][$id] = $r['count'];
	}
	return $TEMP['count'][$id];
}

function cache_member()
{
	global $db;
	$status = $db->table_status(DB_PRE.'member_cache');
	if($status['Rows'] == 0)
	{
		@set_time_limit(600);
		$db->query("INSERT INTO `".DB_PRE."member_cache` SELECT * FROM `".DB_PRE."member`");
		return true;
	}
	return false;
}

function cache_read($file, $path = '', $iscachevar = 0)
{
	if(!$path) $path = CACHE_PATH;
	$cachefile = $path.$file;
	if($iscachevar)
	{
		global $TEMP;
		$key = 'cache_'.substr($file, 0, -4);
		return isset($TEMP[$key]) ? $TEMP[$key] : $TEMP[$key] = @include $cachefile;
	}
	return @include $cachefile;
}

function cache_write($file, $array, $path = '')
{
	if(!is_array($array)) return false;
	$array = "<?php\nreturn ".var_export($array, true).";\n?>";
	$cachefile = ($path ? $path : CACHE_PATH).$file;
	$strlen = file_put_contents($cachefile, $array);
	@chmod($cachefile, 0777);
	return $strlen;
}

function cache_delete($file, $path = '')
{
	$cachefile = ($path ? $path : CACHE_PATH).$file;
	return @unlink($cachefile);
}

function setting_set($tablename, $where, $setting)
{
	global $db;
	if(!is_array($setting)) return false;
	$setting = new_stripslashes($setting);
	$setting = addslashes(var_export($setting, TRUE));
	return $db->query("UPDATE `$tablename` SET `setting`='$setting' WHERE $where");
}

function setting_get($tablename, $where)
{
	global $db;
	$r = $db->get_one("SELECT `setting` FROM `$tablename` WHERE $where LIMIT 1");
	$setting = $r['setting'];
	if($setting) eval("\$setting = $setting;");
	else $setting = array();
	return $setting;
}

function string2array($data)
{
	if($data == '') return array();
	eval("\$array = $data;");
	return $array;
}

function array2string($data, $isformdata = 1)
{
	if($data == '') return '';
	if($isformdata) $data = new_stripslashes($data);
	return addslashes(var_export($data, TRUE));
}

function subcat($module = 'phpcms', $parentid = NULL, $type = NULL)
{
	global $CATEGORY;
	$subcat = array();
	foreach($CATEGORY as $id=>$cat)
	{
		if($cat['module'] == $module && ($parentid === NULL || $cat['parentid'] == $parentid) && ($type === NULL || $cat['type'] == $type)) $subcat[$id] = $cat;
	}
	return $subcat;
}

function submodelcat($modelid = 1, $parentid = NULL, $type = NULL)
{
	global $CATEGORY;
	$subcat = array();
	foreach($CATEGORY as $id=>$cat)
	{
		if($cat['modelid'] == $modelid && ($parentid === NULL || $cat['parentid'] == $parentid) && $cat['parentid'] !=0 && ($type === NULL || $cat['type'] == $type)) $subcat[$id] = $cat;
	}

	return $subcat;
}

function catpos($catid, $urlrule = '')
{
	global $CATEGORY;
	if(!isset($CATEGORY[$catid])) return '';
	$pos = '';
	$arrparentid = array_filter(explode(',', $CATEGORY[$catid]['arrparentid'].','.$catid));
	foreach($arrparentid as $catid)
	{
		if($urlrule) eval("\$url = \"$urlrule\";");
		else $url = $CATEGORY[$catid]['url'];
		$pos .= '<a href="'.$url.'">'.$CATEGORY[$catid]['catname'].'</a>';
	}
	return $pos;
}

function subarea($parentid = 0)
{
	global $AREA;
	$subarea = array();
	foreach($AREA as $id=>$area)
	{
		if($area['parentid'] == $parentid) $subarea[$id] = $area;
	}
	return $subarea;
}

function areapos($areaid, $urlrule = '')
{
	global $AREA;
	if(!isset($AREA[$areaid])) return '';
	$pos = '';
	$arrparentid = array_filter(explode(',', $AREA[$areaid]['arrparentid'].','.$areaid));
	foreach($arrparentid as $areaid)
	{
		if($urlrule) eval("\$url = \"$urlrule\";");
		else $url = $AREA[$areaid]['url'];
		$pos .= '<a href="'.$url.'">'.$AREA[$areaid]['name'].'</a>';
	}
	return $pos;
}

function subtype($module = 'phpcms', $modelid = 0)
{
	global $TYPE;
	$subtype = array();
	$modelid = intval($modelid);
	foreach($TYPE as $id=>$type)
	{
		if($modelid)
		{
			if($type['module'] == $module && $type['modelid']==$modelid) $subtype[$id] = $type;
		}
		else
		{
			if($type['module'] == $module) $subtype[$id] = $type;
		}
	}
	return $subtype;
}

function template($module = 'phpcms', $template = 'index', $istag = 0)
{
	$compiledtplfile = TPL_CACHEPATH.$module.'_'.$template.'.tpl.php';
	if(TPL_REFRESH && (!file_exists($compiledtplfile) || @filemtime(TPL_ROOT.TPL_NAME.'/'.$module.'/'.$template.'.html') > @filemtime($compiledtplfile) || @filemtime(TPL_ROOT.TPL_NAME.'/tag.inc.php') > @filemtime($compiledtplfile)))
	{
		require_once PHPCMS_ROOT.'include/template.func.php';
		template_compile($module, $template, $istag);
	}
	return $compiledtplfile;
}

function thumb($imgurl, $width = 100, $height = 100 ,$autocut = 1, $smallpic = 'images/nopic_small.gif', $ftp = 0)
{
	global $image;
	if(empty($imgurl)) return $smallpic;
	if(!extension_loaded('gd')) return $imgurl;
	if(strpos($imgurl, '://')) {
		$newimgurl = dirname($imgurl).'/thumb_'.$width.'_'.$height.'_'.basename($imgurl);
		$newimgurl = str_replace(UPLOAD_FTP_DOMAIN, '', $newimgurl);
		if(file_exists(PHPCMS_ROOT.$newimgurl)) return $newimgurl;
		@dir_create(UPLOAD_ROOT.date('Y/md/'));
		@copy($imgurl, PHPCMS_ROOT.UPLOAD_URL.basename($imgurl));
		$imgurl = UPLOAD_URL.basename($imgurl);
		$ftp = 1;
	} else {
		if(!file_exists(PHPCMS_ROOT.$imgurl)) return 'images/nopic.gif';
		list($width_t, $height_t, $type, $attr) = getimagesize(PHPCMS_ROOT.$imgurl);
		if($width>=$width_t || $height>=$height_t) return $imgurl;

		$newimgurl = dirname($imgurl).'/thumb_'.$width.'_'.$height.'_'.basename($imgurl);
		if(file_exists(PHPCMS_ROOT.$newimgurl)) return $newimgurl;
	}

	if(!is_object($image))
	{
		require_once 'image.class.php';
		$image = new image();
	}
	return $image->thumb(PHPCMS_ROOT.$imgurl, PHPCMS_ROOT.$newimgurl, $width, $height, '', $autocut, $ftp) ? $newimgurl : $imgurl;	

}

function ssi($file)
{
	if(!file_exists(PHPCMS_ROOT.$file)) return false;
	return (SHTML && defined('CREATEHTML')) ? '<!--#include virtual="'.PHPCMS_PATH.$file.'"-->' : @file_get_contents(PHPCMS_ROOT.$file);
}

function get($sql, $rows = 0, $page = 0, $dbname = '', $dbsource = '', $urlrule = '', $distinct_field = '', $catid = 0)
{
	if(!$sql) return false;
	if($dbsource)
	{
		$s = cache_read('db_'.$dbsource.'.php', '', 1);
		if(!$s) return false;
		if($s['status'])
		{
            global $db;
			$dbname = $s['dbname'];
		}
		else
		{
			$db = new db_mysql;
			$db->connect($s['dbhost'], $s['dbuser'], $s['dbpw'], $s['dbname'], 0, $s['dbcharset']);
		}
	}
	else
	{
		global $db;
		if(DB_PRE != 'phpcms_') $sql = str_replace('phpcms_', DB_PRE, $sql);
	}
	if($dbname) $db->select_db($dbname) or exit("The database $database is not exists!");
	$rows = intval($rows);
	if(!isset($page)) $page = 1;
	$page = max(intval($page), 0);
	$pages = $limit = '';
	if($page)
	{
		$offset = $rows*($page-1);
		$limit = " LIMIT $offset, $rows";
		if($dbname || $dbsource)
		{
			$r = $db->get_one("SELECT COUNT(*) AS `count` ".stristr($sql, 'from'));
			$total = $r['count'];
		}
		elseif($distinct_field)
		{
			$total = cache_count("SELECT COUNT(distinct $distinct_field) AS `count` ".stristr($sql, 'from'));
		}
		else
		{
			$total = cache_count("SELECT COUNT(*) AS `count` ".stristr($sql, 'from'));
		}
		$pages = pages($total, $page, $rows, $urlrule, '', $catid);
	}
	elseif($rows > 0)
	{
		$limit = " LIMIT $rows";
	}
	//echo $sql.$limit;
	$data = $rows == -1 ? $db->get_one($sql) : $db->select($sql.$limit);
	if($dbname) $db->select_db(DB_NAME);
	if(isset($s['dbcharset']) && $s['dbcharset'] != DB_CHARSET) $data = str_charset($s['dbcharset'], CHARSET, $data);
	if($page)
	{
		$count = count($data);
		if(!isset($total)) $total = $count;
		return array('data'=>$data, 'total'=>$total, 'count'=>count($data), 'pages'=>$pages);
	}
	else
	{
		return $data;
	}
}

function tag($module, $template, $sql, $page = 0, $number = 10, $setting = array(), $catid = 0)
{
	global $db, $CATEGORY, $MODULE, $URLRULE, $PHPCMS, $MODEL;
	if($sql)
	{
		@include_once PHPCMS_ROOT.$MODULE[$module]['path'].'include/output.func.php';
		$offset = 0;
		if($page !== 0)
		{
			$page = max(intval($page), 1);
			$offset = $number*($page-1);
			$sql_count = preg_replace("/^SELECT([^(]+)\s*FROM(.+)(ORDER BY.+)$/i", "SELECT COUNT(*) AS `count` FROM\\2", $sql);
			$count = cache_count($sql_count);
			$urlruleid = isset($setting['urlruleid']) ? intval($setting['urlruleid']) : 0;
			$urlrule = $urlruleid > 0 ? $URLRULE[$urlruleid] : '';
			$pages = pages($count, $page, $number, $urlrule, $setting, $catid);
		}
		$i = 0;
		$data = array();
		$result = $db->query("$sql LIMIT $offset, $number");
		while($r = $db->fetch_array($result))
		{
			$data[++$i] = $r;
		}
		$rows = $db->num_rows($result);
		$db->free_result($result);
	}
	else
	{
		$data = array();
		$number = $rows = $count = $page = 0;
		$pages = '';
	}
	require_once template($module, $template, 1);
	$func = '_tag_'.$module.'_'.$template;
	$func($data, $number, $rows, $count, $page, $pages, $setting);
}

function block($pageid, $blockno)
{
	echo ssi('data/block/'.$pageid.'_'.$blockno.'.html');
}

function get_sql_catid($catid)
{
	global $CATEGORY;
	$catid = intval($catid);
	if(!isset($CATEGORY[$catid])) return false;
	return $CATEGORY[$catid]['child'] ? " AND `catid` IN(".$CATEGORY[$catid]['arrchildid'].") " : " AND `catid`=$catid ";
}

function get_sql_areaid($areaid)
{
	global $AREA;
	$areaid = intval($areaid);
	if(!isset($AREA[$areaid])) return false;
	return $AREA[$areaid]['child'] ? " AND `areaid` IN (".$AREA[$areaid]['arrchildid'].") " : " AND `areaid`=$areaid";
}

function get_sql_in($string, $s = ' ')
{
	$array = array_map('trim', explode($s, $string));
	$array = new_addslashes($array);
	return "'".implode("','", $array)."'";
}

function pages($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(), $catid = 0)
{
	global $PHPCMS;
	if($PHPCMS['pagemode'] && $num > $perpage)
	{
		$multipage = '';
		if($num > $perpage)
		{
			$page = 11;
			$offset = 4;
			$pages = ceil($num / $perpage);
			$from = $curr_page - $offset;
			$to = $curr_page + $offset;
			$more = 0;
			if($page >= $pages)
			{
				$from = 2;
				$to = $pages-1;
			}
			else
			{
				if($from <= 1)
				{
					$to = $page-1;
					$from = 2;
				}
				elseif($to >= $pages)
				{
					$from = $pages-($page-2);
					$to = $pages-1;
				}
				$more = 1;
			}
			if($urlrule == '') $urlrule = url_par('page={$page}');

			$multipage .= '总数：<b>'.$num.'</b>&nbsp;&nbsp;';

			if($curr_page>0)
			{
				$multipage .= $catid ? '<a href="'.$url->category($catid, $curr_page-1, 1, 1).'">上一页</a>' : '<a href="'.pageurl($urlrule, $curr_page-1, $array).'">上一页</a>';
				if($curr_page==1)
				{
					$multipage .= '<u><b>1</b></u> ';
				}
				elseif($curr_page>6 && $more)
				{
					$multipage .= $catid ? '<a href="'.$url->category($catid, 1, 1, 1).'">1</a>..' : '<a href="'.pageurl($urlrule, 1, $array).'">1</a>..';
				}
				else
				{
					$multipage .= $catid ? '<a href="'.$url->category($catid, 1, 1, 1).'">1</a>' : '<a href="'.pageurl($urlrule, 1, $array).'">1</a> ';
				}
			}
			for($i = $from; $i <= $to; $i++)
			{
				if($i != $curr_page)
				{
					$multipage .= $catid ? '<a href="'.$url->category($catid, $i, 1, 1).'">'.$i.'</a> ' : '<a href="'.pageurl($urlrule, $i, $array).'">'.$i.'</a> ';
				}
				else
				{
					$multipage .= ' <u><b>'.$i.'</b></u> ';
				}
			}
			if($curr_page<$pages)
			{
				if($curr_page<$pages-5 && $more)
				{
					$multipage .= $catid ? '..<a href="'.$url->category($catid, $pages, 1, 1).'">'.$pages.'</a> <a href="'.$url->category($catid, $curr_page+1, 1).'">下一页</a>' : '..<a href="'.pageurl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.pageurl($urlrule, $curr_page+1, $array).'">下一页</a>';
				}
				else
				{
					$multipage .= $catid ? '<a href="'.$url->category($catid, $pages, 1, 1).'">'.$pages.'</a> <a href="'.$url->category($catid, $curr_page+1, 1, 1).'">下一页</a>' : '<a href="'.pageurl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.pageurl($urlrule, $curr_page+1, $array).'">下一页</a>';
				}
			}
			elseif($curr_page==$pages)
			{
				$multipage .= ' <u><b>'.$pages.'</b></u><a href="'.pageurl($urlrule, $curr_page, $array).'">下一页</a>';
			}
		}
		return $multipage;
	}
	else
	{
		$total = $num;
		$page = $curr_page;
		if($num < 1) return '';
		if($urlrule == '') $urlrule = url_par('page={$page}');
		$pages = ceil($total/$perpage);

		$page = min($pages, $page);
		$prepage = $page - 1;
		$prepage = max($prepage, 1);
		$nextpage = $page+1;
		$nextpage = min($nextpage, $pages);
		if($catid)
		{
			$url = load('url.class.php');
			$firstpage = $url->category($catid, 1, 1, 1);
			$prepage = $url->category($catid, $prepage, 1, 1);
			$nextpage = $url->category($catid, $nextpage, 1, 1);
			$lastpage = $url->category($catid, $pages, 1, 1);
			$urlpre = $url->category($catid, '', 1, 1);
		}
		else
		{
			$firstpage = pageurl($urlrule, 1, $array);
			$prepage = pageurl($urlrule, $prepage, $array);
			$nextpage = pageurl($urlrule, $nextpage, $array);
			$lastpage = pageurl($urlrule, $pages, $array);
			$urlpre = pageurl($urlrule, '', $array);
		}
		$data = str_replace('"', '\"', $PHPCMS['pageshtml']);
		eval("\$url = \"$data\";");
		return $url;
	}
}

function pageurl($urlrule, $page, $array = array())
{
	@extract($array, EXTR_SKIP);
	if(strpos($urlrule, '|'))
	{
		$urlrules = explode('|', $urlrule);
		$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
	}
	eval("\$url = \"$urlrule\";");
	return $url;
}

function showmessage($msg, $url_forward = 'goback', $ms = 1250, $direct = 0)
{
	global $PHPCMS;
	if($url_forward && $url_forward != 'goback' && $url_forward != 'close') $url_forward = url($url_forward, 1);
    if($direct && $url_forward && $url_forward!='goback')
    {
        ob_clean();
        header("location:$url_forward");
        exit("<script>self.location='$url_forward';</script>");
    }
	include defined('IN_ADMIN') ? PHPCMS_ROOT.'admin/templates/showmessage.tpl.php' : template('phpcms','showmessage');
	exit;
}

function createhtml($file)
{
	$data = ob_get_contents();
	ob_clean();
	dir_create(dirname($file));
	$strlen = file_put_contents($file, $data);
	@chmod($file,0777);
	return $strlen;
}

function keyid_make($module, $tablename, $titlefield, $id)
{
	$keyid = $module.'-'.$tablename.'-'.$titlefield.'-'.$id;

	$verify = md5($keyid.AUTH_KEY);
	return array($keyid, $verify);
}

function keyid_get($keyid)
{
	global $db;
	list($module, $tablename, $titlefield, $id) = explode('-', $keyid);
	if(!$tablename) return false;
	$tablename = DB_PRE.$tablename;
	$keyfield = $db->get_primary($tablename);
	
	if($module=='video')
	{
		$r =$db->get_one("SELECT `vid`,`title`,`url` FROM `$tablename` WHERE `$keyfield`='$id'");
		require_once PHPCMS_ROOT.'video/include/output.func.php';
		$r['url'] = video_show_url($r['vid'],$r['url']);
	}
	else
	{
		$r =$db->get_one("SELECT `$titlefield` AS title,`url` FROM `$tablename` WHERE `$keyfield`='$id'");
	}
	return $r;
}

function keyid_verify($keyid, $verify)
{
    $keyid = md5($keyid.AUTH_KEY);
	return $verify == $keyid;
}

function checkcode($checkcode, $enable = 1, $forward = '')
{
	global $LANG;
	if(!$enable) return true;
	session_start();
	if(!isset($_SESSION['checkcode'])) showmessage($LANG['do_not_refresh'], $forward);
	if(strtolower($_SESSION['checkcode']) != strtolower($checkcode))
	{
		unset($_SESSION['checkcode']);
		showmessage($LANG['checkcode_error'], $forward);
	}
	unset($_SESSION['checkcode']);
	return true;
}

function usedtime()
{
	$stime = explode(' ', MICROTIME_START);
	$etime = explode(' ', microtime());
	return number_format(($etime[1] + $etime[0] - $stime[1] - $stime[0]), 6);
}

function debug()
{
	global $db;
	if(!DEBUG || defined('CREATEHTML')) return false;
	define('DEBUG_TIME', usedtime());
	define('DEBUG_QUERIES', $db->querynum);
	return true;
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

function load($file, $module = 'phpcms', $dir = '', $isinit = 1)
{
	global $MODULE;
	if(!isset($MODULE[$module])) return false;
	$path = PHPCMS_ROOT.$MODULE[$module]['path'].($dir ? $dir.'/' : 'include/').$file;
	if(!(@include_once $path)) return false;
	if($isinit && strpos($file, '.class.php') !== false)
	{
		$classname = substr($file, 0, -10);
		if(is_object($classname)) {
			return true;
		} else {
			return new $classname();
		}
	}
	return true;
}

function sizecount($filesize)
{
	if($filesize >= 1073741824)
	{
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
	}
	elseif($filesize >= 1048576)
	{
		$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
	}
	elseif($filesize >= 1024)
	{
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	}
	else
	{
		$filesize = $filesize . ' Bytes';
	}
	return $filesize;
}

function phpcms_auth($txt, $operation = 'ENCODE', $key = '')
{
	$key	= $key ? $key : $GLOBALS['phpcms_auth_key'];
	$txt	= $operation == 'ENCODE' ? $txt : base64_decode($txt);
	$len	= strlen($key);
	$code	= '';
	for($i=0; $i<strlen($txt); $i++){
		$k		= $i % $len;
		$code  .= $txt[$i] ^ $key[$k];
	}
	$code = $operation == 'DECODE' ? $code : base64_encode($code);
	return $code;
}

function hash_string($str)
{
	$str = str_pad($str, 10, 0, STR_PAD_LEFT);
	$str = base64_encode($str);
	$str = substr($str,-5,-3).substr($str,0,-2);
	return $str;
}

function areaname($areaid)
{
	global $AREA;
	if(!isset($AREA[$areaid])) return '';
	$pos = array();
    $arrparentid = array_filter(explode(',', $AREA[$areaid]['arrparentid'].','.$areaid));
	foreach($arrparentid as $areaid)
	{
		$pos[] = $AREA[$areaid]['name'];
	}
	return join('.',$pos);
}

function magic_image($txt, $fonttype = 4)
{
	if(empty($txt)) return false;
	if(function_exists("imagepng"))
	{
		$txt = urlencode(phpcms_auth($txt, 'ENCODE', AUTH_KEY));
		$txt = '<img src="'.PHPCMS_PATH.'magic_image.php?gd=1&fonttype='.$fonttype.'&txt='.$txt.'" align="absmiddle">';
	}
	return $txt;
}

function _base64_encode($t,$str)
{
	return $t."\"".base64_encode($str)."\"";
}
function _base64_decode($t,$str)
{
	return $t."\"".base64_decode($str)."\"";
}

function keylinks($txt, $replacenum = '')
{
	$search = "/(alt\s*=\s*|title\s*=\s*)[\"|\'](.+?)[\"|\']/ise";
	$replace = "_base64_encode('\\1','\\2')";
	$replace1 = "_base64_decode('\\1','\\2')";
	$txt = preg_replace($search, $replace, $txt);
	$linkdatas = cache_read('keylink.php','',1);
	if($linkdatas)
	{
		$word = $replacement = array();
		foreach($linkdatas as $v)
		{
			$word1[] = '/'.preg_quote($v[0], '/').'/';
			$word2[] = $v[0];
			$replacement[] = '<a href="'.$v[1].'" target="_blank" class="keylink">'.$v[0].'</a>';
		}
		if($replacenum != '')
		{
			$txt = preg_replace($word1, $replacement, $txt, $replacenum);
		}
		else
		{
			$txt = str_replace($word2, $replacement, $txt);
		}
	}
	$txt = preg_replace($search, $replace1, $txt);
	return $txt;
}


function url_par($par, $url = '')
{
	if($url == '') $url = URL;
	$pos = strpos($url, '?');
	if($pos === false)
	{
		$url .= '?'.$par;
	}
	else
	{
		$querystring = substr(strstr($url, '?'), 1);
		parse_str($par, $pars);
		foreach($pars as $k=>$v)
		{
			$querystring = _url_par($k, $v, $querystring);
		}
		$url = substr($url, 0, $pos).'?'.$querystring;
	}
	return $url;
}

function _url_par($var, $value, $querystring)
{
	if($querystring)
	{
		$pattern = "/([&]?)(".preg_quote($var)."\=)([^&]+)([&]?)/";
		$querystring = preg_match($pattern, $querystring) ? preg_replace($pattern, '${1}${2}'.$value.'${4}', $querystring) : $querystring."&$var=$value";
	}
	else
	{
		$querystring = $var.'='.$value;
	}
	return $querystring;
}

function username($userid)
{
	global $db;
	$userid = intval($userid);
	$r = $db->get_one("SELECT `username` FROM `".DB_PRE."member_cache` WHERE `userid`=$userid");
	return $r ? $r['username'] : false;
}

function userid($username)
{
	global $db;
	$r = $db->get_one("SELECT `userid` FROM `".DB_PRE."member_cache` WHERE `username`='$username'");
	return $r ? $r['userid'] : false;
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
	error_log($err, 3, PHPCMS_ROOT.'/data/php_error_log.xml');
	@chmod(PHPCMS_ROOT.'/data/php_error_log.xml', 0777);
}

function contentpage($content = '', $maxpage = 10000)
{
	if($content=='') return $content;
	$html = array('div', 'span', 'p', 'a', 'h', 'ul', 'ol', 'li', 'table', 'form', 'script', 'strong', 'dl', 'dt', 'dd');
	$ar_content = explode('<', $content);
	$data = array();
	$i = $show_time = 0;
	if(is_array($ar_content))
	{
		foreach($ar_content as $y => $c)
		{
			if($y == 0)
			{
				$data[$i] = $c;
 				if(strlen(strip_tags($c))>=$maxpage)
				{
					$i++;
				}
				continue;
			}
			$data[$i] .= '<'.$c;
			if($tag=='' && $show_time==0)
			{
				foreach($html as $h)
				{
					if(strpos($c, $h)===0)
					{
						$tag = $h;
						$show_time++;
						break;
					}
				}
			}
			elseif($show_time && $tag)
			{
				if(strpos($c, $tag)===0)
				{
					$show_time++;
				}
				if(strpos($c, '/'.$tag)===0)
				{
					$show_time--;
					if($show_time==0) $tag = '';
				}
			}
			if(strlen(strip_tags($data[$i]))>=$maxpage && $show_time==0)
			{
				$i++;
			}
		}
	}
	$data = implode('[page]', $data);
	return $data;
}

function menu_linkage($linkageid = 0, $id = 'linkid', $defaultvalue = 0)
{
	global $action;
	$linkageid = intval($linkageid);
	$datas = array();
	$datas = @include PHPCMS_ROOT.'data/linkage/'.$linkageid.'.php';
	$infos = $datas['data'];
	if($action=='edit')
	{
		$title = $infos[$defaultvalue]['name'];
	}
	else
	{
		$title = $datas['title'];
	}
	
	$colObj = random(3).date('is');
	$string = '';
	if(!defined('LINKAGE_INIT'))
	{
		define('LINKAGE_INIT', 1);
		$string .= '<script type="text/javascript" src="images/linkage/js/mln.colselect.js"></script>';
		if(defined('IN_ADMIN'))
		{
			$string .= '<link href="images/linkage/style/admin.css" rel="stylesheet" type="text/css">';
		} 
		else
		{
			$string .= '<link href="images/linkage/style/css.css" rel="stylesheet" type="text/css">';
		}
	}
	$string .= '<input type="hidden" name="info['.$id.']" value="1"><div id="'.$id.'"></div>';
	$string .= '<script type="text/javascript">';
	$string .= 'var colObj'.$colObj.' = {"Items":[';
	
	foreach($infos AS $k=>$v)
	{
		$s .= '{"name":"'.$v['name'].'","topid":"'.$v['parentid'].'","colid":"'.$k.'","value":"'.$k.'","fun":function(){}},';
	}

	$string .= substr($s, 0, -1);
	$string .= ']};';
	$string .= '$("#'.$id.'").mlnColsel(colObj'.$colObj.',{';
	$string .= 'title:"'.$title.'",';
	$string .= 'value:"'.$defaultvalue.'",';
	$string .= 'width:100';
	$string .= '});';
	$string .= '</script>';
	return $string;
}
?>