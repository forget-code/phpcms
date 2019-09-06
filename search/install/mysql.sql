INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('search', '全站搜索', 'search/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '全站搜索', '', '', '', 'array (\n  ''titlelen'' => ''80'',\n  ''descriptionlen'' => ''480'',\n  ''type_urlruleid'' => '''',\n  ''show_urlruleid'' => '''',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_search`;
CREATE TABLE IF NOT EXISTS `phpcms_search` (
  `searchid` mediumint(8) unsigned NOT NULL auto_increment,
  `type` varchar(15) NOT NULL,
  `data` mediumtext NOT NULL,
  PRIMARY KEY  (`searchid`),
  KEY `type` (`type`),
  FULLTEXT KEY `data` (`data`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_search_type`;
CREATE TABLE `phpcms_search_type` (
  `type` char(15) NOT NULL,
  `name` char(20) NOT NULL,
  `md5key` char(32) NOT NULL,
  `description` char(255) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`type`)
) TYPE=MyISAM;

INSERT INTO `phpcms_search_type` (`type`, `name`, `md5key`, `description`, `listorder`, `disabled`) VALUES ('news', '资讯', '', '', 1, 0);
INSERT INTO `phpcms_search_type` (`type`, `name`, `md5key`, `description`, `listorder`, `disabled`) VALUES ('picture', '图片', '', '', 2, 0);
INSERT INTO `phpcms_search_type` (`type`, `name`, `md5key`, `description`, `listorder`, `disabled`) VALUES ('down', '下载', '', '', 3, 0);
INSERT INTO `phpcms_search_type` (`type`, `name`, `md5key`, `description`, `listorder`, `disabled`) VALUES ('info', '信息', '', '', 4, 0);
INSERT INTO `phpcms_search_type` (`type`, `name`, `md5key`, `description`, `listorder`, `disabled`) VALUES ('product', '产品', '', '', 5, 0);
INSERT INTO `phpcms_search_type` (`type`, `name`, `md5key`, `description`, `listorder`, `disabled`) VALUES ('ask', '问吧', '', '', 6, 0);
