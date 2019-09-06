<?php
require './include/common.inc.php';

if(isset($flag))
{
	$data = $digg->update($contentid, $flag);
	echo $data ? $data : 0;
}
else
{
	$r = $digg->get($contentid);
	echo $r ? ($digg->is_done($contentid) ? 1 : 0).','.$r['supports'].','.$r['againsts'] : '0,0,0';
}
?>