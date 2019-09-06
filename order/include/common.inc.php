<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -7));
$mod = 'order';
require substr(MOD_ROOT, 0, -1-strlen($mod)).'include/common.inc.php';

if(!$_userid) showmessage('请登陆', $MODULE['member']['url'].'login.php?forward='.urlencode(URL));

require MOD_ROOT.'include/order.class.php';
$order = new order();

$head['title'] = '订单管理_'.$PHPCMS['sitename'];
$head['keywords'] = $PHPCMS['keywords'];
$head['description'] = $PHPCMS['description'];
?>