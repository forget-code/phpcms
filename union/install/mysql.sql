INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('联盟', 'union', 'union', '', 0, 0, 0, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn/', 'phpcms@163.com', '功能说明', '许可协议', '使用帮助', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');

ALTER TABLE `phpcms_member` ADD `introducer` INT UNSIGNED NOT NULL;

INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '推广联盟', '', 'union/manage.php', '_self', '', 25, '', '', '');

DROP TABLE IF EXISTS `phpcms_union`;
CREATE TABLE `phpcms_union` (
  `userid` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `visits` int(10) unsigned NOT NULL default '0',
  `registers` int(10) unsigned NOT NULL default '0',
  `settleexpendamount` float unsigned NOT NULL default '0',
  `totalexpendamount` float unsigned NOT NULL default '0',
  `totalpayamount` float unsigned NOT NULL default '0',
  `lastpayamount` float unsigned NOT NULL default '0',
  `lastpaytime` float unsigned NOT NULL default '0',
  `profitmargin` float unsigned NOT NULL default '0',
  `regtime` int(10) unsigned NOT NULL default '0',
  `regip` varchar(15) NOT NULL default '',
  `passed` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`userid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_union_pay`;
CREATE TABLE `phpcms_union_pay` (
  `payid` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `alipay` varchar(100) NOT NULL default '',
  `amount` float NOT NULL default '0',
  `expendamount` float unsigned NOT NULL default '0',
  `profitmargin` float unsigned NOT NULL default '0',
  `inputer` varchar(30) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`payid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_union_visit`;
CREATE TABLE `phpcms_union_visit` (
  `visitid` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `visittime` int(10) unsigned NOT NULL default '0',
  `visitip` varchar(15) NOT NULL default '',
  `referer` varchar(255) NOT NULL default '',
  `regusername` varchar(30) NOT NULL default '',
  `regtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`visitid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM;