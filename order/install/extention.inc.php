<?php
defined('IN_PHPCMS') or exit('Access Denied');

$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(5, '订单', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'order');");
$parentid = $db->insert_id();
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (".$parentid.", '订单管理', '', '?mod=order&file=order&action=manage', '', 'right', '', '', '', '', 0, 0, 1, 0, '')");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (".$parentid.", '模块配置', '', '?mod=order&file=setting', '', 'right', '', '', '', '', 0, 0, 1, 0, '')");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (".$parentid.", '权限设置', '', '?mod=order&file=priv', '', 'right', '', '', '', '', 0, 0, 1, 0, '')");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES('".$member_1."', '订单管理', '', 'order/', '', '', '', '', '', '', 0, 0, 0, 0, 'order');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES('".$member_0."', '订单管理', '', 'order/', '', '', '', '', '', '', 0, 0, 0, 0, 'order');");
?>
