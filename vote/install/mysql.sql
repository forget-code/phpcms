INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('vote', '投票问卷', 'vote/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '多标题投票模块 for PHPCMS2008', '', '', '', 'array (\n  ''editor'' => ''1'',\n  ''template'' => '''',\n  ''checkcode'' => ''0'',\n  ''anonymous'' => ''1'',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_vote_data`;
CREATE TABLE IF NOT EXISTS `phpcms_vote_data` (
  `userid` mediumint(8) unsigned default '0',
  `username` char(20) NOT NULL,
  `subjectid` mediumint(8) unsigned NOT NULL default '0',
  `time` int(10) unsigned NOT NULL default '0',
  `ip` char(15) NOT NULL,
  `data` text NOT NULL,
  `userinfo` text NOT NULL,
  KEY `subjectid` (`subjectid`),
  KEY `userid` (`userid`),
  KEY `ip` (`ip`)
) TYPE=MyISAM ;


DROP TABLE IF EXISTS `phpcms_vote_option`;
CREATE TABLE IF NOT EXISTS `phpcms_vote_option` (
  `optionid` mediumint(8) unsigned NOT NULL auto_increment,
  `subjectid` mediumint(8) unsigned NOT NULL default '0',
  `option` varchar(255) NOT NULL,
  `image` varchar(100) NOT NULL,
  `listorder` tinyint(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`optionid`),
  KEY `subjectid` (`subjectid`)
) TYPE=MyISAM ;

INSERT INTO `phpcms_vote_option` VALUES (1, 1, 'google', '', 0);
INSERT INTO `phpcms_vote_option` VALUES (2, 1, 'baidu', '', 0);
INSERT INTO `phpcms_vote_option` VALUES (3, 1, 'sohu', '', 0);
INSERT INTO `phpcms_vote_option` VALUES (4, 1, 'yahoo', '', 0);
INSERT INTO `phpcms_vote_option` VALUES (5, 1, '电视/杂志广告', '', 0);
INSERT INTO `phpcms_vote_option` VALUES (6, 1, '朋友介绍', '', 0);
INSERT INTO `phpcms_vote_option` VALUES (7, 1, '其它站的友情链接', '', 0);
INSERT INTO `phpcms_vote_option` VALUES (8, 1, '无意中进来的', '', 0);
INSERT INTO `phpcms_vote_option` VALUES (9, 1, 'sogou', '', 1);

DROP TABLE IF EXISTS `phpcms_vote_subject`;
CREATE TABLE IF NOT EXISTS `phpcms_vote_subject` (
  `subjectid` mediumint(8) unsigned NOT NULL auto_increment,
  `subject` char(255) NOT NULL,
  `ismultiple` tinyint(1) unsigned NOT NULL default '0',
  `ischeckbox` tinyint(1) unsigned NOT NULL default '0',
  `credit` smallint(5) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `fromdate` date NOT NULL default '0000-00-00',
  `todate` date NOT NULL default '0000-00-00',
  `interval` tinyint(3) unsigned NOT NULL default '0',
  `enabled` tinyint(1) unsigned NOT NULL default '1',
  `template` char(20) NOT NULL,
  `parentid` mediumint(8) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  `userinfo` char(255) NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `enablecheckcode` tinyint(1) unsigned NOT NULL default '0',
  `allowguest` tinyint(1) unsigned NOT NULL default '1',
  `groupidsvote` char(100) NOT NULL,
  `groupidsview` char(100) NOT NULL,
  `maxval` tinyint(2) unsigned NOT NULL default '0',
  `minval` tinyint(1) unsigned NOT NULL default '1',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `allowview` tinyint(1) unsigned NOT NULL default '1',
  `optionnumber` tinyint(3) unsigned NOT NULL default '0',
  `votenumber` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`subjectid`),
  KEY `enabled` (`enabled`),
  KEY `fromdate` (`fromdate`,`todate`),
  KEY `todate` (`todate`)
) TYPE=MyISAM ;


INSERT INTO `phpcms_vote_subject` (`subjectid`, `subject`, `ismultiple`, `ischeckbox`, `credit`, `addtime`, `fromdate`, `todate`, `interval`, `enabled`, `template`, `parentid`, `description`, `userinfo`, `listorder`, `enablecheckcode`, `allowguest`, `groupidsvote`, `groupidsview`, `maxval`, `minval`, `userid`, `allowview`, `optionnumber`, `votenumber`) VALUES 
(1, '你是如何得知本站的？', 0, 0, 0, 1224321200, '2011-10-17', '2030-10-17', 0, 1, 'vote_vote_submit', 0, '', 'array (\n)', 0, 0, 1, '', '', 0, 1, 0, 1, 9, 0);


DROP TABLE IF EXISTS `phpcms_vote_useroption`;
CREATE TABLE IF NOT EXISTS `phpcms_vote_useroption` (
  `optionid` mediumint(8) unsigned NOT NULL default '0',
  `subjectid` mediumint(8) unsigned NOT NULL default '0',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  KEY `optionid` (`optionid`),
  KEY `subjectid` (`subjectid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM ;
