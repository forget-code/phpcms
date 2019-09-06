<?php
/*
*######################################
* PHPCMS v3.0.0 - Advanced Content Manage System.
* Copyright (c) 2004-2005 phpcms.cn
*
* For further information go to http://www.phpcms.cn/
* This copyright notice MUST stay intact for use.
*######################################
*/
error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);

define('IN_PHPCMS', TRUE);
define('PHPCMS_ROOT',dirname(__FILE__));

@set_time_limit(1000);

require PHPCMS_ROOT."/phpcms_version.php";
require PHPCMS_ROOT."/include/functions.php";
require PHPCMS_ROOT."/include/admin_functions.php";
require PHPCMS_ROOT."/class/file.php";
require PHPCMS_ROOT."/config.php";
require PHPCMS_ROOT."/class/db_".$database.".php";

header("content-type:text/html;charset=$charset"); 

@session_start();

$f = new phpcms_file;

$PHP_MODULE = @get_loaded_extensions();
$PHP_FTP = in_array('ftp',$PHP_MODULE) ? 1 : 0;
$PHP_OS = @getenv('OS');
$PHP_OS = $PHP_OS ? $PHP_OS : PHP_OS;
$PHP_DOMAIN = $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : '');
define("PHPCMS_SITEURL","http://".$PHP_DOMAIN.$rootpath);

$step = $_POST['step'] ? $_POST['step'] : $_GET['step'];
$step = isset($step) ? $step : 1;

