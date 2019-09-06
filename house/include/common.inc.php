<?php 
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));
$mod = 'house';
require_once substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';

require PHPCMS_ROOT.'/include/module.func.php';
require MOD_ROOT.'/include/urlrule.inc.php';
require MOD_ROOT.'/include/tag.func.php';
require MOD_ROOT.'/include/global.func.php';

$PARS = include MOD_ROOT.'/include/pars.inc.php';
//$TYPES = array_flip($PARS['infotype']);
$DECORATES = array_flip($PARS['decorate']);
$TOWARDS = array_flip($PARS['towards']);
$HOUSETYPE = array_flip($PARS['type']);
$INFRASTRUCTURE = array_flip($PARS['infrastructure']);
$INDOOR = array_flip($PARS['indoor']);
$PERIPHERAL = array_flip($PARS['peripheral']);
$AREA = cache_read('areas_'.$mod.'.php');

$CAT = cache_read('house_infocat.php');
if(!$CAT)
{
	cache_infocat();
	$CAT = cache_read('house_infocat.php');
}

$tab = 'home';
if($MOD['skinid']) $skindir = PHPCMS_PATH.'templates/'.$CONFIG['defaulttemplate'].'/skins/'.$MOD['skinid'];
?>