<?php
function comparetime($time)
{
	global $PHP_TIME;
	if($PHP_TIME-intval($time)>30*24*60*60)	return true;
	else return false;
}

?>