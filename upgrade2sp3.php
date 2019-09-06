<?php
require dirname(__FILE__).'/include/common.inc.php';
$db->query("ALTER TABLE  `".DB_PRE."datasource` CHANGE  `dbuser`  `dbuser` VARCHAR( 30 ) NOT NULL");
echo "更新语句: ALTER TABLE  `".DB_PRE."datasource` CHANGE  `dbuser`  `dbuser` VARCHAR( 30 ) NOT NULL<br>";
$db->query("ALTER TABLE  `".DB_PRE."datasource` CHANGE  `dbname`  `dbname` VARCHAR( 30 ) NOT NULL");
echo "更新语句: ALTER TABLE  `".DB_PRE."datasource` CHANGE  `dbname`  `dbname` VARCHAR( 30 ) NOT NULL<br>";
@unlink('upgrade2sp3.php');
echo "升级完成！";
?>