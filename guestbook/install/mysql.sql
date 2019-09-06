INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('guestbook', '留言板', 'guestbook/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', 'array (\n  ''seo_keywords'' => ''phpcms留言板'',\n  ''seo_description'' => ''phpcms留言板'',\n  ''pagesize'' => ''20'',\n  ''maxcontent'' => ''1000'',\n  ''enablecheckcode'' => ''1'',\n  ''show'' => ''1'',\n  ''enableTourist'' => ''0'',\n  ''checkpass'' => ''0'',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_guestbook`;
CREATE TABLE `phpcms_guestbook` (
  `gid` smallint(5) NOT NULL auto_increment,
  `title` char(80) NOT NULL,
  `content` text NOT NULL,
  `reply` text NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `gender` tinyint(1) unsigned NOT NULL default '0',
  `head` tinyint(3) unsigned NOT NULL default '0',
  `email` char(40) NOT NULL,
  `qq` char(15) NOT NULL,
  `homepage` char(25) NOT NULL,
  `hidden` tinyint(1) unsigned NOT NULL default '0',
  `passed` tinyint(1) unsigned NOT NULL default '0',
  `ip` char(15) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `replyer` char(20) NOT NULL,
  `replytime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`gid`),
  KEY `hidden` (`hidden`,`gid`)
) TYPE=MyISAM;