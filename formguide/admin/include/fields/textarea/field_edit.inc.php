<?php 
$maxlength = max(intval($maxlength), 0);
$sql = "ALTER TABLE `$tablename` CHANGE `$field` `$field` ";
$sql .= ($maxlength && $maxlength <= 255) ? "VARCHAR( $maxlength ) NOT NULL DEFAULT '$defaultvalue'" : "MEDIUMTEXT NOT NULL";
$db->query($sql);
?>