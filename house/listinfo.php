<?php 
require './include/common.inc.php';
$infocat = intval($infocat);
$infocat or showmessage($LANG['illegal_operation'], $PHP_SITEURL);
$infotypename = $PARS['infotype']['type_'.$infocat];
if($infocat<1 || $infocat>6) showmessage($LANG['illegal_operation']);
if($MOD['createlistinfo']){header('Location:'.$CAT[$infocat]['linkurl']);exit;}
$areaid = intval($areaid);
$tab = $infocat;
$head['title'] = $PARS['infotype']['type_'.$infocat].'-'.$MOD['seo_keywords'];
$head['keywords'] = $PARS['infotype']['type_'.$infocat].'-'.$MOD['seo_keywords'];
$head['description'] =  $PARS['infotype']['type_'.$infocat].'-'.$MOD['seo_description'];

include template($mod, 'listinfo');
?>