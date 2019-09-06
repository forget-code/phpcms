INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('自定义网页', 'mypage', 'mypage', '', 0, 0, 1, '1.0.0', 'phpcms', 'http://www.phpcms.cn', 'phpcms@phpcms.cn', '自定义网页管理', '', '', '', 0,  '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_mypage`;
CREATE TABLE `phpcms_mypage` (
  `mypageid` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `seo_title` varchar(255) NOT NULL default '',
  `seo_keywords` varchar(255) NOT NULL default '',
  `seo_description` varchar(255) NOT NULL default '',
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`mypageid`),
  KEY `name` (`name`)
) TYPE=MyISAM;