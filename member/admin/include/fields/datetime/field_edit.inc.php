<?php 
if($dateformat == 'date')
{
	$sql = "ALTER TABLE `$tablename` CHANGE `$field` `$field` DATE NOT NULL DEFAULT '0000-00-00'";
}
elseif($dateformat == 'datetime')
{
	$sql = "ALTER TABLE `$tablename` CHANGE `$field` `$field` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
}
elseif($dateformat == 'int')
{
	if($format)
	$sql = "ALTER TABLE `$tablename` CHANGE `$field` `$field` INT UNSIGNED NOT NULL DEFAULT '0'";
}

$db->query($sql);
?>