switch($step)
{
    case '1':
		$_SESSION['enablesession'] = 1;
	    setcookie('enablecookie','1');
		$license = file_read(PHPCMS_ROOT."/install/license.txt");
		include PHPCMS_ROOT."/install/step".$step.".html";
		break;

    case '2':
		$PHP_SERVER = $_SERVER['SERVER_SOFTWARE'];
		$PHP_VERSION = phpversion();
		$PHP_MYSQL = in_array('mysql',$PHP_MODULE) ? 1 : 0;
        $PHP_GD = "";
        if(function_exists('imagepng')) $PHP_GD .= "png";
        if(function_exists('imagejpeg')) $PHP_GD .= " jpg";
        if(function_exists('imagegif')) $PHP_GD .= " gif";
		$PHP_MBSTRING = in_array('mbstring',$PHP_MODULE) ? 1 : 0;
		$PHP_ZLIB = in_array('zlib',$PHP_MODULE) ? 1 : 0;
        if(in_array('Zend Optimizer',$PHP_MODULE))
	    {
			ob_start();
			phpinfo();
			$phpinfo = ob_get_contents();
			ob_clean();
			preg_match("/Zend&nbsp;Optimizer&nbsp;v([0-9]+\.[0-9]+\.[0-9]+),/",$phpinfo,$info);
			$PHP_ZEND = $info[1];
		}
        $PHP_FOPENURL = @get_cfg_var("allow_url_fopen");
		$PHP_SAFEMODE = ini_get('safe_mode');
		$PHP_SESSION = $_SESSION['enablesession'] ? 1 : 0;
		$PHP_COOKIE = $_COOKIE['enablecookie'] ? 1 : 0;

		$install = 1;

        $mysql_version = explode("-",$PHP_MYSQLVERSION);
		$mysql_version = $mysql_version[0];
		if($PHP_VERSION < '4.2.0' || $PHP_ZEND< '2.5.10') $install = 0;

		include PHPCMS_ROOT."/install/step".$step.".html";
		break;

    case '3':
		$iswriteables = file_read(PHPCMS_ROOT."/install/iswriteable.txt");
	    $iswriteables = explode("\n",$iswriteables);
	    $iswriteables = array_map("trim",$iswriteables);
        foreach($iswriteables as $k=>$v)
        {
			if($v)
			{
				$files[] = $v;
				if(is_writeable(PHPCMS_ROOT."/".$v))
				{
				    $writeables[] = is_dir(PHPCMS_ROOT."/".$v) ? "目录可写" : "文件可写"; 
				}
				else
				{
				    $writeables[] = is_dir(PHPCMS_ROOT."/".$v) ? "<font color='red'>目录不可写</font>" : "<font color='red'>文件不可写</font>"; 
					if($PHP_FTP) $needftp = 1;
					$unwriteables[] = $v;
				}
			}
        }
		include PHPCMS_ROOT."/install/step".$step.".html";
		break;

    case '4':
		$PHP_SELF = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);
		$rootpath = str_replace("\\","/",dirname($PHP_SELF));
		$rootpath = strlen($rootpath)>1 ? $rootpath."/" : "/";

		include PHPCMS_ROOT."/install/step".$step.".html";
		break;

    case '5':
		$dbhost = $_POST['dbhost'];
		$dbuser = $_POST['dbuser'];
		$dbpw = $_POST['dbpw'];
		$dbname = $_POST['dbname'];
		$tablepre = $_POST['tablepre'];

		$rootpath = $_POST['rootpath'];

		$timestamp = time();

		define('PHPCMS_PATH', $rootpath);
		define("PHPCMS_CACHEDIR",$cachedir);

		$db = new db;
		$db->connect($dbhost, $dbuser, $dbpw, '', $pconnect);
		
		if(!@$db->select_db($dbname))
	    {
			@$db->query("CREATE DATABASE $dbname");
			if(@$db->error()) 
				message("指定的数据库不存在，系统也无法创建，请先通过其他方式建立好数据库！","goback");
			else
			    $db->select_db($dbname);
		}

		$query = mysql_list_tables($dbname);
		while($r = mysql_fetch_row($query))
		{
			$tables[] = $r[0];
		}
		if(is_array($tables) && in_array($tablepre."article",$tables)) $isoverwrite = 1;
		$usecookie = $_COOKIE['enablecookie'] ? 1 : 0;
		$admin_usecookie = $_SESSION['enablesession'] ? 0 : 1;

		$configfile = file_read(PHPCMS_ROOT."/config.php");
		$configfile = preg_replace("/[$]dbhost\s*\=\s*[\"'].*?[\"']/is", "\$dbhost = '$dbhost'", $configfile);
		$configfile = preg_replace("/[$]dbuser\s*\=\s*[\"'].*?[\"']/is", "\$dbuser = '$dbuser'", $configfile);
		$configfile = preg_replace("/[$]dbpw\s*\=\s*[\"'].*?[\"']/is", "\$dbpw = '$dbpw'", $configfile);
		$configfile = preg_replace("/[$]dbname\s*\=\s*[\"'].*?[\"']/is", "\$dbname = '$dbname'", $configfile);
		$configfile = preg_replace("/[$]tablepre\s*\=\s*[\"'].*?[\"']/is", "\$tablepre = '$tablepre'", $configfile);
		$configfile = preg_replace("/[$]rootpath\s*\=\s*[\"'].*?[\"']/is", "\$rootpath = '$rootpath'", $configfile);
		$configfile = preg_replace("/[$]usecookie\s*\=\s*[\"'].*?[\"']/is", "\$usecookie = '".$usecookie."'", $configfile);
		$configfile = preg_replace("/[$]admin_usecookie\s*\=\s*[\"'].*?[\"']/is", "\$admin_usecookie = '".$admin_usecookie."'", $configfile);
		file_write(PHPCMS_ROOT."/config.php",$configfile);

		include PHPCMS_ROOT."/install/step".$step.".html";
		break;

    case '6':
		include PHPCMS_ROOT."/include/cache.php";
		include PHPCMS_ROOT."/include/template.php";
		include PHPCMS_ROOT."/include/tag.php";

		$timestamp = time();
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];

		define('PHPCMS_PATH', $rootpath);
		define("PHPCMS_CACHEDIR",$cachedir);

		$db = new db;
		$db->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);

		$sql = file_read(PHPCMS_ROOT."/install/phpcms.sql");
		$dbresult = runquery($sql);

		if(file_exists(PHPCMS_ROOT."/data/ftp.php") && strrpos(strtolower($PHP_OS),"win")===false && @ini_get('safe_mode'))
	    {
			include PHPCMS_ROOT."/data/ftp.php";
			$db->query("UPDATE {$tablepre}setting SET value='1' WHERE variable='enableftp'");
			$db->query("UPDATE {$tablepre}setting SET value='$ftp_host' WHERE variable='ftphost'");
			$db->query("UPDATE {$tablepre}setting SET value='$ftp_user' WHERE variable='ftpuser'");
			$db->query("UPDATE {$tablepre}setting SET value='$ftp_pass' WHERE variable='ftppass'");
			$db->query("UPDATE {$tablepre}setting SET value='$ftp_webpath' WHERE variable='ftpwebpath'");
			$f->enableftp = 1;
			$f->ftp_connect($ftp_host,$ftp_user,$ftp_pass,$ftp_webpath);
			@$f->unlink(PHPCMS_ROOT."/data/ftp.php");
	    }
		$db->query("INSERT INTO {$tablepre}member (username,password,email,groupid,isadmin,regtime,regip,chargetype) VALUES ('$username', '".md5($password)."', '$email','4','1','".time()."','$_SERVER[REMOTE_ADDR]','1')");
		$db->query("INSERT INTO {$tablepre}memberinfo (userid,gender) VALUES ('1','1')");
		$db->query("INSERT INTO {$tablepre}admin (userid,username,grade) VALUES ('1','$username','0')");
        
		$dbresult .= "建立管理帐号 ".$username." <font color='blue'>成功</font>";

		$createdirs = file_read(PHPCMS_ROOT."/install/createdir.txt");
	    $createdirs = explode("\n",$createdirs);
	    $createdirs = array_map("trim",$createdirs);
        foreach($createdirs as $k=>$v)
        {
			if($v)
			{
				$f->create(PHPCMS_ROOT."/".$v);
				$message .= "建立目录 ".$v." <font color='blue'>成功</font><br/>";
			}
		}

		$f->create(PHPCMS_CACHEDIR."templates_c/");
		$f->create(PHPCMS_CACHEDIR."tag/");

		cache_all();
        $message .= "系统缓存建立 <font color='blue'>成功</font><br/>";

		@include PHPCMS_CACHEDIR."module.php";
		@include PHPCMS_CACHEDIR."channel.php";

		template_cache();
        $message .= "模板缓存建立 <font color='blue'>成功</font><br/>";

        $_PHPCMS['logo'] = "images/logo.gif";
		$channelid = 0;
        $skindir = PHPCMS_PATH."templates/".$defaulttemplate."/skins/".$defaultskin;
		for($pageid=1; $pageid<8; $pageid++)
		{
		   tohtml("page",PHPCMS_ROOT."/page");
		}
        $message .= "单网页创建 <font color='blue'>成功</font><br/>";

        tohtml("search",PHPCMS_ROOT);
        $message .= "搜索框创建 <font color='blue'>成功</font><br/>";

		$content = file_read(PHPCMS_ROOT."/install/index.html");
		file_write(PHPCMS_ROOT."/index.html",$content);
        $message .= "首页创建 <font color='blue'>成功</font><br/>";

		include PHPCMS_ROOT."/install/step".$step.".html";
		break;

    case 'ftpset':
		if(!$PHP_FTP) exit("<script>alert('服务器不支持ftp功能！');</script>");
        
		$ftp_host = $_GET['ftphost'];
		$ftp_user = $_GET['ftpuser'];
		$ftp_pass = $_GET['ftppw'];
		$ftp_webpath = $_GET['ftpwebpath'];

		if(!$ftp_host || !$ftp_user) exit("<script>alert('请填写ftp服务器和ftp帐号！');</script>");

	    $useftp = $f->ftp_connect($ftp_host,$ftp_user,$ftp_pass,$ftp_webpath);
		if(!$f->connid) exit("<script>alert('找不到FTP主机！');</script>");
		if(!$f->isconn) exit("<script>alert('FTP帐号和密码不匹配，无法连接FTP！');</script>");
		if(!$useftp) exit("<script>alert('phpcms相对ftp根目录的路径设置错误！');</script>");
		$f->enableftp = 1;

		$iswriteables = file_read(PHPCMS_ROOT."/install/iswriteable.txt");
	    $iswriteables = explode("\n",$iswriteables);
	    $unwriteables = array_map("trim",$iswriteables);
		if(is_array($unwriteables))
	    {
	        foreach($unwriteables as $k=>$path)
			{
				$f->ftp_chmod($path,0777);
			}
			$f->chmod('templates',0777,1);
	    }
		if(strrpos(strtolower($PHP_OS),"win")===false && @ini_get('safe_mode'))
	    {
			$data = "<?php\n\$ftp_host = '$ftp_host';\n\$ftp_user = '$ftp_user';\n\$ftp_pass = '$ftp_pass';\n\$ftp_webpath = '$ftp_webpath';\n?>";
			file_write(PHPCMS_ROOT."/data/ftp.php",$data);
		}
		exit("<script>alert('目录文件可写属性设置成功！');parent.myform.Submit.disabled=false</script>");
		break;

    case 'dbcheck':
		$dbhost = $_GET['dbhost'];
		$dbuser = $_GET['dbuser'];
		$dbpw = $_GET['dbpw'];
		$dbname = $_GET['dbname'];
		$tablepre = $_GET['tablepre'];

		if(!@mysql_connect($dbhost,$dbuser,$dbpw)) exit("<script>alert('无法连接到数据库服务器，请检查配置！');</script>");
		if(!@mysql_select_db($dbname))
	    {
			if(!@mysql_query("CREATE DATABASE $dbname")) exit("<script>alert('指定的数据库不存在，系统也无法创建，请先通过其他方式建立好数据库！');</script>");
			mysql_select_db($dbname);
		}
		$query = mysql_list_tables($dbname);
		while($r = mysql_fetch_row($query))
		{
			$tables[] = $r[0];
		}
		if(is_array($tables) && in_array($tablepre."article",$tables))
	    {
			exit("<script>alert('您已经安装过phpcms，请修改表前缀，否则系统会自动删除原来的数据！');</script>");
		}
        exit("<script>alert('数据库设置正确，可以继续安装！');</script>");
		break;
    default :
}

function runquery($sql) {
	global $tablepre, $db;

	$ret = sql_split($sql);
	foreach($ret as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				preg_match("/CREATE TABLE IF NOT EXISTS `([a-z0-9_]+)` /i",$query, $name);
				$result .= '建立数据表 '.$name[1].' <font color="#0000EE">成功</font><br>';
			}
			$db->query($query);
		}
	}
	return $result;
}
?>