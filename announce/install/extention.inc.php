<?php
defined('IN_PHPCMS') or exit('Access Denied');
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(5, '网站公告', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'announce');");
$parentid = $db->insert_id();
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '添加公告', '', '?mod=announce&file=announce&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, 'announce');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '管理公告', '', '?mod=announce&file=announce&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, 'announce');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '审批公告', '', '?mod=announce&file=announce&action=approval', '', 'right', '', '', '', '', 0, 0, 0, 0, 'announce');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '过期公告', '', '?mod=announce&file=announce&action=expired', '', 'right', '', '', '', '', 0, 0, 0, 0, 'announce');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '权限设置', '', '?mod=announce&file=priv', '', 'right', '', '', '', '', 0, 0, 0, 0, 'announce');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(7, '网站公告', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'announce');");
$parentid = $db->insert_id();
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '新建模板', '', '?mod=phpcms&file=template&action=add&module=announce', '', 'right', '', '', '', '', 0, 0, 0, 0, 'announce');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '管理模板', '', '?mod=phpcms&file=template&action=manage&module=announce', '', 'right', '', '', '', '', 0, 0, 0, 0, 'announce');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '添加标签', '', '?mod=announce&file=tag&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, 'announce');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '管理标签', '', '?mod=announce&file=tag&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, 'announce');");
?>
