<?php
define('rootdir', str_replace("\\", '/', substr(dirname(__FILE__), 0, -7)));
$mod = 'yp';
require rootdir.'/include/common.inc.php';
require rootdir.'/yp/include/tag.func.php';

require PHPCMS_ROOT.'/yp/web/include/common.inc.php';
$item = intval($item);
$_userdir = substr($domainName,0,2);
$datafile = 'userdata/'.$_userdir.'/'.$domainName.'/job/'.$item.'.php';
file_exists($datafile) ? include $datafile : exit('File not exists.');
?>