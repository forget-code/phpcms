INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('comment', '评论', 'comment/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', 'array (\n  ''ischecklogin'' => ''1'',\n  ''ischeckcomment'' => ''0'',\n  ''enablecheckcode'' => ''1'',\n  ''maxnum'' => ''10'',\n  ''enabledkey'' => '','',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_comment`;
CREATE TABLE `phpcms_comment` (
  `commentid` int(10) unsigned NOT NULL auto_increment,
  `keyid` varchar(50) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL,
  `score` tinyint(1) unsigned NOT NULL default '0',
  `support` smallint(5) unsigned NOT NULL default '0',
  `against` smallint(5) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL default '0.0.0.0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`commentid`),
  KEY `keyid` (`keyid`,`status`,`commentid`),
  KEY `userid` (`userid`,`status`,`commentid`),
  KEY `ip` (`ip`,`status`,`commentid`),
  KEY `status` (`status`,`commentid`)
) TYPE=MyISAM;