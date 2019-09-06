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

INSERT INTO `phpcms_ads` (`adsname`, `introduce`, `placeid`, `type`, `linkurl`, `imageurl`, `alt`, `flashurl`, `wmode`, `text`, `code`, `fromdate`, `todate`, `username`, `addtime`, `views`, `hits`, `checked`, `passed`) VALUES('phpcms 2007 旗帜广告', 'phpcms 2007 广告', 1, 'flash', 'http://www.phpcms.cn/', '', '欢迎体验 phpcms 2007 ！', 'images/phpcms2007sp6.swf', '', '', ' ', 1168790400, 1262188800, 'phpcms', 1168837934, 32776, 14, 1, 1);
INSERT INTO `phpcms_ads` (`adsname`, `introduce`, `placeid`, `type`, `linkurl`, `imageurl`, `alt`, `flashurl`, `wmode`, `text`, `code`, `fromdate`, `todate`, `username`, `addtime`, `views`, `hits`, `checked`, `passed`) VALUES('广告2', '', 6, 'image', 'http://www.phpcms.cn', 'images/phpcmssoft.gif', '', '', '', '', '', 1200412800, 1203091200, '', 1200414959, 0, 0, 1, 1);

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

INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES(1, '顶部banner', 'ads', '顶部banner广告', 0, 0, 600, 80, 1);
INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES(2, '首页横幅', 'ads', '', 0, 0, 665, 137, 1);
INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES(3, '左边广告', 'ads', '', 0, 0, 304, 95, 1);
INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES(4, '企业黄页频道宽661高89广告', 'ads', '', 0, 0, 661, 89, 1);
INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES(5, '分类信息宽300高80广告', 'ads', '按地区浏览广告下面', 0, 0, 300, 80, 1);
INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES(6, '文章频道宽305高95广告', 'ads', '文章频道宽305高95广告', 0, 0, 305, 95, 1);
INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES(7, '下载频道宽305高95广告', 'ads', '下载频道宽305高95广告', 0, 0, 305, 95, 1);
INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES(8, '图片频道宽305高95广告', 'ads', '图片频道宽305高95广告', 0, 0, 305, 95, 1);
INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES(9, '影视频道宽722高64广告', 'ads', '', 0, 0, 722, 64, 1);
INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `templateid`, `introduce`, `channelid`, `price`, `width`, `height`, `passed`) VALUES(10, '商城频道宽208高74广告', 'ads', '', 0, 0, 208, 74, 1);