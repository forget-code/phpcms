<?php
defined('IN_PHPCMS') or exit('Access Denied');

include MOD_ROOT.'include/collect.class.php';
$c = new collect();
$infos = $c->stats("group by userid", '`cid` DESC', $page, 30, 1);
include admin_tpl('collect_manage');
?>