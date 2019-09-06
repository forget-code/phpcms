INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('短消息', 'message', 'message', '', 0, 0, 0, '1.0.0', 'phpcms团队（汪伟）', 'http://www.phpcms.cn', 'phpcms@163.com', '注册会员间互相发送短消息', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_message_inbox`;
CREATE TABLE `phpcms_message_inbox` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `sender` varchar(20) NOT NULL default '',
  `receiver` varchar(20) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `sight` tinyint(1) unsigned NOT NULL default '0',
  `forsake` tinyint(1) unsigned NOT NULL default '0',
  `types` tinyint(1) unsigned NOT NULL default '0',
  `sendtime` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_message_outbox`;
CREATE TABLE `phpcms_message_outbox` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `sender` varchar(20) NOT NULL default '',
  `receiver` varchar(20) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `forsake` tinyint(1) unsigned NOT NULL default '0',
  `sendtime` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_message_read`;
CREATE TABLE `phpcms_message_read` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `messageid` int(11) unsigned NOT NULL default '0',
  `userid` int(11) unsigned NOT NULL default '0',
  `forsake` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `messageid` (`messageid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_message_friend`;
CREATE TABLE `phpcms_message_friend` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `userself` char(20) NOT NULL default '',
  `userother` char(20) NOT NULL default '',
  `types` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '短消息', '', 'message/inbox.php', '_self', '', 12, '', '', '');