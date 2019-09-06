INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('友情链接', 'link', 'link', '', 0, 0, 0, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn/', 'phpcms@163.com', '模块介绍', '许可协议', '使用帮助', 'a:5:{s:12:"seo_keywords";s:12:"友情链接";s:15:"seo_description";s:12:"友情链接";s:9:"uploaddir";s:7:"linkpic";s:15:"enablecheckcode";s:1:"1";s:7:"ischeck";s:1:"1";}', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_link`;
CREATE TABLE `phpcms_link` (
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

INSERT INTO `phpcms_link` (`typeid`, `linktype`, `style`, `name`, `url`, `logo`, `introduce`, `username`, `listorder`, `elite`, `passed`, `addtime`, `hits`) VALUES 
(36, 1, '', 'phpcms', 'http://www.phpcms.cn', 'http://www.phpcms.cn/images/friendsitelogo.gif', 'PHPCMS网站管理系统', '', 1, 1, 1, 1171071540, 0);
