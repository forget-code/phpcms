INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('ads', '广告管理', 'ads/', '', 0, '1.0.0.0', 'Phpcm Team', 'http://www.phpcms.cn', 'phpcms@163.com', '', '', '', '', 'array (\r\n  ''enableadsclick'' => ''1'',\r\n  ''pagesize'' => ''15'',\r\n  ''ext'' => ''jpg|jpeg|gif|bmp|png|swf'',\r\n  ''maxsize'' => ''307200'',\r\n  ''htmldir'' => ''js'',\r\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_ads_place`;
CREATE TABLE IF NOT EXISTS `phpcms_ads_place` (
  `placeid` mediumint(8) unsigned NOT NULL auto_increment,
  `placename` char(50) NOT NULL,
  `template` char(30) NOT NULL default '0',
  `introduce` char(100) NOT NULL,
  `price` mediumint(8) unsigned NOT NULL default '0',
  `items` smallint(4) unsigned NOT NULL default '0',
  `width` smallint(4) unsigned NOT NULL default '0',
  `height` smallint(4) unsigned NOT NULL default '0',
  `passed` tinyint(1) unsigned NOT NULL default '1',
  `option` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`placeid`)
) TYPE=MyISAM  ;

-- 
-- 导出表中的数据 `phpcms_ads_place`
-- 

INSERT INTO `phpcms_ads_place` (`placeid`, `placename`, `template`, `introduce`, `price`, `items`, `width`, `height`, `passed`, `option`) VALUES 
(1, '网站首页广告', 'ads', '', 10, 1, 638, 58, 1, 0),
(3, '评论页310x210图片广告', 'ads', '', 10, 1, 310, 210, 1, 0),
(4, '问吧416x60图片广告', 'ads', '', 10, 1, 416, 60, 1, 0),
(5, '模型310x210图片广告', 'ads', '', 50, 1, 310, 210, 1, 0),
(6, '产品展示模型首页广告', 'ads', '', 0, 1, 746, 50, 1, 0),
(7, '网站首页横幅', 'ads', '', 10, 1, 638, 58, 1, 0);

DROP TABLE IF EXISTS `phpcms_ads`;
CREATE TABLE `phpcms_ads` (
  `adsid` mediumint(8) unsigned NOT NULL auto_increment,
  `adsname` varchar(40) NOT NULL,
  `introduce` varchar(255) NOT NULL,
  `placeid` mediumint(8) unsigned NOT NULL default '0',
  `type` varchar(10) NOT NULL,
  `linkurl` varchar(100) NOT NULL,
  `imageurl` varchar(100) NOT NULL,
  `s_imageurl` varchar(100) NOT NULL,
  `alt` varchar(20) NOT NULL,
  `flashurl` varchar(100) NOT NULL,
  `wmode` varchar(20) NOT NULL,
  `text` text NOT NULL,
  `code` text NOT NULL,
  `fromdate` int(10) unsigned NOT NULL default '0',
  `todate` int(10) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `views` int(10) unsigned NOT NULL default '0',
  `clicks` mediumint(8) unsigned NOT NULL default '0',
  `passed` tinyint(1) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`adsid`),
  KEY `fromdate` (`fromdate`,`todate`),
  KEY `placeid` (`placeid`,`passed`,`fromdate`,`todate`,`username`),
  KEY `username` (`username`,`passed`)
) TYPE=MyISAM ;

INSERT INTO `phpcms_ads` (`adsid`, `adsname`, `introduce`, `placeid`, `type`, `linkurl`, `imageurl`, `s_imageurl`, `alt`, `flashurl`, `wmode`, `text`, `code`, `fromdate`, `todate`, `username`, `addtime`, `views`, `clicks`, `passed`, `status`) VALUES 
(1, '首页638x58图片广告', '', 1, 'image', 'www.phpcms.cn', 'uploadfile/2008/0831/20080831094526548.jpg', '', '广告', '', 'transparent', '', '', 1220025600, 1293811200, 'phpcms', 1220064717, 0, 10, 1, 1),
(4, '新浪汽车频道', '', 3, 'image', 'www.google.cn', 'uploadfile/2008/0831/20080831100602900.jpg', '', 'www.google.cn', '', 'transparent', '', '', 1217865600, 1293811200, 'phpcms', 1220148362, 0, 1, 1, 1),
(5, 'phpcms新产品广告', '', 4, 'image', 'www.phpcms.cn', 'uploadfile/2008/0831/20080831104206433.jpg', '', 'phpcms', '', 'transparent', '', '', 1220112000, 1293811200, 'phpcms', 1220150526, 0, 6, 1, 1),
(6, '模型页面广告', '', 5, 'image', 'www.phpcms.cn', 'uploadfile/2008/0831/20080831021105267.jpg', '', '', '', 'transparent', '', '', 1220112000, 1293811200, 'phpcms', 1220163065, 0, 4, 1, 1),
(7, '产品展示模型图片广告', '', 6, 'image', '', 'uploadfile/2008/0831/20081018020032914.gif', '', '', '', 'transparent', '', '', 1224259200, 1293811200, 'phpcms', 1224309632, 0, 0, 1, 1),
(8, '首页横幅广告', '', 7, 'image', 'www.phpcms.cn', 'uploadfile/2008/0831/20080831094526548.jpg', '', '广告', '', 'transparent', '', '', 1220025600, 1293811200, 'phpcms', 1220064717, 0, 10, 1, 1);


DROP TABLE IF EXISTS `phpcms_ads_stat`;
CREATE TABLE IF NOT EXISTS `phpcms_ads_stat` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `adsid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `area` char(40) NOT NULL,
  `ip` char(15) NOT NULL,
  `referer` char(120) NOT NULL,
  `clicktime` int(10) unsigned NOT NULL default '0',
  `type` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `adsid` (`adsid`,`type`,`ip`)
) TYPE=MyISAM;
