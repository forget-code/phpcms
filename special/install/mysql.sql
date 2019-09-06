INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('special', '专题', 'special/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '专题', '', '', '', 'array (\n  ''ishtml'' => ''1'',\n  ''type_urlruleid'' => ''13'',\n  ''show_urlruleid'' => ''19'',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_special`;
CREATE TABLE IF NOT EXISTS `phpcms_special` (
  `specialid` smallint(5) unsigned NOT NULL auto_increment,
  `typeid` smallint(5) unsigned NOT NULL default '0',
  `title` varchar(80) NOT NULL,
  `style` varchar(5) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `banner` varchar(100) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `description` mediumtext NOT NULL,
  `url` varchar(100) NOT NULL,
  `template` varchar(30) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL,
  `createtime` int(10) unsigned NOT NULL default '0',
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `elite` tinyint(1) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`specialid`),
  KEY `typeid` (`typeid`,`disabled`,`elite`,`listorder`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_special_content`;
CREATE TABLE `phpcms_special_content` (
  `specialid` smallint(5) unsigned NOT NULL default '0',
  `contentid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`specialid`,`contentid`),
  KEY `contentid` (`contentid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(13, 'special', 'type', 1, '{$typedir}/index.{$fileext}|{$typedir}/{$page}.{$fileext}', 'news/10.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(14, 'special', 'type', 1, '{$typedir}.{$fileext}|{$typedir}_{$page}.{$fileext}', 'news_10.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(15, 'special', 'type', 1, '{$typeid}.{$fileext}|{$typeid}_{$page}.{$fileext}', '10_1.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(16, 'special', 'type', 0, 'list.php?typeid={$typeid}|list.php?typeid={$typeid}&page={$page}', 'list.php?typeid=10&page=1');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(17, 'special', 'type', 0, 'list.php?typeid-{typeid}.html|list.php?typeid-{typeid}/page-{$page}.html', 'list.php?typeid-10/page-1.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(18, 'special', 'type', 0, 'list-{$typeid}-{$page}.html', 'list-10-1.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(19, 'special', 'show', 1, '{$typedir}/{$filename}.{$fileext}', 'news/beijing2008.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(20, 'special', 'show', 1, '{$typedir}_{$filename}.{$fileext}', 'news_beijing2008.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(21, 'special', 'show', 1, '{$filename}.{$fileext}', 'beijing2008.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(22, 'special', 'show', 0, 'show.php?specialid={$specialid}', 'show.php?specialid=1');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(23, 'special', 'show', 0, 'show.php?specialid-{$specialid}.html', 'show.php?specialid-1.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(24, 'special', 'show', 0, 'show-{$specialid}.html', 'show-1.html');