<?php 
$sql = "ALTER TABLE `$tablename` CHANGE `$field` `$field` VARCHAR( 5 ) NOT NULL DEFAULT '$defaultvalue'";
$db->query($sql);
?>