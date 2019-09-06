DROP TABLE IF EXISTS `phpcms_admin`;
CREATE TABLE IF NOT EXISTS `phpcms_admin` (
  `userid` int(11) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `grade` tinyint(2) unsigned NOT NULL default '0',
  `purviewids` text NOT NULL,
  `modules` text NOT NULL,
  `channelids` text NOT NULL,
  `catids` text NOT NULL,
  `specialids` text NOT NULL,
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`userid`),
  KEY `grade` (`grade`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_attachment`;
CREATE TABLE IF NOT EXISTS `phpcms_attachment` (
  `aid` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(20) NOT NULL default '',
  `keyid` varchar(20) NOT NULL default '',
  `catid` smallint(5) unsigned NOT NULL default '0',
  `itemid` int(11) unsigned NOT NULL default '0',
  `fileurl` varchar(255) NOT NULL default '',
  `filetype` varchar(10) NOT NULL default '',
  `filesize` int(11) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`aid`),
  KEY `username` (`username`),
  KEY `itemid` (`itemid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_author`;
CREATE TABLE IF NOT EXISTS `phpcms_author` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `keyid` varchar(30) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `items` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `channelid` (`keyid`,`updatetime`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_banip`;
CREATE TABLE IF NOT EXISTS `phpcms_banip` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `ip` varchar(15) NOT NULL default '',
  `ifban` tinyint(1) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `overtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ifban` (`ifban`),
  KEY `username` (`username`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_category`;
CREATE TABLE IF NOT EXISTS `phpcms_category` (
  `catid` smallint(6) unsigned NOT NULL auto_increment,
  `module` varchar(20) NOT NULL default '',
  `channelid` tinyint(3) unsigned NOT NULL default '0',
  `catname` varchar(50) NOT NULL default '',
  `catpic` varchar(255) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `introduce` text NOT NULL,
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `catdir` varchar(20) NOT NULL default '',
  `parentid` smallint(6) unsigned NOT NULL default '0',
  `arrparentid` varchar(255) NOT NULL default '',
  `parentdir` varchar(255) NOT NULL default '',
  `child` tinyint(1) NOT NULL default '0',
  `arrchildid` text NOT NULL,
  `itemtarget` tinyint(3) unsigned NOT NULL default '0',
  `itemordertype` tinyint(3) unsigned NOT NULL default '0',
  `listorder` smallint(6) unsigned NOT NULL default '0',
  `ismenu` tinyint(1) NOT NULL default '0',
  `islist` tinyint(1) NOT NULL default '0',
  `ishtml` tinyint(1) unsigned NOT NULL default '0',
  `htmldir` varchar(20) NOT NULL default '',
  `prefix` varchar(20) NOT NULL default '',
  `urlruleid` tinyint(1) unsigned NOT NULL default '0',
  `item_htmldir` varchar(20) NOT NULL default '',
  `item_prefix` varchar(20) NOT NULL default '',
  `item_html_urlruleid` tinyint(1) NOT NULL default '0',
  `item_php_urlruleid` tinyint(1) NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `setting` text NOT NULL,
  `items` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `disabled` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`catid`),
  KEY `module` (`module`,`disabled`),
  KEY `channelid` (`channelid`,`disabled`),
  KEY `ismenu` (`ismenu`),
  KEY `islist` (`islist`),
  KEY `listorder` (`listorder`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_channel`;
CREATE TABLE IF NOT EXISTS `phpcms_channel` (
  `channelid` tinyint(3) unsigned NOT NULL auto_increment,
  `module` varchar(20) NOT NULL default '',
  `channelname` varchar(20) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `channelpic` varchar(255) NOT NULL default '',
  `introduce` text NOT NULL,
  `seo_title` varchar(50) NOT NULL default '',
  `seo_keywords` varchar(255) NOT NULL default '',
  `seo_description` text NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `channeldir` varchar(30) NOT NULL default '',
  `channeldomain` varchar(50) NOT NULL default '',
  `disabled` tinyint(1) NOT NULL default '0',
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '',
  `items` int(11) unsigned NOT NULL default '0',
  `comments` int(11) unsigned NOT NULL default '0',
  `categorys` smallint(6) unsigned NOT NULL default '0',
  `specials` smallint(6) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `enablepurview` tinyint(1) NOT NULL default '0',
  `arrgroupid_browse` text NOT NULL,
  `purview_message` text NOT NULL,
  `point_message` text NOT NULL,
  `enablecontribute` tinyint(1) NOT NULL default '0',
  `enablecheck` tinyint(1) NOT NULL default '0',
  `emailofreject` text NOT NULL,
  `emailofpassed` text NOT NULL,
  `enableupload` tinyint(1) NOT NULL default '0',
  `uploaddir` varchar(50) NOT NULL default '',
  `maxfilesize` int(11) unsigned NOT NULL default '0',
  `uploadfiletype` varchar(255) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  `setting` text NOT NULL,
  `ishtml` tinyint(1) unsigned NOT NULL default '0',
  `cat_html_urlruleid` tinyint(1) NOT NULL default '0',
  `item_html_urlruleid` tinyint(1) NOT NULL default '0',
  `special_html_urlruleid` tinyint(1) NOT NULL default '0',
  `cat_php_urlruleid` tinyint(1) NOT NULL default '0',
  `item_php_urlruleid` tinyint(1) NOT NULL default '0',
  `special_php_urlruleid` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`channelid`),
  KEY `module` (`module`),
  KEY `disabled` (`disabled`),
  KEY `listorder` (`listorder`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_city`;
CREATE TABLE IF NOT EXISTS `phpcms_city` (
  `cityid` int(11) NOT NULL auto_increment,
  `province` varchar(20) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `area` varchar(50) NOT NULL default '',
  `postcode` varchar(10) NOT NULL default '',
  `areacode` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`cityid`),
  KEY `province` (`province`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_copyfrom`;
CREATE TABLE IF NOT EXISTS `phpcms_copyfrom` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `keyid` varchar(30) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `channelid` (`keyid`,`updatetime`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_field`;
CREATE TABLE IF NOT EXISTS `phpcms_field` (
  `fieldid` int(11) NOT NULL auto_increment,
  `tablename` varchar(25) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `size` int(10) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `note` text NOT NULL,
  `type` varchar(20) NOT NULL default '',
  `defaultvalue` text NOT NULL,
  `options` text NOT NULL,
  `formtype` varchar(20) NOT NULL default '',
  `inputtool` varchar(20) NOT NULL default '',
  `inputlimit` varchar(20) NOT NULL default '',
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `enablehtml` tinyint(1) unsigned NOT NULL default '0',
  `enablelist` tinyint(1) unsigned NOT NULL default '0',
  `enablesearch` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`fieldid`),
  KEY `tablename` (`tablename`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_keylink`;
CREATE TABLE IF NOT EXISTS `phpcms_keylink` (
  `linkid` int(11) NOT NULL auto_increment,
  `linktext` varchar(255) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  `passed` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`linkid`),
  KEY `linktext` (`linktext`,`passed`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_keywords`;
CREATE TABLE IF NOT EXISTS `phpcms_keywords` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `keyid` varchar(30) NOT NULL default '',
  `keywords` varchar(100) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `channelid` (`keyid`,`updatetime`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_log`;
CREATE TABLE IF NOT EXISTS `phpcms_log` (
  `logid` int(11) NOT NULL auto_increment,
  `mod` varchar(20) NOT NULL default '',
  `file` varchar(20) NOT NULL default '',
  `action` varchar(20) NOT NULL default '',
  `channelid` int(11) NOT NULL default '0',
  `querystring` text NOT NULL,
  `username` varchar(30) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`logid`),
  KEY `mod` (`mod`,`file`,`action`,`username`),
  KEY `addtime` (`addtime`),
  KEY `ip` (`ip`),
  KEY `channelid` (`channelid`)
) TYPE=MyISAM;

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

DROP TABLE IF EXISTS `phpcms_menu`;
CREATE TABLE IF NOT EXISTS `phpcms_menu` (
  `menuid` smallint(5) unsigned NOT NULL auto_increment,
  `position` varchar(20) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(200) NOT NULL default '',
  `target` varchar(20) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `arrgroupid` varchar(255) NOT NULL default '',
  `arrgrade` varchar(255) NOT NULL default '',
  `username` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`menuid`),
  KEY `position` (`position`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_module`;
CREATE TABLE IF NOT EXISTS `phpcms_module` (
  `moduleid` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `module` varchar(20) NOT NULL default '',
  `moduledir` varchar(20) NOT NULL default '',
  `moduledomain` varchar(50) NOT NULL default '',
  `iscore` tinyint(1) NOT NULL default '0',
  `iscopy` tinyint(1) NOT NULL default '0',
  `isshare` tinyint(1) NOT NULL default '0',
  `version` varchar(50) NOT NULL default '',
  `author` varchar(50) NOT NULL default '',
  `site` varchar(100) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `introduce` text NOT NULL,
  `license` text NOT NULL,
  `faq` mediumtext NOT NULL,
  `setting` text NOT NULL,
  `disabled` tinyint(1) NOT NULL default '0',
  `publishdate` date NOT NULL default '0000-00-00',
  `installdate` date NOT NULL default '0000-00-00',
  `updatedate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`moduleid`),
  UNIQUE KEY `module_2` (`module`),
  KEY `module` (`module`,`iscopy`,`isshare`,`disabled`,`publishdate`,`installdate`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_mytag`;
CREATE TABLE IF NOT EXISTS `phpcms_mytag` (
  `tagid` int(10) unsigned NOT NULL auto_increment,
  `tagname` varchar(50) NOT NULL default '',
  `content` text NOT NULL,
  `introduce` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`tagid`),
  UNIQUE KEY `tagname` (`tagname`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_position`;
CREATE TABLE IF NOT EXISTS `phpcms_position` (
  `posid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `keyid` varchar(20) NOT NULL default '',
  `listorder` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`posid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_position` VALUES (1, '网站首页推荐', '', 1);
INSERT INTO `phpcms_position` VALUES (2, '频道首页焦点', '', 2);
INSERT INTO `phpcms_position` VALUES (3, '频道首页推荐', '', 3);

DROP TABLE IF EXISTS `phpcms_province`;
CREATE TABLE IF NOT EXISTS `phpcms_province` (
  `provinceid` int(11) NOT NULL auto_increment,
  `province` varchar(20) NOT NULL default '',
  KEY `provinceid` (`provinceid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (1, '北京市');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (2, '上海市');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (3, '天津市');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (4, '重庆市');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (5, '河北省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (6, '山西省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (7, '内蒙古自治区');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (8, '辽宁省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (9, '吉林省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (10, '黑龙江省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (11, '江苏省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (12, '浙江省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (13, '安徽省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (14, '福建省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (15, '江西省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (16, '山东省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (17, '河南省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (18, '湖北省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (19, '湖南省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (20, '广东省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (21, '广西壮族自治区');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (22, '海南省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (23, '四川省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (24, '贵州省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (25, '云南省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (26, '西藏自治区');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (27, '陕西省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (28, '甘肃省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (29, '青海省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (30, '宁夏回族自治区');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (31, '新疆维吾尔自治区');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (32, '台湾省');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (33, '香港特别行政区');
INSERT INTO `phpcms_province` (`provinceid`, `province`) VALUES (34, '澳门特别行政区');

DROP TABLE IF EXISTS `phpcms_reword`;
CREATE TABLE IF NOT EXISTS `phpcms_reword` (
  `rid` int(11) NOT NULL auto_increment,
  `word` varchar(255) NOT NULL default '',
  `replacement` varchar(255) NOT NULL default '',
  `passed` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`rid`),
  KEY `word` (`word`,`passed`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_special`;
CREATE TABLE IF NOT EXISTS `phpcms_special` (
  `specialid` smallint(5) unsigned NOT NULL auto_increment,
  `parentid` smallint(5) unsigned NOT NULL default '0',
  `arrchildid` varchar(50) NOT NULL default '',
  `keyid` varchar(20) NOT NULL default '',
  `specialname` varchar(100) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `specialpic` varchar(255) NOT NULL default '',
  `specialbanner` varchar(255) NOT NULL default '',
  `prefix` varchar(50) NOT NULL default '',
  `introduce` text NOT NULL,
  `seo_title` varchar(50) NOT NULL default '',
  `seo_keywords` varchar(255) NOT NULL default '',
  `seo_description` text NOT NULL,
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '',
  `elite` tinyint(1) NOT NULL default '0',
  `listorder` smallint(4) unsigned NOT NULL default '9999',
  `addtime` int(10) unsigned NOT NULL default '0',
  `items` smallint(5) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  `closed` tinyint(1) NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `disabled` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`specialid`),
  KEY `channelid` (`keyid`,`disabled`,`listorder`,`specialid`),
  KEY `module` (`disabled`,`listorder`,`specialid`),
  KEY `parentid` (`disabled`,`listorder`,`specialid`),
  KEY `elite` (`elite`,`disabled`,`listorder`,`specialid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_type`;
CREATE TABLE IF NOT EXISTS `phpcms_type` (
  `typeid` smallint(5) unsigned NOT NULL auto_increment,
  `keyid` varchar(30) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `type` varchar(20) NOT NULL default '',
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `items` int(11) NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`typeid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_menu` (`menuid`, `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES (7, 'admin_top', '使用帮助', '', 'http://help.phpcms.cn/faq.php?action=user_admin', 'left', '', 6, '1', '', '');
INSERT INTO `phpcms_menu` (`menuid`, `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES (6, 'admin_top', '模板风格', '', '?mod=phpcms&file=index&action=template', 'left', '', 5, '', '0', '');
INSERT INTO `phpcms_menu` (`menuid`, `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES (5, 'admin_top', '功能模块', '', '?mod=phpcms&file=index&action=module', 'left', '', 3, '', '0', '');
INSERT INTO `phpcms_menu` (`menuid`, `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES (4, 'admin_top', '会员管理', '', '?mod=member&file=left', 'left', '', 4, '1', '0', '');
INSERT INTO `phpcms_menu` (`menuid`, `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES (3, 'admin_top', '网站频道', '', '?mod=phpcms&file=index&action=channel', 'left', '', 2, '', '0', '');
INSERT INTO `phpcms_menu` (`menuid`, `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES (2, 'admin_top', '系统设置', '', '?mod=phpcms&file=index&action=left', 'left', '', 1, '1', '0', '');
INSERT INTO `phpcms_menu` (`menuid`, `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES (1,'admin_top', '我的面板', '', '?mod=phpcms&file=index&action=mymenu', 'left', '', 0, '1', '', 'phpcms');

INSERT INTO `phpcms_module` (`moduleid`, `name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES (1, 'phpcms', 'phpcms', '', '', 1, 0, 0, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn/', 'phpcms@163.com', 'PHPCMS(PHP CMS)网站管理系统是一个基于PHP+MYSQL的全站生成html的建站系统，经过完善设计并适用于各种服务器环境(如UNIX、LINUX、WINDOWS等)的高效、全新、快速、优秀的网站解决方案，包括文章、下载、图片和信息四大功能模块，支持内容收费、广告管理和论坛整合，适合政府、学校、企业以及其他各种资讯类网站使用……', '', '帮助内容', 'a:87:{s:8:"sitename";s:24:"phpcms网站管理系统";s:7:"siteurl";s:21:"http://www.phpcms.cn/";s:4:"logo";s:15:"images/logo.gif";s:8:"linklogo";s:19:"images/linklogo.gif";s:5:"icpno";s:15:"陕ICP备***号";s:8:"bazscert";s:14:"cert/bazs.cert";s:9:"seo_title";s:24:"phpcms网站管理系统";s:12:"seo_keywords";s:24:"phpcms网站管理系统";s:15:"seo_description";s:24:"phpcms网站管理系统";s:6:"ishtml";s:1:"1";s:5:"index";s:5:"index";s:7:"fileext";s:4:"html";s:14:"webmasteremail";s:17:"master@domain.com";s:9:"copyright";s:24:"phpcms网站管理系统";s:12:"enableeditor";s:1:"1";s:17:"enablegetkeywords";s:1:"0";s:8:"province";s:9:"陕西省";s:4:"city";s:9:"西安市";s:4:"area";s:9:"莲湖区";s:9:"uploaddir";s:10:"uploadfile";s:14:"uploadfiletype";s:40:"gif|jpg|jpeg|png|bmp|txt|zip|rar|doc|swf";s:14:"uploadfunctype";s:1:"1";s:10:"enablegzip";s:1:"0";s:7:"maxpage";s:3:"100";s:8:"pagesize";s:2:"20";s:17:"autoupdatepagenum";s:1:"5";s:10:"searchtime";s:2:"10";s:16:"maxsearchresults";s:3:"500";s:13:"searchperpage";s:2:"10";s:13:"searchcontent";s:1:"1";s:7:"authkey";s:13:"www.phpcms.cn";s:13:"adminaccessip";s:0:"";s:14:"maxfailedtimes";s:1:"5";s:13:"maxlockedtime";s:1:"1";s:11:"enablebanip";s:1:"0";s:20:"enableadmincheckcode";s:1:"1";s:11:"enablethumb";s:1:"1";s:11:"thumb_width";s:3:"150";s:12:"thumb_height";s:3:"150";s:10:"water_type";s:1:"2";s:10:"water_text";s:13:"www.phpcms.cn";s:10:"water_font";s:24:"include/fonts/simhei.ttf";s:14:"water_fontsize";s:2:"18";s:15:"water_fontcolor";s:7:"#ff0000";s:11:"water_image";s:20:"images/watermark.gif";s:16:"water_transition";s:0:"";s:18:"water_jpeg_quality";s:0:"";s:12:"water_min_wh";s:0:"";s:9:"water_pos";s:1:"9";s:12:"sendmailtype";s:4:"smtp";s:8:"smtphost";s:12:"smtp.163.com";s:8:"smtpuser";s:13:"xxxxx@163.com";s:8:"smtppass";s:8:"********";s:8:"smtpport";s:2:"25";s:15:"enablesignature";s:1:"1";s:9:"signature";s:909:"<p>\r\n<table style="WIDTH: 331px; HEIGHT: 152px" cellspacing="0" cellpadding="0" width="331" class="mar_10">\r\n    <tbody>\r\n        <tr>\r\n            <td height="30">\r\n            <p><font color="#ff0000" size="3"><strong>&nbsp;联系方式</strong><font color="#000000" size="2">phpcms网站邮件系统签名</font></font></p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td>\r\n            <p>地址：西安市高新区高新路枫叶高层35号楼1706室(710075) <br />电话：029-88314457 <br />传真：029-88314457 <br />邮件：<a href="mailto:phpcms@163.com">phpcms@163.com</a><br />网址：<a href="http://www.phpcms.cn">http://www.phpcms.cn</a><br />咨询QQ：<a title="点击咨询" href="http://wpa.qq.com/msgrd?V=1&amp;Uin=411109466&amp;Site=phpcms.cn&amp;Menu=yes"><font color="#000000">411109466</font></a> </p>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</p>";s:9:"enableftp";s:1:"0";s:7:"ftphost";s:0:"";s:7:"ftpport";s:2:"21";s:7:"ftpuser";s:0:"";s:7:"ftppass";s:0:"";s:10:"ftpwebpath";s:0:"";s:14:"enablepassport";s:1:"0";s:13:"passport_file";s:6:"discuz";s:16:"passport_charset";s:3:"gbk";s:12:"passport_url";s:39:"http://www.***.com/bbs/api/passport.php";s:12:"passport_key";s:17:"qwertyu@dgffdghfh";s:20:"enableserverpassport";s:1:"0";s:18:"passport_serverurl";s:0:"";s:20:"passport_registerurl";s:0:"";s:17:"passport_loginurl";s:0:"";s:18:"passport_logouturl";s:0:"";s:23:"passport_getpasswordurl";s:0:"";s:18:"passport_serverkey";s:17:"qwertyu@dgffdghfh";s:15:"passport_expire";s:4:"3600";s:8:"enabletm";s:1:"0";s:2:"qq";s:0:"";s:3:"msn";s:0:"";s:5:"skype";s:0:"";s:6:"taobao";s:0:"";s:7:"alibaba";s:0:"";s:10:"enable53kf";s:1:"0";s:6:"kf_arg";s:0:"";s:8:"kf_style";s:0:"";s:6:"cc_uid";s:0:"";s:8:"cc_style";s:1:"3";s:7:"version";s:4:"2007";}', 0, '0000-00-00', '0000-00-00', '0000-00-00');