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
defined('IN_PHPCMS') or header('location:admin.php?mod=phpcms&file=login');

function showResult($v){
	 if($v==1){
	       return '<font color="blue"><b>是</b></font>';
	 }else{
	       return '<font color="red"><b>否</b></font>';
	 }
}

switch($action){
case 'left':

      include admintpl('index_left');
      break;

case 'top':

      include admintpl('index_top');
      break;

case 'main':
      $mysql=showResult(function_exists("mysql_close"));
      $odbc=showResult(function_exists("odbc_close"));
      $serverip=gethostbyname($_SERVER[SERVER_NAME]);
      $mssql=showResult(function_exists("mssql_close"));
      $time=date('Y年m月d日H点i分s秒');
      $msql=showResult(function_exists("msql_close"));
      $smtp=showResult(get_magic_quotes_gpc("smtp"));
      $imageline=showResult(function_exists("imageline"));
      $xml=showResult(get_magic_quotes_gpc("XML Support"));
      $ftp=showResult(get_magic_quotes_gpc("FTP support"));
      $mail=showResult(get_magic_quotes_gpc("Internal Sendmail Support for Windows 4"));
      $error=showResult(get_cfg_var("display_errors"));
      $url=showResult(get_cfg_var("allow_url_fopen"));
      $gzclose=showResult(function_exists("gzclose"));
      $zend=showResult(function_exists("zend_version"));
      $max_execution_time=get_cfg_var("max_execution_time");
      $upload=get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"禁止上传";
      $post_max_size=get_cfg_var("post_max_size");
      $serverlang=getenv("HTTP_ACCEPT_LANGUAGE");
      $memory_limit=get_cfg_var("memory_limit")?get_cfg_var("memory_limit"):"不限";
      $realpath=realpath("./");
      include admintpl('index_main');
      break;

default:

      include admintpl('index');
}
?>
