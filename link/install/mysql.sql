INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('link', '友情链接', 'link/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', 'array (\n  ''seo_keywords'' => ''友情链接'',\n  ''seo_description'' => ''友情链接'',\n  ''enablecheckcode'' => ''0'',\n  ''ischeck'' => ''1'',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_link`;
CREATE TABLE IF NOT EXISTS `phpcms_link` (
  `linkid` smallint(5) unsigned NOT NULL auto_increment,
  `typeid` smallint(5) unsigned NOT NULL default '0',
  `linktype` tinyint(1) unsigned NOT NULL default '0',
  `style` varchar(50) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `logo` varchar(255) NOT NULL default '',
  `introduce` text NOT NULL,
  `username` varchar(30) NOT NULL default '',
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `elite` tinyint(1) unsigned NOT NULL default '0',
  `passed` tinyint(1) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`linkid`),
  KEY `typeid` (`typeid`,`passed`,`listorder`,`linkid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_type` (`typeid`, `module`, `name`, `style`, `typedir`, `description`, `thumb`, `url`, `template`, `listorder`) VALUES (1, 'link', '默认分类', '', '', '', '', '', '', 0);
INSERT INTO `phpcms_link` (`linkid`, `typeid`, `linktype`, `style`, `name`, `url`, `logo`, `introduce`, `username`, `listorder`, `elite`, `passed`, `addtime`, `hits`) VALUES (1, 1, 1, '', 'phpcms', 'http://www.phpcms.cn', 'http://www.phpcms.cn/images/friendsitelogo.gif', '', '', 0, 1, 1, 1225078629, 0);
INSERT INTO `phpcms_link` (`linkid`, `typeid`, `linktype`, `style`, `name`, `url`, `logo`, `introduce`, `username`, `listorder`, `elite`, `passed`, `addtime`, `hits`) VALUES (2, 1, 1, '', '酷溜网', 'http://www.ku6.com', 'http://img1.c0.ku6.cn/css/www/v2/img/logo.jpg', '', '', 0, 1, 1, 1225078838, 0);
