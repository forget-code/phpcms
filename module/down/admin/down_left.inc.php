<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl($mod.'_left');
$d->update();
cache_keywords($channelid);
?>