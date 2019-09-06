<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl($mod.'_left');
$inf->update();
cache_keywords($channelid);
?>