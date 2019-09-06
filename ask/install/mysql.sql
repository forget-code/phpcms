INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`,`publishdate`, `installdate`, `updatedate`) VALUES ('咨询', 'ask', 'ask', '', 0, 0, 0, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', '咨询', '咨询', '咨询', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_ask`;
CREATE TABLE `phpcms_ask` (
  `askid` int(10) unsigned NOT NULL auto_increment,
  `departmentid` smallint(5) unsigned NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `username` varchar(30) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `lastreply` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `score` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`askid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_ask_department`;
CREATE TABLE `phpcms_ask_department` (
  `departmentid` int(11) NOT NULL auto_increment,
  `department` varchar(30) NOT NULL default '',
  `note` text NOT NULL,
  `admin` varchar(30) NOT NULL default '',
  `arrgroupid` varchar(255) NOT NULL default '',
  `point` smallint(5) unsigned NOT NULL default '0',
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`departmentid`),
  KEY `department` (`department`,`admin`)
) TYPE=MyISAM;

INSERT INTO `phpcms_ask_department` (`departmentid`, `department`, `note`, `admin`, `arrgroupid`, `point`, `listorder`) VALUES (1, '技术部', '', '', '', 0, 1);
INSERT INTO `phpcms_ask_department` (`departmentid`, `department`, `note`, `admin`, `arrgroupid`, `point`, `listorder`) VALUES (2, '业务部', '', 'phpcms', '', 0, 2);
INSERT INTO `phpcms_ask_department` (`departmentid`, `department`, `note`, `admin`, `arrgroupid`, `point`, `listorder`) VALUES (3, '财务部', '', 'phpcms', '', 0, 3);

DROP TABLE IF EXISTS `phpcms_ask_reply`;
CREATE TABLE `phpcms_ask_reply` (
  `replyid` int(10) unsigned NOT NULL auto_increment,
  `askid` int(10) unsigned NOT NULL default '0',
  `reply` text NOT NULL,
  `username` varchar(30) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`replyid`),
  KEY `askid` (`askid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '我要咨询', '', 'ask/', '_self', '', 19, '', '', '');