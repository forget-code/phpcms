<?php
$mtime = explode(' ', microtime());
$phpcms_starttime = $mtime[1] + $mtime[0];
unset($LANG, $_REQUEST, $HTTP_ENV_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_POST_FILES, $HTTP_COOKIE_VARS);
set_magic_quotes_runtime(0);
define('IN_PHPCMS', TRUE);
define('PHPCMS_ROOT', str_replace("\\", '/', substr(dirname(__FILE__), 0, -8)));
require PHPCMS_ROOT.'/include/global.func.php';

$search_arr = array("/ union /i","/ select /i","/ update /i","/ outfile /i","/ or /i");
$replace_arr = array('&nbsp;union&nbsp;','&nbsp;select&nbsp;','&nbsp;update&nbsp;','&nbsp;outfile&nbsp;','&nbsp;or&nbsp;');
$_POST = strip_sql($_POST);
$_GET = strip_sql($_GET);
$_COOKIE = strip_sql($_COOKIE);
unset($search_arr, $replace_arr);

$magic_quotes_gpc = get_magic_quotes_gpc();
if(!$magic_quotes_gpc)
{
	$_POST = new_addslashes($_POST);
	$_GET = new_addslashes($_GET);
}
@extract($_POST, EXTR_OVERWRITE);
@extract($_GET, EXTR_OVERWRITE);
unset($_POST, $_GET);

require PHPCMS_ROOT.'/config.inc.php';
require PHPCMS_ROOT.'/languages/'.$CONFIG['language'].'/phpcms.lang.php';

define('PHPCMS_PATH', $CONFIG['rootpath']);
define('PHPCMS_CACHEDIR', $CONFIG['cachedir']);
$CONFIG['enablephplog'] ? set_error_handler('phpcms_error') : error_reporting(E_ERROR | E_WARNING | E_PARSE);
if($CONFIG['sessionsavepath']) session_save_path($CONFIG['sessionsavepath']);
session_start();
if(function_exists('date_default_timezone_set')) date_default_timezone_set($CONFIG['timezone']);
header('Content-type: text/html; charset='.$CONFIG['charset']);
if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown'))
{
	$PHP_IP = getenv('HTTP_CLIENT_IP');
}
elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
{
	$PHP_IP = getenv('HTTP_X_FORWARDED_FOR');
}
elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown'))
{
	$PHP_IP = getenv('REMOTE_ADDR');
}
elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
{
	$PHP_IP = $_SERVER['REMOTE_ADDR'];
}
preg_match("/[\d\.]{7,15}/", $PHP_IP, $ipmatches);
$PHP_IP = $ipmatches[0] ? $ipmatches[0] : 'unknown';
$PHP_TIME = time();
$PHP_SELF = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);
$PHP_QUERYSTRING = $_SERVER['QUERY_STRING'];
$PHP_DOMAIN = $_SERVER['SERVER_NAME'];
$PHP_REFERER = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$PHP_SCHEME = $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
$PHP_PORT = $_SERVER['SERVER_PORT'] == '80' ? '' : ':'.$_SERVER['SERVER_PORT'];
$PHP_SITEURL = $PHP_SCHEME.$PHP_DOMAIN.$PHP_PORT.PHPCMS_PATH;
$PHP_URL = $PHP_SCHEME.$PHP_DOMAIN.$PHP_PORT.$PHP_SELF.($PHP_QUERYSTRING ? '?'.$PHP_QUERYSTRING : '');
$db_file = $db_class = 'db_'.$CONFIG['database'];

if(!defined('IN_ADMIN'))
{
	if($CONFIG['dbiscache']) $db_file .= '_cache';
	if($CONFIG['phpcache'] == '2')
	{
		$cachefileid = md5($PHP_SELF.'?'.$PHP_QUERYSTRING);
		$cachefiledir = PHPCMS_ROOT.'/data/phpcache/'.substr($cachefileid, 0, 2).'/';
		$cachefile = $cachefiledir.$cachefileid.'.html';
		if(file_exists($cachefile) && ($PHP_TIME < @filemtime($cachefile) + $CONFIG['phpcacheexpires']))
		{
			require $cachefile;
			exit;
		}
	}
	if($PHP_QUERYSTRING && preg_match("/^(.*)\.(htm|html|shtm|shtml)$/", $PHP_QUERYSTRING, $urlvar))
	{
		parse_str(str_replace(array('/', '-', ' '), array('&', '=', ''), $urlvar[1]));
	}
	
}

