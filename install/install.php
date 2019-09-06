<?php
error_reporting(E_ERROR);
@set_time_limit(1000);
set_magic_quotes_runtime(0);
define('TIME', time());
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
define('PHPCMS_ROOT', str_replace("\\", '/', dirname(__FILE__)).'/');
if(file_exists(PHPCMS_ROOT.'data/install.lock')) exit('您已经安装过PHPCMS,如果需要重新安装，请删除 ./data/install.lock 文件！');
define('IN_PHPCMS',true);
set_include_path(PHPCMS_ROOT.'include/');

require 'config.inc.php';
require 'version.inc.php';
require 'global.func.php';
require 'admin/global.func.php';
require 'dir.func.php';

define('IP', ip());
define('SCRIPT_NAME', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : preg_replace("/(.*)\.php(.*)/i", "\\1.php", $_SERVER['PHP_SELF']));
define('QUERY_STRING', $_SERVER['QUERY_STRING']);
define('PATH_INFO', isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '');
define('DOMAIN', isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : preg_replace("/([^:]*)[:0-9]*/i", "\\1", $_SERVER['HTTP_HOST']));
define('SCHEME', $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://');
define('SITE_URL', SCHEME.$_SERVER['HTTP_HOST'].PHPCMS_PATH);
define('RELATE_URL', isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : SCRIPT_NAME.(QUERY_STRING ? '?'.QUERY_STRING : PATH_INFO));
define('URL', SCHEME.$_SERVER['HTTP_HOST'].RELATE_URL);
define('SKIN_PATH', 'templates/default/skins/default/phpcms');

$siteUrl = SCHEME.dirname($_SERVER['HTTP_HOST'].$_SERVER["SCRIPT_NAME"]);

if($_REQUEST)
{
	if(!MAGIC_QUOTES_GPC)
	{
		$_REQUEST = new_addslashes($_REQUEST);
		if($_COOKIE) $_COOKIE = new_addslashes($_COOKIE);
	}
	extract($_REQUEST, EXTR_SKIP);
}

header('Content-type: text/html; charset='.CHARSET);

$steps = include PHPCMS_ROOT.'install/step.inc.php';
if(!isset($step)) $step = '1';

if(strrpos(strtolower(PHP_OS),"win") === FALSE)
{
	define('ISUNIX', TRUE);
}
else
{
	define('ISUNIX', FALSE);
}
$mode = 0777;

switch($step)
{
    case '1': //安装须知
		include PHPCMS_ROOT."install/step".$step.".tpl.php";

		break;
	case '2': //许可协议
		$license = file_get_contents(PHPCMS_ROOT."install/license.txt");
		include PHPCMS_ROOT."install/step".$step.".tpl.php";
		break;

	case '3': //环境检测 (FTP帐号设置）
        $PHP_GD = '';
		if(extension_loaded('gd'))
	    {
			if(function_exists('imagepng')) $PHP_GD .= 'png';
			if(function_exists('imagejpeg')) $PHP_GD .= ' jpg';
			if(function_exists('imagegif')) $PHP_GD .= ' gif';
		}
        $PHP_DNS = preg_match("/^[0-9.]{7,15}$/", @gethostbyname('www.phpcms.cn')) ? 1 : 0;
		//是否满足phpcms安装需求
		$is_right = (phpversion() >= '4.3.0' && extension_loaded('mysql') && ini_get('short_open_tag')) ? 1 : 0;
		include PHPCMS_ROOT."install/step".$step.".tpl.php";
		break;
	case '4': //选择安装模块
		require PHPCMS_ROOT.'/install/modules.inc.php';

		include PHPCMS_ROOT."install/step".$step.".tpl.php";
		break;

	case '5': //设置目录属性
		$selectmod = isset($selectmod) ? ','.implode(',', $selectmod) : '';
		$selectmod = 'phpcms,member'.$selectmod;
		$selectmods = explode(',',$selectmod);
		$selectmods = explode(',',$selectmod);
		foreach($selectmods AS $dir)
		{
			if($dir == 'phpcms')
			{
				$files = file(PHPCMS_ROOT."install/chmod.txt");
			}
			else
			{
				$files = file(PHPCMS_ROOT.$dir."/install/chmod.txt");
			}
			$files = array_filter($files);
			foreach($files as $file)
			{
				$file = str_replace('*','',$file);
				$file = trim($file);
				if(is_dir($file))
				{
					$cname = '目录';
				}
				else
				{
					$cname = '文件';
				}
				if(!is_writable(PHPCMS_ROOT.$file)) $no_writablefile .= $file.' '.$cname."不可写<br>";
			}
		}
		if(dir_create(PHPCMS_ROOT.'test_create_dir',0777))
		{
			sleep(1);
			dir_delete(PHPCMS_ROOT.'test_create_dir');
		}
		else
		{
			$no_writablefile = "网站根目录不可写<br>".$no_writablefile;
		}
		include PHPCMS_ROOT."install/step".$step.".tpl.php";
		break;

	case '6': //配置帐号 （MYSQL帐号、管理员帐号、）

		include PHPCMS_ROOT."install/step".$step.".tpl.php";
		break;

	case '7': //安装详细信息-完成安装

		include PHPCMS_ROOT."install/step".$step.".tpl.php";
		break;

	case 'installmodule': //执行SQL
		if($module == 'phpcms')
		{
			$cookie_pre = random(10, 'abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ');
			$auth_key = random(20, 'abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ');
			$PHP_SELF = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);
			$rootpath = str_replace("\\","/",dirname($PHP_SELF));
			$rootpath = strlen($rootpath)>1 ? $rootpath."/" : "/";
			$config = array('DB_HOST'=>$dbhost,
						'DB_USER'=>$dbuser,
						'DB_PW'=>$dbpw,
						'DB_NAME'=>$dbname,
						'DB_PRE'=>$tablepre,
						'PHPCMS_PATH'=>$rootpath,
						'DB_PCONNECT'=>$pconnect,
						'DB_CHARSET'=>$dbcharset,
						'COOKIE_PRE'=>$cookie_pre,
						'PHPCMS_PATH'=>$rootpath,
						'AUTH_KEY'=>$auth_key,
						'ADMIN_EMAIL'=>$email,
						'PASSWORD_KEY'=>$password_key,
						);
			set_config($config);

			$config_js = "var phpcms_path = '$rootpath';\nvar cookie_pre = '$cookie_pre';\nvar cookie_domain = '';\nvar cookie_path = '/';";

			file_put_contents(PHPCMS_ROOT.'data/config.js', $config_js);
			@chmod(PHPCMS_ROOT.'data/config.js', 0777);
			$dbclass = 'db_'.DB_DATABASE;
			require $dbclass.'.class.php';

			$db = new $dbclass;
			$connid = $db->connect($dbhost, $dbuser, $dbpw, '', $pconnect);
			$version = mysql_get_server_info($connid);
			if($version > '4.1' && $dbcharset)
			{
				mysql_query("SET NAMES '$dbcharset'" , $connid);
			}
			if($version > '5.0')
			{
				mysql_query("SET sql_mode=''" , $connid);
			}
			if(!@$db->select_db($dbname))
			{
				@$db->query("CREATE DATABASE $dbname");
				if(@$db->error()) {
					echo 1;exit;
				} else {
					$db->select_db($dbname);
				}
			}

			if(file_exists(PHPCMS_ROOT."install/main/phpcms.sql"))
			{
				$sql = file_get_contents(PHPCMS_ROOT."install/main/phpcms.sql");
				_sql_execute($sql);

			}
			else
			{
				echo 2;//数据库文件不存在
			}
            dir_copy(PHPCMS_ROOT.'install/templates/', PHPCMS_ROOT.'templates/'.TPL_NAME.'/phpcms/');
			$data = file_get_contents(PHPCMS_ROOT.'templates/'.TPL_NAME.'/phpcms/tag_config.inc.php');
			$data = str_replace('phpcms2008_', $tablepre, $data);
			file_put_contents(PHPCMS_ROOT.'templates/'.TPL_NAME.'/phpcms/tag_config.inc.php', $data);
		}
		else
		{
			$dbclass = 'db_'.DB_DATABASE;
			require $dbclass.'.class.php';

			$db = new $dbclass;
			$db->connect(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_PCONNECT, DB_CHARSET);
			$db->query("DELETE FROM `".DB_PRE."module` WHERE module='$module'");
			if(file_exists(PHPCMS_ROOT.$module."/install/mysql.sql"))
			{
				$sql = file_get_contents(PHPCMS_ROOT.$module."/install/mysql.sql");
				sql_execute($sql);
			}
			else
			{
				echo 2;//数据库文件不存在
				exit;
			}
			if(file_exists(PHPCMS_ROOT.$module."/install/extention.inc.php"))
			{
				@extract($db->get_one("SELECT menuid AS member_0 FROM ".DB_PRE."menu WHERE keyid='member_0'"));
				@extract($db->get_one("SELECT menuid AS member_1 FROM ".DB_PRE."menu WHERE keyid='member_1'"));
				@include (PHPCMS_ROOT.$module."/install/extention.inc.php");
			}

			if(file_exists(PHPCMS_ROOT.$module."/install/templates/"))
			{
				dir_copy(PHPCMS_ROOT.$module."/install/templates/", PHPCMS_ROOT.'templates/'.TPL_NAME.'/'.$module.'/');
			}
			if(file_exists(PHPCMS_ROOT.$module."/install/languages/"))
			{
				dir_copy(PHPCMS_ROOT.$module.'/install/languages/', PHPCMS_ROOT.'languages/'.LANG.'/');
			}
			if(file_exists(PHPCMS_ROOT.'templates/'.TPL_NAME.'/'.$module.'/tag_config.inc.php'))
			{
				$data = file_get_contents(PHPCMS_ROOT.'templates/'.TPL_NAME.'/'.$module.'/tag_config.inc.php');
				$data = str_replace('phpcms2008_',DB_PRE,$data);
				file_put_contents(PHPCMS_ROOT.'templates/'.TPL_NAME.'/'.$module.'/tag_config.inc.php',$data);
			}
			if($module == 'member')
			{
				//建立管理员帐号
				if(CHARSET=='gbk') $username = iconv('UTF-8','GBK',$username);
				$password = md5(PASSWORD_KEY.$password);
				$db->query("INSERT INTO ".DB_PRE."admin (`userid`,`username`,`allowmultilogin`,`alloweditpassword`,`editpasswordnextlogin`,`disabled`) VALUES ('1','$username',1,1,0,0)");
				$db->query("INSERT INTO ".DB_PRE."admin_role (`userid`, `roleid`) VALUES(1, 1)");
				$db->query("INSERT INTO ".DB_PRE."member (`userid`,`username`,`password`,`email`,`groupid`,`modelid`) VALUES ('1','$username','$password','$email',1,10)");
				$db->query("INSERT INTO ".DB_PRE."member_info (`userid`,`regip`,`regtime`) VALUES ('1','".IP."','".TIME."')");
			}
		}
		echo $module;
		break;

	case 'dbtest':
		if(!mysql_connect($dbhost, $dbuser, $dbpw)) exit('2');
		$server_info = mysql_get_server_info();
		if($server_info < '4.0') exit('6');
		if(!mysql_select_db($dbname))
	    {
			if(!@mysql_query("CREATE DATABASE `$dbname`")) exit('3');
			mysql_select_db($dbname);
		}
		$tables = array();
		$query = mysql_list_tables($dbname);
		while($r = mysql_fetch_row($query))
		{
			$tables[] = $r[0];
		}
		if($tables && in_array($tablepre.'module', $tables))
	    {
			exit('0');
		}
		else
		{
			exit('1');
		}
		break;

	case 'cache_all':

		$dbclass = 'db_'.DB_DATABASE;
		require $dbclass.'.class.php';
		$db = new $dbclass;
		$db->connect(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_PCONNECT, DB_CHARSET);

		require 'cache.func.php';
		cache_all();
		$cache = cache_read('common.php');

		tags_update(array_keys($cache['MODULE']));

		require 'admin/model.class.php';
        $model = new model();
		$model->cache();
		$model->cache_field(1);
		$model->cache_field(2);
		$model->cache_field(3);
		$model->cache_field(4);
		$model->cache_field(5);
		require 'member/admin/include/model_member.class.php';
		$member_model = new member_model();
		$member_model->cache();
		$member_model->cache_field(10);

        file_put_contents(PHPCMS_ROOT.'data/install.lock','');
		copy(PHPCMS_ROOT."install/cms_index.html",PHPCMS_ROOT."index.html");
		$head['title'] = '网站地图';
		ob_start();
		include template('phpcms', 'sitemap');
		$file = PHPCMS_ROOT.'sitemap.html';
		createhtml($file);
		require 'session_'.SESSION_STORAGE.'.class.php';
		$session = new session();
		session_set_cookie_params(0, COOKIE_PATH, COOKIE_DOMAIN);
		session_start();
		$_SESSION['install_system'] = 1;
		@unlink(PHPCMS_ROOT.'install.php');
		break;
	case 'testdata':
		$dbclass = 'db_'.DB_DATABASE;
		require $dbclass.'.class.php';

		$db = new $dbclass;
		$db->connect(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_PCONNECT, DB_CHARSET);
		if(file_exists(PHPCMS_ROOT."install/main/testsql.sql"))
		{
			$sql = file_get_contents(PHPCMS_ROOT."install/main/testsql.sql");
			sql_execute($sql);
		}
		break;
	case 'ftpset':
		if(!$ftphost || !$ftpuser) exit("<script>alert('请填写ftp服务器和ftp帐号！');</script>");
		$ftp = ftp_connect($ftphost, $ftpport, 90);
		if(!$ftp) exit("<script>alert('设置错误！无法连接到FTP服务器 ');</script>");
		$testlogin = ftp_login($ftp, $ftpuser, $ftppass);
		if(!$testlogin) exit("<script>alert('帐号或密码错误 ');</script>");
		if($ftpwebpath=='') $ftpwebpath = '/';
		$testchdir = ftp_chdir($ftp, $ftpwebpath);
		if(!$testchdir) exit("<script>alert('网站根目录相对FTP根目录".$ftpwebpath."的路径设置错误！');</script>");
		$config = array('FTP_ENABLE'=>1,
						'FTP_HOST'=>$ftphost,
						'FTP_PORT'=>$ftpport,
						'FTP_USER'=>$ftpuser,
						'FTP_PW'=>$ftppass,
						'FTP_PATH'=>$ftpwebpath
						);

		require 'ftp.class.php';
		$f = new ftp($ftphost, $ftpport, $ftpuser, $ftppass, $ftpwebpath);
		$selectmods = explode(',',$selectmod);

		foreach($selectmods AS $dir)
		{
			if($dir == 'phpcms')
			{
				$files = file(PHPCMS_ROOT."install/chmod.txt");
			}
			else
			{
				$files = file(PHPCMS_ROOT.$dir."/install/chmod.txt");
			}
			$files = array_filter($files);
			foreach($files as $file)
			{
				$file = trim($file);
				$f->dir_chmod($file, $mode);
			}
		}
		set_config($config);
		exit("<script>alert('设置成功，请刷新重新检测！');parent.location.reload();</script>");
		break;

	case 'ftpdir_list':
		require_once 'ftp.class.php';
		require_once 'form.class.php';
		$ftp = new ftp($ftphost, $ftpport, $ftpuser, $ftppw, '');
		if($ftp->error)
	    {
			exit($ftp->error);
		}
		else
	    {
			$dirs = $ftp->nlist($path);
			if($dirs)
			{
				$options = $path == '/' ? array('/'=>'/') : array(''=>'请选择');
				foreach($dirs as $k=>$v)
				{
					if(!str_exists($v, '.')) $options[$v] = $v;
				}
				if(count($options) > 1)
				{
					echo form::select($options, 'dirlist', 'dirlist', '', 1, '', 'onchange="$(\'#ftpwebpath\').val(this.value == \'/\' ? \'/\' : \''.$path.'\'+this.value+\'/\');ftpdir_list(\''.$path.'\'+this.value+\'/\')"');
				}
			}
		}
		break;
}

function _sql_execute($sql)
{
	global $db;
    $sqls = _sql_split($sql);
	if(is_array($sqls))
    {
		foreach($sqls as $sql)
		{
			if(trim($sql) != '')
			{
				$db->query($sql);
			}
		}
	}
	else
	{
		$db->query($sqls);
	}
	return true;
}

function _sql_split($sql)
{
	global $db,$dbcharset,$tablepre;
	if($db->version() > '4.1' && $dbcharset)
	{
		$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "TYPE=\\1 DEFAULT CHARSET=".$dbcharset,$sql);
	}
	if($tablepre != "phpcms_") $sql = str_replace("phpcms_", $tablepre, $sql);
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	foreach($queriesarray as $query)
	{
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		$queries = array_filter($queries);
		foreach($queries as $query)
		{
			$str1 = substr($query, 0, 1);
			if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
		}
		$num++;
	}
	return $ret;
}
?>