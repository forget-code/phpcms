<?php 
require './include/common.inc.php';


$head['title'] = $LANG['formguide_index'];
$head['keywords'] = $LANG['formguide_index'];
$head['description'] = $LANG['formguide_index'];

//$templateid = $MOD['templateid'] ? $MOD['templateid'] : "index";
$templateid = "index";
include template($mod,$templateid);
?>