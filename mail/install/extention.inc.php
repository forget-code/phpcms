<?php
defined('IN_PHPCMS') or exit('Access Denied');
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(5, '邮件订阅', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'mail');");
$parentid = $db->insert_id();
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES
(".$parentid.", '群发期刊', '', '?mod=mail&file=subscription&action=send', '', 'right', '', '', '', '', 0, 0, 3, 0, ''),
(".$parentid.", '添加期刊', '', '?mod=mail&file=subscription&action=add', '', 'right', '', '', '', '', 0, 0, 4, 0, ''),
(".$parentid.", '管理期刊', '', '?mod=mail&file=subscription&action=list', '', 'right', '', '', '', '', 0, 0, 5, 0, ''),
(".$parentid.", '管理订阅邮箱', '', '?mod=mail&file=email&action=list', '', 'right', '', '', '', '', 0, 0, 2, 0, ''),
(".$parentid.", '管理订阅分类', '', '?mod=mail&file=type', '', 'right', '', '', '', '', 0, 0, 6, 0, ''),
(".$parentid.", '发送邮件', '', '?mod=mail&file=send', '', 'right', '', '', '', '', 0, 0, 1, 0, ''),
(".$parentid.", '管理邮件列表', '', '?mod=mail&file=maillist&action=list', '', 'right', '', '', '', '', 0, 0, 8, 0, ''),
(".$parentid.", '获取邮箱列表', '', '?mod=mail&file=importmail&action=choice', '', 'right', '', '', '', '', 0, 0, 9, 0, ''),
(".$parentid.", '邮件配置', '', '?mod=phpcms&file=setting&tab=5', '', 'right', '', '', '', '', 0, 0, 10, 0, ''),
(".$parentid.", '模块配置', '', '?mod=mail&file=setting', '', 'right', '', '', '', '', 0, 0, 11, 0, ''),
(".$parentid.", '权限设置', '', '?mod=mail&file=priv', '', 'right', '', '', '', '', 0, 0, 12, 0, ''),
(".$parentid.", '添加订阅类别', '', '?mod=mail&file=type&action=add', '', 'right', '', '', '', '', 0, 0, 7, 0, '');");

$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES('".$member_1."', '邮件订阅', '', 'mail/', '', '', '', '', '', '', 0, 0, 0, 0, 'mail');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES('".$member_0."', '邮件订阅', '', 'mail/', '', '', '', '', '', '', 0, 0, 0, 0, 'pay');");

$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(7, '邮件订阅', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'member');");
$parentid = $db->insert_id();
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '新建模板', '', '?mod=phpcms&file=template&action=add&module=mail', '', 'right', '', '', '', '', 0, 0, 0, 0, 'member');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$parentid.", '管理模板', '', '?mod=phpcms&file=template&action=manage&module=mail', '', 'right', '', '', '', '', 0, 0, 0, 0, 'member');");
?>