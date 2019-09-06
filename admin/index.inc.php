<?php
defined('IN_PHPCMS') or header('location:../admin.php?mod=phpcms&file=index');

function showresult($v)
{
	global $LANG;
	return $v ? '<font color="blue"><b>'.$LANG['yes'].'</b></font>' : '<font color="red"><b>'.$LANG['no'].'</b></font>';
}

if(!function_exists('zend_optimizer_version'))
{
	function zend_optimizer_version()
	{
		ob_start();
		@phpinfo();
		$phpinfo = ob_get_contents();
		ob_end_clean();
		preg_match("/Zend(?: |&nbsp;)+?Optimizer(?: |&nbsp;)+?v([0-9]+\.[0-9]+\.[0-9]+),/",strip_tags($phpinfo),$info); 
		return $info[1];
	}
}

switch($action)
{
	case 'left':
		  $extmenus = array();
		  foreach($MODULE as $mod=>$v)
		  {
			  if($v['isshare'])
			  {
				 if($_grade==0 || @in_array($mod, $_modules)) $extmenus[$mod] = $v;
			  }
		  }
		  include admintpl('index_left');
		  break;

	case 'module':
		  $modtitle = array();
		  $mods = array();
		  foreach($MODULE as $mod=>$v)
		  {
			  if(!$v['iscore'] && !$v['iscopy'])
			  {
				  if($_grade==0 || @in_array($mod,$_modules)) @include PHPCMS_ROOT.'/'.$mod.'/admin/menu.inc.php';
			  }
		  }
		  include admintpl('index_module');
		  break;

	case 'top':
		  include admintpl('index_top');
		  break;

	case 'mymenu':
		  $modtitle = array();
		  $mods = array();
		  foreach($_modules as $mod)
		  {
			  @include PHPCMS_ROOT.'/'.$mod.'/admin/menu.inc.php';
		  }
		  include admintpl('index_mymenu');
		  break;

	case 'template':
		  include admintpl('index_template');
		  break;

	case 'member':
		  include admintpl('index_member');
		  break;

	case 'channel':
		  include admintpl('index_channel');
		  break;

	case 'menu':
		  $modtitle = array();
		  foreach($MODULE as $mod=>$v)
		  {
			  if(!$v['iscopy'] && !$v['isshare'])
			  {
				  if($_grade==0 || @in_array($mod, $_modules)) @include PHPCMS_ROOT.'/'.$mod.'/admin/menu.inc.php';
			  }
		  }
		  include admintpl('index_menu');
		  break;

	case 'main':
		$infosum = array();
		foreach($CHANNEL as $channel)
		{
			if(!$channel['islink'])
			{
				$prekey = $channel['module'].'id';
				$status[-1] = 'num__1';
				$status[0] = 'num_0';
				$status[1] = 'num_1';
				$status[2] = 'num_2';
				$status[3] = 'num_3';
				for($i=-1; $i<4; $i++)
				{
					$r = $db->get_one("select count($prekey) as num from ".channel_table($channel['module'], $channel['channelid'])." where status=$i");
					$$status[$i] = $r['num'];
				}
				$sum = $num__1+$num_0+$num_1+$num_2+$num_3;
				$r['sum']=$sum;
				$r['num__1']=$num__1;
				$r['num_0']=$num_0;
				$r['num_1']=$num_1;
				$r['num_2']=$num_2;
				$r['num_3']=$num_3;
				$infosum[$channel['channelname']] = $r;
			}
		}
		$admingrades = $grades;
		$r = $db->get_one("select email,lastlogintime,logintimes,items from ".TABLE_MEMBER." where username='$_username'");
		$lastlogintime = $r['lastlogintime'] ? date('Y-m-d H:i:s', $r['lastlogintime']) : '';
		$logintimes = $r['logintimes'];
		$items = $r['items'];
		$email = $r['email'];

		$r = $db->get_one("SELECT count(*) as num FROM ".TABLE_MEMBER." WHERE groupid > 5");
		$passedmember = $r['num'];

		$r = $db->get_one("SELECT count(*) as num FROM ".TABLE_MEMBER." WHERE groupid IN(4,5)");
		$notpassedmember = $r['num'];
        $user_modules = implode(',', $LICENSE['modules']);
		$user_info = 'user_charset='.$CONFIG['charset'].'&user_type='.$LICENSE['type'].'&user_version='.PHPCMS_VERSION.'&user_release='.PHPCMS_RELEASE.'&user_os='.PHP_OS.'&user_server='.$_SERVER['SERVER_SOFTWARE'].'&user_php='.phpversion().'&user_mysql='.mysql_get_server_info().'&user_zend='.zend_optimizer_version().'&user_domain='.$PHP_DOMAIN.'&user_email='.$email.'&user_modules='.$user_modules;
		$verify = md5($user_info.'&user_sitename='.$PHPCMS['sitename'].'phpcms_user_info');
        $user_info .= '&user_sitename='.urlencode($PHPCMS['sitename']);
		include admintpl('index_main');
	  break;    
	case 'env':
	$PHP_MODULE = get_loaded_extensions();
	$mysql = showresult(in_array('mysql',$PHP_MODULE));
	$odbc = showresult(in_array('odbc',$PHP_MODULE));
	$serverip = gethostbyname($_SERVER['SERVER_NAME']);
	$mssql = showresult(in_array('mssql',$PHP_MODULE));
	$time = date($LANG['time_format']);
	$msql = showresult(in_array('msql',$PHP_MODULE));
	$mb_string = showresult(in_array('mbstring',$PHP_MODULE));
	$gd = showresult(in_array('gd',$PHP_MODULE));
	$xml = showresult(in_array('xml',$PHP_MODULE));
	$ftp = showresult(in_array('ftp',$PHP_MODULE));
	$safemode = showresult(@ini_get('safe_mode'));
	$error = showresult(@get_cfg_var('display_errors'));
	$url = showresult(@get_cfg_var('allow_url_fopen'));
	$zlib = showresult(in_array('zlib',$PHP_MODULE));
	$max_execution_time = @get_cfg_var('max_execution_time');
	$upload = @get_cfg_var('upload_max_filesize') ? @get_cfg_var('upload_max_filesize') : $LANG['upload_banned'];
	$post_max_size = @get_cfg_var('post_max_size');
	$serverlang = getenv('HTTP_ACCEPT_LANGUAGE');
	$memory_limit = @get_cfg_var('memory_limit') ? @get_cfg_var('memory_limit') : $LANG['no_limit'];
	$realpath = realpath('./');
	$PHP_ZEND = zend_optimizer_version();
	   
	ob_start();
	phpinfo();
	$info = ob_get_contents();
	ob_clean();
	if(preg_match("/<body><div class=\"center\">([\s\S]*?)<\/div><\/body>/",$info,$m)) $phpinfo = $m[1];
	else $phpinfo = $info;
	$phpinfo = str_replace("class=\"e\"","class=\"tablerow\"",$phpinfo);
	$phpinfo = str_replace("class=\"v\"","class=\"tablerow\"",$phpinfo);
	$phpinfo = str_replace("<table","<table class=\"tableborder\"",$phpinfo);
	$phpinfo = preg_replace("/<tr class=\"h\"><td>[\r\n]{0,3}<a href=\"http:\/\/www.php.net\/\"><img(.*)alt=\"PHP Logo\" \/><\/a><h1 class=\"p\">(.*)<\/h1>[\r\n]{0,3}<\/td><\/tr>/","<th colspan=2>".$LANG['php_environment_detail']."</th>",$phpinfo);
	include admintpl('index_env');
	break;

	default:
	$left = $_grade ? 'menu' : 'left';
	include admintpl('index');
}
?>
