INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('网站公告', 'announce', 'announce', '', 0, 0, 1, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', '发布网站公告', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_announce`;
CREATE TABLE `phpcms_announce` (
  `announceid` int(10) unsigned NOT NULL auto_increment,
  `keyid` varchar(20) NOT NULL default '',
  `title` varchar(250) NOT NULL default '',
  `content` text NOT NULL,
  `hits` int(11) NOT NULL default '0',
  `fromdate` date NOT NULL default '0000-00-00',
  `todate` date NOT NULL default '0000-00-00',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '0',
  PRIMARY KEY  (`announceid`),
  KEY `username` (`username`),
  KEY `passed` (`passed`),
  KEY `channelid` (`keyid`)
) TYPE=MyISAM;