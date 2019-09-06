INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('formguide', '表单向导', 'formguide/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', 'array (\n  ''allowmultisubmit'' => ''1'',\n  ''allowunregsubmit'' => ''1'',\n  ''allowsendemail'' => ''0'',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_formguide`;
CREATE TABLE IF NOT EXISTS `phpcms_formguide` (
  `formid` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `tablename` varchar(30) NOT NULL,
  `introduce` varchar(255) NOT NULL,
  `setting` mediumtext NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `template` varchar(50) NOT NULL,
  `disabled` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`formid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_formguide_fields`;
CREATE TABLE IF NOT EXISTS `phpcms_formguide_fields` (
  `fieldid` mediumint(8) unsigned NOT NULL auto_increment,
  `formid` mediumint(8) unsigned NOT NULL default '0',
  `field` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `tips` text NOT NULL,
  `css` varchar(30) NOT NULL,
  `minlength` int(10) unsigned NOT NULL default '0',
  `maxlength` int(10) unsigned NOT NULL default '0',
  `pattern` varchar(255) NOT NULL,
  `errortips` varchar(255) NOT NULL,
  `formtype` varchar(20) NOT NULL,
  `setting` mediumtext NOT NULL,
  `formattribute` varchar(255) NOT NULL,
  `unsetgroupids` varchar(255) NOT NULL,
  `issystem` tinyint(1) unsigned NOT NULL default '0',
  `isbackground` tinyint(1) unsigned NOT NULL default '0',
  `isunique` tinyint(1) unsigned NOT NULL default '0',
  `issearch` tinyint(1) unsigned NOT NULL default '0',
  `isselect` tinyint(1) unsigned NOT NULL default '0',
  `islist` tinyint(1) unsigned NOT NULL default '0',
  `isshow` tinyint(1) unsigned NOT NULL default '0',
  `listorder` mediumint(8) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`fieldid`),
  KEY `field` (`field`,`formid`),
  KEY `formid` (`formid`,`disabled`)
) TYPE=MyISAM;