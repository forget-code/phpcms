INSERT INTO `phpcms_module` ( `name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`,  `publishdate`, `installdate`, `updatedate`) VALUES ('单网页', 'page', 'page', '', 0, 0, 1, '1.0.0', 'phpcms', 'http://www.phpcms.cn', 'phpcms@phpcms.cn', '单网页管理', '', '', '',  0,'0000-00-00', '0000-00-00', '0000-00-00');
DROP TABLE IF EXISTS `phpcms_page`;

CREATE TABLE `phpcms_page` (
  `pageid` int(10) unsigned NOT NULL auto_increment,
  `keyid` varchar(30) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  `seo_title` varchar(255) NOT NULL default '',
  `seo_keywords` varchar(255) NOT NULL default '',
  `seo_description` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `filepath` varchar(100) NOT NULL default '',
  `skinid` varchar(20) NOT NULL default '',
  `templateid` varchar(20) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `edittime` int(10) unsigned NOT NULL default '0',
  `listorder` smallint(4) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`pageid`),
  KEY `title` (`title`),
  KEY `passed` (`passed`),
  KEY `username` (`username`),
  KEY `orderid` (`listorder`)
) TYPE=MyISAM;

INSERT INTO `phpcms_page` ( `keyid`, `title`, `linkurl`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `filepath`, `skinid`, `templateid`, `username`, `addtime`, `edittime`, `listorder`, `passed`) VALUES ('phpcms', '关于我们', '', '关于我们', '关于我们', '关于我们', '<p>网站介绍内容...</p>', 'page/aboutus.html', '0', '0', '', 1150311752, 0, 0, 1);
INSERT INTO `phpcms_page` ( `keyid`, `title`, `linkurl`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `filepath`, `skinid`, `templateid`, `username`, `addtime`, `edittime`, `listorder`, `passed`) VALUES ('phpcms', '版权声明', '', '版权声明', '版权声明', '版权声明', '<font color="#000000">版权声明内容...</font>', 'page/announce.html', '0', '0', '', 1150312631, 0, 0, 1);
INSERT INTO `phpcms_page` ( `keyid`, `title`, `linkurl`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `filepath`, `skinid`, `templateid`, `username`, `addtime`, `edittime`, `listorder`, `passed`) VALUES ('phpcms', '联系我们', '', '联系我们', '联系我们', '联系我们', '<font color="#000000">联系我们内容...</font>', 'page/contactus.html', '0', '0', '', 1150312711, 0, 0, 1);
INSERT INTO `phpcms_page` ( `keyid`, `title`, `linkurl`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `filepath`, `skinid`, `templateid`, `username`, `addtime`, `edittime`, `listorder`, `passed`) VALUES ('phpcms', '诚聘英才', '', '诚聘英才', '诚聘英才', '诚聘英才', '招聘信息内容...', 'page/joinus.html', '0', '0', '', 1150312777, 0, 1, 1);
INSERT INTO `phpcms_page` ( `keyid`, `title`, `linkurl`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `filepath`, `skinid`, `templateid`, `username`, `addtime`, `edittime`, `listorder`, `passed`) VALUES ('phpcms', '友情链接', '/link/', '', '', '', '', '', '', '0', '', 1150312828, 0, 2, 1);
INSERT INTO `phpcms_page` ( `keyid`, `title`, `linkurl`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `filepath`, `skinid`, `templateid`, `username`, `addtime`, `edittime`, `listorder`, `passed`) VALUES ('phpcms', '网站公告', '/announce/?channelid=0', '', '', '', '', '', '', '0', '', 1150316643, 0, 0, 0);
INSERT INTO `phpcms_page` ( `keyid`, `title`, `linkurl`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `filepath`, `skinid`, `templateid`, `username`, `addtime`, `edittime`, `listorder`, `passed`) VALUES ('phpcms', '广告服务', '', '广告报价表', '广告报价表', '广告报价表', '<p>广告服务介绍</p>\r\n<p><font color="#ff0000" size="3"><a href="/ads/"><font color="#ff0000">广告位报价表》</font></a></font></p>', 'page/ads.html', '0', '0', '', 1150448950, 0, 0, 1);