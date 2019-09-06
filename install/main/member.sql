DROP TABLE IF EXISTS `phpcms_member`;
CREATE TABLE IF NOT EXISTS `phpcms_member` (
  `userid` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(20) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `question` varchar(50) NOT NULL default '',
  `answer` varchar(32) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `showemail` tinyint(1) NOT NULL default '0',
  `groupid` smallint(5) unsigned NOT NULL default '0',
  `arrgroupid` varchar(100) NOT NULL default '',
  `regip` varchar(15) NOT NULL default '',
  `regtime` int(11) unsigned NOT NULL default '0',
  `lastloginip` varchar(15) NOT NULL default '',
  `lastlogintime` int(11) unsigned NOT NULL default '0',
  `logintimes` smallint(5) unsigned NOT NULL default '0',
  `domain` varchar(50) NOT NULL default '',
  `chargetype` tinyint(1) NOT NULL default '0',
  `begindate` date NOT NULL default '0000-00-00',
  `enddate` date NOT NULL default '0000-00-00',
  `money` float NOT NULL default '0',
  `payment` float unsigned NOT NULL default '0',
  `point` smallint(5) unsigned NOT NULL default '0',
  `credit` smallint(5) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `items` smallint(5) unsigned NOT NULL default '0',
  `newmessages` tinyint(3) unsigned NOT NULL default '0',
  `authstr` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`userid`),
  UNIQUE KEY `username` (`username`),
  KEY `groupid` (`groupid`),
  KEY `email` (`email`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_member_group`;
CREATE TABLE IF NOT EXISTS `phpcms_member_group` (
  `groupid` tinyint(3) unsigned NOT NULL auto_increment,
  `groupname` varchar(50) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `grouptype` enum('system','special') NOT NULL default 'special',
  `chargetype` tinyint(1) unsigned NOT NULL default '0',
  `defaultpoint` smallint(5) unsigned NOT NULL default '0',
  `defaultvalidday` smallint(6) NOT NULL default '0',
  `discount` int(3) unsigned NOT NULL default '100',
  `enableaddalways` tinyint(1) unsigned NOT NULL default '0',
  `messagelimit` tinyint(3) unsigned NOT NULL default '20',
  PRIMARY KEY  (`groupid`),
  KEY `grouptype` (`grouptype`)
) TYPE=MyISAM;

INSERT INTO `phpcms_member_group` (`groupid`, `groupname`, `introduce`, `grouptype`, `chargetype`, `defaultpoint`, `defaultvalidday`, `discount`, `enableaddalways`, `messagelimit`) VALUES (1, '管理员', '', 'system', 1, 0, -1, 100, 0, 20);
INSERT INTO `phpcms_member_group` (`groupid`, `groupname`, `introduce`, `grouptype`, `chargetype`, `defaultpoint`, `defaultvalidday`, `discount`, `enableaddalways`, `messagelimit`) VALUES (2, '禁止访问', '', 'system', 0, 0, 0, 100, 0, 0);
INSERT INTO `phpcms_member_group` (`groupid`, `groupname`, `introduce`, `grouptype`, `chargetype`, `defaultpoint`, `defaultvalidday`, `discount`, `enableaddalways`, `messagelimit`) VALUES (3, '游客', '', 'system', 0, 0, 0, 100, 0, 0);
INSERT INTO `phpcms_member_group` (`groupid`, `groupname`, `introduce`, `grouptype`, `chargetype`, `defaultpoint`, `defaultvalidday`, `discount`, `enableaddalways`, `messagelimit`) VALUES (4, '待验证会员', '', 'system', 0, 0, 0, 100, 0, 0);
INSERT INTO `phpcms_member_group` (`groupid`, `groupname`, `introduce`, `grouptype`, `chargetype`, `defaultpoint`, `defaultvalidday`, `discount`, `enableaddalways`, `messagelimit`) VALUES (5, '待审批会员', '', 'system', 0, 0, 0, 100, 0, 0);
INSERT INTO `phpcms_member_group` (`groupid`, `groupname`, `introduce`, `grouptype`, `chargetype`, `defaultpoint`, `defaultvalidday`, `discount`, `enableaddalways`, `messagelimit`) VALUES (6, '注册会员', '', 'system', 1, 0, -1, 100, 0, 5);
INSERT INTO `phpcms_member_group` (`groupid`, `groupname`, `introduce`, `grouptype`, `chargetype`, `defaultpoint`, `defaultvalidday`, `discount`, `enableaddalways`, `messagelimit`) VALUES (7, '收费会员', '收费会员', 'special', 1, 0, -1, 100, 0, 20);
INSERT INTO `phpcms_member_group` (`groupid`, `groupname`, `introduce`, `grouptype`, `chargetype`, `defaultpoint`, `defaultvalidday`, `discount`, `enableaddalways`, `messagelimit`) VALUES (8, 'VIP会员', '', 'special', 1, 0, -1, 80, 0, 20);
INSERT INTO `phpcms_member_group` (`groupid`, `groupname`, `introduce`, `grouptype`, `chargetype`, `defaultpoint`, `defaultvalidday`, `discount`, `enableaddalways`, `messagelimit`) VALUES (9, '特约记者', '本站特约记者', 'special', 0, 100, -1, 100, 1, 20);

DROP TABLE IF EXISTS `phpcms_member_info`;
CREATE TABLE IF NOT EXISTS `phpcms_member_info` (
  `userid` int(11) NOT NULL default '0',
  `userface` varchar(255) NOT NULL default '',
  `facewidth` char(3) NOT NULL default '',
  `faceheight` char(3) NOT NULL default '',
  `sign` text NOT NULL,
  `truename` varchar(50) NOT NULL default '',
  `gender` tinyint(1) NOT NULL default '0',
  `birthday` date NOT NULL default '0000-00-00',
  `idtype` varchar(20) NOT NULL default '',
  `idcard` varchar(50) NOT NULL default '',
  `province` varchar(30) NOT NULL default '',
  `city` varchar(30) NOT NULL default '',
  `area` varchar(30) NOT NULL default '',
  `industry` varchar(50) NOT NULL default '',
  `edulevel` varchar(20) NOT NULL default '',
  `occupation` varchar(20) NOT NULL default '',
  `income` varchar(50) NOT NULL default '',
  `telephone` varchar(50) NOT NULL default '',
  `mobile` varchar(15) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `postid` varchar(6) NOT NULL default '',
  `homepage` varchar(255) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `msn` varchar(50) NOT NULL default '',
  `icq` varchar(20) NOT NULL default '',
  `skype` varchar(50) NOT NULL default '',
  `alipay` varchar(50) NOT NULL default '',
  `paypal` varchar(50) NOT NULL default '',
  `note` text NOT NULL,
  `my_mobile` varchar(255) NOT NULL default '',
  `my_special` text NOT NULL,
  PRIMARY KEY  (`userid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('会员', 'member', 'member', '', 1, 0, 0, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn/', 'phpcms@163.com', '会员管理', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');