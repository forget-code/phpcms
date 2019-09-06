<?php 
$dbhost = 'localhost';
$dbuser = 'root';
$dbpw = '';
$dbname = 'phpcms';	
$tablepre = 'phpcms_'; 
$database = 'mysql';	
$pconnect = 1;	

$dbiscache = 0;     //是否启用 sql cache (只对前台起作用，建议在不生成html并且访问量过大时开启)
$dbexpires = 3600;  //sql cache 过期时间(秒)

$charset = 'utf-8';   //数据库连接字符集

$rootpath = '/phpcms/';    //phpcms安装路径（相对于网站根路径的）

$cachedir = PHPCMS_ROOT."/data/cache/";  //缓冲目录

$fileiscache = 0;   //是否开启文件缓冲功能的总开关（只对前台起作用，建议在不生成html并且访问量过大时开启）
$filecaching = 0;   //文件缓冲模式是否默认开启（当$fileiscache = 1时有效）
$fileexpires = 3600;   //文件缓冲过期时间(秒)

$usecookie = '1';        //前台是否使用cookie (1,使用cookie; 0,使用session)
$admin_usecookie = '1';  //后台是否使用cookie (1,使用cookie; 0,使用session)

$cookiedomain = '';    //cookie 作用域
$cookiepath = '/';     //cookie 作用路径

$defaulttemplate = 'default';
$defaultskin = 'default';
$tplrefresh = 1;

$timezone = "Etc/GMT-8";  //时区设置（只对php 5.1以上版本有效），Etc/GMT-8 实际表示的是 GMT+8 

$debug = 0;   //是否显示调试信息
?>