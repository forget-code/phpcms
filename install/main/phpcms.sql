DROP TABLE IF EXISTS `phpcms_admin`;
CREATE TABLE `phpcms_admin` (
  `userid` mediumint(8) unsigned NOT NULL,
  `username` char(20) NOT NULL,
  `allowmultilogin` tinyint(1) unsigned NOT NULL default '0',
  `alloweditpassword` tinyint(1) unsigned NOT NULL default '0',
  `editpasswordnextlogin` tinyint(1) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`userid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_admin_role`;
CREATE TABLE `phpcms_admin_role` (
  `userid` mediumint(8) unsigned NOT NULL,
  `roleid` tinyint(3) unsigned NOT NULL,
  KEY `userid` (`userid`),
  KEY `roleid` (`roleid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_admin_role_priv`;
CREATE TABLE `phpcms_admin_role_priv` (
  `roleid` tinyint(3) unsigned NOT NULL default '0',
  `field` char(15) NOT NULL,
  `value` char(15) NOT NULL,
  `priv` char(15) NOT NULL,
  PRIMARY KEY  (`roleid`,`field`,`value`,`priv`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `phpcms_area`;
CREATE TABLE `phpcms_area` (
  `areaid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `style` varchar(35) NOT NULL,
  `parentid` smallint(5) unsigned NOT NULL default '0',
  `arrparentid` varchar(255) NOT NULL default '',
  `child` tinyint(1) unsigned NOT NULL default '0',
  `arrchildid` mediumtext NOT NULL,
  `template` varchar(50) NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`areaid`),
  KEY `parentid` (`parentid`,`listorder`)
) TYPE=MyISAM;

INSERT INTO `phpcms_area` (`areaid`, `name`, `style`, `parentid`, `arrparentid`, `child`, `arrchildid`, `template`, `listorder`, `hits`) VALUES (1, '北京', '', 0, '0', 0, '1', '', 1, 0);
INSERT INTO `phpcms_area` (`areaid`, `name`, `style`, `parentid`, `arrparentid`, `child`, `arrchildid`, `template`, `listorder`, `hits`) VALUES (2, '上海', '', 0, '0', 0, '2', '', 2, 0);

DROP TABLE IF EXISTS `phpcms_attachment`;
CREATE TABLE `phpcms_attachment` (
  `aid` int(10) unsigned NOT NULL auto_increment,
  `module` char(15) NOT NULL,
  `catid` smallint(5) unsigned NOT NULL default '0',
  `contentid` mediumint(8) unsigned NOT NULL default '0',
  `field` char(20) NOT NULL,
  `filename` char(50) NOT NULL,
  `filepath` char(200) NOT NULL,
  `filetype` char(30) NOT NULL,
  `filesize` int(10) unsigned NOT NULL default '0',
  `fileext` char(10) NOT NULL,
  `description` char(50) NOT NULL,
  `isimage` tinyint(1) unsigned NOT NULL default '0',
  `isthumb` tinyint(1) unsigned NOT NULL default '0',
  `downloads` mediumint(8) unsigned NOT NULL default '0',
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `uploadtime` int(10) unsigned NOT NULL default '0',
  `uploadip` char(15) NOT NULL,
  PRIMARY KEY  (`aid`),
  KEY `contentid` (`contentid`,`field`,`listorder`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_author`;
CREATE TABLE `phpcms_author` (
  `authorid` smallint(5) unsigned NOT NULL auto_increment,
  `username` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `gender` tinyint(1) unsigned NOT NULL default '0',
  `birthday` date NOT NULL default '0000-00-00',
  `email` varchar(40) NOT NULL,
  `qq` varchar(15) NOT NULL,
  `msn` varchar(40) NOT NULL,
  `homepage` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `introduce` mediumtext NOT NULL,
  `updatetime` int(10) unsigned NOT NULL default '0',
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  `elite` tinyint(1) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`authorid`),
  UNIQUE KEY `name` (`name`),
  KEY `username` (`username`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `phpcms_block`;
CREATE TABLE `phpcms_block` (
  `blockid` smallint(5) unsigned NOT NULL auto_increment,
  `pageid` varchar(20) NOT NULL,
  `blockno` tinyint(2) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL,
  `isarray` tinyint(1) unsigned NOT NULL default '0',
  `rows` tinyint(2) unsigned NOT NULL default '8',
  `data` mediumtext NOT NULL,
  `listorder` tinyint(2) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`blockid`),
  KEY `pageid` (`pageid`,`blockno`,`disabled`,`listorder`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_c_down`;
CREATE TABLE `phpcms_c_down` (
  `contentid` mediumint(8) unsigned NOT NULL,
  `template` varchar(30) NOT NULL,
  `content` mediumtext NOT NULL,
  `version` varchar(20) NOT NULL default '',
  `classtype` varchar(20) NOT NULL default '国产软件',
  `language` varchar(20) NOT NULL default '简体中文',
  `copytype` varchar(15) NOT NULL default '免费版',
  `systems` varchar(100) NOT NULL default 'Win2000/WinXP/Win2003',
  `stars` varchar(20) NOT NULL default '★★★☆☆',
  `filesize` varchar(20) NOT NULL default '未知',
  `downurl` varchar(255) NOT NULL default '',
  `downurls` text NOT NULL,
  `groupids_view` tinyint(1) unsigned NOT NULL default '0',
  `readpoint` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`contentid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_c_info`;
CREATE TABLE `phpcms_c_info` (
  `contentid` mediumint(8) unsigned NOT NULL,
  `template` char(30) NOT NULL,
  `content` mediumtext NOT NULL,
  `endtime` date NOT NULL default '0000-00-00',
  `telephone` varchar(100) NOT NULL default '',
  `email` varchar(40) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `groupids_view` tinyint(1) unsigned NOT NULL default '0',
  `readpoint` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`contentid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_c_news`;
CREATE TABLE `phpcms_c_news` (
  `contentid` mediumint(8) unsigned NOT NULL,
  `template` varchar(30) NOT NULL default '',
  `titleintact` varchar(200) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `groupids_view` tinyint(1) unsigned NOT NULL default '0',
  `readpoint` smallint(5) unsigned NOT NULL default '0',
  `author` varchar(30) NOT NULL default '',
  `copyfrom` varchar(100) NOT NULL,
  PRIMARY KEY  (`contentid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_c_picture`;
CREATE TABLE `phpcms_c_picture` (
  `contentid` mediumint(8) unsigned NOT NULL,
  `template` char(30) NOT NULL,
  `content` mediumtext NOT NULL,
  `pictureurls` tinyint(1) unsigned NOT NULL default '0',
  `author` varchar(30) NOT NULL default '',
  `copyfrom` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`contentid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_c_product`;
CREATE TABLE `phpcms_c_product` (
  `contentid` mediumint(8) unsigned NOT NULL,
  `template` varchar(255) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `price` float unsigned NOT NULL default '0',
  `size` varchar(50) NOT NULL default '',
  `pictureurls` tinyint(1) unsigned NOT NULL default '0',
  `unit` varchar(4) NOT NULL default '个',
  `stock` varchar(20) NOT NULL default '',
  `stars` varchar(20) NOT NULL default '★★★☆☆',
  PRIMARY KEY  (`contentid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_cache_count`;
CREATE TABLE `phpcms_cache_count` (
  `id` char(32) NOT NULL default '',
  `count` mediumint(8) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MEMORY;

DROP TABLE IF EXISTS `phpcms_category`;
CREATE TABLE `phpcms_category` (
  `catid` smallint(5) unsigned NOT NULL auto_increment,
  `module` varchar(15) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL default '0',
  `modelid` tinyint(3) unsigned NOT NULL default '0',
  `parentid` smallint(5) unsigned NOT NULL default '0',
  `arrparentid` varchar(255) NOT NULL,
  `child` tinyint(1) unsigned NOT NULL default '0',
  `arrchildid` mediumtext NOT NULL,
  `catname` varchar(30) NOT NULL,
  `style` varchar(5) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `parentdir` varchar(100) NOT NULL,
  `catdir` varchar(30) NOT NULL,
  `url` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `items` mediumint(8) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  `setting` mediumtext NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `ismenu` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`catid`),
  KEY `module` (`module`,`parentid`,`listorder`,`catid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_category` (`catid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `content`, `items`, `hits`, `setting`, `listorder`, `ismenu`) VALUES (1, 'phpcms', 1, 0, 0, '0', 1, '1,2,3,4,5', '网站介绍', '', '', '', '', 'about', 'about/index.html', '网站介绍', 0, 0, 'array (\n  ''template'' => ''page'',\n  ''ishtml'' => ''1'',\n  ''category_urlruleid'' => ''1'',\n  ''meta_title'' => '''',\n  ''meta_keywords'' => '''',\n  ''meta_description'' => '''',\n)', 1, 0);
INSERT INTO `phpcms_category` (`catid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `content`, `items`, `hits`, `setting`, `listorder`, `ismenu`) VALUES (2, 'phpcms', 1, 0, 1, '0,1', 0, '2', '关于我们', '', '', '', 'about/', 'aboutus', 'about/aboutus/index.html', '关于我们', 0, 0, 'array (\n  ''template'' => ''page'',\n  ''ishtml'' => ''1'',\n  ''category_urlruleid'' => ''1'',\n  ''meta_title'' => ''关于我们'',\n  ''meta_keywords'' => ''关于我们'',\n  ''meta_description'' => ''关于我们'',\n)', 2, 0);
INSERT INTO `phpcms_category` (`catid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `content`, `items`, `hits`, `setting`, `listorder`, `ismenu`) VALUES (3, 'phpcms', 1, 0, 1, '0,1', 0, '3', '联系方式', '', '', '', 'about/', 'contactus', 'about/contactus/index.html', '联系方式', 0, 0, 'array (\n  ''template'' => ''page'',\n  ''ishtml'' => ''1'',\n  ''category_urlruleid'' => ''1'',\n  ''meta_title'' => ''联系方式'',\n  ''meta_keywords'' => ''联系方式'',\n  ''meta_description'' => ''联系方式'',\n)', 3, 0);
INSERT INTO `phpcms_category` (`catid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `content`, `items`, `hits`, `setting`, `listorder`, `ismenu`) VALUES (4, 'phpcms', 1, 0, 1, '0,1', 0, '4', '招聘信息', '', '', '', 'about/', 'joinus', 'about/joinus/index.html', '招聘信息', 0, 0, 'array (\n  ''template'' => ''page'',\n  ''ishtml'' => ''1'',\n  ''category_urlruleid'' => ''1'',\n  ''meta_title'' => ''招聘信息'',\n  ''meta_keywords'' => ''招聘信息'',\n  ''meta_description'' => ''招聘信息'',\n)', 4, 0);
INSERT INTO `phpcms_category` (`catid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `content`, `items`, `hits`, `setting`, `listorder`, `ismenu`) VALUES (5, 'phpcms', 1, 0, 1, '0,1', 0, '5', '版权声明', '', '', '', 'about/', 'copyright', 'about/copyright/index.html', '版权声明', 0, 0, 'array (\n  ''template'' => ''page'',\n  ''ishtml'' => ''1'',\n  ''category_urlruleid'' => ''1'',\n  ''meta_title'' => ''版权声明'',\n  ''meta_keywords'' => ''版权声明'',\n  ''meta_description'' => ''版权声明'',\n)', 5, 0);
INSERT INTO `phpcms_category` (`catid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `content`, `items`, `hits`, `setting`, `listorder`, `ismenu`) VALUES (7, 'phpcms', 2, 0, 0, '0', 0, '7', '专题', '', '', '', '', '', 'special/', '', 0, 0, '', 501, 1);
INSERT INTO `phpcms_category` (`catid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `content`, `items`, `hits`, `setting`, `listorder`, `ismenu`) VALUES (9, 'phpcms', 2, 0, 0, '0', 0, '9', '问吧', '', '', '', '', '', 'ask/', '', 0, 0, '', 502, 1);
INSERT INTO `phpcms_category` (`catid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `content`, `items`, `hits`, `setting`, `listorder`, `ismenu`) VALUES (8, 'phpcms', 2, 0, 0, '0', 0, '8', '搜索', '', '', '', '', '', 'search/', '', 0, 0, '', 503, 1);
INSERT INTO `phpcms_category` (`catid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `content`, `items`, `hits`, `setting`, `listorder`, `ismenu`) VALUES (6, 'phpcms', 2, 0, 0, '0', 0, '6', '会员', '', '', '', '', '', 'member/list.php?modelid=10', '', 0, 0, '', 504, 1);
INSERT INTO `phpcms_category` (`catid`, `module`, `type`, `modelid`, `parentid`, `arrparentid`, `child`, `arrchildid`, `catname`, `style`, `image`, `description`, `parentdir`, `catdir`, `url`, `content`, `items`, `hits`, `setting`, `listorder`, `ismenu`) VALUES (10, 'phpcms', 2, 0, 0, '0', 0, '10', '论坛', '', '', '', '', '', 'http://bbs.phpcms.cn', '', 0, 0, '', 505, 1);

DROP TABLE IF EXISTS `phpcms_content`;
CREATE TABLE `phpcms_content` (
  `contentid` mediumint(8) unsigned NOT NULL auto_increment,
  `catid` smallint(5) unsigned NOT NULL default '0',
  `typeid` smallint(5) unsigned NOT NULL default '0',
  `areaid` smallint(5) unsigned NOT NULL default '0',
  `title` char(80) NOT NULL default '',
  `style` char(5) NOT NULL default '',
  `thumb` char(100) NOT NULL default '',
  `keywords` char(40) NOT NULL default '',
  `description` char(255) NOT NULL default '',
  `posids` tinyint(1) unsigned NOT NULL default '0',
  `url` char(100) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  `status` tinyint(2) unsigned NOT NULL default '3',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  `searchid` mediumint(8) unsigned NOT NULL default '0',
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `prefix` char(20) NOT NULL default '',
  PRIMARY KEY  (`contentid`),
  KEY `status` (`status`,`listorder`,`contentid`),
  KEY `listorder` (`catid`,`status`,`listorder`,`contentid`),
  KEY `catid` (`catid`,`status`,`contentid`),
  KEY `updatetime` (`catid`,`status`,`updatetime`),
  KEY `typeid` (`typeid`,`status`,`contentid`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `phpcms_content_count`;
CREATE TABLE `phpcms_content_count` (
  `contentid` mediumint(8) unsigned NOT NULL,
  `hits` mediumint(8) unsigned NOT NULL default '0',
  `hits_day` smallint(5) unsigned NOT NULL default '0',
  `hits_week` mediumint(8) unsigned NOT NULL default '0',
  `hits_month` mediumint(8) unsigned NOT NULL default '0',
  `hits_time` int(10) unsigned NOT NULL default '0',
  `comments` smallint(5) unsigned NOT NULL default '0',
  `comments_checked` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`contentid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_content_position`;
CREATE TABLE `phpcms_content_position` (
  `contentid` mediumint(8) unsigned NOT NULL default '0',
  `posid` smallint(5) unsigned NOT NULL default '0',
  KEY `posid` (`posid`),
  KEY `contentid` (`contentid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_content_tag`;
CREATE TABLE `phpcms_content_tag` (
  `tag` char(20) NOT NULL,
  `contentid` mediumint(8) unsigned NOT NULL default '0',
  KEY `contentid` (`contentid`),
  KEY `tag` (`tag`(10))
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_copyfrom`;
CREATE TABLE `phpcms_copyfrom` (
  `copyfromid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `usetimes` mediumint(8) unsigned NOT NULL default '0',
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`copyfromid`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_datasource`;
CREATE TABLE `phpcms_datasource` (
  `name` varchar(15) NOT NULL,
  `dbtype` varchar(10) NOT NULL,
  `dbhost` varchar(15) NOT NULL,
  `dbuser` varchar(10) NOT NULL,
  `dbpw` varchar(50) NOT NULL,
  `dbname` varchar(20) NOT NULL,
  `dbcharset` varchar(10) NOT NULL,
  `tablename` varchar(30) NOT NULL,
  `fields` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`name`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_hits`;
CREATE TABLE `phpcms_hits` (
  `field` char(10) NOT NULL,
  `value` mediumint(8) unsigned NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `hits` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`field`,`value`,`date`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_ipbanned`;
CREATE TABLE `phpcms_ipbanned` (
  `ip` char(15) NOT NULL,
  `expires` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ip`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_keylink`;
CREATE TABLE `phpcms_keylink` (
  `keylinkid` smallint(5) unsigned NOT NULL auto_increment,
  `word` char(40) NOT NULL,
  `url` char(100) NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`keylinkid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_keyword`;
CREATE TABLE `phpcms_keyword` (
  `tagid` smallint(5) unsigned NOT NULL auto_increment,
  `tag` char(20) NOT NULL,
  `style` char(5) NOT NULL,
  `usetimes` smallint(5) unsigned NOT NULL default '0',
  `lastusetime` int(10) unsigned NOT NULL default '0',
  `hits` mediumint(8) unsigned NOT NULL default '0',
  `lasthittime` int(10) unsigned NOT NULL default '0',
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tagid`),
  UNIQUE KEY `tag` (`tag`),
  KEY `usetimes` (`usetimes`,`listorder`),
  KEY `hits` (`hits`,`listorder`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_log`;
CREATE TABLE `phpcms_log` (
  `logid` int(10) unsigned NOT NULL auto_increment,
  `field` varchar(15) NOT NULL,
  `value` int(10) unsigned NOT NULL default '0',
  `module` varchar(15) NOT NULL,
  `file` varchar(20) NOT NULL,
  `action` varchar(20) NOT NULL,
  `querystring` varchar(255) NOT NULL,
  `data` mediumtext NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`logid`),
  KEY `userid` (`userid`),
  KEY `module` (`module`,`file`,`action`),
  KEY `field` (`field`,`value`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_menu`;
CREATE TABLE `phpcms_menu` (
  `menuid` smallint(5) unsigned NOT NULL auto_increment,
  `parentid` smallint(5) unsigned NOT NULL default '0',
  `name` char(20) NOT NULL,
  `image` char(100) NOT NULL,
  `url` char(100) NOT NULL,
  `description` char(100) NOT NULL,
  `target` char(15) NOT NULL default 'right',
  `style` char(15) NOT NULL,
  `js` char(100) NOT NULL,
  `groupids` char(60) NOT NULL,
  `roleids` char(60) NOT NULL,
  `isfolder` tinyint(1) unsigned NOT NULL default '0',
  `isopen` tinyint(1) unsigned NOT NULL default '0',
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `keyid` char(30) NOT NULL,
  PRIMARY KEY  (`menuid`),
  KEY `userid` (`userid`),
  KEY `keyid` (`keyid`),
  KEY `parentid` (`parentid`,`listorder`,`menuid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (1, 0, '后台顶部菜单', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (20, 0, '会员中心', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'member_0');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (40, 0, '会员中心快捷菜单', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'member_1');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (2, 1, '我的面板', '', '', '', 'left', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (3, 1, '系统设置', '', '', '', 'left', '', '', '', '1,2', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (4, 1, '内容管理', '', '', '', 'left', '', '', '', '1,2,3', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (5, 1, '模块管理', '', '', '', 'left', '', '', '', '1,2,3,5', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (6, 1, '会员管理', '', '', '', 'left', '', '', '', '1,2,3', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (7, 1, '模板风格', '', '', '', 'left', '', '', '', '1,4', 1, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (61, 4, '全部内容', '', '?mod=phpcms&file=content_all', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (62, 4, '专题管理', '', '?mod=special&file=special&action=list', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (63, 4, '碎片管理', '', '?mod=phpcms&file=block&action=list', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (64, 4, '推荐位管理', '', '?mod=phpcms&file=position&action=list', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (99, 2, '常用操作', '', '', '', '_self', '', '', '', '', 1, 1, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (100, 2, '个人信息', '', '', '', '_self', '', '', '', '', 1, 1, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (101, 100, '修改资料', '', 'member/edit.php', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (102, 100, '修改密码', '', 'member/editpwd.php', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (103, 100, '短消息', '', 'message/', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (110, 99, '添加常用菜单', '', '?mod=phpcms&file=menu&action=add&parentid=99&parentname=常用操作', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (111, 99, '管理常用菜单', '', '?mod=phpcms&file=menu&action=manage&parentid=99&parentname=常用操作', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (112, 99, '后台首页', '', '?mod=phpcms&file=index&action=main', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (113, 99, '更新首页', '', '?mod=phpcms&file=html&action=index', '', 'right', '', '', '', '', 0, 0, 0, 1, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (114, 99, '更新缓存', '', '?mod=phpcms&file=cache', '', 'right', '', '', '', '', 0, 0, 0, 1, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (115, 99, '添加栏目', '', '?mod=phpcms&file=category&action=add', '', 'right', '', '', '', '', 0, 0, 0, 1, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (116, 99, '管理栏目', '', '?mod=phpcms&file=category&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 1, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (117, 99, '管理会员', '', '?mod=member&file=member&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 1, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (118, 99, '添加管理员', '', '?mod=phpcms&file=admin&action=add', '', 'right', '', '', '', '', 0, 0, 0, 1, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (600, 99, '添加地区', '', '?mod=phpcms&file=area&action=add', '', 'right', '', '', '', '', 0, 0, 0, 1, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (601, 99, '管理内容模型', '', '?mod=phpcms&file=model&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 1, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (602, 99, '数据库备份', '', '?mod=phpcms&file=database&action=export', '', 'right', '', '', '', '', 0, 0, 0, 1, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (603, 99, '网站配置', '', '?mod=phpcms&file=setting&tab=0', '', 'right', '', '', '', '', 0, 0, 0, 1, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (120, 3, '栏目管理', '', '', '', '_self', '', '', '', '1,2', 1, 1, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (121, 120, '添加栏目', '', '?mod=phpcms&file=category&action=add', '', 'right', '', '', '', '1,2', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (122, 120, '管理栏目', '', '?mod=phpcms&file=category&action=manage', '', 'right', '', '', '', '1,2', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (123, 120, '合并栏目', '', '?mod=phpcms&file=category&action=join', '', 'right', '', '', '', '1,2', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (124, 120, '更新栏目缓存', '', '?mod=phpcms&file=category&action=updatecache', '', 'right', '', '', '', '1,2', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (125, 120, '修复栏目数据', '', '?mod=phpcms&file=category&action=repair', '', 'right', '', '', '', '1,2', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (126, 120, '批量添加栏目', '', '?mod=phpcms&file=category&action=more', '', 'right', '', '', '', '1,2', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (130, 3, '模型管理', '', '', '', '_self', '', '', '', '1', 1, 1, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (131, 130, '添加模型', '', '?mod=phpcms&file=model&action=add', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (132, 130, '管理模型', '', '?mod=phpcms&file=model&action=manage', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (133, 130, '导入模型', '', '?mod=phpcms&file=model&action=import', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (140, 3, '模块管理', '', '', '', '_self', '', '', '', '1', 1, 1, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (141, 140, '安装模块', '', '?mod=phpcms&file=module&action=install', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (142, 140, '管理模块', '', '?mod=phpcms&file=module&action=manage', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (143, 140, '新建模块', '', '?mod=phpcms&file=module&action=add', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (150, 3, '管理员设置', '', '', '', '_self', '', '', '', '1', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (151, 150, '添加管理员', '', '?mod=phpcms&file=admin&action=add', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (152, 150, '管理员列表', '', '?mod=phpcms&file=admin&action=manage', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (153, 150, '添加角色', '', '?mod=phpcms&file=role&action=add', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (154, 150, '管理角色', '', '?mod=phpcms&file=role&action=manage', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (160, 3, '数据库管理', '', '', '', '_self', '', '', '', '1', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (161, 160, '数据库备份', '', '?mod=phpcms&file=database&action=export', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (162, 160, '数据库恢复', '', '?mod=phpcms&file=database&action=import', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (163, 160, '数据库修复', '', '?mod=phpcms&file=database&action=repair', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (164, 160, '字符串替换', '', '?mod=phpcms&file=database&action=replace', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (165, 160, '执行SQL', '', '?mod=phpcms&file=database&action=executesql', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (170, 3, '相关设置', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (171, 170, '类别管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (500, 171, '添加类别', '', '?mod=phpcms&file=type&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (501, 171, '管理类别', '', '?mod=phpcms&file=type&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (172, 170, '地区管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (505, 172, '添加地区', '', '?mod=phpcms&file=area&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (506, 172, '管理地区', '', '?mod=phpcms&file=area&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (507, 172, '更新地区缓存', '', '?mod=phpcms&file=area&action=updatecache', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (508, 172, '修复地区数据', '', '?mod=phpcms&file=area&action=repair', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (173, 170, '菜单管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (510, 173, '添加菜单', '', '?mod=phpcms&file=menu&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (511, 173, '管理菜单', '', '?mod=phpcms&file=menu', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (174, 170, '推荐位管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (515, 174, '添加推荐位', '', '?mod=phpcms&file=position&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (516, 174, '管理推荐位', '', '?mod=phpcms&file=position&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (175, 170, '关键词管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (520, 175, '添加关键词', '', '?mod=phpcms&file=keyword&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (521, 175, '管理关键词', '', '?mod=phpcms&file=keyword&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (176, 170, '作者管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (525, 176, '添加作者', '', '?mod=phpcms&file=author&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (526, 176, '管理作者', '', '?mod=phpcms&file=author&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (177, 170, '来源管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (530, 177, '添加来源', '', '?mod=phpcms&file=copyfrom&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (531, 177, '管理来源', '', '?mod=phpcms&file=copyfrom&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (178, 170, '关联链接管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (535, 178, '添加关联链接', '', '?mod=phpcms&file=keylink&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (536, 178, '管理关联链接', '', '?mod=phpcms&file=keylink&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (180, 170, '工作流管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (540, 180, '添加工作流方案', '', '?mod=phpcms&file=workflow&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (541, 180, '管理工作流方案', '', '?mod=phpcms&file=workflow', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (181, 170, '稿件状态管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (545, 181, '添加状态', '', '?mod=phpcms&file=status&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (546, 181, '管理状态', '', '?mod=phpcms&file=status', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (200, 170, '数据源管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (201, 200, '添加数据源', '', '?mod=phpcms&file=datasource&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (202, 200, '管理数据源', '', '?mod=phpcms&file=datasource&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (205, 170, 'URL规则管理', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (206, 205, '添加URL规则', '', '?mod=phpcms&file=urlrule&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (207, 205, '管理URL规则', '', '?mod=phpcms&file=urlrule&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (210, 3, '系统工具', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (211, 210, '木马扫描', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (212, 211, '扫描木马', '', '?mod=phpcms&file=safe', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (213, 211, '文件安全校验', '', '?mod=phpcms&file=filecheck', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (214, 211, '创建文件校验镜像', '', '?mod=phpcms&file=filecheck&action=make', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (215, 210, '外部数据导入', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (216, 215, '添加数据导入规则', '', '?mod=phpcms&file=import&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (217, 215, '资讯数据导入', '', '?mod=phpcms&file=import&action=manage&type=content', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (218, 215, '会员数据导入', '', '?mod=phpcms&file=import&action=manage&type=member', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (219, 210, '更新缓存', '', '?mod=phpcms&file=cache', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (220, 210, 'Baibu/Google地图', '', '?mod=phpcms&file=googlemap', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (221, 210, '系统运行环境诊断', '', '?mod=phpcms&file=system', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (222, 210, 'IP 禁止', '', '?mod=phpcms&file=ipbanned', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (223, 210, '非法信息屏蔽日志', '', '?mod=phpcms&file=filterword', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (224, 210, '后台操作日志', '', '?mod=phpcms&file=log', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (225, 210, 'php 错误日志', '', '?mod=phpcms&file=errorlog', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (226, 210, '文件管理器', '', '?mod=phpcms&file=filemanager', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (227, 210, '网站地图', '', '?mod=phpcms&file=sitemap', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (230, 210, '数据字典', '', '?mod=phpcms&file=datadict', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (231, 210, '附件管理', '', '?mod=phpcms&file=attachment&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (250, 3, '网站配置', '', '', '', '_self', '', '', '', '1', 1, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (251, 250, '基本信息', '', '?mod=phpcms&file=setting&tab=0', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (252, 250, '网站设置', '', '?mod=phpcms&file=setting&tab=1', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (253, 250, '性能优化', '', '?mod=phpcms&file=setting&tab=2', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (254, 250, '安全设置', '', '?mod=phpcms&file=setting&tab=3', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (255, 250, '附件设置', '', '?mod=phpcms&file=setting&tab=4', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (256, 250, '邮件设置', '', '?mod=phpcms&file=setting&tab=5', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (257, 250, 'FTP设置', '', '?mod=phpcms&file=setting&tab=6', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (258, 250, '通行证', '', '?mod=phpcms&file=setting&tab=7', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (259, 250, '扩展设置', '', '?mod=phpcms&file=setting&tab=8', '', 'right', '', '', '', '1', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (300, 4, '内容发布管理', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, 'catid_0');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (310, 300, '网站介绍', '', '?mod=phpcms&file=content&action=manage&catid=1', '', 'right', '', '', '', '', 1, 0, 0, 0, 'catid_1');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (311, 310, '关于我们', '', '?mod=phpcms&file=content&action=manage&catid=2', '', 'right', '', '', '', '', 0, 0, 0, 0, 'catid_2');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (312, 310, '联系方式', '', '?mod=phpcms&file=content&action=manage&catid=3', '', 'right', '', '', '', '', 0, 0, 0, 0, 'catid_3');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (313, 310, '招聘信息', '', '?mod=phpcms&file=content&action=manage&catid=4', '', 'right', '', '', '', '', 0, 0, 0, 0, 'catid_4');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (314, 310, '版权声明', '', '?mod=phpcms&file=content&action=manage&catid=5', '', 'right', '', '', '', '', 0, 0, 0, 0, 'catid_5');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (319, 4, '生成HTML', '', '', '', '_self', '', '', '', '', 1, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (320, 319, '更新首页', '', '?mod=phpcms&file=html&action=index', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (321, 319, '更新栏目页', '', '?mod=phpcms&file=html&action=category', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (323, 319, '更新专题页', '', '?mod=special&file=html', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (324, 319, '更新内容页', '', '?mod=phpcms&file=html&action=show', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (325, 319, '更新URL', '', '?mod=phpcms&file=url', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (350, 7, '模板方案', '', '?mod=phpcms&file=templateproject&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (351, 7, '风格方案', '', '?mod=phpcms&file=skin&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (352, 7, '碎片管理', '', '?mod=phpcms&file=block', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (353, 7, '更新模板缓存', '', '?mod=phpcms&file=template&action=cache', '', 'right', '', '', '', '', 0, 0, 0, 0, '');

INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (360, 7, 'Phpcms', '', '', '', '_self', '', '', '', '', 1, 1, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (361, 360, '新建模板', '', '?mod=phpcms&file=template&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (362, 360, '管理模板', '', '?mod=phpcms&file=template&action=manage&module=phpcms', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (363, 360, '添加内容标签', '', '?mod=phpcms&file=tag&action=add&module=phpcms&type=content', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (364, 360, '管理内容标签', '', '?mod=phpcms&file=tag&action=manage&module=phpcms&type=content', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (365, 360, '添加栏目标签', '', '?mod=phpcms&file=tag&action=add&type=category', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
INSERT INTO `phpcms_menu` (`menuid`, `parentid`, `name`, `image`, `url`, `description`, `target`, `style`, `js`, `groupids`, `roleids`, `isfolder`, `isopen`, `listorder`, `userid`, `keyid`) VALUES (366, 360, '管理栏目标签', '', '?mod=phpcms&file=tag&action=manage&type=category', '', 'right', '', '', '', '', 0, 0, 0, 0, '');
DROP TABLE IF EXISTS `phpcms_model`;
CREATE TABLE `phpcms_model` (
  `modelid` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `tablename` varchar(20) NOT NULL,
  `itemname` varchar(10) NOT NULL,
  `itemunit` varchar(10) NOT NULL,
  `workflowid` tinyint(3) unsigned NOT NULL default '0',
  `template_category` varchar(30) NOT NULL,
  `template_list` varchar(30) NOT NULL,
  `template_show` varchar(30) NOT NULL,
  `template_print` varchar(30) NOT NULL,
  `ishtml` tinyint(1) unsigned NOT NULL default '0',
  `category_urlruleid` tinyint(1) unsigned NOT NULL default '0',
  `show_urlruleid` tinyint(1) unsigned NOT NULL default '0',
  `enablesearch` tinyint(1) unsigned NOT NULL default '1',
  `ischeck` tinyint(1) unsigned NOT NULL default '1',
  `isrelated` tinyint(1) unsigned NOT NULL default '1',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  `modeltype` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`modelid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_model` (`modelid`, `name`, `description`, `tablename`, `itemname`, `itemunit`, `workflowid`, `template_category`, `template_list`, `template_show`, `template_print`, `ishtml`, `category_urlruleid`, `show_urlruleid`,`enablesearch`, `ischeck`, `disabled`, `modeltype`) VALUES (1, '新闻', '', 'news', '新闻', '篇', 1, 'category', 'list', 'show', 'print', 1, 1, 7, 1, 1, 0, 0);
INSERT INTO `phpcms_model` (`modelid`, `name`, `description`, `tablename`, `itemname`, `itemunit`, `workflowid`, `template_category`, `template_list`, `template_show`, `template_print`, `ishtml`, `category_urlruleid`, `show_urlruleid`,`enablesearch`, `ischeck`, `disabled`, `modeltype`) VALUES (2, '图片', '', 'picture', '图片', '张', 1, 'category_picture', 'list_picture', 'show_picture', 'print', 1, 1, 7, 1, 1, 0, 0);
INSERT INTO `phpcms_model` (`modelid`, `name`, `description`, `tablename`, `itemname`, `itemunit`, `workflowid`, `template_category`, `template_list`, `template_show`, `template_print`, `ishtml`, `category_urlruleid`, `show_urlruleid`,`enablesearch`, `ischeck`, `disabled`, `modeltype`) VALUES (3, '下载', '', 'down', '下载', '条', 1, 'category_down', 'list_down', 'show_down', 'print', 1, 1, 7, 1, 1, 0, 0);
INSERT INTO `phpcms_model` (`modelid`, `name`, `description`, `tablename`, `itemname`, `itemunit`, `workflowid`, `template_category`, `template_list`, `template_show`, `template_print`, `ishtml`, `category_urlruleid`, `show_urlruleid`,`enablesearch`, `ischeck`, `disabled`, `modeltype`) VALUES (4, '信息', '', 'info', '信息', '条', 1, 'category_info', 'list_info', 'show_info', 'print', 1, 1, 7, 1, 0, 0, 0);
INSERT INTO `phpcms_model` (`modelid`, `name`, `description`, `tablename`, `itemname`, `itemunit`, `workflowid`, `template_category`, `template_list`, `template_show`, `template_print`, `ishtml`, `category_urlruleid`, `show_urlruleid`,`enablesearch`, `ischeck`, `disabled`, `modeltype`) VALUES (5, '产品', '', 'product', '产品', '件', 1, 'category_product', 'list_product', 'show_product', 'print', 1, 1, 7, 1, 1, 0, 0);
INSERT INTO `phpcms_model` (`modelid`, `name`, `description`, `tablename`, `itemname`, `itemunit`, `workflowid`, `template_category`, `template_list`, `template_show`, `template_print`, `ishtml`, `category_urlruleid`, `show_urlruleid`,`enablesearch`, `ischeck`, `disabled`, `modeltype`) VALUES (10, '普通会员', '', 'detail', '', '', 0, '', '', '', '', 0, 0, 0, 1, 0, 0, 2);

DROP TABLE IF EXISTS `phpcms_model_field`;
CREATE TABLE `phpcms_model_field` (
  `fieldid` mediumint(8) unsigned NOT NULL auto_increment,
  `modelid` tinyint(3) unsigned NOT NULL default '0',
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
  `unsetroleids` varchar(255) NOT NULL,
  `iscore` tinyint(1) unsigned NOT NULL default '0',
  `issystem` tinyint(1) unsigned NOT NULL default '0',
  `isunique` tinyint(1) unsigned NOT NULL default '0',
  `issearch` tinyint(1) unsigned NOT NULL default '0',
  `isselect` tinyint(1) unsigned NOT NULL default '0',
  `iswhere` tinyint(1) unsigned NOT NULL default '0',
  `isorder` tinyint(1) unsigned NOT NULL default '0',
  `islist` tinyint(1) unsigned NOT NULL default '0',
  `isshow` tinyint(1) unsigned NOT NULL default '0',
  `isadd` tinyint(1) unsigned NOT NULL default '1',
  `isfulltext` tinyint(1) unsigned NOT NULL default '1',
  `listorder` mediumint(8) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`fieldid`),
  KEY `modelid` (`modelid`,`disabled`),
  KEY `field` (`field`,`modelid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(1, 1, 'contentid', 'ID', '', '', 0, 0, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(2, 1, 'catid', '栏目', '', '', 1, 6, '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 1, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(3, 1, 'typeid', '类别', '', '', 0, 0, '', '', 'typeid', 'array (\n  ''minnumber'' => '''',\n  ''maxnumber'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 2, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(4, 1, 'areaid', '地区', '', '', 0, 0, '', '', 'areaid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 3, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(5, 1, 'title', '标题', '', 'inputtitle', 1, 80, '', '', 'title', 'array (\n  ''size'' => ''80'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 4, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(6, 1, 'titleintact', '完整标题', '', '', 0, 200, '', '', 'text', 'array (\n  ''size'' => ''80'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 4, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(7, 1, 'style', '颜色和字型', '', '', 0, 0, '', '', 'style', '', '', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 5, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(8, 1, 'thumb', '缩略图', '', '', 0, 100, '', '', 'image', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''upload_maxsize'' => ''1024'',\n  ''upload_allowext'' => ''jpg|jpeg|gif|png|bmp'',\n  ''isselectimage'' => ''1'',\n  ''isthumb'' => ''1'',\n  ''thumb_width'' => ''300'',\n  ''thumb_height'' => ''300'',\n  ''iswatermark'' => ''1'',\n  ''watermark_img'' => ''images/watermark.gif'',\n)', '', '', '', 0, 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 6, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(9, 1, 'keywords', '关键词', '多关键词之间用空格隔开', '', 0, 40, '', '', 'keyword', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 1, 0, 0, 1, 1, 1, 7, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(10, 1, 'author', '作者', '', '', 0, 30, '', '', 'author', 'array (\n  ''size'' => ''30'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 8, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(11, 1, 'copyfrom', '来源', '', '', 0, 0, '', '', 'copyfrom', 'array (\n  ''size'' => ''30'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 9, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(12, 1, 'description', '摘要', '', '', 0, 255, '', '', 'textarea', 'array (\n  ''rows'' => ''4'',\n  ''cols'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''enablekeylink'' => ''0'',\n  ''replacenum'' => '''',\n)', 'style="width:100%"', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 10, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(13, 1, 'userid', '发布人', '', '', 0, 0, '', '', 'userid', '', '', '', '', 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 11, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(14, 1, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 12, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(15, 1, 'content', '内容', '', '', 1, 999999, '', '', 'editor', 'array (\n  ''toolbar'' => ''standard'',\n  ''width'' => ''100%'',\n  ''height'' => ''350'',\n  ''defaultvalue'' => '''',\n  ''storage'' => ''database'',\n  ''enablekeylink'' => ''1'',\n  ''replacenum'' => ''2'',\n  ''enablesaveimage'' => ''1'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 13, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(16, 1, 'islink', '转向链接', '', '', 0, 0, '', '', 'islink', '', '', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 14, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(17, 1, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 15, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(18, 1, 'posids', '推荐位', '全选<input boxid=''posids'' type=''checkbox'' onclick="checkall(''posids'')" >', '', 0, 0, '', '', 'posid', 'array (\n  ''cols'' => ''4'',\n  ''width'' => ''125'',\n)', '', '', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 16, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(19, 1, 'groupids_view', '阅读权限', '全选<input boxid=''groupids_view'' type=''checkbox'' onclick="checkall(''groupids_view'')" >', '', 0, 0, '', '', 'groupid', 'array (\n  ''priv'' => ''view'',\n  ''cols'' => ''4'',\n  ''width'' => ''125'',\n)', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 17, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(20, 1, 'readpoint', '阅读所需点数', '', '', 0, 5, '', '', 'number', 'array (\n  ''minnumber'' => ''1'',\n  ''maxnumber'' => ''99999'',\n  ''decimaldigits'' => ''0'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 18, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(21, 1, 'prefix', 'html文件名', '', '', 0, 20, '', '', 'text', 'array (\n  ''size'' => ''20'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 19, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(22, 1, 'url', 'URL', '', '', 0, 100, '', '', 'text', '', '', '', '', 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 0, 96, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(23, 1, 'listorder', '排序', '', '', 0, 6, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0, 97, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(24, 1, 'status', '状态', '', '', 0, 2, '', '', 'box', '', '', '', '', 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 98, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(25, 1, 'template', '内容页模板', '', '', 0, 30, '', '', 'template', 'array (\n  ''size'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 99, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(50, 2, 'contentid', 'ID', '', '', 0, 0, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(51, 2, 'catid', '栏目', '', '', 1, 6, '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 1, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(52, 2, 'typeid', '类别', '', '', 0, 0, '', '', 'typeid', 'array (\n  ''minnumber'' => '''',\n  ''maxnumber'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 2, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(53, 2, 'areaid', '地区', '', '', 0, 0, '', '', 'areaid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 3, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(54, 2, 'title', '标题', '', 'inputtitle', 1, 80, '', '', 'title', 'array (\n  ''size'' => ''80'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 4, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(55, 2, 'style', '颜色和字型', '', '', 0, 0, '', '', 'style', '', '', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 5, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(56, 2, 'thumb', '缩略图', '', '', 0, 100, '', '', 'image', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''upload_maxsize'' => ''1024'',\n  ''upload_allowext'' => ''jpg|jpeg|gif|png|bmp'',\n  ''isselectimage'' => ''1'',\n  ''isthumb'' => ''1'',\n  ''thumb_width'' => ''300'',\n  ''thumb_height'' => ''300'',\n  ''iswatermark'' => ''0'',\n  ''watermark_img'' => ''images/watermark.gif'',\n)', '', '', '', 0, 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 6, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(57, 2, 'keywords', '关键词', '多个关键词之间用空格隔开', '', 0, 40, '', '', 'keyword', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, 7, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(58, 2, 'author', '作者', '', '', 0, 30, '', '', 'author', 'array (\n  ''size'' => ''30'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 8, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(59, 2, 'copyfrom', '来源', '', '', 0, 100, '', '', 'copyfrom', 'array (\n  ''size'' => ''30'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 9, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(60, 2, 'description', '摘要', '', '', 0, 255, '', '', 'textarea', 'array (\n  ''rows'' => ''6'',\n  ''cols'' => ''90'',\n  ''defaultvalue'' => '''',\n  ''enablekeylink'' => ''0'',\n  ''replacenum'' => '''',\n)', 'style="width:100%"', '-99', '-99', 0, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 10, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(61, 2, 'userid', '发布人', '', '', 0, 0, '', '', 'userid', '', '', '', '', 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 11, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(62, 2, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 12, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(63, 2, 'content', '描述', '', '', 1, 999999, '', '', 'editor', 'array (\n  ''toolbar'' => ''basic'',\n  ''width'' => ''90%'',\n  ''height'' => ''300'',\n  ''defaultvalue'' => '''',\n  ''storage'' => ''database'',\n  ''enablekeylink'' => ''0'',\n  ''replacenum'' => '''',\n  ''enablesaveimage'' => ''1'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, 1, 13, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(64, 2, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 14, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(65, 2, 'islink', '转向链接', '', '', 0, 0, '', '', 'islink', '', '', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 15, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(66, 2, 'posids', '推荐位', '全选<input boxid=''posids'' type=''checkbox'' onclick="checkall(''posids'')" >', '', 0, 0, '', '', 'posid', 'array (\n  ''cols'' => ''4'',\n  ''width'' => ''125'',\n)', '', '', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 16, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(67, 2, 'pictureurls', '组图', '', '', 0, 255, '', '', 'images', 'array (\n  ''upload_maxsize'' => ''1024'',\n  ''upload_allowext'' => ''gif|jpg|jpeg|png|bmp'',\n  ''isthumb'' => ''1'',\n  ''thumb_width'' => ''150'',\n  ''thumb_height'' => ''150'',\n  ''iswatermark'' => ''1'',\n  ''ishtml'' => ''1'',\n  ''watermark_img'' => ''images/watermark.gif'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 17, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(68, 2, 'prefix', 'html文件名', '', '', 0, 20, '', '', 'text', 'array (\n  ''size'' => ''20'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 18, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(69, 2, 'url', 'URL', '', '', 0, 100, '', '', 'text', '', '', '', '', 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 0, 96, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(70, 2, 'listorder', '排序', '', '', 0, 6, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0, 97, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(71, 2, 'status', '状态', '', '', 0, 2, '', '', 'box', '', '', '', '', 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 98, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(72, 2, 'template', '内容页模板', '', '', 0, 30, '', '', 'template', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 99, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(89, 3, 'contentid', 'ID', '', '', 0, 0, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(90, 3, 'catid', '栏目', '', '', 1, 6, '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'array (\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 1, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(91, 3, 'typeid', '类别', '', '', 0, 0, '', '', 'typeid', 'array (\n  ''minnumber'' => '''',\n  ''maxnumber'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 2, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(92, 3, 'areaid', '地区', '', '', 0, 0, '', '', 'areaid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 3, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(93, 3, 'title', '标题', '', 'inputtitle', 1, 80, '', '', 'title', 'array (\n  ''size'' => ''80'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 4, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(94, 3, 'style', '颜色和字型', '', '', 0, 0, '', '', 'style', '', '', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 5, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(95, 3, 'thumb', '缩略图', '', '', 0, 100, '', '', 'image', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''upload_maxsize'' => ''1024'',\n  ''upload_allowext'' => ''jpg|jpeg|gif|png|bmp'',\n  ''isselectimage'' => ''1'',\n  ''isthumb'' => ''1'',\n  ''thumb_width'' => ''300'',\n  ''thumb_height'' => ''300'',\n  ''iswatermark'' => ''1'',\n  ''watermark_img'' => ''images/watermark.gif'',\n)', '', '', '', 0, 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 6, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(96, 3, 'keywords', '关键词', '多个关键词之间用空格隔开', '', 0, 40, '', '', 'keyword', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 0, 1, 1, 1, 7, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(97, 3, 'description', '摘要', '', '', 0, 255, '', '', 'textarea', 'array (\n  ''rows'' => ''4'',\n  ''cols'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''enablehtml'' => ''0'',\n  ''enablekeylink'' => ''0'',\n  ''enablefilterword'' => ''0'',\n)', 'style="width:100%"', '', '', 0, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 8, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(98, 3, 'userid', '发布人', '', '', 0, 0, '', '', 'userid', '', '', '', '', 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 9, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(99, 3, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 10, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(100, 3, 'content', '描述', '', '', 1, 999999, '', '', 'editor', 'array (\n  ''toolbar'' => ''basic'',\n  ''width'' => ''100%'',\n  ''height'' => ''300'',\n  ''defaultvalue'' => '''',\n  ''storage'' => ''database'',\n  ''enablekeylink'' => ''0'',\n  ''replacenum'' => '''',\n  ''enablesaveimage'' => ''1'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 11, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(101, 3, 'downurl', '下载地址', '', '', 4, 255, '', '', 'downfile', 'array (\n  ''mode'' => ''1'',\n  ''servers'' => ''电信下载|http://tel.xxx.com/\r\n网通下载|http://cnc.xxx.com/'',\n  ''size'' => ''60'',\n  ''downloadtype'' => ''1'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 20, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(102, 3, 'downurls', '下载列表', '名称|下载地址', '', 6, 0, '', '', 'downfiles', 'array (\n  ''size'' => ''30'',\n  ''downloadtype'' => ''1'',\n)', 'style="width:100%"', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 20, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(103, 3, 'filesize', '文件大小', '', '', 0, 20, '', '', 'text', 'array (\n  ''size'' => ''10'',\n  ''defaultvalue'' => ''未知'',\n  ''ispassword'' => ''0'',\n)', 'onfocus="if(this.value==''未知'') this.value='''';" onblur="if(this.value=='''') this.value=''未知'';"', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 21, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(104, 3, 'version', '版本号', '', '', 0, 20, '', '', 'text', 'array (\n  ''size'' => ''10'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 22, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(105, 3, 'classtype', '软件类型', '', '', 0, 20, '', '', 'box', 'array (\n  ''options'' => ''国产软件|国产软件\r\n国外软件|国外软件\r\n汉化补丁|汉化补丁\r\n程序源码|程序源码\r\n其他|其他'',\n  ''boxtype'' => ''select'',\n  ''fieldtype'' => ''CHAR'',\n  ''cols'' => ''5'',\n  ''width'' => ''80'',\n  ''size'' => ''1'',\n  ''defaultvalue'' => ''国产软件'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 23, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(106, 3, 'language', '软件语言', '', '', 0, 20, '', '', 'box', 'array (\n  ''options'' => ''英文|英文\r\n简体中文|简体中文\r\n繁体中文|繁体中文\r\n简繁中文|简繁中文\r\n多国语言|多国语言\r\n其他语言|其他语言'',\n  ''boxtype'' => ''select'',\n  ''fieldtype'' => ''CHAR'',\n  ''cols'' => ''5'',\n  ''width'' => ''80'',\n  ''size'' => ''1'',\n  ''defaultvalue'' => ''简体中文'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 24, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(107, 3, 'copytype', '软件授权形式', '', '', 0, 15, '', '', 'box', 'array (\n  ''options'' => ''免费版|免费版\r\n共享版|共享版\r\n试用版|试用版\r\n演示版|演示版\r\n注册版|注册版\r\n破解版|破解版\r\n零售版|零售版\r\nOEM版|OEM版'',\n  ''boxtype'' => ''select'',\n  ''fieldtype'' => ''CHAR'',\n  ''cols'' => ''5'',\n  ''width'' => ''80'',\n  ''size'' => ''1'',\n  ''defaultvalue'' => ''免费版'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 25, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(108, 3, 'systems', '软件平台', '<select name=''selectSystem'' onchange="ChangeInput(this,document.myform.systems,''/'')">\r\n	<option value=''WinXP''>WinXP</option>\r\n	<option value=''Vista''>Vista</option>\r\n	<option value=''Win2000''>Win2000</option>\r\n	<option value=''Win2003''>Win2003</option>\r\n	<option value=''Unix''>Unix</option>\r\n	<option value=''Linux''>Linux</option>\r\n	<option value=''MacOS''>MacOS</option>\r\n</select>', '', 0, 100, '', '', 'text', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => ''Win2000/WinXP/Win2003'',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 26, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(109, 3, 'stars', '评分等级', '', '', 0, 20, '', '', 'box', 'array (\n  ''options'' => ''★☆☆☆☆|★☆☆☆☆\r\n★★☆☆☆|★★☆☆☆\r\n★★★☆☆|★★★☆☆\r\n★★★★☆|★★★★☆\r\n★★★★★|★★★★★'',\n  ''boxtype'' => ''radio'',\n  ''fieldtype'' => ''CHAR'',\n  ''cols'' => ''5'',\n  ''width'' => ''100'',\n  ''size'' => ''1'',\n  ''defaultvalue'' => ''★★★☆☆'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 27, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(110, 3, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 30, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(111, 3, 'islink', '转向链接', '', '', 0, 0, '', '', 'islink', '', '', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 31, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(112, 3, 'posids', '推荐位', '全选<input boxid=''posids'' type=''checkbox'' onclick="checkall(''posids'')" >', '', 0, 0, '', '', 'posid', 'array (\n  ''cols'' => ''4'',\n  ''width'' => ''125'',\n)', '', '', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 32, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(113, 3, 'groupids_view', '下载权限', '全选<input boxid=''groupids_view'' type=''checkbox'' onclick="checkall(''groupids_view'')" >', '', 0, 0, '', '', 'groupid', 'array (\n  ''priv'' => ''view'',\n  ''cols'' => ''4'',\n  ''width'' => ''125'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 33, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(114, 3, 'readpoint', '阅读所需点数', '', '', 0, 5, '', '', 'number', 'array (\n  ''minnumber'' => ''0'',\n  ''maxnumber'' => ''99999'',\n  ''decimaldigits'' => ''0'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 34, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(115, 3, 'prefix', 'html文件名', '', '', 0, 20, '', '', 'text', 'array (\n  ''size'' => ''20'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 35, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(116, 3, 'url', 'URL', '', '', 0, 100, '', '', 'text', '', '', '', '', 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 0, 96, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(117, 3, 'listorder', '排序', '', '', 0, 6, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0, 97, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(118, 3, 'status', '状态', '', '', 0, 2, '', '', 'box', '', '', '', '', 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 98, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(166, 4, 'contentid', 'ID', '', '', 0, 0, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(167, 4, 'catid', '栏目', '', '', 1, 6, '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'array (\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 1, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(168, 4, 'typeid', '类别', '', '', 0, 0, '', '', 'typeid', 'array (\n  ''minnumber'' => '''',\n  ''maxnumber'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 2, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(169, 4, 'areaid', '地区', '', '', 0, 0, '', '', 'areaid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 3, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(170, 4, 'title', '标题', '', 'inputtitle', 1, 80, '', '', 'title', 'array (\n  ''size'' => ''80'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 4, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(171, 4, 'style', '颜色和字型', '', '', 0, 0, '', '', 'style', '', '', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 5, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(172, 4, 'thumb', '缩略图', '', '', 0, 100, '', '', 'image', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''upload_maxsize'' => ''1024'',\n  ''upload_allowext'' => ''jpg|jpeg|gif|png|bmp'',\n  ''isselectimage'' => ''1'',\n  ''isthumb'' => ''1'',\n  ''thumb_width'' => ''300'',\n  ''thumb_height'' => ''300'',\n  ''iswatermark'' => ''1'',\n  ''watermark_img'' => ''images/watermark.gif'',\n)', '', '', '', 0, 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 6, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(173, 4, 'keywords', '关键词', '多个关键词之间用空格隔开', '', 0, 40, '', '', 'keyword', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 0, 1, 1, 1, 7, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(174, 4, 'description', '摘要', '', '', 0, 255, '', '', 'textarea', 'array (\n  ''rows'' => ''4'',\n  ''cols'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''enablehtml'' => ''0'',\n  ''enablekeylink'' => ''0'',\n  ''enablefilterword'' => ''0'',\n)', 'style="width:100%"', '', '', 0, 1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 8, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(178, 4, 'userid', '发布人', '', '', 0, 0, '', '', 'userid', '', '', '', '', 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 9, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(179, 4, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 10, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(180, 4, 'content', '描述', '', '', 1, 999999, '', '', 'editor', 'array (\n  ''toolbar'' => ''basic'',\n  ''width'' => ''100%'',\n  ''height'' => ''350'',\n  ''defaultvalue'' => '''',\n  ''storage'' => ''database'',\n  ''enablekeylink'' => ''0'',\n  ''replacenum'' => '''',\n  ''enablesaveimage'' => ''1'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 11, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(181, 4, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 12, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(182, 4, 'endtime', '截止日期', '', '', 0, 0, '', '', 'datetime', 'array (\n  ''dateformat'' => ''date'',\n  ''format'' => ''Y-m-d H:i:s'',\n  ''defaulttype'' => ''0'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 13, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(183, 4, 'telephone', '联系电话', '', '', 0, 20, '/^[0-9-]{6,20}$/', '请填写正确的电话号码', 'text', 'array (\n  ''size'' => ''20'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 0, 14, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(184, 4, 'email', 'E-mail', '', '', 6, 40, '/^[\\w\\-\\.]+@[\\w\\-\\.]+(\\.\\w+)+$/', '请填写正确的E-mail', 'text', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 0, 15, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(185, 4, 'address', '地址', '', '', 0, 0, '', '', 'text', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 0, 16, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(186, 4, 'islink', '转向链接', '', '', 0, 0, '', '', 'islink', '', '', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 19, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(187, 4, 'posids', '推荐位', '全选<input boxid=''posids'' type=''checkbox'' onclick="checkall(''posids'')" >', '', 0, 0, '', '', 'posid', 'array (\n  ''cols'' => ''4'',\n  ''width'' => ''125'',\n)', '', '', '', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 20, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(188, 4, 'groupids_view', '阅读权限', '全选<input boxid=''groupids_view'' type=''checkbox'' onclick="checkall(''groupids_view'')" >', '', 0, 0, '', '', 'groupid', 'array (\n  ''priv'' => ''view'',\n  ''cols'' => ''4'',\n  ''width'' => ''125'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 21, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(189, 4, 'readpoint', '阅读所需点数', '', '', 0, 5, '', '', 'number', 'array (\n  ''minnumber'' => ''0'',\n  ''maxnumber'' => ''99999'',\n  ''decimaldigits'' => ''0'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 22, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(190, 4, 'prefix', 'html文件名', '', '', 0, 20, '', '', 'text', 'array (\n  ''size'' => ''20'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 23, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(191, 4, 'url', 'URL', '', '', 0, 100, '', '', 'text', '', '', '', '', 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 0, 96, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(192, 4, 'listorder', '排序', '', '', 0, 6, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0, 97, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(193, 4, 'status', '状态', '', '', 0, 2, '', '', 'box', '', '', '', '', 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 98, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(194, 4, 'template', '内容页模板', '', '', 0, 30, '', '', 'template', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 99, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(210, 5, 'contentid', 'ID', '', '', 0, 0, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(211, 5, 'catid', '栏目', '', '', 1, 9999, '/^[0-9]+$/', '请选择所属栏目', 'catid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 1, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(212, 5, 'typeid', '类别', '', '', 0, 0, '', '', 'typeid', 'array (\n  ''minnumber'' => '''',\n  ''maxnumber'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 2, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(213, 5, 'areaid', '地区', '', '', 0, 0, '', '', 'areaid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0, 3, 1);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(214, 5, 'title', '产品名称', '', 'inputtitle', 1, 80, '', '', 'title', 'array (\n  ''size'' => ''80'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 4, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(215, 5, 'style', '颜色和字型', '', '', 0, 0, '', '', 'style', '', '', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 5, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(216, 5, 'thumb', '缩略图', '', '', 0, 100, '', '', 'image', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''upload_maxsize'' => ''1024'',\n  ''upload_allowext'' => ''jpg|jpeg|gif|png|bmp'',\n  ''isselectimage'' => ''1'',\n  ''isthumb'' => ''1'',\n  ''thumb_width'' => ''800'',\n  ''thumb_height'' => ''600'',\n  ''iswatermark'' => ''1'',\n  ''watermark_img'' => ''images/watermark.gif'',\n)', '', '-99', '-99', 0, 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 6, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(217, 5, 'keywords', '关键词', '多个关键词之间用空格隔开', '', 0, 40, '', '', 'keyword', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 0, 1, 1, 1, 7, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(218, 5, 'userid', '发布人', '', '', 0, 0, '', '', 'userid', '', '', '', '', 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 9, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(219, 5, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 10, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(220, 5, 'unit', '产品单位', '', '', 1, 4, '', '', 'box', 'array (\n  ''options'' => ''个|个\r\n件|件\r\n台|台\r\n条|条\r\n张|张\r\n本|本\r\n只|只\r\n箱|箱\r\n瓶|瓶\r\n吨|吨\r\nKg|Kg\r\nm|m'',\n  ''boxtype'' => ''select'',\n  ''fieldtype'' => ''CHAR'',\n  ''cols'' => '''',\n  ''width'' => '''',\n  ''size'' => '''',\n  ''defaultvalue'' => ''个'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 20, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(221, 5, 'price', '价格', '单位（元）', '', 0, 7, '/^[0-9\\.]+$/', '请输入正确的价格', 'number', 'array (\n  ''minnumber'' => ''0.01'',\n  ''maxnumber'' => ''9999999'',\n  ''decimaldigits'' => ''2'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 1, 1, 0, 1, 1, 1, 1, 0, 20, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(222, 5, 'size', '产品型号', '', '', 0, 50, '', '', 'text', 'array (\n  ''size'' => ''30'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 22, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(223, 5, 'stock', '库存', '', '', 0, 20, '', '', 'text', 'array (\n  ''size'' => ''10'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 23, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(224, 5, 'description', '产品描述', '', '', 0, 255, '', '', 'textarea', 'array (\n  ''rows'' => ''4'',\n  ''cols'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''enablekeylink'' => ''0'',\n  ''replacenum'' => '''',\n)', 'style="width:100%"', '-99', '-99', 0, 1, 0, 1, 1, 0, 0, 1, 1, 1, 1, 29, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(225, 5, 'content', '产品介绍', '', '', 1, 999999, '', '', 'editor', 'array (\n  ''toolbar'' => ''standard'',\n  ''width'' => ''100%'',\n  ''height'' => ''350'',\n  ''defaultvalue'' => '''',\n  ''storage'' => ''database'',\n  ''enablekeylink'' => ''0'',\n  ''replacenum'' => '''',\n  ''enablesaveimage'' => ''1'',\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 30, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(226, 5, 'pictureurls', '组图', '', '', 0, 255, '', '', 'images', 'array (\n  ''upload_maxsize'' => ''1024'',\n  ''upload_allowext'' => ''gif|jpg|jpeg|png|bmp'',\n  ''isthumb'' => ''0'',\n  ''thumb_width'' => ''150'',\n  ''thumb_height'' => ''150'',\n  ''iswatermark'' => ''1'',\n  ''ishtml'' => ''0'',\n  ''watermark_img'' => ''images/watermark.gif'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 31, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(227, 5, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 32, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(228, 5, 'islink', '转向链接', '', '', 0, 0, '', '', 'islink', '', '', '-99', '-99', 0, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 32, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(229, 5, 'stars', '推荐等级', '', '', 0, 20, '', '', 'box', 'array (\n  ''options'' => ''★☆☆☆☆|★☆☆☆☆\r\n★★☆☆☆|★★☆☆☆\r\n★★★☆☆|★★★☆☆\r\n★★★★☆|★★★★☆\r\n★★★★★|★★★★★'',\n  ''boxtype'' => ''radio'',\n  ''fieldtype'' => ''VARCHAR'',\n  ''cols'' => ''5'',\n  ''width'' => ''100'',\n  ''size'' => ''1'',\n  ''defaultvalue'' => ''★★★☆☆'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 33, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(230, 5, 'posids', '推荐位', '全选<input boxid=''posids'' type=''checkbox'' onclick="checkall(''posids'')" >', '', 0, 0, '', '', 'posid', 'array (\n  ''cols'' => ''4'',\n  ''width'' => ''125'',\n)', '', '-99', '-99', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 36, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(231, 5, 'prefix', 'html文件名', '', '', 0, 20, '', '', 'text', 'array (\n  ''size'' => ''20'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 37, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(232, 5, 'url', 'URL', '', '', 0, 100, '', '', 'text', '', '', '', '', 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 96, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(233, 5, 'listorder', '排序', '', '', 1, 1, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 0, 97, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(234, 5, 'status', '状态', '', '', 0, 2, '', '', 'box', '', '', '', '', 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 98, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES(235, 5, 'template', '内容页模板', '', '', 0, 255, '', '', 'template', 'array (\n  ''size'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 99, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES (500, 10, 'truename', '姓名', '', '', 0, 0, '', '', 'text', 'array (\n  ''size'' => ''12'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 1, 0, 0, 1, 0, 1, 0, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES (501, 10, 'gender', '性别', '', '', 0, 1, '', '', 'box', 'array (\n  ''options'' => ''男|0\r\n女|1'',\n  ''boxtype'' => ''radio'',\n  ''fieldtype'' => ''TINYINT'',\n  ''cols'' => ''5'',\n  ''width'' => ''80'',\n  ''size'' => ''1'',\n  ''defaultvalue'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 1, 1, 0, 1, 0, 1, 0, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES (502, 10, 'birthday', '生日', '', '', 0, 0, '', '', 'datetime', 'array (\n  ''dateformat'' => ''date'',\n  ''format'' => ''Y-m-d H:i:s'',\n  ''defaulttype'' => ''0'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 1, 1, 1, 0, 1, 0, 1, 1, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES (503, 10, 'mobile', '手机', '', '', 0, 0, '/^(13|15)[0-9]{9}$/', '手机号格式不对', 'text', 'array (\n  ''size'' => ''15'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 1, 0, 0, 1, 0, 1, 1, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES (504, 10, 'telephone', '电话', '', '', 0, 0, '/^[0-9-]{6,13}$/', '电话格式不对', 'text', 'array (\n  ''size'' => ''20'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 1, 0, 0, 1, 0, 1, 1, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES (505, 10, 'qq', 'QQ', '', '', 0, 0, '/^[0-9]{5,20}$/', 'QQ号格式不对', 'text', 'array (\n  ''size'' => ''20'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 1, 0, 0, 1, 0, 1, 1, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES (506, 10, 'msn', 'MSN', '', '', 0, 0, '/^[\\w\\-\\.]+@[\\w\\-\\.]+(\\.\\w+)+$/', 'MSN格式不对', 'text', 'array (\n  ''size'' => ''40'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 1, 0, 0, 1, 0, 1, 1, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES (507, 10, 'address', '地址', '', '', 0, 0, '', '', 'text', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1, 0, 0);
INSERT INTO `phpcms_model_field` (`fieldid`, `modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `isadd`, `isfulltext`, `listorder`, `disabled`) VALUES (508, 10, 'postcode', '邮编', '', '', 0, 0, '/^[0-9]{6}$/', '邮编格式不对', 'text', 'array (\n  ''size'' => ''6'',\n  ''defaultvalue'' => '''',\n  ''ispassword'' => ''0'',\n)', '', '-99', '-99', 0, 0, 0, 1, 1, 1, 0, 1, 0, 1, 1, 0, 0);

DROP TABLE IF EXISTS `phpcms_module`;
CREATE TABLE `phpcms_module` (
  `module` varchar(15) NOT NULL,
  `name` varchar(20) NOT NULL,
  `path` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `iscore` tinyint(1) unsigned NOT NULL default '0',
  `version` varchar(50) NOT NULL default '',
  `author` varchar(50) NOT NULL default '',
  `site` varchar(100) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `description` mediumtext NOT NULL,
  `license` mediumtext NOT NULL,
  `faq` mediumtext NOT NULL,
  `tagtypes` mediumtext NOT NULL,
  `setting` mediumtext NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  `publishdate` date NOT NULL default '0000-00-00',
  `installdate` date NOT NULL default '0000-00-00',
  `updatedate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`module`)
) TYPE=MyISAM;

INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('phpcms', 'Phpcms', '', '', 1, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', 'Phpcms Content Manage System', '', '', 'array (\r\n ''phpcms-content''=>''phpcms'',\r\n ''phpcms-category''=>''栏目标签'',\r\n)', 'array (\n  ''phpcmsusername'' => '''',\n  ''phpcmspassword'' => '''',\n  ''sitename'' => ''Phpcms'',\n  ''siteurl'' => '''',\n  ''ishtml'' => ''1'',\n  ''fileext'' => ''html'',\n  ''meta_title'' => ''中国领先的网站内容管理系统'',\n  ''meta_keywords'' => ''Phpcms 网站内容管理系统'',\n  ''meta_description'' => ''Phpcms 网站内容管理系统'',\n  ''copyright'' => ''<p>CopyRight 2006---2008&nbsp; <a href="http://www.phpcms.cn/">酷6网（北京）信息技术有限公司</a>版权所有</p>'',\n  ''icpno'' => ''京ICP证060955号'',\n  ''pageshtml'' => ''总数：<b>{$total}</b>\r\n<a href="{$firstpage}">首页</a><a href="{$prepage}">上一页</a><a href="{$nextpage}">下一页</a><a href="{$lastpage}">尾页</a>\r\n页次：<b><font color="red">{$page}</font>/{$pages}</b>\r\n<input type="text" name="page" id="page" size="2" onKeyDown="if(event.keyCode==13) {redirect(\\''{$urlpre}\\''+this.value); return false;}"> \r\n<input type="button" value="GO" class="gotopage" onclick="redirect(\\''{$urlpre}\\''+$(\\''#page\\'').val())">'',\n  ''segmentclass'' => ''segment'',\n  ''enablegetkeywords'' => ''1'',\n ''enable_urlencode'' => ''0'',\n ''areaid'' => ''1'',\n  ''editor_max_data_hour'' => ''4'',\n  ''editor_interval_data'' => ''30'',\n  ''maxpage'' => ''100'',\n  ''pagesize'' => ''20'',\n  ''autoupdatelist'' => ''5'',\n  ''search_time'' => ''10'',\n  ''search_maxresults'' => ''500'',\n  ''search_pagesize'' => ''10'',\n  ''category_count'' => ''1'',\n  ''show_hits'' => ''1'',\n  ''adminaccessip'' => '''',\n  ''maxloginfailedtimes'' => ''5'',\n  ''maxiplockedtime'' => ''1'',\n  ''enable_ipbanned'' => ''0'',\n  ''minrefreshtime'' => ''0'',\n  ''filter_word'' => '''',\n  ''thumb_enable'' => ''1'',\n  ''thumb_width'' => ''300'',\n  ''thumb_height'' => ''300'',\n  ''watermark_enable'' => ''1'',\n  ''watermark_minwidth'' => ''300'',\n  ''watermark_minheight'' => ''300'',\n  ''watermark_img'' => ''images/watermark.gif'',\n  ''watermark_pct'' => ''100'',\n  ''watermark_quality'' => ''80'',\n  ''watermark_pos'' => ''9'',\n  ''mail_type'' => ''1'',\n  ''mail_server'' => ''smtp.163.com'',\n  ''mail_port'' => ''25'',\n  ''mail_user'' => ''phpcms@163.com'',\n  ''mail_password'' => '''',\n  ''mail_sign'' => '''',\n  ''enablepassport'' => ''0'',\n  ''passport_file'' => ''discuz'',\n  ''passport_charset'' => ''gbk'',\n  ''passport_url'' => ''http://www.***.com/bbs/api/passport.php'',\n  ''passport_key'' => '''',\n  ''enableserverpassport'' => ''0'',\n  ''passport_serverurl'' => ''http://www.***.com/bbs/'',\n  ''passport_registerurl'' => ''register.php'',\n  ''passport_loginurl'' => ''login.php'',\n  ''passport_logouturl'' => ''login.php?action=quit'',\n  ''passport_getpasswordurl'' => ''sendpwd.php'',\n  ''passport_serverkey'' => '''',\n  ''passport_expire'' => '''',\n  ''uc'' => ''0'',\n  ''uc_api'' => ''http://uc.phpcms.cn/uc'',\n  ''uc_ip'' => '''',\n  ''uc_dbhost'' => ''localhost'',\n  ''uc_dbname'' => ''dbname'',\n  ''uc_dbuser'' => ''dbuser'',\n  ''uc_dbpwd'' => ''dbpw'',\n  ''uc_dbpre'' => ''uc_'',\n  ''uc_charset'' => ''gbk'',\n  ''uc_appid'' => ''3'',\n  ''uc_key'' => '''',\n  ''enabletm'' => ''0'',\n  ''qq'' => '''',\n  ''msn'' => '''',\n  ''skype'' => '''',\n  ''taobao'' => '''',\n  ''alibaba'' => '''',\n  ''version'' => ''2008'',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_position`;
CREATE TABLE IF NOT EXISTS `phpcms_position` (
  `posid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `listorder` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`posid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_position` (`posid`, `name`, `listorder`) VALUES (1, '首页推荐', 0);
INSERT INTO `phpcms_position` (`posid`, `name`, `listorder`) VALUES (2, '首页焦点', 0);
INSERT INTO `phpcms_position` (`posid`, `name`, `listorder`) VALUES (3, '首页头条', 0);
INSERT INTO `phpcms_position` (`posid`, `name`, `listorder`) VALUES (4, '列表页推荐', 0);
INSERT INTO `phpcms_position` (`posid`, `name`, `listorder`) VALUES (5, '内容页推荐', 0);

DROP TABLE IF EXISTS `phpcms_process`;
CREATE TABLE IF NOT EXISTS `phpcms_process` (
  `processid` smallint(5) unsigned NOT NULL auto_increment,
  `workflowid` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `passname` varchar(20) NOT NULL,
  `passstatus` tinyint(3) unsigned NOT NULL default '0',
  `rejectname` varchar(20) NOT NULL,
  `rejectstatus` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`processid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_process` (`processid`, `workflowid`, `name`, `description`, `passname`, `passstatus`, `rejectname`, `rejectstatus`) VALUES (1, 1, '审核', '', '批准', 99, '退稿', 1);
INSERT INTO `phpcms_process` (`processid`, `workflowid`, `name`, `description`, `passname`, `passstatus`, `rejectname`, `rejectstatus`) VALUES (2, 2, '一审', '', '批准', 4, '退稿', 1);
INSERT INTO `phpcms_process` (`processid`, `workflowid`, `name`, `description`, `passname`, `passstatus`, `rejectname`, `rejectstatus`) VALUES (3, 2, '终审', '', '批准', 99, '退稿', 7);
INSERT INTO `phpcms_process` (`processid`, `workflowid`, `name`, `description`, `passname`, `passstatus`, `rejectname`, `rejectstatus`) VALUES (4, 3, '一审', '', '批准', 4, '退稿', 1);
INSERT INTO `phpcms_process` (`processid`, `workflowid`, `name`, `description`, `passname`, `passstatus`, `rejectname`, `rejectstatus`) VALUES (5, 3, '二审', '', '批准', 6, '退稿', 5);
INSERT INTO `phpcms_process` (`processid`, `workflowid`, `name`, `description`, `passname`, `passstatus`, `rejectname`, `rejectstatus`) VALUES (6, 3, '终审', '', '批准', 99, '退稿', 7);

DROP TABLE IF EXISTS `phpcms_process_status`;
CREATE TABLE IF NOT EXISTS `phpcms_process_status` (
  `processid` smallint(5) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  KEY `processid` (`processid`),
  KEY `status` (`status`)
) TYPE=MyISAM;

INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (1, 1);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (1, 3);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (1, 99);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (2, 1);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (2, 3);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (2, 4);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (2, 7);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (3, 4);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (3, 7);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (3, 99);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (4, 1);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (4, 3);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (4, 4);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (4, 5);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (5, 4);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (5, 5);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (5, 6);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (5, 7);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (6, 6);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (6, 7);
INSERT INTO `phpcms_process_status` (`processid`, `status`) VALUES (6, 99);

DROP TABLE IF EXISTS `phpcms_role`;
CREATE TABLE `phpcms_role` (
  `roleid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `ipaccess` text NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`roleid`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM;

INSERT INTO `phpcms_role` (`roleid`, `name`, `description`, `ipaccess`, `listorder`, `disabled`) VALUES (1, '超级管理员', '超级管理员', '', 0, 0);
INSERT INTO `phpcms_role` (`roleid`, `name`, `description`, `ipaccess`, `listorder`, `disabled`) VALUES (2, '总编', '拥有所有栏目和所有专题的所有权限，并且可以添加栏目和专题', '', 0, 0);
INSERT INTO `phpcms_role` (`roleid`, `name`, `description`, `ipaccess`, `listorder`, `disabled`) VALUES (3, '栏目编辑', '拥有某些栏目的信息录入、审核及管理权限，需要进一步详细设置。', '', 0, 0);
INSERT INTO `phpcms_role` (`roleid`, `name`, `description`, `ipaccess`, `listorder`, `disabled`) VALUES (4, '设计师', '拥有模板与标签管理权限', '', 0, 0);
INSERT INTO `phpcms_role` (`roleid`, `name`, `description`, `ipaccess`, `listorder`, `disabled`) VALUES (5, '财务人员', '拥有订单查看、录入银行汇款、开发票等权限。', '', 0, 0);

DROP TABLE IF EXISTS `phpcms_session`;
CREATE TABLE `phpcms_session` (
  `sessionid` char(32) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `ip` char(15) NOT NULL,
  `lastvisit` int(10) unsigned NOT NULL default '0',
  `groupid` tinyint(3) unsigned NOT NULL default '0',
  `module` char(15) NOT NULL,
  `catid` smallint(5) unsigned NOT NULL default '0',
  `contentid` mediumint(8) unsigned NOT NULL default '0',
  `data` char(255) NOT NULL,
  PRIMARY KEY  (`sessionid`),
  KEY `lastvisit` (`lastvisit`)
) TYPE=MEMORY;

DROP TABLE IF EXISTS `phpcms_status`;
CREATE TABLE `phpcms_status` (
  `status` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `issystem` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`status`)
) TYPE=MyISAM;

INSERT INTO `phpcms_status` (`status`, `name`, `description`, `issystem`) VALUES (0, '删除', '已被删除至回收站', 1);
INSERT INTO `phpcms_status` (`status`, `name`, `description`, `issystem`) VALUES (1, '退稿', '稿件被退回', 1);
INSERT INTO `phpcms_status` (`status`, `name`, `description`, `issystem`) VALUES (2, '草稿', '草稿', 1);
INSERT INTO `phpcms_status` (`status`, `name`, `description`, `issystem`) VALUES (3, '待审', '等待审核', 1);
INSERT INTO `phpcms_status` (`status`, `name`, `description`, `issystem`) VALUES (99, '终审通过', '已经通过终审', 1);
INSERT INTO `phpcms_status` (`status`, `name`, `description`, `issystem`) VALUES (4, '一审通过', '一审通过', 0);
INSERT INTO `phpcms_status` (`status`, `name`, `description`, `issystem`) VALUES (5, '二审退稿', '二审退稿', 0);
INSERT INTO `phpcms_status` (`status`, `name`, `description`, `issystem`) VALUES (6, '二审通过', '二审通过', 0);
INSERT INTO `phpcms_status` (`status`, `name`, `description`, `issystem`) VALUES (7, '终审退稿', '终审退稿', 0);

DROP TABLE IF EXISTS `phpcms_type`;
CREATE TABLE IF NOT EXISTS `phpcms_type` (
  `typeid` smallint(5) unsigned NOT NULL auto_increment,
  `module` char(15) NOT NULL default 'phpcms',
  `name` char(30) NOT NULL,
  `style` char(5) NOT NULL,
  `typedir` char(20) NOT NULL,
  `description` char(255) NOT NULL,
  `thumb` char(100) NOT NULL,
  `url` char(100) NOT NULL,
  `template` char(50) NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`typeid`),
  KEY `module` (`module`,`listorder`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_times`;
CREATE TABLE `phpcms_times` (
  `action` char(10) NOT NULL,
  `ip` char(15) NOT NULL,
  `time` int(10) unsigned NOT NULL default '0',
  `times` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`action`,`ip`)
) TYPE=MEMORY;

DROP TABLE IF EXISTS `phpcms_urlrule`;
CREATE TABLE `phpcms_urlrule` (
  `urlruleid` smallint(5) unsigned NOT NULL auto_increment,
  `module` varchar(15) NOT NULL,
  `file` varchar(20) NOT NULL,
  `ishtml` tinyint(1) unsigned NOT NULL default '0',
  `urlrule` varchar(255) NOT NULL,
  `example` varchar(255) NOT NULL,
  PRIMARY KEY  (`urlruleid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (1, 'phpcms', 'category', 1, '{$categorydir}/index.{$fileext}|{$categorydir}/{$page}.{$fileext}', 'it/product/2.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (2, 'phpcms', 'category', 1, 'category/{$catid}.{$fileext}|category/{$catid}_{$page}.{$fileext}', 'category/2_1.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (3, 'phpcms', 'category', 1, '{$catdir}/index.{$fileext}|{$catdir}/{$page}.{$fileext}', 'news/2_1.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (4, 'phpcms', 'category', 0, 'list.php?catid={$catid}|list.php?catid={$catid}&page={$page}', 'list.php?catid=1&page=2');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (5, 'phpcms', 'category', 0, 'list.php?catid-{$catid}.html|list.php?catid-{$catid}/page-{$page}.html', 'list.php?catid-1/page-2.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (6, 'phpcms', 'category', 0, 'list-{$catid}-{$page}.html', 'list-1-2.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (7, 'phpcms', 'show', 1, '{$year}/{$month}{$day}/{$contentid}.{$fileext}|{$year}/{$month}{$day}/{$contentid}_{$page}.{$fileext}', '2006/1010/1_2.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (8, 'phpcms', 'show', 1, '{$categorydir}/{$year}/{$month}{$day}/{$contentid}.{$fileext}|{$categorydir}/{$year}/{$month}{$day}/{$contentid}_{$page}.{$fileext}', 'it/product/2006/1010/1_2.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (9, 'phpcms', 'show', 1, 'show/{$contentid}.{$fileext}|show/{$contentid}_{$page}.{$fileext}', 'show/1_2.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (10, 'phpcms', 'show', 0, 'show.php?contentid={$contentid}|show.php?contentid={$contentid}&page={$page}', 'show.php?contentid=1&page=2');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (11, 'phpcms', 'show', 0, 'show.php?contentid-{$contentid}.html|show.php?contentid-{$contentid}/page-{$page}.html', 'show.php?contentid-1/page-2.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES (12, 'phpcms', 'show', 0, 'show-{$contentid}-1.html|show-{$contentid}-{$page}.html', 'show-1-2.html');

DROP TABLE IF EXISTS `phpcms_workflow`;
CREATE TABLE `phpcms_workflow` (
  `workflowid` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`workflowid`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM;

INSERT INTO `phpcms_workflow` (`workflowid`, `name`, `description`) VALUES (1, '一级审核', '一级审核方案，需要经过1次审核才能正式发布');
INSERT INTO `phpcms_workflow` (`workflowid`, `name`, `description`) VALUES (2, '二级审核', '二级审核方案，需要经过2次审核才能正式发布');
INSERT INTO `phpcms_workflow` (`workflowid`, `name`, `description`) VALUES (3, '三级审核', '三级审核方案，需要经过3次审核才能正式发布');

DROP TABLE IF EXISTS `phpcms_editor_data`;
CREATE TABLE `phpcms_editor_data` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `editorid` char(15) NOT NULL,
  `ip` char(15) NOT NULL,
  `created_time` int(10) unsigned NOT NULL default '0',
  `data` mediumtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`,`editorid`,`created_time`,`id`)
) TYPE=MyISAM;