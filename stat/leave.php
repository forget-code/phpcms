<?php
include './include/common.inc.php';
$db->query("UPDATE ".TABLE_STAT_VISITOR." SET ltime=null,beon=0 WHERE vid=$vid");
$db->query("UPDATE ".TABLE_STAT_VPAGES." SET ltime=null WHERE vid=$vid AND pid=$pid");
?>