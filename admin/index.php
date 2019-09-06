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
defined('IN_PHPCMS') or header('location:../admin.php?mod=phpcms&file=index');

function showResult($v){
	 if($v==1){
	       return '<font color="blue"><b>是</b></font>';
	 }else{
	       return '<font color="red"><b>否</b></font>';
	 }
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
	  if($_grade>0) showmessage("您没有权限！");

	  $mods = array();
	  foreach($_MODULE as $mod=>$v)
	  {
		  if(!$v['enablecopy'] && !$v['isshare'])
		  {
			  if($_grade==0 || @in_array($mod,$_purview_module)) @include PHPCMS_ROOT."/".$mod."/admin/menu.php";
		  }
	  }
	  foreach($_MODULE as $mod=>$v)
	  {
		  if($v['isshare'])
		  {
             if($_grade==0 || @in_array($mod,$_purview_module)) $extmenus[$mod] = $v;
		  }
	  }
      include admintpl('index_left');
      break;

case 'top':

      include admintpl('index_top');
      break;

case 'menu':
	  foreach($_MODULE as $mod=>$v)
	  {
		  if(!$v['enablecopy'] && !$v['isshare'])
		  {
			  if($_grade==0 || @in_array($mod,$_purview_module)) @include PHPCMS_ROOT."/".$mod."/admin/menu.php";
		  }
	  }
      include admintpl('index_menu');
      break;

case 'main':
	  $admingrades = array
	  (
		0 => "超级管理员",
		1 => "频道管理员",
		2 => "栏目总编",
		3 => "栏目编辑",
		4 => "信息发布员",
		5 => "信息审核员",
	  );

      $PHP_MODULE = @get_loaded_extensions();

      $mysql=showResult(in_array('mysql',$PHP_MODULE));
      $odbc=showResult(in_array('odbc',$PHP_MODULE));
      $serverip=gethostbyname($_SERVER['SERVER_NAME']);
      $mssql=showResult(in_array('mssql',$PHP_MODULE));
      $time=date('Y年m月d日H点i分s秒');
      $msql=showResult(in_array('msql',$PHP_MODULE));
      $mb_string=showResult(in_array('mbstring',$PHP_MODULE));
      $gd=showResult(in_array('gd',$PHP_MODULE));
      $xml=showResult(in_array('xml',$PHP_MODULE));
      $ftp=showResult(in_array('ftp',$PHP_MODULE));
      $safemode=showResult(@ini_get('safe_mode'));
      $error=showResult(@get_cfg_var("display_errors"));
      $url=showResult(@get_cfg_var("allow_url_fopen"));
      $zlib=showResult(in_array('zlib',$PHP_MODULE));
      $zend=showResult(function_exists("zend_version"));
      $max_execution_time=@get_cfg_var("max_execution_time");
      $upload=@get_cfg_var("upload_max_filesize")?@get_cfg_var("upload_max_filesize"):"禁止上传";
      $post_max_size=@get_cfg_var("post_max_size");
      $serverlang=getenv("HTTP_ACCEPT_LANGUAGE");
      $memory_limit=@get_cfg_var("memory_limit")?@get_cfg_var("memory_limit"):"不限";
      $realpath=realpath("./");

      $r = $db->get_one("select email,lastlogintime,logintimes,additems from ".TABLE_MEMBER." where username='$_username'");
      $lastlogintime = $r[lastlogintime] ? date("Y-m-d H:i:s",$r[lastlogintime]) : '';
      $logintimes = $r[logintimes];
	  $additems = $r[additems];
	  $email = $r[email];

      $r = $db->get_one("SELECT count(*) as num FROM ".TABLE_MEMBER." WHERE groupid>3");
      $passedmember = $r[num];

      $r = $db->get_one("SELECT count(*) as num FROM ".TABLE_MEMBER." WHERE groupid<4");
      $notpassedmember = $r[num];

	  $PHP_ZEND = zend_optimizer_version();

	  $user_info = "user_version=".PHPCMS_VERSION."&user_release=".PHPCMS_RELEASE."&user_os=".PHP_OS."&user_server=".$_SERVER["SERVER_SOFTWARE"]."&user_php=".phpversion()."&user_mysql=".mysql_get_server_info()."&user_zend=".$PHP_ZEND."&user_domain=".$PHP_DOMAIN."&user_sitename=".$_PHPCMS['sitename']."&user_email=".$email;

	  $verify = md5($user_info);

      @extract($db->get_one("SELECT COUNT(*) AS inbox_new_num FROM ".TABLE_PM." WHERE tousername='$_username' and new=1 and send=1 and recycle=0","CACHE")); //新信件数量

      include admintpl('index_main');
      break;

default:
	  $left = $_grade ? "menu" : "left";
      include admintpl('index');
}
?>
