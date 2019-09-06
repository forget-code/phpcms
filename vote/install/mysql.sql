INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('投票', 'vote', 'vote', '', 0, 0, 1, '1.0.0', 'phpcms', 'http://www.phpcms.cn', 'phpcms@163.com', '投票', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_vote_subject`;
CREATE TABLE `phpcms_vote_subject` (
  `voteid` int(10) NOT NULL auto_increment,
  `keyid` varchar(20) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
  `type` varchar(8) NOT NULL default 'radio',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `fromdate` date NOT NULL default '0000-00-00',
  `todate` date NOT NULL default '0000-00-00',
  `totalnumber` int(11) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  `templateid` varchar(20) NOT NULL default '',
  `skinid` varchar(20) NOT NULL default '',
  `attribute` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`voteid`),
  KEY `channelid` (`keyid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_vote_option`;
CREATE TABLE `phpcms_vote_option` (
  `optionid` int(11) NOT NULL auto_increment,
  `voteid` int(10) NOT NULL default '0',
  `option` varchar(255) NOT NULL default '',
  `number` int(11) NOT NULL default '0',
  PRIMARY KEY  (`optionid`),
  KEY `voteid` (`voteid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_vote_data`;
CREATE TABLE `phpcms_vote_data` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `voteid` int(10) NOT NULL default '0',
  `voteuser` varchar(30) NOT NULL default '',
  `votetime` int(11) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `voteuser` (`voteuser`)
) TYPE=MyISAM;