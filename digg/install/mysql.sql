INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('digg', '顶一下', 'digg/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '顶一下', '', '', '', 'array (\n  ''mode'' => ''1'',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_digg`;
CREATE TABLE IF NOT EXISTS `phpcms_digg` (
  `contentid` mediumint(8) unsigned NOT NULL default '0',
  `supports` mediumint(8) unsigned NOT NULL default '0',
  `againsts` mediumint(8) unsigned NOT NULL default '0',
  `supports_day` smallint(5) unsigned NOT NULL default '0',
  `againsts_day` smallint(5) unsigned NOT NULL default '0',
  `supports_week` mediumint(6) unsigned NOT NULL default '0',
  `againsts_week` mediumint(6) unsigned NOT NULL default '0',
  `supports_month` mediumint(8) unsigned NOT NULL default '0',
  `againsts_month` mediumint(8) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`contentid`),
  KEY `supports` (`supports`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_digg_log`;
CREATE TABLE IF NOT EXISTS `phpcms_digg_log` (
  `contentid` mediumint(8) unsigned NOT NULL default '0',
  `flag` tinyint(1) unsigned NOT NULL default '0',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `ip` char(15) NOT NULL,
  `time` int(10) unsigned NOT NULL default '0',
  KEY `contentid` (`contentid`,`flag`,`time`),
  KEY `userid` (`userid`,`contentid`),
  KEY `ip` (`ip`,`contentid`)
) TYPE=MyISAM;