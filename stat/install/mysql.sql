INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('访问统计', 'stat', 'stat', '', 0, 0, 0, '1.0.0', 'phpcms团队（汪伟）', 'http://www.phpcms.cn', 'phpcms@163.com', '访问统计', '', '', 'a:5:{s:8:"disabled";s:1:"1";s:8:"savetime";s:3:"180";s:8:"interval";s:2:"60";s:8:"username";s:6:"phpcms";s:6:"passwd";s:6:"phpcms";}', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_stat_visitor`;
CREATE TABLE `phpcms_stat_visitor` (
  `vid` int(11) unsigned NOT NULL auto_increment,
  `vip` varchar(23) NOT NULL default '',
  `osys` varchar(20) NOT NULL default '',
  `lang` varchar(10) NOT NULL default '',
  `broswer` varchar(20) NOT NULL default '',
  `screen` varchar(9) NOT NULL default '',
  `color` tinyint(3) unsigned NOT NULL default '0',
  `alexa` tinyint(1) unsigned NOT NULL default '0',
  `times` int(11) unsigned NOT NULL default '1',
  `etime` datetime NOT NULL default '0000-00-00 00:00:00',
  `ltime` timestamp(14) NOT NULL,
  `tweek` tinyint(2) unsigned NOT NULL default '0',
  `beon` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`vid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_stat_area`;
CREATE TABLE `phpcms_stat_area` (
  `aid` int(11) unsigned NOT NULL auto_increment,
  `vip` varchar(23) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `province` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`aid`),
  UNIQUE KEY `vip` (`vip`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_stat_history`;
CREATE TABLE `phpcms_stat_history` (
  `hid` tinyint(3) unsigned NOT NULL auto_increment,
  `content` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`hid`),
  UNIQUE KEY `content` (`content`),
  UNIQUE KEY `url` (`url`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_stat_vpages`;
CREATE TABLE `phpcms_stat_vpages` (
  `pid` int(11) unsigned NOT NULL auto_increment,
  `vid` int(11) unsigned NOT NULL default '0',
  `refurl` varchar(255) NOT NULL default '',
  `rdomain` varchar(50) NOT NULL default '',
  `keyword` varchar(255) NOT NULL default '',
  `pageurl` varchar(255) NOT NULL default '',
  `filen` varchar(20) NOT NULL default '',
  `ftime` datetime NOT NULL default '0000-00-00 00:00:00',
  `ltime` timestamp(14) NOT NULL,
  PRIMARY KEY  (`pid`),
  KEY `vid` (`vid`)
) TYPE=MyISAM;