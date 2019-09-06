<?php
defined('IN_PHPCMS') or exit('Access Denied');
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(5, '错误报告', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'error_report');");
$parentid = $db->insert_id();
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES
(".$parentid.", '管理错误报告', '', '?mod=error_report&file=error_report&action=list', '', 'right', '', '', '', '', 0, 0, 1, 0, ''),
(".$parentid.", '添加分类', '', '?mod=error_report&file=type&action=add', '', 'right', '', '', '', '', 0, 0, 3, 0, ''),
(".$parentid.", '管理分类', '', '?mod=error_report&file=type', '', 'right', '', '', '', '', 0, 0, 2, 0, ''),
(".$parentid.", '模块配置', '', '?mod=error_report&file=setting', '', 'right', '', '', '', '', 0, 0, 4, 0, ''),
(".$parentid.", '权限设置', '', '?mod=error_report&file=priv', '', 'right', '', '', '', '', 0, 0, 5, 0, '');");
?>