<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$function = isset($function) ? $function :'formguide';
//$tags = $tag->get_tags_config($function);
include admintpl('tag_manage');
?>