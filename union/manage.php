<?php
require './include/common.inc.php';

$r = $db->get_one("SELECT profitmargin FROM ".TABLE_UNION." WHERE userid=$_userid");
if(!$r) showmessage('请您先申请加入推广联盟！', $MOD['linkurl'].'register.php');
extract($r);

$actions = array('stats', 'visit', 'reguser', 'expend', 'pay','code');

if(!in_array($action, $actions)) $action = 'stats';

include MOD_ROOT.'/action/manage_'.$action.'.inc.php';
?>