require PHPCMS_ROOT.'/include/'.$db_file.'.class.php';
require PHPCMS_ROOT.'/include/tag.func.php';
require PHPCMS_ROOT.'/include/extension.inc.php';
$db = new $db_class;
$db->connect($CONFIG['dbhost'], $CONFIG['dbuser'], $CONFIG['dbpw'], $CONFIG['dbname'], $CONFIG['pconnect']);
$db->iscache = $CONFIG['dbiscache'];
$db->expires = $CONFIG['dbexpires'];

if(!cache_read('table.php'))
{
	require_once PHPCMS_ROOT.'/include/cache.func.php';
    cache_all();
}
$CACHE = cache_read('common.php');
$MODULE = $CACHE['module'];
$CHANNEL = $CACHE['channel'];
$PHPCMS = $CACHE['phpcms'];
$FIELD = $CACHE['field'];
unset($CACHE, $ipmatches, $CONFIG['timezone'], $CONFIG['cachedir'], $CONFIG['dbhost'], $CONFIG['dbuser'], $CONFIG['dbpw'], $CONFIG['pconnect'], $CONFIG['dbiscache'], $CONFIG['dbexpires']);

if($PHPCMS['enablebanip'] && ip_banned($PHP_IP)) showmessage($LANG['administrator_banned_this_IP']);

$TEMP = $MOD = $CHA = $CATEGORY = $CAT = array();
$ftp = $enableftp = $tags = $html = 0;
if(!isset($mod))
{
	$mod = 'phpcms';
}
elseif($mod != 'phpcms')
{
	isset($MODULE[$mod]) or exit($LANG['module_not_exists']);
	$MOD = cache_read($mod.'_setting.php');
	@include PHPCMS_ROOT.'/languages/'.(defined('IN_ADMIN') ? $CONFIG['adminlanguage'].'/'.$mod.'_admin.lang.php' : $CONFIG['language'].'/'.$mod.'.lang.php');
}

if(!isset($forward)) $forward = $PHP_REFERER;
$dosubmit = isset($dosubmit) ? 1 : 0;
$channelid = isset($channelid) ? intval($channelid) : 0;
$skindir = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$CONFIG['defaultskin'];
if($PHPCMS['enablegzip'] && function_exists('ob_gzhandler'))
{
	($CONFIG['phpcache'] || defined('SHOWJS')) ? ob_start() : ob_start('ob_gzhandler');
}
else
{
	$PHPCMS['enablegzip'] = 0;
	ob_start();
}

$_userid = 0;
$_username = '';
$_groupid = 3;
$_arrgroupid = array();
$phpcms_auth = getcookie('auth');
if($phpcms_auth)
{
	$phpcms_auth_key = md5($PHPCMS['authkey'].$_SERVER['HTTP_USER_AGENT']);
	list($_userid, $_password, $_answer) = $phpcms_auth ? explode("\t", phpcms_auth($phpcms_auth, 'DECODE')) : array(0, '', '');
	$_userid = intval($_userid);
	if($_userid < 0) $_userid = 0;
	if($_userid)
	{
		$memberinfo = $db->get_one("SELECT username,password,groupid,arrgroupid,email,chargetype,begindate,enddate,money,point,credit,newmessages FROM ".TABLE_MEMBER." WHERE userid=$_userid LIMIT 0,1");
		if($memberinfo && $memberinfo['password'] == $_password)
		{
			if($memberinfo['groupid'] == 2)
			{
                mkcookie('auth', '');
				showmessage($LANG['userid_banned_by_administrator']);
			}
			@extract($memberinfo, EXTR_PREFIX_ALL, '');
			unset($memberinfo, $_password, $_answer);
			$_arrgroupid = $_arrgroupid ? array_filter(explode(',', $_arrgroupid)) : array(); 
		}
		else
		{
			mkcookie('auth', '');
		}
	}
}
unset($db_class, $db_file, $phpcms_auth, $phpcms_auth_key, $memberinfo);
?>