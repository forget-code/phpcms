<?php 
require './include/common.inc.php';
require PHPCMS_ROOT.'/include/area.func.php';

$actions = array('house', 'building', 'coop');
if(!in_array($action, $actions)) $action = 'house';
if($MOD['moduledomain'] && strpos($PHP_URL, $MOD['moduledomain'])!==false)
{
   header('Location:'.$PHPCMS['siteurl'].'/'.$MOD['moduledir'].'/search.php?'.$PHP_QUERYSTRING);
   exit;
}
require MOD_ROOT.'/actions/search_'.$action.'.inc.php';
?>