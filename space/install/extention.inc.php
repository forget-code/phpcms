<?php
defined('IN_PHPCMS') or exit('Access Denied');
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(5, '空间管理', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'space');");
$parentid = $db->insert_id();
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '添加空间API', '', '?mod=space&file=manage&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, 'space');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '管理空间API', '', '?mod=space&file=manage&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, 'space');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '权限设置', '', '?mod=space&file=priv', '', 'right', '', '', '', '', 0, 0, 0, 0, 'space');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(7, '个人空间', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'space');");
$parentid = $db->insert_id();
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '新建模板', '', '?mod=phpcms&file=template&action=add&module=space', '', 'right', '', '', '', '', 0, 0, 0, 0, 'space');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '管理模板', '', '?mod=phpcms&file=template&action=manage&module=space', '', 'right', '', '', '', '', 0, 0, 0, 0, 'space');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$member_0.", '个人空间', '', 'space/index.php', '', 'right', '', '', '', '', 0, 0, 0, 0, 'space');");
require_once 'cache.func.php';
cache_table(DB_PRE.'space_api', '*', '', 'disable=0', 'listorder', 0);
?>