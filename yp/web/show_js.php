<?php
define('rootdir', str_replace("\\", '/', substr(dirname(__FILE__), 0, -7)));
$mod = 'yp';
require rootdir.'/include/common.inc.php';
$item = intval($item);
switch($label)
{
	case 'article':
		$db->query("UPDATE ".TABLE_YP_ARTICLE." SET hits=(hits+1) WHERE articleid=$item");
		@extract($db->get_one("SELECT hits FROM ".TABLE_YP_ARTICLE." WHERE articleid=$item"));
	break;
	case 'buy':
		$db->query("UPDATE ".TABLE_YP_BUY." SET hits=(hits+1) WHERE productid=$item");
		@extract($db->get_one("SELECT hits FROM ".TABLE_YP_BUY." WHERE productid=$item"));
	break;
	case 'sales':
		$db->query("UPDATE ".TABLE_YP_SALES." SET hits=(hits+1) WHERE productid=$item");
		@extract($db->get_one("SELECT hits FROM ".TABLE_YP_SALES." WHERE productid=$item"));
	break;
	case 'product':
		$db->query("UPDATE ".TABLE_YP_PRODUCT." SET hits=(hits+1) WHERE productid=$item");
		@extract($db->get_one("SELECT hits FROM ".TABLE_YP_PRODUCT." WHERE productid=$item"));
	break;
	case 'job':
		$db->query("UPDATE ".TABLE_YP_JOB." SET hits=(hits+1) WHERE jobid=$item");
		@extract($db->get_one("SELECT hits FROM ".TABLE_YP_JOB." WHERE jobid=$item"));
	break;
}
echo "try {setidval('hits','".$hits."');}catch(e){}\n";
?>