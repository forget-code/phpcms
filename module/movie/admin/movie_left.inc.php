<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl($mod.'_left');
$d->update();//更新栏目及频道items统计 TEMP
cache_keywords($channelid);
?>