<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/rank.class.php';
$rank = new rank();
$moodid = $moodid ? intval($moodid) : 1;
$arraymood = $rank->get();
$filed = $rank->show($moodid);
@extract($filed);
if($range)
{
	$limittime = TIME-$range*36800;
	$where = "AND d.updatetime>$limittime";
}
$infos = $rank->listinfo($moodid, 1, 20, $where);

include admin_tpl('rank');
?>