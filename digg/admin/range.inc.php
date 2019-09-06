<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$page = max(intval($page), 1);
$where = $catid ? " AND c.catid IN(".$CATEGORY[$catid]['arrchildid'].") " : '';
$orderby = $range ? 'd.supports_'.$range : 'd.supports';
include admin_tpl('range');
?>