CREATE TABLE IF NOT EXISTS `phpcms_area` (
  `areaid` smallint(6) unsigned NOT NULL auto_increment,
  `keyid` varchar(20) NOT NULL,
  `areaname` varchar(50) NOT NULL default '',
  `domain` varchar(50) NOT NULL default '',
  `style` varchar(50) NOT NULL default '',
  `parentid` smallint(6) unsigned NOT NULL default '0',
  `arrparentid` varchar(255) NOT NULL default '',
  `child` tinyint(1) NOT NULL default '0',
  `arrchildid` mediumtext NOT NULL,
  `listorder` smallint(6) unsigned NOT NULL default '0',
  `urlruleid` tinyint(1) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `setting` mediumtext NOT NULL,
  `hits` int(11) unsigned NOT NULL default '0',
  `disabled` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`areaid`),
  KEY `listorder` (`listorder`),
  KEY `keyid` (`keyid`,`disabled`,`listorder`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_house`;
CREATE TABLE IF NOT EXISTS `phpcms_house` (
  `houseid` int(11) unsigned NOT NULL auto_increment,
  `infocat` tinyint(2) unsigned NOT NULL default '0',
  `validperiod` smallint(4) NOT NULL default '0',
  `areaid` smallint(4) unsigned NOT NULL default '0',
  `address` varchar(255) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  `housetype` varchar(200) NOT NULL default '',
  `currentfloor` smallint(4) NOT NULL default '0',
  `totalfloor` smallint(4) NOT NULL default '0',
  `buildarea` decimal(10,3) unsigned NOT NULL default '0.000',
  `usearea` decimal(10,3) unsigned NOT NULL default '0.000',
  `towards` smallint(4) unsigned NOT NULL default '0',
  `decorate` smallint(4) unsigned NOT NULL default '0',
  `manage` tinyint(1) NOT NULL default '0',
  `propertytype` smallint(4) NOT NULL default '0',
  `buildtime` varchar(100) NOT NULL default '',
  `price` int(11) unsigned NOT NULL default '0',
  `unit` varchar(20) NOT NULL default '',
  `infrastructure` varchar(200) NOT NULL default '',
  `indoor` varchar(200) NOT NULL default '',
  `transit` mediumtext NOT NULL,
  `peripheral` varchar(200) NOT NULL default '',
  `description` mediumtext NOT NULL,
  `img1` varchar(255) NOT NULL default '',
  `img2` varchar(255) NOT NULL default '',
  `img3` varchar(255) NOT NULL default '',
  `img4` varchar(255) NOT NULL default '',
  `username` varchar(255) NOT NULL default '',
  `contract` varchar(255) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `mobile` varchar(50) NOT NULL default '',
  `telephone` varchar(50) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `msn` varchar(50) NOT NULL default '',
  `comments` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `addtime` int(11) unsigned NOT NULL default '0',
  `edittime` int(11) unsigned NOT NULL default '0',
  `ishtml` tinyint(1) unsigned NOT NULL default '1',
  `htmldir` varchar(20) NOT NULL default '',
  `prefix` varchar(50) NOT NULL default '',
  `urlruleid` tinyint(3) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '0',
  `listorder` int(5) unsigned NOT NULL default '0',
  `style` varchar(80) NOT NULL default '',
  `arrposid` varchar(50) NOT NULL default '0',
  `subtype` smallint(5) NOT NULL default '0',
  `isinter` tinyint(3) unsigned NOT NULL default '0',
  `corpname` varchar(250) NOT NULL default '',
  `status` tinyint(1) NOT NULL,
  `endtime` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`houseid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_house_coop`;
CREATE TABLE IF NOT EXISTS `phpcms_house_coop` (
  `houseid` int(11) unsigned NOT NULL default '0',
  `havehouse` tinyint(1) unsigned NOT NULL default '0',
  `mygender` tinyint(1) unsigned NOT NULL default '0',
  `yourgender` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`houseid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_house_display`;
CREATE TABLE IF NOT EXISTS `phpcms_house_display` (
  `displayid` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(250) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0',
  `develop` varchar(250) NOT NULL default '',
  `areaid` smallint(5) unsigned NOT NULL default '0',
  `area` varchar(250) NOT NULL default '',
  `startprice` int(10) unsigned NOT NULL default '0',
  `avgprice` int(10) unsigned NOT NULL default '0',
  `address` varchar(250) NOT NULL default '',
  `saleaddress` varchar(250) NOT NULL default '',
  `saletele` varchar(50) NOT NULL default '',
  `contract` varchar(200) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `fax` varchar(50) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `transit` mediumtext NOT NULL,
  `introduce` mediumtext NOT NULL,
  `img1` varchar(250) NOT NULL default '',
  `img2` varchar(250) NOT NULL default '',
  `img3` varchar(250) NOT NULL default '',
  `image` varchar(250) NOT NULL default '',
  `thumb` varchar(250) NOT NULL default '',
  `managefee` varchar(250) NOT NULL default '',
  `licence` varchar(250) NOT NULL default '',
  `starttime` varchar(250) NOT NULL default '',
  `staytime` varchar(250) NOT NULL default '',
  `capacity` varchar(250) NOT NULL default '',
  `green` varchar(250) NOT NULL default '',
  `username` varchar(30) NOT NULL,
  `addtime` int(11) unsigned NOT NULL default '0',
  `edittime` int(11) unsigned NOT NULL default '0',
  `comments` int(11) unsigned NOT NULL default '0',
  `ishtml` tinyint(1) unsigned NOT NULL default '1',
  `htmldir` varchar(20) NOT NULL default '',
  `prefix` varchar(50) NOT NULL default '',
  `urlruleid` tinyint(3) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '0',
  `listorder` int(5) unsigned NOT NULL default '0',
  `subtype` smallint(5) NOT NULL default '0',
  `style` varchar(80) NOT NULL default '',
  `arrposid` varchar(50) NOT NULL default '0',
  `buildarea` varchar(250) NOT NULL default '',
  `housetype` varchar(200) NOT NULL default '',
  `peripheral` varchar(200) NOT NULL default '',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`displayid`),
  KEY `username` (`status`,`username`,`displayid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_house_hold`;
CREATE TABLE IF NOT EXISTS `phpcms_house_hold` (
  `holdid` int(11) unsigned NOT NULL auto_increment,
  `displayid` int(11) unsigned NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `thumb` varchar(250) NOT NULL default '',
  `image` varchar(250) NOT NULL default '',
  `area` decimal(10,3) NOT NULL default '0.000',
  PRIMARY KEY  (`holdid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_channel` (`module`, `channelname`, `style`, `channelpic`, `introduce`, `seo_title`, `seo_keywords`, `seo_description`, `listorder`, `islink`, `channeldir`, `channeldomain`, `disabled`, `templateid`, `skinid`, `items`, `comments`, `categorys`, `specials`, `hits`, `enablepurview`, `arrgroupid_browse`, `purview_message`, `point_message`, `enablecontribute`, `enablecheck`, `emailofreject`, `emailofpassed`, `enableupload`, `uploaddir`, `maxfilesize`, `uploadfiletype`, `linkurl`, `setting`, `ishtml`, `cat_html_urlruleid`, `item_html_urlruleid`, `special_html_urlruleid`, `cat_php_urlruleid`, `item_php_urlruleid`, `special_php_urlruleid`) VALUES ( 'house', '房产', '', '', '', '', '', '', 30, 1, '', '', 0, '0', '0', 0, 0, 0, 0, 0, 0, '', '', '', 1, 1, '', '', 1, 'uploadfile', 1024000, 'gif|jpg', 'house/', '', 1, 0, 0, 0, 0, 0, 0);
INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('房产', 'house', 'house', '', 0, 0, 0, '1.0.0', 'phpcms', 'www.phpcms.cn', 'phpcms@163.com', 'phpcms房产模块', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');

alter table `phpcms_member_info` add `my_house_membertype` int(11) NOT NULL, add  `my_house_corpname` varchar(255) NOT NULL, ADD `my_house_introduce` text NOT NULL ;
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '房屋出租管理', '我有房子可以出租', 'house/frontmgr.php?type=1', '_self', '', 0, '', '', '');
INSERT INTO `phpcms_menu` ( `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '房屋求租管理', '我需要租房', 'house/frontmgr.php?type=2', '_self', '', 0, '', '', '');
INSERT INTO `phpcms_menu` ( `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ( 'member_menu', '房屋合租管理', '我需要和别人合租房', 'house/frontmgr.php?type=3', '_self', '', 0, '', '', '');
INSERT INTO `phpcms_menu` ( `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ( 'member_menu', '房屋出售管理', '我有房需要出售', 'house/frontmgr.php?type=4', '_self', '', 0, '', '', '');
INSERT INTO `phpcms_menu` ( `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ( 'member_menu', '房屋求购管理', '我需要购买住房', 'house/frontmgr.php?type=5', '_self', '', 0, '', '', '');
INSERT INTO `phpcms_menu` ( `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ( 'member_menu', '房屋置换管理', '我需要置换住房', 'house/frontmgr.php?type=6', '_self', '', 0, '', '', '');
INSERT INTO `phpcms_menu` ( `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ( 'member_menu', '新楼盘管理', '添加管理新楼盘', 'house/displaymgr.php', '_self', '', 0, '', '', '');