INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('announce', '网站公告', 'announce/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', '', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_announce`;
CREATE TABLE IF NOT EXISTS `phpcms_announce` (
  `announceid` smallint(4) unsigned NOT NULL auto_increment,
  `title` char(80) NOT NULL,
  `content` text NOT NULL,
  `hits` smallint(5) unsigned NOT NULL default '0',
  `fromdate` date NOT NULL default '0000-00-00',
  `todate` date NOT NULL default '0000-00-00',
  `username` char(20) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `passed` tinyint(1) unsigned NOT NULL default '0',
  `template` char(30) NOT NULL,
  PRIMARY KEY  (`announceid`),
  KEY `passed` (`passed`,`announceid`),
  KEY `fromdate` (`fromdate`,`todate`)
) TYPE=MyISAM;