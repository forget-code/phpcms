<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl($mod.'_left');
$art->update();
cache_keywords($channelid);
cache_author($channelid);
cache_copyfrom($channelid);
?>