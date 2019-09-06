<?php 
require './include/common.inc.php';
if($_userid)
$db->query("UPDATE ".TABLE_MEMBER." SET totalonline=totalonline+($PHP_TIME-lastlogintime),lastlogintime=$PHP_TIME where userid=$_userid");
?>