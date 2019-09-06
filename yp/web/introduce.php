<?php
define('rootdir', str_replace("\\", '/', substr(dirname(__FILE__), 0, -7)));
$mod = 'yp';
require rootdir.'/include/common.inc.php';
require rootdir.'/yp/include/tag.func.php';

require PHPCMS_ROOT.'/yp/web/include/common.inc.php';

$_userdir = substr($domainName,0,2);
$datafile = 'userdata/'.$_userdir.'/'.$domainName.'/introduce.php';

file_exists($datafile) ? include $datafile : exit('File not exists.');

?>