<?php
defined('IN_PHPCMS') or exit('Access Denied');
$result = $db->query("SELECT * FROM ".$CONFIG['tablepre']."channel WHERE module='movie' ");
while($r = $db->fetch_array($result))
{
	if($r['islink']) continue;
	$table = $CONFIG['tablepre']."movie_".$r['channelid'];
	$db->query("DROP TABLE IF EXISTS $table ");
	dir_delete(PHPCMS_ROOT.'/'.$r['channeldir'].'/');
}
$db->query("DELETE FROM ".$CONFIG['tablepre']."channel WHERE module='movie'");
$db->query("DELETE FROM ".$CONFIG['tablepre']."module WHERE module='movie'");
$db->query("DROP TABLE IF EXISTS ".$CONFIG['tablepre']."movie_server");
$db->query("DROP TABLE IF EXISTS ".$CONFIG['tablepre']."movie_player");

dir_delete(PHPCMS_ROOT.'/module/movie/');
?>