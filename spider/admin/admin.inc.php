<?php
error_reporting(E_ALL);
defined("IN_PHPCMS") or exit ("Access Denied");
define('TABLE_SPIDER_SITES',DB_PRE.'spider_sites');
define('TABLE_SPIDER_JOB',DB_PRE.'spider_job');
define('TABLE_SPIDER_URLS',DB_PRE.'spider_urls');
define('TABLE_SPIDER_OUT',DB_PRE.'spider_out');
define('MOD_ROOT', PHPCMS_ROOT.'/'.$mod);
require MOD_ROOT.'/include/functions.func.php';
$charset_config = array('self'=>'gbk','target'=>'utf8');//GBK配置
//$charset_config = array('self'=>'utf8','target'=>'gbk');
if($file!='setting')
{
	checkModConfig();
}
?>