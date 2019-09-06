INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('广告', 'ads', 'ads', '', 0, 0, 0, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn/', 'phpcms@163.com', '功能说明', '许可协议', '使用帮助', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_ads`;
CREATE TABLE IF NOT EXISTS `phpcms_ads` (
  `adsid` int(11) NOT NULL auto_increment,
  `adsname` varchar(50) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `placeid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  `imageurl` varchar(255) NOT NULL default '',
  `alt` varchar(255) NOT NULL default '',
  `flashurl` varchar(255) NOT NULL default '',
  `wmode` varchar(20) NOT NULL default '',
  `text` mediumtext NOT NULL,
  `code` mediumtext NOT NULL,
  `fromdate` int(11) unsigned NOT NULL default '0',
  `todate` int(11) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(11) unsigned NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `checked` tinyint(1) unsigned NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`adsid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_ads` (`adsid`, `adsname`, `introduce`, `placeid`, `type`, `linkurl`, `imageurl`, `alt`, `flashurl`, `wmode`, `text`, `code`, `fromdate`, `todate`, `username`, `addtime`, `views`, `hits`, `checked`, `passed`) VALUES (1, 'phpcms 2007 广告', 'phpcms 2007 广告', 1, 'image', 'http://www.phpcms.cn/', 'ads/uploadfile/200701/banner.gif', '欢迎体验phpcms 2007 测试版', '', '', '', '<TABLE>\r\n<TR>\r\n	<TD>e</TD>\r\n	<TD>wwwwwwwwwwwwwww</TD>\r\n	<TD>aaaaaw</TD>\r\n</TR>\r\n<TR>\r\n	<TD>ssssaaaaaaaa</TD>\r\n	<TD></TD>\r\n	<TD>ssssssss</TD>\r\n</TR>', 1168790400, 1200326400, 'phpcms', 1168837934, 9601, 12, 1, 1);
INSERT INTO `phpcms_ads` (`adsid`, `adsname`, `introduce`, `placeid`, `type`, `linkurl`, `imageurl`, `alt`, `flashurl`, `wmode`, `text`, `code`, `fromdate`, `todate`, `username`, `addtime`, `views`, `hits`, `checked`, `passed`) VALUES (2, 'phpcms 2007 优惠订购广告', 'ssssssss', 2, 'image', 'http://www.phpcms.cn/', 'ads/uploadfile/200701/bigbanner.gif', 'phpcms 2007 7折优惠订购', '', '', '', '<TABLE>\r\n<TR>\r\n	<TD>e</TD>\r\n	<TD>wwwwwwwwwwwwwww</TD>\r\n	<TD>aaaaaw</TD>\r\n</TR>\r\n<TR>\r\n	<TD>ssssaaaaaaaa</TD>\r\n	<TD></TD>\r\n	<TD>ssssssss</TD>\r\n</TR>', 1168790400, 1179158400, 'phpcms', 1168838524, 1289, 3, 1, 1);

DROP TABLE IF EXISTS `phpcms_ads_place`;
CREATE TABLE IF NOT EXISTS `phpcms_ads_place` (
  `placeid` int(11) NOT NULL auto_increment,
  `placename` varchar(50) NOT NULL default '',
  `templateid` varchar(20) NOT NULL default '0',
  `introduce` varchar(255) NOT NULL default '',
  `channelid` smallint(5) unsigned NOT NULL default '0',
  `price` int(11) NOT NULL default '0',
  `width` int(11) NOT NULL default '0',
  `height` int(11) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`placeid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES (1, '顶部banner', 'ads', '顶部banner广告', 0, 0, 468, 60, 1);
INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES (2, '首页横幅', 'ads', '', 0, 0, 708, 80, 1);
