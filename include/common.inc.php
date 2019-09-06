<?php
define('PHPCMS_ROOT', str_replace("\\", '/', substr(dirname(__FILE__), 0, -7)));
define('MICROTIME_START', microtime());
define('IN_PHPCMS', TRUE);
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
define('TIME', time());
set_include_path(PHPCMS_ROOT.'include/');
set_magic_quotes_runtime(0);
unset($LANG, $HTTP_ENV_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_POST_FILES, $HTTP_COOKIE_VARS);

require 'config.inc.php';
require 'global.func.php';
require 'dir.func.php';
require 'url.func.php';
require 'output.class.php';
require 'priv_group.class.php';
require 'times.class.php';
require PHPCMS_ROOT.'languages/'.LANG.'/phpcms.lang.php';

ERRORLOG ? set_error_handler('phpcms_error') : error_reporting(E_ERROR | E_WARNING | E_PARSE);

define('IP', ip());
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
define('SCRIPT_NAME', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : preg_replace("/(.*)\.php(.*)/i", "\\1.php", $_SERVER['PHP_SELF']));
define('QUERY_STRING', safe_replace($_SERVER['QUERY_STRING']));
define('PATH_INFO', isset($_SERVER['PATH_INFO']) ? safe_replace($_SERVER['PATH_INFO']) : '');
define('DOMAIN', isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : preg_replace("/([^:]*)[:0-9]*/i", "\\1", $_SERVER['HTTP_HOST']));
define('SCHEME', $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://');
define('SITE_URL', SCHEME.$_SERVER['HTTP_HOST'].PHPCMS_PATH);
define('RELATE_URL', isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : SCRIPT_NAME.(QUERY_STRING ? '?'.QUERY_STRING : PATH_INFO));
define('URL', SCHEME.$_SERVER['HTTP_HOST'].RELATE_URL);
define('RELATE_REFERER',urlencode(RELATE_URL));
define('CACHE_FORM', PHPCMS_ROOT.'data/formguide/');

if(function_exists('date_default_timezone_set')) date_default_timezone_set(TIMEZONE);
header('Content-type: text/html; charset='.CHARSET);

if(CACHE_PAGE && !defined('IN_ADMIN')) cache_page_start();
if(GZIP && function_exists('ob_gzhandler'))
{
	ob_start('ob_gzhandler');
}
else
{
	ob_start();
}

$dbclass = 'db_'.DB_DATABASE;
require $dbclass.'.class.php';

$db = new $dbclass;
$db->connect(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_PCONNECT, DB_CHARSET);

require 'session_'.SESSION_STORAGE.'.class.php';
$session = new session();
session_set_cookie_params(0, COOKIE_PATH, COOKIE_DOMAIN);

if($_REQUEST)
{
	if(MAGIC_QUOTES_GPC)
	{
		$_REQUEST = new_stripslashes($_REQUEST);
		if($_COOKIE) $_COOKIE = new_stripslashes($_COOKIE);
		extract($db->escape($_REQUEST), EXTR_SKIP);
	}
	else
	{
		$_POST = $db->escape($_POST);
		$_GET = $db->escape($_GET);
		$_COOKIE = $db->escape($_COOKIE);
		@extract($_POST,EXTR_SKIP);
		@extract($_GET,EXTR_SKIP);
		@extract($_COOKIE,EXTR_SKIP);
	}
	if(!defined('IN_ADMIN')) $_REQUEST = filter_xss($_REQUEST, ALLOWED_HTMLTAGS);
	if($_COOKIE) $db->escape($_COOKIE);
}
if(QUERY_STRING && strpos(QUERY_STRING, '=') === false && preg_match("/^(.*)\.(htm|html|shtm|shtml)$/", QUERY_STRING, $urlvar))
{
	parse_str(str_replace(array('/', '-', ' '), array('&', '=', ''), $urlvar[1]));
}

$CACHE = cache_read('common.php');
if(!$CACHE)
{
	require_once 'cache.func.php';
	cache_all();
	$CACHE = cache_read('common.php');
}
extract($CACHE);
unset($CACHE);

if($PHPCMS['enable_ipbanned'] && ip_banned(IP)) showmessage($LANG['administrator_banned_this_IP']);
if(!defined('IN_ADMIN'))
{
	if(FILTER_ENABLE && filter_word()) showmessage('The content including illegal information: '.ILLEGAL_WORD.' .');
    if($PHPCMS['minrefreshtime'])
	{
		$cc = new times();
		$cc->set('cc', $PHPCMS['minrefreshtime'], 1);
		if($cc->check()) showmessage('Do not refresh the page in '.$PHPCMS['minrefreshtime'].' seconds!');
		$cc->add();
		unset($cc);
	}
    if(!isset($forward)) $forward = HTTP_REFERER;
}

$M = $TEMP = array();
if(!isset($mod)) $mod = 'phpcms';
if($mod != 'phpcms')
{
	isset($MODULE[$mod]) or exit($LANG['module_not_exists']);
	$langfile = defined('IN_ADMIN') ? $mod.'_admin' : $mod;
	@include PHPCMS_ROOT.'languages/'.LANG.'/'.$langfile.'.lang.php';
	$M = cache_read('module_'.$mod.'.php');
}

$_userid = 0;
$_username = '';
$_groupid = 3;
$phpcms_auth = get_cookie('auth');
if($phpcms_auth)
{
	$auth_key = md5(AUTH_KEY.$_SERVER['HTTP_USER_AGENT']);
	list($_userid, $_password) = explode("\t", phpcms_auth($phpcms_auth, 'DECODE', $auth_key));
	$_userid = intval($_userid);
	$sql_member = "SELECT * FROM `".DB_PRE."member_cache` WHERE `userid`=$_userid";
	$r = $db->get_one($sql_member);
	if(!$r && cache_member())
	{
		$r = $db->get_one($sql_member);
	}
	if($r && $r['password'] === $_password)
	{
		if($r['groupid'] == 2)
		{
			set_cookie('auth', '');
			showmessage($LANG['userid_banned_by_administrator']);
		}
		@extract($r, EXTR_PREFIX_ALL, '');
	}
	else
	{
		$_userid = 0;
		$_username = '';
		$_groupid = 3;
		set_cookie('auth', '');
	}
	unset($r, $phpcms_auth, $phpcms_auth_key, $_password, $sql_member);
}
$G = cache_read('member_group_'.$_groupid.'.php');
$priv_group = new priv_group();
define('SKIN_PATH', 'templates/'.TPL_NAME.'/skins/'.TPL_CSS.'/');
define('PASSPORT_ENABLE', ($PHPCMS['uc'] || $PHPCMS['enablepassport'] || $PHPCMS['enableserverpassport']) ? 1 : 0);

if($PHPCMS['publish']) {
	$content_publisharr = cache_read('publish.php');
	if(is_array($content_publisharr)) {
		foreach($content_publisharr as $k=>$v) {
			if($v < TIME) {
				$tmp_contentid[] = $k;
				unset($content_publisharr[$k]);
			}
		}
	}
	if(isset($tmp_contentid)) {
		require_once 'admin/content.class.php';
		require_once 'attachment.class.php';
		$attachment = new attachment($mod, 0);
		$c = new content();
		$res = $c->status($tmp_contentid, 99, 1);
		cache_write('publish.php', $content_publisharr);	
		unset($c);
		unset($attachment);
		unset($tmp_contentid);
	}
	unset($content_publisharr);
}
?>