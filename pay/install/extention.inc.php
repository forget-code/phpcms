<?php
defined('IN_PHPCMS') or exit('Access Denied');
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(5, '财务', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'pay');");
$parentid = $db->insert_id();
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES
(".$parentid.", '添加财务', '', '?mod=pay&file=exchange&action=add', '', 'right', '', '', '', '', 0, 0, 1, 0, ''),
(".$parentid.", '管理交易记录', '', '?mod=pay&file=exchange&action=list', '', 'right', '', '', '', '', 0, 0, 3, 0, 'pay'),
(".$parentid.", '管理支付记录', '', '?mod=pay&file=payonline&action=list&ispay=-1', '', 'right', '', '', '', '', 0, 0, 4, 0, 'pay'),
(".$parentid.", '管理汇款记录', '', '?mod=pay&file=useramount&action=list&ispay=-1', '', 'right', '', '', '', '', 0, 0, 5, 0, 'pay'),
(".$parentid.", '管理点卡类型', '', '?mod=pay&file=pointcard&action=list', '', 'right', '', '', '', '', 0, 0, 8, 0, 'pay'),
(".$parentid.", '管理点卡', '', '?mod=pay&file=card&action=list', '', 'right', '', '', '', '', 0, 0, 7, 0, 'pay'),
(".$parentid.", '生成点卡', '', '?mod=pay&file=card&action=add', '', 'right', '', '', '', '', 0, 0, 6, 0, 'pay'),
(".$parentid.", '支付配置', '', '?mod=pay&file=paymethod&action=list', '', 'right', '', '', '', '', 0, 0, 10, 0, 'pay'),
(".$parentid.", '模块配置', '', '?mod=pay&&file=setting', '', 'right', '', '', '', '', 0, 0, 11, 0, ''),
(".$parentid.", '权限设置', '', '?mod=pay&file=priv', '', 'right', '', '', '', '', 0, 0, 12, 0, ''),
(".$parentid.", '添加点卡类型', '', '?mod=pay&file=pointcard&action=add', '', 'right', '', '', '', '', 0, 0, 9, 0, '');");


$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES('".$member_1."', '财务管理', '', 'pay/', '', '', '', '', '', '', 0, 0, 0, 0, 'pay');");
$db->query("INSERT INTO `".DB_PRE."menu` (`parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES(".$member_0.", '财务管理', '', 'pay/', '', 'right', '', '', '', '', 0, 0, 0, 0, 'pay');");
?>