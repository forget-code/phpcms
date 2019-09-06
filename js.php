<?php 
define('SHOWJS', 1);
require dirname(__FILE__).'/include/common.inc.php';
require PHPCMS_ROOT.'/templates/'.$CONFIG['defaulttemplate'].'/html.php';

if(!isset($html[$tag])) showmessage($LANG['tag_not_exists']);
if(strpos($html[$tag],'$') !== FALSE) showmessage($LANG['disallow_variable_in_tags']);

eval('tag_data('.$html[$tag].');');
phpcache(1);
?>