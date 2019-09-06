<?php 
require_once './include/common.inc.php';
require_once MOD_ROOT.'/include/link.class.php';
$link   = new link();
$linkid = intval($linkid); 
if(empty($linkid))
{
	showmessage('参数错误',$forward);
}
else 
{
	echo $link->hits($linkid);	
}

?>