<?php
defined('IN_PHPCMS') or exit('Access Denied');
$number= array();
$number['product'][0] = cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."yp_product` WHERE status = 1");
$number['product'][1] = cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."yp_product` WHERE status = 99");
$number['job'][0] = cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."yp_job` WHERE status = 1");
$number['job'][1] = cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."yp_job` WHERE status = 99");
$number['job'][2] = cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."yp_apply`");
$number['buy'][0] = cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."yp_buy` WHERE status = 1");
$number['buy'][1] = cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."yp_buy` WHERE status = 99");
$number['news'][0] = cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."yp_news` WHERE status = 1");
$number['news'][1] = cache_count("SELECT count(*) AS `count` FROM `".DB_PRE."yp_news` WHERE status = 99");
include admin_tpl('panel');
?>