INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('mail', '邮箱订阅', 'mail/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', 'array (\n  ''validation'' => ''0'',\n  ''maxnum'' => ''5'',\n  ''ischeckcode'' => ''1'',\n  ''enabledkey'' => '','',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_mail_email`;
CREATE TABLE `phpcms_mail_email` (
  `email` char(50) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `ip` char(15) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `authcode` char(32) NOT NULL,
  PRIMARY KEY  (`email`),
  KEY `userid` (`userid`)
) TYPE=MyISAM;
DROP TABLE IF EXISTS `phpcms_mail`;
CREATE TABLE `phpcms_mail` (
  `mailid` int(10) unsigned NOT NULL auto_increment,
  `typeid` smallint(5) unsigned NOT NULL default '0',
  `title` char(200) NOT NULL,
  `content` mediumtext NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `sendtime` int(10) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL,
  `period` int(10) unsigned NOT NULL default '0',
  `count` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mailid`),
  KEY `typeid` (`typeid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_mail_email_type`;
CREATE TABLE `phpcms_mail_email_type` (
  `email` char(50) NOT NULL,
  `typeid` smallint(5) unsigned NOT NULL default '0',
  KEY `email` (`email`),
  KEY `typeid` (`typeid`)
) TYPE=MyISAM;

