<?php
require './include/common.inc.php';
$year = date('ym',TIME);
$table_status = $db->table_status(DB_PRE.'ads_'.$year);
if(!$table_status) {
	include MOD_ROOT.'include/create.table.php';
}
$place->show($id);
?>