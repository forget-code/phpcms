<?php 
if($dateformat == 'date')
{
	$sql = "ALTER TABLE `$tablename` ADD `$field` DATE NOT NULL DEFAULT '0000-00-00'";
}
elseif($dateformat == 'datetime')
{
	$sql = "ALTER TABLE `$tablename` ADD `$field` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
}
elseif($dateformat == 'int')
{
	if($format)
	$sql = "ALTER TABLE `$tablename` ADD `$field` INT UNSIGNED NOT NULL DEFAULT '0'";
}

$db->query($sql);
?>