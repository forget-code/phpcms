<?php 
defined('IN_PHPCMS') or exit('Access Denied');
$serverid ? 1 : showmessage($LANG['illegal_operation']);
$db->query("UPDATE ".TABLE_MOVIE_SERVER." SET `num` = (num-1) WHERE serverid = $serverid AND num > 0 ");
?>