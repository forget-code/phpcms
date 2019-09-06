-- 
-- 表的结构 `phpcms_admin`
-- 

DROP TABLE IF EXISTS `phpcms_admin`;
CREATE TABLE IF NOT EXISTS `phpcms_admin` (
  `userid` int(11) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `grade` tinyint(4) NOT NULL default '0',
  `purview_module` text NOT NULL,
  `purview_channel` text NOT NULL,
  `purview_category` text NOT NULL,
  PRIMARY KEY  (`userid`),
  KEY `grade` (`grade`),
  KEY `username` (`username`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_ads`
-- 

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
  `text` text NOT NULL,
  `code` text NOT NULL,
  `fromdate` int(11) unsigned NOT NULL default '0',
  `todate` int(11) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(11) unsigned NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `ispassed` tinyint(1) unsigned NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`adsid`),
  KEY `placeid` (`placeid`),
  KEY `fromdate` (`fromdate`,`todate`,`username`,`passed`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_ads`
-- 

INSERT INTO `phpcms_ads` VALUES (1, 'phpcms 3.0闪亮登场', 'phpcms 3.0闪亮登场', 1, 'image', 'http://www.phpcms.cn', 'http://www.phpcms.cn/images/banner_2.jpg', 'phpcms 3.0闪亮登场', '', '', '', '', 1151337600, 1217088000, 'phpcms', 1151404258, 13, 2, 1, 1);
INSERT INTO `phpcms_ads` VALUES (2, 'phpcms 3.0 flash广告', 'phpcms 3.0 flash广告', 2, 'flash', '', '', '', 'http://www.phpcms.cn/images/phpcms.swf', '', '', '', 1151337600, 1217088000, 'phpcms', 1151406255, 1, 0, 1, 1);
INSERT INTO `phpcms_ads` VALUES (3, 'phpcms 浮动广告', 'phpcms 浮动广告', 3, 'image', 'http://www.phpcms.cn', 'http://demo.phpcms.cn/ads/uploads/200606/20060618084925314.jpg', '', '', '', '', '', 1151337600, 1217088000, 'phpcms', 1151406330, 1, 0, 1, 1);
INSERT INTO `phpcms_ads` VALUES (4, '浦东信息港主机广告', '浦东信息港主机广告', 4, 'image', 'http://www.pdxx.com', 'http://www.phpcms.cn/images/pdxx.gif', '', '', '', '', '', 1151337600, 1217088000, 'phpcms', 1151406374, 0, 0, 1, 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_ads_place`
-- 

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
  `adsid` int(11) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`placeid`),
  KEY `adsid` (`adsid`,`passed`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_ads_place`
-- 

INSERT INTO `phpcms_ads_place` VALUES (1, '网站顶部banner', 'ads', '网站顶部banner', 0, 0, 584, 80, 0, 1);
INSERT INTO `phpcms_ads_place` VALUES (2, '首页横幅', 'ads', '首页横幅', 0, 0, 700, 80, 0, 1);
INSERT INTO `phpcms_ads_place` VALUES (3, '全站漂浮', 'ads-float', '全站漂浮', 0, 0, 100, 100, 0, 1);
INSERT INTO `phpcms_ads_place` VALUES (4, '下载列表banner', 'ads', '下载列表banner', 2, 0, 468, 60, 0, 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_announcement`
-- 

DROP TABLE IF EXISTS `phpcms_announcement`;
CREATE TABLE IF NOT EXISTS `phpcms_announcement` (
  `announceid` int(10) unsigned NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `content` text NOT NULL,
  `hits` int(11) NOT NULL default '0',
  `fromdate` date NOT NULL default '0000-00-00',
  `todate` date NOT NULL default '0000-00-00',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '0',
  PRIMARY KEY  (`announceid`),
  KEY `username` (`username`),
  KEY `passed` (`passed`),
  KEY `channelid` (`channelid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_article`
-- 

DROP TABLE IF EXISTS `phpcms_article`;
CREATE TABLE IF NOT EXISTS `phpcms_article` (
  `articleid` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `specialid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `titleintact` varchar(255) NOT NULL default '',
  `subheading` varchar(255) NOT NULL default '',
  `includepic` tinyint(1) NOT NULL default '0',
  `titlefontcolor` varchar(7) NOT NULL default '',
  `titlefonttype` tinyint(1) NOT NULL default '0',
  `showcommentlink` tinyint(1) NOT NULL default '0',
  `description` mediumtext NOT NULL,
  `keywords` varchar(100) NOT NULL default '',
  `author` varchar(50) NOT NULL default '',
  `authoremail` varchar(50) NOT NULL default '',
  `copyfromname` varchar(100) NOT NULL default '',
  `copyfromurl` varchar(255) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `paginationtype` tinyint(1) NOT NULL default '0',
  `maxcharperpage` int(11) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `savepathfilename` mediumtext NOT NULL,
  `linkurl` varchar(255) NOT NULL default '',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `editor` varchar(25) NOT NULL default '',
  `edittime` int(11) NOT NULL default '0',
  `checker` varchar(25) NOT NULL default '',
  `checktime` int(11) NOT NULL default '0',
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '0',
  `ontop` tinyint(1) NOT NULL default '0',
  `elite` tinyint(1) NOT NULL default '0',
  `stars` tinyint(1) NOT NULL default '0',
  `recycle` tinyint(1) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `groupview` varchar(255) NOT NULL default '',
  `readpoint` int(11) NOT NULL default '0',
  PRIMARY KEY  (`articleid`),
  KEY `catid` (`catid`,`channelid`,`recycle`,`status`,`ontop`,`articleid`),
  KEY `specialid` (`specialid`,`channelid`,`recycle`,`status`,`ontop`,`articleid`),
  KEY `elite` (`elite`,`channelid`,`recycle`,`status`,`articleid`),
  KEY `channelid` (`channelid`,`recycle`,`status`,`articleid`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_author`
-- 

DROP TABLE IF EXISTS `phpcms_author`;
CREATE TABLE IF NOT EXISTS `phpcms_author` (
  `id` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `face` varchar(255) NOT NULL default '',
  `articlenum` int(11) NOT NULL default '0',
  `introduction` varchar(255) NOT NULL default '',
  `elite` tinyint(1) NOT NULL default '0',
  `updatetime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `channelid` (`channelid`,`updatetime`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_banip`
-- 

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

-- 
-- 导出表中的数据 `phpcms_banip`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_category`
-- 

DROP TABLE IF EXISTS `phpcms_category`;
CREATE TABLE IF NOT EXISTS `phpcms_category` (
  `catid` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `catname` varchar(50) NOT NULL default '',
  `catpic` varchar(255) NOT NULL default '',
  `target` varchar(15) NOT NULL default '',
  `cattype` tinyint(1) NOT NULL default '0',
  `catdir` varchar(30) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  `parentid` int(11) NOT NULL default '0',
  `arrparentid` varchar(255) NOT NULL default '',
  `parentdir` varchar(255) NOT NULL default '',
  `child` tinyint(1) NOT NULL default '0',
  `arrchildid` text NOT NULL,
  `orderid` int(11) NOT NULL default '0',
  `introduce` text NOT NULL,
  `meta_keywords` varchar(255) NOT NULL default '',
  `meta_description` text NOT NULL,
  `templateid` varchar(20) NOT NULL default '0',
  `listtemplateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '0',
  `showonmenu` tinyint(1) NOT NULL default '0',
  `islist` tinyint(1) NOT NULL default '0',
  `showchilditems` tinyint(4) NOT NULL default '0',
  `maxperpage` tinyint(4) NOT NULL default '0',
  `defaultitemtemplate` varchar(20) NOT NULL default '0',
  `defaultitemskin` varchar(20) NOT NULL default '0',
  `itemordertype` tinyint(4) NOT NULL default '0',
  `itemtarget` tinyint(1) NOT NULL default '0',
  `itemnumber` int(11) NOT NULL default '0',
  `enableprotect` tinyint(1) NOT NULL default '0',
  `enableadd` tinyint(1) NOT NULL default '0',
  `enablecomment` tinyint(1) NOT NULL default '0',
  `catpurview` tinyint(1) NOT NULL default '0',
  `arrgroupid_browse` text NOT NULL,
  `arrgroupid_view` text NOT NULL,
  `arrgroupid_add` text NOT NULL,
  `creditget` int(11) NOT NULL default '0',
  `defaultpoint` int(11) NOT NULL default '0',
  `defaultchargetype` tinyint(1) NOT NULL default '0',
  `closed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`catid`),
  KEY `catname` (`catname`,`cattype`,`parentid`,`child`),
  KEY `orderid` (`orderid`),
  KEY `showonmenu` (`showonmenu`,`islist`),
  KEY `channelid` (`channelid`),
  KEY `listtemplateid` (`listtemplateid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_category`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_channel`
-- 

DROP TABLE IF EXISTS `phpcms_channel`;
CREATE TABLE IF NOT EXISTS `phpcms_channel` (
  `channelid` int(11) NOT NULL auto_increment,
  `module` varchar(20) NOT NULL default '',
  `channelname` varchar(20) NOT NULL default '',
  `channelpic` varchar(255) NOT NULL default '',
  `introduce` text NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` varchar(255) NOT NULL default '',
  `orderid` int(11) NOT NULL default '0',
  `channeltype` tinyint(1) NOT NULL default '0',
  `linkurl` varchar(100) NOT NULL default '',
  `channeldir` varchar(30) NOT NULL default '',
  `channeldomain` varchar(50) NOT NULL default '',
  `disabled` tinyint(1) NOT NULL default '0',
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '',
  `itemcount` int(11) NOT NULL default '0',
  `itemchecked` int(11) NOT NULL default '0',
  `commentcount` int(11) NOT NULL default '0',
  `specialcount` int(11) NOT NULL default '0',
  `hitscount` int(11) NOT NULL default '0',
  `channelpurview` tinyint(1) NOT NULL default '0',
  `arrgroupid_browse` text NOT NULL,
  `purview_message` text NOT NULL,
  `point_message` text NOT NULL,
  `enablecontribute` tinyint(1) NOT NULL default '0',
  `enablecheck` tinyint(1) NOT NULL default '0',
  `emailofreject` text NOT NULL,
  `emailofpassed` text NOT NULL,
  `enableupload` tinyint(1) NOT NULL default '0',
  `uploaddir` varchar(50) NOT NULL default '',
  `maxfilesize` int(11) NOT NULL default '0',
  `uploadfiletype` varchar(255) NOT NULL default '',
  `htmlcreatetype` tinyint(4) NOT NULL default '0',
  `urltype` tinyint(1) NOT NULL default '0',
  `fileext` varchar(20) NOT NULL default '',
  `listfilepre` varchar(20) NOT NULL default '',
  `listfiletype` tinyint(4) NOT NULL default '0',
  `contentfilepre` varchar(20) NOT NULL default '',
  `contentfiletype` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`channelid`),
  KEY `orderid` (`orderid`,`channeltype`),
  KEY `module` (`module`),
  KEY `disabled` (`disabled`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_channel`
-- 

INSERT INTO `phpcms_channel` VALUES (1, 'article', '文章', '', '', '文章,新闻,phpcms', '文章,新闻,phpcms', 1, 1, '', 'article', '', 0, '0', 'article', 0, 0, 0, 0, 0, 0, '', '<div align=''center'' style=''color:red''>对不起，您没有阅读权限！</div>', '<p align=''center''><span style=''background:#E3E3E3''><a href=''{$readurl}'' class=''read''>阅读本文需要消耗<font color=''red''>{$readpoint}</font>点，您确认查看吗？</a></span></p><br/>', 1, 1, '退稿时站内短信/Email通知内容：\r\n', '稿件被采用时站内短信/Email通知内容：\r\n', 1, 'uploadfile', 1024000, 'gif|jpg|jpeg|bmp|swf|rm|mp3|wav|mid|midi|ra|avi|mpg|mpeg|asf|asx|wma|mov|rar|zip|exe|doc|xls|chm|hlp', 3, 1, 'html', 'list_', 0, 'article_', 0);
INSERT INTO `phpcms_channel` VALUES (2, 'down', '下载', '', '软件下载', '软件下载', '软件下载,phpcms', 2, 1, '', 'down', '', 0, '0', 'down', 0, 0, 0, 0, 0, 0, '', '<div align=''center'' style=''color:red''>对不起，您没有阅读权限！</div>', '<p align=''center''><span style=''background:#E3E3E3''><a href=''{$readurl}'' class=''read''>阅读本文需要消耗<font color=''red''>{$readpoint}</font>点，您确认查看吗？</a></span></p><br/>', 1, 1, '', '', 1, 'uploadfile', 1024000, 'gif|jpg|bmp|png|doc|rar|zip|txt', 3, 1, 'html', 'list_', 0, 'soft_', 0);
INSERT INTO `phpcms_channel` VALUES (3, 'picture', '图片', '', '图片展示', '图片', '图片,phpcms', 3, 1, '', 'picture', '', 0, 'index', 'picture', 0, 0, 0, 0, 0, 0, '', '<div align=''center'' style=''color:red''>对不起，您没有阅读权限！</div>', '<p align=''center''><span style=''background:#E3E3E3''><a href=''{$readurl}'' class=''read''>阅读本文需要消耗<font color=''red''>{$readpoint}</font>点，您确认查看吗？</a></span></p><br/>', 1, 1, '', '', 1, 'uploadfile', 2048000, 'jpg|jpeg|gif|png|bmp', 3, 1, 'html', 'list_', 0, 'picture_', 0);
INSERT INTO `phpcms_channel` VALUES (4, '', '论坛', '', '', '', '', 4, 0, 'http://bbs.phpcms.cn', '', '', 0, '0', '0', 0, 0, 0, 0, 0, 0, '', '', '', 1, 1, '', '', 1, 'uploadfile', 1024, 'gif|jpg|jpeg|bmp|swf|rm|mp3|wav|mid|midi|ra|avi|mpg|mpeg|asf|asx|wma|mov|rar|zip|doc|xls|chm|hlp', 3, 1, 'htm', 'list_', 0, 'content_', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_city`
-- 

DROP TABLE IF EXISTS `phpcms_city`;
CREATE TABLE IF NOT EXISTS `phpcms_city` (
  `cityid` int(11) NOT NULL auto_increment,
  `country` varchar(50) NOT NULL default '',
  `province` varchar(20) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `area` varchar(50) NOT NULL default '',
  `postcode` varchar(10) NOT NULL default '',
  `areacode` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`cityid`),
  KEY `province` (`province`),
  KEY `country` (`country`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_city`
-- 

INSERT INTO `phpcms_city` VALUES (1, '中华人民共和国', '北京市', '东城区', '', '100000', '010');
INSERT INTO `phpcms_city` VALUES (2, '中华人民共和国', '北京市', '西城区', '', '100000', '010');
INSERT INTO `phpcms_city` VALUES (3, '中华人民共和国', '北京市', '崇文区', '', '100000', '010');
INSERT INTO `phpcms_city` VALUES (4, '中华人民共和国', '北京市', '宣武区', '', '100000', '010');
INSERT INTO `phpcms_city` VALUES (5, '中华人民共和国', '北京市', '朝阳区', '', '100000', '010');
INSERT INTO `phpcms_city` VALUES (6, '中华人民共和国', '北京市', '丰台区', '', '100000', '010');
INSERT INTO `phpcms_city` VALUES (7, '中华人民共和国', '北京市', '石景山区', '', '100000', '010');
INSERT INTO `phpcms_city` VALUES (8, '中华人民共和国', '北京市', '海淀区', '', '100000', '010');
INSERT INTO `phpcms_city` VALUES (9, '中华人民共和国', '北京市', '门头沟区', '', '102300', '010');
INSERT INTO `phpcms_city` VALUES (10, '中华人民共和国', '北京市', '房山区', '', '102400', '010');
INSERT INTO `phpcms_city` VALUES (11, '中华人民共和国', '北京市', '通州区', '', '101100', '010');
INSERT INTO `phpcms_city` VALUES (12, '中华人民共和国', '北京市', '顺义区', '', '101300', '010');
INSERT INTO `phpcms_city` VALUES (13, '中华人民共和国', '北京市', '昌平区', '', '102200', '010');
INSERT INTO `phpcms_city` VALUES (14, '中华人民共和国', '北京市', '大兴区', '', '102600', '010');
INSERT INTO `phpcms_city` VALUES (15, '中华人民共和国', '北京市', '怀柔区', '', '101400', '010');
INSERT INTO `phpcms_city` VALUES (16, '中华人民共和国', '北京市', '平谷区', '', '101200', '010');
INSERT INTO `phpcms_city` VALUES (17, '中华人民共和国', '北京市', '密云县', '', '101500', '010');
INSERT INTO `phpcms_city` VALUES (18, '中华人民共和国', '北京市', '延庆县', '', '102100', '010');
INSERT INTO `phpcms_city` VALUES (19, '中华人民共和国', '上海市', '黄浦区', '', '200000', '021');
INSERT INTO `phpcms_city` VALUES (20, '中华人民共和国', '上海市', '卢湾区', '', '200000', '021');
INSERT INTO `phpcms_city` VALUES (21, '中华人民共和国', '上海市', '徐汇区', '', '200000', '021');
INSERT INTO `phpcms_city` VALUES (22, '中华人民共和国', '上海市', '长宁区', '', '200000', '021');
INSERT INTO `phpcms_city` VALUES (23, '中华人民共和国', '上海市', '静安区', '', '200000', '021');
INSERT INTO `phpcms_city` VALUES (24, '中华人民共和国', '上海市', '普陀区', '', '200000', '021');
INSERT INTO `phpcms_city` VALUES (25, '中华人民共和国', '上海市', '闸北区', '', '200000', '021');
INSERT INTO `phpcms_city` VALUES (26, '中华人民共和国', '上海市', '虹口区', '', '200000', '021');
INSERT INTO `phpcms_city` VALUES (27, '中华人民共和国', '上海市', '杨浦区', '', '200000', '021');
INSERT INTO `phpcms_city` VALUES (28, '中华人民共和国', '上海市', '闵行区', '', '201100', '021');
INSERT INTO `phpcms_city` VALUES (29, '中华人民共和国', '上海市', '宝山区', '', '201900', '021');
INSERT INTO `phpcms_city` VALUES (30, '中华人民共和国', '上海市', '嘉定区', '', '201800', '021');
INSERT INTO `phpcms_city` VALUES (31, '中华人民共和国', '上海市', '浦东新区', '', '201200', '021');
INSERT INTO `phpcms_city` VALUES (32, '中华人民共和国', '上海市', '金山区', '', '201500', '021');
INSERT INTO `phpcms_city` VALUES (33, '中华人民共和国', '上海市', '松江区', '', '201600', '021');
INSERT INTO `phpcms_city` VALUES (34, '中华人民共和国', '上海市', '青浦区', '', '201700', '021');
INSERT INTO `phpcms_city` VALUES (35, '中华人民共和国', '上海市', '南汇区', '', '201300', '021');
INSERT INTO `phpcms_city` VALUES (36, '中华人民共和国', '上海市', '奉贤区', '', '201400', '021');
INSERT INTO `phpcms_city` VALUES (37, '中华人民共和国', '上海市', '崇明县', '', '202150', '021');
INSERT INTO `phpcms_city` VALUES (38, '中华人民共和国', '天津市', '和平区', '', '300000', '022');
INSERT INTO `phpcms_city` VALUES (39, '中华人民共和国', '天津市', '河东区', '', '300000', '022');
INSERT INTO `phpcms_city` VALUES (40, '中华人民共和国', '天津市', '河西区', '', '300000', '022');
INSERT INTO `phpcms_city` VALUES (41, '中华人民共和国', '天津市', '南开区', '', '300000', '022');
INSERT INTO `phpcms_city` VALUES (42, '中华人民共和国', '天津市', '河北区', '', '300000', '022');
INSERT INTO `phpcms_city` VALUES (43, '中华人民共和国', '天津市', '红桥区', '', '300000', '022');
INSERT INTO `phpcms_city` VALUES (44, '中华人民共和国', '天津市', '塘沽区', '', '300450', '022');
INSERT INTO `phpcms_city` VALUES (45, '中华人民共和国', '天津市', '汉沽区', '', '300480', '022');
INSERT INTO `phpcms_city` VALUES (46, '中华人民共和国', '天津市', '大港区', '', '300200', '022');
INSERT INTO `phpcms_city` VALUES (47, '中华人民共和国', '天津市', '东丽区', '', '300000', '022');
INSERT INTO `phpcms_city` VALUES (48, '中华人民共和国', '天津市', '西青区', '', '300000', '022');
INSERT INTO `phpcms_city` VALUES (49, '中华人民共和国', '天津市', '津南区', '', '300000', '022');
INSERT INTO `phpcms_city` VALUES (50, '中华人民共和国', '天津市', '北辰区', '', '300000', '022');
INSERT INTO `phpcms_city` VALUES (51, '中华人民共和国', '天津市', '武清区', '', '301700', '022');
INSERT INTO `phpcms_city` VALUES (52, '中华人民共和国', '天津市', '宝坻区', '', '301800', '022');
INSERT INTO `phpcms_city` VALUES (53, '中华人民共和国', '天津市', '宁河县', '', '301500', '022');
INSERT INTO `phpcms_city` VALUES (54, '中华人民共和国', '天津市', '静海县', '', '301600', '022');
INSERT INTO `phpcms_city` VALUES (55, '中华人民共和国', '天津市', '蓟县', '', '301900', '022');
INSERT INTO `phpcms_city` VALUES (56, '中华人民共和国', '重庆市', '万州区', '', '404000', '023');
INSERT INTO `phpcms_city` VALUES (57, '中华人民共和国', '重庆市', '涪陵区', '', '408000', '023');
INSERT INTO `phpcms_city` VALUES (58, '中华人民共和国', '重庆市', '渝中区', '', '400010', '023');
INSERT INTO `phpcms_city` VALUES (59, '中华人民共和国', '重庆市', '大渡口区', '', '400080', '023');
INSERT INTO `phpcms_city` VALUES (60, '中华人民共和国', '重庆市', '江北区', '', '400020', '023');
INSERT INTO `phpcms_city` VALUES (61, '中华人民共和国', '重庆市', '沙坪坝区', '', '400030', '023');
INSERT INTO `phpcms_city` VALUES (62, '中华人民共和国', '重庆市', '九龙坡区', '', '400050', '023');
INSERT INTO `phpcms_city` VALUES (63, '中华人民共和国', '重庆市', '南岸区', '', '400060', '023');
INSERT INTO `phpcms_city` VALUES (64, '中华人民共和国', '重庆市', '北碚区', '', '400700', '023');
INSERT INTO `phpcms_city` VALUES (65, '中华人民共和国', '重庆市', '万盛区', '', '400800', '023');
INSERT INTO `phpcms_city` VALUES (66, '中华人民共和国', '重庆市', '双桥区', '', '400900', '023');
INSERT INTO `phpcms_city` VALUES (67, '中华人民共和国', '重庆市', '渝北区', '', '401100', '023');
INSERT INTO `phpcms_city` VALUES (68, '中华人民共和国', '重庆市', '巴南区', '', '401300', '023');
INSERT INTO `phpcms_city` VALUES (69, '中华人民共和国', '重庆市', '黔江区', '', '409000', '023');
INSERT INTO `phpcms_city` VALUES (70, '中华人民共和国', '重庆市', '长寿区', '', '401200', '023');
INSERT INTO `phpcms_city` VALUES (71, '中华人民共和国', '重庆市', '綦江县', '', '401400', '023');
INSERT INTO `phpcms_city` VALUES (72, '中华人民共和国', '重庆市', '潼南县', '', '402600', '023');
INSERT INTO `phpcms_city` VALUES (73, '中华人民共和国', '重庆市', '铜梁县', '', '402500', '023');
INSERT INTO `phpcms_city` VALUES (74, '中华人民共和国', '重庆市', '大足县', '', '402300', '023');
INSERT INTO `phpcms_city` VALUES (75, '中华人民共和国', '重庆市', '荣昌县', '', '402400', '023');
INSERT INTO `phpcms_city` VALUES (76, '中华人民共和国', '重庆市', '璧山县', '', '402700', '023');
INSERT INTO `phpcms_city` VALUES (77, '中华人民共和国', '重庆市', '梁平县', '', '405200', '023');
INSERT INTO `phpcms_city` VALUES (78, '中华人民共和国', '重庆市', '城口县', '', '405900', '023');
INSERT INTO `phpcms_city` VALUES (79, '中华人民共和国', '重庆市', '丰都县', '', '408200', '023');
INSERT INTO `phpcms_city` VALUES (80, '中华人民共和国', '重庆市', '垫江县', '', '408300', '023');
INSERT INTO `phpcms_city` VALUES (81, '中华人民共和国', '重庆市', '武隆县', '', '408500', '023');
INSERT INTO `phpcms_city` VALUES (82, '中华人民共和国', '重庆市', '忠县', '', '404300', '023');
INSERT INTO `phpcms_city` VALUES (83, '中华人民共和国', '重庆市', '开县', '', '405400', '023');
INSERT INTO `phpcms_city` VALUES (84, '中华人民共和国', '重庆市', '云阳县', '', '404500', '023');
INSERT INTO `phpcms_city` VALUES (85, '中华人民共和国', '重庆市', '奉节县', '', '404600', '023');
INSERT INTO `phpcms_city` VALUES (86, '中华人民共和国', '重庆市', '巫山县', '', '404700', '023');
INSERT INTO `phpcms_city` VALUES (87, '中华人民共和国', '重庆市', '巫溪县', '', '405800', '023');
INSERT INTO `phpcms_city` VALUES (88, '中华人民共和国', '重庆市', '石柱土家族自治县', '', '409100', '023');
INSERT INTO `phpcms_city` VALUES (89, '中华人民共和国', '重庆市', '秀山土家族苗族自治县', '', '409900', '023');
INSERT INTO `phpcms_city` VALUES (90, '中华人民共和国', '重庆市', '酉阳土家族苗族自治县', '', '409800', '023');
INSERT INTO `phpcms_city` VALUES (91, '中华人民共和国', '重庆市', '彭水苗族土家族自治县', '', '409600', '023');
INSERT INTO `phpcms_city` VALUES (92, '中华人民共和国', '重庆市', '江津市', '', '402200', '023');
INSERT INTO `phpcms_city` VALUES (93, '中华人民共和国', '重庆市', '合川市', '', '401500', '023');
INSERT INTO `phpcms_city` VALUES (94, '中华人民共和国', '重庆市', '永川市', '', '402100', '023');
INSERT INTO `phpcms_city` VALUES (95, '中华人民共和国', '重庆市', '南川市', '', '408400', '023');
INSERT INTO `phpcms_city` VALUES (96, '中华人民共和国', '河北省', '石家庄市', '长安区', '050000', '0311');
INSERT INTO `phpcms_city` VALUES (97, '中华人民共和国', '河北省', '石家庄市', '桥东区', '050000', '0311');
INSERT INTO `phpcms_city` VALUES (98, '中华人民共和国', '河北省', '石家庄市', '桥西区', '050000', '0311');
INSERT INTO `phpcms_city` VALUES (99, '中华人民共和国', '河北省', '石家庄市', '新华区', '050000', '0311');
INSERT INTO `phpcms_city` VALUES (100, '中华人民共和国', '河北省', '石家庄市', '井陉矿区', '050100', '0311');
INSERT INTO `phpcms_city` VALUES (101, '中华人民共和国', '河北省', '石家庄市', '裕华区', '050000', '0311');
INSERT INTO `phpcms_city` VALUES (102, '中华人民共和国', '河北省', '石家庄市', '井陉县', '050300', '0311');
INSERT INTO `phpcms_city` VALUES (103, '中华人民共和国', '河北省', '石家庄市', '正定县', '050800', '0311');
INSERT INTO `phpcms_city` VALUES (104, '中华人民共和国', '河北省', '石家庄市', '栾城县', '051430', '0311');
INSERT INTO `phpcms_city` VALUES (105, '中华人民共和国', '河北省', '石家庄市', '行唐县', '050600', '0311');
INSERT INTO `phpcms_city` VALUES (106, '中华人民共和国', '河北省', '石家庄市', '灵寿县', '050500', '0311');
INSERT INTO `phpcms_city` VALUES (107, '中华人民共和国', '河北省', '石家庄市', '高邑县', '051330', '0311');
INSERT INTO `phpcms_city` VALUES (108, '中华人民共和国', '河北省', '石家庄市', '深泽县', '052500', '0311');
INSERT INTO `phpcms_city` VALUES (109, '中华人民共和国', '河北省', '石家庄市', '赞皇县', '051230', '0311');
INSERT INTO `phpcms_city` VALUES (110, '中华人民共和国', '河北省', '石家庄市', '无极县', '052400', '0311');
INSERT INTO `phpcms_city` VALUES (111, '中华人民共和国', '河北省', '石家庄市', '平山县', '050400', '0311');
INSERT INTO `phpcms_city` VALUES (112, '中华人民共和国', '河北省', '石家庄市', '元氏县', '051130', '0311');
INSERT INTO `phpcms_city` VALUES (113, '中华人民共和国', '河北省', '石家庄市', '赵县', '051530', '0311');
INSERT INTO `phpcms_city` VALUES (114, '中华人民共和国', '河北省', '石家庄市', '辛集市', '052300', '0311');
INSERT INTO `phpcms_city` VALUES (115, '中华人民共和国', '河北省', '石家庄市', '藁城市', '052160', '0311');
INSERT INTO `phpcms_city` VALUES (116, '中华人民共和国', '河北省', '石家庄市', '晋州市', '052200', '0311');
INSERT INTO `phpcms_city` VALUES (117, '中华人民共和国', '河北省', '石家庄市', '新乐市', '050700', '0311');
INSERT INTO `phpcms_city` VALUES (118, '中华人民共和国', '河北省', '石家庄市', '鹿泉市', '050200', '0311');
INSERT INTO `phpcms_city` VALUES (119, '中华人民共和国', '河北省', '唐山市', '路南区', '063000', '0315');
INSERT INTO `phpcms_city` VALUES (120, '中华人民共和国', '河北省', '唐山市', '路北区', '063000', '0315');
INSERT INTO `phpcms_city` VALUES (121, '中华人民共和国', '河北省', '唐山市', '古冶区', '063100', '0315');
INSERT INTO `phpcms_city` VALUES (122, '中华人民共和国', '河北省', '唐山市', '开平区', '063000', '0315');
INSERT INTO `phpcms_city` VALUES (123, '中华人民共和国', '河北省', '唐山市', '丰南区', '063300', '0315');
INSERT INTO `phpcms_city` VALUES (124, '中华人民共和国', '河北省', '唐山市', '丰润区', '063000', '0315');
INSERT INTO `phpcms_city` VALUES (125, '中华人民共和国', '河北省', '唐山市', '滦县', '063700', '0315');
INSERT INTO `phpcms_city` VALUES (126, '中华人民共和国', '河北省', '唐山市', '滦南县', '063500', '0315');
INSERT INTO `phpcms_city` VALUES (127, '中华人民共和国', '河北省', '唐山市', '乐亭县', '063600', '0315');
INSERT INTO `phpcms_city` VALUES (128, '中华人民共和国', '河北省', '唐山市', '迁西县', '064300', '0315');
INSERT INTO `phpcms_city` VALUES (129, '中华人民共和国', '河北省', '唐山市', '玉田县', '064100', '0315');
INSERT INTO `phpcms_city` VALUES (130, '中华人民共和国', '河北省', '唐山市', '唐海县', '063200', '0315');
INSERT INTO `phpcms_city` VALUES (131, '中华人民共和国', '河北省', '唐山市', '遵化市', '064200', '0315');
INSERT INTO `phpcms_city` VALUES (132, '中华人民共和国', '河北省', '唐山市', '迁安市', '064400', '0315');
INSERT INTO `phpcms_city` VALUES (133, '中华人民共和国', '河北省', '秦皇岛市', '海港区', '066000', '0335');
INSERT INTO `phpcms_city` VALUES (134, '中华人民共和国', '河北省', '秦皇岛市', '山海关区', '066200', '0335');
INSERT INTO `phpcms_city` VALUES (135, '中华人民共和国', '河北省', '秦皇岛市', '北戴河区', '066300', '0335');
INSERT INTO `phpcms_city` VALUES (136, '中华人民共和国', '河北省', '秦皇岛市', '青龙满族自治县', '066500', '0335');
INSERT INTO `phpcms_city` VALUES (137, '中华人民共和国', '河北省', '秦皇岛市', '昌黎县', '066600', '0335');
INSERT INTO `phpcms_city` VALUES (138, '中华人民共和国', '河北省', '秦皇岛市', '抚宁县', '066300', '0335');
INSERT INTO `phpcms_city` VALUES (139, '中华人民共和国', '河北省', '秦皇岛市', '卢龙县', '066400', '0335');
INSERT INTO `phpcms_city` VALUES (140, '中华人民共和国', '河北省', '邯郸市', '邯山区', '056000', '0310');
INSERT INTO `phpcms_city` VALUES (141, '中华人民共和国', '河北省', '邯郸市', '丛台区', '056000', '0310');
INSERT INTO `phpcms_city` VALUES (142, '中华人民共和国', '河北省', '邯郸市', '复兴区', '056000', '0310');
INSERT INTO `phpcms_city` VALUES (143, '中华人民共和国', '河北省', '邯郸市', '峰峰矿区', '056200', '0310');
INSERT INTO `phpcms_city` VALUES (144, '中华人民共和国', '河北省', '邯郸市', '邯郸县', '056000', '0310');
INSERT INTO `phpcms_city` VALUES (145, '中华人民共和国', '河北省', '邯郸市', '临漳县', '056600', '0310');
INSERT INTO `phpcms_city` VALUES (146, '中华人民共和国', '河北省', '邯郸市', '成安县', '056700', '0310');
INSERT INTO `phpcms_city` VALUES (147, '中华人民共和国', '河北省', '邯郸市', '大名县', '056900', '0310');
INSERT INTO `phpcms_city` VALUES (148, '中华人民共和国', '河北省', '邯郸市', '涉县', '056400', '0310');
INSERT INTO `phpcms_city` VALUES (149, '中华人民共和国', '河北省', '邯郸市', '磁县', '056500', '0310');
INSERT INTO `phpcms_city` VALUES (150, '中华人民共和国', '河北省', '邯郸市', '肥乡县', '057550', '0310');
INSERT INTO `phpcms_city` VALUES (151, '中华人民共和国', '河北省', '邯郸市', '永年县', '057150', '0310');
INSERT INTO `phpcms_city` VALUES (152, '中华人民共和国', '河北省', '邯郸市', '邱县', '057450', '0310');
INSERT INTO `phpcms_city` VALUES (153, '中华人民共和国', '河北省', '邯郸市', '鸡泽县', '057350', '0310');
INSERT INTO `phpcms_city` VALUES (154, '中华人民共和国', '河北省', '邯郸市', '广平县', '057650', '0310');
INSERT INTO `phpcms_city` VALUES (155, '中华人民共和国', '河北省', '邯郸市', '馆陶县', '057750', '0310');
INSERT INTO `phpcms_city` VALUES (156, '中华人民共和国', '河北省', '邯郸市', '魏县', '056800', '0310');
INSERT INTO `phpcms_city` VALUES (157, '中华人民共和国', '河北省', '邯郸市', '曲周县', '057250', '0310');
INSERT INTO `phpcms_city` VALUES (158, '中华人民共和国', '河北省', '邯郸市', '武安市', '056300', '0310');
INSERT INTO `phpcms_city` VALUES (159, '中华人民共和国', '河北省', '邢台市', '桥东区', '054000', '0319');
INSERT INTO `phpcms_city` VALUES (160, '中华人民共和国', '河北省', '邢台市', '桥西区', '054000', '0319');
INSERT INTO `phpcms_city` VALUES (161, '中华人民共和国', '河北省', '邢台市', '邢台县', '054000', '0319');
INSERT INTO `phpcms_city` VALUES (162, '中华人民共和国', '河北省', '邢台市', '临城县', '054300', '0319');
INSERT INTO `phpcms_city` VALUES (163, '中华人民共和国', '河北省', '邢台市', '内丘县', '054200', '0319');
INSERT INTO `phpcms_city` VALUES (164, '中华人民共和国', '河北省', '邢台市', '柏乡县', '055450', '0319');
INSERT INTO `phpcms_city` VALUES (165, '中华人民共和国', '河北省', '邢台市', '隆尧县', '055350', '0319');
INSERT INTO `phpcms_city` VALUES (166, '中华人民共和国', '河北省', '邢台市', '任县', '055150', '0319');
INSERT INTO `phpcms_city` VALUES (167, '中华人民共和国', '河北省', '邢台市', '南和县', '054400', '0319');
INSERT INTO `phpcms_city` VALUES (168, '中华人民共和国', '河北省', '邢台市', '宁晋县', '055550', '0319');
INSERT INTO `phpcms_city` VALUES (169, '中华人民共和国', '河北省', '邢台市', '巨鹿县', '055250', '0319');
INSERT INTO `phpcms_city` VALUES (170, '中华人民共和国', '河北省', '邢台市', '新河县', '051730', '0319');
INSERT INTO `phpcms_city` VALUES (171, '中华人民共和国', '河北省', '邢台市', '广宗县', '054600', '0319');
INSERT INTO `phpcms_city` VALUES (172, '中华人民共和国', '河北省', '邢台市', '平乡县', '054500', '0319');
INSERT INTO `phpcms_city` VALUES (173, '中华人民共和国', '河北省', '邢台市', '威县', '054700', '0319');
INSERT INTO `phpcms_city` VALUES (174, '中华人民共和国', '河北省', '邢台市', '清河县', '054800', '0319');
INSERT INTO `phpcms_city` VALUES (175, '中华人民共和国', '河北省', '邢台市', '临西县', '054900', '0319');
INSERT INTO `phpcms_city` VALUES (176, '中华人民共和国', '河北省', '邢台市', '南宫市', '051800', '0319');
INSERT INTO `phpcms_city` VALUES (177, '中华人民共和国', '河北省', '邢台市', '沙河市', '054100', '0319');
INSERT INTO `phpcms_city` VALUES (178, '中华人民共和国', '河北省', '保定市', '新市区', '071000', '0312');
INSERT INTO `phpcms_city` VALUES (179, '中华人民共和国', '河北省', '保定市', '北市区', '071000', '0312');
INSERT INTO `phpcms_city` VALUES (180, '中华人民共和国', '河北省', '保定市', '南市区', '071000', '0312');
INSERT INTO `phpcms_city` VALUES (181, '中华人民共和国', '河北省', '保定市', '满城县', '072150', '0312');
INSERT INTO `phpcms_city` VALUES (182, '中华人民共和国', '河北省', '保定市', '清苑县', '071100', '0312');
INSERT INTO `phpcms_city` VALUES (183, '中华人民共和国', '河北省', '保定市', '涞水县', '074100', '0312');
INSERT INTO `phpcms_city` VALUES (184, '中华人民共和国', '河北省', '保定市', '阜平县', '073200', '0312');
INSERT INTO `phpcms_city` VALUES (185, '中华人民共和国', '河北省', '保定市', '徐水县', '072550', '0312');
INSERT INTO `phpcms_city` VALUES (186, '中华人民共和国', '河北省', '保定市', '定兴县', '072650', '0312');
INSERT INTO `phpcms_city` VALUES (187, '中华人民共和国', '河北省', '保定市', '唐县', '072350', '0312');
INSERT INTO `phpcms_city` VALUES (188, '中华人民共和国', '河北省', '保定市', '高阳县', '071500', '0312');
INSERT INTO `phpcms_city` VALUES (189, '中华人民共和国', '河北省', '保定市', '容城县', '071700', '0312');
INSERT INTO `phpcms_city` VALUES (190, '中华人民共和国', '河北省', '保定市', '涞源县', '102900', '0312');
INSERT INTO `phpcms_city` VALUES (191, '中华人民共和国', '河北省', '保定市', '望都县', '072450', '0312');
INSERT INTO `phpcms_city` VALUES (192, '中华人民共和国', '河北省', '保定市', '安新县', '071600', '0312');
INSERT INTO `phpcms_city` VALUES (193, '中华人民共和国', '河北省', '保定市', '易县', '074200', '0312');
INSERT INTO `phpcms_city` VALUES (194, '中华人民共和国', '河北省', '保定市', '曲阳县', '073100', '0312');
INSERT INTO `phpcms_city` VALUES (195, '中华人民共和国', '河北省', '保定市', '蠡县', '071400', '0312');
INSERT INTO `phpcms_city` VALUES (196, '中华人民共和国', '河北省', '保定市', '顺平县', '072250', '0312');
INSERT INTO `phpcms_city` VALUES (197, '中华人民共和国', '河北省', '保定市', '博野县', '071300', '0312');
INSERT INTO `phpcms_city` VALUES (198, '中华人民共和国', '河北省', '保定市', '雄县', '071800', '0312');
INSERT INTO `phpcms_city` VALUES (199, '中华人民共和国', '河北省', '保定市', '涿州市', '072750', '0312');
INSERT INTO `phpcms_city` VALUES (200, '中华人民共和国', '河北省', '保定市', '定州市', '073000', '0312');
INSERT INTO `phpcms_city` VALUES (201, '中华人民共和国', '河北省', '保定市', '安国市', '071200', '0312');
INSERT INTO `phpcms_city` VALUES (202, '中华人民共和国', '河北省', '保定市', '高碑店市', '074000', '0312');
INSERT INTO `phpcms_city` VALUES (203, '中华人民共和国', '河北省', '张家口市', '桥东区', '075000', '0313');
INSERT INTO `phpcms_city` VALUES (204, '中华人民共和国', '河北省', '张家口市', '桥西区', '075000', '0313');
INSERT INTO `phpcms_city` VALUES (205, '中华人民共和国', '河北省', '张家口市', '宣化区', '075000', '0313');
INSERT INTO `phpcms_city` VALUES (206, '中华人民共和国', '河北省', '张家口市', '下花园区', '075300', '0313');
INSERT INTO `phpcms_city` VALUES (207, '中华人民共和国', '河北省', '张家口市', '宣化县', '075100', '0313');
INSERT INTO `phpcms_city` VALUES (208, '中华人民共和国', '河北省', '张家口市', '张北县', '076450', '0313');
INSERT INTO `phpcms_city` VALUES (209, '中华人民共和国', '河北省', '张家口市', '康保县', '076650', '0313');
INSERT INTO `phpcms_city` VALUES (210, '中华人民共和国', '河北省', '张家口市', '沽源县', '076550', '0313');
INSERT INTO `phpcms_city` VALUES (211, '中华人民共和国', '河北省', '张家口市', '尚义县', '076750', '0313');
INSERT INTO `phpcms_city` VALUES (212, '中华人民共和国', '河北省', '张家口市', '蔚县', '075700', '0313');
INSERT INTO `phpcms_city` VALUES (213, '中华人民共和国', '河北省', '张家口市', '阳原县', '075800', '0313');
INSERT INTO `phpcms_city` VALUES (214, '中华人民共和国', '河北省', '张家口市', '怀安县', '076150', '0313');
INSERT INTO `phpcms_city` VALUES (215, '中华人民共和国', '河北省', '张家口市', '万全县', '076250', '0313');
INSERT INTO `phpcms_city` VALUES (216, '中华人民共和国', '河北省', '张家口市', '怀来县', '075400', '0313');
INSERT INTO `phpcms_city` VALUES (217, '中华人民共和国', '河北省', '张家口市', '涿鹿县', '075600', '0313');
INSERT INTO `phpcms_city` VALUES (218, '中华人民共和国', '河北省', '张家口市', '赤城县', '075500', '0313');
INSERT INTO `phpcms_city` VALUES (219, '中华人民共和国', '河北省', '张家口市', '崇礼县', '076350', '0313');
INSERT INTO `phpcms_city` VALUES (220, '中华人民共和国', '河北省', '承德市', '双桥区', '067000', '0314');
INSERT INTO `phpcms_city` VALUES (221, '中华人民共和国', '河北省', '承德市', '双滦区', '067000', '0314');
INSERT INTO `phpcms_city` VALUES (222, '中华人民共和国', '河北省', '承德市', '鹰手营子矿区', '067200', '0314');
INSERT INTO `phpcms_city` VALUES (223, '中华人民共和国', '河北省', '承德市', '承德县', '067400', '0314');
INSERT INTO `phpcms_city` VALUES (224, '中华人民共和国', '河北省', '承德市', '兴隆县', '067300', '0314');
INSERT INTO `phpcms_city` VALUES (225, '中华人民共和国', '河北省', '承德市', '平泉县', '067500', '0314');
INSERT INTO `phpcms_city` VALUES (226, '中华人民共和国', '河北省', '承德市', '滦平县', '068250', '0314');
INSERT INTO `phpcms_city` VALUES (227, '中华人民共和国', '河北省', '承德市', '隆化县', '068150', '0314');
INSERT INTO `phpcms_city` VALUES (228, '中华人民共和国', '河北省', '承德市', '丰宁满族自治县', '068350', '0314');
INSERT INTO `phpcms_city` VALUES (229, '中华人民共和国', '河北省', '承德市', '宽城满族自治县', '067600', '0314');
INSERT INTO `phpcms_city` VALUES (230, '中华人民共和国', '河北省', '承德市', '围场满族蒙古族自治县', '068450', '0314');
INSERT INTO `phpcms_city` VALUES (231, '中华人民共和国', '河北省', '沧州市', '新华区', '061000', '0317');
INSERT INTO `phpcms_city` VALUES (232, '中华人民共和国', '河北省', '沧州市', '运河区', '061000', '0317');
INSERT INTO `phpcms_city` VALUES (233, '中华人民共和国', '河北省', '沧州市', '沧县', '061000', '0317');
INSERT INTO `phpcms_city` VALUES (234, '中华人民共和国', '河北省', '沧州市', '青县', '062650', '0317');
INSERT INTO `phpcms_city` VALUES (235, '中华人民共和国', '河北省', '沧州市', '东光县', '061600', '0317');
INSERT INTO `phpcms_city` VALUES (236, '中华人民共和国', '河北省', '沧州市', '海兴县', '061200', '0317');
INSERT INTO `phpcms_city` VALUES (237, '中华人民共和国', '河北省', '沧州市', '盐山县', '061300', '0317');
INSERT INTO `phpcms_city` VALUES (238, '中华人民共和国', '河北省', '沧州市', '肃宁县', '062350', '0317');
INSERT INTO `phpcms_city` VALUES (239, '中华人民共和国', '河北省', '沧州市', '南皮县', '061500', '0317');
INSERT INTO `phpcms_city` VALUES (240, '中华人民共和国', '河北省', '沧州市', '吴桥县', '061800', '0317');
INSERT INTO `phpcms_city` VALUES (241, '中华人民共和国', '河北省', '沧州市', '献县', '062250', '0317');
INSERT INTO `phpcms_city` VALUES (242, '中华人民共和国', '河北省', '沧州市', '孟村回族自治县', '061400', '0317');
INSERT INTO `phpcms_city` VALUES (243, '中华人民共和国', '河北省', '沧州市', '泊头市', '062150', '0317');
INSERT INTO `phpcms_city` VALUES (244, '中华人民共和国', '河北省', '沧州市', '任丘市', '062550', '0317');
INSERT INTO `phpcms_city` VALUES (245, '中华人民共和国', '河北省', '沧州市', '黄骅市', '061100', '0317');
INSERT INTO `phpcms_city` VALUES (246, '中华人民共和国', '河北省', '沧州市', '河间市', '062450', '0317');
INSERT INTO `phpcms_city` VALUES (247, '中华人民共和国', '河北省', '廊坊市', '安次区', '065000', '0316');
INSERT INTO `phpcms_city` VALUES (248, '中华人民共和国', '河北省', '廊坊市', '广阳区', '065000', '0316');
INSERT INTO `phpcms_city` VALUES (249, '中华人民共和国', '河北省', '廊坊市', '固安县', '065500', '0316');
INSERT INTO `phpcms_city` VALUES (250, '中华人民共和国', '河北省', '廊坊市', '永清县', '065600', '0316');
INSERT INTO `phpcms_city` VALUES (251, '中华人民共和国', '河北省', '廊坊市', '香河县', '065400', '0316');
INSERT INTO `phpcms_city` VALUES (252, '中华人民共和国', '河北省', '廊坊市', '大城县', '065900', '0316');
INSERT INTO `phpcms_city` VALUES (253, '中华人民共和国', '河北省', '廊坊市', '文安县', '065800', '0316');
INSERT INTO `phpcms_city` VALUES (254, '中华人民共和国', '河北省', '廊坊市', '大厂回族自治县', '065300', '0316');
INSERT INTO `phpcms_city` VALUES (255, '中华人民共和国', '河北省', '廊坊市', '霸州市', '065700', '0316');
INSERT INTO `phpcms_city` VALUES (256, '中华人民共和国', '河北省', '廊坊市', '三河市', '065200', '0316');
INSERT INTO `phpcms_city` VALUES (257, '中华人民共和国', '河北省', '衡水市', '桃城区', '053000', '0318');
INSERT INTO `phpcms_city` VALUES (258, '中华人民共和国', '河北省', '衡水市', '枣强县', '053100', '0318');
INSERT INTO `phpcms_city` VALUES (259, '中华人民共和国', '河北省', '衡水市', '武邑县', '053400', '0318');
INSERT INTO `phpcms_city` VALUES (260, '中华人民共和国', '河北省', '衡水市', '武强县', '053300', '0318');
INSERT INTO `phpcms_city` VALUES (261, '中华人民共和国', '河北省', '衡水市', '饶阳县', '053900', '0318');
INSERT INTO `phpcms_city` VALUES (262, '中华人民共和国', '河北省', '衡水市', '安平县', '053600', '0318');
INSERT INTO `phpcms_city` VALUES (263, '中华人民共和国', '河北省', '衡水市', '故城县', '253800', '0318');
INSERT INTO `phpcms_city` VALUES (264, '中华人民共和国', '河北省', '衡水市', '景县', '053500', '0318');
INSERT INTO `phpcms_city` VALUES (265, '中华人民共和国', '河北省', '衡水市', '阜城县', '053700', '0318');
INSERT INTO `phpcms_city` VALUES (266, '中华人民共和国', '河北省', '衡水市', '冀州市', '053200', '0318');
INSERT INTO `phpcms_city` VALUES (267, '中华人民共和国', '河北省', '衡水市', '深州市', '052800', '0318');
INSERT INTO `phpcms_city` VALUES (268, '中华人民共和国', '山西省', '太原市', '小店区', '030000', '0351');
INSERT INTO `phpcms_city` VALUES (269, '中华人民共和国', '山西省', '太原市', '迎泽区', '030000', '0351');
INSERT INTO `phpcms_city` VALUES (270, '中华人民共和国', '山西省', '太原市', '杏花岭区', '030000', '0351');
INSERT INTO `phpcms_city` VALUES (271, '中华人民共和国', '山西省', '太原市', '尖草坪区', '030000', '0351');
INSERT INTO `phpcms_city` VALUES (272, '中华人民共和国', '山西省', '太原市', '万柏林区', '030000', '0351');
INSERT INTO `phpcms_city` VALUES (273, '中华人民共和国', '山西省', '太原市', '晋源区', '030000', '0351');
INSERT INTO `phpcms_city` VALUES (274, '中华人民共和国', '山西省', '太原市', '清徐县', '030400', '0351');
INSERT INTO `phpcms_city` VALUES (275, '中华人民共和国', '山西省', '太原市', '阳曲县', '030100', '0351');
INSERT INTO `phpcms_city` VALUES (276, '中华人民共和国', '山西省', '太原市', '娄烦县', '030300', '0351');
INSERT INTO `phpcms_city` VALUES (277, '中华人民共和国', '山西省', '太原市', '古交市', '030200', '0351');
INSERT INTO `phpcms_city` VALUES (278, '中华人民共和国', '山西省', '大同市', '城区', '037000', '0352');
INSERT INTO `phpcms_city` VALUES (279, '中华人民共和国', '山西省', '大同市', '矿区', '037000', '0352');
INSERT INTO `phpcms_city` VALUES (280, '中华人民共和国', '山西省', '大同市', '南郊区', '037000', '0352');
INSERT INTO `phpcms_city` VALUES (281, '中华人民共和国', '山西省', '大同市', '新荣区', '037000', '0352');
INSERT INTO `phpcms_city` VALUES (282, '中华人民共和国', '山西省', '大同市', '阳高县', '038100', '0352');
INSERT INTO `phpcms_city` VALUES (283, '中华人民共和国', '山西省', '大同市', '天镇县', '038200', '0352');
INSERT INTO `phpcms_city` VALUES (284, '中华人民共和国', '山西省', '大同市', '广灵县', '037500', '0352');
INSERT INTO `phpcms_city` VALUES (285, '中华人民共和国', '山西省', '大同市', '灵丘县', '034400', '0352');
INSERT INTO `phpcms_city` VALUES (286, '中华人民共和国', '山西省', '大同市', '浑源县', '037400', '0352');
INSERT INTO `phpcms_city` VALUES (287, '中华人民共和国', '山西省', '大同市', '左云县', '037100', '0352');
INSERT INTO `phpcms_city` VALUES (288, '中华人民共和国', '山西省', '大同市', '大同县', '037300', '0352');
INSERT INTO `phpcms_city` VALUES (289, '中华人民共和国', '山西省', '阳泉市', '城区', '045000', '0353');
INSERT INTO `phpcms_city` VALUES (290, '中华人民共和国', '山西省', '阳泉市', '矿区', '045000', '0353');
INSERT INTO `phpcms_city` VALUES (291, '中华人民共和国', '山西省', '阳泉市', '郊区', '045000', '0353');
INSERT INTO `phpcms_city` VALUES (292, '中华人民共和国', '山西省', '阳泉市', '平定县', '045200', '0353');
INSERT INTO `phpcms_city` VALUES (293, '中华人民共和国', '山西省', '阳泉市', '盂县', '045100', '0353');
INSERT INTO `phpcms_city` VALUES (294, '中华人民共和国', '山西省', '长治市', '城区', '046000', '0355');
INSERT INTO `phpcms_city` VALUES (295, '中华人民共和国', '山西省', '长治市', '郊区', '046000', '0355');
INSERT INTO `phpcms_city` VALUES (296, '中华人民共和国', '山西省', '长治市', '长治县', '047100', '0355');
INSERT INTO `phpcms_city` VALUES (297, '中华人民共和国', '山西省', '长治市', '襄垣县', '046200', '0355');
INSERT INTO `phpcms_city` VALUES (298, '中华人民共和国', '山西省', '长治市', '屯留县', '046100', '0355');
INSERT INTO `phpcms_city` VALUES (299, '中华人民共和国', '山西省', '长治市', '平顺县', '047400', '0355');
INSERT INTO `phpcms_city` VALUES (300, '中华人民共和国', '山西省', '长治市', '黎城县', '047600', '0355');
INSERT INTO `phpcms_city` VALUES (301, '中华人民共和国', '山西省', '长治市', '壶关县', '047300', '0355');
INSERT INTO `phpcms_city` VALUES (302, '中华人民共和国', '山西省', '长治市', '长子县', '046600', '0355');
INSERT INTO `phpcms_city` VALUES (303, '中华人民共和国', '山西省', '长治市', '武乡县', '046300', '0355');
INSERT INTO `phpcms_city` VALUES (304, '中华人民共和国', '山西省', '长治市', '沁县', '046400', '0355');
INSERT INTO `phpcms_city` VALUES (305, '中华人民共和国', '山西省', '长治市', '沁源县', '046500', '0355');
INSERT INTO `phpcms_city` VALUES (306, '中华人民共和国', '山西省', '长治市', '潞城市', '047500', '0355');
INSERT INTO `phpcms_city` VALUES (307, '中华人民共和国', '山西省', '晋城市', '城区', '048000', '0356');
INSERT INTO `phpcms_city` VALUES (308, '中华人民共和国', '山西省', '晋城市', '沁水县', '048200', '0356');
INSERT INTO `phpcms_city` VALUES (309, '中华人民共和国', '山西省', '晋城市', '阳城县', '048100', '0356');
INSERT INTO `phpcms_city` VALUES (310, '中华人民共和国', '山西省', '晋城市', '陵川县', '048300', '0356');
INSERT INTO `phpcms_city` VALUES (311, '中华人民共和国', '山西省', '晋城市', '泽州县', '048000', '0356');
INSERT INTO `phpcms_city` VALUES (312, '中华人民共和国', '山西省', '晋城市', '高平市', '046700', '0356');
INSERT INTO `phpcms_city` VALUES (313, '中华人民共和国', '山西省', '朔州市', '朔城区', '038500', '0349');
INSERT INTO `phpcms_city` VALUES (314, '中华人民共和国', '山西省', '朔州市', '平鲁区', '038500', '0349');
INSERT INTO `phpcms_city` VALUES (315, '中华人民共和国', '山西省', '朔州市', '山阴县', '038400', '0349');
INSERT INTO `phpcms_city` VALUES (316, '中华人民共和国', '山西省', '朔州市', '应县', '037600', '0349');
INSERT INTO `phpcms_city` VALUES (317, '中华人民共和国', '山西省', '朔州市', '右玉县', '037200', '0349');
INSERT INTO `phpcms_city` VALUES (318, '中华人民共和国', '山西省', '朔州市', '怀仁县', '038300', '0349');
INSERT INTO `phpcms_city` VALUES (319, '中华人民共和国', '山西省', '晋中市', '榆次区', '030600', '0354');
INSERT INTO `phpcms_city` VALUES (320, '中华人民共和国', '山西省', '晋中市', '榆社县', '031800', '0354');
INSERT INTO `phpcms_city` VALUES (321, '中华人民共和国', '山西省', '晋中市', '左权县', '032600', '0354');
INSERT INTO `phpcms_city` VALUES (322, '中华人民共和国', '山西省', '晋中市', '和顺县', '032700', '0354');
INSERT INTO `phpcms_city` VALUES (323, '中华人民共和国', '山西省', '晋中市', '昔阳县', '045300', '0354');
INSERT INTO `phpcms_city` VALUES (324, '中华人民共和国', '山西省', '晋中市', '寿阳县', '031700', '0354');
INSERT INTO `phpcms_city` VALUES (325, '中华人民共和国', '山西省', '晋中市', '太谷县', '030800', '0354');
INSERT INTO `phpcms_city` VALUES (326, '中华人民共和国', '山西省', '晋中市', '祁县', '030900', '0354');
INSERT INTO `phpcms_city` VALUES (327, '中华人民共和国', '山西省', '晋中市', '平遥县', '031100', '0354');
INSERT INTO `phpcms_city` VALUES (328, '中华人民共和国', '山西省', '晋中市', '灵石县', '031300', '0354');
INSERT INTO `phpcms_city` VALUES (329, '中华人民共和国', '山西省', '晋中市', '介休市', '031200', '0354');
INSERT INTO `phpcms_city` VALUES (330, '中华人民共和国', '山西省', '运城市', '盐湖区', '044000', '0359');
INSERT INTO `phpcms_city` VALUES (331, '中华人民共和国', '山西省', '运城市', '临猗县', '044100', '0359');
INSERT INTO `phpcms_city` VALUES (332, '中华人民共和国', '山西省', '运城市', '万荣县', '044200', '0359');
INSERT INTO `phpcms_city` VALUES (333, '中华人民共和国', '山西省', '运城市', '闻喜县', '043800', '0359');
INSERT INTO `phpcms_city` VALUES (334, '中华人民共和国', '山西省', '运城市', '稷山县', '043200', '0359');
INSERT INTO `phpcms_city` VALUES (335, '中华人民共和国', '山西省', '运城市', '新绛县', '043100', '0359');
INSERT INTO `phpcms_city` VALUES (336, '中华人民共和国', '山西省', '运城市', '绛县', '043600', '0359');
INSERT INTO `phpcms_city` VALUES (337, '中华人民共和国', '山西省', '运城市', '垣曲县', '043700', '0359');
INSERT INTO `phpcms_city` VALUES (338, '中华人民共和国', '山西省', '运城市', '夏县', '044400', '0359');
INSERT INTO `phpcms_city` VALUES (339, '中华人民共和国', '山西省', '运城市', '平陆县', '044300', '0359');
INSERT INTO `phpcms_city` VALUES (340, '中华人民共和国', '山西省', '运城市', '芮城县', '044600', '0359');
INSERT INTO `phpcms_city` VALUES (341, '中华人民共和国', '山西省', '运城市', '永济市', '044500', '0359');
INSERT INTO `phpcms_city` VALUES (342, '中华人民共和国', '山西省', '运城市', '河津市', '043300', '0359');
INSERT INTO `phpcms_city` VALUES (343, '中华人民共和国', '山西省', '忻州市', '忻府区', '034000', '0350');
INSERT INTO `phpcms_city` VALUES (344, '中华人民共和国', '山西省', '忻州市', '定襄县', '035400', '0350');
INSERT INTO `phpcms_city` VALUES (345, '中华人民共和国', '山西省', '忻州市', '五台县', '035500', '0350');
INSERT INTO `phpcms_city` VALUES (346, '中华人民共和国', '山西省', '忻州市', '代县', '034200', '0350');
INSERT INTO `phpcms_city` VALUES (347, '中华人民共和国', '山西省', '忻州市', '繁峙县', '034300', '0350');
INSERT INTO `phpcms_city` VALUES (348, '中华人民共和国', '山西省', '忻州市', '宁武县', '036000', '0350');
INSERT INTO `phpcms_city` VALUES (349, '中华人民共和国', '山西省', '忻州市', '静乐县', '035100', '0350');
INSERT INTO `phpcms_city` VALUES (350, '中华人民共和国', '山西省', '忻州市', '神池县', '036100', '0350');
INSERT INTO `phpcms_city` VALUES (351, '中华人民共和国', '山西省', '忻州市', '五寨县', '036200', '0350');
INSERT INTO `phpcms_city` VALUES (352, '中华人民共和国', '山西省', '忻州市', '岢岚县', '036300', '0350');
INSERT INTO `phpcms_city` VALUES (353, '中华人民共和国', '山西省', '忻州市', '河曲县', '036500', '0350');
INSERT INTO `phpcms_city` VALUES (354, '中华人民共和国', '山西省', '忻州市', '保德县', '036600', '0350');
INSERT INTO `phpcms_city` VALUES (355, '中华人民共和国', '山西省', '忻州市', '偏关县', '036400', '0350');
INSERT INTO `phpcms_city` VALUES (356, '中华人民共和国', '山西省', '忻州市', '原平市', '034100', '0350');
INSERT INTO `phpcms_city` VALUES (357, '中华人民共和国', '山西省', '临汾市', '尧都区', '041000', '0357');
INSERT INTO `phpcms_city` VALUES (358, '中华人民共和国', '山西省', '临汾市', '曲沃县', '043400', '0357');
INSERT INTO `phpcms_city` VALUES (359, '中华人民共和国', '山西省', '临汾市', '翼城县', '043500', '0357');
INSERT INTO `phpcms_city` VALUES (360, '中华人民共和国', '山西省', '临汾市', '襄汾县', '041500', '0357');
INSERT INTO `phpcms_city` VALUES (361, '中华人民共和国', '山西省', '临汾市', '洪洞县', '031600', '0357');
INSERT INTO `phpcms_city` VALUES (362, '中华人民共和国', '山西省', '临汾市', '古县', '042400', '0357');
INSERT INTO `phpcms_city` VALUES (363, '中华人民共和国', '山西省', '临汾市', '安泽县', '042500', '0357');
INSERT INTO `phpcms_city` VALUES (364, '中华人民共和国', '山西省', '临汾市', '浮山县', '042600', '0357');
INSERT INTO `phpcms_city` VALUES (365, '中华人民共和国', '山西省', '临汾市', '吉县', '042200', '0357');
INSERT INTO `phpcms_city` VALUES (366, '中华人民共和国', '山西省', '临汾市', '乡宁县', '042100', '0357');
INSERT INTO `phpcms_city` VALUES (367, '中华人民共和国', '山西省', '临汾市', '大宁县', '042300', '0357');
INSERT INTO `phpcms_city` VALUES (368, '中华人民共和国', '山西省', '临汾市', '隰县', '041300', '0357');
INSERT INTO `phpcms_city` VALUES (369, '中华人民共和国', '山西省', '临汾市', '永和县', '041400', '0357');
INSERT INTO `phpcms_city` VALUES (370, '中华人民共和国', '山西省', '临汾市', '蒲县', '041200', '0357');
INSERT INTO `phpcms_city` VALUES (371, '中华人民共和国', '山西省', '临汾市', '汾西县', '031500', '0357');
INSERT INTO `phpcms_city` VALUES (372, '中华人民共和国', '山西省', '临汾市', '侯马市', '043000', '0357');
INSERT INTO `phpcms_city` VALUES (373, '中华人民共和国', '山西省', '临汾市', '霍州市', '031400', '0357');
INSERT INTO `phpcms_city` VALUES (374, '中华人民共和国', '山西省', '吕梁市', '离石区', '033000', '0358');
INSERT INTO `phpcms_city` VALUES (375, '中华人民共和国', '山西省', '吕梁市', '文水县', '032100', '0358');
INSERT INTO `phpcms_city` VALUES (376, '中华人民共和国', '山西省', '吕梁市', '交城县', '030500', '0358');
INSERT INTO `phpcms_city` VALUES (377, '中华人民共和国', '山西省', '吕梁市', '兴县', '035300', '0358');
INSERT INTO `phpcms_city` VALUES (378, '中华人民共和国', '山西省', '吕梁市', '临县', '033200', '0358');
INSERT INTO `phpcms_city` VALUES (379, '中华人民共和国', '山西省', '吕梁市', '柳林县', '033300', '0358');
INSERT INTO `phpcms_city` VALUES (380, '中华人民共和国', '山西省', '吕梁市', '石楼县', '032500', '0358');
INSERT INTO `phpcms_city` VALUES (381, '中华人民共和国', '山西省', '吕梁市', '岚县', '035200', '0358');
INSERT INTO `phpcms_city` VALUES (382, '中华人民共和国', '山西省', '吕梁市', '方山县', '033100', '0358');
INSERT INTO `phpcms_city` VALUES (383, '中华人民共和国', '山西省', '吕梁市', '中阳县', '033400', '0358');
INSERT INTO `phpcms_city` VALUES (384, '中华人民共和国', '山西省', '吕梁市', '交口县', '032400', '0358');
INSERT INTO `phpcms_city` VALUES (385, '中华人民共和国', '山西省', '吕梁市', '孝义市', '032300', '0358');
INSERT INTO `phpcms_city` VALUES (386, '中华人民共和国', '山西省', '吕梁市', '汾阳市', '032200', '0358');
INSERT INTO `phpcms_city` VALUES (387, '中华人民共和国', '内蒙古自治区', '呼和浩特市', '新城区', '010000', '0471');
INSERT INTO `phpcms_city` VALUES (388, '中华人民共和国', '内蒙古自治区', '呼和浩特市', '回民区', '010000', '0471');
INSERT INTO `phpcms_city` VALUES (389, '中华人民共和国', '内蒙古自治区', '呼和浩特市', '玉泉区', '010000', '0471');
INSERT INTO `phpcms_city` VALUES (390, '中华人民共和国', '内蒙古自治区', '呼和浩特市', '赛罕区', '010000', '0471');
INSERT INTO `phpcms_city` VALUES (391, '中华人民共和国', '内蒙古自治区', '呼和浩特市', '土默特左旗', '010100', '0471');
INSERT INTO `phpcms_city` VALUES (392, '中华人民共和国', '内蒙古自治区', '呼和浩特市', '托克托县', '010200', '0471');
INSERT INTO `phpcms_city` VALUES (393, '中华人民共和国', '内蒙古自治区', '呼和浩特市', '和林格尔县', '011500', '0471');
INSERT INTO `phpcms_city` VALUES (394, '中华人民共和国', '内蒙古自治区', '呼和浩特市', '清水河县', '011600', '0471');
INSERT INTO `phpcms_city` VALUES (395, '中华人民共和国', '内蒙古自治区', '呼和浩特市', '武川县', '011700', '0471');
INSERT INTO `phpcms_city` VALUES (396, '中华人民共和国', '内蒙古自治区', '包头市', '东河区', '014000', '0472');
INSERT INTO `phpcms_city` VALUES (397, '中华人民共和国', '内蒙古自治区', '包头市', '昆都仑区', '014000', '0472');
INSERT INTO `phpcms_city` VALUES (398, '中华人民共和国', '内蒙古自治区', '包头市', '青山区', '014000', '0472');
INSERT INTO `phpcms_city` VALUES (399, '中华人民共和国', '内蒙古自治区', '包头市', '石拐区', '014000', '0472');
INSERT INTO `phpcms_city` VALUES (400, '中华人民共和国', '内蒙古自治区', '包头市', '白云矿区', '014000', '0472');
INSERT INTO `phpcms_city` VALUES (401, '中华人民共和国', '内蒙古自治区', '包头市', '九原区', '014000', '0472');
INSERT INTO `phpcms_city` VALUES (402, '中华人民共和国', '内蒙古自治区', '包头市', '土默特右旗', '014100', '0472');
INSERT INTO `phpcms_city` VALUES (403, '中华人民共和国', '内蒙古自治区', '包头市', '固阳县', '014200', '0472');
INSERT INTO `phpcms_city` VALUES (404, '中华人民共和国', '内蒙古自治区', '包头市', '达尔罕茂明安联合旗', '014500', '0472');
INSERT INTO `phpcms_city` VALUES (405, '中华人民共和国', '内蒙古自治区', '乌海市', '海勃湾区', '016000', '0473');
INSERT INTO `phpcms_city` VALUES (406, '中华人民共和国', '内蒙古自治区', '乌海市', '海南区', '016000', '0473');
INSERT INTO `phpcms_city` VALUES (407, '中华人民共和国', '内蒙古自治区', '乌海市', '乌达区', '016000', '0473');
INSERT INTO `phpcms_city` VALUES (408, '中华人民共和国', '内蒙古自治区', '赤峰市', '红山区', '024000', '0476');
INSERT INTO `phpcms_city` VALUES (409, '中华人民共和国', '内蒙古自治区', '赤峰市', '元宝山区', '024000', '0476');
INSERT INTO `phpcms_city` VALUES (410, '中华人民共和国', '内蒙古自治区', '赤峰市', '松山区', '024000', '0476');
INSERT INTO `phpcms_city` VALUES (411, '中华人民共和国', '内蒙古自治区', '赤峰市', '阿鲁科尔沁旗', '025500', '0476');
INSERT INTO `phpcms_city` VALUES (412, '中华人民共和国', '内蒙古自治区', '赤峰市', '巴林左旗', '025450', '0476');
INSERT INTO `phpcms_city` VALUES (413, '中华人民共和国', '内蒙古自治区', '赤峰市', '巴林右旗', '025150', '0476');
INSERT INTO `phpcms_city` VALUES (414, '中华人民共和国', '内蒙古自治区', '赤峰市', '林西县', '025250', '0476');
INSERT INTO `phpcms_city` VALUES (415, '中华人民共和国', '内蒙古自治区', '赤峰市', '克什克腾旗', '025350', '0476');
INSERT INTO `phpcms_city` VALUES (416, '中华人民共和国', '内蒙古自治区', '赤峰市', '翁牛特旗', '024500', '0476');
INSERT INTO `phpcms_city` VALUES (417, '中华人民共和国', '内蒙古自治区', '赤峰市', '喀喇沁旗', '024400', '0476');
INSERT INTO `phpcms_city` VALUES (418, '中华人民共和国', '内蒙古自治区', '赤峰市', '宁城县', '024200', '0476');
INSERT INTO `phpcms_city` VALUES (419, '中华人民共和国', '内蒙古自治区', '赤峰市', '敖汉旗', '024300', '0476');
INSERT INTO `phpcms_city` VALUES (420, '中华人民共和国', '内蒙古自治区', '通辽市', '科尔沁区', '028000', '0475');
INSERT INTO `phpcms_city` VALUES (421, '中华人民共和国', '内蒙古自治区', '通辽市', '科尔沁左翼中旗', '029300', '0475');
INSERT INTO `phpcms_city` VALUES (422, '中华人民共和国', '内蒙古自治区', '通辽市', '科尔沁左翼后旗', '028100', '0475');
INSERT INTO `phpcms_city` VALUES (423, '中华人民共和国', '内蒙古自治区', '通辽市', '开鲁县', '028400', '0475');
INSERT INTO `phpcms_city` VALUES (424, '中华人民共和国', '内蒙古自治区', '通辽市', '库伦旗', '028200', '0475');
INSERT INTO `phpcms_city` VALUES (425, '中华人民共和国', '内蒙古自治区', '通辽市', '奈曼旗', '028300', '0475');
INSERT INTO `phpcms_city` VALUES (426, '中华人民共和国', '内蒙古自治区', '通辽市', '扎鲁特旗', '029100', '0475');
INSERT INTO `phpcms_city` VALUES (427, '中华人民共和国', '内蒙古自治区', '通辽市', '霍林郭勒市', '029200', '0475');
INSERT INTO `phpcms_city` VALUES (428, '中华人民共和国', '内蒙古自治区', '鄂尔多斯市', '东胜区', '017000', '0477');
INSERT INTO `phpcms_city` VALUES (429, '中华人民共和国', '内蒙古自治区', '鄂尔多斯市', '达拉特旗', '014300', '0477');
INSERT INTO `phpcms_city` VALUES (430, '中华人民共和国', '内蒙古自治区', '鄂尔多斯市', '准格尔旗', '017100', '0477');
INSERT INTO `phpcms_city` VALUES (431, '中华人民共和国', '内蒙古自治区', '鄂尔多斯市', '鄂托克前旗', '016200', '0477');
INSERT INTO `phpcms_city` VALUES (432, '中华人民共和国', '内蒙古自治区', '鄂尔多斯市', '鄂托克旗', '016100', '0477');
INSERT INTO `phpcms_city` VALUES (433, '中华人民共和国', '内蒙古自治区', '鄂尔多斯市', '杭锦旗', '017400', '0477');
INSERT INTO `phpcms_city` VALUES (434, '中华人民共和国', '内蒙古自治区', '鄂尔多斯市', '乌审旗', '017300', '0477');
INSERT INTO `phpcms_city` VALUES (435, '中华人民共和国', '内蒙古自治区', '鄂尔多斯市', '伊金霍洛旗', '017200', '0477');
INSERT INTO `phpcms_city` VALUES (436, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '海拉尔区', '021000', '0470');
INSERT INTO `phpcms_city` VALUES (437, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '阿荣旗', '162750', '0470');
INSERT INTO `phpcms_city` VALUES (438, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '莫力达瓦达斡尔族自治旗', '162850', '0470');
INSERT INTO `phpcms_city` VALUES (439, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '鄂伦春自治旗', '022450', '0470');
INSERT INTO `phpcms_city` VALUES (440, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '鄂温克族自治旗', '021100', '0470');
INSERT INTO `phpcms_city` VALUES (441, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '陈巴尔虎旗', '021500', '0470');
INSERT INTO `phpcms_city` VALUES (442, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '新巴尔虎左旗', '021200', '0470');
INSERT INTO `phpcms_city` VALUES (443, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '新巴尔虎右旗', '021300', '0470');
INSERT INTO `phpcms_city` VALUES (444, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '满洲里市', '021400', '0470');
INSERT INTO `phpcms_city` VALUES (445, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '牙克石市', '022150', '0470');
INSERT INTO `phpcms_city` VALUES (446, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '扎兰屯市', '162650', '0470');
INSERT INTO `phpcms_city` VALUES (447, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '额尔古纳市', '022250', '0470');
INSERT INTO `phpcms_city` VALUES (448, '中华人民共和国', '内蒙古自治区', '呼伦贝尔市', '根河市', '022350', '0470');
INSERT INTO `phpcms_city` VALUES (449, '中华人民共和国', '内蒙古自治区', '巴彦淖尔市', '临河区', '015000', '0478');
INSERT INTO `phpcms_city` VALUES (450, '中华人民共和国', '内蒙古自治区', '巴彦淖尔市', '五原县', '015100', '0478');
INSERT INTO `phpcms_city` VALUES (451, '中华人民共和国', '内蒙古自治区', '巴彦淖尔市', '磴口县', '015200', '0478');
INSERT INTO `phpcms_city` VALUES (452, '中华人民共和国', '内蒙古自治区', '巴彦淖尔市', '乌拉特前旗', '014400', '0478');
INSERT INTO `phpcms_city` VALUES (453, '中华人民共和国', '内蒙古自治区', '巴彦淖尔市', '乌拉特中旗', '015300', '0478');
INSERT INTO `phpcms_city` VALUES (454, '中华人民共和国', '内蒙古自治区', '巴彦淖尔市', '乌拉特后旗', '015500', '0478');
INSERT INTO `phpcms_city` VALUES (455, '中华人民共和国', '内蒙古自治区', '巴彦淖尔市', '杭锦后旗', '015400', '0478');
INSERT INTO `phpcms_city` VALUES (456, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '集宁区', '012000', '0474');
INSERT INTO `phpcms_city` VALUES (457, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '卓资县', '012300', '0474');
INSERT INTO `phpcms_city` VALUES (458, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '化德县', '013350', '0474');
INSERT INTO `phpcms_city` VALUES (459, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '商都县', '013400', '0474');
INSERT INTO `phpcms_city` VALUES (460, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '兴和县', '013650', '0474');
INSERT INTO `phpcms_city` VALUES (461, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '凉城县', '013750', '0474');
INSERT INTO `phpcms_city` VALUES (462, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '察哈尔右翼前旗', '012200', '0474');
INSERT INTO `phpcms_city` VALUES (463, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '察哈尔右翼中旗', '013500', '0474');
INSERT INTO `phpcms_city` VALUES (464, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '察哈尔右翼后旗', '012400', '0474');
INSERT INTO `phpcms_city` VALUES (465, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '四子王旗', '011800', '0474');
INSERT INTO `phpcms_city` VALUES (466, '中华人民共和国', '内蒙古自治区', '乌兰察布市', '丰镇市', '012100', '0474');
INSERT INTO `phpcms_city` VALUES (467, '中华人民共和国', '内蒙古自治区', '兴安盟', '乌兰浩特市', '137400', '0482');
INSERT INTO `phpcms_city` VALUES (468, '中华人民共和国', '内蒙古自治区', '兴安盟', '阿尔山市', '137400', '0482');
INSERT INTO `phpcms_city` VALUES (469, '中华人民共和国', '内蒙古自治区', '兴安盟', '科尔沁右翼前旗', '137400', '0482');
INSERT INTO `phpcms_city` VALUES (470, '中华人民共和国', '内蒙古自治区', '兴安盟', '科尔沁右翼中旗', '029400', '0482');
INSERT INTO `phpcms_city` VALUES (471, '中华人民共和国', '内蒙古自治区', '兴安盟', '扎赉特旗', '137600', '0482');
INSERT INTO `phpcms_city` VALUES (472, '中华人民共和国', '内蒙古自治区', '兴安盟', '突泉县', '137500', '0482');
INSERT INTO `phpcms_city` VALUES (473, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '二连浩特市', '012600', '0479');
INSERT INTO `phpcms_city` VALUES (474, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '锡林浩特市', '026000', '0479');
INSERT INTO `phpcms_city` VALUES (475, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '阿巴嘎旗', '011400', '0479');
INSERT INTO `phpcms_city` VALUES (476, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '苏尼特左旗', '011300', '0479');
INSERT INTO `phpcms_city` VALUES (477, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '苏尼特右旗', '011200', '0479');
INSERT INTO `phpcms_city` VALUES (478, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '东乌珠穆沁旗', '026300', '0479');
INSERT INTO `phpcms_city` VALUES (479, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '西乌珠穆沁旗', '026200', '0479');
INSERT INTO `phpcms_city` VALUES (480, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '太仆寺旗', '027000', '0479');
INSERT INTO `phpcms_city` VALUES (481, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '镶黄旗', '013250', '0479');
INSERT INTO `phpcms_city` VALUES (482, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '正镶白旗', '013800', '0479');
INSERT INTO `phpcms_city` VALUES (483, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '正蓝旗', '027200', '0479');
INSERT INTO `phpcms_city` VALUES (484, '中华人民共和国', '内蒙古自治区', '锡林郭勒盟', '多伦县', '027300', '0479');
INSERT INTO `phpcms_city` VALUES (485, '中华人民共和国', '内蒙古自治区', '阿拉善盟', '阿拉善左旗', '750300', '0483');
INSERT INTO `phpcms_city` VALUES (486, '中华人民共和国', '内蒙古自治区', '阿拉善盟', '阿拉善右旗', '737300', '0483');
INSERT INTO `phpcms_city` VALUES (487, '中华人民共和国', '内蒙古自治区', '阿拉善盟', '额济纳旗', '735400', '0483');
INSERT INTO `phpcms_city` VALUES (488, '中华人民共和国', '辽宁省', '沈阳市', '和平区', '110000', '024');
INSERT INTO `phpcms_city` VALUES (489, '中华人民共和国', '辽宁省', '沈阳市', '沈河区', '110000', '024');
INSERT INTO `phpcms_city` VALUES (490, '中华人民共和国', '辽宁省', '沈阳市', '大东区', '110000', '024');
INSERT INTO `phpcms_city` VALUES (491, '中华人民共和国', '辽宁省', '沈阳市', '皇姑区', '110000', '024');
INSERT INTO `phpcms_city` VALUES (492, '中华人民共和国', '辽宁省', '沈阳市', '铁西区', '110000', '024');
INSERT INTO `phpcms_city` VALUES (493, '中华人民共和国', '辽宁省', '沈阳市', '苏家屯区', '110100', '024');
INSERT INTO `phpcms_city` VALUES (494, '中华人民共和国', '辽宁省', '沈阳市', '东陵区', '110000', '024');
INSERT INTO `phpcms_city` VALUES (495, '中华人民共和国', '辽宁省', '沈阳市', '新城子区', '110000', '024');
INSERT INTO `phpcms_city` VALUES (496, '中华人民共和国', '辽宁省', '沈阳市', '于洪区', '110000', '024');
INSERT INTO `phpcms_city` VALUES (497, '中华人民共和国', '辽宁省', '沈阳市', '辽中县', '110200', '024');
INSERT INTO `phpcms_city` VALUES (498, '中华人民共和国', '辽宁省', '沈阳市', '康平县', '110500', '024');
INSERT INTO `phpcms_city` VALUES (499, '中华人民共和国', '辽宁省', '沈阳市', '法库县', '110400', '024');
INSERT INTO `phpcms_city` VALUES (500, '中华人民共和国', '辽宁省', '沈阳市', '新民市', '110300', '024');
INSERT INTO `phpcms_city` VALUES (501, '中华人民共和国', '辽宁省', '大连市', '中山区', '116000', '0411');
INSERT INTO `phpcms_city` VALUES (502, '中华人民共和国', '辽宁省', '大连市', '西岗区', '116000', '0411');
INSERT INTO `phpcms_city` VALUES (503, '中华人民共和国', '辽宁省', '大连市', '沙河口区', '116000', '0411');
INSERT INTO `phpcms_city` VALUES (504, '中华人民共和国', '辽宁省', '大连市', '甘井子区', '116000', '0411');
INSERT INTO `phpcms_city` VALUES (505, '中华人民共和国', '辽宁省', '大连市', '旅顺口区', '116000', '0411');
INSERT INTO `phpcms_city` VALUES (506, '中华人民共和国', '辽宁省', '大连市', '金州区', '116000', '0411');
INSERT INTO `phpcms_city` VALUES (507, '中华人民共和国', '辽宁省', '大连市', '长海县', '116500', '0411');
INSERT INTO `phpcms_city` VALUES (508, '中华人民共和国', '辽宁省', '大连市', '瓦房店市', '116300', '0411');
INSERT INTO `phpcms_city` VALUES (509, '中华人民共和国', '辽宁省', '大连市', '普兰店市', '116200', '0411');
INSERT INTO `phpcms_city` VALUES (510, '中华人民共和国', '辽宁省', '大连市', '庄河市', '116400', '0411');
INSERT INTO `phpcms_city` VALUES (511, '中华人民共和国', '辽宁省', '鞍山市', '铁东区', '114000', '0412');
INSERT INTO `phpcms_city` VALUES (512, '中华人民共和国', '辽宁省', '鞍山市', '铁西区', '114000', '0412');
INSERT INTO `phpcms_city` VALUES (513, '中华人民共和国', '辽宁省', '鞍山市', '立山区', '114000', '0412');
INSERT INTO `phpcms_city` VALUES (514, '中华人民共和国', '辽宁省', '鞍山市', '千山区', '114000', '0412');
INSERT INTO `phpcms_city` VALUES (515, '中华人民共和国', '辽宁省', '鞍山市', '台安县', '114100', '0412');
INSERT INTO `phpcms_city` VALUES (516, '中华人民共和国', '辽宁省', '鞍山市', '岫岩满族自治县', '118400', '0412');
INSERT INTO `phpcms_city` VALUES (517, '中华人民共和国', '辽宁省', '鞍山市', '海城市', '114200', '0412');
INSERT INTO `phpcms_city` VALUES (518, '中华人民共和国', '辽宁省', '抚顺市', '新抚区', '113000', '0413');
INSERT INTO `phpcms_city` VALUES (519, '中华人民共和国', '辽宁省', '抚顺市', '东洲区', '113000', '0413');
INSERT INTO `phpcms_city` VALUES (520, '中华人民共和国', '辽宁省', '抚顺市', '望花区', '113000', '0413');
INSERT INTO `phpcms_city` VALUES (521, '中华人民共和国', '辽宁省', '抚顺市', '顺城区', '113000', '0413');
INSERT INTO `phpcms_city` VALUES (522, '中华人民共和国', '辽宁省', '抚顺市', '抚顺县', '113100', '0413');
INSERT INTO `phpcms_city` VALUES (523, '中华人民共和国', '辽宁省', '抚顺市', '新宾满族自治县', '113200', '0413');
INSERT INTO `phpcms_city` VALUES (524, '中华人民共和国', '辽宁省', '抚顺市', '清原满族自治县', '113300', '0413');
INSERT INTO `phpcms_city` VALUES (525, '中华人民共和国', '辽宁省', '本溪市', '平山区', '117000', '0414');
INSERT INTO `phpcms_city` VALUES (526, '中华人民共和国', '辽宁省', '本溪市', '溪湖区', '117000', '0414');
INSERT INTO `phpcms_city` VALUES (527, '中华人民共和国', '辽宁省', '本溪市', '明山区', '117000', '0414');
INSERT INTO `phpcms_city` VALUES (528, '中华人民共和国', '辽宁省', '本溪市', '南芬区', '117000', '0414');
INSERT INTO `phpcms_city` VALUES (529, '中华人民共和国', '辽宁省', '本溪市', '本溪满族自治县', '117100', '0414');
INSERT INTO `phpcms_city` VALUES (530, '中华人民共和国', '辽宁省', '本溪市', '桓仁满族自治县', '117200', '0414');
INSERT INTO `phpcms_city` VALUES (531, '中华人民共和国', '辽宁省', '丹东市', '元宝区', '118000', '0415');
INSERT INTO `phpcms_city` VALUES (532, '中华人民共和国', '辽宁省', '丹东市', '振兴区', '118000', '0415');
INSERT INTO `phpcms_city` VALUES (533, '中华人民共和国', '辽宁省', '丹东市', '振安区', '118000', '0415');
INSERT INTO `phpcms_city` VALUES (534, '中华人民共和国', '辽宁省', '丹东市', '宽甸满族自治县', '118200', '0415');
INSERT INTO `phpcms_city` VALUES (535, '中华人民共和国', '辽宁省', '丹东市', '东港市', '118300', '0415');
INSERT INTO `phpcms_city` VALUES (536, '中华人民共和国', '辽宁省', '丹东市', '凤城市', '118100', '0415');
INSERT INTO `phpcms_city` VALUES (537, '中华人民共和国', '辽宁省', '锦州市', '古塔区', '121000', '0416');
INSERT INTO `phpcms_city` VALUES (538, '中华人民共和国', '辽宁省', '锦州市', '凌河区', '121000', '0416');
INSERT INTO `phpcms_city` VALUES (539, '中华人民共和国', '辽宁省', '锦州市', '太和区', '121000', '0416');
INSERT INTO `phpcms_city` VALUES (540, '中华人民共和国', '辽宁省', '锦州市', '黑山县', '121400', '0416');
INSERT INTO `phpcms_city` VALUES (541, '中华人民共和国', '辽宁省', '锦州市', '义县', '121100', '0416');
INSERT INTO `phpcms_city` VALUES (542, '中华人民共和国', '辽宁省', '锦州市', '凌海市', '121200', '0416');
INSERT INTO `phpcms_city` VALUES (543, '中华人民共和国', '辽宁省', '锦州市', '北镇市', '121300', '0416');
INSERT INTO `phpcms_city` VALUES (544, '中华人民共和国', '辽宁省', '营口市', '站前区', '115000', '0417');
INSERT INTO `phpcms_city` VALUES (545, '中华人民共和国', '辽宁省', '营口市', '西市区', '115000', '0417');
INSERT INTO `phpcms_city` VALUES (546, '中华人民共和国', '辽宁省', '营口市', '鲅鱼圈区', '115000', '0417');
INSERT INTO `phpcms_city` VALUES (547, '中华人民共和国', '辽宁省', '营口市', '老边区', '115000', '0417');
INSERT INTO `phpcms_city` VALUES (548, '中华人民共和国', '辽宁省', '营口市', '盖州市', '115200', '0417');
INSERT INTO `phpcms_city` VALUES (549, '中华人民共和国', '辽宁省', '营口市', '大石桥市', '115100', '0417');
INSERT INTO `phpcms_city` VALUES (550, '中华人民共和国', '辽宁省', '阜新市', '海州区', '123000', '0418');
INSERT INTO `phpcms_city` VALUES (551, '中华人民共和国', '辽宁省', '阜新市', '新邱区', '123000', '0418');
INSERT INTO `phpcms_city` VALUES (552, '中华人民共和国', '辽宁省', '阜新市', '太平区', '123000', '0418');
INSERT INTO `phpcms_city` VALUES (553, '中华人民共和国', '辽宁省', '阜新市', '清河门区', '123000', '0418');
INSERT INTO `phpcms_city` VALUES (554, '中华人民共和国', '辽宁省', '阜新市', '细河区', '123000', '0418');
INSERT INTO `phpcms_city` VALUES (555, '中华人民共和国', '辽宁省', '阜新市', '阜新蒙古族自治县', '123100', '0418');
INSERT INTO `phpcms_city` VALUES (556, '中华人民共和国', '辽宁省', '阜新市', '彰武县', '123200', '0418');
INSERT INTO `phpcms_city` VALUES (557, '中华人民共和国', '辽宁省', '辽阳市', '白塔区', '111000', '0419');
INSERT INTO `phpcms_city` VALUES (558, '中华人民共和国', '辽宁省', '辽阳市', '文圣区', '111000', '0419');
INSERT INTO `phpcms_city` VALUES (559, '中华人民共和国', '辽宁省', '辽阳市', '宏伟区', '111000', '0419');
INSERT INTO `phpcms_city` VALUES (560, '中华人民共和国', '辽宁省', '辽阳市', '弓长岭区', '111000', '0419');
INSERT INTO `phpcms_city` VALUES (561, '中华人民共和国', '辽宁省', '辽阳市', '太子河区', '111000', '0419');
INSERT INTO `phpcms_city` VALUES (562, '中华人民共和国', '辽宁省', '辽阳市', '辽阳县', '111200', '0419');
INSERT INTO `phpcms_city` VALUES (563, '中华人民共和国', '辽宁省', '辽阳市', '灯塔市', '111300', '0419');
INSERT INTO `phpcms_city` VALUES (564, '中华人民共和国', '辽宁省', '盘锦市', '双台子区', '124000', '0427');
INSERT INTO `phpcms_city` VALUES (565, '中华人民共和国', '辽宁省', '盘锦市', '兴隆台区', '124000', '0427');
INSERT INTO `phpcms_city` VALUES (566, '中华人民共和国', '辽宁省', '盘锦市', '大洼县', '124200', '0427');
INSERT INTO `phpcms_city` VALUES (567, '中华人民共和国', '辽宁省', '盘锦市', '盘山县', '124100', '0427');
INSERT INTO `phpcms_city` VALUES (568, '中华人民共和国', '辽宁省', '铁岭市', '银州区', '112000', '0410');
INSERT INTO `phpcms_city` VALUES (569, '中华人民共和国', '辽宁省', '铁岭市', '清河区', '112000', '0410');
INSERT INTO `phpcms_city` VALUES (570, '中华人民共和国', '辽宁省', '铁岭市', '铁岭县', '112600', '0410');
INSERT INTO `phpcms_city` VALUES (571, '中华人民共和国', '辽宁省', '铁岭市', '西丰县', '112400', '0410');
INSERT INTO `phpcms_city` VALUES (572, '中华人民共和国', '辽宁省', '铁岭市', '昌图县', '112500', '0410');
INSERT INTO `phpcms_city` VALUES (573, '中华人民共和国', '辽宁省', '铁岭市', '调兵山市', '112700', '0410');
INSERT INTO `phpcms_city` VALUES (574, '中华人民共和国', '辽宁省', '铁岭市', '开原市', '112300', '0410');
INSERT INTO `phpcms_city` VALUES (575, '中华人民共和国', '辽宁省', '朝阳市', '双塔区', '122000', '0421');
INSERT INTO `phpcms_city` VALUES (576, '中华人民共和国', '辽宁省', '朝阳市', '龙城区', '122000', '0421');
INSERT INTO `phpcms_city` VALUES (577, '中华人民共和国', '辽宁省', '朝阳市', '朝阳县', '122000', '0421');
INSERT INTO `phpcms_city` VALUES (578, '中华人民共和国', '辽宁省', '朝阳市', '建平县', '122400', '0421');
INSERT INTO `phpcms_city` VALUES (579, '中华人民共和国', '辽宁省', '朝阳市', '喀喇沁左翼蒙古族自治县', '122300', '0421');
INSERT INTO `phpcms_city` VALUES (580, '中华人民共和国', '辽宁省', '朝阳市', '北票市', '122100', '0421');
INSERT INTO `phpcms_city` VALUES (581, '中华人民共和国', '辽宁省', '朝阳市', '凌源市', '122500', '0421');
INSERT INTO `phpcms_city` VALUES (582, '中华人民共和国', '辽宁省', '葫芦岛市', '连山区', '125000', '0429');
INSERT INTO `phpcms_city` VALUES (583, '中华人民共和国', '辽宁省', '葫芦岛市', '龙港区', '125000', '0429');
INSERT INTO `phpcms_city` VALUES (584, '中华人民共和国', '辽宁省', '葫芦岛市', '南票区', '125000', '0429');
INSERT INTO `phpcms_city` VALUES (585, '中华人民共和国', '辽宁省', '葫芦岛市', '绥中县', '125200', '0429');
INSERT INTO `phpcms_city` VALUES (586, '中华人民共和国', '辽宁省', '葫芦岛市', '建昌县', '125300', '0429');
INSERT INTO `phpcms_city` VALUES (587, '中华人民共和国', '辽宁省', '葫芦岛市', '兴城市', '125100', '0429');
INSERT INTO `phpcms_city` VALUES (588, '中华人民共和国', '吉林省', '长春市', '南关区', '130000', '0431');
INSERT INTO `phpcms_city` VALUES (589, '中华人民共和国', '吉林省', '长春市', '宽城区', '130000', '0431');
INSERT INTO `phpcms_city` VALUES (590, '中华人民共和国', '吉林省', '长春市', '朝阳区', '130000', '0431');
INSERT INTO `phpcms_city` VALUES (591, '中华人民共和国', '吉林省', '长春市', '二道区', '130000', '0431');
INSERT INTO `phpcms_city` VALUES (592, '中华人民共和国', '吉林省', '长春市', '绿园区', '130000', '0431');
INSERT INTO `phpcms_city` VALUES (593, '中华人民共和国', '吉林省', '长春市', '双阳区', '130600', '0431');
INSERT INTO `phpcms_city` VALUES (594, '中华人民共和国', '吉林省', '长春市', '农安县', '130200', '0431');
INSERT INTO `phpcms_city` VALUES (595, '中华人民共和国', '吉林省', '长春市', '九台市', '130500', '0431');
INSERT INTO `phpcms_city` VALUES (596, '中华人民共和国', '吉林省', '长春市', '榆树市', '130400', '0431');
INSERT INTO `phpcms_city` VALUES (597, '中华人民共和国', '吉林省', '长春市', '德惠市', '130300', '0431');
INSERT INTO `phpcms_city` VALUES (598, '中华人民共和国', '吉林省', '吉林市', '昌邑区', '132000', '0432');
INSERT INTO `phpcms_city` VALUES (599, '中华人民共和国', '吉林省', '吉林市', '龙潭区', '132000', '0432');
INSERT INTO `phpcms_city` VALUES (600, '中华人民共和国', '吉林省', '吉林市', '船营区', '132000', '0432');
INSERT INTO `phpcms_city` VALUES (601, '中华人民共和国', '吉林省', '吉林市', '丰满区', '132000', '0432');
INSERT INTO `phpcms_city` VALUES (602, '中华人民共和国', '吉林省', '吉林市', '永吉县', '132100', '0432');
INSERT INTO `phpcms_city` VALUES (603, '中华人民共和国', '吉林省', '吉林市', '蛟河市', '132500', '0432');
INSERT INTO `phpcms_city` VALUES (604, '中华人民共和国', '吉林省', '吉林市', '桦甸市', '132400', '0432');
INSERT INTO `phpcms_city` VALUES (605, '中华人民共和国', '吉林省', '吉林市', '舒兰市', '132600', '0432');
INSERT INTO `phpcms_city` VALUES (606, '中华人民共和国', '吉林省', '吉林市', '磐石市', '132300', '0432');
INSERT INTO `phpcms_city` VALUES (607, '中华人民共和国', '吉林省', '四平市', '铁西区', '136000', '0434');
INSERT INTO `phpcms_city` VALUES (608, '中华人民共和国', '吉林省', '四平市', '铁东区', '136000', '0434');
INSERT INTO `phpcms_city` VALUES (609, '中华人民共和国', '吉林省', '四平市', '梨树县', '136500', '0434');
INSERT INTO `phpcms_city` VALUES (610, '中华人民共和国', '吉林省', '四平市', '伊通满族自治县', '130700', '0434');
INSERT INTO `phpcms_city` VALUES (611, '中华人民共和国', '吉林省', '四平市', '公主岭市', '136100', '0434');
INSERT INTO `phpcms_city` VALUES (612, '中华人民共和国', '吉林省', '四平市', '双辽市', '136400', '0434');
INSERT INTO `phpcms_city` VALUES (613, '中华人民共和国', '吉林省', '辽源市', '龙山区', '136200', '0437');
INSERT INTO `phpcms_city` VALUES (614, '中华人民共和国', '吉林省', '辽源市', '西安区', '136200', '0437');
INSERT INTO `phpcms_city` VALUES (615, '中华人民共和国', '吉林省', '辽源市', '东丰县', '136300', '0437');
INSERT INTO `phpcms_city` VALUES (616, '中华人民共和国', '吉林省', '辽源市', '东辽县', '136600', '0437');
INSERT INTO `phpcms_city` VALUES (617, '中华人民共和国', '吉林省', '通化市', '东昌区', '134000', '0435');
INSERT INTO `phpcms_city` VALUES (618, '中华人民共和国', '吉林省', '通化市', '二道江区', '134000', '0435');
INSERT INTO `phpcms_city` VALUES (619, '中华人民共和国', '吉林省', '通化市', '通化县', '134100', '0435');
INSERT INTO `phpcms_city` VALUES (620, '中华人民共和国', '吉林省', '通化市', '辉南县', '135100', '0448');
INSERT INTO `phpcms_city` VALUES (621, '中华人民共和国', '吉林省', '通化市', '柳河县', '135300', '0448');
INSERT INTO `phpcms_city` VALUES (622, '中华人民共和国', '吉林省', '通化市', '梅河口市', '135000', '0448');
INSERT INTO `phpcms_city` VALUES (623, '中华人民共和国', '吉林省', '通化市', '集安市', '134200', '0435');
INSERT INTO `phpcms_city` VALUES (624, '中华人民共和国', '吉林省', '白山市', '八道江区', '134300', '0439');
INSERT INTO `phpcms_city` VALUES (625, '中华人民共和国', '吉林省', '白山市', '抚松县', '134500', '0439');
INSERT INTO `phpcms_city` VALUES (626, '中华人民共和国', '吉林省', '白山市', '靖宇县', '135200', '0439');
INSERT INTO `phpcms_city` VALUES (627, '中华人民共和国', '吉林省', '白山市', '长白朝鲜族自治县', '134400', '0439');
INSERT INTO `phpcms_city` VALUES (628, '中华人民共和国', '吉林省', '白山市', '江源县', '134700', '0439');
INSERT INTO `phpcms_city` VALUES (629, '中华人民共和国', '吉林省', '白山市', '临江市', '134600', '0439');
INSERT INTO `phpcms_city` VALUES (630, '中华人民共和国', '吉林省', '松原市', '宁江区', '138000', '0438');
INSERT INTO `phpcms_city` VALUES (631, '中华人民共和国', '吉林省', '松原市', '前郭尔罗斯蒙古族自治县', '131100', '0438');
INSERT INTO `phpcms_city` VALUES (632, '中华人民共和国', '吉林省', '松原市', '长岭县', '131500', '0438');
INSERT INTO `phpcms_city` VALUES (633, '中华人民共和国', '吉林省', '松原市', '乾安县', '131400', '0438');
INSERT INTO `phpcms_city` VALUES (634, '中华人民共和国', '吉林省', '松原市', '扶余县', '131200', '0438');
INSERT INTO `phpcms_city` VALUES (635, '中华人民共和国', '吉林省', '白城市', '洮北区', '137000', '0436');
INSERT INTO `phpcms_city` VALUES (636, '中华人民共和国', '吉林省', '白城市', '镇赉县', '137300', '0436');
INSERT INTO `phpcms_city` VALUES (637, '中华人民共和国', '吉林省', '白城市', '通榆县', '137200', '0436');
INSERT INTO `phpcms_city` VALUES (638, '中华人民共和国', '吉林省', '白城市', '洮南市', '137100', '0436');
INSERT INTO `phpcms_city` VALUES (639, '中华人民共和国', '吉林省', '白城市', '大安市', '131300', '0436');
INSERT INTO `phpcms_city` VALUES (640, '中华人民共和国', '吉林省', '延边朝鲜族自治州', '延吉市', '133000', '0433');
INSERT INTO `phpcms_city` VALUES (641, '中华人民共和国', '吉林省', '延边朝鲜族自治州', '图们市', '133100', '0433');
INSERT INTO `phpcms_city` VALUES (642, '中华人民共和国', '吉林省', '延边朝鲜族自治州', '敦化市', '133700', '0433');
INSERT INTO `phpcms_city` VALUES (643, '中华人民共和国', '吉林省', '延边朝鲜族自治州', '珲春市', '133300', '0440');
INSERT INTO `phpcms_city` VALUES (644, '中华人民共和国', '吉林省', '延边朝鲜族自治州', '龙井市', '133400', '0433');
INSERT INTO `phpcms_city` VALUES (645, '中华人民共和国', '吉林省', '延边朝鲜族自治州', '和龙市', '133500', '0433');
INSERT INTO `phpcms_city` VALUES (646, '中华人民共和国', '吉林省', '延边朝鲜族自治州', '汪清县', '133200', '0433');
INSERT INTO `phpcms_city` VALUES (647, '中华人民共和国', '吉林省', '延边朝鲜族自治州', '安图县', '133600', '0433');
INSERT INTO `phpcms_city` VALUES (648, '中华人民共和国', '黑龙江省', '哈尔滨市', '道里区', '150000', '0451');
INSERT INTO `phpcms_city` VALUES (649, '中华人民共和国', '黑龙江省', '哈尔滨市', '南岗区', '150000', '0451');
INSERT INTO `phpcms_city` VALUES (650, '中华人民共和国', '黑龙江省', '哈尔滨市', '道外区', '150000', '0451');
INSERT INTO `phpcms_city` VALUES (651, '中华人民共和国', '黑龙江省', '哈尔滨市', '香坊区', '150000', '0451');
INSERT INTO `phpcms_city` VALUES (652, '中华人民共和国', '黑龙江省', '哈尔滨市', '动力区', '150000', '0451');
INSERT INTO `phpcms_city` VALUES (653, '中华人民共和国', '黑龙江省', '哈尔滨市', '平房区', '150000', '0451');
INSERT INTO `phpcms_city` VALUES (654, '中华人民共和国', '黑龙江省', '哈尔滨市', '松北区', '150000', '0451');
INSERT INTO `phpcms_city` VALUES (655, '中华人民共和国', '黑龙江省', '哈尔滨市', '呼兰区', '150500', '0451');
INSERT INTO `phpcms_city` VALUES (656, '中华人民共和国', '黑龙江省', '哈尔滨市', '依兰县', '154800', '0451');
INSERT INTO `phpcms_city` VALUES (657, '中华人民共和国', '黑龙江省', '哈尔滨市', '方正县', '150800', '0451');
INSERT INTO `phpcms_city` VALUES (658, '中华人民共和国', '黑龙江省', '哈尔滨市', '宾县', '150400', '0451');
INSERT INTO `phpcms_city` VALUES (659, '中华人民共和国', '黑龙江省', '哈尔滨市', '巴彦县', '151800', '0451');
INSERT INTO `phpcms_city` VALUES (660, '中华人民共和国', '黑龙江省', '哈尔滨市', '木兰县', '151900', '0451');
INSERT INTO `phpcms_city` VALUES (661, '中华人民共和国', '黑龙江省', '哈尔滨市', '通河县', '150900', '0451');
INSERT INTO `phpcms_city` VALUES (662, '中华人民共和国', '黑龙江省', '哈尔滨市', '延寿县', '150700', '0451');
INSERT INTO `phpcms_city` VALUES (663, '中华人民共和国', '黑龙江省', '哈尔滨市', '阿城市', '150300', '0451');
INSERT INTO `phpcms_city` VALUES (664, '中华人民共和国', '黑龙江省', '哈尔滨市', '双城市', '150100', '0451');
INSERT INTO `phpcms_city` VALUES (665, '中华人民共和国', '黑龙江省', '哈尔滨市', '尚志市', '150600', '0451');
INSERT INTO `phpcms_city` VALUES (666, '中华人民共和国', '黑龙江省', '哈尔滨市', '五常市', '150200', '0451');
INSERT INTO `phpcms_city` VALUES (667, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '龙沙区', '161000', '0452');
INSERT INTO `phpcms_city` VALUES (668, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '建华区', '161000', '0452');
INSERT INTO `phpcms_city` VALUES (669, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '铁锋区', '161000', '0452');
INSERT INTO `phpcms_city` VALUES (670, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '昂昂溪区', '161000', '0452');
INSERT INTO `phpcms_city` VALUES (671, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '富拉尔基区', '161000', '0452');
INSERT INTO `phpcms_city` VALUES (672, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '碾子山区', '161000', '0452');
INSERT INTO `phpcms_city` VALUES (673, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '梅里斯达斡尔族区', '161000', '0452');
INSERT INTO `phpcms_city` VALUES (674, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '龙江县', '161100', '0452');
INSERT INTO `phpcms_city` VALUES (675, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '依安县', '161500', '0452');
INSERT INTO `phpcms_city` VALUES (676, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '泰来县', '162400', '0452');
INSERT INTO `phpcms_city` VALUES (677, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '甘南县', '162100', '0452');
INSERT INTO `phpcms_city` VALUES (678, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '富裕县', '161200', '0452');
INSERT INTO `phpcms_city` VALUES (679, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '克山县', '161600', '0452');
INSERT INTO `phpcms_city` VALUES (680, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '克东县', '164800', '0452');
INSERT INTO `phpcms_city` VALUES (681, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '拜泉县', '164700', '0452');
INSERT INTO `phpcms_city` VALUES (682, '中华人民共和国', '黑龙江省', '齐齐哈尔市', '讷河市', '161300', '0452');
INSERT INTO `phpcms_city` VALUES (683, '中华人民共和国', '黑龙江省', '鸡西市', '鸡冠区', '158100', '0467');
INSERT INTO `phpcms_city` VALUES (684, '中华人民共和国', '黑龙江省', '鸡西市', '恒山区', '158100', '0467');
INSERT INTO `phpcms_city` VALUES (685, '中华人民共和国', '黑龙江省', '鸡西市', '滴道区', '158100', '0467');
INSERT INTO `phpcms_city` VALUES (686, '中华人民共和国', '黑龙江省', '鸡西市', '梨树区', '158100', '0467');
INSERT INTO `phpcms_city` VALUES (687, '中华人民共和国', '黑龙江省', '鸡西市', '城子河区', '158100', '0467');
INSERT INTO `phpcms_city` VALUES (688, '中华人民共和国', '黑龙江省', '鸡西市', '麻山区', '158100', '0467');
INSERT INTO `phpcms_city` VALUES (689, '中华人民共和国', '黑龙江省', '鸡西市', '鸡东县', '158200', '0467');
INSERT INTO `phpcms_city` VALUES (690, '中华人民共和国', '黑龙江省', '鸡西市', '虎林市', '158400', '0467');
INSERT INTO `phpcms_city` VALUES (691, '中华人民共和国', '黑龙江省', '鸡西市', '密山市', '158300', '0467');
INSERT INTO `phpcms_city` VALUES (692, '中华人民共和国', '黑龙江省', '鹤岗市', '向阳区', '154100', '0468');
INSERT INTO `phpcms_city` VALUES (693, '中华人民共和国', '黑龙江省', '鹤岗市', '工农区', '154100', '0468');
INSERT INTO `phpcms_city` VALUES (694, '中华人民共和国', '黑龙江省', '鹤岗市', '南山区', '154100', '0468');
INSERT INTO `phpcms_city` VALUES (695, '中华人民共和国', '黑龙江省', '鹤岗市', '兴安区', '154100', '0468');
INSERT INTO `phpcms_city` VALUES (696, '中华人民共和国', '黑龙江省', '鹤岗市', '东山区', '154100', '0468');
INSERT INTO `phpcms_city` VALUES (697, '中华人民共和国', '黑龙江省', '鹤岗市', '兴山区', '154100', '0468');
INSERT INTO `phpcms_city` VALUES (698, '中华人民共和国', '黑龙江省', '鹤岗市', '萝北县', '154200', '0468');
INSERT INTO `phpcms_city` VALUES (699, '中华人民共和国', '黑龙江省', '鹤岗市', '绥滨县', '156200', '0468');
INSERT INTO `phpcms_city` VALUES (700, '中华人民共和国', '黑龙江省', '双鸭山市', '尖山区', '155100', '0469');
INSERT INTO `phpcms_city` VALUES (701, '中华人民共和国', '黑龙江省', '双鸭山市', '岭东区', '155100', '0469');
INSERT INTO `phpcms_city` VALUES (702, '中华人民共和国', '黑龙江省', '双鸭山市', '四方台区', '155100', '0469');
INSERT INTO `phpcms_city` VALUES (703, '中华人民共和国', '黑龙江省', '双鸭山市', '宝山区', '155100', '0469');
INSERT INTO `phpcms_city` VALUES (704, '中华人民共和国', '黑龙江省', '双鸭山市', '集贤县', '155900', '0469');
INSERT INTO `phpcms_city` VALUES (705, '中华人民共和国', '黑龙江省', '双鸭山市', '友谊县', '155800', '0469');
INSERT INTO `phpcms_city` VALUES (706, '中华人民共和国', '黑龙江省', '双鸭山市', '宝清县', '155600', '0469');
INSERT INTO `phpcms_city` VALUES (707, '中华人民共和国', '黑龙江省', '双鸭山市', '饶河县', '155700', '0469');
INSERT INTO `phpcms_city` VALUES (708, '中华人民共和国', '黑龙江省', '大庆市', '萨尔图区', '163000', '0459');
INSERT INTO `phpcms_city` VALUES (709, '中华人民共和国', '黑龙江省', '大庆市', '龙凤区', '163000', '0459');
INSERT INTO `phpcms_city` VALUES (710, '中华人民共和国', '黑龙江省', '大庆市', '让胡路区', '163000', '0459');
INSERT INTO `phpcms_city` VALUES (711, '中华人民共和国', '黑龙江省', '大庆市', '红岗区', '163000', '0459');
INSERT INTO `phpcms_city` VALUES (712, '中华人民共和国', '黑龙江省', '大庆市', '大同区', '163000', '0459');
INSERT INTO `phpcms_city` VALUES (713, '中华人民共和国', '黑龙江省', '大庆市', '肇州县', '166400', '0459');
INSERT INTO `phpcms_city` VALUES (714, '中华人民共和国', '黑龙江省', '大庆市', '肇源县', '166500', '0459');
INSERT INTO `phpcms_city` VALUES (715, '中华人民共和国', '黑龙江省', '大庆市', '林甸县', '166300', '0459');
INSERT INTO `phpcms_city` VALUES (716, '中华人民共和国', '黑龙江省', '大庆市', '杜尔伯特蒙古族自治县', '166200', '0459');
INSERT INTO `phpcms_city` VALUES (717, '中华人民共和国', '黑龙江省', '伊春市', '伊春区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (718, '中华人民共和国', '黑龙江省', '伊春市', '南岔区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (719, '中华人民共和国', '黑龙江省', '伊春市', '友好区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (720, '中华人民共和国', '黑龙江省', '伊春市', '西林区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (721, '中华人民共和国', '黑龙江省', '伊春市', '翠峦区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (722, '中华人民共和国', '黑龙江省', '伊春市', '新青区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (723, '中华人民共和国', '黑龙江省', '伊春市', '美溪区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (724, '中华人民共和国', '黑龙江省', '伊春市', '金山屯区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (725, '中华人民共和国', '黑龙江省', '伊春市', '五营区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (726, '中华人民共和国', '黑龙江省', '伊春市', '乌马河区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (727, '中华人民共和国', '黑龙江省', '伊春市', '汤旺河区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (728, '中华人民共和国', '黑龙江省', '伊春市', '带岭区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (729, '中华人民共和国', '黑龙江省', '伊春市', '乌伊岭区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (730, '中华人民共和国', '黑龙江省', '伊春市', '红星区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (731, '中华人民共和国', '黑龙江省', '伊春市', '上甘岭区', '153000', '0458');
INSERT INTO `phpcms_city` VALUES (732, '中华人民共和国', '黑龙江省', '伊春市', '嘉荫县', '153200', '0458');
INSERT INTO `phpcms_city` VALUES (733, '中华人民共和国', '黑龙江省', '伊春市', '铁力市', '152500', '0458');
INSERT INTO `phpcms_city` VALUES (734, '中华人民共和国', '黑龙江省', '佳木斯市', '永红区', '154000', '0454');
INSERT INTO `phpcms_city` VALUES (735, '中华人民共和国', '黑龙江省', '佳木斯市', '向阳区', '154000', '0454');
INSERT INTO `phpcms_city` VALUES (736, '中华人民共和国', '黑龙江省', '佳木斯市', '前进区', '154000', '0454');
INSERT INTO `phpcms_city` VALUES (737, '中华人民共和国', '黑龙江省', '佳木斯市', '东风区', '154000', '0454');
INSERT INTO `phpcms_city` VALUES (738, '中华人民共和国', '黑龙江省', '佳木斯市', '郊区', '154000', '0454');
INSERT INTO `phpcms_city` VALUES (739, '中华人民共和国', '黑龙江省', '佳木斯市', '桦南县', '154400', '0454');
INSERT INTO `phpcms_city` VALUES (740, '中华人民共和国', '黑龙江省', '佳木斯市', '桦川县', '154300', '0454');
INSERT INTO `phpcms_city` VALUES (741, '中华人民共和国', '黑龙江省', '佳木斯市', '汤原县', '154700', '0454');
INSERT INTO `phpcms_city` VALUES (742, '中华人民共和国', '黑龙江省', '佳木斯市', '抚远县', '156500', '0454');
INSERT INTO `phpcms_city` VALUES (743, '中华人民共和国', '黑龙江省', '佳木斯市', '同江市', '156400', '0454');
INSERT INTO `phpcms_city` VALUES (744, '中华人民共和国', '黑龙江省', '佳木斯市', '富锦市', '156100', '0454');
INSERT INTO `phpcms_city` VALUES (745, '中华人民共和国', '黑龙江省', '七台河市', '新兴区', '154600', '0464');
INSERT INTO `phpcms_city` VALUES (746, '中华人民共和国', '黑龙江省', '七台河市', '桃山区', '154600', '0464');
INSERT INTO `phpcms_city` VALUES (747, '中华人民共和国', '黑龙江省', '七台河市', '茄子河区', '154600', '0464');
INSERT INTO `phpcms_city` VALUES (748, '中华人民共和国', '黑龙江省', '七台河市', '勃利县', '154500', '0464');
INSERT INTO `phpcms_city` VALUES (749, '中华人民共和国', '黑龙江省', '牡丹江市', '东安区', '157000', '0453');
INSERT INTO `phpcms_city` VALUES (750, '中华人民共和国', '黑龙江省', '牡丹江市', '阳明区', '157000', '0453');
INSERT INTO `phpcms_city` VALUES (751, '中华人民共和国', '黑龙江省', '牡丹江市', '爱民区', '157000', '0453');
INSERT INTO `phpcms_city` VALUES (752, '中华人民共和国', '黑龙江省', '牡丹江市', '西安区', '157000', '0453');
INSERT INTO `phpcms_city` VALUES (753, '中华人民共和国', '黑龙江省', '牡丹江市', '东宁县', '157200', '0453');
INSERT INTO `phpcms_city` VALUES (754, '中华人民共和国', '黑龙江省', '牡丹江市', '林口县', '157600', '0453');
INSERT INTO `phpcms_city` VALUES (755, '中华人民共和国', '黑龙江省', '牡丹江市', '绥芬河市', '157300', '0453');
INSERT INTO `phpcms_city` VALUES (756, '中华人民共和国', '黑龙江省', '牡丹江市', '海林市', '157100', '0453');
INSERT INTO `phpcms_city` VALUES (757, '中华人民共和国', '黑龙江省', '牡丹江市', '宁安市', '157400', '0453');
INSERT INTO `phpcms_city` VALUES (758, '中华人民共和国', '黑龙江省', '牡丹江市', '穆棱市', '157500', '0453');
INSERT INTO `phpcms_city` VALUES (759, '中华人民共和国', '黑龙江省', '黑河市', '爱辉区', '164300', '0456');
INSERT INTO `phpcms_city` VALUES (760, '中华人民共和国', '黑龙江省', '黑河市', '嫩江县', '161400', '0456');
INSERT INTO `phpcms_city` VALUES (761, '中华人民共和国', '黑龙江省', '黑河市', '逊克县', '164400', '0456');
INSERT INTO `phpcms_city` VALUES (762, '中华人民共和国', '黑龙江省', '黑河市', '孙吴县', '164200', '0456');
INSERT INTO `phpcms_city` VALUES (763, '中华人民共和国', '黑龙江省', '黑河市', '北安市', '164000', '0456');
INSERT INTO `phpcms_city` VALUES (764, '中华人民共和国', '黑龙江省', '黑河市', '五大连池市', '164100', '0456');
INSERT INTO `phpcms_city` VALUES (765, '中华人民共和国', '黑龙江省', '绥化市', '北林区', '152000', '0455');
INSERT INTO `phpcms_city` VALUES (766, '中华人民共和国', '黑龙江省', '绥化市', '望奎县', '152100', '0455');
INSERT INTO `phpcms_city` VALUES (767, '中华人民共和国', '黑龙江省', '绥化市', '兰西县', '151500', '0455');
INSERT INTO `phpcms_city` VALUES (768, '中华人民共和国', '黑龙江省', '绥化市', '青冈县', '151600', '0455');
INSERT INTO `phpcms_city` VALUES (769, '中华人民共和国', '黑龙江省', '绥化市', '庆安县', '152400', '0455');
INSERT INTO `phpcms_city` VALUES (770, '中华人民共和国', '黑龙江省', '绥化市', '明水县', '151700', '0455');
INSERT INTO `phpcms_city` VALUES (771, '中华人民共和国', '黑龙江省', '绥化市', '绥棱县', '152200', '0455');
INSERT INTO `phpcms_city` VALUES (772, '中华人民共和国', '黑龙江省', '绥化市', '安达市', '151400', '0455');
INSERT INTO `phpcms_city` VALUES (773, '中华人民共和国', '黑龙江省', '绥化市', '肇东市', '151100', '0455');
INSERT INTO `phpcms_city` VALUES (774, '中华人民共和国', '黑龙江省', '绥化市', '海伦市', '152300', '0455');
INSERT INTO `phpcms_city` VALUES (775, '中华人民共和国', '黑龙江省', '大兴安岭地区', '呼玛县', '165100', '0457');
INSERT INTO `phpcms_city` VALUES (776, '中华人民共和国', '黑龙江省', '大兴安岭地区', '塔河县', '165200', '0457');
INSERT INTO `phpcms_city` VALUES (777, '中华人民共和国', '黑龙江省', '大兴安岭地区', '漠河县', '165300', '0457');
INSERT INTO `phpcms_city` VALUES (778, '中华人民共和国', '江苏省', '南京市', '玄武区', '210000', '025');
INSERT INTO `phpcms_city` VALUES (779, '中华人民共和国', '江苏省', '南京市', '白下区', '210000', '025');
INSERT INTO `phpcms_city` VALUES (780, '中华人民共和国', '江苏省', '南京市', '秦淮区', '210000', '025');
INSERT INTO `phpcms_city` VALUES (781, '中华人民共和国', '江苏省', '南京市', '建邺区', '210000', '025');
INSERT INTO `phpcms_city` VALUES (782, '中华人民共和国', '江苏省', '南京市', '鼓楼区', '210000', '025');
INSERT INTO `phpcms_city` VALUES (783, '中华人民共和国', '江苏省', '南京市', '下关区', '210000', '025');
INSERT INTO `phpcms_city` VALUES (784, '中华人民共和国', '江苏省', '南京市', '浦口区', '210000', '025');
INSERT INTO `phpcms_city` VALUES (785, '中华人民共和国', '江苏省', '南京市', '栖霞区', '210000', '025');
INSERT INTO `phpcms_city` VALUES (786, '中华人民共和国', '江苏省', '南京市', '雨花台区', '210000', '025');
INSERT INTO `phpcms_city` VALUES (787, '中华人民共和国', '江苏省', '南京市', '江宁区', '211100', '025');
INSERT INTO `phpcms_city` VALUES (788, '中华人民共和国', '江苏省', '南京市', '六合区', '211500', '025');
INSERT INTO `phpcms_city` VALUES (789, '中华人民共和国', '江苏省', '南京市', '溧水县', '211200', '025');
INSERT INTO `phpcms_city` VALUES (790, '中华人民共和国', '江苏省', '南京市', '高淳县', '211300', '025');
INSERT INTO `phpcms_city` VALUES (791, '中华人民共和国', '江苏省', '无锡市', '崇安区', '214000', '0510');
INSERT INTO `phpcms_city` VALUES (792, '中华人民共和国', '江苏省', '无锡市', '南长区', '214000', '0510');
INSERT INTO `phpcms_city` VALUES (793, '中华人民共和国', '江苏省', '无锡市', '北塘区', '214000', '0510');
INSERT INTO `phpcms_city` VALUES (794, '中华人民共和国', '江苏省', '无锡市', '锡山区', '214000', '0510');
INSERT INTO `phpcms_city` VALUES (795, '中华人民共和国', '江苏省', '无锡市', '惠山区', '214000', '0510');
INSERT INTO `phpcms_city` VALUES (796, '中华人民共和国', '江苏省', '无锡市', '滨湖区', '214000', '0510');
INSERT INTO `phpcms_city` VALUES (797, '中华人民共和国', '江苏省', '无锡市', '江阴市', '214400', '0510');
INSERT INTO `phpcms_city` VALUES (798, '中华人民共和国', '江苏省', '无锡市', '宜兴市', '214200', '0510');
INSERT INTO `phpcms_city` VALUES (799, '中华人民共和国', '江苏省', '徐州市', '鼓楼区', '221000', '0516');
INSERT INTO `phpcms_city` VALUES (800, '中华人民共和国', '江苏省', '徐州市', '云龙区', '221000', '0516');
INSERT INTO `phpcms_city` VALUES (801, '中华人民共和国', '江苏省', '徐州市', '九里区', '221000', '0516');
INSERT INTO `phpcms_city` VALUES (802, '中华人民共和国', '江苏省', '徐州市', '贾汪区', '221000', '0516');
INSERT INTO `phpcms_city` VALUES (803, '中华人民共和国', '江苏省', '徐州市', '泉山区', '221000', '0516');
INSERT INTO `phpcms_city` VALUES (804, '中华人民共和国', '江苏省', '徐州市', '丰县', '221700', '0516');
INSERT INTO `phpcms_city` VALUES (805, '中华人民共和国', '江苏省', '徐州市', '沛县', '221600', '0516');
INSERT INTO `phpcms_city` VALUES (806, '中华人民共和国', '江苏省', '徐州市', '铜山县', '221100', '0516');
INSERT INTO `phpcms_city` VALUES (807, '中华人民共和国', '江苏省', '徐州市', '睢宁县', '221200', '0516');
INSERT INTO `phpcms_city` VALUES (808, '中华人民共和国', '江苏省', '徐州市', '新沂市', '221400', '0516');
INSERT INTO `phpcms_city` VALUES (809, '中华人民共和国', '江苏省', '徐州市', '邳州市', '221300', '0516');
INSERT INTO `phpcms_city` VALUES (810, '中华人民共和国', '江苏省', '常州市', '天宁区', '213000', '0519');
INSERT INTO `phpcms_city` VALUES (811, '中华人民共和国', '江苏省', '常州市', '钟楼区', '213000', '0519');
INSERT INTO `phpcms_city` VALUES (812, '中华人民共和国', '江苏省', '常州市', '戚墅堰区', '213000', '0519');
INSERT INTO `phpcms_city` VALUES (813, '中华人民共和国', '江苏省', '常州市', '新北区', '213000', '0519');
INSERT INTO `phpcms_city` VALUES (814, '中华人民共和国', '江苏省', '常州市', '武进区', '213000', '0519');
INSERT INTO `phpcms_city` VALUES (815, '中华人民共和国', '江苏省', '常州市', '溧阳市', '213300', '0519');
INSERT INTO `phpcms_city` VALUES (816, '中华人民共和国', '江苏省', '常州市', '金坛市', '213200', '0519');
INSERT INTO `phpcms_city` VALUES (817, '中华人民共和国', '江苏省', '苏州市', '沧浪区', '215000', '0512');
INSERT INTO `phpcms_city` VALUES (818, '中华人民共和国', '江苏省', '苏州市', '平江区', '215000', '0512');
INSERT INTO `phpcms_city` VALUES (819, '中华人民共和国', '江苏省', '苏州市', '金阊区', '215000', '0512');
INSERT INTO `phpcms_city` VALUES (820, '中华人民共和国', '江苏省', '苏州市', '虎丘区', '215000', '0512');
INSERT INTO `phpcms_city` VALUES (821, '中华人民共和国', '江苏省', '苏州市', '吴中区', '215100', '0512');
INSERT INTO `phpcms_city` VALUES (822, '中华人民共和国', '江苏省', '苏州市', '相城区', '215100', '0512');
INSERT INTO `phpcms_city` VALUES (823, '中华人民共和国', '江苏省', '苏州市', '常熟市', '215500', '0512');
INSERT INTO `phpcms_city` VALUES (824, '中华人民共和国', '江苏省', '苏州市', '张家港市', '215600', '0512');
INSERT INTO `phpcms_city` VALUES (825, '中华人民共和国', '江苏省', '苏州市', '昆山市', '215300', '0512');
INSERT INTO `phpcms_city` VALUES (826, '中华人民共和国', '江苏省', '苏州市', '吴江市', '215200', '0512');
INSERT INTO `phpcms_city` VALUES (827, '中华人民共和国', '江苏省', '苏州市', '太仓市', '215400', '0512');
INSERT INTO `phpcms_city` VALUES (828, '中华人民共和国', '江苏省', '南通市', '崇川区', '226000', '0513');
INSERT INTO `phpcms_city` VALUES (829, '中华人民共和国', '江苏省', '南通市', '港闸区', '226000', '0513');
INSERT INTO `phpcms_city` VALUES (830, '中华人民共和国', '江苏省', '南通市', '海安县', '226600', '0513');
INSERT INTO `phpcms_city` VALUES (831, '中华人民共和国', '江苏省', '南通市', '如东县', '226400', '0513');
INSERT INTO `phpcms_city` VALUES (832, '中华人民共和国', '江苏省', '南通市', '启东市', '226200', '0513');
INSERT INTO `phpcms_city` VALUES (833, '中华人民共和国', '江苏省', '南通市', '如皋市', '226500', '0513');
INSERT INTO `phpcms_city` VALUES (834, '中华人民共和国', '江苏省', '南通市', '通州市', '226300', '0513');
INSERT INTO `phpcms_city` VALUES (835, '中华人民共和国', '江苏省', '南通市', '海门市', '226100', '0513');
INSERT INTO `phpcms_city` VALUES (836, '中华人民共和国', '江苏省', '连云港市', '连云区', '222000', '0518');
INSERT INTO `phpcms_city` VALUES (837, '中华人民共和国', '江苏省', '连云港市', '新浦区', '222000', '0518');
INSERT INTO `phpcms_city` VALUES (838, '中华人民共和国', '江苏省', '连云港市', '海州区', '222000', '0518');
INSERT INTO `phpcms_city` VALUES (839, '中华人民共和国', '江苏省', '连云港市', '赣榆县', '222100', '0518');
INSERT INTO `phpcms_city` VALUES (840, '中华人民共和国', '江苏省', '连云港市', '东海县', '222300', '0518');
INSERT INTO `phpcms_city` VALUES (841, '中华人民共和国', '江苏省', '连云港市', '灌云县', '222200', '0518');
INSERT INTO `phpcms_city` VALUES (842, '中华人民共和国', '江苏省', '连云港市', '灌南县', '223500', '0518');
INSERT INTO `phpcms_city` VALUES (843, '中华人民共和国', '江苏省', '淮安市', '清河区', '223000', '0517');
INSERT INTO `phpcms_city` VALUES (844, '中华人民共和国', '江苏省', '淮安市', '楚州区', '223200', '0517');
INSERT INTO `phpcms_city` VALUES (845, '中华人民共和国', '江苏省', '淮安市', '淮阴区', '223300', '0517');
INSERT INTO `phpcms_city` VALUES (846, '中华人民共和国', '江苏省', '淮安市', '清浦区', '223000', '0517');
INSERT INTO `phpcms_city` VALUES (847, '中华人民共和国', '江苏省', '淮安市', '涟水县', '223400', '0517');
INSERT INTO `phpcms_city` VALUES (848, '中华人民共和国', '江苏省', '淮安市', '洪泽县', '223100', '0517');
INSERT INTO `phpcms_city` VALUES (849, '中华人民共和国', '江苏省', '淮安市', '盱眙县', '211700', '0517');
INSERT INTO `phpcms_city` VALUES (850, '中华人民共和国', '江苏省', '淮安市', '金湖县', '211600', '0517');
INSERT INTO `phpcms_city` VALUES (851, '中华人民共和国', '江苏省', '盐城市', '亭湖区', '224000', '0515');
INSERT INTO `phpcms_city` VALUES (852, '中华人民共和国', '江苏省', '盐城市', '盐都区', '224000', '0515');
INSERT INTO `phpcms_city` VALUES (853, '中华人民共和国', '江苏省', '盐城市', '响水县', '224600', '0515');
INSERT INTO `phpcms_city` VALUES (854, '中华人民共和国', '江苏省', '盐城市', '滨海县', '224000', '0515');
INSERT INTO `phpcms_city` VALUES (855, '中华人民共和国', '江苏省', '盐城市', '阜宁县', '224400', '0515');
INSERT INTO `phpcms_city` VALUES (856, '中华人民共和国', '江苏省', '盐城市', '射阳县', '224300', '0515');
INSERT INTO `phpcms_city` VALUES (857, '中华人民共和国', '江苏省', '盐城市', '建湖县', '224700', '0515');
INSERT INTO `phpcms_city` VALUES (858, '中华人民共和国', '江苏省', '盐城市', '东台市', '224200', '0515');
INSERT INTO `phpcms_city` VALUES (859, '中华人民共和国', '江苏省', '盐城市', '大丰市', '224100', '0515');
INSERT INTO `phpcms_city` VALUES (860, '中华人民共和国', '江苏省', '扬州市', '广陵区', '225000', '0514');
INSERT INTO `phpcms_city` VALUES (861, '中华人民共和国', '江苏省', '扬州市', '邗江区', '225000', '0514');
INSERT INTO `phpcms_city` VALUES (862, '中华人民共和国', '江苏省', '扬州市', '维扬区', '225000', '0514');
INSERT INTO `phpcms_city` VALUES (863, '中华人民共和国', '江苏省', '扬州市', '宝应县', '225800', '0514');
INSERT INTO `phpcms_city` VALUES (864, '中华人民共和国', '江苏省', '扬州市', '仪征市', '211400', '0514');
INSERT INTO `phpcms_city` VALUES (865, '中华人民共和国', '江苏省', '扬州市', '高邮市', '225600', '0514');
INSERT INTO `phpcms_city` VALUES (866, '中华人民共和国', '江苏省', '扬州市', '江都市', '225200', '0514');
INSERT INTO `phpcms_city` VALUES (867, '中华人民共和国', '江苏省', '镇江市', '京口区', '212000', '0511');
INSERT INTO `phpcms_city` VALUES (868, '中华人民共和国', '江苏省', '镇江市', '润州区', '212000', '0511');
INSERT INTO `phpcms_city` VALUES (869, '中华人民共和国', '江苏省', '镇江市', '丹徒区', '212100', '0511');
INSERT INTO `phpcms_city` VALUES (870, '中华人民共和国', '江苏省', '镇江市', '丹阳市', '212300', '0511');
INSERT INTO `phpcms_city` VALUES (871, '中华人民共和国', '江苏省', '镇江市', '扬中市', '212200', '0511');
INSERT INTO `phpcms_city` VALUES (872, '中华人民共和国', '江苏省', '镇江市', '句容市', '212400', '0511');
INSERT INTO `phpcms_city` VALUES (873, '中华人民共和国', '江苏省', '泰州市', '海陵区', '225300', '0523');
INSERT INTO `phpcms_city` VALUES (874, '中华人民共和国', '江苏省', '泰州市', '高港区', '225300', '0523');
INSERT INTO `phpcms_city` VALUES (875, '中华人民共和国', '江苏省', '泰州市', '兴化市', '225700', '0523');
INSERT INTO `phpcms_city` VALUES (876, '中华人民共和国', '江苏省', '泰州市', '靖江市', '214500', '0523');
INSERT INTO `phpcms_city` VALUES (877, '中华人民共和国', '江苏省', '泰州市', '泰兴市', '225400', '0523');
INSERT INTO `phpcms_city` VALUES (878, '中华人民共和国', '江苏省', '泰州市', '姜堰市', '225500', '0523');
INSERT INTO `phpcms_city` VALUES (879, '中华人民共和国', '江苏省', '宿迁市', '宿城区', '223800', '0527');
INSERT INTO `phpcms_city` VALUES (880, '中华人民共和国', '江苏省', '宿迁市', '宿豫区', '223800', '0527');
INSERT INTO `phpcms_city` VALUES (881, '中华人民共和国', '江苏省', '宿迁市', '沭阳县', '223600', '0527');
INSERT INTO `phpcms_city` VALUES (882, '中华人民共和国', '江苏省', '宿迁市', '泗阳县', '223700', '0527');
INSERT INTO `phpcms_city` VALUES (883, '中华人民共和国', '江苏省', '宿迁市', '泗洪县', '223900', '0527');
INSERT INTO `phpcms_city` VALUES (884, '中华人民共和国', '浙江省', '杭州市', '上城区', '310000', '0571');
INSERT INTO `phpcms_city` VALUES (885, '中华人民共和国', '浙江省', '杭州市', '下城区', '310000', '0571');
INSERT INTO `phpcms_city` VALUES (886, '中华人民共和国', '浙江省', '杭州市', '江干区', '310000', '0571');
INSERT INTO `phpcms_city` VALUES (887, '中华人民共和国', '浙江省', '杭州市', '拱墅区', '310000', '0571');
INSERT INTO `phpcms_city` VALUES (888, '中华人民共和国', '浙江省', '杭州市', '西湖区', '310000', '0571');
INSERT INTO `phpcms_city` VALUES (889, '中华人民共和国', '浙江省', '杭州市', '滨江区', '310000', '0571');
INSERT INTO `phpcms_city` VALUES (890, '中华人民共和国', '浙江省', '杭州市', '萧山区', '311200', '0571');
INSERT INTO `phpcms_city` VALUES (891, '中华人民共和国', '浙江省', '杭州市', '余杭区', '311100', '0571');
INSERT INTO `phpcms_city` VALUES (892, '中华人民共和国', '浙江省', '杭州市', '桐庐县', '311500', '0571');
INSERT INTO `phpcms_city` VALUES (893, '中华人民共和国', '浙江省', '杭州市', '淳安县', '311700', '0571');
INSERT INTO `phpcms_city` VALUES (894, '中华人民共和国', '浙江省', '杭州市', '建德市', '311600', '0571');
INSERT INTO `phpcms_city` VALUES (895, '中华人民共和国', '浙江省', '杭州市', '富阳市', '311400', '0571');
INSERT INTO `phpcms_city` VALUES (896, '中华人民共和国', '浙江省', '杭州市', '临安市', '311300', '0571');
INSERT INTO `phpcms_city` VALUES (897, '中华人民共和国', '浙江省', '宁波市', '海曙区', '315000', '0574');
INSERT INTO `phpcms_city` VALUES (898, '中华人民共和国', '浙江省', '宁波市', '江东区', '315000', '0574');
INSERT INTO `phpcms_city` VALUES (899, '中华人民共和国', '浙江省', '宁波市', '江北区', '315000', '0574');
INSERT INTO `phpcms_city` VALUES (900, '中华人民共和国', '浙江省', '宁波市', '北仑区', '315800', '0574');
INSERT INTO `phpcms_city` VALUES (901, '中华人民共和国', '浙江省', '宁波市', '镇海区', '315200', '0574');
INSERT INTO `phpcms_city` VALUES (902, '中华人民共和国', '浙江省', '宁波市', '鄞州区', '315100', '0574');
INSERT INTO `phpcms_city` VALUES (903, '中华人民共和国', '浙江省', '宁波市', '象山县', '315700', '0574');
INSERT INTO `phpcms_city` VALUES (904, '中华人民共和国', '浙江省', '宁波市', '宁海县', '315600', '0574');
INSERT INTO `phpcms_city` VALUES (905, '中华人民共和国', '浙江省', '宁波市', '余姚市', '315400', '0574');
INSERT INTO `phpcms_city` VALUES (906, '中华人民共和国', '浙江省', '宁波市', '慈溪市', '315300', '0574');
INSERT INTO `phpcms_city` VALUES (907, '中华人民共和国', '浙江省', '宁波市', '奉化市', '315500', '0574');
INSERT INTO `phpcms_city` VALUES (908, '中华人民共和国', '浙江省', '温州市', '鹿城区', '325000', '0577');
INSERT INTO `phpcms_city` VALUES (909, '中华人民共和国', '浙江省', '温州市', '龙湾区', '325000', '0577');
INSERT INTO `phpcms_city` VALUES (910, '中华人民共和国', '浙江省', '温州市', '瓯海区', '325000', '0577');
INSERT INTO `phpcms_city` VALUES (911, '中华人民共和国', '浙江省', '温州市', '洞头县', '325700', '0577');
INSERT INTO `phpcms_city` VALUES (912, '中华人民共和国', '浙江省', '温州市', '永嘉县', '325100', '0577');
INSERT INTO `phpcms_city` VALUES (913, '中华人民共和国', '浙江省', '温州市', '平阳县', '325400', '0577');
INSERT INTO `phpcms_city` VALUES (914, '中华人民共和国', '浙江省', '温州市', '苍南县', '325800', '0577');
INSERT INTO `phpcms_city` VALUES (915, '中华人民共和国', '浙江省', '温州市', '文成县', '325300', '0577');
INSERT INTO `phpcms_city` VALUES (916, '中华人民共和国', '浙江省', '温州市', '泰顺县', '325500', '0577');
INSERT INTO `phpcms_city` VALUES (917, '中华人民共和国', '浙江省', '温州市', '瑞安市', '325200', '0577');
INSERT INTO `phpcms_city` VALUES (918, '中华人民共和国', '浙江省', '温州市', '乐清市', '325600', '0577');
INSERT INTO `phpcms_city` VALUES (919, '中华人民共和国', '浙江省', '嘉兴市', '秀城区', '314000', '0573');
INSERT INTO `phpcms_city` VALUES (920, '中华人民共和国', '浙江省', '嘉兴市', '秀洲区', '314000', '0573');
INSERT INTO `phpcms_city` VALUES (921, '中华人民共和国', '浙江省', '嘉兴市', '嘉善县', '314100', '0573');
INSERT INTO `phpcms_city` VALUES (922, '中华人民共和国', '浙江省', '嘉兴市', '海盐县', '314300', '0573');
INSERT INTO `phpcms_city` VALUES (923, '中华人民共和国', '浙江省', '嘉兴市', '海宁市', '314400', '0573');
INSERT INTO `phpcms_city` VALUES (924, '中华人民共和国', '浙江省', '嘉兴市', '平湖市', '314200', '0573');
INSERT INTO `phpcms_city` VALUES (925, '中华人民共和国', '浙江省', '嘉兴市', '桐乡市', '314500', '0573');
INSERT INTO `phpcms_city` VALUES (926, '中华人民共和国', '浙江省', '湖州市', '吴兴区', '313000', '0572');
INSERT INTO `phpcms_city` VALUES (927, '中华人民共和国', '浙江省', '湖州市', '南浔区', '313000', '0572');
INSERT INTO `phpcms_city` VALUES (928, '中华人民共和国', '浙江省', '湖州市', '德清县', '313200', '0572');
INSERT INTO `phpcms_city` VALUES (929, '中华人民共和国', '浙江省', '湖州市', '长兴县', '313100', '0572');
INSERT INTO `phpcms_city` VALUES (930, '中华人民共和国', '浙江省', '湖州市', '安吉县', '313300', '0572');
INSERT INTO `phpcms_city` VALUES (931, '中华人民共和国', '浙江省', '绍兴市', '越城区', '312000', '0575');
INSERT INTO `phpcms_city` VALUES (932, '中华人民共和国', '浙江省', '绍兴市', '绍兴县', '312000', '0575');
INSERT INTO `phpcms_city` VALUES (933, '中华人民共和国', '浙江省', '绍兴市', '新昌县', '312500', '0575');
INSERT INTO `phpcms_city` VALUES (934, '中华人民共和国', '浙江省', '绍兴市', '诸暨市', '311800', '0575');
INSERT INTO `phpcms_city` VALUES (935, '中华人民共和国', '浙江省', '绍兴市', '上虞市', '312300', '0575');
INSERT INTO `phpcms_city` VALUES (936, '中华人民共和国', '浙江省', '绍兴市', '嵊州市', '312400', '0575');
INSERT INTO `phpcms_city` VALUES (937, '中华人民共和国', '浙江省', '金华市', '婺城区', '321000', '0579');
INSERT INTO `phpcms_city` VALUES (938, '中华人民共和国', '浙江省', '金华市', '金东区', '321000', '0579');
INSERT INTO `phpcms_city` VALUES (939, '中华人民共和国', '浙江省', '金华市', '武义县', '321200', '0579');
INSERT INTO `phpcms_city` VALUES (940, '中华人民共和国', '浙江省', '金华市', '浦江县', '322200', '0579');
INSERT INTO `phpcms_city` VALUES (941, '中华人民共和国', '浙江省', '金华市', '磐安县', '322300', '0579');
INSERT INTO `phpcms_city` VALUES (942, '中华人民共和国', '浙江省', '金华市', '兰溪市', '321100', '0579');
INSERT INTO `phpcms_city` VALUES (943, '中华人民共和国', '浙江省', '金华市', '义乌市', '322000', '0579');
INSERT INTO `phpcms_city` VALUES (944, '中华人民共和国', '浙江省', '金华市', '东阳市', '322100', '0579');
INSERT INTO `phpcms_city` VALUES (945, '中华人民共和国', '浙江省', '金华市', '永康市', '321300', '0579');
INSERT INTO `phpcms_city` VALUES (946, '中华人民共和国', '浙江省', '衢州市', '柯城区', '324000', '0570');
INSERT INTO `phpcms_city` VALUES (947, '中华人民共和国', '浙江省', '衢州市', '衢江区', '324000', '0570');
INSERT INTO `phpcms_city` VALUES (948, '中华人民共和国', '浙江省', '衢州市', '常山县', '324200', '0570');
INSERT INTO `phpcms_city` VALUES (949, '中华人民共和国', '浙江省', '衢州市', '开化县', '324300', '0570');
INSERT INTO `phpcms_city` VALUES (950, '中华人民共和国', '浙江省', '衢州市', '龙游县', '324400', '0570');
INSERT INTO `phpcms_city` VALUES (951, '中华人民共和国', '浙江省', '衢州市', '江山市', '324100', '0570');
INSERT INTO `phpcms_city` VALUES (952, '中华人民共和国', '浙江省', '舟山市', '定海区', '316000', '0580');
INSERT INTO `phpcms_city` VALUES (953, '中华人民共和国', '浙江省', '舟山市', '普陀区', '316100', '0580');
INSERT INTO `phpcms_city` VALUES (954, '中华人民共和国', '浙江省', '舟山市', '岱山县', '316200', '0580');
INSERT INTO `phpcms_city` VALUES (955, '中华人民共和国', '浙江省', '舟山市', '嵊泗县', '202450', '0580');
INSERT INTO `phpcms_city` VALUES (956, '中华人民共和国', '浙江省', '台州市', '椒江区', '317700', '0576');
INSERT INTO `phpcms_city` VALUES (957, '中华人民共和国', '浙江省', '台州市', '黄岩区', '318020', '0576');
INSERT INTO `phpcms_city` VALUES (958, '中华人民共和国', '浙江省', '台州市', '路桥区', '318000', '0576');
INSERT INTO `phpcms_city` VALUES (959, '中华人民共和国', '浙江省', '台州市', '玉环县', '317600', '0576');
INSERT INTO `phpcms_city` VALUES (960, '中华人民共和国', '浙江省', '台州市', '三门县', '317100', '0576');
INSERT INTO `phpcms_city` VALUES (961, '中华人民共和国', '浙江省', '台州市', '天台县', '317200', '0576');
INSERT INTO `phpcms_city` VALUES (962, '中华人民共和国', '浙江省', '台州市', '仙居县', '317300', '0576');
INSERT INTO `phpcms_city` VALUES (963, '中华人民共和国', '浙江省', '台州市', '温岭市', '317500', '0576');
INSERT INTO `phpcms_city` VALUES (964, '中华人民共和国', '浙江省', '台州市', '临海市', '317000', '0576');
INSERT INTO `phpcms_city` VALUES (965, '中华人民共和国', '浙江省', '丽水市', '莲都区', '323000', '0578');
INSERT INTO `phpcms_city` VALUES (966, '中华人民共和国', '浙江省', '丽水市', '青田县', '323900', '0578');
INSERT INTO `phpcms_city` VALUES (967, '中华人民共和国', '浙江省', '丽水市', '缙云县', '321400', '0578');
INSERT INTO `phpcms_city` VALUES (968, '中华人民共和国', '浙江省', '丽水市', '遂昌县', '323300', '0578');
INSERT INTO `phpcms_city` VALUES (969, '中华人民共和国', '浙江省', '丽水市', '松阳县', '323400', '0578');
INSERT INTO `phpcms_city` VALUES (970, '中华人民共和国', '浙江省', '丽水市', '云和县', '323600', '0578');
INSERT INTO `phpcms_city` VALUES (971, '中华人民共和国', '浙江省', '丽水市', '庆元县', '323800', '0578');
INSERT INTO `phpcms_city` VALUES (972, '中华人民共和国', '浙江省', '丽水市', '景宁畲族自治县', '323500', '0578');
INSERT INTO `phpcms_city` VALUES (973, '中华人民共和国', '浙江省', '丽水市', '龙泉市', '323700', '0578');
INSERT INTO `phpcms_city` VALUES (974, '中华人民共和国', '安徽省', '合肥市', '瑶海区', '230000', '0551');
INSERT INTO `phpcms_city` VALUES (975, '中华人民共和国', '安徽省', '合肥市', '庐阳区', '230000', '0551');
INSERT INTO `phpcms_city` VALUES (976, '中华人民共和国', '安徽省', '合肥市', '蜀山区', '230000', '0551');
INSERT INTO `phpcms_city` VALUES (977, '中华人民共和国', '安徽省', '合肥市', '包河区', '230000', '0551');
INSERT INTO `phpcms_city` VALUES (978, '中华人民共和国', '安徽省', '合肥市', '长丰县', '231100', '0551');
INSERT INTO `phpcms_city` VALUES (979, '中华人民共和国', '安徽省', '合肥市', '肥东县', '230000', '0551');
INSERT INTO `phpcms_city` VALUES (980, '中华人民共和国', '安徽省', '合肥市', '肥西县', '231200', '0551');
INSERT INTO `phpcms_city` VALUES (981, '中华人民共和国', '安徽省', '芜湖市', '镜湖区', '241000', '0553');
INSERT INTO `phpcms_city` VALUES (982, '中华人民共和国', '安徽省', '芜湖市', '弋江区', '241000', '0553');
INSERT INTO `phpcms_city` VALUES (983, '中华人民共和国', '安徽省', '芜湖市', '鸠江区', '241000', '0553');
INSERT INTO `phpcms_city` VALUES (984, '中华人民共和国', '安徽省', '芜湖市', '三山区', '241000', '0553');
INSERT INTO `phpcms_city` VALUES (985, '中华人民共和国', '安徽省', '芜湖市', '芜湖县', '241100', '0553');
INSERT INTO `phpcms_city` VALUES (986, '中华人民共和国', '安徽省', '芜湖市', '繁昌县', '241200', '0553');
INSERT INTO `phpcms_city` VALUES (987, '中华人民共和国', '安徽省', '芜湖市', '南陵县', '242400', '0553');
INSERT INTO `phpcms_city` VALUES (988, '中华人民共和国', '安徽省', '蚌埠市', '龙子湖区', '233000', '0552');
INSERT INTO `phpcms_city` VALUES (989, '中华人民共和国', '安徽省', '蚌埠市', '蚌山区', '233000', '0552');
INSERT INTO `phpcms_city` VALUES (990, '中华人民共和国', '安徽省', '蚌埠市', '禹会区', '233000', '0552');
INSERT INTO `phpcms_city` VALUES (991, '中华人民共和国', '安徽省', '蚌埠市', '淮上区', '233000', '0552');
INSERT INTO `phpcms_city` VALUES (992, '中华人民共和国', '安徽省', '蚌埠市', '怀远县', '233400', '0552');
INSERT INTO `phpcms_city` VALUES (993, '中华人民共和国', '安徽省', '蚌埠市', '五河县', '233300', '0552');
INSERT INTO `phpcms_city` VALUES (994, '中华人民共和国', '安徽省', '蚌埠市', '固镇县', '233700', '0552');
INSERT INTO `phpcms_city` VALUES (995, '中华人民共和国', '安徽省', '淮南市', '大通区', '232000', '0554');
INSERT INTO `phpcms_city` VALUES (996, '中华人民共和国', '安徽省', '淮南市', '田家庵区', '232000', '0554');
INSERT INTO `phpcms_city` VALUES (997, '中华人民共和国', '安徽省', '淮南市', '谢家集区', '232000', '0554');
INSERT INTO `phpcms_city` VALUES (998, '中华人民共和国', '安徽省', '淮南市', '八公山区', '232000', '0554');
INSERT INTO `phpcms_city` VALUES (999, '中华人民共和国', '安徽省', '淮南市', '潘集区', '232000', '0554');
INSERT INTO `phpcms_city` VALUES (1000, '中华人民共和国', '安徽省', '淮南市', '凤台县', '232100', '0554');
INSERT INTO `phpcms_city` VALUES (1001, '中华人民共和国', '安徽省', '马鞍山市', '金家庄区', '243000', '0555');
INSERT INTO `phpcms_city` VALUES (1002, '中华人民共和国', '安徽省', '马鞍山市', '花山区', '243000', '0555');
INSERT INTO `phpcms_city` VALUES (1003, '中华人民共和国', '安徽省', '马鞍山市', '雨山区', '243000', '0555');
INSERT INTO `phpcms_city` VALUES (1004, '中华人民共和国', '安徽省', '马鞍山市', '当涂县', '243100', '0555');
INSERT INTO `phpcms_city` VALUES (1005, '中华人民共和国', '安徽省', '淮北市', '杜集区', '235000', '0561');
INSERT INTO `phpcms_city` VALUES (1006, '中华人民共和国', '安徽省', '淮北市', '相山区', '235000', '0561');
INSERT INTO `phpcms_city` VALUES (1007, '中华人民共和国', '安徽省', '淮北市', '烈山区', '235000', '0561');
INSERT INTO `phpcms_city` VALUES (1008, '中华人民共和国', '安徽省', '淮北市', '濉溪县', '235100', '0561');
INSERT INTO `phpcms_city` VALUES (1009, '中华人民共和国', '安徽省', '铜陵市', '铜官山区', '244000', '0562');
INSERT INTO `phpcms_city` VALUES (1010, '中华人民共和国', '安徽省', '铜陵市', '狮子山区', '244000', '0562');
INSERT INTO `phpcms_city` VALUES (1011, '中华人民共和国', '安徽省', '铜陵市', '郊区', '244000', '0562');
INSERT INTO `phpcms_city` VALUES (1012, '中华人民共和国', '安徽省', '铜陵市', '铜陵县', '244100', '0562');
INSERT INTO `phpcms_city` VALUES (1013, '中华人民共和国', '安徽省', '安庆市', '迎江区', '246000', '0556');
INSERT INTO `phpcms_city` VALUES (1014, '中华人民共和国', '安徽省', '安庆市', '大观区', '246000', '0556');
INSERT INTO `phpcms_city` VALUES (1015, '中华人民共和国', '安徽省', '安庆市', '宜秀区', '246000', '0556');
INSERT INTO `phpcms_city` VALUES (1016, '中华人民共和国', '安徽省', '安庆市', '怀宁县', '246100', '0556');
INSERT INTO `phpcms_city` VALUES (1017, '中华人民共和国', '安徽省', '安庆市', '枞阳县', '246700', '0556');
INSERT INTO `phpcms_city` VALUES (1018, '中华人民共和国', '安徽省', '安庆市', '潜山县', '246300', '0556');
INSERT INTO `phpcms_city` VALUES (1019, '中华人民共和国', '安徽省', '安庆市', '太湖县', '246400', '0556');
INSERT INTO `phpcms_city` VALUES (1020, '中华人民共和国', '安徽省', '安庆市', '宿松县', '246500', '0556');
INSERT INTO `phpcms_city` VALUES (1021, '中华人民共和国', '安徽省', '安庆市', '望江县', '246200', '0556');
INSERT INTO `phpcms_city` VALUES (1022, '中华人民共和国', '安徽省', '安庆市', '岳西县', '246600', '0556');
INSERT INTO `phpcms_city` VALUES (1023, '中华人民共和国', '安徽省', '安庆市', '桐城市', '231400', '0556');
INSERT INTO `phpcms_city` VALUES (1024, '中华人民共和国', '安徽省', '黄山市', '屯溪区', '245000', '0559');
INSERT INTO `phpcms_city` VALUES (1025, '中华人民共和国', '安徽省', '黄山市', '黄山区', '242700', '0559');
INSERT INTO `phpcms_city` VALUES (1026, '中华人民共和国', '安徽省', '黄山市', '徽州区', '245060', '0559');
INSERT INTO `phpcms_city` VALUES (1027, '中华人民共和国', '安徽省', '黄山市', '歙县', '245200', '0559');
INSERT INTO `phpcms_city` VALUES (1028, '中华人民共和国', '安徽省', '黄山市', '休宁县', '245400', '0559');
INSERT INTO `phpcms_city` VALUES (1029, '中华人民共和国', '安徽省', '黄山市', '黟县', '245500', '0559');
INSERT INTO `phpcms_city` VALUES (1030, '中华人民共和国', '安徽省', '黄山市', '祁门县', '245600', '0559');
INSERT INTO `phpcms_city` VALUES (1031, '中华人民共和国', '安徽省', '滁州市', '琅琊区', '239000', '0550');
INSERT INTO `phpcms_city` VALUES (1032, '中华人民共和国', '安徽省', '滁州市', '南谯区', '239000', '0550');
INSERT INTO `phpcms_city` VALUES (1033, '中华人民共和国', '安徽省', '滁州市', '来安县', '239200', '0550');
INSERT INTO `phpcms_city` VALUES (1034, '中华人民共和国', '安徽省', '滁州市', '全椒县', '239500', '0550');
INSERT INTO `phpcms_city` VALUES (1035, '中华人民共和国', '安徽省', '滁州市', '定远县', '233200', '0550');
INSERT INTO `phpcms_city` VALUES (1036, '中华人民共和国', '安徽省', '滁州市', '凤阳县', '233100', '0550');
INSERT INTO `phpcms_city` VALUES (1037, '中华人民共和国', '安徽省', '滁州市', '天长市', '239300', '0550');
INSERT INTO `phpcms_city` VALUES (1038, '中华人民共和国', '安徽省', '滁州市', '明光市', '239400', '0550');
INSERT INTO `phpcms_city` VALUES (1039, '中华人民共和国', '安徽省', '阜阳市', '颍州区', '236000', '0558');
INSERT INTO `phpcms_city` VALUES (1040, '中华人民共和国', '安徽省', '阜阳市', '颍东区', '236000', '0558');
INSERT INTO `phpcms_city` VALUES (1041, '中华人民共和国', '安徽省', '阜阳市', '颍泉区', '236000', '0558');
INSERT INTO `phpcms_city` VALUES (1042, '中华人民共和国', '安徽省', '阜阳市', '临泉县', '236400', '0558');
INSERT INTO `phpcms_city` VALUES (1043, '中华人民共和国', '安徽省', '阜阳市', '太和县', '236600', '0558');
INSERT INTO `phpcms_city` VALUES (1044, '中华人民共和国', '安徽省', '阜阳市', '阜南县', '236300', '0558');
INSERT INTO `phpcms_city` VALUES (1045, '中华人民共和国', '安徽省', '阜阳市', '颍上县', '236200', '0558');
INSERT INTO `phpcms_city` VALUES (1046, '中华人民共和国', '安徽省', '阜阳市', '界首市', '236500', '0558');
INSERT INTO `phpcms_city` VALUES (1047, '中华人民共和国', '安徽省', '宿州市', '埇桥区', '234000', '0557');
INSERT INTO `phpcms_city` VALUES (1048, '中华人民共和国', '安徽省', '宿州市', '砀山县', '235300', '0557');
INSERT INTO `phpcms_city` VALUES (1049, '中华人民共和国', '安徽省', '宿州市', '萧县', '235200', '0557');
INSERT INTO `phpcms_city` VALUES (1050, '中华人民共和国', '安徽省', '宿州市', '灵璧县', '234200', '0557');
INSERT INTO `phpcms_city` VALUES (1051, '中华人民共和国', '安徽省', '宿州市', '泗县', '234300', '0557');
INSERT INTO `phpcms_city` VALUES (1052, '中华人民共和国', '安徽省', '巢湖市', '居巢区', '238000', '0565');
INSERT INTO `phpcms_city` VALUES (1053, '中华人民共和国', '安徽省', '巢湖市', '庐江县', '231500', '0565');
INSERT INTO `phpcms_city` VALUES (1054, '中华人民共和国', '安徽省', '巢湖市', '无为县', '238300', '0565');
INSERT INTO `phpcms_city` VALUES (1055, '中华人民共和国', '安徽省', '巢湖市', '含山县', '238100', '0565');
INSERT INTO `phpcms_city` VALUES (1056, '中华人民共和国', '安徽省', '巢湖市', '和县', '238200', '0565');
INSERT INTO `phpcms_city` VALUES (1057, '中华人民共和国', '安徽省', '六安市', '金安区', '237000', '0564');
INSERT INTO `phpcms_city` VALUES (1058, '中华人民共和国', '安徽省', '六安市', '裕安区', '237000', '0564');
INSERT INTO `phpcms_city` VALUES (1059, '中华人民共和国', '安徽省', '六安市', '寿县', '232200', '0564');
INSERT INTO `phpcms_city` VALUES (1060, '中华人民共和国', '安徽省', '六安市', '霍邱县', '237400', '0564');
INSERT INTO `phpcms_city` VALUES (1061, '中华人民共和国', '安徽省', '六安市', '舒城县', '231300', '0564');
INSERT INTO `phpcms_city` VALUES (1062, '中华人民共和国', '安徽省', '六安市', '金寨县', '237300', '0564');
INSERT INTO `phpcms_city` VALUES (1063, '中华人民共和国', '安徽省', '六安市', '霍山县', '237200', '0564');
INSERT INTO `phpcms_city` VALUES (1064, '中华人民共和国', '安徽省', '亳州市', '谯城区', '236800', '0558');
INSERT INTO `phpcms_city` VALUES (1065, '中华人民共和国', '安徽省', '亳州市', '涡阳县', '233600', '0558');
INSERT INTO `phpcms_city` VALUES (1066, '中华人民共和国', '安徽省', '亳州市', '蒙城县', '233500', '0558');
INSERT INTO `phpcms_city` VALUES (1067, '中华人民共和国', '安徽省', '亳州市', '利辛县', '236700', '0558');
INSERT INTO `phpcms_city` VALUES (1068, '中华人民共和国', '安徽省', '池州市', '贵池区', '247100', '0566');
INSERT INTO `phpcms_city` VALUES (1069, '中华人民共和国', '安徽省', '池州市', '东至县', '247200', '0566');
INSERT INTO `phpcms_city` VALUES (1070, '中华人民共和国', '安徽省', '池州市', '石台县', '245100', '0566');
INSERT INTO `phpcms_city` VALUES (1071, '中华人民共和国', '安徽省', '池州市', '青阳县', '242800', '0566');
INSERT INTO `phpcms_city` VALUES (1072, '中华人民共和国', '安徽省', '宣城市', '宣州区', '242000', '0563');
INSERT INTO `phpcms_city` VALUES (1073, '中华人民共和国', '安徽省', '宣城市', '郎溪县', '242100', '0563');
INSERT INTO `phpcms_city` VALUES (1074, '中华人民共和国', '安徽省', '宣城市', '广德县', '242200', '0563');
INSERT INTO `phpcms_city` VALUES (1075, '中华人民共和国', '安徽省', '宣城市', '泾县', '242500', '0563');
INSERT INTO `phpcms_city` VALUES (1076, '中华人民共和国', '安徽省', '宣城市', '绩溪县', '245300', '0563');
INSERT INTO `phpcms_city` VALUES (1077, '中华人民共和国', '安徽省', '宣城市', '旌德县', '242600', '0563');
INSERT INTO `phpcms_city` VALUES (1078, '中华人民共和国', '安徽省', '宣城市', '宁国市', '242300', '0563');
INSERT INTO `phpcms_city` VALUES (1079, '中华人民共和国', '福建省', '福州市', '鼓楼区', '350000', '0591');
INSERT INTO `phpcms_city` VALUES (1080, '中华人民共和国', '福建省', '福州市', '台江区', '350000', '0591');
INSERT INTO `phpcms_city` VALUES (1081, '中华人民共和国', '福建省', '福州市', '仓山区', '350000', '0591');
INSERT INTO `phpcms_city` VALUES (1082, '中华人民共和国', '福建省', '福州市', '马尾区', '350000', '0591');
INSERT INTO `phpcms_city` VALUES (1083, '中华人民共和国', '福建省', '福州市', '晋安区', '350000', '0591');
INSERT INTO `phpcms_city` VALUES (1084, '中华人民共和国', '福建省', '福州市', '闽侯县', '350100', '0591');
INSERT INTO `phpcms_city` VALUES (1085, '中华人民共和国', '福建省', '福州市', '连江县', '350500', '0591');
INSERT INTO `phpcms_city` VALUES (1086, '中华人民共和国', '福建省', '福州市', '罗源县', '350600', '0591');
INSERT INTO `phpcms_city` VALUES (1087, '中华人民共和国', '福建省', '福州市', '闽清县', '350800', '0591');
INSERT INTO `phpcms_city` VALUES (1088, '中华人民共和国', '福建省', '福州市', '永泰县', '350700', '0591');
INSERT INTO `phpcms_city` VALUES (1089, '中华人民共和国', '福建省', '福州市', '平潭县', '350400', '0591');
INSERT INTO `phpcms_city` VALUES (1090, '中华人民共和国', '福建省', '福州市', '福清市', '350300', '0591');
INSERT INTO `phpcms_city` VALUES (1091, '中华人民共和国', '福建省', '福州市', '长乐市', '350200', '0591');
INSERT INTO `phpcms_city` VALUES (1092, '中华人民共和国', '福建省', '厦门市', '思明区', '361000', '0592');
INSERT INTO `phpcms_city` VALUES (1093, '中华人民共和国', '福建省', '厦门市', '海沧区', '361000', '0592');
INSERT INTO `phpcms_city` VALUES (1094, '中华人民共和国', '福建省', '厦门市', '湖里区', '361000', '0592');
INSERT INTO `phpcms_city` VALUES (1095, '中华人民共和国', '福建省', '厦门市', '集美区', '361000', '0592');
INSERT INTO `phpcms_city` VALUES (1096, '中华人民共和国', '福建省', '厦门市', '同安区', '361100', '0592');
INSERT INTO `phpcms_city` VALUES (1097, '中华人民共和国', '福建省', '厦门市', '翔安区', '361100', '0592');
INSERT INTO `phpcms_city` VALUES (1098, '中华人民共和国', '福建省', '莆田市', '城厢区', '351100', '0594');
INSERT INTO `phpcms_city` VALUES (1099, '中华人民共和国', '福建省', '莆田市', '涵江区', '351100', '0594');
INSERT INTO `phpcms_city` VALUES (1100, '中华人民共和国', '福建省', '莆田市', '荔城区', '351100', '0594');
INSERT INTO `phpcms_city` VALUES (1101, '中华人民共和国', '福建省', '莆田市', '秀屿区', '351100', '0594');
INSERT INTO `phpcms_city` VALUES (1102, '中华人民共和国', '福建省', '莆田市', '仙游县', '351200', '0594');
INSERT INTO `phpcms_city` VALUES (1103, '中华人民共和国', '福建省', '三明市', '梅列区', '365000', '0598');
INSERT INTO `phpcms_city` VALUES (1104, '中华人民共和国', '福建省', '三明市', '三元区', '365000', '0598');
INSERT INTO `phpcms_city` VALUES (1105, '中华人民共和国', '福建省', '三明市', '明溪县', '365300', '0598');
INSERT INTO `phpcms_city` VALUES (1106, '中华人民共和国', '福建省', '三明市', '清流县', '365300', '0598');
INSERT INTO `phpcms_city` VALUES (1107, '中华人民共和国', '福建省', '三明市', '宁化县', '365400', '0598');
INSERT INTO `phpcms_city` VALUES (1108, '中华人民共和国', '福建省', '三明市', '大田县', '366100', '0598');
INSERT INTO `phpcms_city` VALUES (1109, '中华人民共和国', '福建省', '三明市', '尤溪县', '365100', '0598');
INSERT INTO `phpcms_city` VALUES (1110, '中华人民共和国', '福建省', '三明市', '沙县', '365500', '0598');
INSERT INTO `phpcms_city` VALUES (1111, '中华人民共和国', '福建省', '三明市', '将乐县', '353300', '0598');
INSERT INTO `phpcms_city` VALUES (1112, '中华人民共和国', '福建省', '三明市', '泰宁县', '354400', '0598');
INSERT INTO `phpcms_city` VALUES (1113, '中华人民共和国', '福建省', '三明市', '建宁县', '354500', '0598');
INSERT INTO `phpcms_city` VALUES (1114, '中华人民共和国', '福建省', '三明市', '永安市', '366000', '0598');
INSERT INTO `phpcms_city` VALUES (1115, '中华人民共和国', '福建省', '泉州市', '鲤城区', '362000', '0595');
INSERT INTO `phpcms_city` VALUES (1116, '中华人民共和国', '福建省', '泉州市', '丰泽区', '362000', '0595');
INSERT INTO `phpcms_city` VALUES (1117, '中华人民共和国', '福建省', '泉州市', '洛江区', '362000', '0595');
INSERT INTO `phpcms_city` VALUES (1118, '中华人民共和国', '福建省', '泉州市', '泉港区', '362100', '0595');
INSERT INTO `phpcms_city` VALUES (1119, '中华人民共和国', '福建省', '泉州市', '惠安县', '362100', '0595');
INSERT INTO `phpcms_city` VALUES (1120, '中华人民共和国', '福建省', '泉州市', '安溪县', '362400', '0595');
INSERT INTO `phpcms_city` VALUES (1121, '中华人民共和国', '福建省', '泉州市', '永春县', '362600', '0595');
INSERT INTO `phpcms_city` VALUES (1122, '中华人民共和国', '福建省', '泉州市', '德化县', '362500', '0595');
INSERT INTO `phpcms_city` VALUES (1123, '中华人民共和国', '福建省', '泉州市', '金门县', '362000', '0595');
INSERT INTO `phpcms_city` VALUES (1124, '中华人民共和国', '福建省', '泉州市', '石狮市', '362700', '0595');
INSERT INTO `phpcms_city` VALUES (1125, '中华人民共和国', '福建省', '泉州市', '晋江市', '362200', '0595');
INSERT INTO `phpcms_city` VALUES (1126, '中华人民共和国', '福建省', '泉州市', '南安市', '362300', '0595');
INSERT INTO `phpcms_city` VALUES (1127, '中华人民共和国', '福建省', '漳州市', '芗城区', '363000', '0596');
INSERT INTO `phpcms_city` VALUES (1128, '中华人民共和国', '福建省', '漳州市', '龙文区', '363000', '0596');
INSERT INTO `phpcms_city` VALUES (1129, '中华人民共和国', '福建省', '漳州市', '云霄县', '363300', '0596');
INSERT INTO `phpcms_city` VALUES (1130, '中华人民共和国', '福建省', '漳州市', '漳浦县', '363200', '0596');
INSERT INTO `phpcms_city` VALUES (1131, '中华人民共和国', '福建省', '漳州市', '诏安县', '363500', '0596');
INSERT INTO `phpcms_city` VALUES (1132, '中华人民共和国', '福建省', '漳州市', '长泰县', '363900', '0596');
INSERT INTO `phpcms_city` VALUES (1133, '中华人民共和国', '福建省', '漳州市', '东山县', '363400', '0596');
INSERT INTO `phpcms_city` VALUES (1134, '中华人民共和国', '福建省', '漳州市', '南靖县', '363600', '0596');
INSERT INTO `phpcms_city` VALUES (1135, '中华人民共和国', '福建省', '漳州市', '平和县', '363700', '0596');
INSERT INTO `phpcms_city` VALUES (1136, '中华人民共和国', '福建省', '漳州市', '华安县', '363800', '0596');
INSERT INTO `phpcms_city` VALUES (1137, '中华人民共和国', '福建省', '漳州市', '龙海市', '363100', '0596');
INSERT INTO `phpcms_city` VALUES (1138, '中华人民共和国', '福建省', '南平市', '延平区', '353000', '0599');
INSERT INTO `phpcms_city` VALUES (1139, '中华人民共和国', '福建省', '南平市', '顺昌县', '353200', '0599');
INSERT INTO `phpcms_city` VALUES (1140, '中华人民共和国', '福建省', '南平市', '浦城县', '353400', '0599');
INSERT INTO `phpcms_city` VALUES (1141, '中华人民共和国', '福建省', '南平市', '光泽县', '354100', '0599');
INSERT INTO `phpcms_city` VALUES (1142, '中华人民共和国', '福建省', '南平市', '松溪县', '353500', '0599');
INSERT INTO `phpcms_city` VALUES (1143, '中华人民共和国', '福建省', '南平市', '政和县', '353600', '0599');
INSERT INTO `phpcms_city` VALUES (1144, '中华人民共和国', '福建省', '南平市', '邵武市', '354000', '0599');
INSERT INTO `phpcms_city` VALUES (1145, '中华人民共和国', '福建省', '南平市', '武夷山市', '354300', '0599');
INSERT INTO `phpcms_city` VALUES (1146, '中华人民共和国', '福建省', '南平市', '建瓯市', '353100', '0599');
INSERT INTO `phpcms_city` VALUES (1147, '中华人民共和国', '福建省', '南平市', '建阳市', '354200', '0599');
INSERT INTO `phpcms_city` VALUES (1148, '中华人民共和国', '福建省', '龙岩市', '新罗区', '364000', '0597');
INSERT INTO `phpcms_city` VALUES (1149, '中华人民共和国', '福建省', '龙岩市', '长汀县', '366300', '0597');
INSERT INTO `phpcms_city` VALUES (1150, '中华人民共和国', '福建省', '龙岩市', '永定县', '364100', '0597');
INSERT INTO `phpcms_city` VALUES (1151, '中华人民共和国', '福建省', '龙岩市', '上杭县', '364200', '0597');
INSERT INTO `phpcms_city` VALUES (1152, '中华人民共和国', '福建省', '龙岩市', '武平县', '364300', '0597');
INSERT INTO `phpcms_city` VALUES (1153, '中华人民共和国', '福建省', '龙岩市', '连城县', '366200', '0597');
INSERT INTO `phpcms_city` VALUES (1154, '中华人民共和国', '福建省', '龙岩市', '漳平市', '364400', '0597');
INSERT INTO `phpcms_city` VALUES (1155, '中华人民共和国', '福建省', '宁德市', '蕉城区', '352000', '0593');
INSERT INTO `phpcms_city` VALUES (1156, '中华人民共和国', '福建省', '宁德市', '霞浦县', '355100', '0593');
INSERT INTO `phpcms_city` VALUES (1157, '中华人民共和国', '福建省', '宁德市', '古田县', '352200', '0593');
INSERT INTO `phpcms_city` VALUES (1158, '中华人民共和国', '福建省', '宁德市', '屏南县', '352300', '0593');
INSERT INTO `phpcms_city` VALUES (1159, '中华人民共和国', '福建省', '宁德市', '寿宁县', '355500', '0593');
INSERT INTO `phpcms_city` VALUES (1160, '中华人民共和国', '福建省', '宁德市', '周宁县', '355400', '0593');
INSERT INTO `phpcms_city` VALUES (1161, '中华人民共和国', '福建省', '宁德市', '柘荣县', '355300', '0593');
INSERT INTO `phpcms_city` VALUES (1162, '中华人民共和国', '福建省', '宁德市', '福安市', '355000', '0593');
INSERT INTO `phpcms_city` VALUES (1163, '中华人民共和国', '福建省', '宁德市', '福鼎市', '355200', '0593');
INSERT INTO `phpcms_city` VALUES (1164, '中华人民共和国', '江西省', '南昌市', '东湖区', '330000', '0791');
INSERT INTO `phpcms_city` VALUES (1165, '中华人民共和国', '江西省', '南昌市', '西湖区', '330000', '0791');
INSERT INTO `phpcms_city` VALUES (1166, '中华人民共和国', '江西省', '南昌市', '青云谱区', '330000', '0791');
INSERT INTO `phpcms_city` VALUES (1167, '中华人民共和国', '江西省', '南昌市', '湾里区', '330000', '0791');
INSERT INTO `phpcms_city` VALUES (1168, '中华人民共和国', '江西省', '南昌市', '青山湖区', '330000', '0791');
INSERT INTO `phpcms_city` VALUES (1169, '中华人民共和国', '江西省', '南昌市', '南昌县', '330200', '0791');
INSERT INTO `phpcms_city` VALUES (1170, '中华人民共和国', '江西省', '南昌市', '新建县', '330100', '0791');
INSERT INTO `phpcms_city` VALUES (1171, '中华人民共和国', '江西省', '南昌市', '安义县', '330500', '0791');
INSERT INTO `phpcms_city` VALUES (1172, '中华人民共和国', '江西省', '南昌市', '进贤县', '331700', '0791');
INSERT INTO `phpcms_city` VALUES (1173, '中华人民共和国', '江西省', '景德镇市', '昌江区', '333000', '0798');
INSERT INTO `phpcms_city` VALUES (1174, '中华人民共和国', '江西省', '景德镇市', '珠山区', '333000', '0798');
INSERT INTO `phpcms_city` VALUES (1175, '中华人民共和国', '江西省', '景德镇市', '浮梁县', '333400', '0798');
INSERT INTO `phpcms_city` VALUES (1176, '中华人民共和国', '江西省', '景德镇市', '乐平市', '333300', '0798');
INSERT INTO `phpcms_city` VALUES (1177, '中华人民共和国', '江西省', '萍乡市', '安源区', '337000', '0799');
INSERT INTO `phpcms_city` VALUES (1178, '中华人民共和国', '江西省', '萍乡市', '湘东区', '337000', '0799');
INSERT INTO `phpcms_city` VALUES (1179, '中华人民共和国', '江西省', '萍乡市', '莲花县', '337100', '0799');
INSERT INTO `phpcms_city` VALUES (1180, '中华人民共和国', '江西省', '萍乡市', '上栗县', '337000', '0799');
INSERT INTO `phpcms_city` VALUES (1181, '中华人民共和国', '江西省', '萍乡市', '芦溪县', '337000', '0799');
INSERT INTO `phpcms_city` VALUES (1182, '中华人民共和国', '江西省', '九江市', '庐山区', '332900', '0792');
INSERT INTO `phpcms_city` VALUES (1183, '中华人民共和国', '江西省', '九江市', '浔阳区', '332000', '0792');
INSERT INTO `phpcms_city` VALUES (1184, '中华人民共和国', '江西省', '九江市', '九江县', '332100', '0792');
INSERT INTO `phpcms_city` VALUES (1185, '中华人民共和国', '江西省', '九江市', '武宁县', '332300', '0792');
INSERT INTO `phpcms_city` VALUES (1186, '中华人民共和国', '江西省', '九江市', '修水县', '332400', '0792');
INSERT INTO `phpcms_city` VALUES (1187, '中华人民共和国', '江西省', '九江市', '永修县', '330300', '0792');
INSERT INTO `phpcms_city` VALUES (1188, '中华人民共和国', '江西省', '九江市', '德安县', '330400', '0792');
INSERT INTO `phpcms_city` VALUES (1189, '中华人民共和国', '江西省', '九江市', '星子县', '332800', '0792');
INSERT INTO `phpcms_city` VALUES (1190, '中华人民共和国', '江西省', '九江市', '都昌县', '332600', '0792');
INSERT INTO `phpcms_city` VALUES (1191, '中华人民共和国', '江西省', '九江市', '湖口县', '332500', '0792');
INSERT INTO `phpcms_city` VALUES (1192, '中华人民共和国', '江西省', '九江市', '彭泽县', '332700', '0792');
INSERT INTO `phpcms_city` VALUES (1193, '中华人民共和国', '江西省', '九江市', '瑞昌市', '332200', '0792');
INSERT INTO `phpcms_city` VALUES (1194, '中华人民共和国', '江西省', '新余市', '渝水区', '336500', '0790');
INSERT INTO `phpcms_city` VALUES (1195, '中华人民共和国', '江西省', '新余市', '分宜县', '336600', '0790');
INSERT INTO `phpcms_city` VALUES (1196, '中华人民共和国', '江西省', '鹰潭市', '月湖区', '335000', '0701');
INSERT INTO `phpcms_city` VALUES (1197, '中华人民共和国', '江西省', '鹰潭市', '余江县', '335200', '0701');
INSERT INTO `phpcms_city` VALUES (1198, '中华人民共和国', '江西省', '鹰潭市', '贵溪市', '335400', '0701');
INSERT INTO `phpcms_city` VALUES (1199, '中华人民共和国', '江西省', '赣州市', '章贡区', '341000', '0797');
INSERT INTO `phpcms_city` VALUES (1200, '中华人民共和国', '江西省', '赣州市', '赣县', '341100', '0797');
INSERT INTO `phpcms_city` VALUES (1201, '中华人民共和国', '江西省', '赣州市', '信丰县', '341600', '0797');
INSERT INTO `phpcms_city` VALUES (1202, '中华人民共和国', '江西省', '赣州市', '大余县', '341500', '0797');
INSERT INTO `phpcms_city` VALUES (1203, '中华人民共和国', '江西省', '赣州市', '上犹县', '341200', '0797');
INSERT INTO `phpcms_city` VALUES (1204, '中华人民共和国', '江西省', '赣州市', '崇义县', '341300', '0797');
INSERT INTO `phpcms_city` VALUES (1205, '中华人民共和国', '江西省', '赣州市', '安远县', '342100', '0797');
INSERT INTO `phpcms_city` VALUES (1206, '中华人民共和国', '江西省', '赣州市', '龙南县', '341700', '0797');
INSERT INTO `phpcms_city` VALUES (1207, '中华人民共和国', '江西省', '赣州市', '定南县', '341900', '0797');
INSERT INTO `phpcms_city` VALUES (1208, '中华人民共和国', '江西省', '赣州市', '全南县', '341800', '0797');
INSERT INTO `phpcms_city` VALUES (1209, '中华人民共和国', '江西省', '赣州市', '宁都县', '342800', '0797');
INSERT INTO `phpcms_city` VALUES (1210, '中华人民共和国', '江西省', '赣州市', '于都县', '342300', '0797');
INSERT INTO `phpcms_city` VALUES (1211, '中华人民共和国', '江西省', '赣州市', '兴国县', '342400', '0797');
INSERT INTO `phpcms_city` VALUES (1212, '中华人民共和国', '江西省', '赣州市', '会昌县', '342600', '0797');
INSERT INTO `phpcms_city` VALUES (1213, '中华人民共和国', '江西省', '赣州市', '寻乌县', '342200', '0797');
INSERT INTO `phpcms_city` VALUES (1214, '中华人民共和国', '江西省', '赣州市', '石城县', '342700', '0797');
INSERT INTO `phpcms_city` VALUES (1215, '中华人民共和国', '江西省', '赣州市', '瑞金市', '342500', '0797');
INSERT INTO `phpcms_city` VALUES (1216, '中华人民共和国', '江西省', '赣州市', '南康市', '341400', '0797');
INSERT INTO `phpcms_city` VALUES (1217, '中华人民共和国', '江西省', '吉安市', '吉州区', '343000', '0796');
INSERT INTO `phpcms_city` VALUES (1218, '中华人民共和国', '江西省', '吉安市', '青原区', '343000', '0796');
INSERT INTO `phpcms_city` VALUES (1219, '中华人民共和国', '江西省', '吉安市', '吉安县', '343100', '0796');
INSERT INTO `phpcms_city` VALUES (1220, '中华人民共和国', '江西省', '吉安市', '吉水县', '331600', '0796');
INSERT INTO `phpcms_city` VALUES (1221, '中华人民共和国', '江西省', '吉安市', '峡江县', '331400', '0796');
INSERT INTO `phpcms_city` VALUES (1222, '中华人民共和国', '江西省', '吉安市', '新干县', '331300', '0796');
INSERT INTO `phpcms_city` VALUES (1223, '中华人民共和国', '江西省', '吉安市', '永丰县', '331500', '0796');
INSERT INTO `phpcms_city` VALUES (1224, '中华人民共和国', '江西省', '吉安市', '泰和县', '343700', '0796');
INSERT INTO `phpcms_city` VALUES (1225, '中华人民共和国', '江西省', '吉安市', '遂川县', '343900', '0796');
INSERT INTO `phpcms_city` VALUES (1226, '中华人民共和国', '江西省', '吉安市', '万安县', '343800', '0796');
INSERT INTO `phpcms_city` VALUES (1227, '中华人民共和国', '江西省', '吉安市', '安福县', '343200', '0796');
INSERT INTO `phpcms_city` VALUES (1228, '中华人民共和国', '江西省', '吉安市', '永新县', '343400', '0796');
INSERT INTO `phpcms_city` VALUES (1229, '中华人民共和国', '江西省', '吉安市', '井冈山市', '343600', '0796');
INSERT INTO `phpcms_city` VALUES (1230, '中华人民共和国', '江西省', '宜春市', '袁州区', '336000', '0795');
INSERT INTO `phpcms_city` VALUES (1231, '中华人民共和国', '江西省', '宜春市', '奉新县', '330700', '0795');
INSERT INTO `phpcms_city` VALUES (1232, '中华人民共和国', '江西省', '宜春市', '万载县', '336100', '0795');
INSERT INTO `phpcms_city` VALUES (1233, '中华人民共和国', '江西省', '宜春市', '上高县', '336400', '0795');
INSERT INTO `phpcms_city` VALUES (1234, '中华人民共和国', '江西省', '宜春市', '宜丰县', '336300', '0795');
INSERT INTO `phpcms_city` VALUES (1235, '中华人民共和国', '江西省', '宜春市', '靖安县', '330600', '0795');
INSERT INTO `phpcms_city` VALUES (1236, '中华人民共和国', '江西省', '宜春市', '铜鼓县', '336200', '0795');
INSERT INTO `phpcms_city` VALUES (1237, '中华人民共和国', '江西省', '宜春市', '丰城市', '331100', '0795');
INSERT INTO `phpcms_city` VALUES (1238, '中华人民共和国', '江西省', '宜春市', '樟树市', '331200', '0795');
INSERT INTO `phpcms_city` VALUES (1239, '中华人民共和国', '江西省', '宜春市', '高安市', '330800', '0795');
INSERT INTO `phpcms_city` VALUES (1240, '中华人民共和国', '江西省', '抚州市', '临川区', '344100', '0794');
INSERT INTO `phpcms_city` VALUES (1241, '中华人民共和国', '江西省', '抚州市', '南城县', '344700', '0794');
INSERT INTO `phpcms_city` VALUES (1242, '中华人民共和国', '江西省', '抚州市', '黎川县', '344600', '0794');
INSERT INTO `phpcms_city` VALUES (1243, '中华人民共和国', '江西省', '抚州市', '南丰县', '344500', '0794');
INSERT INTO `phpcms_city` VALUES (1244, '中华人民共和国', '江西省', '抚州市', '崇仁县', '344200', '0794');
INSERT INTO `phpcms_city` VALUES (1245, '中华人民共和国', '江西省', '抚州市', '乐安县', '344300', '0794');
INSERT INTO `phpcms_city` VALUES (1246, '中华人民共和国', '江西省', '抚州市', '宜黄县', '344400', '0794');
INSERT INTO `phpcms_city` VALUES (1247, '中华人民共和国', '江西省', '抚州市', '金溪县', '344800', '0794');
INSERT INTO `phpcms_city` VALUES (1248, '中华人民共和国', '江西省', '抚州市', '资溪县', '335300', '0794');
INSERT INTO `phpcms_city` VALUES (1249, '中华人民共和国', '江西省', '抚州市', '东乡县', '331800', '0794');
INSERT INTO `phpcms_city` VALUES (1250, '中华人民共和国', '江西省', '抚州市', '广昌县', '344900', '0794');
INSERT INTO `phpcms_city` VALUES (1251, '中华人民共和国', '江西省', '上饶市', '信州区', '334000', '0793');
INSERT INTO `phpcms_city` VALUES (1252, '中华人民共和国', '江西省', '上饶市', '上饶县', '334100', '0793');
INSERT INTO `phpcms_city` VALUES (1253, '中华人民共和国', '江西省', '上饶市', '广丰县', '334600', '0793');
INSERT INTO `phpcms_city` VALUES (1254, '中华人民共和国', '江西省', '上饶市', '玉山县', '334700', '0793');
INSERT INTO `phpcms_city` VALUES (1255, '中华人民共和国', '江西省', '上饶市', '铅山县', '334500', '0793');
INSERT INTO `phpcms_city` VALUES (1256, '中华人民共和国', '江西省', '上饶市', '横峰县', '334300', '0793');
INSERT INTO `phpcms_city` VALUES (1257, '中华人民共和国', '江西省', '上饶市', '弋阳县', '334400', '0793');
INSERT INTO `phpcms_city` VALUES (1258, '中华人民共和国', '江西省', '上饶市', '余干县', '335100', '0793');
INSERT INTO `phpcms_city` VALUES (1259, '中华人民共和国', '江西省', '上饶市', '鄱阳县', '333100', '0793');
INSERT INTO `phpcms_city` VALUES (1260, '中华人民共和国', '江西省', '上饶市', '万年县', '335500', '0793');
INSERT INTO `phpcms_city` VALUES (1261, '中华人民共和国', '江西省', '上饶市', '婺源县', '333200', '0793');
INSERT INTO `phpcms_city` VALUES (1262, '中华人民共和国', '江西省', '上饶市', '德兴市', '334200', '0793');
INSERT INTO `phpcms_city` VALUES (1263, '中华人民共和国', '山东省', '济南市', '历下区', '250000', '0531');
INSERT INTO `phpcms_city` VALUES (1264, '中华人民共和国', '山东省', '济南市', '市中区', '250000', '0531');
INSERT INTO `phpcms_city` VALUES (1265, '中华人民共和国', '山东省', '济南市', '槐荫区', '250000', '0531');
INSERT INTO `phpcms_city` VALUES (1266, '中华人民共和国', '山东省', '济南市', '天桥区', '250000', '0531');
INSERT INTO `phpcms_city` VALUES (1267, '中华人民共和国', '山东省', '济南市', '历城区', '250100', '0531');
INSERT INTO `phpcms_city` VALUES (1268, '中华人民共和国', '山东省', '济南市', '长清区', '250300', '0531');
INSERT INTO `phpcms_city` VALUES (1269, '中华人民共和国', '山东省', '济南市', '平阴县', '250400', '0531');
INSERT INTO `phpcms_city` VALUES (1270, '中华人民共和国', '山东省', '济南市', '济阳县', '251400', '0531');
INSERT INTO `phpcms_city` VALUES (1271, '中华人民共和国', '山东省', '济南市', '商河县', '251600', '0531');
INSERT INTO `phpcms_city` VALUES (1272, '中华人民共和国', '山东省', '济南市', '章丘市', '250200', '0531');
INSERT INTO `phpcms_city` VALUES (1273, '中华人民共和国', '山东省', '青岛市', '市南区', '266000', '0532');
INSERT INTO `phpcms_city` VALUES (1274, '中华人民共和国', '山东省', '青岛市', '市北区', '266000', '0532');
INSERT INTO `phpcms_city` VALUES (1275, '中华人民共和国', '山东省', '青岛市', '四方区', '266000', '0532');
INSERT INTO `phpcms_city` VALUES (1276, '中华人民共和国', '山东省', '青岛市', '黄岛区', '266000', '0532');
INSERT INTO `phpcms_city` VALUES (1277, '中华人民共和国', '山东省', '青岛市', '崂山区', '266100', '0532');
INSERT INTO `phpcms_city` VALUES (1278, '中华人民共和国', '山东省', '青岛市', '李沧区', '266000', '0532');
INSERT INTO `phpcms_city` VALUES (1279, '中华人民共和国', '山东省', '青岛市', '城阳区', '266000', '0532');
INSERT INTO `phpcms_city` VALUES (1280, '中华人民共和国', '山东省', '青岛市', '胶州市', '266300', '0532');
INSERT INTO `phpcms_city` VALUES (1281, '中华人民共和国', '山东省', '青岛市', '即墨市', '266200', '0532');
INSERT INTO `phpcms_city` VALUES (1282, '中华人民共和国', '山东省', '青岛市', '平度市', '266700', '0532');
INSERT INTO `phpcms_city` VALUES (1283, '中华人民共和国', '山东省', '青岛市', '胶南市', '266400', '0532');
INSERT INTO `phpcms_city` VALUES (1284, '中华人民共和国', '山东省', '青岛市', '莱西市', '266600', '0532');
INSERT INTO `phpcms_city` VALUES (1285, '中华人民共和国', '山东省', '淄博市', '淄川区', '255100', '0533');
INSERT INTO `phpcms_city` VALUES (1286, '中华人民共和国', '山东省', '淄博市', '张店区', '255000', '0533');
INSERT INTO `phpcms_city` VALUES (1287, '中华人民共和国', '山东省', '淄博市', '博山区', '255200', '0533');
INSERT INTO `phpcms_city` VALUES (1288, '中华人民共和国', '山东省', '淄博市', '临淄区', '255400', '0533');
INSERT INTO `phpcms_city` VALUES (1289, '中华人民共和国', '山东省', '淄博市', '周村区', '255300', '0533');
INSERT INTO `phpcms_city` VALUES (1290, '中华人民共和国', '山东省', '淄博市', '桓台县', '256400', '0533');
INSERT INTO `phpcms_city` VALUES (1291, '中华人民共和国', '山东省', '淄博市', '高青县', '256300', '0533');
INSERT INTO `phpcms_city` VALUES (1292, '中华人民共和国', '山东省', '淄博市', '沂源县', '256100', '0533');
INSERT INTO `phpcms_city` VALUES (1293, '中华人民共和国', '山东省', '枣庄市', '市中区', '277000', '0632');
INSERT INTO `phpcms_city` VALUES (1294, '中华人民共和国', '山东省', '枣庄市', '薛城区', '277000', '0632');
INSERT INTO `phpcms_city` VALUES (1295, '中华人民共和国', '山东省', '枣庄市', '峄城区', '277300', '0632');
INSERT INTO `phpcms_city` VALUES (1296, '中华人民共和国', '山东省', '枣庄市', '台儿庄区', '277400', '0632');
INSERT INTO `phpcms_city` VALUES (1297, '中华人民共和国', '山东省', '枣庄市', '山亭区', '277200', '0632');
INSERT INTO `phpcms_city` VALUES (1298, '中华人民共和国', '山东省', '枣庄市', '滕州市', '277500', '0632');
INSERT INTO `phpcms_city` VALUES (1299, '中华人民共和国', '山东省', '东营市', '东营区', '257100', '0546');
INSERT INTO `phpcms_city` VALUES (1300, '中华人民共和国', '山东省', '东营市', '河口区', '257200', '0546');
INSERT INTO `phpcms_city` VALUES (1301, '中华人民共和国', '山东省', '东营市', '垦利县', '257500', '0546');
INSERT INTO `phpcms_city` VALUES (1302, '中华人民共和国', '山东省', '东营市', '利津县', '257400', '0546');
INSERT INTO `phpcms_city` VALUES (1303, '中华人民共和国', '山东省', '东营市', '广饶县', '257300', '0546');
INSERT INTO `phpcms_city` VALUES (1304, '中华人民共和国', '山东省', '烟台市', '芝罘区', '264000', '0535');
INSERT INTO `phpcms_city` VALUES (1305, '中华人民共和国', '山东省', '烟台市', '福山区', '265500', '0535');
INSERT INTO `phpcms_city` VALUES (1306, '中华人民共和国', '山东省', '烟台市', '牟平区', '264100', '0535');
INSERT INTO `phpcms_city` VALUES (1307, '中华人民共和国', '山东省', '烟台市', '莱山区', '264000', '0535');
INSERT INTO `phpcms_city` VALUES (1308, '中华人民共和国', '山东省', '烟台市', '长岛县', '265800', '0535');
INSERT INTO `phpcms_city` VALUES (1309, '中华人民共和国', '山东省', '烟台市', '龙口市', '265700', '0535');
INSERT INTO `phpcms_city` VALUES (1310, '中华人民共和国', '山东省', '烟台市', '莱阳市', '265200', '0535');
INSERT INTO `phpcms_city` VALUES (1311, '中华人民共和国', '山东省', '烟台市', '莱州市', '261400', '0535');
INSERT INTO `phpcms_city` VALUES (1312, '中华人民共和国', '山东省', '烟台市', '蓬莱市', '265600', '0535');
INSERT INTO `phpcms_city` VALUES (1313, '中华人民共和国', '山东省', '烟台市', '招远市', '265400', '0535');
INSERT INTO `phpcms_city` VALUES (1314, '中华人民共和国', '山东省', '烟台市', '栖霞市', '265300', '0535');
INSERT INTO `phpcms_city` VALUES (1315, '中华人民共和国', '山东省', '烟台市', '海阳市', '265100', '0535');
INSERT INTO `phpcms_city` VALUES (1316, '中华人民共和国', '山东省', '潍坊市', '潍城区', '261000', '0536');
INSERT INTO `phpcms_city` VALUES (1317, '中华人民共和国', '山东省', '潍坊市', '寒亭区', '261100', '0536');
INSERT INTO `phpcms_city` VALUES (1318, '中华人民共和国', '山东省', '潍坊市', '坊子区', '261200', '0536');
INSERT INTO `phpcms_city` VALUES (1319, '中华人民共和国', '山东省', '潍坊市', '奎文区', '261000', '0536');
INSERT INTO `phpcms_city` VALUES (1320, '中华人民共和国', '山东省', '潍坊市', '临朐县', '262600', '0536');
INSERT INTO `phpcms_city` VALUES (1321, '中华人民共和国', '山东省', '潍坊市', '昌乐县', '262400', '0536');
INSERT INTO `phpcms_city` VALUES (1322, '中华人民共和国', '山东省', '潍坊市', '青州市', '262500', '0536');
INSERT INTO `phpcms_city` VALUES (1323, '中华人民共和国', '山东省', '潍坊市', '诸城市', '262200', '0536');
INSERT INTO `phpcms_city` VALUES (1324, '中华人民共和国', '山东省', '潍坊市', '寿光市', '262700', '0536');
INSERT INTO `phpcms_city` VALUES (1325, '中华人民共和国', '山东省', '潍坊市', '安丘市', '262100', '0536');
INSERT INTO `phpcms_city` VALUES (1326, '中华人民共和国', '山东省', '潍坊市', '高密市', '261500', '0536');
INSERT INTO `phpcms_city` VALUES (1327, '中华人民共和国', '山东省', '潍坊市', '昌邑市', '261300', '0536');
INSERT INTO `phpcms_city` VALUES (1328, '中华人民共和国', '山东省', '济宁市', '市中区', '272000', '0537');
INSERT INTO `phpcms_city` VALUES (1329, '中华人民共和国', '山东省', '济宁市', '任城区', '272000', '0537');
INSERT INTO `phpcms_city` VALUES (1330, '中华人民共和国', '山东省', '济宁市', '微山县', '277600', '0537');
INSERT INTO `phpcms_city` VALUES (1331, '中华人民共和国', '山东省', '济宁市', '鱼台县', '272300', '0537');
INSERT INTO `phpcms_city` VALUES (1332, '中华人民共和国', '山东省', '济宁市', '金乡县', '272200', '0537');
INSERT INTO `phpcms_city` VALUES (1333, '中华人民共和国', '山东省', '济宁市', '嘉祥县', '272400', '0537');
INSERT INTO `phpcms_city` VALUES (1334, '中华人民共和国', '山东省', '济宁市', '汶上县', '272500', '0537');
INSERT INTO `phpcms_city` VALUES (1335, '中华人民共和国', '山东省', '济宁市', '泗水县', '273200', '0537');
INSERT INTO `phpcms_city` VALUES (1336, '中华人民共和国', '山东省', '济宁市', '梁山县', '272600', '0537');
INSERT INTO `phpcms_city` VALUES (1337, '中华人民共和国', '山东省', '济宁市', '曲阜市', '273100', '0537');
INSERT INTO `phpcms_city` VALUES (1338, '中华人民共和国', '山东省', '济宁市', '兖州市', '272000', '0537');
INSERT INTO `phpcms_city` VALUES (1339, '中华人民共和国', '山东省', '济宁市', '邹城市', '273500', '0537');
INSERT INTO `phpcms_city` VALUES (1340, '中华人民共和国', '山东省', '泰安市', '泰山区', '271000', '0538');
INSERT INTO `phpcms_city` VALUES (1341, '中华人民共和国', '山东省', '泰安市', '岱岳区', '271000', '0538');
INSERT INTO `phpcms_city` VALUES (1342, '中华人民共和国', '山东省', '泰安市', '宁阳县', '271400', '0538');
INSERT INTO `phpcms_city` VALUES (1343, '中华人民共和国', '山东省', '泰安市', '东平县', '271500', '0538');
INSERT INTO `phpcms_city` VALUES (1344, '中华人民共和国', '山东省', '泰安市', '新泰市', '271200', '0538');
INSERT INTO `phpcms_city` VALUES (1345, '中华人民共和国', '山东省', '泰安市', '肥城市', '271600', '0538');
INSERT INTO `phpcms_city` VALUES (1346, '中华人民共和国', '山东省', '威海市', '环翠区', '264200', '0631');
INSERT INTO `phpcms_city` VALUES (1347, '中华人民共和国', '山东省', '威海市', '文登市', '264400', '0631');
INSERT INTO `phpcms_city` VALUES (1348, '中华人民共和国', '山东省', '威海市', '荣成市', '264300', '0631');
INSERT INTO `phpcms_city` VALUES (1349, '中华人民共和国', '山东省', '威海市', '乳山市', '264500', '0631');
INSERT INTO `phpcms_city` VALUES (1350, '中华人民共和国', '山东省', '日照市', '东港区', '276800', '0633');
INSERT INTO `phpcms_city` VALUES (1351, '中华人民共和国', '山东省', '日照市', '岚山区', '276800', '0633');
INSERT INTO `phpcms_city` VALUES (1352, '中华人民共和国', '山东省', '日照市', '五莲县', '262300', '0633');
INSERT INTO `phpcms_city` VALUES (1353, '中华人民共和国', '山东省', '日照市', '莒县', '276500', '0633');
INSERT INTO `phpcms_city` VALUES (1354, '中华人民共和国', '山东省', '莱芜市', '莱城区', '271100', '0634');
INSERT INTO `phpcms_city` VALUES (1355, '中华人民共和国', '山东省', '莱芜市', '钢城区', '271100', '0634');
INSERT INTO `phpcms_city` VALUES (1356, '中华人民共和国', '山东省', '临沂市', '兰山区', '276000', '0539');
INSERT INTO `phpcms_city` VALUES (1357, '中华人民共和国', '山东省', '临沂市', '罗庄区', '276000', '0539');
INSERT INTO `phpcms_city` VALUES (1358, '中华人民共和国', '山东省', '临沂市', '河东区', '276000', '0539');
INSERT INTO `phpcms_city` VALUES (1359, '中华人民共和国', '山东省', '临沂市', '沂南县', '276300', '0539');
INSERT INTO `phpcms_city` VALUES (1360, '中华人民共和国', '山东省', '临沂市', '郯城县', '276100', '0539');
INSERT INTO `phpcms_city` VALUES (1361, '中华人民共和国', '山东省', '临沂市', '沂水县', '276400', '0539');
INSERT INTO `phpcms_city` VALUES (1362, '中华人民共和国', '山东省', '临沂市', '苍山县', '277700', '0539');
INSERT INTO `phpcms_city` VALUES (1363, '中华人民共和国', '山东省', '临沂市', '费县', '273400', '0539');
INSERT INTO `phpcms_city` VALUES (1364, '中华人民共和国', '山东省', '临沂市', '平邑县', '273300', '0539');
INSERT INTO `phpcms_city` VALUES (1365, '中华人民共和国', '山东省', '临沂市', '莒南县', '276600', '0539');
INSERT INTO `phpcms_city` VALUES (1366, '中华人民共和国', '山东省', '临沂市', '蒙阴县', '276200', '0539');
INSERT INTO `phpcms_city` VALUES (1367, '中华人民共和国', '山东省', '临沂市', '临沭县', '276700', '0539');
INSERT INTO `phpcms_city` VALUES (1368, '中华人民共和国', '山东省', '德州市', '德城区', '253000', '0534');
INSERT INTO `phpcms_city` VALUES (1369, '中华人民共和国', '山东省', '德州市', '陵县', '253500', '0534');
INSERT INTO `phpcms_city` VALUES (1370, '中华人民共和国', '山东省', '德州市', '宁津县', '253400', '0534');
INSERT INTO `phpcms_city` VALUES (1371, '中华人民共和国', '山东省', '德州市', '庆云县', '253700', '0534');
INSERT INTO `phpcms_city` VALUES (1372, '中华人民共和国', '山东省', '德州市', '临邑县', '251500', '0534');
INSERT INTO `phpcms_city` VALUES (1373, '中华人民共和国', '山东省', '德州市', '齐河县', '251100', '0534');
INSERT INTO `phpcms_city` VALUES (1374, '中华人民共和国', '山东省', '德州市', '平原县', '253100', '0534');
INSERT INTO `phpcms_city` VALUES (1375, '中华人民共和国', '山东省', '德州市', '夏津县', '253200', '0534');
INSERT INTO `phpcms_city` VALUES (1376, '中华人民共和国', '山东省', '德州市', '武城县', '253300', '0534');
INSERT INTO `phpcms_city` VALUES (1377, '中华人民共和国', '山东省', '德州市', '乐陵市', '253600', '0534');
INSERT INTO `phpcms_city` VALUES (1378, '中华人民共和国', '山东省', '德州市', '禹城市', '251200', '0534');
INSERT INTO `phpcms_city` VALUES (1379, '中华人民共和国', '山东省', '聊城市', '东昌府区', '252000', '0635');
INSERT INTO `phpcms_city` VALUES (1380, '中华人民共和国', '山东省', '聊城市', '阳谷县', '252300', '0635');
INSERT INTO `phpcms_city` VALUES (1381, '中华人民共和国', '山东省', '聊城市', '莘县', '252400', '0635');
INSERT INTO `phpcms_city` VALUES (1382, '中华人民共和国', '山东省', '聊城市', '茌平县', '252100', '0635');
INSERT INTO `phpcms_city` VALUES (1383, '中华人民共和国', '山东省', '聊城市', '东阿县', '252200', '0635');
INSERT INTO `phpcms_city` VALUES (1384, '中华人民共和国', '山东省', '聊城市', '冠县', '252500', '0635');
INSERT INTO `phpcms_city` VALUES (1385, '中华人民共和国', '山东省', '聊城市', '高唐县', '252800', '0635');
INSERT INTO `phpcms_city` VALUES (1386, '中华人民共和国', '山东省', '聊城市', '临清市', '252600', '0635');
INSERT INTO `phpcms_city` VALUES (1387, '中华人民共和国', '山东省', '滨州市', '滨城区', '256600', '0543');
INSERT INTO `phpcms_city` VALUES (1388, '中华人民共和国', '山东省', '滨州市', '惠民县', '251700', '0543');
INSERT INTO `phpcms_city` VALUES (1389, '中华人民共和国', '山东省', '滨州市', '阳信县', '251800', '0543');
INSERT INTO `phpcms_city` VALUES (1390, '中华人民共和国', '山东省', '滨州市', '无棣县', '251900', '0543');
INSERT INTO `phpcms_city` VALUES (1391, '中华人民共和国', '山东省', '滨州市', '沾化县', '256800', '0543');
INSERT INTO `phpcms_city` VALUES (1392, '中华人民共和国', '山东省', '滨州市', '博兴县', '256500', '0543');
INSERT INTO `phpcms_city` VALUES (1393, '中华人民共和国', '山东省', '滨州市', '邹平县', '256200', '0543');
INSERT INTO `phpcms_city` VALUES (1394, '中华人民共和国', '山东省', '荷泽市', '牡丹区', '274000', '0530');
INSERT INTO `phpcms_city` VALUES (1395, '中华人民共和国', '山东省', '荷泽市', '曹县', '274400', '0530');
INSERT INTO `phpcms_city` VALUES (1396, '中华人民共和国', '山东省', '荷泽市', '单县', '274300', '0530');
INSERT INTO `phpcms_city` VALUES (1397, '中华人民共和国', '山东省', '荷泽市', '成武县', '274200', '0530');
INSERT INTO `phpcms_city` VALUES (1398, '中华人民共和国', '山东省', '荷泽市', '巨野县', '274900', '0530');
INSERT INTO `phpcms_city` VALUES (1399, '中华人民共和国', '山东省', '荷泽市', '郓城县', '274700', '0530');
INSERT INTO `phpcms_city` VALUES (1400, '中华人民共和国', '山东省', '荷泽市', '鄄城县', '274600', '0530');
INSERT INTO `phpcms_city` VALUES (1401, '中华人民共和国', '山东省', '荷泽市', '定陶县', '274100', '0530');
INSERT INTO `phpcms_city` VALUES (1402, '中华人民共和国', '山东省', '荷泽市', '东明县', '274500', '0530');
INSERT INTO `phpcms_city` VALUES (1403, '中华人民共和国', '河南省', '郑州市', '中原区', '450000', '0371');
INSERT INTO `phpcms_city` VALUES (1404, '中华人民共和国', '河南省', '郑州市', '二七区', '450000', '0371');
INSERT INTO `phpcms_city` VALUES (1405, '中华人民共和国', '河南省', '郑州市', '管城回族区', '450000', '0371');
INSERT INTO `phpcms_city` VALUES (1406, '中华人民共和国', '河南省', '郑州市', '金水区', '450000', '0371');
INSERT INTO `phpcms_city` VALUES (1407, '中华人民共和国', '河南省', '郑州市', '上街区', '450000', '0371');
INSERT INTO `phpcms_city` VALUES (1408, '中华人民共和国', '河南省', '郑州市', '惠济区', '450000', '0371');
INSERT INTO `phpcms_city` VALUES (1409, '中华人民共和国', '河南省', '郑州市', '中牟县', '451450', '0371');
INSERT INTO `phpcms_city` VALUES (1410, '中华人民共和国', '河南省', '郑州市', '巩义市', '452100', '0371');
INSERT INTO `phpcms_city` VALUES (1411, '中华人民共和国', '河南省', '郑州市', '荥阳市', '450100', '0371');
INSERT INTO `phpcms_city` VALUES (1412, '中华人民共和国', '河南省', '郑州市', '新密市', '452370', '0371');
INSERT INTO `phpcms_city` VALUES (1413, '中华人民共和国', '河南省', '郑州市', '新郑市', '451100', '0371');
INSERT INTO `phpcms_city` VALUES (1414, '中华人民共和国', '河南省', '郑州市', '登封市', '452470', '0371');
INSERT INTO `phpcms_city` VALUES (1415, '中华人民共和国', '河南省', '开封市', '龙亭区', '475000', '0378');
INSERT INTO `phpcms_city` VALUES (1416, '中华人民共和国', '河南省', '开封市', '顺河回族区', '475000', '0378');
INSERT INTO `phpcms_city` VALUES (1417, '中华人民共和国', '河南省', '开封市', '鼓楼区', '475000', '0378');
INSERT INTO `phpcms_city` VALUES (1418, '中华人民共和国', '河南省', '开封市', '禹王台区', '475000', '0378');
INSERT INTO `phpcms_city` VALUES (1419, '中华人民共和国', '河南省', '开封市', '金明区', '475000', '0378');
INSERT INTO `phpcms_city` VALUES (1420, '中华人民共和国', '河南省', '开封市', '杞县', '475200', '0378');
INSERT INTO `phpcms_city` VALUES (1421, '中华人民共和国', '河南省', '开封市', '通许县', '452200', '0378');
INSERT INTO `phpcms_city` VALUES (1422, '中华人民共和国', '河南省', '开封市', '尉氏县', '452100', '0378');
INSERT INTO `phpcms_city` VALUES (1423, '中华人民共和国', '河南省', '开封市', '开封县', '475100', '0378');
INSERT INTO `phpcms_city` VALUES (1424, '中华人民共和国', '河南省', '开封市', '兰考县', '475300', '0378');
INSERT INTO `phpcms_city` VALUES (1425, '中华人民共和国', '河南省', '洛阳市', '老城区', '471000', '0379');
INSERT INTO `phpcms_city` VALUES (1426, '中华人民共和国', '河南省', '洛阳市', '西工区', '471000', '0379');
INSERT INTO `phpcms_city` VALUES (1427, '中华人民共和国', '河南省', '洛阳市', '廛河回族区', '471000', '0379');
INSERT INTO `phpcms_city` VALUES (1428, '中华人民共和国', '河南省', '洛阳市', '涧西区', '471000', '0379');
INSERT INTO `phpcms_city` VALUES (1429, '中华人民共和国', '河南省', '洛阳市', '吉利区', '471000', '0379');
INSERT INTO `phpcms_city` VALUES (1430, '中华人民共和国', '河南省', '洛阳市', '洛龙区', '471000', '0379');
INSERT INTO `phpcms_city` VALUES (1431, '中华人民共和国', '河南省', '洛阳市', '孟津县', '471100', '0379');
INSERT INTO `phpcms_city` VALUES (1432, '中华人民共和国', '河南省', '洛阳市', '新安县', '471800', '0379');
INSERT INTO `phpcms_city` VALUES (1433, '中华人民共和国', '河南省', '洛阳市', '栾川县', '471500', '0379');
INSERT INTO `phpcms_city` VALUES (1434, '中华人民共和国', '河南省', '洛阳市', '嵩县', '471400', '0379');
INSERT INTO `phpcms_city` VALUES (1435, '中华人民共和国', '河南省', '洛阳市', '汝阳县', '471200', '0379');
INSERT INTO `phpcms_city` VALUES (1436, '中华人民共和国', '河南省', '洛阳市', '宜阳县', '471600', '0379');
INSERT INTO `phpcms_city` VALUES (1437, '中华人民共和国', '河南省', '洛阳市', '洛宁县', '471700', '0379');
INSERT INTO `phpcms_city` VALUES (1438, '中华人民共和国', '河南省', '洛阳市', '伊川县', '471300', '0379');
INSERT INTO `phpcms_city` VALUES (1439, '中华人民共和国', '河南省', '洛阳市', '偃师市', '471900', '0379');
INSERT INTO `phpcms_city` VALUES (1440, '中华人民共和国', '河南省', '平顶山市', '新华区', '467000', '0375');
INSERT INTO `phpcms_city` VALUES (1441, '中华人民共和国', '河南省', '平顶山市', '卫东区', '467000', '0375');
INSERT INTO `phpcms_city` VALUES (1442, '中华人民共和国', '河南省', '平顶山市', '石龙区', '467000', '0375');
INSERT INTO `phpcms_city` VALUES (1443, '中华人民共和国', '河南省', '平顶山市', '湛河区', '467000', '0375');
INSERT INTO `phpcms_city` VALUES (1444, '中华人民共和国', '河南省', '平顶山市', '宝丰县', '467400', '0375');
INSERT INTO `phpcms_city` VALUES (1445, '中华人民共和国', '河南省', '平顶山市', '叶县', '467200', '0375');
INSERT INTO `phpcms_city` VALUES (1446, '中华人民共和国', '河南省', '平顶山市', '鲁山县', '467300', '0375');
INSERT INTO `phpcms_city` VALUES (1447, '中华人民共和国', '河南省', '平顶山市', '郏县', '467100', '0375');
INSERT INTO `phpcms_city` VALUES (1448, '中华人民共和国', '河南省', '平顶山市', '舞钢市', '462500', '0375');
INSERT INTO `phpcms_city` VALUES (1449, '中华人民共和国', '河南省', '平顶山市', '汝州市', '467500', '0375');
INSERT INTO `phpcms_city` VALUES (1450, '中华人民共和国', '河南省', '安阳市', '文峰区', '455000', '0372');
INSERT INTO `phpcms_city` VALUES (1451, '中华人民共和国', '河南省', '安阳市', '北关区', '455000', '0372');
INSERT INTO `phpcms_city` VALUES (1452, '中华人民共和国', '河南省', '安阳市', '殷都区', '455000', '0372');
INSERT INTO `phpcms_city` VALUES (1453, '中华人民共和国', '河南省', '安阳市', '龙安区', '455000', '0372');
INSERT INTO `phpcms_city` VALUES (1454, '中华人民共和国', '河南省', '安阳市', '安阳县', '455100', '0372');
INSERT INTO `phpcms_city` VALUES (1455, '中华人民共和国', '河南省', '安阳市', '汤阴县', '456150', '0372');
INSERT INTO `phpcms_city` VALUES (1456, '中华人民共和国', '河南省', '安阳市', '滑县', '456400', '0372');
INSERT INTO `phpcms_city` VALUES (1457, '中华人民共和国', '河南省', '安阳市', '内黄县', '456300', '0372');
INSERT INTO `phpcms_city` VALUES (1458, '中华人民共和国', '河南省', '安阳市', '林州市', '456500', '0372');
INSERT INTO `phpcms_city` VALUES (1459, '中华人民共和国', '河南省', '鹤壁市', '鹤山区', '458000', '0392');
INSERT INTO `phpcms_city` VALUES (1460, '中华人民共和国', '河南省', '鹤壁市', '山城区', '458000', '0392');
INSERT INTO `phpcms_city` VALUES (1461, '中华人民共和国', '河南省', '鹤壁市', '淇滨区', '458000', '0392');
INSERT INTO `phpcms_city` VALUES (1462, '中华人民共和国', '河南省', '鹤壁市', '浚县', '456250', '0392');
INSERT INTO `phpcms_city` VALUES (1463, '中华人民共和国', '河南省', '鹤壁市', '淇县', '456750', '0392');
INSERT INTO `phpcms_city` VALUES (1464, '中华人民共和国', '河南省', '新乡市', '红旗区', '453000', '0373');
INSERT INTO `phpcms_city` VALUES (1465, '中华人民共和国', '河南省', '新乡市', '卫滨区', '453000', '0373');
INSERT INTO `phpcms_city` VALUES (1466, '中华人民共和国', '河南省', '新乡市', '凤泉区', '453000', '0373');
INSERT INTO `phpcms_city` VALUES (1467, '中华人民共和国', '河南省', '新乡市', '牧野区', '453000', '0373');
INSERT INTO `phpcms_city` VALUES (1468, '中华人民共和国', '河南省', '新乡市', '新乡县', '453700', '0373');
INSERT INTO `phpcms_city` VALUES (1469, '中华人民共和国', '河南省', '新乡市', '获嘉县', '453800', '0373');
INSERT INTO `phpcms_city` VALUES (1470, '中华人民共和国', '河南省', '新乡市', '原阳县', '453500', '0373');
INSERT INTO `phpcms_city` VALUES (1471, '中华人民共和国', '河南省', '新乡市', '延津县', '453200', '0373');
INSERT INTO `phpcms_city` VALUES (1472, '中华人民共和国', '河南省', '新乡市', '封丘县', '453300', '0373');
INSERT INTO `phpcms_city` VALUES (1473, '中华人民共和国', '河南省', '新乡市', '长垣县', '453400', '0373');
INSERT INTO `phpcms_city` VALUES (1474, '中华人民共和国', '河南省', '新乡市', '卫辉市', '453100', '0373');
INSERT INTO `phpcms_city` VALUES (1475, '中华人民共和国', '河南省', '新乡市', '辉县市', '453600', '0373');
INSERT INTO `phpcms_city` VALUES (1476, '中华人民共和国', '河南省', '焦作市', '解放区', '454150', '0391');
INSERT INTO `phpcms_city` VALUES (1477, '中华人民共和国', '河南省', '焦作市', '中站区', '454150', '0391');
INSERT INTO `phpcms_city` VALUES (1478, '中华人民共和国', '河南省', '焦作市', '马村区', '454150', '0391');
INSERT INTO `phpcms_city` VALUES (1479, '中华人民共和国', '河南省', '焦作市', '山阳区', '454150', '0391');
INSERT INTO `phpcms_city` VALUES (1480, '中华人民共和国', '河南省', '焦作市', '修武县', '454350', '0391');
INSERT INTO `phpcms_city` VALUES (1481, '中华人民共和国', '河南省', '焦作市', '博爱县', '454450', '0391');
INSERT INTO `phpcms_city` VALUES (1482, '中华人民共和国', '河南省', '焦作市', '武陟县', '454950', '0391');
INSERT INTO `phpcms_city` VALUES (1483, '中华人民共和国', '河南省', '焦作市', '温县', '454850', '0391');
INSERT INTO `phpcms_city` VALUES (1484, '中华人民共和国', '河南省', '焦作市', '济源市', '454650', '0391');
INSERT INTO `phpcms_city` VALUES (1485, '中华人民共和国', '河南省', '焦作市', '沁阳市', '454550', '0391');
INSERT INTO `phpcms_city` VALUES (1486, '中华人民共和国', '河南省', '焦作市', '孟州市', '454750', '0391');
INSERT INTO `phpcms_city` VALUES (1487, '中华人民共和国', '河南省', '濮阳市', '华龙区', '457000', '0393');
INSERT INTO `phpcms_city` VALUES (1488, '中华人民共和国', '河南省', '濮阳市', '清丰县', '457300', '0393');
INSERT INTO `phpcms_city` VALUES (1489, '中华人民共和国', '河南省', '濮阳市', '南乐县', '457400', '0393');
INSERT INTO `phpcms_city` VALUES (1490, '中华人民共和国', '河南省', '濮阳市', '范县', '457500', '0393');
INSERT INTO `phpcms_city` VALUES (1491, '中华人民共和国', '河南省', '濮阳市', '台前县', '457600', '0393');
INSERT INTO `phpcms_city` VALUES (1492, '中华人民共和国', '河南省', '濮阳市', '濮阳县', '457100', '0393');
INSERT INTO `phpcms_city` VALUES (1493, '中华人民共和国', '河南省', '许昌市', '魏都区', '461000', '0374');
INSERT INTO `phpcms_city` VALUES (1494, '中华人民共和国', '河南省', '许昌市', '许昌县', '461100', '0374');
INSERT INTO `phpcms_city` VALUES (1495, '中华人民共和国', '河南省', '许昌市', '鄢陵县', '461200', '0374');
INSERT INTO `phpcms_city` VALUES (1496, '中华人民共和国', '河南省', '许昌市', '襄城县', '452670', '0374');
INSERT INTO `phpcms_city` VALUES (1497, '中华人民共和国', '河南省', '许昌市', '禹州市', '452570', '0374');
INSERT INTO `phpcms_city` VALUES (1498, '中华人民共和国', '河南省', '许昌市', '长葛市', '461500', '0374');
INSERT INTO `phpcms_city` VALUES (1499, '中华人民共和国', '河南省', '漯河市', '源汇区', '462000', '0395');
INSERT INTO `phpcms_city` VALUES (1500, '中华人民共和国', '河南省', '漯河市', '郾城区', '462300', '0395');
INSERT INTO `phpcms_city` VALUES (1501, '中华人民共和国', '河南省', '漯河市', '召陵区', '462300', '0395');
INSERT INTO `phpcms_city` VALUES (1502, '中华人民共和国', '河南省', '漯河市', '舞阳县', '462400', '0395');
INSERT INTO `phpcms_city` VALUES (1503, '中华人民共和国', '河南省', '漯河市', '临颍县', '462600', '0395');
INSERT INTO `phpcms_city` VALUES (1504, '中华人民共和国', '河南省', '三门峡市', '湖滨区', '472000', '0398');
INSERT INTO `phpcms_city` VALUES (1505, '中华人民共和国', '河南省', '三门峡市', '渑池县', '472400', '0398');
INSERT INTO `phpcms_city` VALUES (1506, '中华人民共和国', '河南省', '三门峡市', '陕县', '472100', '0398');
INSERT INTO `phpcms_city` VALUES (1507, '中华人民共和国', '河南省', '三门峡市', '卢氏县', '472200', '0398');
INSERT INTO `phpcms_city` VALUES (1508, '中华人民共和国', '河南省', '三门峡市', '义马市', '472300', '0398');
INSERT INTO `phpcms_city` VALUES (1509, '中华人民共和国', '河南省', '三门峡市', '灵宝市', '472500', '0398');
INSERT INTO `phpcms_city` VALUES (1510, '中华人民共和国', '河南省', '南阳市', '宛城区', '473000', '0377');
INSERT INTO `phpcms_city` VALUES (1511, '中华人民共和国', '河南省', '南阳市', '卧龙区', '473000', '0377');
INSERT INTO `phpcms_city` VALUES (1512, '中华人民共和国', '河南省', '南阳市', '南召县', '474650', '0377');
INSERT INTO `phpcms_city` VALUES (1513, '中华人民共和国', '河南省', '南阳市', '方城县', '473200', '0377');
INSERT INTO `phpcms_city` VALUES (1514, '中华人民共和国', '河南省', '南阳市', '西峡县', '474550', '0377');
INSERT INTO `phpcms_city` VALUES (1515, '中华人民共和国', '河南省', '南阳市', '镇平县', '474250', '0377');
INSERT INTO `phpcms_city` VALUES (1516, '中华人民共和国', '河南省', '南阳市', '内乡县', '474350', '0377');
INSERT INTO `phpcms_city` VALUES (1517, '中华人民共和国', '河南省', '南阳市', '淅川县', '474450', '0377');
INSERT INTO `phpcms_city` VALUES (1518, '中华人民共和国', '河南省', '南阳市', '社旗县', '473300', '0377');
INSERT INTO `phpcms_city` VALUES (1519, '中华人民共和国', '河南省', '南阳市', '唐河县', '473400', '0377');
INSERT INTO `phpcms_city` VALUES (1520, '中华人民共和国', '河南省', '南阳市', '新野县', '473500', '0377');
INSERT INTO `phpcms_city` VALUES (1521, '中华人民共和国', '河南省', '南阳市', '桐柏县', '474750', '0377');
INSERT INTO `phpcms_city` VALUES (1522, '中华人民共和国', '河南省', '南阳市', '邓州市', '474150', '0377');
INSERT INTO `phpcms_city` VALUES (1523, '中华人民共和国', '河南省', '商丘市', '梁园区', '476000', '0370');
INSERT INTO `phpcms_city` VALUES (1524, '中华人民共和国', '河南省', '商丘市', '睢阳区', '476000', '0370');
INSERT INTO `phpcms_city` VALUES (1525, '中华人民共和国', '河南省', '商丘市', '民权县', '476800', '0370');
INSERT INTO `phpcms_city` VALUES (1526, '中华人民共和国', '河南省', '商丘市', '睢县', '476900', '0370');
INSERT INTO `phpcms_city` VALUES (1527, '中华人民共和国', '河南省', '商丘市', '宁陵县', '476700', '0370');
INSERT INTO `phpcms_city` VALUES (1528, '中华人民共和国', '河南省', '商丘市', '柘城县', '476200', '0370');
INSERT INTO `phpcms_city` VALUES (1529, '中华人民共和国', '河南省', '商丘市', '虞城县', '476300', '0370');
INSERT INTO `phpcms_city` VALUES (1530, '中华人民共和国', '河南省', '商丘市', '夏邑县', '476400', '0370');
INSERT INTO `phpcms_city` VALUES (1531, '中华人民共和国', '河南省', '商丘市', '永城市', '476600', '0370');
INSERT INTO `phpcms_city` VALUES (1532, '中华人民共和国', '河南省', '信阳市', '浉河区', '464000', '0376');
INSERT INTO `phpcms_city` VALUES (1533, '中华人民共和国', '河南省', '信阳市', '平桥区', '464000', '0376');
INSERT INTO `phpcms_city` VALUES (1534, '中华人民共和国', '河南省', '信阳市', '罗山县', '464200', '0376');
INSERT INTO `phpcms_city` VALUES (1535, '中华人民共和国', '河南省', '信阳市', '光山县', '465450', '0397');
INSERT INTO `phpcms_city` VALUES (1536, '中华人民共和国', '河南省', '信阳市', '新县', '465500', '0397');
INSERT INTO `phpcms_city` VALUES (1537, '中华人民共和国', '河南省', '信阳市', '商城县', '465350', '0397');
INSERT INTO `phpcms_city` VALUES (1538, '中华人民共和国', '河南省', '信阳市', '固始县', '465200', '0397');
INSERT INTO `phpcms_city` VALUES (1539, '中华人民共和国', '河南省', '信阳市', '潢川县', '465150', '0397');
INSERT INTO `phpcms_city` VALUES (1540, '中华人民共和国', '河南省', '信阳市', '淮滨县', '464400', '0397');
INSERT INTO `phpcms_city` VALUES (1541, '中华人民共和国', '河南省', '信阳市', '息县', '464300', '0397');
INSERT INTO `phpcms_city` VALUES (1542, '中华人民共和国', '河南省', '周口市', '川汇区', '466000', '0394');
INSERT INTO `phpcms_city` VALUES (1543, '中华人民共和国', '河南省', '周口市', '扶沟县', '461300', '0394');
INSERT INTO `phpcms_city` VALUES (1544, '中华人民共和国', '河南省', '周口市', '西华县', '466600', '0394');
INSERT INTO `phpcms_city` VALUES (1545, '中华人民共和国', '河南省', '周口市', '商水县', '466100', '0394');
INSERT INTO `phpcms_city` VALUES (1546, '中华人民共和国', '河南省', '周口市', '沈丘县', '466300', '0394');
INSERT INTO `phpcms_city` VALUES (1547, '中华人民共和国', '河南省', '周口市', '郸城县', '477150', '0394');
INSERT INTO `phpcms_city` VALUES (1548, '中华人民共和国', '河南省', '周口市', '淮阳县', '466700', '0394');
INSERT INTO `phpcms_city` VALUES (1549, '中华人民共和国', '河南省', '周口市', '太康县', '475400', '0394');
INSERT INTO `phpcms_city` VALUES (1550, '中华人民共和国', '河南省', '周口市', '鹿邑县', '477200', '0394');
INSERT INTO `phpcms_city` VALUES (1551, '中华人民共和国', '河南省', '周口市', '项城市', '466200', '0394');
INSERT INTO `phpcms_city` VALUES (1552, '中华人民共和国', '河南省', '驻马店市', '驿城区', '463000', '0396');
INSERT INTO `phpcms_city` VALUES (1553, '中华人民共和国', '河南省', '驻马店市', '西平县', '463900', '0396');
INSERT INTO `phpcms_city` VALUES (1554, '中华人民共和国', '河南省', '驻马店市', '上蔡县', '463800', '0396');
INSERT INTO `phpcms_city` VALUES (1555, '中华人民共和国', '河南省', '驻马店市', '平舆县', '463400', '0396');
INSERT INTO `phpcms_city` VALUES (1556, '中华人民共和国', '河南省', '驻马店市', '正阳县', '463600', '0396');
INSERT INTO `phpcms_city` VALUES (1557, '中华人民共和国', '河南省', '驻马店市', '确山县', '463200', '0396');
INSERT INTO `phpcms_city` VALUES (1558, '中华人民共和国', '河南省', '驻马店市', '泌阳县', '463700', '0396');
INSERT INTO `phpcms_city` VALUES (1559, '中华人民共和国', '河南省', '驻马店市', '汝南县', '463300', '0396');
INSERT INTO `phpcms_city` VALUES (1560, '中华人民共和国', '河南省', '驻马店市', '遂平县', '463100', '0396');
INSERT INTO `phpcms_city` VALUES (1561, '中华人民共和国', '河南省', '驻马店市', '新蔡县', '463500', '0396');
INSERT INTO `phpcms_city` VALUES (1562, '中华人民共和国', '湖北省', '武汉市', '江岸区', '430010', '027');
INSERT INTO `phpcms_city` VALUES (1563, '中华人民共和国', '湖北省', '武汉市', '江汉区', '430000', '027');
INSERT INTO `phpcms_city` VALUES (1564, '中华人民共和国', '湖北省', '武汉市', '硚口区', '430000', '027');
INSERT INTO `phpcms_city` VALUES (1565, '中华人民共和国', '湖北省', '武汉市', '汉阳区', '430050', '027');
INSERT INTO `phpcms_city` VALUES (1566, '中华人民共和国', '湖北省', '武汉市', '武昌区', '430000', '027');
INSERT INTO `phpcms_city` VALUES (1567, '中华人民共和国', '湖北省', '武汉市', '青山区', '430080', '027');
INSERT INTO `phpcms_city` VALUES (1568, '中华人民共和国', '湖北省', '武汉市', '洪山区', '430070', '027');
INSERT INTO `phpcms_city` VALUES (1569, '中华人民共和国', '湖北省', '武汉市', '东西湖区', '430040', '027');
INSERT INTO `phpcms_city` VALUES (1570, '中华人民共和国', '湖北省', '武汉市', '汉南区', '430090', '027');
INSERT INTO `phpcms_city` VALUES (1571, '中华人民共和国', '湖北省', '武汉市', '蔡甸区', '430100', '027');
INSERT INTO `phpcms_city` VALUES (1572, '中华人民共和国', '湖北省', '武汉市', '江夏区', '430200', '027');
INSERT INTO `phpcms_city` VALUES (1573, '中华人民共和国', '湖北省', '武汉市', '黄陂区', '432200', '027');
INSERT INTO `phpcms_city` VALUES (1574, '中华人民共和国', '湖北省', '武汉市', '新洲区', '431400', '027');
INSERT INTO `phpcms_city` VALUES (1575, '中华人民共和国', '湖北省', '黄石市', '黄石港区', '435000', '0714');
INSERT INTO `phpcms_city` VALUES (1576, '中华人民共和国', '湖北省', '黄石市', '西塞山区', '435000', '0714');
INSERT INTO `phpcms_city` VALUES (1577, '中华人民共和国', '湖北省', '黄石市', '下陆区', '435000', '0714');
INSERT INTO `phpcms_city` VALUES (1578, '中华人民共和国', '湖北省', '黄石市', '铁山区', '435000', '0714');
INSERT INTO `phpcms_city` VALUES (1579, '中华人民共和国', '湖北省', '黄石市', '阳新县', '435200', '0714');
INSERT INTO `phpcms_city` VALUES (1580, '中华人民共和国', '湖北省', '黄石市', '大冶市', '435100', '0714');
INSERT INTO `phpcms_city` VALUES (1581, '中华人民共和国', '湖北省', '十堰市', '茅箭区', '442000', '0719');
INSERT INTO `phpcms_city` VALUES (1582, '中华人民共和国', '湖北省', '十堰市', '张湾区', '442000', '0719');
INSERT INTO `phpcms_city` VALUES (1583, '中华人民共和国', '湖北省', '十堰市', '郧县', '442500', '0719');
INSERT INTO `phpcms_city` VALUES (1584, '中华人民共和国', '湖北省', '十堰市', '郧西县', '442600', '0719');
INSERT INTO `phpcms_city` VALUES (1585, '中华人民共和国', '湖北省', '十堰市', '竹山县', '442200', '0719');
INSERT INTO `phpcms_city` VALUES (1586, '中华人民共和国', '湖北省', '十堰市', '竹溪县', '442300', '0719');
INSERT INTO `phpcms_city` VALUES (1587, '中华人民共和国', '湖北省', '十堰市', '房县', '442100', '0719');
INSERT INTO `phpcms_city` VALUES (1588, '中华人民共和国', '湖北省', '十堰市', '丹江口市', '442700', '0719');
INSERT INTO `phpcms_city` VALUES (1589, '中华人民共和国', '湖北省', '宜昌市', '西陵区', '443000', '0717');
INSERT INTO `phpcms_city` VALUES (1590, '中华人民共和国', '湖北省', '宜昌市', '伍家岗区', '443000', '0717');
INSERT INTO `phpcms_city` VALUES (1591, '中华人民共和国', '湖北省', '宜昌市', '点军区', '443000', '0717');
INSERT INTO `phpcms_city` VALUES (1592, '中华人民共和国', '湖北省', '宜昌市', '猇亭区', '443000', '0717');
INSERT INTO `phpcms_city` VALUES (1593, '中华人民共和国', '湖北省', '宜昌市', '夷陵区', '443100', '0717');
INSERT INTO `phpcms_city` VALUES (1594, '中华人民共和国', '湖北省', '宜昌市', '远安县', '444200', '0717');
INSERT INTO `phpcms_city` VALUES (1595, '中华人民共和国', '湖北省', '宜昌市', '兴山县', '443700', '0717');
INSERT INTO `phpcms_city` VALUES (1596, '中华人民共和国', '湖北省', '宜昌市', '秭归县', '443600', '0717');
INSERT INTO `phpcms_city` VALUES (1597, '中华人民共和国', '湖北省', '宜昌市', '长阳土家族自治县', '443500', '0717');
INSERT INTO `phpcms_city` VALUES (1598, '中华人民共和国', '湖北省', '宜昌市', '五峰土家族自治县', '443400', '0717');
INSERT INTO `phpcms_city` VALUES (1599, '中华人民共和国', '湖北省', '宜昌市', '宜都市', '443000', '0717');
INSERT INTO `phpcms_city` VALUES (1600, '中华人民共和国', '湖北省', '宜昌市', '当阳市', '444100', '0717');
INSERT INTO `phpcms_city` VALUES (1601, '中华人民共和国', '湖北省', '宜昌市', '枝江市', '443200', '0717');
INSERT INTO `phpcms_city` VALUES (1602, '中华人民共和国', '湖北省', '襄樊市', '襄城区', '441000', '0710');
INSERT INTO `phpcms_city` VALUES (1603, '中华人民共和国', '湖北省', '襄樊市', '樊城区', '441000', '0710');
INSERT INTO `phpcms_city` VALUES (1604, '中华人民共和国', '湖北省', '襄樊市', '襄阳区', '441100', '0710');
INSERT INTO `phpcms_city` VALUES (1605, '中华人民共和国', '湖北省', '襄樊市', '南漳县', '441500', '0710');
INSERT INTO `phpcms_city` VALUES (1606, '中华人民共和国', '湖北省', '襄樊市', '谷城县', '441700', '0710');
INSERT INTO `phpcms_city` VALUES (1607, '中华人民共和国', '湖北省', '襄樊市', '保康县', '441600', '0710');
INSERT INTO `phpcms_city` VALUES (1608, '中华人民共和国', '湖北省', '襄樊市', '老河口市', '441800', '0710');
INSERT INTO `phpcms_city` VALUES (1609, '中华人民共和国', '湖北省', '襄樊市', '枣阳市', '441200', '0710');
INSERT INTO `phpcms_city` VALUES (1610, '中华人民共和国', '湖北省', '襄樊市', '宜城市', '441400', '0710');
INSERT INTO `phpcms_city` VALUES (1611, '中华人民共和国', '湖北省', '鄂州市', '梁子湖区', '436000', '0711');
INSERT INTO `phpcms_city` VALUES (1612, '中华人民共和国', '湖北省', '鄂州市', '华容区', '436000', '0711');
INSERT INTO `phpcms_city` VALUES (1613, '中华人民共和国', '湖北省', '鄂州市', '鄂城区', '436000', '0711');
INSERT INTO `phpcms_city` VALUES (1614, '中华人民共和国', '湖北省', '荆门市', '东宝区', '448000', '0724');
INSERT INTO `phpcms_city` VALUES (1615, '中华人民共和国', '湖北省', '荆门市', '掇刀区', '448000', '0724');
INSERT INTO `phpcms_city` VALUES (1616, '中华人民共和国', '湖北省', '荆门市', '京山县', '431800', '0724');
INSERT INTO `phpcms_city` VALUES (1617, '中华人民共和国', '湖北省', '荆门市', '沙洋县', '448200', '0724');
INSERT INTO `phpcms_city` VALUES (1618, '中华人民共和国', '湖北省', '荆门市', '钟祥市', '431900', '0724');
INSERT INTO `phpcms_city` VALUES (1619, '中华人民共和国', '湖北省', '孝感市', '孝南区', '432100', '0712');
INSERT INTO `phpcms_city` VALUES (1620, '中华人民共和国', '湖北省', '孝感市', '孝昌县', '432900', '0712');
INSERT INTO `phpcms_city` VALUES (1621, '中华人民共和国', '湖北省', '孝感市', '大悟县', '432800', '0712');
INSERT INTO `phpcms_city` VALUES (1622, '中华人民共和国', '湖北省', '孝感市', '云梦县', '432500', '0712');
INSERT INTO `phpcms_city` VALUES (1623, '中华人民共和国', '湖北省', '孝感市', '应城市', '432400', '0712');
INSERT INTO `phpcms_city` VALUES (1624, '中华人民共和国', '湖北省', '孝感市', '安陆市', '432600', '0712');
INSERT INTO `phpcms_city` VALUES (1625, '中华人民共和国', '湖北省', '孝感市', '汉川市', '432300', '0712');
INSERT INTO `phpcms_city` VALUES (1626, '中华人民共和国', '湖北省', '荆州市', '沙市区', '434000', '0716');
INSERT INTO `phpcms_city` VALUES (1627, '中华人民共和国', '湖北省', '荆州市', '荆州区', '434020', '0716');
INSERT INTO `phpcms_city` VALUES (1628, '中华人民共和国', '湖北省', '荆州市', '公安县', '434300', '0716');
INSERT INTO `phpcms_city` VALUES (1629, '中华人民共和国', '湖北省', '荆州市', '监利县', '433300', '0716');
INSERT INTO `phpcms_city` VALUES (1630, '中华人民共和国', '湖北省', '荆州市', '江陵县', '434100', '0716');
INSERT INTO `phpcms_city` VALUES (1631, '中华人民共和国', '湖北省', '荆州市', '石首市', '434400', '0716');
INSERT INTO `phpcms_city` VALUES (1632, '中华人民共和国', '湖北省', '荆州市', '洪湖市', '433200', '0716');
INSERT INTO `phpcms_city` VALUES (1633, '中华人民共和国', '湖北省', '荆州市', '松滋市', '434200', '0716');
INSERT INTO `phpcms_city` VALUES (1634, '中华人民共和国', '湖北省', '黄冈市', '黄州区', '438000', '0713');
INSERT INTO `phpcms_city` VALUES (1635, '中华人民共和国', '湖北省', '黄冈市', '团风县', '438000', '0713');
INSERT INTO `phpcms_city` VALUES (1636, '中华人民共和国', '湖北省', '黄冈市', '红安县', '438400', '0713');
INSERT INTO `phpcms_city` VALUES (1637, '中华人民共和国', '湖北省', '黄冈市', '罗田县', '438600', '0713');
INSERT INTO `phpcms_city` VALUES (1638, '中华人民共和国', '湖北省', '黄冈市', '英山县', '438700', '0713');
INSERT INTO `phpcms_city` VALUES (1639, '中华人民共和国', '湖北省', '黄冈市', '浠水县', '438200', '0713');
INSERT INTO `phpcms_city` VALUES (1640, '中华人民共和国', '湖北省', '黄冈市', '蕲春县', '435300', '0713');
INSERT INTO `phpcms_city` VALUES (1641, '中华人民共和国', '湖北省', '黄冈市', '黄梅县', '435500', '0713');
INSERT INTO `phpcms_city` VALUES (1642, '中华人民共和国', '湖北省', '黄冈市', '麻城市', '438300', '0713');
INSERT INTO `phpcms_city` VALUES (1643, '中华人民共和国', '湖北省', '黄冈市', '武穴市', '435400', '0713');
INSERT INTO `phpcms_city` VALUES (1644, '中华人民共和国', '湖北省', '咸宁市', '咸安区', '437000', '0715');
INSERT INTO `phpcms_city` VALUES (1645, '中华人民共和国', '湖北省', '咸宁市', '嘉鱼县', '437200', '0715');
INSERT INTO `phpcms_city` VALUES (1646, '中华人民共和国', '湖北省', '咸宁市', '通城县', '437400', '0715');
INSERT INTO `phpcms_city` VALUES (1647, '中华人民共和国', '湖北省', '咸宁市', '崇阳县', '437500', '0715');
INSERT INTO `phpcms_city` VALUES (1648, '中华人民共和国', '湖北省', '咸宁市', '通山县', '437600', '0715');
INSERT INTO `phpcms_city` VALUES (1649, '中华人民共和国', '湖北省', '咸宁市', '赤壁市', '437300', '0715');
INSERT INTO `phpcms_city` VALUES (1650, '中华人民共和国', '湖北省', '随州市', '曾都区', '441300', '0722');
INSERT INTO `phpcms_city` VALUES (1651, '中华人民共和国', '湖北省', '随州市', '广水市', '432700', '0722');
INSERT INTO `phpcms_city` VALUES (1652, '中华人民共和国', '湖北省', '恩施土家族苗族自治州', '恩施市', '445000', '0718');
INSERT INTO `phpcms_city` VALUES (1653, '中华人民共和国', '湖北省', '恩施土家族苗族自治州', '利川市', '445400', '0718');
INSERT INTO `phpcms_city` VALUES (1654, '中华人民共和国', '湖北省', '恩施土家族苗族自治州', '建始县', '445300', '0718');
INSERT INTO `phpcms_city` VALUES (1655, '中华人民共和国', '湖北省', '恩施土家族苗族自治州', '巴东县', '444300', '0718');
INSERT INTO `phpcms_city` VALUES (1656, '中华人民共和国', '湖北省', '恩施土家族苗族自治州', '宣恩县', '445500', '0718');
INSERT INTO `phpcms_city` VALUES (1657, '中华人民共和国', '湖北省', '恩施土家族苗族自治州', '咸丰县', '445600', '0718');
INSERT INTO `phpcms_city` VALUES (1658, '中华人民共和国', '湖北省', '恩施土家族苗族自治州', '来凤县', '445700', '0718');
INSERT INTO `phpcms_city` VALUES (1659, '中华人民共和国', '湖北省', '恩施土家族苗族自治州', '鹤峰县', '445800', '0718');
INSERT INTO `phpcms_city` VALUES (1660, '中华人民共和国', '湖北省', '仙桃市', '', '433000', '0728');
INSERT INTO `phpcms_city` VALUES (1661, '中华人民共和国', '湖北省', '潜江市', '', '433100', '0728');
INSERT INTO `phpcms_city` VALUES (1662, '中华人民共和国', '湖北省', '天门市', '', '431700', '0728');
INSERT INTO `phpcms_city` VALUES (1663, '中华人民共和国', '湖北省', '神农架林区', '', '442400', '0719');
INSERT INTO `phpcms_city` VALUES (1664, '中华人民共和国', '湖南省', '长沙市', '芙蓉区', '410000', '0731');
INSERT INTO `phpcms_city` VALUES (1665, '中华人民共和国', '湖南省', '长沙市', '天心区', '410000', '0731');
INSERT INTO `phpcms_city` VALUES (1666, '中华人民共和国', '湖南省', '长沙市', '岳麓区', '410000', '0731');
INSERT INTO `phpcms_city` VALUES (1667, '中华人民共和国', '湖南省', '长沙市', '开福区', '410000', '0731');
INSERT INTO `phpcms_city` VALUES (1668, '中华人民共和国', '湖南省', '长沙市', '雨花区', '410000', '0731');
INSERT INTO `phpcms_city` VALUES (1669, '中华人民共和国', '湖南省', '长沙市', '长沙县', '410100', '0731');
INSERT INTO `phpcms_city` VALUES (1670, '中华人民共和国', '湖南省', '长沙市', '望城县', '410200', '0731');
INSERT INTO `phpcms_city` VALUES (1671, '中华人民共和国', '湖南省', '长沙市', '宁乡县', '410600', '0731');
INSERT INTO `phpcms_city` VALUES (1672, '中华人民共和国', '湖南省', '长沙市', '浏阳市', '410300', '0731');
INSERT INTO `phpcms_city` VALUES (1673, '中华人民共和国', '湖南省', '株洲市', '荷塘区', '412000', '0733');
INSERT INTO `phpcms_city` VALUES (1674, '中华人民共和国', '湖南省', '株洲市', '芦淞区', '412000', '0733');
INSERT INTO `phpcms_city` VALUES (1675, '中华人民共和国', '湖南省', '株洲市', '石峰区', '412000', '0733');
INSERT INTO `phpcms_city` VALUES (1676, '中华人民共和国', '湖南省', '株洲市', '天元区', '412000', '0733');
INSERT INTO `phpcms_city` VALUES (1677, '中华人民共和国', '湖南省', '株洲市', '株洲县', '412000', '0733');
INSERT INTO `phpcms_city` VALUES (1678, '中华人民共和国', '湖南省', '株洲市', '攸县', '412300', '0733');
INSERT INTO `phpcms_city` VALUES (1679, '中华人民共和国', '湖南省', '株洲市', '茶陵县', '412400', '0733');
INSERT INTO `phpcms_city` VALUES (1680, '中华人民共和国', '湖南省', '株洲市', '炎陵县', '412500', '0733');
INSERT INTO `phpcms_city` VALUES (1681, '中华人民共和国', '湖南省', '株洲市', '醴陵市', '412200', '0733');
INSERT INTO `phpcms_city` VALUES (1682, '中华人民共和国', '湖南省', '湘潭市', '雨湖区', '411100', '0732');
INSERT INTO `phpcms_city` VALUES (1683, '中华人民共和国', '湖南省', '湘潭市', '岳塘区', '411100', '0732');
INSERT INTO `phpcms_city` VALUES (1684, '中华人民共和国', '湖南省', '湘潭市', '湘潭县', '411200', '0732');
INSERT INTO `phpcms_city` VALUES (1685, '中华人民共和国', '湖南省', '湘潭市', '湘乡市', '411400', '0732');
INSERT INTO `phpcms_city` VALUES (1686, '中华人民共和国', '湖南省', '湘潭市', '韶山市', '411300', '0732');
INSERT INTO `phpcms_city` VALUES (1687, '中华人民共和国', '湖南省', '衡阳市', '珠晖区', '421000', '0734');
INSERT INTO `phpcms_city` VALUES (1688, '中华人民共和国', '湖南省', '衡阳市', '雁峰区', '421000', '0734');
INSERT INTO `phpcms_city` VALUES (1689, '中华人民共和国', '湖南省', '衡阳市', '石鼓区', '421000', '0734');
INSERT INTO `phpcms_city` VALUES (1690, '中华人民共和国', '湖南省', '衡阳市', '蒸湘区', '421000', '0734');
INSERT INTO `phpcms_city` VALUES (1691, '中华人民共和国', '湖南省', '衡阳市', '南岳区', '421000', '0734');
INSERT INTO `phpcms_city` VALUES (1692, '中华人民共和国', '湖南省', '衡阳市', '衡阳县', '421200', '0734');
INSERT INTO `phpcms_city` VALUES (1693, '中华人民共和国', '湖南省', '衡阳市', '衡南县', '421100', '0734');
INSERT INTO `phpcms_city` VALUES (1694, '中华人民共和国', '湖南省', '衡阳市', '衡山县', '421300', '0734');
INSERT INTO `phpcms_city` VALUES (1695, '中华人民共和国', '湖南省', '衡阳市', '衡东县', '421400', '0734');
INSERT INTO `phpcms_city` VALUES (1696, '中华人民共和国', '湖南省', '衡阳市', '祁东县', '421600', '0734');
INSERT INTO `phpcms_city` VALUES (1697, '中华人民共和国', '湖南省', '衡阳市', '耒阳市', '421800', '0734');
INSERT INTO `phpcms_city` VALUES (1698, '中华人民共和国', '湖南省', '衡阳市', '常宁市', '421500', '0734');
INSERT INTO `phpcms_city` VALUES (1699, '中华人民共和国', '湖南省', '邵阳市', '双清区', '422000', '0739');
INSERT INTO `phpcms_city` VALUES (1700, '中华人民共和国', '湖南省', '邵阳市', '大祥区', '422000', '0739');
INSERT INTO `phpcms_city` VALUES (1701, '中华人民共和国', '湖南省', '邵阳市', '北塔区', '422000', '0739');
INSERT INTO `phpcms_city` VALUES (1702, '中华人民共和国', '湖南省', '邵阳市', '邵东县', '422800', '0739');
INSERT INTO `phpcms_city` VALUES (1703, '中华人民共和国', '湖南省', '邵阳市', '新邵县', '422900', '0739');
INSERT INTO `phpcms_city` VALUES (1704, '中华人民共和国', '湖南省', '邵阳市', '邵阳县', '422100', '0739');
INSERT INTO `phpcms_city` VALUES (1705, '中华人民共和国', '湖南省', '邵阳市', '隆回县', '422200', '0739');
INSERT INTO `phpcms_city` VALUES (1706, '中华人民共和国', '湖南省', '邵阳市', '洞口县', '422300', '0739');
INSERT INTO `phpcms_city` VALUES (1707, '中华人民共和国', '湖南省', '邵阳市', '绥宁县', '422600', '0739');
INSERT INTO `phpcms_city` VALUES (1708, '中华人民共和国', '湖南省', '邵阳市', '新宁县', '422700', '0739');
INSERT INTO `phpcms_city` VALUES (1709, '中华人民共和国', '湖南省', '邵阳市', '城步苗族自治县', '422500', '0739');
INSERT INTO `phpcms_city` VALUES (1710, '中华人民共和国', '湖南省', '邵阳市', '武冈市', '422400', '0739');
INSERT INTO `phpcms_city` VALUES (1711, '中华人民共和国', '湖南省', '岳阳市', '岳阳楼区', '414000', '0730');
INSERT INTO `phpcms_city` VALUES (1712, '中华人民共和国', '湖南省', '岳阳市', '云溪区', '414000', '0730');
INSERT INTO `phpcms_city` VALUES (1713, '中华人民共和国', '湖南省', '岳阳市', '君山区', '414000', '0730');
INSERT INTO `phpcms_city` VALUES (1714, '中华人民共和国', '湖南省', '岳阳市', '岳阳县', '414100', '0730');
INSERT INTO `phpcms_city` VALUES (1715, '中华人民共和国', '湖南省', '岳阳市', '华容县', '414200', '0730');
INSERT INTO `phpcms_city` VALUES (1716, '中华人民共和国', '湖南省', '岳阳市', '湘阴县', '410500', '0730');
INSERT INTO `phpcms_city` VALUES (1717, '中华人民共和国', '湖南省', '岳阳市', '平江县', '410400', '0730');
INSERT INTO `phpcms_city` VALUES (1718, '中华人民共和国', '湖南省', '岳阳市', '汨罗市', '414400', '0730');
INSERT INTO `phpcms_city` VALUES (1719, '中华人民共和国', '湖南省', '岳阳市', '临湘市', '414300', '0730');
INSERT INTO `phpcms_city` VALUES (1720, '中华人民共和国', '湖南省', '常德市', '武陵区', '415000', '0736');
INSERT INTO `phpcms_city` VALUES (1721, '中华人民共和国', '湖南省', '常德市', '鼎城区', '415100', '0736');
INSERT INTO `phpcms_city` VALUES (1722, '中华人民共和国', '湖南省', '常德市', '安乡县', '415600', '0736');
INSERT INTO `phpcms_city` VALUES (1723, '中华人民共和国', '湖南省', '常德市', '汉寿县', '415900', '0736');
INSERT INTO `phpcms_city` VALUES (1724, '中华人民共和国', '湖南省', '常德市', '澧县', '415500', '0736');
INSERT INTO `phpcms_city` VALUES (1725, '中华人民共和国', '湖南省', '常德市', '临澧县', '415200', '0736');
INSERT INTO `phpcms_city` VALUES (1726, '中华人民共和国', '湖南省', '常德市', '桃源县', '415700', '0736');
INSERT INTO `phpcms_city` VALUES (1727, '中华人民共和国', '湖南省', '常德市', '石门县', '415300', '0736');
INSERT INTO `phpcms_city` VALUES (1728, '中华人民共和国', '湖南省', '常德市', '津市市', '415400', '0736');
INSERT INTO `phpcms_city` VALUES (1729, '中华人民共和国', '湖南省', '张家界市', '永定区', '427000', '0744');
INSERT INTO `phpcms_city` VALUES (1730, '中华人民共和国', '湖南省', '张家界市', '武陵源区', '427400', '0744');
INSERT INTO `phpcms_city` VALUES (1731, '中华人民共和国', '湖南省', '张家界市', '慈利县', '427200', '0744');
INSERT INTO `phpcms_city` VALUES (1732, '中华人民共和国', '湖南省', '张家界市', '桑植县', '427100', '0744');
INSERT INTO `phpcms_city` VALUES (1733, '中华人民共和国', '湖南省', '益阳市', '资阳区', '413000', '0737');
INSERT INTO `phpcms_city` VALUES (1734, '中华人民共和国', '湖南省', '益阳市', '赫山区', '413000', '0737');
INSERT INTO `phpcms_city` VALUES (1735, '中华人民共和国', '湖南省', '益阳市', '南县', '413200', '0737');
INSERT INTO `phpcms_city` VALUES (1736, '中华人民共和国', '湖南省', '益阳市', '桃江县', '413400', '0737');
INSERT INTO `phpcms_city` VALUES (1737, '中华人民共和国', '湖南省', '益阳市', '安化县', '413500', '0737');
INSERT INTO `phpcms_city` VALUES (1738, '中华人民共和国', '湖南省', '益阳市', '沅江市', '413100', '0737');
INSERT INTO `phpcms_city` VALUES (1739, '中华人民共和国', '湖南省', '郴州市', '北湖区', '423000', '0735');
INSERT INTO `phpcms_city` VALUES (1740, '中华人民共和国', '湖南省', '郴州市', '苏仙区', '423000', '0735');
INSERT INTO `phpcms_city` VALUES (1741, '中华人民共和国', '湖南省', '郴州市', '桂阳县', '424400', '0735');
INSERT INTO `phpcms_city` VALUES (1742, '中华人民共和国', '湖南省', '郴州市', '宜章县', '424200', '0735');
INSERT INTO `phpcms_city` VALUES (1743, '中华人民共和国', '湖南省', '郴州市', '永兴县', '423300', '0735');
INSERT INTO `phpcms_city` VALUES (1744, '中华人民共和国', '湖南省', '郴州市', '嘉禾县', '424500', '0735');
INSERT INTO `phpcms_city` VALUES (1745, '中华人民共和国', '湖南省', '郴州市', '临武县', '424300', '0735');
INSERT INTO `phpcms_city` VALUES (1746, '中华人民共和国', '湖南省', '郴州市', '汝城县', '424100', '0735');
INSERT INTO `phpcms_city` VALUES (1747, '中华人民共和国', '湖南省', '郴州市', '桂东县', '423500', '0735');
INSERT INTO `phpcms_city` VALUES (1748, '中华人民共和国', '湖南省', '郴州市', '安仁县', '423600', '0735');
INSERT INTO `phpcms_city` VALUES (1749, '中华人民共和国', '湖南省', '郴州市', '资兴市', '423400', '0735');
INSERT INTO `phpcms_city` VALUES (1750, '中华人民共和国', '湖南省', '永州市', '零陵区', '425000', '0746');
INSERT INTO `phpcms_city` VALUES (1751, '中华人民共和国', '湖南省', '永州市', '冷水滩区', '425000', '0746');
INSERT INTO `phpcms_city` VALUES (1752, '中华人民共和国', '湖南省', '永州市', '祁阳县', '426100', '0746');
INSERT INTO `phpcms_city` VALUES (1753, '中华人民共和国', '湖南省', '永州市', '东安县', '425900', '0746');
INSERT INTO `phpcms_city` VALUES (1754, '中华人民共和国', '湖南省', '永州市', '双牌县', '425200', '0746');
INSERT INTO `phpcms_city` VALUES (1755, '中华人民共和国', '湖南省', '永州市', '道县', '425300', '0746');
INSERT INTO `phpcms_city` VALUES (1756, '中华人民共和国', '湖南省', '永州市', '江永县', '425400', '0746');
INSERT INTO `phpcms_city` VALUES (1757, '中华人民共和国', '湖南省', '永州市', '宁远县', '425600', '0746');
INSERT INTO `phpcms_city` VALUES (1758, '中华人民共和国', '湖南省', '永州市', '蓝山县', '425800', '0746');
INSERT INTO `phpcms_city` VALUES (1759, '中华人民共和国', '湖南省', '永州市', '新田县', '425700', '0746');
INSERT INTO `phpcms_city` VALUES (1760, '中华人民共和国', '湖南省', '永州市', '江华瑶族自治县', '425500', '0746');
INSERT INTO `phpcms_city` VALUES (1761, '中华人民共和国', '湖南省', '怀化市', '鹤城区', '418000', '0745');
INSERT INTO `phpcms_city` VALUES (1762, '中华人民共和国', '湖南省', '怀化市', '中方县', '418000', '0745');
INSERT INTO `phpcms_city` VALUES (1763, '中华人民共和国', '湖南省', '怀化市', '沅陵县', '419600', '0745');
INSERT INTO `phpcms_city` VALUES (1764, '中华人民共和国', '湖南省', '怀化市', '辰溪县', '419500', '0745');
INSERT INTO `phpcms_city` VALUES (1765, '中华人民共和国', '湖南省', '怀化市', '溆浦县', '419300', '0745');
INSERT INTO `phpcms_city` VALUES (1766, '中华人民共和国', '湖南省', '怀化市', '会同县', '418300', '0745');
INSERT INTO `phpcms_city` VALUES (1767, '中华人民共和国', '湖南省', '怀化市', '麻阳苗族自治县', '419400', '0745');
INSERT INTO `phpcms_city` VALUES (1768, '中华人民共和国', '湖南省', '怀化市', '新晃侗族自治县', '419200', '0745');
INSERT INTO `phpcms_city` VALUES (1769, '中华人民共和国', '湖南省', '怀化市', '芷江侗族自治县', '419100', '0745');
INSERT INTO `phpcms_city` VALUES (1770, '中华人民共和国', '湖南省', '怀化市', '靖州苗族侗族自治县', '418400', '0745');
INSERT INTO `phpcms_city` VALUES (1771, '中华人民共和国', '湖南省', '怀化市', '通道侗族自治县', '418500', '0745');
INSERT INTO `phpcms_city` VALUES (1772, '中华人民共和国', '湖南省', '怀化市', '洪江市', '418200', '0745');
INSERT INTO `phpcms_city` VALUES (1773, '中华人民共和国', '湖南省', '娄底市', '娄星区', '417000', '0738');
INSERT INTO `phpcms_city` VALUES (1774, '中华人民共和国', '湖南省', '娄底市', '双峰县', '417700', '0738');
INSERT INTO `phpcms_city` VALUES (1775, '中华人民共和国', '湖南省', '娄底市', '新化县', '417600', '0738');
INSERT INTO `phpcms_city` VALUES (1776, '中华人民共和国', '湖南省', '娄底市', '冷水江市', '417500', '0738');
INSERT INTO `phpcms_city` VALUES (1777, '中华人民共和国', '湖南省', '娄底市', '涟源市', '417100', '0738');
INSERT INTO `phpcms_city` VALUES (1778, '中华人民共和国', '湖南省', '湘西土家族苗族自治州', '吉首市', '416000', '0743');
INSERT INTO `phpcms_city` VALUES (1779, '中华人民共和国', '湖南省', '湘西土家族苗族自治州', '泸溪县', '416100', '0743');
INSERT INTO `phpcms_city` VALUES (1780, '中华人民共和国', '湖南省', '湘西土家族苗族自治州', '凤凰县', '416200', '0743');
INSERT INTO `phpcms_city` VALUES (1781, '中华人民共和国', '湖南省', '湘西土家族苗族自治州', '花垣县', '416400', '0743');
INSERT INTO `phpcms_city` VALUES (1782, '中华人民共和国', '湖南省', '湘西土家族苗族自治州', '保靖县', '416500', '0743');
INSERT INTO `phpcms_city` VALUES (1783, '中华人民共和国', '湖南省', '湘西土家族苗族自治州', '古丈县', '416300', '0743');
INSERT INTO `phpcms_city` VALUES (1784, '中华人民共和国', '湖南省', '湘西土家族苗族自治州', '永顺县', '416700', '0743');
INSERT INTO `phpcms_city` VALUES (1785, '中华人民共和国', '湖南省', '湘西土家族苗族自治州', '龙山县', '416800', '0743');
INSERT INTO `phpcms_city` VALUES (1786, '中华人民共和国', '广东省', '广州市', '荔湾区', '510100', '020');
INSERT INTO `phpcms_city` VALUES (1787, '中华人民共和国', '广东省', '广州市', '越秀区', '510000', '020');
INSERT INTO `phpcms_city` VALUES (1788, '中华人民共和国', '广东省', '广州市', '海珠区', '510200', '020');
INSERT INTO `phpcms_city` VALUES (1789, '中华人民共和国', '广东省', '广州市', '天河区', '510600', '020');
INSERT INTO `phpcms_city` VALUES (1790, '中华人民共和国', '广东省', '广州市', '白云区', '510400', '020');
INSERT INTO `phpcms_city` VALUES (1791, '中华人民共和国', '广东省', '广州市', '黄埔区', '510700', '020');
INSERT INTO `phpcms_city` VALUES (1792, '中华人民共和国', '广东省', '广州市', '番禺区', '511400', '020');
INSERT INTO `phpcms_city` VALUES (1793, '中华人民共和国', '广东省', '广州市', '花都区', '510800', '020');
INSERT INTO `phpcms_city` VALUES (1794, '中华人民共和国', '广东省', '广州市', '南沙区', '511400', '020');
INSERT INTO `phpcms_city` VALUES (1795, '中华人民共和国', '广东省', '广州市', '萝岗区', '510700', '020');
INSERT INTO `phpcms_city` VALUES (1796, '中华人民共和国', '广东省', '广州市', '增城市', '511300', '020');
INSERT INTO `phpcms_city` VALUES (1797, '中华人民共和国', '广东省', '广州市', '从化市', '510900', '020');
INSERT INTO `phpcms_city` VALUES (1798, '中华人民共和国', '广东省', '韶关市', '武江区', '512000', '0751');
INSERT INTO `phpcms_city` VALUES (1799, '中华人民共和国', '广东省', '韶关市', '浈江区', '512000', '0751');
INSERT INTO `phpcms_city` VALUES (1800, '中华人民共和国', '广东省', '韶关市', '曲江区', '512100', '0751');
INSERT INTO `phpcms_city` VALUES (1801, '中华人民共和国', '广东省', '韶关市', '始兴县', '512500', '0751');
INSERT INTO `phpcms_city` VALUES (1802, '中华人民共和国', '广东省', '韶关市', '仁化县', '512300', '0751');
INSERT INTO `phpcms_city` VALUES (1803, '中华人民共和国', '广东省', '韶关市', '翁源县', '512600', '0751');
INSERT INTO `phpcms_city` VALUES (1804, '中华人民共和国', '广东省', '韶关市', '乳源瑶族自治县', '512600', '0751');
INSERT INTO `phpcms_city` VALUES (1805, '中华人民共和国', '广东省', '韶关市', '新丰县', '511100', '0751');
INSERT INTO `phpcms_city` VALUES (1806, '中华人民共和国', '广东省', '韶关市', '乐昌市', '512200', '0751');
INSERT INTO `phpcms_city` VALUES (1807, '中华人民共和国', '广东省', '韶关市', '南雄市', '512400', '0751');
INSERT INTO `phpcms_city` VALUES (1808, '中华人民共和国', '广东省', '深圳市', '罗湖区', '518000', '0755');
INSERT INTO `phpcms_city` VALUES (1809, '中华人民共和国', '广东省', '深圳市', '福田区', '518000', '0755');
INSERT INTO `phpcms_city` VALUES (1810, '中华人民共和国', '广东省', '深圳市', '南山区', '518000', '0755');
INSERT INTO `phpcms_city` VALUES (1811, '中华人民共和国', '广东省', '深圳市', '宝安区', '518100', '0755');
INSERT INTO `phpcms_city` VALUES (1812, '中华人民共和国', '广东省', '深圳市', '龙岗区', '518100', '0755');
INSERT INTO `phpcms_city` VALUES (1813, '中华人民共和国', '广东省', '深圳市', '盐田区', '518000', '0755');
INSERT INTO `phpcms_city` VALUES (1814, '中华人民共和国', '广东省', '珠海市', '香洲区', '519000', '0756');
INSERT INTO `phpcms_city` VALUES (1815, '中华人民共和国', '广东省', '珠海市', '斗门区', '519100', '0756');
INSERT INTO `phpcms_city` VALUES (1816, '中华人民共和国', '广东省', '珠海市', '金湾区', '519090', '0756');
INSERT INTO `phpcms_city` VALUES (1817, '中华人民共和国', '广东省', '汕头市', '龙湖区', '515000', '0754');
INSERT INTO `phpcms_city` VALUES (1818, '中华人民共和国', '广东省', '汕头市', '金平区', '515000', '0754');
INSERT INTO `phpcms_city` VALUES (1819, '中华人民共和国', '广东省', '汕头市', '濠江区', '515000', '0754');
INSERT INTO `phpcms_city` VALUES (1820, '中华人民共和国', '广东省', '汕头市', '潮阳区', '515100', '0754');
INSERT INTO `phpcms_city` VALUES (1821, '中华人民共和国', '广东省', '汕头市', '潮南区', '515000', '0754');
INSERT INTO `phpcms_city` VALUES (1822, '中华人民共和国', '广东省', '汕头市', '澄海区', '515800', '0754');
INSERT INTO `phpcms_city` VALUES (1823, '中华人民共和国', '广东省', '汕头市', '南澳县', '515900', '0754');
INSERT INTO `phpcms_city` VALUES (1824, '中华人民共和国', '广东省', '佛山市', '禅城区', '528000', '0757');
INSERT INTO `phpcms_city` VALUES (1825, '中华人民共和国', '广东省', '佛山市', '南海区', '528200', '0757');
INSERT INTO `phpcms_city` VALUES (1826, '中华人民共和国', '广东省', '佛山市', '顺德区', '528300', '0757');
INSERT INTO `phpcms_city` VALUES (1827, '中华人民共和国', '广东省', '佛山市', '三水区', '528100', '0757');
INSERT INTO `phpcms_city` VALUES (1828, '中华人民共和国', '广东省', '佛山市', '高明区', '528500', '0757');
INSERT INTO `phpcms_city` VALUES (1829, '中华人民共和国', '广东省', '江门市', '蓬江区', '529000', '0750');
INSERT INTO `phpcms_city` VALUES (1830, '中华人民共和国', '广东省', '江门市', '江海区', '529000', '0750');
INSERT INTO `phpcms_city` VALUES (1831, '中华人民共和国', '广东省', '江门市', '新会区', '529100', '0750');
INSERT INTO `phpcms_city` VALUES (1832, '中华人民共和国', '广东省', '江门市', '台山市', '529200', '0750');
INSERT INTO `phpcms_city` VALUES (1833, '中华人民共和国', '广东省', '江门市', '开平市', '529300', '0750');
INSERT INTO `phpcms_city` VALUES (1834, '中华人民共和国', '广东省', '江门市', '鹤山市', '529700', '0750');
INSERT INTO `phpcms_city` VALUES (1835, '中华人民共和国', '广东省', '江门市', '恩平市', '529400', '0750');
INSERT INTO `phpcms_city` VALUES (1836, '中华人民共和国', '广东省', '湛江市', '赤坎区', '524000', '0759');
INSERT INTO `phpcms_city` VALUES (1837, '中华人民共和国', '广东省', '湛江市', '霞山区', '524000', '0759');
INSERT INTO `phpcms_city` VALUES (1838, '中华人民共和国', '广东省', '湛江市', '坡头区', '524000', '0759');
INSERT INTO `phpcms_city` VALUES (1839, '中华人民共和国', '广东省', '湛江市', '麻章区', '524000', '0759');
INSERT INTO `phpcms_city` VALUES (1840, '中华人民共和国', '广东省', '湛江市', '遂溪县', '524300', '0759');
INSERT INTO `phpcms_city` VALUES (1841, '中华人民共和国', '广东省', '湛江市', '徐闻县', '524100', '0759');
INSERT INTO `phpcms_city` VALUES (1842, '中华人民共和国', '广东省', '湛江市', '廉江市', '524400', '0759');
INSERT INTO `phpcms_city` VALUES (1843, '中华人民共和国', '广东省', '湛江市', '雷州市', '524200', '0759');
INSERT INTO `phpcms_city` VALUES (1844, '中华人民共和国', '广东省', '湛江市', '吴川市', '524500', '0759');
INSERT INTO `phpcms_city` VALUES (1845, '中华人民共和国', '广东省', '茂名市', '茂南区', '525000', '0668');
INSERT INTO `phpcms_city` VALUES (1846, '中华人民共和国', '广东省', '茂名市', '茂港区', '525000', '0668');
INSERT INTO `phpcms_city` VALUES (1847, '中华人民共和国', '广东省', '茂名市', '电白县', '525400', '0668');
INSERT INTO `phpcms_city` VALUES (1848, '中华人民共和国', '广东省', '茂名市', '高州市', '525200', '0668');
INSERT INTO `phpcms_city` VALUES (1849, '中华人民共和国', '广东省', '茂名市', '化州市', '525100', '0668');
INSERT INTO `phpcms_city` VALUES (1850, '中华人民共和国', '广东省', '茂名市', '信宜市', '525300', '0668');
INSERT INTO `phpcms_city` VALUES (1851, '中华人民共和国', '广东省', '肇庆市', '端州区', '526000', '0758');
INSERT INTO `phpcms_city` VALUES (1852, '中华人民共和国', '广东省', '肇庆市', '鼎湖区', '526000', '0758');
INSERT INTO `phpcms_city` VALUES (1853, '中华人民共和国', '广东省', '肇庆市', '广宁县', '526300', '0758');
INSERT INTO `phpcms_city` VALUES (1854, '中华人民共和国', '广东省', '肇庆市', '怀集县', '526400', '0758');
INSERT INTO `phpcms_city` VALUES (1855, '中华人民共和国', '广东省', '肇庆市', '封开县', '526500', '0758');
INSERT INTO `phpcms_city` VALUES (1856, '中华人民共和国', '广东省', '肇庆市', '德庆县', '526600', '0758');
INSERT INTO `phpcms_city` VALUES (1857, '中华人民共和国', '广东省', '肇庆市', '高要市', '526100', '0758');
INSERT INTO `phpcms_city` VALUES (1858, '中华人民共和国', '广东省', '肇庆市', '四会市', '526200', '0758');
INSERT INTO `phpcms_city` VALUES (1859, '中华人民共和国', '广东省', '惠州市', '惠城区', '516000', '0752');
INSERT INTO `phpcms_city` VALUES (1860, '中华人民共和国', '广东省', '惠州市', '惠阳区', '516200', '0752');
INSERT INTO `phpcms_city` VALUES (1861, '中华人民共和国', '广东省', '惠州市', '博罗县', '516100', '0752');
INSERT INTO `phpcms_city` VALUES (1862, '中华人民共和国', '广东省', '惠州市', '惠东县', '516300', '0752');
INSERT INTO `phpcms_city` VALUES (1863, '中华人民共和国', '广东省', '惠州市', '龙门县', '516800', '0752');
INSERT INTO `phpcms_city` VALUES (1864, '中华人民共和国', '广东省', '梅州市', '梅江区', '514000', '0753');
INSERT INTO `phpcms_city` VALUES (1865, '中华人民共和国', '广东省', '梅州市', '梅县', '514700', '0753');
INSERT INTO `phpcms_city` VALUES (1866, '中华人民共和国', '广东省', '梅州市', '大埔县', '514200', '0753');
INSERT INTO `phpcms_city` VALUES (1867, '中华人民共和国', '广东省', '梅州市', '丰顺县', '514300', '0753');
INSERT INTO `phpcms_city` VALUES (1868, '中华人民共和国', '广东省', '梅州市', '五华县', '514400', '0753');
INSERT INTO `phpcms_city` VALUES (1869, '中华人民共和国', '广东省', '梅州市', '平远县', '514600', '0753');
INSERT INTO `phpcms_city` VALUES (1870, '中华人民共和国', '广东省', '梅州市', '蕉岭县', '514100', '0753');
INSERT INTO `phpcms_city` VALUES (1871, '中华人民共和国', '广东省', '梅州市', '兴宁市', '514500', '0753');
INSERT INTO `phpcms_city` VALUES (1872, '中华人民共和国', '广东省', '汕尾市', '城区', '516600', '0660');
INSERT INTO `phpcms_city` VALUES (1873, '中华人民共和国', '广东省', '汕尾市', '海丰县', '516400', '0660');
INSERT INTO `phpcms_city` VALUES (1874, '中华人民共和国', '广东省', '汕尾市', '陆河县', '516700', '0660');
INSERT INTO `phpcms_city` VALUES (1875, '中华人民共和国', '广东省', '汕尾市', '陆丰市', '516500', '0660');
INSERT INTO `phpcms_city` VALUES (1876, '中华人民共和国', '广东省', '河源市', '源城区', '517000', '0762');
INSERT INTO `phpcms_city` VALUES (1877, '中华人民共和国', '广东省', '河源市', '紫金县', '517400', '0762');
INSERT INTO `phpcms_city` VALUES (1878, '中华人民共和国', '广东省', '河源市', '龙川县', '517300', '0762');
INSERT INTO `phpcms_city` VALUES (1879, '中华人民共和国', '广东省', '河源市', '连平县', '517100', '0762');
INSERT INTO `phpcms_city` VALUES (1880, '中华人民共和国', '广东省', '河源市', '和平县', '517200', '0762');
INSERT INTO `phpcms_city` VALUES (1881, '中华人民共和国', '广东省', '河源市', '东源县', '517500', '0762');
INSERT INTO `phpcms_city` VALUES (1882, '中华人民共和国', '广东省', '阳江市', '江城区', '529500', '0662');
INSERT INTO `phpcms_city` VALUES (1883, '中华人民共和国', '广东省', '阳江市', '阳西县', '529800', '0662');
INSERT INTO `phpcms_city` VALUES (1884, '中华人民共和国', '广东省', '阳江市', '阳东县', '529900', '0662');
INSERT INTO `phpcms_city` VALUES (1885, '中华人民共和国', '广东省', '阳江市', '阳春市', '529600', '0662');
INSERT INTO `phpcms_city` VALUES (1886, '中华人民共和国', '广东省', '清远市', '清城区', '511500', '0763');
INSERT INTO `phpcms_city` VALUES (1887, '中华人民共和国', '广东省', '清远市', '佛冈县', '511600', '0763');
INSERT INTO `phpcms_city` VALUES (1888, '中华人民共和国', '广东省', '清远市', '阳山县', '513100', '0763');
INSERT INTO `phpcms_city` VALUES (1889, '中华人民共和国', '广东省', '清远市', '连山壮族瑶族自治县', '513200', '0763');
INSERT INTO `phpcms_city` VALUES (1890, '中华人民共和国', '广东省', '清远市', '连南瑶族自治县', '513300', '0763');
INSERT INTO `phpcms_city` VALUES (1891, '中华人民共和国', '广东省', '清远市', '清新县', '511800', '0763');
INSERT INTO `phpcms_city` VALUES (1892, '中华人民共和国', '广东省', '清远市', '英德市', '513000', '0763');
INSERT INTO `phpcms_city` VALUES (1893, '中华人民共和国', '广东省', '清远市', '连州市', '513400', '0763');
INSERT INTO `phpcms_city` VALUES (1894, '中华人民共和国', '广东省', '东莞市', '', '523000', '0769');
INSERT INTO `phpcms_city` VALUES (1895, '中华人民共和国', '广东省', '中山市', '', '528400', '0760');
INSERT INTO `phpcms_city` VALUES (1896, '中华人民共和国', '广东省', '潮州市', '湘桥区', '521000', '0768');
INSERT INTO `phpcms_city` VALUES (1897, '中华人民共和国', '广东省', '潮州市', '潮安县', '515600', '0768');
INSERT INTO `phpcms_city` VALUES (1898, '中华人民共和国', '广东省', '潮州市', '饶平县', '515700', '0768');
INSERT INTO `phpcms_city` VALUES (1899, '中华人民共和国', '广东省', '揭阳市', '榕城区', '522000', '0663');
INSERT INTO `phpcms_city` VALUES (1900, '中华人民共和国', '广东省', '揭阳市', '揭东县', '515500', '0663');
INSERT INTO `phpcms_city` VALUES (1901, '中华人民共和国', '广东省', '揭阳市', '揭西县', '515400', '0663');
INSERT INTO `phpcms_city` VALUES (1902, '中华人民共和国', '广东省', '揭阳市', '惠来县', '515200', '0663');
INSERT INTO `phpcms_city` VALUES (1903, '中华人民共和国', '广东省', '揭阳市', '普宁市', '515300', '0663');
INSERT INTO `phpcms_city` VALUES (1904, '中华人民共和国', '广东省', '云浮市', '云城区', '527300', '0766');
INSERT INTO `phpcms_city` VALUES (1905, '中华人民共和国', '广东省', '云浮市', '新兴县', '527400', '0766');
INSERT INTO `phpcms_city` VALUES (1906, '中华人民共和国', '广东省', '云浮市', '郁南县', '527100', '0766');
INSERT INTO `phpcms_city` VALUES (1907, '中华人民共和国', '广东省', '云浮市', '云安县', '527500', '0766');
INSERT INTO `phpcms_city` VALUES (1908, '中华人民共和国', '广东省', '云浮市', '罗定市', '527200', '0766');
INSERT INTO `phpcms_city` VALUES (1909, '中华人民共和国', '广西壮族自治区', '南宁市', '兴宁区', '530000', '0771');
INSERT INTO `phpcms_city` VALUES (1910, '中华人民共和国', '广西壮族自治区', '南宁市', '青秀区', '530000', '0771');
INSERT INTO `phpcms_city` VALUES (1911, '中华人民共和国', '广西壮族自治区', '南宁市', '江南区', '530000', '0771');
INSERT INTO `phpcms_city` VALUES (1912, '中华人民共和国', '广西壮族自治区', '南宁市', '西乡塘区', '530000', '0771');
INSERT INTO `phpcms_city` VALUES (1913, '中华人民共和国', '广西壮族自治区', '南宁市', '良庆区', '530200', '0771');
INSERT INTO `phpcms_city` VALUES (1914, '中华人民共和国', '广西壮族自治区', '南宁市', '邕宁区', '530200', '0771');
INSERT INTO `phpcms_city` VALUES (1915, '中华人民共和国', '广西壮族自治区', '南宁市', '武鸣县', '530100', '0771');
INSERT INTO `phpcms_city` VALUES (1916, '中华人民共和国', '广西壮族自治区', '南宁市', '隆安县', '532700', '0771');
INSERT INTO `phpcms_city` VALUES (1917, '中华人民共和国', '广西壮族自治区', '南宁市', '马山县', '530600', '0771');
INSERT INTO `phpcms_city` VALUES (1918, '中华人民共和国', '广西壮族自治区', '南宁市', '上林县', '530500', '0771');
INSERT INTO `phpcms_city` VALUES (1919, '中华人民共和国', '广西壮族自治区', '南宁市', '宾阳县', '530400', '0771');
INSERT INTO `phpcms_city` VALUES (1920, '中华人民共和国', '广西壮族自治区', '南宁市', '横县', '530300', '0771');
INSERT INTO `phpcms_city` VALUES (1921, '中华人民共和国', '广西壮族自治区', '柳州市', '城中区', '545000', '0772');
INSERT INTO `phpcms_city` VALUES (1922, '中华人民共和国', '广西壮族自治区', '柳州市', '鱼峰区', '545000', '0772');
INSERT INTO `phpcms_city` VALUES (1923, '中华人民共和国', '广西壮族自治区', '柳州市', '柳南区', '545000', '0772');
INSERT INTO `phpcms_city` VALUES (1924, '中华人民共和国', '广西壮族自治区', '柳州市', '柳北区', '545000', '0772');
INSERT INTO `phpcms_city` VALUES (1925, '中华人民共和国', '广西壮族自治区', '柳州市', '柳江县', '545100', '0772');
INSERT INTO `phpcms_city` VALUES (1926, '中华人民共和国', '广西壮族自治区', '柳州市', '柳城县', '545200', '0772');
INSERT INTO `phpcms_city` VALUES (1927, '中华人民共和国', '广西壮族自治区', '柳州市', '鹿寨县', '545600', '0772');
INSERT INTO `phpcms_city` VALUES (1928, '中华人民共和国', '广西壮族自治区', '柳州市', '融安县', '545400', '0772');
INSERT INTO `phpcms_city` VALUES (1929, '中华人民共和国', '广西壮族自治区', '柳州市', '融水苗族自治县', '545300', '0772');
INSERT INTO `phpcms_city` VALUES (1930, '中华人民共和国', '广西壮族自治区', '柳州市', '三江侗族自治县', '545500', '0772');
INSERT INTO `phpcms_city` VALUES (1931, '中华人民共和国', '广西壮族自治区', '桂林市', '秀峰区', '541000', '0773');
INSERT INTO `phpcms_city` VALUES (1932, '中华人民共和国', '广西壮族自治区', '桂林市', '叠彩区', '541000', '0773');
INSERT INTO `phpcms_city` VALUES (1933, '中华人民共和国', '广西壮族自治区', '桂林市', '象山区', '541000', '0773');
INSERT INTO `phpcms_city` VALUES (1934, '中华人民共和国', '广西壮族自治区', '桂林市', '七星区', '541000', '0773');
INSERT INTO `phpcms_city` VALUES (1935, '中华人民共和国', '广西壮族自治区', '桂林市', '雁山区', '541000', '0773');
INSERT INTO `phpcms_city` VALUES (1936, '中华人民共和国', '广西壮族自治区', '桂林市', '阳朔县', '541900', '0773');
INSERT INTO `phpcms_city` VALUES (1937, '中华人民共和国', '广西壮族自治区', '桂林市', '临桂县', '541100', '0773');
INSERT INTO `phpcms_city` VALUES (1938, '中华人民共和国', '广西壮族自治区', '桂林市', '灵川县', '541200', '0773');
INSERT INTO `phpcms_city` VALUES (1939, '中华人民共和国', '广西壮族自治区', '桂林市', '全州县', '541500', '0773');
INSERT INTO `phpcms_city` VALUES (1940, '中华人民共和国', '广西壮族自治区', '桂林市', '兴安县', '541300', '0773');
INSERT INTO `phpcms_city` VALUES (1941, '中华人民共和国', '广西壮族自治区', '桂林市', '永福县', '541800', '0773');
INSERT INTO `phpcms_city` VALUES (1942, '中华人民共和国', '广西壮族自治区', '桂林市', '灌阳县', '541600', '0773');
INSERT INTO `phpcms_city` VALUES (1943, '中华人民共和国', '广西壮族自治区', '桂林市', '龙胜各族自治县', '541700', '0773');
INSERT INTO `phpcms_city` VALUES (1944, '中华人民共和国', '广西壮族自治区', '桂林市', '资源县', '541400', '0773');
INSERT INTO `phpcms_city` VALUES (1945, '中华人民共和国', '广西壮族自治区', '桂林市', '平乐县', '542400', '0773');
INSERT INTO `phpcms_city` VALUES (1946, '中华人民共和国', '广西壮族自治区', '桂林市', '荔蒲县', '546600', '0773');
INSERT INTO `phpcms_city` VALUES (1947, '中华人民共和国', '广西壮族自治区', '桂林市', '恭城瑶族自治县', '542500', '0773');
INSERT INTO `phpcms_city` VALUES (1948, '中华人民共和国', '广西壮族自治区', '梧州市', '万秀区', '543000', '0774');
INSERT INTO `phpcms_city` VALUES (1949, '中华人民共和国', '广西壮族自治区', '梧州市', '蝶山区', '543000', '0774');
INSERT INTO `phpcms_city` VALUES (1950, '中华人民共和国', '广西壮族自治区', '梧州市', '长洲区', '543000', '0774');
INSERT INTO `phpcms_city` VALUES (1951, '中华人民共和国', '广西壮族自治区', '梧州市', '苍梧县', '543100', '0774');
INSERT INTO `phpcms_city` VALUES (1952, '中华人民共和国', '广西壮族自治区', '梧州市', '藤县', '543300', '0774');
INSERT INTO `phpcms_city` VALUES (1953, '中华人民共和国', '广西壮族自治区', '梧州市', '蒙山县', '546700', '0774');
INSERT INTO `phpcms_city` VALUES (1954, '中华人民共和国', '广西壮族自治区', '梧州市', '岑溪市', '543200', '0774');
INSERT INTO `phpcms_city` VALUES (1955, '中华人民共和国', '广西壮族自治区', '北海市', '海城区', '536000', '0779');
INSERT INTO `phpcms_city` VALUES (1956, '中华人民共和国', '广西壮族自治区', '北海市', '银海区', '536000', '0779');
INSERT INTO `phpcms_city` VALUES (1957, '中华人民共和国', '广西壮族自治区', '北海市', '铁山港区', '536000', '0779');
INSERT INTO `phpcms_city` VALUES (1958, '中华人民共和国', '广西壮族自治区', '北海市', '合浦县', '536100', '0779');
INSERT INTO `phpcms_city` VALUES (1959, '中华人民共和国', '广西壮族自治区', '防城港市', '港口区', '538000', '0770');
INSERT INTO `phpcms_city` VALUES (1960, '中华人民共和国', '广西壮族自治区', '防城港市', '防城区', '538000', '0770');
INSERT INTO `phpcms_city` VALUES (1961, '中华人民共和国', '广西壮族自治区', '防城港市', '上思县', '535500', '0770');
INSERT INTO `phpcms_city` VALUES (1962, '中华人民共和国', '广西壮族自治区', '防城港市', '东兴市', '538100', '0770');
INSERT INTO `phpcms_city` VALUES (1963, '中华人民共和国', '广西壮族自治区', '钦州市', '钦南区', '535000', '0777');
INSERT INTO `phpcms_city` VALUES (1964, '中华人民共和国', '广西壮族自治区', '钦州市', '钦北区', '535000', '0777');
INSERT INTO `phpcms_city` VALUES (1965, '中华人民共和国', '广西壮族自治区', '钦州市', '灵山县', '535400', '0777');
INSERT INTO `phpcms_city` VALUES (1966, '中华人民共和国', '广西壮族自治区', '钦州市', '浦北县', '535300', '0777');
INSERT INTO `phpcms_city` VALUES (1967, '中华人民共和国', '广西壮族自治区', '贵港市', '港北区', '537100', '0775');
INSERT INTO `phpcms_city` VALUES (1968, '中华人民共和国', '广西壮族自治区', '贵港市', '港南区', '537100', '0775');
INSERT INTO `phpcms_city` VALUES (1969, '中华人民共和国', '广西壮族自治区', '贵港市', '覃塘区', '537100', '0775');
INSERT INTO `phpcms_city` VALUES (1970, '中华人民共和国', '广西壮族自治区', '贵港市', '平南县', '537300', '0775');
INSERT INTO `phpcms_city` VALUES (1971, '中华人民共和国', '广西壮族自治区', '贵港市', '桂平市', '537200', '0775');
INSERT INTO `phpcms_city` VALUES (1972, '中华人民共和国', '广西壮族自治区', '玉林市', '玉州区', '537000', '0775');
INSERT INTO `phpcms_city` VALUES (1973, '中华人民共和国', '广西壮族自治区', '玉林市', '容县', '537500', '0775');
INSERT INTO `phpcms_city` VALUES (1974, '中华人民共和国', '广西壮族自治区', '玉林市', '陆川县', '537700', '0775');
INSERT INTO `phpcms_city` VALUES (1975, '中华人民共和国', '广西壮族自治区', '玉林市', '博白县', '537600', '0775');
INSERT INTO `phpcms_city` VALUES (1976, '中华人民共和国', '广西壮族自治区', '玉林市', '兴业县', '537800', '0775');
INSERT INTO `phpcms_city` VALUES (1977, '中华人民共和国', '广西壮族自治区', '玉林市', '北流市', '537400', '0775');
INSERT INTO `phpcms_city` VALUES (1978, '中华人民共和国', '广西壮族自治区', '百色市', '右江区', '533000', '0776');
INSERT INTO `phpcms_city` VALUES (1979, '中华人民共和国', '广西壮族自治区', '百色市', '田阳县', '533600', '0776');
INSERT INTO `phpcms_city` VALUES (1980, '中华人民共和国', '广西壮族自治区', '百色市', '田东县', '531500', '0776');
INSERT INTO `phpcms_city` VALUES (1981, '中华人民共和国', '广西壮族自治区', '百色市', '平果县', '531400', '0776');
INSERT INTO `phpcms_city` VALUES (1982, '中华人民共和国', '广西壮族自治区', '百色市', '德保县', '533700', '0776');
INSERT INTO `phpcms_city` VALUES (1983, '中华人民共和国', '广西壮族自治区', '百色市', '靖西县', '533800', '0776');
INSERT INTO `phpcms_city` VALUES (1984, '中华人民共和国', '广西壮族自治区', '百色市', '那坡县', '533900', '0776');
INSERT INTO `phpcms_city` VALUES (1985, '中华人民共和国', '广西壮族自治区', '百色市', '凌云县', '533100', '0776');
INSERT INTO `phpcms_city` VALUES (1986, '中华人民共和国', '广西壮族自治区', '百色市', '乐业县', '533200', '0776');
INSERT INTO `phpcms_city` VALUES (1987, '中华人民共和国', '广西壮族自治区', '百色市', '田林县', '533300', '0776');
INSERT INTO `phpcms_city` VALUES (1988, '中华人民共和国', '广西壮族自治区', '百色市', '西林县', '533500', '0776');
INSERT INTO `phpcms_city` VALUES (1989, '中华人民共和国', '广西壮族自治区', '百色市', '隆林各族自治县', '533500', '0776');
INSERT INTO `phpcms_city` VALUES (1990, '中华人民共和国', '广西壮族自治区', '贺州市', '八步区', '542800', '0774');
INSERT INTO `phpcms_city` VALUES (1991, '中华人民共和国', '广西壮族自治区', '贺州市', '昭平县', '546800', '0774');
INSERT INTO `phpcms_city` VALUES (1992, '中华人民共和国', '广西壮族自治区', '贺州市', '钟山县', '542600', '0774');
INSERT INTO `phpcms_city` VALUES (1993, '中华人民共和国', '广西壮族自治区', '贺州市', '富川瑶族自治县', '542700', '0774');
INSERT INTO `phpcms_city` VALUES (1994, '中华人民共和国', '广西壮族自治区', '河池市', '金城江区', '547000', '0778');
INSERT INTO `phpcms_city` VALUES (1995, '中华人民共和国', '广西壮族自治区', '河池市', '南丹县', '547200', '0778');
INSERT INTO `phpcms_city` VALUES (1996, '中华人民共和国', '广西壮族自治区', '河池市', '天峨县', '547300', '0778');
INSERT INTO `phpcms_city` VALUES (1997, '中华人民共和国', '广西壮族自治区', '河池市', '凤山县', '547600', '0778');
INSERT INTO `phpcms_city` VALUES (1998, '中华人民共和国', '广西壮族自治区', '河池市', '东兰县', '547400', '0778');
INSERT INTO `phpcms_city` VALUES (1999, '中华人民共和国', '广西壮族自治区', '河池市', '罗城仫佬族自治县', '546400', '0778');
INSERT INTO `phpcms_city` VALUES (2000, '中华人民共和国', '广西壮族自治区', '河池市', '环江毛南族自治县', '547100', '0778');
INSERT INTO `phpcms_city` VALUES (2001, '中华人民共和国', '广西壮族自治区', '河池市', '巴马瑶族自治县', '547500', '0778');
INSERT INTO `phpcms_city` VALUES (2002, '中华人民共和国', '广西壮族自治区', '河池市', '都安瑶族自治县', '530700', '0778');
INSERT INTO `phpcms_city` VALUES (2003, '中华人民共和国', '广西壮族自治区', '河池市', '大化瑶族自治县', '530800', '0778');
INSERT INTO `phpcms_city` VALUES (2004, '中华人民共和国', '广西壮族自治区', '河池市', '宜州市', '546300', '0778');
INSERT INTO `phpcms_city` VALUES (2005, '中华人民共和国', '广西壮族自治区', '来宾市', '兴宾区', '546100', '0772');
INSERT INTO `phpcms_city` VALUES (2006, '中华人民共和国', '广西壮族自治区', '来宾市', '忻城县', '546200', '0772');
INSERT INTO `phpcms_city` VALUES (2007, '中华人民共和国', '广西壮族自治区', '来宾市', '象州县', '545800', '0772');
INSERT INTO `phpcms_city` VALUES (2008, '中华人民共和国', '广西壮族自治区', '来宾市', '武宣县', '545900', '0772');
INSERT INTO `phpcms_city` VALUES (2009, '中华人民共和国', '广西壮族自治区', '来宾市', '金秀瑶族自治县', '545700', '0772');
INSERT INTO `phpcms_city` VALUES (2010, '中华人民共和国', '广西壮族自治区', '来宾市', '合山市', '546500', '0772');
INSERT INTO `phpcms_city` VALUES (2011, '中华人民共和国', '广西壮族自治区', '崇左市', '江洲区', '532200', '0771');
INSERT INTO `phpcms_city` VALUES (2012, '中华人民共和国', '广西壮族自治区', '崇左市', '扶绥县', '532100', '0771');
INSERT INTO `phpcms_city` VALUES (2013, '中华人民共和国', '广西壮族自治区', '崇左市', '宁明县', '532500', '0771');
INSERT INTO `phpcms_city` VALUES (2014, '中华人民共和国', '广西壮族自治区', '崇左市', '龙州县', '532400', '0771');
INSERT INTO `phpcms_city` VALUES (2015, '中华人民共和国', '广西壮族自治区', '崇左市', '大新县', '532300', '0771');
INSERT INTO `phpcms_city` VALUES (2016, '中华人民共和国', '广西壮族自治区', '崇左市', '天等县', '532800', '0771');
INSERT INTO `phpcms_city` VALUES (2017, '中华人民共和国', '广西壮族自治区', '崇左市', '凭祥市', '532600', '0771');
INSERT INTO `phpcms_city` VALUES (2018, '中华人民共和国', '海南省', '海口市', '秀英区', '570100', '0898');
INSERT INTO `phpcms_city` VALUES (2019, '中华人民共和国', '海南省', '海口市', '龙华区', '570100', '0898');
INSERT INTO `phpcms_city` VALUES (2020, '中华人民共和国', '海南省', '海口市', '琼山区', '571100', '0898');
INSERT INTO `phpcms_city` VALUES (2021, '中华人民共和国', '海南省', '海口市', '美兰区', '570100', '0898');
INSERT INTO `phpcms_city` VALUES (2022, '中华人民共和国', '海南省', '三亚市', '', '572000', '0898');
INSERT INTO `phpcms_city` VALUES (2023, '中华人民共和国', '海南省', '五指山市', '', '572200', '0898');
INSERT INTO `phpcms_city` VALUES (2024, '中华人民共和国', '海南省', '琼海市', '', '571400', '0898');
INSERT INTO `phpcms_city` VALUES (2025, '中华人民共和国', '海南省', '儋州市', '', '571700', '0898');
INSERT INTO `phpcms_city` VALUES (2026, '中华人民共和国', '海南省', '文昌市', '', '571300', '0898');
INSERT INTO `phpcms_city` VALUES (2027, '中华人民共和国', '海南省', '万宁市', '', '571500', '0898');
INSERT INTO `phpcms_city` VALUES (2028, '中华人民共和国', '海南省', '东方市', '', '572600', '0898');
INSERT INTO `phpcms_city` VALUES (2029, '中华人民共和国', '海南省', '定安县', '', '571200', '0898');
INSERT INTO `phpcms_city` VALUES (2030, '中华人民共和国', '海南省', '屯昌县', '', '571600', '0898');
INSERT INTO `phpcms_city` VALUES (2031, '中华人民共和国', '海南省', '澄迈县', '', '571900', '0898');
INSERT INTO `phpcms_city` VALUES (2032, '中华人民共和国', '海南省', '临高县', '', '571800', '0898');
INSERT INTO `phpcms_city` VALUES (2033, '中华人民共和国', '海南省', '白沙黎族自治县', '', '572800', '0898');
INSERT INTO `phpcms_city` VALUES (2034, '中华人民共和国', '海南省', '昌江黎族自治县', '', '572700', '0898');
INSERT INTO `phpcms_city` VALUES (2035, '中华人民共和国', '海南省', '乐东黎族自治县', '', '572500', '0898');
INSERT INTO `phpcms_city` VALUES (2036, '中华人民共和国', '海南省', '陵水黎族自治县', '', '572400', '0898');
INSERT INTO `phpcms_city` VALUES (2037, '中华人民共和国', '海南省', '保亭黎族苗族自治县', '', '572300', '0898');
INSERT INTO `phpcms_city` VALUES (2038, '中华人民共和国', '海南省', '琼中黎族苗族自治县', '', '572900', '0898');
INSERT INTO `phpcms_city` VALUES (2039, '中华人民共和国', '海南省', '西沙群岛', '', '572000', '0898');
INSERT INTO `phpcms_city` VALUES (2040, '中华人民共和国', '海南省', '南沙群岛', '', '572000', '0898');
INSERT INTO `phpcms_city` VALUES (2041, '中华人民共和国', '海南省', '中沙群岛的岛礁及其海域', '', '572000', '0898');
INSERT INTO `phpcms_city` VALUES (2042, '中华人民共和国', '四川省', '成都市', '锦江区', '610000', '028');
INSERT INTO `phpcms_city` VALUES (2043, '中华人民共和国', '四川省', '成都市', '青羊区', '610000', '028');
INSERT INTO `phpcms_city` VALUES (2044, '中华人民共和国', '四川省', '成都市', '金牛区', '610000', '028');
INSERT INTO `phpcms_city` VALUES (2045, '中华人民共和国', '四川省', '成都市', '武侯区', '610000', '028');
INSERT INTO `phpcms_city` VALUES (2046, '中华人民共和国', '四川省', '成都市', '成华区', '610000', '028');
INSERT INTO `phpcms_city` VALUES (2047, '中华人民共和国', '四川省', '成都市', '龙泉驿区', '610100', '028');
INSERT INTO `phpcms_city` VALUES (2048, '中华人民共和国', '四川省', '成都市', '青白江区', '610300', '028');
INSERT INTO `phpcms_city` VALUES (2049, '中华人民共和国', '四川省', '成都市', '新都区', '610500', '028');
INSERT INTO `phpcms_city` VALUES (2050, '中华人民共和国', '四川省', '成都市', '温江区', '611100', '028');
INSERT INTO `phpcms_city` VALUES (2051, '中华人民共和国', '四川省', '成都市', '金堂县', '610400', '028');
INSERT INTO `phpcms_city` VALUES (2052, '中华人民共和国', '四川省', '成都市', '双流县', '610200', '028');
INSERT INTO `phpcms_city` VALUES (2053, '中华人民共和国', '四川省', '成都市', '郫县', '611700', '028');
INSERT INTO `phpcms_city` VALUES (2054, '中华人民共和国', '四川省', '成都市', '大邑县', '611300', '028');
INSERT INTO `phpcms_city` VALUES (2055, '中华人民共和国', '四川省', '成都市', '蒲江县', '611600', '028');
INSERT INTO `phpcms_city` VALUES (2056, '中华人民共和国', '四川省', '成都市', '新津县', '611400', '028');
INSERT INTO `phpcms_city` VALUES (2057, '中华人民共和国', '四川省', '成都市', '都江堰市', '611800', '028');
INSERT INTO `phpcms_city` VALUES (2058, '中华人民共和国', '四川省', '成都市', '彭州市', '610000', '028');
INSERT INTO `phpcms_city` VALUES (2059, '中华人民共和国', '四川省', '成都市', '邛崃市', '611500', '028');
INSERT INTO `phpcms_city` VALUES (2060, '中华人民共和国', '四川省', '成都市', '崇州市', '611200', '028');
INSERT INTO `phpcms_city` VALUES (2061, '中华人民共和国', '四川省', '自贡市', '自流井区', '643000', '0813');
INSERT INTO `phpcms_city` VALUES (2062, '中华人民共和国', '四川省', '自贡市', '贡井区', '643020', '0813');
INSERT INTO `phpcms_city` VALUES (2063, '中华人民共和国', '四川省', '自贡市', '大安区', '643010', '0813');
INSERT INTO `phpcms_city` VALUES (2064, '中华人民共和国', '四川省', '自贡市', '沿滩区', '643030', '0813');
INSERT INTO `phpcms_city` VALUES (2065, '中华人民共和国', '四川省', '自贡市', '荣县', '643100', '0813');
INSERT INTO `phpcms_city` VALUES (2066, '中华人民共和国', '四川省', '自贡市', '富顺县', '643200', '0813');
INSERT INTO `phpcms_city` VALUES (2067, '中华人民共和国', '四川省', '攀枝花市', '东区', '617000', '0812');
INSERT INTO `phpcms_city` VALUES (2068, '中华人民共和国', '四川省', '攀枝花市', '西区', '617000', '0812');
INSERT INTO `phpcms_city` VALUES (2069, '中华人民共和国', '四川省', '攀枝花市', '仁和区', '617000', '0812');
INSERT INTO `phpcms_city` VALUES (2070, '中华人民共和国', '四川省', '攀枝花市', '米易县', '617200', '0812');
INSERT INTO `phpcms_city` VALUES (2071, '中华人民共和国', '四川省', '攀枝花市', '盐边县', '617100', '0812');
INSERT INTO `phpcms_city` VALUES (2072, '中华人民共和国', '四川省', '泸州市', '江阳区', '646000', '0830');
INSERT INTO `phpcms_city` VALUES (2073, '中华人民共和国', '四川省', '泸州市', '纳溪区', '646000', '0830');
INSERT INTO `phpcms_city` VALUES (2074, '中华人民共和国', '四川省', '泸州市', '龙马潭区', '646000', '0830');
INSERT INTO `phpcms_city` VALUES (2075, '中华人民共和国', '四川省', '泸州市', '泸县', '646100', '0830');
INSERT INTO `phpcms_city` VALUES (2076, '中华人民共和国', '四川省', '泸州市', '合江县', '646200', '0830');
INSERT INTO `phpcms_city` VALUES (2077, '中华人民共和国', '四川省', '泸州市', '叙永县', '646400', '0830');
INSERT INTO `phpcms_city` VALUES (2078, '中华人民共和国', '四川省', '泸州市', '古蔺县', '646500', '0830');
INSERT INTO `phpcms_city` VALUES (2079, '中华人民共和国', '四川省', '德阳市', '旌阳区', '618000', '0838');
INSERT INTO `phpcms_city` VALUES (2080, '中华人民共和国', '四川省', '德阳市', '中江县', '618300', '0838');
INSERT INTO `phpcms_city` VALUES (2081, '中华人民共和国', '四川省', '德阳市', '罗江县', '618500', '0838');
INSERT INTO `phpcms_city` VALUES (2082, '中华人民共和国', '四川省', '德阳市', '广汉市', '618300', '0838');
INSERT INTO `phpcms_city` VALUES (2083, '中华人民共和国', '四川省', '德阳市', '什邡市', '618400', '0838');
INSERT INTO `phpcms_city` VALUES (2084, '中华人民共和国', '四川省', '德阳市', '绵竹市', '618200', '0838');
INSERT INTO `phpcms_city` VALUES (2085, '中华人民共和国', '四川省', '绵阳市', '涪城区', '621000', '0816');
INSERT INTO `phpcms_city` VALUES (2086, '中华人民共和国', '四川省', '绵阳市', '游仙区', '621000', '0816');
INSERT INTO `phpcms_city` VALUES (2087, '中华人民共和国', '四川省', '绵阳市', '三台县', '621100', '0816');
INSERT INTO `phpcms_city` VALUES (2088, '中华人民共和国', '四川省', '绵阳市', '盐亭县', '621600', '0816');
INSERT INTO `phpcms_city` VALUES (2089, '中华人民共和国', '四川省', '绵阳市', '安县', '622650', '0816');
INSERT INTO `phpcms_city` VALUES (2090, '中华人民共和国', '四川省', '绵阳市', '梓潼县', '622150', '0816');
INSERT INTO `phpcms_city` VALUES (2091, '中华人民共和国', '四川省', '绵阳市', '北川羌族自治县', '622700', '0816');
INSERT INTO `phpcms_city` VALUES (2092, '中华人民共和国', '四川省', '绵阳市', '平武县', '622550', '0816');
INSERT INTO `phpcms_city` VALUES (2093, '中华人民共和国', '四川省', '绵阳市', '江油市', '621700', '0816');
INSERT INTO `phpcms_city` VALUES (2094, '中华人民共和国', '四川省', '广元市', '市中区', '628000', '0839');
INSERT INTO `phpcms_city` VALUES (2095, '中华人民共和国', '四川省', '广元市', '元坝区', '628000', '0839');
INSERT INTO `phpcms_city` VALUES (2096, '中华人民共和国', '四川省', '广元市', '朝天区', '628000', '0839');
INSERT INTO `phpcms_city` VALUES (2097, '中华人民共和国', '四川省', '广元市', '旺苍县', '628200', '0839');
INSERT INTO `phpcms_city` VALUES (2098, '中华人民共和国', '四川省', '广元市', '青川县', '628100', '0839');
INSERT INTO `phpcms_city` VALUES (2099, '中华人民共和国', '四川省', '广元市', '剑阁县', '628300', '0839');
INSERT INTO `phpcms_city` VALUES (2100, '中华人民共和国', '四川省', '广元市', '苍溪县', '628400', '0839');
INSERT INTO `phpcms_city` VALUES (2101, '中华人民共和国', '四川省', '遂宁市', '船山区', '629000', '0825');
INSERT INTO `phpcms_city` VALUES (2102, '中华人民共和国', '四川省', '遂宁市', '安居区', '629000', '0825');
INSERT INTO `phpcms_city` VALUES (2103, '中华人民共和国', '四川省', '遂宁市', '蓬溪县', '629100', '0825');
INSERT INTO `phpcms_city` VALUES (2104, '中华人民共和国', '四川省', '遂宁市', '射洪县', '629200', '0825');
INSERT INTO `phpcms_city` VALUES (2105, '中华人民共和国', '四川省', '遂宁市', '大英县', '629300', '0825');
INSERT INTO `phpcms_city` VALUES (2106, '中华人民共和国', '四川省', '内江市', '市中区', '641000', '0832');
INSERT INTO `phpcms_city` VALUES (2107, '中华人民共和国', '四川省', '内江市', '东兴区', '641100', '0832');
INSERT INTO `phpcms_city` VALUES (2108, '中华人民共和国', '四川省', '内江市', '威远县', '642450', '0832');
INSERT INTO `phpcms_city` VALUES (2109, '中华人民共和国', '四川省', '内江市', '资中县', '641200', '0832');
INSERT INTO `phpcms_city` VALUES (2110, '中华人民共和国', '四川省', '内江市', '隆昌县', '642150', '0832');
INSERT INTO `phpcms_city` VALUES (2111, '中华人民共和国', '四川省', '乐山市', '市中区', '614000', '0833');
INSERT INTO `phpcms_city` VALUES (2112, '中华人民共和国', '四川省', '乐山市', '沙湾区', '614900', '0833');
INSERT INTO `phpcms_city` VALUES (2113, '中华人民共和国', '四川省', '乐山市', '五通桥区', '614800', '0833');
INSERT INTO `phpcms_city` VALUES (2114, '中华人民共和国', '四川省', '乐山市', '金口河区', '614700', '0833');
INSERT INTO `phpcms_city` VALUES (2115, '中华人民共和国', '四川省', '乐山市', '犍为县', '614400', '0833');
INSERT INTO `phpcms_city` VALUES (2116, '中华人民共和国', '四川省', '乐山市', '井研县', '613100', '0833');
INSERT INTO `phpcms_city` VALUES (2117, '中华人民共和国', '四川省', '乐山市', '夹江县', '614100', '0833');
INSERT INTO `phpcms_city` VALUES (2118, '中华人民共和国', '四川省', '乐山市', '沐川县', '614500', '0833');
INSERT INTO `phpcms_city` VALUES (2119, '中华人民共和国', '四川省', '乐山市', '峨边彝族自治县', '614300', '0833');
INSERT INTO `phpcms_city` VALUES (2120, '中华人民共和国', '四川省', '乐山市', '马边彝族自治县', '614600', '0833');
INSERT INTO `phpcms_city` VALUES (2121, '中华人民共和国', '四川省', '乐山市', '峨眉山市', '614200', '0833');
INSERT INTO `phpcms_city` VALUES (2122, '中华人民共和国', '四川省', '南充市', '顺庆区', '637000', '0817');
INSERT INTO `phpcms_city` VALUES (2123, '中华人民共和国', '四川省', '南充市', '高坪区', '637100', '0817');
INSERT INTO `phpcms_city` VALUES (2124, '中华人民共和国', '四川省', '南充市', '嘉陵区', '637500', '0817');
INSERT INTO `phpcms_city` VALUES (2125, '中华人民共和国', '四川省', '南充市', '南部县', '637300', '0817');
INSERT INTO `phpcms_city` VALUES (2126, '中华人民共和国', '四川省', '南充市', '营山县', '637700', '0817');
INSERT INTO `phpcms_city` VALUES (2127, '中华人民共和国', '四川省', '南充市', '蓬安县', '637800', '0817');
INSERT INTO `phpcms_city` VALUES (2128, '中华人民共和国', '四川省', '南充市', '仪陇县', '637600', '0817');
INSERT INTO `phpcms_city` VALUES (2129, '中华人民共和国', '四川省', '南充市', '西充县', '637200', '0817');
INSERT INTO `phpcms_city` VALUES (2130, '中华人民共和国', '四川省', '南充市', '阆中市', '637400', '0817');
INSERT INTO `phpcms_city` VALUES (2131, '中华人民共和国', '四川省', '眉山市', '东坡区', '620000', '0833');
INSERT INTO `phpcms_city` VALUES (2132, '中华人民共和国', '四川省', '眉山市', '仁寿县', '620500', '0833');
INSERT INTO `phpcms_city` VALUES (2133, '中华人民共和国', '四川省', '眉山市', '彭山县', '620800', '0833');
INSERT INTO `phpcms_city` VALUES (2134, '中华人民共和国', '四川省', '眉山市', '洪雅县', '620300', '0833');
INSERT INTO `phpcms_city` VALUES (2135, '中华人民共和国', '四川省', '眉山市', '丹棱县', '620200', '0833');
INSERT INTO `phpcms_city` VALUES (2136, '中华人民共和国', '四川省', '眉山市', '青神县', '620400', '0833');
INSERT INTO `phpcms_city` VALUES (2137, '中华人民共和国', '四川省', '宜宾市', '翠屏区', '644000', '0831');
INSERT INTO `phpcms_city` VALUES (2138, '中华人民共和国', '四川省', '宜宾市', '宜宾县', '644600', '0831');
INSERT INTO `phpcms_city` VALUES (2139, '中华人民共和国', '四川省', '宜宾市', '南溪县', '644100', '0831');
INSERT INTO `phpcms_city` VALUES (2140, '中华人民共和国', '四川省', '宜宾市', '江安县', '644200', '0831');
INSERT INTO `phpcms_city` VALUES (2141, '中华人民共和国', '四川省', '宜宾市', '长宁县', '644300', '0831');
INSERT INTO `phpcms_city` VALUES (2142, '中华人民共和国', '四川省', '宜宾市', '高县', '645150', '0831');
INSERT INTO `phpcms_city` VALUES (2143, '中华人民共和国', '四川省', '宜宾市', '珙县', '644500', '0831');
INSERT INTO `phpcms_city` VALUES (2144, '中华人民共和国', '四川省', '宜宾市', '筠连县', '645250', '0831');
INSERT INTO `phpcms_city` VALUES (2145, '中华人民共和国', '四川省', '宜宾市', '兴文县', '644400', '0831');
INSERT INTO `phpcms_city` VALUES (2146, '中华人民共和国', '四川省', '宜宾市', '屏山县', '645350', '0831');
INSERT INTO `phpcms_city` VALUES (2147, '中华人民共和国', '四川省', '广安市', '广安区', '638500', '0826');
INSERT INTO `phpcms_city` VALUES (2148, '中华人民共和国', '四川省', '广安市', '岳池县', '638300', '0826');
INSERT INTO `phpcms_city` VALUES (2149, '中华人民共和国', '四川省', '广安市', '武胜县', '638400', '0826');
INSERT INTO `phpcms_city` VALUES (2150, '中华人民共和国', '四川省', '广安市', '邻水县', '638500', '0826');
INSERT INTO `phpcms_city` VALUES (2151, '中华人民共和国', '四川省', '广安市', '华蓥市', '638600', '0826');
INSERT INTO `phpcms_city` VALUES (2152, '中华人民共和国', '四川省', '达州市', '通川区', '635000', '0818');
INSERT INTO `phpcms_city` VALUES (2153, '中华人民共和国', '四川省', '达州市', '达县', '635000', '0818');
INSERT INTO `phpcms_city` VALUES (2154, '中华人民共和国', '四川省', '达州市', '宣汉县', '636150', '0818');
INSERT INTO `phpcms_city` VALUES (2155, '中华人民共和国', '四川省', '达州市', '开江县', '636250', '0818');
INSERT INTO `phpcms_city` VALUES (2156, '中华人民共和国', '四川省', '达州市', '大竹县', '635100', '0818');
INSERT INTO `phpcms_city` VALUES (2157, '中华人民共和国', '四川省', '达州市', '渠县', '635200', '0818');
INSERT INTO `phpcms_city` VALUES (2158, '中华人民共和国', '四川省', '达州市', '万源市', '636350', '0818');
INSERT INTO `phpcms_city` VALUES (2159, '中华人民共和国', '四川省', '雅安市', '雨城区', '625000', '0835');
INSERT INTO `phpcms_city` VALUES (2160, '中华人民共和国', '四川省', '雅安市', '名山县', '625100', '0835');
INSERT INTO `phpcms_city` VALUES (2161, '中华人民共和国', '四川省', '雅安市', '荥经县', '625200', '0835');
INSERT INTO `phpcms_city` VALUES (2162, '中华人民共和国', '四川省', '雅安市', '汉源县', '625300', '0835');
INSERT INTO `phpcms_city` VALUES (2163, '中华人民共和国', '四川省', '雅安市', '石棉县', '625400', '0835');
INSERT INTO `phpcms_city` VALUES (2164, '中华人民共和国', '四川省', '雅安市', '天全县', '625500', '0835');
INSERT INTO `phpcms_city` VALUES (2165, '中华人民共和国', '四川省', '雅安市', '芦山县', '625600', '0835');
INSERT INTO `phpcms_city` VALUES (2166, '中华人民共和国', '四川省', '雅安市', '宝兴县', '625700', '0835');
INSERT INTO `phpcms_city` VALUES (2167, '中华人民共和国', '四川省', '巴中市', '巴州区', '636600', '0827');
INSERT INTO `phpcms_city` VALUES (2168, '中华人民共和国', '四川省', '巴中市', '通江县', '636700', '0827');
INSERT INTO `phpcms_city` VALUES (2169, '中华人民共和国', '四川省', '巴中市', '南江县', '635600', '0827');
INSERT INTO `phpcms_city` VALUES (2170, '中华人民共和国', '四川省', '巴中市', '平昌县', '636400', '0827');
INSERT INTO `phpcms_city` VALUES (2171, '中华人民共和国', '四川省', '资阳市', '雁江区', '641300', '0832');
INSERT INTO `phpcms_city` VALUES (2172, '中华人民共和国', '四川省', '资阳市', '安岳县', '642350', '0832');
INSERT INTO `phpcms_city` VALUES (2173, '中华人民共和国', '四川省', '资阳市', '乐至县', '641500', '0832');
INSERT INTO `phpcms_city` VALUES (2174, '中华人民共和国', '四川省', '资阳市', '简阳市', '641400', '0832');
INSERT INTO `phpcms_city` VALUES (2175, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '汶川县', '623000', '0837');
INSERT INTO `phpcms_city` VALUES (2176, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '理县', '623100', '0837');
INSERT INTO `phpcms_city` VALUES (2177, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '茂县', '623200', '0837');
INSERT INTO `phpcms_city` VALUES (2178, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '松潘县', '623300', '0837');
INSERT INTO `phpcms_city` VALUES (2179, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '九寨沟县', '623400', '0837');
INSERT INTO `phpcms_city` VALUES (2180, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '金川县', '624100', '0837');
INSERT INTO `phpcms_city` VALUES (2181, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '小金县', '624200', '0837');
INSERT INTO `phpcms_city` VALUES (2182, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '黑水县', '623500', '0837');
INSERT INTO `phpcms_city` VALUES (2183, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '马尔康县', '624000', '0837');
INSERT INTO `phpcms_city` VALUES (2184, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '壤塘县', '624300', '0837');
INSERT INTO `phpcms_city` VALUES (2185, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '阿坝县', '624600', '0837');
INSERT INTO `phpcms_city` VALUES (2186, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '若尔盖县', '624500', '0837');
INSERT INTO `phpcms_city` VALUES (2187, '中华人民共和国', '四川省', '阿坝藏族羌族自治州', '红原县', '624400', '0837');
INSERT INTO `phpcms_city` VALUES (2188, '中华人民共和国', '四川省', '甘孜藏族自治州', '康定县', '626000', '0836');
INSERT INTO `phpcms_city` VALUES (2189, '中华人民共和国', '四川省', '甘孜藏族自治州', '泸定县', '626100', '0836');
INSERT INTO `phpcms_city` VALUES (2190, '中华人民共和国', '四川省', '甘孜藏族自治州', '丹巴县', '626300', '0836');
INSERT INTO `phpcms_city` VALUES (2191, '中华人民共和国', '四川省', '甘孜藏族自治州', '九龙县', '616200', '0836');
INSERT INTO `phpcms_city` VALUES (2192, '中华人民共和国', '四川省', '甘孜藏族自治州', '雅江县', '627450', '0836');
INSERT INTO `phpcms_city` VALUES (2193, '中华人民共和国', '四川省', '甘孜藏族自治州', '道孚县', '626400', '0836');
INSERT INTO `phpcms_city` VALUES (2194, '中华人民共和国', '四川省', '甘孜藏族自治州', '炉霍县', '626500', '0836');
INSERT INTO `phpcms_city` VALUES (2195, '中华人民共和国', '四川省', '甘孜藏族自治州', '甘孜县', '626700', '0836');
INSERT INTO `phpcms_city` VALUES (2196, '中华人民共和国', '四川省', '甘孜藏族自治州', '新龙县', '626800', '0836');
INSERT INTO `phpcms_city` VALUES (2197, '中华人民共和国', '四川省', '甘孜藏族自治州', '德格县', '627250', '0836');
INSERT INTO `phpcms_city` VALUES (2198, '中华人民共和国', '四川省', '甘孜藏族自治州', '白玉县', '627150', '0836');
INSERT INTO `phpcms_city` VALUES (2199, '中华人民共和国', '四川省', '甘孜藏族自治州', '石渠县', '627350', '0836');
INSERT INTO `phpcms_city` VALUES (2200, '中华人民共和国', '四川省', '甘孜藏族自治州', '色达县', '626600', '0836');
INSERT INTO `phpcms_city` VALUES (2201, '中华人民共和国', '四川省', '甘孜藏族自治州', '理塘县', '624300', '0836');
INSERT INTO `phpcms_city` VALUES (2202, '中华人民共和国', '四川省', '甘孜藏族自治州', '巴塘县', '627650', '0836');
INSERT INTO `phpcms_city` VALUES (2203, '中华人民共和国', '四川省', '甘孜藏族自治州', '乡城县', '627850', '0836');
INSERT INTO `phpcms_city` VALUES (2204, '中华人民共和国', '四川省', '甘孜藏族自治州', '稻城县', '627750', '0836');
INSERT INTO `phpcms_city` VALUES (2205, '中华人民共和国', '四川省', '甘孜藏族自治州', '得荣县', '627950', '0836');
INSERT INTO `phpcms_city` VALUES (2206, '中华人民共和国', '四川省', '凉山彝族自治州', '西昌市', '615000', '0834');
INSERT INTO `phpcms_city` VALUES (2207, '中华人民共和国', '四川省', '凉山彝族自治州', '木里藏族自治县', '615800', '0834');
INSERT INTO `phpcms_city` VALUES (2208, '中华人民共和国', '四川省', '凉山彝族自治州', '盐源县', '615700', '0834');
INSERT INTO `phpcms_city` VALUES (2209, '中华人民共和国', '四川省', '凉山彝族自治州', '德昌县', '615500', '0834');
INSERT INTO `phpcms_city` VALUES (2210, '中华人民共和国', '四川省', '凉山彝族自治州', '会理县', '615100', '0834');
INSERT INTO `phpcms_city` VALUES (2211, '中华人民共和国', '四川省', '凉山彝族自治州', '会东县', '615200', '0834');
INSERT INTO `phpcms_city` VALUES (2212, '中华人民共和国', '四川省', '凉山彝族自治州', '宁南县', '615400', '0834');
INSERT INTO `phpcms_city` VALUES (2213, '中华人民共和国', '四川省', '凉山彝族自治州', '普格县', '615300', '0834');
INSERT INTO `phpcms_city` VALUES (2214, '中华人民共和国', '四川省', '凉山彝族自治州', '布拖县', '615350', '0834');
INSERT INTO `phpcms_city` VALUES (2215, '中华人民共和国', '四川省', '凉山彝族自治州', '金阳县', '616250', '0834');
INSERT INTO `phpcms_city` VALUES (2216, '中华人民共和国', '四川省', '凉山彝族自治州', '昭觉县', '616150', '0834');
INSERT INTO `phpcms_city` VALUES (2217, '中华人民共和国', '四川省', '凉山彝族自治州', '喜德县', '616750', '0834');
INSERT INTO `phpcms_city` VALUES (2218, '中华人民共和国', '四川省', '凉山彝族自治州', '冕宁县', '615600', '0834');
INSERT INTO `phpcms_city` VALUES (2219, '中华人民共和国', '四川省', '凉山彝族自治州', '越西县', '616650', '0834');
INSERT INTO `phpcms_city` VALUES (2220, '中华人民共和国', '四川省', '凉山彝族自治州', '甘洛县', '616850', '0834');
INSERT INTO `phpcms_city` VALUES (2221, '中华人民共和国', '四川省', '凉山彝族自治州', '美姑县', '616450', '0834');
INSERT INTO `phpcms_city` VALUES (2222, '中华人民共和国', '四川省', '凉山彝族自治州', '雷波县', '616550', '0834');
INSERT INTO `phpcms_city` VALUES (2223, '中华人民共和国', '贵州省', '贵阳市', '南明区', '550000', '0851');
INSERT INTO `phpcms_city` VALUES (2224, '中华人民共和国', '贵州省', '贵阳市', '云岩区', '550000', '0851');
INSERT INTO `phpcms_city` VALUES (2225, '中华人民共和国', '贵州省', '贵阳市', '花溪区', '550000', '0851');
INSERT INTO `phpcms_city` VALUES (2226, '中华人民共和国', '贵州省', '贵阳市', '乌当区', '550000', '0851');
INSERT INTO `phpcms_city` VALUES (2227, '中华人民共和国', '贵州省', '贵阳市', '白云区', '550000', '0851');
INSERT INTO `phpcms_city` VALUES (2228, '中华人民共和国', '贵州省', '贵阳市', '小河区', '550000', '0851');
INSERT INTO `phpcms_city` VALUES (2229, '中华人民共和国', '贵州省', '贵阳市', '开阳县', '550300', '0851');
INSERT INTO `phpcms_city` VALUES (2230, '中华人民共和国', '贵州省', '贵阳市', '息烽县', '551100', '0851');
INSERT INTO `phpcms_city` VALUES (2231, '中华人民共和国', '贵州省', '贵阳市', '修文县', '550200', '0851');
INSERT INTO `phpcms_city` VALUES (2232, '中华人民共和国', '贵州省', '贵阳市', '清镇市', '551400', '0851');
INSERT INTO `phpcms_city` VALUES (2233, '中华人民共和国', '贵州省', '六盘水市', '钟山区', '553000', '0858');
INSERT INTO `phpcms_city` VALUES (2234, '中华人民共和国', '贵州省', '六盘水市', '六枝特区', '553400', '0858');
INSERT INTO `phpcms_city` VALUES (2235, '中华人民共和国', '贵州省', '六盘水市', '水城县', '553000', '0858');
INSERT INTO `phpcms_city` VALUES (2236, '中华人民共和国', '贵州省', '六盘水市', '盘县', '561600', '0858');
INSERT INTO `phpcms_city` VALUES (2237, '中华人民共和国', '贵州省', '遵义市', '红花岗区', '563000', '0852');
INSERT INTO `phpcms_city` VALUES (2238, '中华人民共和国', '贵州省', '遵义市', '汇川区', '563000', '0852');
INSERT INTO `phpcms_city` VALUES (2239, '中华人民共和国', '贵州省', '遵义市', '遵义县', '563100', '0852');
INSERT INTO `phpcms_city` VALUES (2240, '中华人民共和国', '贵州省', '遵义市', '桐梓县', '563200', '0852');
INSERT INTO `phpcms_city` VALUES (2241, '中华人民共和国', '贵州省', '遵义市', '绥阳县', '563300', '0852');
INSERT INTO `phpcms_city` VALUES (2242, '中华人民共和国', '贵州省', '遵义市', '正安县', '563400', '0852');
INSERT INTO `phpcms_city` VALUES (2243, '中华人民共和国', '贵州省', '遵义市', '道真仡佬族苗族自治县', '563500', '0852');
INSERT INTO `phpcms_city` VALUES (2244, '中华人民共和国', '贵州省', '遵义市', '务川仡佬族苗族自治县', '564300', '0852');
INSERT INTO `phpcms_city` VALUES (2245, '中华人民共和国', '贵州省', '遵义市', '凤冈县', '564200', '0852');
INSERT INTO `phpcms_city` VALUES (2246, '中华人民共和国', '贵州省', '遵义市', '湄潭县', '564100', '0852');
INSERT INTO `phpcms_city` VALUES (2247, '中华人民共和国', '贵州省', '遵义市', '余庆县', '564400', '0852');
INSERT INTO `phpcms_city` VALUES (2248, '中华人民共和国', '贵州省', '遵义市', '习水县', '564600', '0852');
INSERT INTO `phpcms_city` VALUES (2249, '中华人民共和国', '贵州省', '遵义市', '赤水市', '564700', '0852');
INSERT INTO `phpcms_city` VALUES (2250, '中华人民共和国', '贵州省', '遵义市', '仁怀市', '564500', '0852');
INSERT INTO `phpcms_city` VALUES (2251, '中华人民共和国', '贵州省', '安顺市', '西秀区', '561000', '0853');
INSERT INTO `phpcms_city` VALUES (2252, '中华人民共和国', '贵州省', '安顺市', '平坝县', '561100', '0853');
INSERT INTO `phpcms_city` VALUES (2253, '中华人民共和国', '贵州省', '安顺市', '普定县', '562100', '0853');
INSERT INTO `phpcms_city` VALUES (2254, '中华人民共和国', '贵州省', '安顺市', '镇宁布依族苗族自治县', '561200', '0853');
INSERT INTO `phpcms_city` VALUES (2255, '中华人民共和国', '贵州省', '安顺市', '关岭布依族苗族自治县', '561300', '0853');
INSERT INTO `phpcms_city` VALUES (2256, '中华人民共和国', '贵州省', '安顺市', '紫云苗族布依族自治县', '550800', '0853');
INSERT INTO `phpcms_city` VALUES (2257, '中华人民共和国', '贵州省', '铜仁地区', '铜仁市', '554300', '0856');
INSERT INTO `phpcms_city` VALUES (2258, '中华人民共和国', '贵州省', '铜仁地区', '江口县', '554400', '0856');
INSERT INTO `phpcms_city` VALUES (2259, '中华人民共和国', '贵州省', '铜仁地区', '玉屏侗族自治县', '554000', '0856');
INSERT INTO `phpcms_city` VALUES (2260, '中华人民共和国', '贵州省', '铜仁地区', '石阡县', '555100', '0856');
INSERT INTO `phpcms_city` VALUES (2261, '中华人民共和国', '贵州省', '铜仁地区', '思南县', '565100', '0856');
INSERT INTO `phpcms_city` VALUES (2262, '中华人民共和国', '贵州省', '铜仁地区', '印江土家族苗族自治县', '555200', '0856');
INSERT INTO `phpcms_city` VALUES (2263, '中华人民共和国', '贵州省', '铜仁地区', '德江县', '565200', '0856');
INSERT INTO `phpcms_city` VALUES (2264, '中华人民共和国', '贵州省', '铜仁地区', '沿河土家族自治县', '565300', '0856');
INSERT INTO `phpcms_city` VALUES (2265, '中华人民共和国', '贵州省', '铜仁地区', '松桃苗族自治县', '554100', '0856');
INSERT INTO `phpcms_city` VALUES (2266, '中华人民共和国', '贵州省', '铜仁地区', '万山特区', '554200', '0856');
INSERT INTO `phpcms_city` VALUES (2267, '中华人民共和国', '贵州省', '黔西南布依族苗族自治州', '兴义市', '562400', '0859');
INSERT INTO `phpcms_city` VALUES (2268, '中华人民共和国', '贵州省', '黔西南布依族苗族自治州', '兴仁县', '562300', '0859');
INSERT INTO `phpcms_city` VALUES (2269, '中华人民共和国', '贵州省', '黔西南布依族苗族自治州', '普安县', '561500', '0859');
INSERT INTO `phpcms_city` VALUES (2270, '中华人民共和国', '贵州省', '黔西南布依族苗族自治州', '晴隆县', '561400', '0859');
INSERT INTO `phpcms_city` VALUES (2271, '中华人民共和国', '贵州省', '黔西南布依族苗族自治州', '贞丰县', '562200', '0859');
INSERT INTO `phpcms_city` VALUES (2272, '中华人民共和国', '贵州省', '黔西南布依族苗族自治州', '望谟县', '552300', '0859');
INSERT INTO `phpcms_city` VALUES (2273, '中华人民共和国', '贵州省', '黔西南布依族苗族自治州', '册亨县', '552200', '0859');
INSERT INTO `phpcms_city` VALUES (2274, '中华人民共和国', '贵州省', '黔西南布依族苗族自治州', '安龙县', '552400', '0859');
INSERT INTO `phpcms_city` VALUES (2275, '中华人民共和国', '贵州省', '毕节地区', '毕节市', '551700', '0857');
INSERT INTO `phpcms_city` VALUES (2276, '中华人民共和国', '贵州省', '毕节地区', '大方县', '551600', '0857');
INSERT INTO `phpcms_city` VALUES (2277, '中华人民共和国', '贵州省', '毕节地区', '黔西县', '551500', '0857');
INSERT INTO `phpcms_city` VALUES (2278, '中华人民共和国', '贵州省', '毕节地区', '金沙县', '551800', '0857');
INSERT INTO `phpcms_city` VALUES (2279, '中华人民共和国', '贵州省', '毕节地区', '织金县', '552100', '0857');
INSERT INTO `phpcms_city` VALUES (2280, '中华人民共和国', '贵州省', '毕节地区', '纳雍县', '553300', '0857');
INSERT INTO `phpcms_city` VALUES (2281, '中华人民共和国', '贵州省', '毕节地区', '威宁彝族回族苗族自治县', '553100', '0857');
INSERT INTO `phpcms_city` VALUES (2282, '中华人民共和国', '贵州省', '毕节地区', '赫章县', '553200', '0857');
INSERT INTO `phpcms_city` VALUES (2283, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '凯里市', '556000', '0855');
INSERT INTO `phpcms_city` VALUES (2284, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '黄平县', '556100', '0855');
INSERT INTO `phpcms_city` VALUES (2285, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '施秉县', '556200', '0855');
INSERT INTO `phpcms_city` VALUES (2286, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '三穗县', '556500', '0855');
INSERT INTO `phpcms_city` VALUES (2287, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '镇远县', '557700', '0855');
INSERT INTO `phpcms_city` VALUES (2288, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '岑巩县', '557800', '0855');
INSERT INTO `phpcms_city` VALUES (2289, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '天柱县', '556600', '0855');
INSERT INTO `phpcms_city` VALUES (2290, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '锦屏县', '556700', '0855');
INSERT INTO `phpcms_city` VALUES (2291, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '剑河县', '556400', '0855');
INSERT INTO `phpcms_city` VALUES (2292, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '台江县', '556300', '0855');
INSERT INTO `phpcms_city` VALUES (2293, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '黎平县', '557300', '0855');
INSERT INTO `phpcms_city` VALUES (2294, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '榕江县', '557200', '0855');
INSERT INTO `phpcms_city` VALUES (2295, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '从江县', '557400', '0855');
INSERT INTO `phpcms_city` VALUES (2296, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '雷山县', '557100', '0855');
INSERT INTO `phpcms_city` VALUES (2297, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '麻江县', '557600', '0855');
INSERT INTO `phpcms_city` VALUES (2298, '中华人民共和国', '贵州省', '黔东南苗族侗族自治州', '丹寨县', '557500', '0855');
INSERT INTO `phpcms_city` VALUES (2299, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '都匀市', '558000', '0854');
INSERT INTO `phpcms_city` VALUES (2300, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '福泉市', '550500', '0854');
INSERT INTO `phpcms_city` VALUES (2301, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '荔波县', '558400', '0854');
INSERT INTO `phpcms_city` VALUES (2302, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '贵定县', '551300', '0854');
INSERT INTO `phpcms_city` VALUES (2303, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '瓮安县', '550400', '0854');
INSERT INTO `phpcms_city` VALUES (2304, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '独山县', '558200', '0854');
INSERT INTO `phpcms_city` VALUES (2305, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '平塘县', '558300', '0854');
INSERT INTO `phpcms_city` VALUES (2306, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '罗甸县', '550100', '0854');
INSERT INTO `phpcms_city` VALUES (2307, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '长顺县', '550700', '0854');
INSERT INTO `phpcms_city` VALUES (2308, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '龙里县', '551200', '0854');
INSERT INTO `phpcms_city` VALUES (2309, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '惠水县', '550600', '0854');
INSERT INTO `phpcms_city` VALUES (2310, '中华人民共和国', '贵州省', '黔南布依族苗族自治州', '三都水族自治县', '558100', '0854');
INSERT INTO `phpcms_city` VALUES (2311, '中华人民共和国', '云南省', '昆明市', '五华区', '650000', '0871');
INSERT INTO `phpcms_city` VALUES (2312, '中华人民共和国', '云南省', '昆明市', '盘龙区', '650000', '0871');
INSERT INTO `phpcms_city` VALUES (2313, '中华人民共和国', '云南省', '昆明市', '官渡区', '650200', '0871');
INSERT INTO `phpcms_city` VALUES (2314, '中华人民共和国', '云南省', '昆明市', '西山区', '650100', '0871');
INSERT INTO `phpcms_city` VALUES (2315, '中华人民共和国', '云南省', '昆明市', '东川区', '654100', '0871');
INSERT INTO `phpcms_city` VALUES (2316, '中华人民共和国', '云南省', '昆明市', '呈贡县', '650500', '0871');
INSERT INTO `phpcms_city` VALUES (2317, '中华人民共和国', '云南省', '昆明市', '晋宁县', '650600', '0871');
INSERT INTO `phpcms_city` VALUES (2318, '中华人民共和国', '云南省', '昆明市', '富民县', '650400', '0871');
INSERT INTO `phpcms_city` VALUES (2319, '中华人民共和国', '云南省', '昆明市', '宜良县', '652100', '0871');
INSERT INTO `phpcms_city` VALUES (2320, '中华人民共和国', '云南省', '昆明市', '石林彝族自治县', '652200', '0871');
INSERT INTO `phpcms_city` VALUES (2321, '中华人民共和国', '云南省', '昆明市', '嵩明县', '651700', '0871');
INSERT INTO `phpcms_city` VALUES (2322, '中华人民共和国', '云南省', '昆明市', '禄劝彝族苗族自治县', '651500', '0871');
INSERT INTO `phpcms_city` VALUES (2323, '中华人民共和国', '云南省', '昆明市', '寻甸回族彝族自治县', '655200', '0871');
INSERT INTO `phpcms_city` VALUES (2324, '中华人民共和国', '云南省', '昆明市', '安宁市', '650300', '0871');
INSERT INTO `phpcms_city` VALUES (2325, '中华人民共和国', '云南省', '曲靖市', '麒麟区', '655000', '0874');
INSERT INTO `phpcms_city` VALUES (2326, '中华人民共和国', '云南省', '曲靖市', '马龙县', '655100', '0874');
INSERT INTO `phpcms_city` VALUES (2327, '中华人民共和国', '云南省', '曲靖市', '陆良县', '655600', '0874');
INSERT INTO `phpcms_city` VALUES (2328, '中华人民共和国', '云南省', '曲靖市', '师宗县', '655700', '0874');
INSERT INTO `phpcms_city` VALUES (2329, '中华人民共和国', '云南省', '曲靖市', '罗平县', '655800', '0874');
INSERT INTO `phpcms_city` VALUES (2330, '中华人民共和国', '云南省', '曲靖市', '富源县', '655500', '0874');
INSERT INTO `phpcms_city` VALUES (2331, '中华人民共和国', '云南省', '曲靖市', '会泽县', '654200', '0874');
INSERT INTO `phpcms_city` VALUES (2332, '中华人民共和国', '云南省', '曲靖市', '沾益县', '655500', '0874');
INSERT INTO `phpcms_city` VALUES (2333, '中华人民共和国', '云南省', '曲靖市', '宣威市', '655400', '0874');
INSERT INTO `phpcms_city` VALUES (2334, '中华人民共和国', '云南省', '玉溪市', '红塔区', '653100', '0877');
INSERT INTO `phpcms_city` VALUES (2335, '中华人民共和国', '云南省', '玉溪市', '江川县', '652600', '0877');
INSERT INTO `phpcms_city` VALUES (2336, '中华人民共和国', '云南省', '玉溪市', '澄江县', '652500', '0877');
INSERT INTO `phpcms_city` VALUES (2337, '中华人民共和国', '云南省', '玉溪市', '通海县', '652700', '0877');
INSERT INTO `phpcms_city` VALUES (2338, '中华人民共和国', '云南省', '玉溪市', '华宁县', '652800', '0877');
INSERT INTO `phpcms_city` VALUES (2339, '中华人民共和国', '云南省', '玉溪市', '易门县', '651100', '0877');
INSERT INTO `phpcms_city` VALUES (2340, '中华人民共和国', '云南省', '玉溪市', '峨山彝族自治县', '653200', '0877');
INSERT INTO `phpcms_city` VALUES (2341, '中华人民共和国', '云南省', '玉溪市', '新平彝族傣族自治县', '653400', '0877');
INSERT INTO `phpcms_city` VALUES (2342, '中华人民共和国', '云南省', '玉溪市', '元江哈尼族彝族傣族自治县', '653300', '0877');
INSERT INTO `phpcms_city` VALUES (2343, '中华人民共和国', '云南省', '保山市', '隆阳区', '678000', '0875');
INSERT INTO `phpcms_city` VALUES (2344, '中华人民共和国', '云南省', '保山市', '施甸县', '678200', '0875');
INSERT INTO `phpcms_city` VALUES (2345, '中华人民共和国', '云南省', '保山市', '腾冲县', '679100', '0875');
INSERT INTO `phpcms_city` VALUES (2346, '中华人民共和国', '云南省', '保山市', '龙陵县', '678300', '0875');
INSERT INTO `phpcms_city` VALUES (2347, '中华人民共和国', '云南省', '保山市', '昌宁县', '678100', '0875');
INSERT INTO `phpcms_city` VALUES (2348, '中华人民共和国', '云南省', '昭通市', '昭阳区', '657000', '0870');
INSERT INTO `phpcms_city` VALUES (2349, '中华人民共和国', '云南省', '昭通市', '鲁甸县', '657100', '0870');
INSERT INTO `phpcms_city` VALUES (2350, '中华人民共和国', '云南省', '昭通市', '巧家县', '654600', '0870');
INSERT INTO `phpcms_city` VALUES (2351, '中华人民共和国', '云南省', '昭通市', '盐津县', '657500', '0870');
INSERT INTO `phpcms_city` VALUES (2352, '中华人民共和国', '云南省', '昭通市', '大关县', '657400', '0870');
INSERT INTO `phpcms_city` VALUES (2353, '中华人民共和国', '云南省', '昭通市', '永善县', '657300', '0870');
INSERT INTO `phpcms_city` VALUES (2354, '中华人民共和国', '云南省', '昭通市', '绥江县', '657700', '0870');
INSERT INTO `phpcms_city` VALUES (2355, '中华人民共和国', '云南省', '昭通市', '镇雄县', '657200', '0870');
INSERT INTO `phpcms_city` VALUES (2356, '中华人民共和国', '云南省', '昭通市', '彝良县', '657600', '0870');
INSERT INTO `phpcms_city` VALUES (2357, '中华人民共和国', '云南省', '昭通市', '威信县', '657900', '0870');
INSERT INTO `phpcms_city` VALUES (2358, '中华人民共和国', '云南省', '昭通市', '水富县', '657800', '0870');
INSERT INTO `phpcms_city` VALUES (2359, '中华人民共和国', '云南省', '丽江市', '古城区', '674100', '0888');
INSERT INTO `phpcms_city` VALUES (2360, '中华人民共和国', '云南省', '丽江市', '玉龙纳西族自治县', '674100', '0888');
INSERT INTO `phpcms_city` VALUES (2361, '中华人民共和国', '云南省', '丽江市', '永胜县', '674200', '0888');
INSERT INTO `phpcms_city` VALUES (2362, '中华人民共和国', '云南省', '丽江市', '华坪县', '674800', '0888');
INSERT INTO `phpcms_city` VALUES (2363, '中华人民共和国', '云南省', '丽江市', '宁蒗彝族自治县', '674300', '0888');
INSERT INTO `phpcms_city` VALUES (2364, '中华人民共和国', '云南省', '思茅市', '翠云区', '665000', '0879');
INSERT INTO `phpcms_city` VALUES (2365, '中华人民共和国', '云南省', '思茅市', '普洱哈尼族彝族自治县', '665100', '0879');
INSERT INTO `phpcms_city` VALUES (2366, '中华人民共和国', '云南省', '思茅市', '墨江哈尼族自治县', '654800', '0879');
INSERT INTO `phpcms_city` VALUES (2367, '中华人民共和国', '云南省', '思茅市', '景东彝族自治县', '676200', '0879');
INSERT INTO `phpcms_city` VALUES (2368, '中华人民共和国', '云南省', '思茅市', '景谷傣族彝族自治县', '666400', '0879');
INSERT INTO `phpcms_city` VALUES (2369, '中华人民共和国', '云南省', '思茅市', '镇沅彝族哈尼族拉祜族自治县', '666500', '0879');
INSERT INTO `phpcms_city` VALUES (2370, '中华人民共和国', '云南省', '思茅市', '江城哈尼族彝族自治县', '665900', '0879');
INSERT INTO `phpcms_city` VALUES (2371, '中华人民共和国', '云南省', '思茅市', '孟连傣族拉祜族佤族自治县', '665800', '0879');
INSERT INTO `phpcms_city` VALUES (2372, '中华人民共和国', '云南省', '思茅市', '澜沧拉祜族自治县', '665600', '0879');
INSERT INTO `phpcms_city` VALUES (2373, '中华人民共和国', '云南省', '思茅市', '西盟佤族自治县', '665700', '0879');
INSERT INTO `phpcms_city` VALUES (2374, '中华人民共和国', '云南省', '临沧市', '临翔区', '677000', '0883');
INSERT INTO `phpcms_city` VALUES (2375, '中华人民共和国', '云南省', '临沧市', '凤庆县', '675900', '0883');
INSERT INTO `phpcms_city` VALUES (2376, '中华人民共和国', '云南省', '临沧市', '云县', '675800', '0883');
INSERT INTO `phpcms_city` VALUES (2377, '中华人民共和国', '云南省', '临沧市', '永德县', '677600', '0883');
INSERT INTO `phpcms_city` VALUES (2378, '中华人民共和国', '云南省', '临沧市', '镇康县', '677700', '0883');
INSERT INTO `phpcms_city` VALUES (2379, '中华人民共和国', '云南省', '临沧市', '双江拉祜族佤族布朗族傣族自治县', '677300', '0883');
INSERT INTO `phpcms_city` VALUES (2380, '中华人民共和国', '云南省', '临沧市', '耿马傣族佤族自治县', '677500', '0883');
INSERT INTO `phpcms_city` VALUES (2381, '中华人民共和国', '云南省', '楚雄彝族自治州', '沧源佤族自治县', '677400', '0883');
INSERT INTO `phpcms_city` VALUES (2382, '中华人民共和国', '云南省', '楚雄彝族自治州', '楚雄市', '675000', '0878');
INSERT INTO `phpcms_city` VALUES (2383, '中华人民共和国', '云南省', '楚雄彝族自治州', '双柏县', '675100', '0878');
INSERT INTO `phpcms_city` VALUES (2384, '中华人民共和国', '云南省', '楚雄彝族自治州', '牟定县', '675500', '0878');
INSERT INTO `phpcms_city` VALUES (2385, '中华人民共和国', '云南省', '楚雄彝族自治州', '南华县', '675200', '0878');
INSERT INTO `phpcms_city` VALUES (2386, '中华人民共和国', '云南省', '楚雄彝族自治州', '姚安县', '675300', '0878');
INSERT INTO `phpcms_city` VALUES (2387, '中华人民共和国', '云南省', '楚雄彝族自治州', '大姚县', '675400', '0878');
INSERT INTO `phpcms_city` VALUES (2388, '中华人民共和国', '云南省', '楚雄彝族自治州', '永仁县', '651400', '0878');
INSERT INTO `phpcms_city` VALUES (2389, '中华人民共和国', '云南省', '楚雄彝族自治州', '元谋县', '651300', '0878');
INSERT INTO `phpcms_city` VALUES (2390, '中华人民共和国', '云南省', '楚雄彝族自治州', '武定县', '651600', '0878');
INSERT INTO `phpcms_city` VALUES (2391, '中华人民共和国', '云南省', '楚雄彝族自治州', '禄丰县', '651200', '0878');
INSERT INTO `phpcms_city` VALUES (2392, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '个旧市', '661000', '0873');
INSERT INTO `phpcms_city` VALUES (2393, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '开远市', '661600', '0873');
INSERT INTO `phpcms_city` VALUES (2394, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '蒙自县', '661100', '0873');
INSERT INTO `phpcms_city` VALUES (2395, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '屏边苗族自治县', '661200', '0873');
INSERT INTO `phpcms_city` VALUES (2396, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '建水县', '654300', '0873');
INSERT INTO `phpcms_city` VALUES (2397, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '石屏县', '662200', '0873');
INSERT INTO `phpcms_city` VALUES (2398, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '弥勒县', '652300', '0873');
INSERT INTO `phpcms_city` VALUES (2399, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '泸西县', '652400', '0873');
INSERT INTO `phpcms_city` VALUES (2400, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '元阳县', '662400', '0873');
INSERT INTO `phpcms_city` VALUES (2401, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '红河县', '654400', '0873');
INSERT INTO `phpcms_city` VALUES (2402, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '金平苗族瑶族傣族自治县', '661500', '0873');
INSERT INTO `phpcms_city` VALUES (2403, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '绿春县', '662500', '0873');
INSERT INTO `phpcms_city` VALUES (2404, '中华人民共和国', '云南省', '红河哈尼族彝族自治州', '河口瑶族自治县', '661300', '0873');
INSERT INTO `phpcms_city` VALUES (2405, '中华人民共和国', '云南省', '文山壮族苗族自治州', '文山县', '663000', '0876');
INSERT INTO `phpcms_city` VALUES (2406, '中华人民共和国', '云南省', '文山壮族苗族自治州', '砚山县', '663100', '0876');
INSERT INTO `phpcms_city` VALUES (2407, '中华人民共和国', '云南省', '文山壮族苗族自治州', '西畴县', '663500', '0876');
INSERT INTO `phpcms_city` VALUES (2408, '中华人民共和国', '云南省', '文山壮族苗族自治州', '麻栗坡县', '663600', '0876');
INSERT INTO `phpcms_city` VALUES (2409, '中华人民共和国', '云南省', '文山壮族苗族自治州', '马关县', '663700', '0876');
INSERT INTO `phpcms_city` VALUES (2410, '中华人民共和国', '云南省', '文山壮族苗族自治州', '丘北县', '663200', '0876');
INSERT INTO `phpcms_city` VALUES (2411, '中华人民共和国', '云南省', '文山壮族苗族自治州', '广南县', '663300', '0876');
INSERT INTO `phpcms_city` VALUES (2412, '中华人民共和国', '云南省', '文山壮族苗族自治州', '富宁县', '663400', '0876');
INSERT INTO `phpcms_city` VALUES (2413, '中华人民共和国', '云南省', '西双版纳傣族自治州', '景洪市', '666100', '0691');
INSERT INTO `phpcms_city` VALUES (2414, '中华人民共和国', '云南省', '西双版纳傣族自治州', '勐海县', '666200', '0691');
INSERT INTO `phpcms_city` VALUES (2415, '中华人民共和国', '云南省', '西双版纳傣族自治州', '勐腊县', '666300', '0691');
INSERT INTO `phpcms_city` VALUES (2416, '中华人民共和国', '云南省', '大理白族自治州', '大理市', '671000', '0872');
INSERT INTO `phpcms_city` VALUES (2417, '中华人民共和国', '云南省', '大理白族自治州', '漾濞彝族自治县', '672500', '0872');
INSERT INTO `phpcms_city` VALUES (2418, '中华人民共和国', '云南省', '大理白族自治州', '祥云县', '672100', '0872');
INSERT INTO `phpcms_city` VALUES (2419, '中华人民共和国', '云南省', '大理白族自治州', '宾川县', '671600', '0872');
INSERT INTO `phpcms_city` VALUES (2420, '中华人民共和国', '云南省', '大理白族自治州', '弥渡县', '675600', '0872');
INSERT INTO `phpcms_city` VALUES (2421, '中华人民共和国', '云南省', '大理白族自治州', '南涧彝族自治县', '675700', '0872');
INSERT INTO `phpcms_city` VALUES (2422, '中华人民共和国', '云南省', '大理白族自治州', '巍山彝族回族自治县', '672400', '0872');
INSERT INTO `phpcms_city` VALUES (2423, '中华人民共和国', '云南省', '大理白族自治州', '永平县', '672600', '0872');
INSERT INTO `phpcms_city` VALUES (2424, '中华人民共和国', '云南省', '大理白族自治州', '云龙县', '672700', '0872');
INSERT INTO `phpcms_city` VALUES (2425, '中华人民共和国', '云南省', '大理白族自治州', '洱源县', '671200', '0872');
INSERT INTO `phpcms_city` VALUES (2426, '中华人民共和国', '云南省', '大理白族自治州', '剑川县', '671300', '0872');
INSERT INTO `phpcms_city` VALUES (2427, '中华人民共和国', '云南省', '大理白族自治州', '鹤庆县', '671500', '0872');
INSERT INTO `phpcms_city` VALUES (2428, '中华人民共和国', '云南省', '德宏傣族景颇族自治州', '瑞丽市', '678600', '0692');
INSERT INTO `phpcms_city` VALUES (2429, '中华人民共和国', '云南省', '德宏傣族景颇族自治州', '潞西市', '678400', '0692');
INSERT INTO `phpcms_city` VALUES (2430, '中华人民共和国', '云南省', '德宏傣族景颇族自治州', '梁河县', '679200', '0692');
INSERT INTO `phpcms_city` VALUES (2431, '中华人民共和国', '云南省', '德宏傣族景颇族自治州', '盈江县', '679300', '0692');
INSERT INTO `phpcms_city` VALUES (2432, '中华人民共和国', '云南省', '德宏傣族景颇族自治州', '陇川县', '678700', '0692');
INSERT INTO `phpcms_city` VALUES (2433, '中华人民共和国', '云南省', '怒江傈僳族自治州', '泸水县', '673200', '0886');
INSERT INTO `phpcms_city` VALUES (2434, '中华人民共和国', '云南省', '怒江傈僳族自治州', '福贡县', '673400', '0886');
INSERT INTO `phpcms_city` VALUES (2435, '中华人民共和国', '云南省', '怒江傈僳族自治州', '贡山独龙族怒族自治县', '673500', '0886');
INSERT INTO `phpcms_city` VALUES (2436, '中华人民共和国', '云南省', '怒江傈僳族自治州', '兰坪白族普米族自治县', '671400', '0886');
INSERT INTO `phpcms_city` VALUES (2437, '中华人民共和国', '云南省', '迪庆藏族自治州', '香格里拉县', '674400', '0887');
INSERT INTO `phpcms_city` VALUES (2438, '中华人民共和国', '云南省', '迪庆藏族自治州', '德钦县', '674500', '0887');
INSERT INTO `phpcms_city` VALUES (2439, '中华人民共和国', '云南省', '迪庆藏族自治州', '维西傈僳族自治县', '674600', '0887');
INSERT INTO `phpcms_city` VALUES (2440, '中华人民共和国', '西藏自治区', '拉萨市', '城关区', '850000', '0891');
INSERT INTO `phpcms_city` VALUES (2441, '中华人民共和国', '西藏自治区', '拉萨市', '林周县', '851600', '0891');
INSERT INTO `phpcms_city` VALUES (2442, '中华人民共和国', '西藏自治区', '拉萨市', '当雄县', '851500', '0891');
INSERT INTO `phpcms_city` VALUES (2443, '中华人民共和国', '西藏自治区', '拉萨市', '尼木县', '851600', '0891');
INSERT INTO `phpcms_city` VALUES (2444, '中华人民共和国', '西藏自治区', '拉萨市', '曲水县', '850600', '0891');
INSERT INTO `phpcms_city` VALUES (2445, '中华人民共和国', '西藏自治区', '拉萨市', '堆龙德庆县', '851400', '0891');
INSERT INTO `phpcms_city` VALUES (2446, '中华人民共和国', '西藏自治区', '拉萨市', '达孜县', '850100', '0891');
INSERT INTO `phpcms_city` VALUES (2447, '中华人民共和国', '西藏自治区', '拉萨市', '墨竹工卡县', '850200', '0891');
INSERT INTO `phpcms_city` VALUES (2448, '中华人民共和国', '西藏自治区', '昌都地区', '昌都县', '854000', '0895');
INSERT INTO `phpcms_city` VALUES (2449, '中华人民共和国', '西藏自治区', '昌都地区', '江达县', '854100', '0895');
INSERT INTO `phpcms_city` VALUES (2450, '中华人民共和国', '西藏自治区', '昌都地区', '贡觉县', '854200', '08053');
INSERT INTO `phpcms_city` VALUES (2451, '中华人民共和国', '西藏自治区', '昌都地区', '类乌齐县', '855600', '08050');
INSERT INTO `phpcms_city` VALUES (2452, '中华人民共和国', '西藏自治区', '昌都地区', '丁青县', '855700', '08059');
INSERT INTO `phpcms_city` VALUES (2453, '中华人民共和国', '西藏自治区', '昌都地区', '察雅县', '854300', '0895');
INSERT INTO `phpcms_city` VALUES (2454, '中华人民共和国', '西藏自治区', '昌都地区', '八宿县', '854600', '08056');
INSERT INTO `phpcms_city` VALUES (2455, '中华人民共和国', '西藏自治区', '昌都地区', '左贡县', '854400', '08055');
INSERT INTO `phpcms_city` VALUES (2456, '中华人民共和国', '西藏自治区', '昌都地区', '芒康县', '854500', '08054');
INSERT INTO `phpcms_city` VALUES (2457, '中华人民共和国', '西藏自治区', '昌都地区', '洛隆县', '855400', '08057');
INSERT INTO `phpcms_city` VALUES (2458, '中华人民共和国', '西藏自治区', '昌都地区', '边坝县', '855500', '08058');
INSERT INTO `phpcms_city` VALUES (2459, '中华人民共和国', '西藏自治区', '山南地区', '乃东县', '856100', '0893');
INSERT INTO `phpcms_city` VALUES (2460, '中华人民共和国', '西藏自治区', '山南地区', '扎囊县', '850800', '08040');
INSERT INTO `phpcms_city` VALUES (2461, '中华人民共和国', '西藏自治区', '山南地区', '贡嘎县', '850700', '0893');
INSERT INTO `phpcms_city` VALUES (2462, '中华人民共和国', '西藏自治区', '山南地区', '桑日县', '856200', '0893');
INSERT INTO `phpcms_city` VALUES (2463, '中华人民共和国', '西藏自治区', '山南地区', '琼结县', '856800', '08039');
INSERT INTO `phpcms_city` VALUES (2464, '中华人民共和国', '西藏自治区', '山南地区', '曲松县', '856300', '08037');
INSERT INTO `phpcms_city` VALUES (2465, '中华人民共和国', '西藏自治区', '山南地区', '措美县', '856900', '08077');
INSERT INTO `phpcms_city` VALUES (2466, '中华人民共和国', '西藏自治区', '山南地区', '洛扎县', '851200', '08047');
INSERT INTO `phpcms_city` VALUES (2467, '中华人民共和国', '西藏自治区', '山南地区', '加查县', '856400', '08036');
INSERT INTO `phpcms_city` VALUES (2468, '中华人民共和国', '西藏自治区', '山南地区', '隆子县', '856600', '08038');
INSERT INTO `phpcms_city` VALUES (2469, '中华人民共和国', '西藏自治区', '山南地区', '错那县', '856700', '08030');
INSERT INTO `phpcms_city` VALUES (2470, '中华人民共和国', '西藏自治区', '山南地区', '浪卡子县', '851100', '08048');
INSERT INTO `phpcms_city` VALUES (2471, '中华人民共和国', '西藏自治区', '日喀则地区', '日喀则市', '857000', '0892');
INSERT INTO `phpcms_city` VALUES (2472, '中华人民共和国', '西藏自治区', '日喀则地区', '南木林县', '857100', '08034');
INSERT INTO `phpcms_city` VALUES (2473, '中华人民共和国', '西藏自治区', '日喀则地区', '江孜县', '857400', '0892');
INSERT INTO `phpcms_city` VALUES (2474, '中华人民共和国', '西藏自治区', '日喀则地区', '定日县', '858200', '08026');
INSERT INTO `phpcms_city` VALUES (2475, '中华人民共和国', '西藏自治区', '日喀则地区', '萨迦县', '857800', '08024');
INSERT INTO `phpcms_city` VALUES (2476, '中华人民共和国', '西藏自治区', '日喀则地区', '拉孜县', '858100', '08032');
INSERT INTO `phpcms_city` VALUES (2477, '中华人民共和国', '西藏自治区', '日喀则地区', '昂仁县', '858500', '08031');
INSERT INTO `phpcms_city` VALUES (2478, '中华人民共和国', '西藏自治区', '日喀则地区', '谢通门县', '858900', '08033');
INSERT INTO `phpcms_city` VALUES (2479, '中华人民共和国', '西藏自治区', '日喀则地区', '白朗县', '857300', '0892');
INSERT INTO `phpcms_city` VALUES (2480, '中华人民共和国', '西藏自治区', '日喀则地区', '仁布县', '857200', '0892');
INSERT INTO `phpcms_city` VALUES (2481, '中华人民共和国', '西藏自治区', '日喀则地区', '康马县', '857500', '08021');
INSERT INTO `phpcms_city` VALUES (2482, '中华人民共和国', '西藏自治区', '日喀则地区', '定结县', '857900', '08025');
INSERT INTO `phpcms_city` VALUES (2483, '中华人民共和国', '西藏自治区', '日喀则地区', '仲巴县', '858800', '08029');
INSERT INTO `phpcms_city` VALUES (2484, '中华人民共和国', '西藏自治区', '日喀则地区', '亚东县', '857600', '08022');
INSERT INTO `phpcms_city` VALUES (2485, '中华人民共和国', '西藏自治区', '日喀则地区', '吉隆县', '858700', '08028');
INSERT INTO `phpcms_city` VALUES (2486, '中华人民共和国', '西藏自治区', '日喀则地区', '聂拉木县', '858300', '08027');
INSERT INTO `phpcms_city` VALUES (2487, '中华人民共和国', '西藏自治区', '日喀则地区', '萨嘎县', '858600', '08020');
INSERT INTO `phpcms_city` VALUES (2488, '中华人民共和国', '西藏自治区', '日喀则地区', '岗巴县', '857700', '08023');
INSERT INTO `phpcms_city` VALUES (2489, '中华人民共和国', '西藏自治区', '那曲地区', '那曲县', '852000', '0896');
INSERT INTO `phpcms_city` VALUES (2490, '中华人民共和国', '西藏自治区', '那曲地区', '嘉黎县', '852400', '08063');
INSERT INTO `phpcms_city` VALUES (2491, '中华人民共和国', '西藏自治区', '那曲地区', '比如县', '852300', '08062');
INSERT INTO `phpcms_city` VALUES (2492, '中华人民共和国', '西藏自治区', '那曲地区', '聂荣县', '853500', '08065');
INSERT INTO `phpcms_city` VALUES (2493, '中华人民共和国', '西藏自治区', '那曲地区', '安多县', '853400', '0896');
INSERT INTO `phpcms_city` VALUES (2494, '中华人民共和国', '西藏自治区', '那曲地区', '申扎县', '853100', '08068');
INSERT INTO `phpcms_city` VALUES (2495, '中华人民共和国', '西藏自治区', '那曲地区', '索县', '852200', '08078');
INSERT INTO `phpcms_city` VALUES (2496, '中华人民共和国', '西藏自治区', '那曲地区', '班戈县', '852500', '08067');
INSERT INTO `phpcms_city` VALUES (2497, '中华人民共和国', '西藏自治区', '那曲地区', '巴青县', '852100', '08061');
INSERT INTO `phpcms_city` VALUES (2498, '中华人民共和国', '西藏自治区', '那曲地区', '尼玛县', '853200', '08081');
INSERT INTO `phpcms_city` VALUES (2499, '中华人民共和国', '西藏自治区', '阿里地区', '普兰县', '859500', '08060');
INSERT INTO `phpcms_city` VALUES (2500, '中华人民共和国', '西藏自治区', '阿里地区', '札达县', '859600', '08071');
INSERT INTO `phpcms_city` VALUES (2501, '中华人民共和国', '西藏自治区', '阿里地区', '噶尔县', '859000', '0897');
INSERT INTO `phpcms_city` VALUES (2502, '中华人民共和国', '西藏自治区', '阿里地区', '日土县', '859700', '08075');
INSERT INTO `phpcms_city` VALUES (2503, '中华人民共和国', '西藏自治区', '阿里地区', '革吉县', '859100', '08072');
INSERT INTO `phpcms_city` VALUES (2504, '中华人民共和国', '西藏自治区', '阿里地区', '改则县', '859200', '08076');
INSERT INTO `phpcms_city` VALUES (2505, '中华人民共和国', '西藏自治区', '阿里地区', '措勤县', '859300', '08069');
INSERT INTO `phpcms_city` VALUES (2506, '中华人民共和国', '西藏自治区', '林芝地区', '林芝县', '860100', '0894');
INSERT INTO `phpcms_city` VALUES (2507, '中华人民共和国', '西藏自治区', '林芝地区', '工布江达县', '860200', '0894');
INSERT INTO `phpcms_city` VALUES (2508, '中华人民共和国', '西藏自治区', '林芝地区', '米林县', '860500', '0894');
INSERT INTO `phpcms_city` VALUES (2509, '中华人民共和国', '西藏自治区', '林芝地区', '墨脱县', '860700', '0894');
INSERT INTO `phpcms_city` VALUES (2510, '中华人民共和国', '西藏自治区', '林芝地区', '波密县', '860300', '0894');
INSERT INTO `phpcms_city` VALUES (2511, '中华人民共和国', '西藏自治区', '林芝地区', '察隅县', '860600', '0894');
INSERT INTO `phpcms_city` VALUES (2512, '中华人民共和国', '西藏自治区', '林芝地区', '朗县', '860400', '0894');
INSERT INTO `phpcms_city` VALUES (2513, '中华人民共和国', '陕西省', '西安市', '新城区', '710000', '029');
INSERT INTO `phpcms_city` VALUES (2514, '中华人民共和国', '陕西省', '西安市', '碑林区', '710000', '029');
INSERT INTO `phpcms_city` VALUES (2515, '中华人民共和国', '陕西省', '西安市', '莲湖区', '710000', '029');
INSERT INTO `phpcms_city` VALUES (2516, '中华人民共和国', '陕西省', '西安市', '灞桥区', '710000', '029');
INSERT INTO `phpcms_city` VALUES (2517, '中华人民共和国', '陕西省', '西安市', '未央区', '710000', '029');
INSERT INTO `phpcms_city` VALUES (2518, '中华人民共和国', '陕西省', '西安市', '雁塔区', '710000', '029');
INSERT INTO `phpcms_city` VALUES (2519, '中华人民共和国', '陕西省', '西安市', '阎良区', '710000', '029');
INSERT INTO `phpcms_city` VALUES (2520, '中华人民共和国', '陕西省', '西安市', '临潼区', '710600', '029');
INSERT INTO `phpcms_city` VALUES (2521, '中华人民共和国', '陕西省', '西安市', '长安区', '710100', '029');
INSERT INTO `phpcms_city` VALUES (2522, '中华人民共和国', '陕西省', '西安市', '蓝田县', '710500', '029');
INSERT INTO `phpcms_city` VALUES (2523, '中华人民共和国', '陕西省', '西安市', '周至县', '710400', '029');
INSERT INTO `phpcms_city` VALUES (2524, '中华人民共和国', '陕西省', '西安市', '户县', '710300', '029');
INSERT INTO `phpcms_city` VALUES (2525, '中华人民共和国', '陕西省', '西安市', '高陵县', '710200', '029');
INSERT INTO `phpcms_city` VALUES (2526, '中华人民共和国', '陕西省', '铜川市', '王益区', '727000', '0919');
INSERT INTO `phpcms_city` VALUES (2527, '中华人民共和国', '陕西省', '铜川市', '印台区', '727000', '0919');
INSERT INTO `phpcms_city` VALUES (2528, '中华人民共和国', '陕西省', '铜川市', '耀州区', '727100', '0919');
INSERT INTO `phpcms_city` VALUES (2529, '中华人民共和国', '陕西省', '铜川市', '宜君县', '727200', '0919');
INSERT INTO `phpcms_city` VALUES (2530, '中华人民共和国', '陕西省', '宝鸡市', '渭滨区', '721000', '0917');
INSERT INTO `phpcms_city` VALUES (2531, '中华人民共和国', '陕西省', '宝鸡市', '金台区', '721000', '0917');
INSERT INTO `phpcms_city` VALUES (2532, '中华人民共和国', '陕西省', '宝鸡市', '陈仓区', '721300', '0917');
INSERT INTO `phpcms_city` VALUES (2533, '中华人民共和国', '陕西省', '宝鸡市', '凤翔县', '721400', '0917');
INSERT INTO `phpcms_city` VALUES (2534, '中华人民共和国', '陕西省', '宝鸡市', '岐山县', '722400', '0917');
INSERT INTO `phpcms_city` VALUES (2535, '中华人民共和国', '陕西省', '宝鸡市', '扶风县', '722200', '0917');
INSERT INTO `phpcms_city` VALUES (2536, '中华人民共和国', '陕西省', '宝鸡市', '眉县', '722300', '0917');
INSERT INTO `phpcms_city` VALUES (2537, '中华人民共和国', '陕西省', '宝鸡市', '陇县', '721200', '0917');
INSERT INTO `phpcms_city` VALUES (2538, '中华人民共和国', '陕西省', '宝鸡市', '千阳县', '721100', '0917');
INSERT INTO `phpcms_city` VALUES (2539, '中华人民共和国', '陕西省', '宝鸡市', '麟游县', '721500', '0917');
INSERT INTO `phpcms_city` VALUES (2540, '中华人民共和国', '陕西省', '宝鸡市', '凤县', '721700', '0917');
INSERT INTO `phpcms_city` VALUES (2541, '中华人民共和国', '陕西省', '宝鸡市', '太白县', '721600', '0917');
INSERT INTO `phpcms_city` VALUES (2542, '中华人民共和国', '陕西省', '咸阳市', '秦都区', '712000', '0910');
INSERT INTO `phpcms_city` VALUES (2543, '中华人民共和国', '陕西省', '咸阳市', '杨凌区', '712100', '0910');
INSERT INTO `phpcms_city` VALUES (2544, '中华人民共和国', '陕西省', '咸阳市', '渭城区', '712000', '0910');
INSERT INTO `phpcms_city` VALUES (2545, '中华人民共和国', '陕西省', '咸阳市', '三原县', '713800', '0910');
INSERT INTO `phpcms_city` VALUES (2546, '中华人民共和国', '陕西省', '咸阳市', '泾阳县', '713700', '0910');
INSERT INTO `phpcms_city` VALUES (2547, '中华人民共和国', '陕西省', '咸阳市', '乾县', '713300', '0910');
INSERT INTO `phpcms_city` VALUES (2548, '中华人民共和国', '陕西省', '咸阳市', '礼泉县', '713200', '0910');
INSERT INTO `phpcms_city` VALUES (2549, '中华人民共和国', '陕西省', '咸阳市', '永寿县', '713400', '0910');
INSERT INTO `phpcms_city` VALUES (2550, '中华人民共和国', '陕西省', '咸阳市', '彬县', '713500', '0910');
INSERT INTO `phpcms_city` VALUES (2551, '中华人民共和国', '陕西省', '咸阳市', '长武县', '713600', '0910');
INSERT INTO `phpcms_city` VALUES (2552, '中华人民共和国', '陕西省', '咸阳市', '旬邑县', '711300', '0910');
INSERT INTO `phpcms_city` VALUES (2553, '中华人民共和国', '陕西省', '咸阳市', '淳化县', '711200', '0910');
INSERT INTO `phpcms_city` VALUES (2554, '中华人民共和国', '陕西省', '咸阳市', '武功县', '712200', '0910');
INSERT INTO `phpcms_city` VALUES (2555, '中华人民共和国', '陕西省', '咸阳市', '兴平市', '713100', '0910');
INSERT INTO `phpcms_city` VALUES (2556, '中华人民共和国', '陕西省', '渭南市', '临渭区', '714000', '0913');
INSERT INTO `phpcms_city` VALUES (2557, '中华人民共和国', '陕西省', '渭南市', '华县', '714100', '0913');
INSERT INTO `phpcms_city` VALUES (2558, '中华人民共和国', '陕西省', '渭南市', '潼关县', '714300', '0913');
INSERT INTO `phpcms_city` VALUES (2559, '中华人民共和国', '陕西省', '渭南市', '大荔县', '715100', '0913');
INSERT INTO `phpcms_city` VALUES (2560, '中华人民共和国', '陕西省', '渭南市', '合阳县', '715300', '0913');
INSERT INTO `phpcms_city` VALUES (2561, '中华人民共和国', '陕西省', '渭南市', '澄城县', '715200', '0913');
INSERT INTO `phpcms_city` VALUES (2562, '中华人民共和国', '陕西省', '渭南市', '蒲城县', '715500', '0913');
INSERT INTO `phpcms_city` VALUES (2563, '中华人民共和国', '陕西省', '渭南市', '白水县', '715600', '0913');
INSERT INTO `phpcms_city` VALUES (2564, '中华人民共和国', '陕西省', '渭南市', '富平县', '711700', '0913');
INSERT INTO `phpcms_city` VALUES (2565, '中华人民共和国', '陕西省', '渭南市', '韩城市', '715400', '0913');
INSERT INTO `phpcms_city` VALUES (2566, '中华人民共和国', '陕西省', '渭南市', '华阴市', '714200', '0913');
INSERT INTO `phpcms_city` VALUES (2567, '中华人民共和国', '陕西省', '延安市', '宝塔区', '716000', '0911');
INSERT INTO `phpcms_city` VALUES (2568, '中华人民共和国', '陕西省', '延安市', '延长县', '717100', '0911');
INSERT INTO `phpcms_city` VALUES (2569, '中华人民共和国', '陕西省', '延安市', '延川县', '717200', '0911');
INSERT INTO `phpcms_city` VALUES (2570, '中华人民共和国', '陕西省', '延安市', '子长县', '717300', '0911');
INSERT INTO `phpcms_city` VALUES (2571, '中华人民共和国', '陕西省', '延安市', '安塞县', '717400', '0911');
INSERT INTO `phpcms_city` VALUES (2572, '中华人民共和国', '陕西省', '延安市', '志丹县', '717500', '0911');
INSERT INTO `phpcms_city` VALUES (2573, '中华人民共和国', '陕西省', '延安市', '吴起县', '717600', '0911');
INSERT INTO `phpcms_city` VALUES (2574, '中华人民共和国', '陕西省', '延安市', '甘泉县', '716100', '0911');
INSERT INTO `phpcms_city` VALUES (2575, '中华人民共和国', '陕西省', '延安市', '富县', '727500', '0911');
INSERT INTO `phpcms_city` VALUES (2576, '中华人民共和国', '陕西省', '延安市', '洛川县', '727400', '0911');
INSERT INTO `phpcms_city` VALUES (2577, '中华人民共和国', '陕西省', '延安市', '宜川县', '716200', '0911');
INSERT INTO `phpcms_city` VALUES (2578, '中华人民共和国', '陕西省', '延安市', '黄龙县', '715700', '0911');
INSERT INTO `phpcms_city` VALUES (2579, '中华人民共和国', '陕西省', '延安市', '黄陵县', '727300', '0911');
INSERT INTO `phpcms_city` VALUES (2580, '中华人民共和国', '陕西省', '汉中市', '汉台区', '723000', '0916');
INSERT INTO `phpcms_city` VALUES (2581, '中华人民共和国', '陕西省', '汉中市', '南郑县', '723100', '0916');
INSERT INTO `phpcms_city` VALUES (2582, '中华人民共和国', '陕西省', '汉中市', '城固县', '723200', '0916');
INSERT INTO `phpcms_city` VALUES (2583, '中华人民共和国', '陕西省', '汉中市', '洋县', '723300', '0916');
INSERT INTO `phpcms_city` VALUES (2584, '中华人民共和国', '陕西省', '汉中市', '西乡县', '723500', '0916');
INSERT INTO `phpcms_city` VALUES (2585, '中华人民共和国', '陕西省', '汉中市', '勉县', '724200', '0916');
INSERT INTO `phpcms_city` VALUES (2586, '中华人民共和国', '陕西省', '汉中市', '宁强县', '724400', '0916');
INSERT INTO `phpcms_city` VALUES (2587, '中华人民共和国', '陕西省', '汉中市', '略阳县', '724300', '0916');
INSERT INTO `phpcms_city` VALUES (2588, '中华人民共和国', '陕西省', '汉中市', '镇巴县', '723600', '0916');
INSERT INTO `phpcms_city` VALUES (2589, '中华人民共和国', '陕西省', '汉中市', '留坝县', '724100', '0916');
INSERT INTO `phpcms_city` VALUES (2590, '中华人民共和国', '陕西省', '汉中市', '佛坪县', '723400', '0916');
INSERT INTO `phpcms_city` VALUES (2591, '中华人民共和国', '陕西省', '榆林市', '榆阳区', '719000', '0912');
INSERT INTO `phpcms_city` VALUES (2592, '中华人民共和国', '陕西省', '榆林市', '神木县', '719300', '0912');
INSERT INTO `phpcms_city` VALUES (2593, '中华人民共和国', '陕西省', '榆林市', '府谷县', '719400', '0912');
INSERT INTO `phpcms_city` VALUES (2594, '中华人民共和国', '陕西省', '榆林市', '横山县', '719200', '0912');
INSERT INTO `phpcms_city` VALUES (2595, '中华人民共和国', '陕西省', '榆林市', '靖边县', '718500', '0912');
INSERT INTO `phpcms_city` VALUES (2596, '中华人民共和国', '陕西省', '榆林市', '定边县', '718600', '0912');
INSERT INTO `phpcms_city` VALUES (2597, '中华人民共和国', '陕西省', '榆林市', '绥德县', '718000', '0912');
INSERT INTO `phpcms_city` VALUES (2598, '中华人民共和国', '陕西省', '榆林市', '米脂县', '718100', '0912');
INSERT INTO `phpcms_city` VALUES (2599, '中华人民共和国', '陕西省', '榆林市', '佳县', '719200', '0912');
INSERT INTO `phpcms_city` VALUES (2600, '中华人民共和国', '陕西省', '榆林市', '吴堡县', '718200', '0912');
INSERT INTO `phpcms_city` VALUES (2601, '中华人民共和国', '陕西省', '榆林市', '清涧县', '718300', '0912');
INSERT INTO `phpcms_city` VALUES (2602, '中华人民共和国', '陕西省', '榆林市', '子洲县', '718400', '0912');
INSERT INTO `phpcms_city` VALUES (2603, '中华人民共和国', '陕西省', '安康市', '汉滨区', '725000', '0915');
INSERT INTO `phpcms_city` VALUES (2604, '中华人民共和国', '陕西省', '安康市', '汉阴县', '725100', '0915');
INSERT INTO `phpcms_city` VALUES (2605, '中华人民共和国', '陕西省', '安康市', '石泉县', '725200', '0915');
INSERT INTO `phpcms_city` VALUES (2606, '中华人民共和国', '陕西省', '安康市', '宁陕县', '711600', '0915');
INSERT INTO `phpcms_city` VALUES (2607, '中华人民共和国', '陕西省', '安康市', '紫阳县', '725300', '0915');
INSERT INTO `phpcms_city` VALUES (2608, '中华人民共和国', '陕西省', '安康市', '岚皋县', '725400', '0915');
INSERT INTO `phpcms_city` VALUES (2609, '中华人民共和国', '陕西省', '安康市', '平利县', '725500', '0915');
INSERT INTO `phpcms_city` VALUES (2610, '中华人民共和国', '陕西省', '安康市', '镇坪县', '725600', '0915');
INSERT INTO `phpcms_city` VALUES (2611, '中华人民共和国', '陕西省', '安康市', '旬阳县', '725700', '0915');
INSERT INTO `phpcms_city` VALUES (2612, '中华人民共和国', '陕西省', '安康市', '白河县', '725800', '0915');
INSERT INTO `phpcms_city` VALUES (2613, '中华人民共和国', '陕西省', '商洛市', '商州区', '726000', '0914');
INSERT INTO `phpcms_city` VALUES (2614, '中华人民共和国', '陕西省', '商洛市', '洛南县', '726100', '0914');
INSERT INTO `phpcms_city` VALUES (2615, '中华人民共和国', '陕西省', '商洛市', '丹凤县', '726200', '0914');
INSERT INTO `phpcms_city` VALUES (2616, '中华人民共和国', '陕西省', '商洛市', '商南县', '726300', '0914');
INSERT INTO `phpcms_city` VALUES (2617, '中华人民共和国', '陕西省', '商洛市', '山阳县', '726400', '0914');
INSERT INTO `phpcms_city` VALUES (2618, '中华人民共和国', '陕西省', '商洛市', '镇安县', '711500', '0914');
INSERT INTO `phpcms_city` VALUES (2619, '中华人民共和国', '陕西省', '商洛市', '柞水县', '711400', '0914');
INSERT INTO `phpcms_city` VALUES (2620, '中华人民共和国', '甘肃省', '兰州市', '城关区', '730030', '0931');
INSERT INTO `phpcms_city` VALUES (2621, '中华人民共和国', '甘肃省', '兰州市', '七里河区', '730050', '0931');
INSERT INTO `phpcms_city` VALUES (2622, '中华人民共和国', '甘肃省', '兰州市', '西固区', '730060', '0931');
INSERT INTO `phpcms_city` VALUES (2623, '中华人民共和国', '甘肃省', '兰州市', '安宁区', '730070', '0931');
INSERT INTO `phpcms_city` VALUES (2624, '中华人民共和国', '甘肃省', '兰州市', '红古区', '730080', '0931');
INSERT INTO `phpcms_city` VALUES (2625, '中华人民共和国', '甘肃省', '兰州市', '永登县', '730300', '0931');
INSERT INTO `phpcms_city` VALUES (2626, '中华人民共和国', '甘肃省', '兰州市', '皋兰县', '730200', '0931');
INSERT INTO `phpcms_city` VALUES (2627, '中华人民共和国', '甘肃省', '兰州市', '榆中县', '730100', '0931');
INSERT INTO `phpcms_city` VALUES (2628, '中华人民共和国', '甘肃省', '嘉峪关市', '', '735100', '0937');
INSERT INTO `phpcms_city` VALUES (2629, '中华人民共和国', '甘肃省', '金昌市', '金川区', '737100', '0935');
INSERT INTO `phpcms_city` VALUES (2630, '中华人民共和国', '甘肃省', '金昌市', '永昌县', '737200', '0935');
INSERT INTO `phpcms_city` VALUES (2631, '中华人民共和国', '甘肃省', '白银市', '白银区', '730900', '0943');
INSERT INTO `phpcms_city` VALUES (2632, '中华人民共和国', '甘肃省', '白银市', '平川区', '730900', '0943');
INSERT INTO `phpcms_city` VALUES (2633, '中华人民共和国', '甘肃省', '白银市', '靖远县', '730600', '0943');
INSERT INTO `phpcms_city` VALUES (2634, '中华人民共和国', '甘肃省', '白银市', '会宁县', '730700', '0943');
INSERT INTO `phpcms_city` VALUES (2635, '中华人民共和国', '甘肃省', '白银市', '景泰县', '730400', '0943');
INSERT INTO `phpcms_city` VALUES (2636, '中华人民共和国', '甘肃省', '天水市', '秦城区', '741000', '0938');
INSERT INTO `phpcms_city` VALUES (2637, '中华人民共和国', '甘肃省', '天水市', '北道区', '741000', '0938');
INSERT INTO `phpcms_city` VALUES (2638, '中华人民共和国', '甘肃省', '天水市', '清水县', '741400', '0938');
INSERT INTO `phpcms_city` VALUES (2639, '中华人民共和国', '甘肃省', '天水市', '秦安县', '741600', '0938');
INSERT INTO `phpcms_city` VALUES (2640, '中华人民共和国', '甘肃省', '天水市', '甘谷县', '741200', '0938');
INSERT INTO `phpcms_city` VALUES (2641, '中华人民共和国', '甘肃省', '天水市', '武山县', '741300', '0938');
INSERT INTO `phpcms_city` VALUES (2642, '中华人民共和国', '甘肃省', '天水市', '张家川回族自治县', '741500', '0938');
INSERT INTO `phpcms_city` VALUES (2643, '中华人民共和国', '甘肃省', '武威市', '凉州区', '733000', '0935');
INSERT INTO `phpcms_city` VALUES (2644, '中华人民共和国', '甘肃省', '武威市', '民勤县', '733300', '0935');
INSERT INTO `phpcms_city` VALUES (2645, '中华人民共和国', '甘肃省', '武威市', '古浪县', '733100', '0935');
INSERT INTO `phpcms_city` VALUES (2646, '中华人民共和国', '甘肃省', '武威市', '天祝藏族自治县', '733200', '0935');
INSERT INTO `phpcms_city` VALUES (2647, '中华人民共和国', '甘肃省', '张掖市', '甘州区', '734000', '0936');
INSERT INTO `phpcms_city` VALUES (2648, '中华人民共和国', '甘肃省', '张掖市', '肃南裕固族自治县', '734400', '0936');
INSERT INTO `phpcms_city` VALUES (2649, '中华人民共和国', '甘肃省', '张掖市', '民乐县', '734500', '0936');
INSERT INTO `phpcms_city` VALUES (2650, '中华人民共和国', '甘肃省', '张掖市', '临泽县', '734200', '0936');
INSERT INTO `phpcms_city` VALUES (2651, '中华人民共和国', '甘肃省', '张掖市', '高台县', '734300', '0936');
INSERT INTO `phpcms_city` VALUES (2652, '中华人民共和国', '甘肃省', '张掖市', '山丹县', '734100', '0936');
INSERT INTO `phpcms_city` VALUES (2653, '中华人民共和国', '甘肃省', '平凉市', '崆峒区', '744000', '0933');
INSERT INTO `phpcms_city` VALUES (2654, '中华人民共和国', '甘肃省', '平凉市', '泾川县', '744300', '0933');
INSERT INTO `phpcms_city` VALUES (2655, '中华人民共和国', '甘肃省', '平凉市', '灵台县', '744400', '0933');
INSERT INTO `phpcms_city` VALUES (2656, '中华人民共和国', '甘肃省', '平凉市', '崇信县', '744200', '0933');
INSERT INTO `phpcms_city` VALUES (2657, '中华人民共和国', '甘肃省', '平凉市', '华亭县', '744100', '0933');
INSERT INTO `phpcms_city` VALUES (2658, '中华人民共和国', '甘肃省', '平凉市', '庄浪县', '744600', '0933');
INSERT INTO `phpcms_city` VALUES (2659, '中华人民共和国', '甘肃省', '平凉市', '静宁县', '743400', '0933');
INSERT INTO `phpcms_city` VALUES (2660, '中华人民共和国', '甘肃省', '酒泉市', '肃州区', '735000', '0937');
INSERT INTO `phpcms_city` VALUES (2661, '中华人民共和国', '甘肃省', '酒泉市', '金塔县', '735300', '0937');
INSERT INTO `phpcms_city` VALUES (2662, '中华人民共和国', '甘肃省', '酒泉市', '瓜州县', '736100', '0937');
INSERT INTO `phpcms_city` VALUES (2663, '中华人民共和国', '甘肃省', '酒泉市', '肃北蒙古族自治县', '736300', '0937');
INSERT INTO `phpcms_city` VALUES (2664, '中华人民共和国', '甘肃省', '酒泉市', '阿克塞哈萨克族自治县', '736400', '0937');
INSERT INTO `phpcms_city` VALUES (2665, '中华人民共和国', '甘肃省', '酒泉市', '玉门市', '735200', '0937');
INSERT INTO `phpcms_city` VALUES (2666, '中华人民共和国', '甘肃省', '酒泉市', '敦煌市', '736200', '0937');
INSERT INTO `phpcms_city` VALUES (2667, '中华人民共和国', '甘肃省', '庆阳市', '西峰区', '745000', '0934');
INSERT INTO `phpcms_city` VALUES (2668, '中华人民共和国', '甘肃省', '庆阳市', '庆城县', '745100', '0934');
INSERT INTO `phpcms_city` VALUES (2669, '中华人民共和国', '甘肃省', '庆阳市', '环县', '745700', '0934');
INSERT INTO `phpcms_city` VALUES (2670, '中华人民共和国', '甘肃省', '庆阳市', '华池县', '745600', '0934');
INSERT INTO `phpcms_city` VALUES (2671, '中华人民共和国', '甘肃省', '庆阳市', '合水县', '745400', '0934');
INSERT INTO `phpcms_city` VALUES (2672, '中华人民共和国', '甘肃省', '庆阳市', '正宁县', '745300', '0934');
INSERT INTO `phpcms_city` VALUES (2673, '中华人民共和国', '甘肃省', '庆阳市', '宁县', '745200', '0934');
INSERT INTO `phpcms_city` VALUES (2674, '中华人民共和国', '甘肃省', '庆阳市', '镇原县', '744500', '0934');
INSERT INTO `phpcms_city` VALUES (2675, '中华人民共和国', '甘肃省', '定西市', '安定区', '743000', '0932');
INSERT INTO `phpcms_city` VALUES (2676, '中华人民共和国', '甘肃省', '定西市', '通渭县', '743300', '0932');
INSERT INTO `phpcms_city` VALUES (2677, '中华人民共和国', '甘肃省', '定西市', '陇西县', '748100', '0932');
INSERT INTO `phpcms_city` VALUES (2678, '中华人民共和国', '甘肃省', '定西市', '渭源县', '748200', '0932');
INSERT INTO `phpcms_city` VALUES (2679, '中华人民共和国', '甘肃省', '定西市', '临洮县', '730500', '0932');
INSERT INTO `phpcms_city` VALUES (2680, '中华人民共和国', '甘肃省', '定西市', '漳县', '748300', '0932');
INSERT INTO `phpcms_city` VALUES (2681, '中华人民共和国', '甘肃省', '定西市', '岷县', '748400', '0932');
INSERT INTO `phpcms_city` VALUES (2682, '中华人民共和国', '甘肃省', '陇南市', '武都区', '746000', '0939');
INSERT INTO `phpcms_city` VALUES (2683, '中华人民共和国', '甘肃省', '陇南市', '成县', '742500', '0939');
INSERT INTO `phpcms_city` VALUES (2684, '中华人民共和国', '甘肃省', '陇南市', '文县', '746400', '0939');
INSERT INTO `phpcms_city` VALUES (2685, '中华人民共和国', '甘肃省', '陇南市', '宕昌县', '748500', '0939');
INSERT INTO `phpcms_city` VALUES (2686, '中华人民共和国', '甘肃省', '陇南市', '康县', '746500', '0939');
INSERT INTO `phpcms_city` VALUES (2687, '中华人民共和国', '甘肃省', '陇南市', '西和县', '742100', '0939');
INSERT INTO `phpcms_city` VALUES (2688, '中华人民共和国', '甘肃省', '陇南市', '礼县', '742200', '0939');
INSERT INTO `phpcms_city` VALUES (2689, '中华人民共和国', '甘肃省', '陇南市', '徽县', '742300', '0939');
INSERT INTO `phpcms_city` VALUES (2690, '中华人民共和国', '甘肃省', '陇南市', '两当县', '742400', '0939');
INSERT INTO `phpcms_city` VALUES (2691, '中华人民共和国', '甘肃省', '临夏回族自治州', '临夏市', '731100', '0930');
INSERT INTO `phpcms_city` VALUES (2692, '中华人民共和国', '甘肃省', '临夏回族自治州', '临夏县', '731800', '0930');
INSERT INTO `phpcms_city` VALUES (2693, '中华人民共和国', '甘肃省', '临夏回族自治州', '康乐县', '731500', '0930');
INSERT INTO `phpcms_city` VALUES (2694, '中华人民共和国', '甘肃省', '临夏回族自治州', '永靖县', '731600', '0930');
INSERT INTO `phpcms_city` VALUES (2695, '中华人民共和国', '甘肃省', '临夏回族自治州', '广河县', '731300', '0930');
INSERT INTO `phpcms_city` VALUES (2696, '中华人民共和国', '甘肃省', '临夏回族自治州', '和政县', '731200', '0930');
INSERT INTO `phpcms_city` VALUES (2697, '中华人民共和国', '甘肃省', '临夏回族自治州', '东乡族自治县', '731400', '0930');
INSERT INTO `phpcms_city` VALUES (2698, '中华人民共和国', '甘肃省', '临夏回族自治州', '积石山保安族东乡族撒拉族自治县', '731700', '0930');
INSERT INTO `phpcms_city` VALUES (2699, '中华人民共和国', '甘肃省', '甘南藏族自治州', '合作市', '747000', '0941');
INSERT INTO `phpcms_city` VALUES (2700, '中华人民共和国', '甘肃省', '甘南藏族自治州', '临潭县', '747500', '0941');
INSERT INTO `phpcms_city` VALUES (2701, '中华人民共和国', '甘肃省', '甘南藏族自治州', '卓尼县', '747600', '0941');
INSERT INTO `phpcms_city` VALUES (2702, '中华人民共和国', '甘肃省', '甘南藏族自治州', '舟曲县', '746300', '0941');
INSERT INTO `phpcms_city` VALUES (2703, '中华人民共和国', '甘肃省', '甘南藏族自治州', '迭部县', '747400', '0941');
INSERT INTO `phpcms_city` VALUES (2704, '中华人民共和国', '甘肃省', '甘南藏族自治州', '玛曲县', '747300', '0941');
INSERT INTO `phpcms_city` VALUES (2705, '中华人民共和国', '甘肃省', '甘南藏族自治州', '碌曲县', '747200', '0941');
INSERT INTO `phpcms_city` VALUES (2706, '中华人民共和国', '甘肃省', '甘南藏族自治州', '夏河县', '747100', '0941');
INSERT INTO `phpcms_city` VALUES (2707, '中华人民共和国', '青海省', '西宁市', '城东区', '810000', '0971');
INSERT INTO `phpcms_city` VALUES (2708, '中华人民共和国', '青海省', '西宁市', '城中区', '810000', '0971');
INSERT INTO `phpcms_city` VALUES (2709, '中华人民共和国', '青海省', '西宁市', '城西区', '810000', '0971');
INSERT INTO `phpcms_city` VALUES (2710, '中华人民共和国', '青海省', '西宁市', '城北区', '810000', '0971');
INSERT INTO `phpcms_city` VALUES (2711, '中华人民共和国', '青海省', '西宁市', '大通回族土族自治县', '810100', '0971');
INSERT INTO `phpcms_city` VALUES (2712, '中华人民共和国', '青海省', '西宁市', '湟中县', '811600', '0972');
INSERT INTO `phpcms_city` VALUES (2713, '中华人民共和国', '青海省', '西宁市', '湟源县', '812100', '0972');
INSERT INTO `phpcms_city` VALUES (2714, '中华人民共和国', '青海省', '海东地区', '平安县', '810600', '0972');
INSERT INTO `phpcms_city` VALUES (2715, '中华人民共和国', '青海省', '海东地区', '民和回族土族自治县', '810800', '0972');
INSERT INTO `phpcms_city` VALUES (2716, '中华人民共和国', '青海省', '海东地区', '乐都县', '810700', '0972');
INSERT INTO `phpcms_city` VALUES (2717, '中华人民共和国', '青海省', '海东地区', '互助土族自治县', '810500', '0972');
INSERT INTO `phpcms_city` VALUES (2718, '中华人民共和国', '青海省', '海东地区', '化隆回族自治县', '810900', '0972');
INSERT INTO `phpcms_city` VALUES (2719, '中华人民共和国', '青海省', '海东地区', '循化撒拉族自治县', '811100', '0972');
INSERT INTO `phpcms_city` VALUES (2720, '中华人民共和国', '青海省', '海北藏族自治州', '门源回族自治县', '810300', '0978');
INSERT INTO `phpcms_city` VALUES (2721, '中华人民共和国', '青海省', '海北藏族自治州', '祁连县', '810400', '0970');
INSERT INTO `phpcms_city` VALUES (2722, '中华人民共和国', '青海省', '海北藏族自治州', '海晏县', '812200', '0970');
INSERT INTO `phpcms_city` VALUES (2723, '中华人民共和国', '青海省', '海北藏族自治州', '刚察县', '812300', '0970');
INSERT INTO `phpcms_city` VALUES (2724, '中华人民共和国', '青海省', '黄南藏族自治州', '同仁县', '811300', '0973');
INSERT INTO `phpcms_city` VALUES (2725, '中华人民共和国', '青海省', '黄南藏族自治州', '尖扎县', '811200', '0973');
INSERT INTO `phpcms_city` VALUES (2726, '中华人民共和国', '青海省', '黄南藏族自治州', '泽库县', '811400', '0973');
INSERT INTO `phpcms_city` VALUES (2727, '中华人民共和国', '青海省', '黄南藏族自治州', '河南蒙古族自治县', '811500', '0973');
INSERT INTO `phpcms_city` VALUES (2728, '中华人民共和国', '青海省', '海南藏族自治州', '共和县', '813000', '0974');
INSERT INTO `phpcms_city` VALUES (2729, '中华人民共和国', '青海省', '海南藏族自治州', '同德县', '813200', '0974');
INSERT INTO `phpcms_city` VALUES (2730, '中华人民共和国', '青海省', '海南藏族自治州', '贵德县', '811700', '0974');
INSERT INTO `phpcms_city` VALUES (2731, '中华人民共和国', '青海省', '海南藏族自治州', '兴海县', '813300', '0974');
INSERT INTO `phpcms_city` VALUES (2732, '中华人民共和国', '青海省', '海南藏族自治州', '贵南县', '813100', '0974');
INSERT INTO `phpcms_city` VALUES (2733, '中华人民共和国', '青海省', '果洛藏族自治州', '玛沁县', '814000', '0975');
INSERT INTO `phpcms_city` VALUES (2734, '中华人民共和国', '青海省', '果洛藏族自治州', '班玛县', '814300', '0975');
INSERT INTO `phpcms_city` VALUES (2735, '中华人民共和国', '青海省', '果洛藏族自治州', '甘德县', '814100', '0975');
INSERT INTO `phpcms_city` VALUES (2736, '中华人民共和国', '青海省', '果洛藏族自治州', '达日县', '814200', '0975');
INSERT INTO `phpcms_city` VALUES (2737, '中华人民共和国', '青海省', '果洛藏族自治州', '久治县', '624700', '0975');
INSERT INTO `phpcms_city` VALUES (2738, '中华人民共和国', '青海省', '果洛藏族自治州', '玛多县', '813500', '0975');
INSERT INTO `phpcms_city` VALUES (2739, '中华人民共和国', '青海省', '玉树藏族自治州', '玉树县', '815000', '0976');
INSERT INTO `phpcms_city` VALUES (2740, '中华人民共和国', '青海省', '玉树藏族自治州', '杂多县', '815300', '0976');
INSERT INTO `phpcms_city` VALUES (2741, '中华人民共和国', '青海省', '玉树藏族自治州', '称多县', '815100', '0976');
INSERT INTO `phpcms_city` VALUES (2742, '中华人民共和国', '青海省', '玉树藏族自治州', '治多县', '815400', '0976');
INSERT INTO `phpcms_city` VALUES (2743, '中华人民共和国', '青海省', '玉树藏族自治州', '囊谦县', '815200', '0976');
INSERT INTO `phpcms_city` VALUES (2744, '中华人民共和国', '青海省', '玉树藏族自治州', '曲麻莱县', '815500', '0976');
INSERT INTO `phpcms_city` VALUES (2745, '中华人民共和国', '青海省', '海西蒙古族藏族自治州', '格尔木市', '816000', '0977');
INSERT INTO `phpcms_city` VALUES (2746, '中华人民共和国', '青海省', '海西蒙古族藏族自治州', '德令哈市', '817000', '0977');
INSERT INTO `phpcms_city` VALUES (2747, '中华人民共和国', '青海省', '海西蒙古族藏族自治州', '乌兰县', '817100', '0977');
INSERT INTO `phpcms_city` VALUES (2748, '中华人民共和国', '青海省', '海西蒙古族藏族自治州', '都兰县', '816100', '0977');
INSERT INTO `phpcms_city` VALUES (2749, '中华人民共和国', '青海省', '海西蒙古族藏族自治州', '天峻县', '817200', '0977');
INSERT INTO `phpcms_city` VALUES (2750, '中华人民共和国', '宁夏回族自治区', '银川市', '兴庆区', '750000', '0951');
INSERT INTO `phpcms_city` VALUES (2751, '中华人民共和国', '宁夏回族自治区', '银川市', '西夏区', '750000', '0951');
INSERT INTO `phpcms_city` VALUES (2752, '中华人民共和国', '宁夏回族自治区', '银川市', '金凤区', '750000', '0951');
INSERT INTO `phpcms_city` VALUES (2753, '中华人民共和国', '宁夏回族自治区', '银川市', '永宁县', '750100', '0951');
INSERT INTO `phpcms_city` VALUES (2754, '中华人民共和国', '宁夏回族自治区', '银川市', '贺兰县', '750200', '0951');
INSERT INTO `phpcms_city` VALUES (2755, '中华人民共和国', '宁夏回族自治区', '银川市', '灵武市', '751400', '0951');
INSERT INTO `phpcms_city` VALUES (2756, '中华人民共和国', '宁夏回族自治区', '石嘴山市', '大武口区', '753000', '0952');
INSERT INTO `phpcms_city` VALUES (2757, '中华人民共和国', '宁夏回族自治区', '石嘴山市', '惠农区', '753000', '0952');
INSERT INTO `phpcms_city` VALUES (2758, '中华人民共和国', '宁夏回族自治区', '石嘴山市', '平罗县', '753400', '0952');
INSERT INTO `phpcms_city` VALUES (2759, '中华人民共和国', '宁夏回族自治区', '吴忠市', '利通区', '751100', '0953');
INSERT INTO `phpcms_city` VALUES (2760, '中华人民共和国', '宁夏回族自治区', '吴忠市', '盐池县', '751500', '0953');
INSERT INTO `phpcms_city` VALUES (2761, '中华人民共和国', '宁夏回族自治区', '吴忠市', '同心县', '751300', '0953');
INSERT INTO `phpcms_city` VALUES (2762, '中华人民共和国', '宁夏回族自治区', '吴忠市', '青铜峡市', '751600', '0953');
INSERT INTO `phpcms_city` VALUES (2763, '中华人民共和国', '宁夏回族自治区', '固原市', '原州区', '756000', '0954');
INSERT INTO `phpcms_city` VALUES (2764, '中华人民共和国', '宁夏回族自治区', '固原市', '西吉县', '756200', '0954');
INSERT INTO `phpcms_city` VALUES (2765, '中华人民共和国', '宁夏回族自治区', '固原市', '隆德县', '756300', '0954');
INSERT INTO `phpcms_city` VALUES (2766, '中华人民共和国', '宁夏回族自治区', '固原市', '泾源县', '756400', '0954');
INSERT INTO `phpcms_city` VALUES (2767, '中华人民共和国', '宁夏回族自治区', '固原市', '彭阳县', '756500', '0954');
INSERT INTO `phpcms_city` VALUES (2768, '中华人民共和国', '宁夏回族自治区', '中卫市', '沙坡头区', '755000', '0953');
INSERT INTO `phpcms_city` VALUES (2769, '中华人民共和国', '宁夏回族自治区', '中卫市', '中宁县', '755100', '0953');
INSERT INTO `phpcms_city` VALUES (2770, '中华人民共和国', '宁夏回族自治区', '中卫市', '海原县', '755200', '0954');
INSERT INTO `phpcms_city` VALUES (2771, '中华人民共和国', '新疆维吾尔自治区', '乌鲁木齐市', '天山区', '830000', '0991');
INSERT INTO `phpcms_city` VALUES (2772, '中华人民共和国', '新疆维吾尔自治区', '乌鲁木齐市', '沙依巴克区', '830000', '0991');
INSERT INTO `phpcms_city` VALUES (2773, '中华人民共和国', '新疆维吾尔自治区', '乌鲁木齐市', '新市区', '830000', '0991');
INSERT INTO `phpcms_city` VALUES (2774, '中华人民共和国', '新疆维吾尔自治区', '乌鲁木齐市', '水磨沟区', '830000', '0991');
INSERT INTO `phpcms_city` VALUES (2775, '中华人民共和国', '新疆维吾尔自治区', '乌鲁木齐市', '头屯河区', '830000', '0991');
INSERT INTO `phpcms_city` VALUES (2776, '中华人民共和国', '新疆维吾尔自治区', '乌鲁木齐市', '达坂城区', '830000', '0991');
INSERT INTO `phpcms_city` VALUES (2777, '中华人民共和国', '新疆维吾尔自治区', '乌鲁木齐市', '东山区', '830000', '0991');
INSERT INTO `phpcms_city` VALUES (2778, '中华人民共和国', '新疆维吾尔自治区', '乌鲁木齐市', '乌鲁木齐县', '830000', '0991');
INSERT INTO `phpcms_city` VALUES (2779, '中华人民共和国', '新疆维吾尔自治区', '克拉玛依市', '独山子区', '834000', '0990');
INSERT INTO `phpcms_city` VALUES (2780, '中华人民共和国', '新疆维吾尔自治区', '克拉玛依市', '克拉玛依区', '834000', '0990');
INSERT INTO `phpcms_city` VALUES (2781, '中华人民共和国', '新疆维吾尔自治区', '克拉玛依市', '白碱滩区', '834000', '0990');
INSERT INTO `phpcms_city` VALUES (2782, '中华人民共和国', '新疆维吾尔自治区', '克拉玛依市', '乌尔禾区', '834000', '0990');
INSERT INTO `phpcms_city` VALUES (2783, '中华人民共和国', '新疆维吾尔自治区', '吐鲁番地区', '吐鲁番市', '838000', '0995');
INSERT INTO `phpcms_city` VALUES (2784, '中华人民共和国', '新疆维吾尔自治区', '吐鲁番地区', '鄯善县', '838200', '0995');
INSERT INTO `phpcms_city` VALUES (2785, '中华人民共和国', '新疆维吾尔自治区', '吐鲁番地区', '托克逊县', '838100', '0995');
INSERT INTO `phpcms_city` VALUES (2786, '中华人民共和国', '新疆维吾尔自治区', '哈密地区', '哈密市', '839000', '0902');
INSERT INTO `phpcms_city` VALUES (2787, '中华人民共和国', '新疆维吾尔自治区', '哈密地区', '巴里坤哈萨克自治县', '839200', '0902');
INSERT INTO `phpcms_city` VALUES (2788, '中华人民共和国', '新疆维吾尔自治区', '哈密地区', '伊吾县', '839300', '0902');
INSERT INTO `phpcms_city` VALUES (2789, '中华人民共和国', '新疆维吾尔自治区', '昌吉回族自治州', '昌吉市', '831100', '0994');
INSERT INTO `phpcms_city` VALUES (2790, '中华人民共和国', '新疆维吾尔自治区', '昌吉回族自治州', '阜康市', '831500', '0994');
INSERT INTO `phpcms_city` VALUES (2791, '中华人民共和国', '新疆维吾尔自治区', '昌吉回族自治州', '米泉市', '831400', '0994');
INSERT INTO `phpcms_city` VALUES (2792, '中华人民共和国', '新疆维吾尔自治区', '昌吉回族自治州', '呼图壁县', '831200', '0994');
INSERT INTO `phpcms_city` VALUES (2793, '中华人民共和国', '新疆维吾尔自治区', '昌吉回族自治州', '玛纳斯县', '832200', '0994');
INSERT INTO `phpcms_city` VALUES (2794, '中华人民共和国', '新疆维吾尔自治区', '昌吉回族自治州', '奇台县', '831800', '0994');
INSERT INTO `phpcms_city` VALUES (2795, '中华人民共和国', '新疆维吾尔自治区', '昌吉回族自治州', '吉木萨尔县', '831700', '0994');
INSERT INTO `phpcms_city` VALUES (2796, '中华人民共和国', '新疆维吾尔自治区', '昌吉回族自治州', '木垒哈萨克自治县', '831900', '0994');
INSERT INTO `phpcms_city` VALUES (2797, '中华人民共和国', '新疆维吾尔自治区', '博尔塔拉蒙古自治州', '博乐市', '833400', '0909');
INSERT INTO `phpcms_city` VALUES (2798, '中华人民共和国', '新疆维吾尔自治区', '博尔塔拉蒙古自治州', '精河县', '833300', '0909');
INSERT INTO `phpcms_city` VALUES (2799, '中华人民共和国', '新疆维吾尔自治区', '博尔塔拉蒙古自治州', '温泉县', '833500', '0909');
INSERT INTO `phpcms_city` VALUES (2800, '中华人民共和国', '新疆维吾尔自治区', '巴音郭楞蒙古自治州', '库尔勒市', '841000', '0996');
INSERT INTO `phpcms_city` VALUES (2801, '中华人民共和国', '新疆维吾尔自治区', '巴音郭楞蒙古自治州', '轮台县', '841600', '0996');
INSERT INTO `phpcms_city` VALUES (2802, '中华人民共和国', '新疆维吾尔自治区', '巴音郭楞蒙古自治州', '尉犁县', '841500', '0996');
INSERT INTO `phpcms_city` VALUES (2803, '中华人民共和国', '新疆维吾尔自治区', '巴音郭楞蒙古自治州', '若羌县', '841800', '0996');
INSERT INTO `phpcms_city` VALUES (2804, '中华人民共和国', '新疆维吾尔自治区', '巴音郭楞蒙古自治州', '且末县', '841900', '0996');
INSERT INTO `phpcms_city` VALUES (2805, '中华人民共和国', '新疆维吾尔自治区', '巴音郭楞蒙古自治州', '焉耆回族自治县', '841100', '0996');
INSERT INTO `phpcms_city` VALUES (2806, '中华人民共和国', '新疆维吾尔自治区', '巴音郭楞蒙古自治州', '和静县', '841300', '0996');
INSERT INTO `phpcms_city` VALUES (2807, '中华人民共和国', '新疆维吾尔自治区', '巴音郭楞蒙古自治州', '和硕县', '841200', '0996');
INSERT INTO `phpcms_city` VALUES (2808, '中华人民共和国', '新疆维吾尔自治区', '巴音郭楞蒙古自治州', '博湖县', '841400', '0996');
INSERT INTO `phpcms_city` VALUES (2809, '中华人民共和国', '新疆维吾尔自治区', '阿克苏地区', '阿克苏市', '843000', '0997');
INSERT INTO `phpcms_city` VALUES (2810, '中华人民共和国', '新疆维吾尔自治区', '阿克苏地区', '温宿县', '843100', '0997');
INSERT INTO `phpcms_city` VALUES (2811, '中华人民共和国', '新疆维吾尔自治区', '阿克苏地区', '库车县', '842000', '0997');
INSERT INTO `phpcms_city` VALUES (2812, '中华人民共和国', '新疆维吾尔自治区', '阿克苏地区', '沙雅县', '842200', '0997');
INSERT INTO `phpcms_city` VALUES (2813, '中华人民共和国', '新疆维吾尔自治区', '阿克苏地区', '新和县', '842100', '0997');
INSERT INTO `phpcms_city` VALUES (2814, '中华人民共和国', '新疆维吾尔自治区', '阿克苏地区', '拜城县', '842300', '0997');
INSERT INTO `phpcms_city` VALUES (2815, '中华人民共和国', '新疆维吾尔自治区', '阿克苏地区', '乌什县', '843400', '0997');
INSERT INTO `phpcms_city` VALUES (2816, '中华人民共和国', '新疆维吾尔自治区', '阿克苏地区', '阿瓦提县', '843200', '0997');
INSERT INTO `phpcms_city` VALUES (2817, '中华人民共和国', '新疆维吾尔自治区', '阿克苏地区', '柯坪县', '843600', '0997');
INSERT INTO `phpcms_city` VALUES (2818, '中华人民共和国', '新疆维吾尔自治区', '克孜勒苏柯尔克孜自治州', '阿图什市', '845350', '0908');
INSERT INTO `phpcms_city` VALUES (2819, '中华人民共和国', '新疆维吾尔自治区', '克孜勒苏柯尔克孜自治州', '阿克陶县', '845550', '0908');
INSERT INTO `phpcms_city` VALUES (2820, '中华人民共和国', '新疆维吾尔自治区', '克孜勒苏柯尔克孜自治州', '阿合奇县', '843500', '0997');
INSERT INTO `phpcms_city` VALUES (2821, '中华人民共和国', '新疆维吾尔自治区', '克孜勒苏柯尔克孜自治州', '乌恰县', '845450', '0908');
INSERT INTO `phpcms_city` VALUES (2822, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '喀什市', '844000', '0998');
INSERT INTO `phpcms_city` VALUES (2823, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '疏附县', '844100', '0998');
INSERT INTO `phpcms_city` VALUES (2824, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '疏勒县', '844200', '0998');
INSERT INTO `phpcms_city` VALUES (2825, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '英吉沙县', '844500', '0998');
INSERT INTO `phpcms_city` VALUES (2826, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '泽普县', '844800', '0998');
INSERT INTO `phpcms_city` VALUES (2827, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '莎车县', '844700', '0998');
INSERT INTO `phpcms_city` VALUES (2828, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '叶城县', '844900', '0998');
INSERT INTO `phpcms_city` VALUES (2829, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '麦盖提县', '844600', '0998');
INSERT INTO `phpcms_city` VALUES (2830, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '岳普湖县', '844400', '0998');
INSERT INTO `phpcms_city` VALUES (2831, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '伽师县', '844300', '0998');
INSERT INTO `phpcms_city` VALUES (2832, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '巴楚县', '843800', '0998');
INSERT INTO `phpcms_city` VALUES (2833, '中华人民共和国', '新疆维吾尔自治区', '喀什地区', '塔什库尔干塔吉克自治县', '845250', '0998');
INSERT INTO `phpcms_city` VALUES (2834, '中华人民共和国', '新疆维吾尔自治区', '和田地区', '和田市', '848000', '0903');
INSERT INTO `phpcms_city` VALUES (2835, '中华人民共和国', '新疆维吾尔自治区', '和田地区', '和田县', '848000', '0903');
INSERT INTO `phpcms_city` VALUES (2836, '中华人民共和国', '新疆维吾尔自治区', '和田地区', '墨玉县', '848100', '0903');
INSERT INTO `phpcms_city` VALUES (2837, '中华人民共和国', '新疆维吾尔自治区', '和田地区', '皮山县', '845150', '0903');
INSERT INTO `phpcms_city` VALUES (2838, '中华人民共和国', '新疆维吾尔自治区', '和田地区', '洛浦县', '848200', '0903');
INSERT INTO `phpcms_city` VALUES (2839, '中华人民共和国', '新疆维吾尔自治区', '和田地区', '策勒县', '848300', '0903');
INSERT INTO `phpcms_city` VALUES (2840, '中华人民共和国', '新疆维吾尔自治区', '和田地区', '于田县', '848400', '0903');
INSERT INTO `phpcms_city` VALUES (2841, '中华人民共和国', '新疆维吾尔自治区', '和田地区', '民丰县', '848500', '0903');
INSERT INTO `phpcms_city` VALUES (2842, '中华人民共和国', '新疆维吾尔自治区', '伊犁哈萨克自治州', '伊宁市', '835000', '0999');
INSERT INTO `phpcms_city` VALUES (2843, '中华人民共和国', '新疆维吾尔自治区', '伊犁哈萨克自治州', '奎屯市', '833200', '0992');
INSERT INTO `phpcms_city` VALUES (2844, '中华人民共和国', '新疆维吾尔自治区', '伊犁哈萨克自治州', '伊宁县', '835100', '0999');
INSERT INTO `phpcms_city` VALUES (2845, '中华人民共和国', '新疆维吾尔自治区', '伊犁哈萨克自治州', '察布查尔锡伯自治县', '835300', '0999');
INSERT INTO `phpcms_city` VALUES (2846, '中华人民共和国', '新疆维吾尔自治区', '伊犁哈萨克自治州', '霍城县', '835200', '0999');
INSERT INTO `phpcms_city` VALUES (2847, '中华人民共和国', '新疆维吾尔自治区', '伊犁哈萨克自治州', '巩留县', '835400', '0999');
INSERT INTO `phpcms_city` VALUES (2848, '中华人民共和国', '新疆维吾尔自治区', '伊犁哈萨克自治州', '新源县', '835800', '0999');
INSERT INTO `phpcms_city` VALUES (2849, '中华人民共和国', '新疆维吾尔自治区', '伊犁哈萨克自治州', '昭苏县', '835600', '0999');
INSERT INTO `phpcms_city` VALUES (2850, '中华人民共和国', '新疆维吾尔自治区', '伊犁哈萨克自治州', '特克斯县', '835500', '0999');
INSERT INTO `phpcms_city` VALUES (2851, '中华人民共和国', '新疆维吾尔自治区', '伊犁哈萨克自治州', '尼勒克县', '835700', '0999');
INSERT INTO `phpcms_city` VALUES (2852, '中华人民共和国', '新疆维吾尔自治区', '塔城地区', '塔城市', '834300', '0901');
INSERT INTO `phpcms_city` VALUES (2853, '中华人民共和国', '新疆维吾尔自治区', '塔城地区', '乌苏市', '833300', '0992');
INSERT INTO `phpcms_city` VALUES (2854, '中华人民共和国', '新疆维吾尔自治区', '塔城地区', '额敏县', '834600', '0901');
INSERT INTO `phpcms_city` VALUES (2855, '中华人民共和国', '新疆维吾尔自治区', '塔城地区', '沙湾县', '832100', '0993');
INSERT INTO `phpcms_city` VALUES (2856, '中华人民共和国', '新疆维吾尔自治区', '塔城地区', '托里县', '834500', '0901');
INSERT INTO `phpcms_city` VALUES (2857, '中华人民共和国', '新疆维吾尔自治区', '塔城地区', '裕民县', '834800', '0901');
INSERT INTO `phpcms_city` VALUES (2858, '中华人民共和国', '新疆维吾尔自治区', '塔城地区', '和布克赛尔蒙古自治县', '834400', '0990');
INSERT INTO `phpcms_city` VALUES (2859, '中华人民共和国', '新疆维吾尔自治区', '阿勒泰地区', '阿勒泰市', '836500', '0906');
INSERT INTO `phpcms_city` VALUES (2860, '中华人民共和国', '新疆维吾尔自治区', '阿勒泰地区', '布尔津县', '836600', '0906');
INSERT INTO `phpcms_city` VALUES (2861, '中华人民共和国', '新疆维吾尔自治区', '阿勒泰地区', '富蕴县', '836100', '0906');
INSERT INTO `phpcms_city` VALUES (2862, '中华人民共和国', '新疆维吾尔自治区', '阿勒泰地区', '福海县', '836400', '0906');
INSERT INTO `phpcms_city` VALUES (2863, '中华人民共和国', '新疆维吾尔自治区', '阿勒泰地区', '哈巴河县', '836700', '0906');
INSERT INTO `phpcms_city` VALUES (2864, '中华人民共和国', '新疆维吾尔自治区', '阿勒泰地区', '青河县', '836200', '0906');
INSERT INTO `phpcms_city` VALUES (2865, '中华人民共和国', '新疆维吾尔自治区', '阿勒泰地区', '吉木乃县', '836800', '0906');
INSERT INTO `phpcms_city` VALUES (2866, '中华人民共和国', '新疆维吾尔自治区', '石河子市', '', '832000', '0993');
INSERT INTO `phpcms_city` VALUES (2867, '中华人民共和国', '新疆维吾尔自治区', '阿拉尔市', '', '843300', '0997');
INSERT INTO `phpcms_city` VALUES (2868, '中华人民共和国', '新疆维吾尔自治区', '图木舒克市', '', '844000', '0998');
INSERT INTO `phpcms_city` VALUES (2869, '中华人民共和国', '新疆维吾尔自治区', '五家渠市', '', '831300', '0994');
INSERT INTO `phpcms_city` VALUES (2870, '中华人民共和国', '台湾省', '台北市', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2871, '中华人民共和国', '台湾省', '高雄市', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2872, '中华人民共和国', '台湾省', '基隆市', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2873, '中华人民共和国', '台湾省', '新竹市', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2874, '中华人民共和国', '台湾省', '台中市', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2875, '中华人民共和国', '台湾省', '嘉义市', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2876, '中华人民共和国', '台湾省', '台南市', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2877, '中华人民共和国', '台湾省', '台北县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2878, '中华人民共和国', '台湾省', '桃园县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2879, '中华人民共和国', '台湾省', '新竹县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2880, '中华人民共和国', '台湾省', '苗栗县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2881, '中华人民共和国', '台湾省', '台中县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2882, '中华人民共和国', '台湾省', '彰化县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2883, '中华人民共和国', '台湾省', '南投县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2884, '中华人民共和国', '台湾省', '云林县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2885, '中华人民共和国', '台湾省', '嘉义县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2886, '中华人民共和国', '台湾省', '台南县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2887, '中华人民共和国', '台湾省', '高雄县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2888, '中华人民共和国', '台湾省', '屏东县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2889, '中华人民共和国', '台湾省', '宜兰县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2890, '中华人民共和国', '台湾省', '花莲县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2891, '中华人民共和国', '台湾省', '台东县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2892, '中华人民共和国', '台湾省', '澎湖县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2893, '中华人民共和国', '台湾省', '金门县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2894, '中华人民共和国', '台湾省', '连江县', '', '999079', '00886');
INSERT INTO `phpcms_city` VALUES (2895, '中华人民共和国', '香港特别行政区', '中西区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2896, '中华人民共和国', '香港特别行政区', '东区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2897, '中华人民共和国', '香港特别行政区', '南区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2898, '中华人民共和国', '香港特别行政区', '湾仔区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2899, '中华人民共和国', '香港特别行政区', '九龙城区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2900, '中华人民共和国', '香港特别行政区', '观塘区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2901, '中华人民共和国', '香港特别行政区', '深水埗区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2902, '中华人民共和国', '香港特别行政区', '黄大仙区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2903, '中华人民共和国', '香港特别行政区', '油尖旺区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2904, '中华人民共和国', '香港特别行政区', '离岛区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2905, '中华人民共和国', '香港特别行政区', '葵青区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2906, '中华人民共和国', '香港特别行政区', '北区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2907, '中华人民共和国', '香港特别行政区', '西贡区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2908, '中华人民共和国', '香港特别行政区', '沙田区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2909, '中华人民共和国', '香港特别行政区', '大埔区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2910, '中华人民共和国', '香港特别行政区', '荃湾区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2911, '中华人民共和国', '香港特别行政区', '屯门区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2912, '中华人民共和国', '香港特别行政区', '元朗区', '', '999077', '00852');
INSERT INTO `phpcms_city` VALUES (2913, '中华人民共和国', '澳门特别行政区', '澳门市花地玛堂区', '', '999078', '00853');
INSERT INTO `phpcms_city` VALUES (2914, '中华人民共和国', '澳门特别行政区', '澳门市圣安多尼堂区', '', '999078', '00853');
INSERT INTO `phpcms_city` VALUES (2915, '中华人民共和国', '澳门特别行政区', '澳门市大堂区', '', '999078', '00853');
INSERT INTO `phpcms_city` VALUES (2916, '中华人民共和国', '澳门特别行政区', '澳门市望德堂区', '', '999078', '00853');
INSERT INTO `phpcms_city` VALUES (2917, '中华人民共和国', '澳门特别行政区', '澳门市风顺堂区', '', '999078', '00853');
INSERT INTO `phpcms_city` VALUES (2918, '中华人民共和国', '澳门特别行政区', '海岛市嘉模堂区', '', '999078', '00853');
INSERT INTO `phpcms_city` VALUES (2919, '中华人民共和国', '澳门特别行政区', '海岛市圣方济各堂区', '', '999078', '00853');

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_comment`
-- 

DROP TABLE IF EXISTS `phpcms_comment`;
CREATE TABLE IF NOT EXISTS `phpcms_comment` (
  `commentid` int(11) NOT NULL auto_increment,
  `item` varchar(20) NOT NULL default '0',
  `itemid` int(11) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `score` tinyint(1) NOT NULL default '0',
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`commentid`),
  KEY `module` (`item`,`itemid`,`username`,`passed`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_comment`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_copyfrom`
-- 

DROP TABLE IF EXISTS `phpcms_copyfrom`;
CREATE TABLE IF NOT EXISTS `phpcms_copyfrom` (
  `id` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `url` varchar(255) NOT NULL default '#',
  `hits` int(11) NOT NULL default '0',
  `updatetime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `channelid` (`channelid`,`updatetime`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_copyfrom`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_down`
-- 

DROP TABLE IF EXISTS `phpcms_down`;
CREATE TABLE IF NOT EXISTS `phpcms_down` (
  `downid` int(10) unsigned NOT NULL auto_increment,
  `channelid` int(10) unsigned NOT NULL default '0',
  `catid` int(10) unsigned NOT NULL default '0',
  `specialid` int(10) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `titlefontcolor` varchar(7) NOT NULL default '',
  `titlefonttype` tinyint(1) unsigned NOT NULL default '0',
  `includepic` tinyint(1) NOT NULL default '0',
  `keywords` varchar(100) NOT NULL default '',
  `author` varchar(50) NOT NULL default '',
  `copyfromname` varchar(100) NOT NULL default '',
  `copyfromurl` varchar(100) NOT NULL default '',
  `linkurl` varchar(200) NOT NULL default '',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `checker` varchar(30) NOT NULL default '',
  `checktime` int(10) unsigned NOT NULL default '0',
  `editor` varchar(30) NOT NULL default '',
  `edittime` int(10) unsigned NOT NULL default '0',
  `introduce` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `downurls` text NOT NULL,
  `skinid` varchar(20) NOT NULL default '',
  `templateid` varchar(20) NOT NULL default '0',
  `ontop` tinyint(1) unsigned NOT NULL default '0',
  `elite` tinyint(1) unsigned NOT NULL default '0',
  `recycle` tinyint(1) unsigned NOT NULL default '0',
  `stars` tinyint(1) unsigned NOT NULL default '0',
  `readpoint` int(10) unsigned NOT NULL default '0',
  `groupview` varchar(255) NOT NULL default '',
  `lastdowntime` int(11) NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  `downs` int(11) NOT NULL default '0',
  `daydowns` int(10) unsigned NOT NULL default '0',
  `weekdowns` int(10) unsigned NOT NULL default '0',
  `monthdowns` int(10) unsigned NOT NULL default '0',
  `version` varchar(255) NOT NULL default '',
  `system` varchar(255) NOT NULL default 'Win9x/NT/2000/XP/2003',
  `demourl` varchar(255) NOT NULL default '',
  `regurl` varchar(255) NOT NULL default '',
  `language` varchar(255) NOT NULL default '',
  `copytype` varchar(255) NOT NULL default '',
  `classtype` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`downid`),
  KEY `ontop` (`ontop`),
  KEY `hits` (`hits`),
  KEY `keywords` (`keywords`),
  KEY `title` (`title`),
  KEY `catid` (`catid`),
  KEY `specialid` (`specialid`),
  KEY `status` (`status`),
  KEY `elite` (`elite`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_down`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_exchange`
-- 

DROP TABLE IF EXISTS `phpcms_exchange`;
CREATE TABLE IF NOT EXISTS `phpcms_exchange` (
  `exchangeid` int(11) NOT NULL auto_increment,
  `type` varchar(20) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `point` int(11) NOT NULL default '0',
  `money` int(11) NOT NULL default '0',
  `credit` int(11) NOT NULL default '0',
  `day` int(11) NOT NULL default '0',
  `note` text NOT NULL,
  `inputer` varchar(30) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`exchangeid`),
  KEY `type` (`type`,`username`,`inputer`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_exchange`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_field`
-- 

DROP TABLE IF EXISTS `phpcms_field`;
CREATE TABLE IF NOT EXISTS `phpcms_field` (
  `fieldid` int(11) NOT NULL auto_increment,
  `module` varchar(20) NOT NULL default '',
  `channelid` int(11) NOT NULL default '0',
  `fieldname` varchar(50) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `note` text NOT NULL,
  `fieldtype` tinyint(1) NOT NULL default '0',
  `defaultvalue` text NOT NULL,
  `options` text NOT NULL,
  `enablenull` tinyint(1) NOT NULL default '0',
  `enablesearch` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`fieldid`),
  KEY `channelid` (`channelid`,`fieldname`),
  KEY `module` (`module`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_field`
-- 

INSERT INTO `phpcms_field` VALUES (7, '', 2, 'version', '版本号', '', 1, '1.0', '', 1, 0);
INSERT INTO `phpcms_field` VALUES (4, '', 2, 'copytype', '软件授权形式', ' 请选择<b>软件授权形式</b>', 3, '免费版', '免费版\r\n共享版\r\n试用版\r\n演示版\r\n注册版\r\n破解版\r\n零售版\r\nOEM版', 0, 0);
INSERT INTO `phpcms_field` VALUES (5, '', 2, 'language', '软件语言', '', 3, '简体中文', '英文\r\n简体中文\r\n繁体中文\r\n简繁中文\r\n多国语言\r\n其他语言', 0, 0);
INSERT INTO `phpcms_field` VALUES (6, '', 2, 'classtype', '软件类型', '', 3, '国产软件', '国产软件\r\n国外软件\r\n汉化补丁\r\n程序源码\r\n其他', 0, 0);
INSERT INTO `phpcms_field` VALUES (3, '', 2, 'system', '软件平台', '<br/><script language="javascript" type="text/javascript">\r\n<!--\r\nfunction ToSystem(addTitle)\r\n{\r\n    var str=document.getElementById("system").value;\r\n    var opsys=document.getElementById("system");\r\n    if (opsys.value=="")\r\n	{\r\n        opsys.value=opsys.value+addTitle;\r\n    }else\r\n	{\r\n        if (str.substr(str.length-1,1)=="/")\r\n		{\r\n            opsys.value=opsys.value+addTitle;\r\n        }else\r\n		{\r\n            opsys.value=opsys.value+"/"+addTitle;\r\n        }\r\n    }\r\n    opsys.focus();\r\n}\r\n// -->\r\n</script>\r\n点击添加 << <a href="javascript:ToSystem(''Win98'')">Win98/</a>/\r\n<a href="javascript:ToSystem(''NT'')">WinNT</a>/\r\n<a href="javascript:ToSystem(''2000'')">Win2000</a>/\r\n<a href="javascript:ToSystem(''XP'')">WinXP</a>/\r\n<a href="javascript:ToSystem(''2003'')">WinXP2003</a>/\r\n<a href="javascript:ToSystem(''Unix'')">Unix</a>/\r\n<a href="javascript:ToSystem(''Linux'')">Linux</a>/\r\n<a href="javascript:ToSystem(''MacOS'')">MacOS</a>', 1, 'Win2000/WinXP/Win2003', '', 0, 0);
INSERT INTO `phpcms_field` VALUES (2, '', 2, 'demourl', '软件演示地址', '', 1, '', '', 1, 0);
INSERT INTO `phpcms_field` VALUES (1, '', 2, 'regurl', '软件注册地址', '', 1, 'http://www.phpcms.cn', '', 1, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_finance`
-- 

DROP TABLE IF EXISTS `phpcms_finance`;
CREATE TABLE IF NOT EXISTS `phpcms_finance` (
  `financeid` int(11) NOT NULL auto_increment,
  `type` varchar(20) NOT NULL default '',
  `username` varchar(30) NOT NULL default '',
  `money` int(11) NOT NULL default '0',
  `bank` varchar(50) NOT NULL default '',
  `idcard` varchar(100) NOT NULL default '',
  `note` text NOT NULL,
  `inputer` varchar(30) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`financeid`),
  KEY `type` (`type`,`username`),
  KEY `admin` (`inputer`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_finance`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_friend`
-- 

DROP TABLE IF EXISTS `phpcms_friend`;
CREATE TABLE IF NOT EXISTS `phpcms_friend` (
  `username` varchar(20) NOT NULL default '0',
  `friendname` varchar(20) NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `orderid` tinyint(11) NOT NULL default '0',
  `type` tinyint(1) NOT NULL default '1',
  `description` varchar(255) NOT NULL default '',
  KEY `order` (`orderid`),
  KEY `username` (`username`),
  KEY `friendname` (`friendname`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_friend`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_guestbook`
-- 

DROP TABLE IF EXISTS `phpcms_guestbook`;
CREATE TABLE IF NOT EXISTS `phpcms_guestbook` (
  `gid` int(11) NOT NULL auto_increment,
  `channelid` tinyint(11) NOT NULL default '0',
  `title` varchar(200) NOT NULL default '',
  `content` text NOT NULL,
  `reply` text NOT NULL,
  `username` varchar(50) NOT NULL default '',
  `gender` tinyint(1) NOT NULL default '0',
  `head` tinyint(4) NOT NULL default '0',
  `email` varchar(100) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `homepage` varchar(100) NOT NULL default '',
  `hidden` tinyint(1) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `replyer` varchar(30) NOT NULL default '',
  `replytime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gid`),
  KEY `title` (`title`,`username`),
  FULLTEXT KEY `content` (`content`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_guestbook`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_keylink`
-- 

DROP TABLE IF EXISTS `phpcms_keylink`;
CREATE TABLE IF NOT EXISTS `phpcms_keylink` (
  `linkid` int(11) NOT NULL auto_increment,
  `linktext` varchar(255) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  `passed` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`linkid`),
  KEY `linktext` (`linktext`,`passed`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_keylink`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_keyword`
-- 

DROP TABLE IF EXISTS `phpcms_keyword`;
CREATE TABLE IF NOT EXISTS `phpcms_keyword` (
  `id` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `keyword` varchar(100) NOT NULL default '',
  `hits` int(11) NOT NULL default '0',
  `updatetime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `channelid` (`channelid`,`updatetime`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_keyword`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_link`
-- 

DROP TABLE IF EXISTS `phpcms_link`;
CREATE TABLE IF NOT EXISTS `phpcms_link` (
  `siteid` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `linktype` tinyint(1) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `logo` varchar(255) NOT NULL default '',
  `introduction` text NOT NULL,
  `username` varchar(30) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `orderid` int(11) NOT NULL default '0',
  `elite` tinyint(1) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  `addtime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`siteid`),
  KEY `linktype` (`elite`,`passed`),
  KEY `linktype_2` (`linktype`),
  KEY `orderid` (`orderid`),
  KEY `channelid` (`channelid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_link`
-- 

INSERT INTO `phpcms_link` VALUES (1, 0, 1, 'phpcms网站管理系统', 'http://www.phpcms.cn', 'http://www.phpcms.cn/images/friendsitelogo.gif', 'phpcms网站管理系统官方网站，提供最新的网站管理软件下载和技术支持。', 'phpcms', 'phpcms@163.com', '', 1, 0, 1, 1150314350);
INSERT INTO `phpcms_link` VALUES (2, 0, 1, '西部数码', 'http://www.west263.com', 'http://www.west999.com/photo/logo8831.gif', '中国十大主机商之一，提供虚拟主机。', 'phpcms', 'sales@west263.com', '', 2, 0, 1, 1150314350);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_log`
-- 

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

-- 
-- 导出表中的数据 `phpcms_log`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_member`
-- 

DROP TABLE IF EXISTS `phpcms_member`;
CREATE TABLE IF NOT EXISTS `phpcms_member` (
  `userid` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `question` varchar(50) NOT NULL default '',
  `answer` varchar(32) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `showemail` tinyint(1) NOT NULL default '0',
  `groupid` int(11) NOT NULL default '0',
  `isadmin` tinyint(1) NOT NULL default '0',
  `regip` varchar(15) NOT NULL default '',
  `regtime` int(11) NOT NULL default '0',
  `lastloginip` varchar(15) NOT NULL default '',
  `lastlogintime` int(11) NOT NULL default '0',
  `logintimes` int(11) NOT NULL default '0',
  `locked` tinyint(1) NOT NULL default '0',
  `chargetype` tinyint(1) NOT NULL default '0',
  `begindate` date NOT NULL default '0000-00-00',
  `enddate` date NOT NULL default '0000-00-00',
  `money` int(11) NOT NULL default '0',
  `payment` int(11) NOT NULL default '0',
  `point` int(11) NOT NULL default '0',
  `credit` int(11) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `additems` int(11) NOT NULL default '0',
  `note` text NOT NULL,
  `authstr` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`userid`),
  KEY `username` (`username`,`password`,`answer`,`email`),
  KEY `groupid` (`groupid`,`isadmin`,`locked`),
  KEY `additems` (`additems`),
  FULLTEXT KEY `note` (`note`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_member`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_memberinfo`
-- 

DROP TABLE IF EXISTS `phpcms_memberinfo`;
CREATE TABLE IF NOT EXISTS `phpcms_memberinfo` (
  `userid` int(11) NOT NULL default '0',
  `userface` varchar(255) NOT NULL default '',
  `facewidth` int(4) NOT NULL default '0',
  `faceheight` int(4) NOT NULL default '0',
  `sign` text NOT NULL,
  `truename` varchar(50) NOT NULL default '',
  `gender` tinyint(4) NOT NULL default '0',
  `birthday` date NOT NULL default '0000-00-00',
  `idtype` varchar(20) NOT NULL default '',
  `idcard` varchar(50) NOT NULL default '',
  `province` varchar(30) NOT NULL default '',
  `city` varchar(30) NOT NULL default '',
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
  PRIMARY KEY  (`userid`),
  KEY `gender` (`gender`,`province`,`city`,`industry`),
  KEY `edulevel` (`edulevel`,`occupation`,`income`,`postid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_memberinfo`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_module`
-- 

DROP TABLE IF EXISTS `phpcms_module`;
CREATE TABLE IF NOT EXISTS `phpcms_module` (
  `modid` int(11) NOT NULL auto_increment,
  `module` varchar(20) NOT NULL default '',
  `modulename` varchar(20) NOT NULL default '',
  `introduce` text NOT NULL,
  `enablecopy` tinyint(1) NOT NULL default '0',
  `isshare` tinyint(1) NOT NULL default '0',
  `author` varchar(50) NOT NULL default '',
  `authorsite` varchar(100) NOT NULL default '',
  `authoremail` varchar(100) NOT NULL default '',
  `updatetime` int(11) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`modid`),
  KEY `passed` (`passed`),
  KEY `module` (`module`),
  KEY `enablecopy` (`enablecopy`),
  KEY `isshare` (`isshare`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_module`
-- 

INSERT INTO `phpcms_module` VALUES (1, 'phpcms', 'phpcms', '', 0, 0, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 0, 1);
INSERT INTO `phpcms_module` VALUES (2, 'article', '文章', '', 1, 0, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1142877312, 1);
INSERT INTO `phpcms_module` VALUES (3, 'down', '下载', '', 1, 0, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1142877318, 1);
INSERT INTO `phpcms_module` VALUES (4, 'picture', '图片', '', 1, 0, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 0, 1);
INSERT INTO `phpcms_module` VALUES (5, 'ads', '广告', '', 0, 0, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1145265247, 1);
INSERT INTO `phpcms_module` VALUES (6, 'member', '会员', '', 0, 0, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 0, 1);
INSERT INTO `phpcms_module` VALUES (7, 'comment', '评论', '', 0, 1, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1144981235, 1);
INSERT INTO `phpcms_module` VALUES (8, 'mail', '邮件', '', 0, 0, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1144983311, 1);
INSERT INTO `phpcms_module` VALUES (9, 'guestbook', '留言本', '', 0, 1, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1147080790, 1);
INSERT INTO `phpcms_module` VALUES (10, 'announce', '公告', '', 0, 1, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1146303642, 1);
INSERT INTO `phpcms_module` VALUES (11, 'vote', '投票', '', 0, 1, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1146454314, 1);
INSERT INTO `phpcms_module` VALUES (12, 'link', '友情链接', '', 0, 1, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1147143022, 1);
INSERT INTO `phpcms_module` VALUES (13, 'page', '单网页', '', 0, 1, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1147176260, 1);
INSERT INTO `phpcms_module` VALUES (14, 'mypage', '自定义网页', '', 0, 1, 'phpcms团队', 'http://www.phpcms.cn', 'phpcms@163.com', 1148489379, 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_mypage`
-- 

DROP TABLE IF EXISTS `phpcms_mypage`;
CREATE TABLE IF NOT EXISTS `phpcms_mypage` (
  `mypageid` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `name` varchar(20) NOT NULL default '',
  `meta_title` varchar(255) NOT NULL default '',
  `meta_keywords` varchar(255) NOT NULL default '',
  `meta_description` varchar(255) NOT NULL default '',
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`mypageid`),
  UNIQUE KEY `name_2` (`name`),
  KEY `name` (`name`),
  KEY `channelid` (`channelid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_mypage`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_mytag`
-- 

DROP TABLE IF EXISTS `phpcms_mytag`;
CREATE TABLE IF NOT EXISTS `phpcms_mytag` (
  `tagid` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `tagname` varchar(50) NOT NULL default '',
  `content` text NOT NULL,
  `introduce` varchar(255) NOT NULL default '',
  `passed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`tagid`),
  UNIQUE KEY `tagname_2` (`tagname`),
  KEY `tagname` (`tagname`,`passed`),
  KEY `channelid` (`channelid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_mytag`
-- 

INSERT INTO `phpcms_mytag` VALUES (1, 0, 'tag', '最新文章：{$articlelist(0,1,0,1,0,0,10,30,0,0,0,1,2,0,0,0,1,1)}', '首页', 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_page`
-- 

DROP TABLE IF EXISTS `phpcms_page`;
CREATE TABLE IF NOT EXISTS `phpcms_page` (
  `pageid` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `linkurl` varchar(255) NOT NULL default '',
  `meta_title` varchar(255) NOT NULL default '',
  `meta_keywords` varchar(255) NOT NULL default '',
  `meta_description` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `filepath` varchar(100) NOT NULL default '',
  `skinid` varchar(20) NOT NULL default '',
  `templateid` varchar(20) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `orderid` int(11) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`pageid`),
  KEY `title` (`title`),
  KEY `passed` (`passed`),
  KEY `username` (`username`),
  KEY `orderid` (`orderid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_page`
-- 

INSERT INTO `phpcms_page` VALUES (1, 0, '关于我们', '', '关于我们', '关于我们', '关于我们', '<p>网站介绍内容...</p>', 'page/aboutus.html', '0', '0', '', 1150311752, 1, 1);
INSERT INTO `phpcms_page` VALUES (2, 0, '版权声明', '', '版权声明', '版权声明', '版权声明', '<font color="#000000">版权声明内容...</font>', 'page/announce.html', '0', '0', '', 1150312631, 2, 1);
INSERT INTO `phpcms_page` VALUES (3, 0, '联系我们', '', '联系我们', '联系我们', '联系我们', '<font color="#000000">联系我们内容...</font>', 'page/contactus.html', '0', '0', '', 1150312711, 4, 1);
INSERT INTO `phpcms_page` VALUES (4, 0, '诚聘英才', '', '诚聘英才', '诚聘英才', '诚聘英才', '招聘信息内容...', 'page/joinus.html', '0', '0', '', 1150312777, 5, 1);
INSERT INTO `phpcms_page` VALUES (5, 0, '友情链接', '/link/', '', '', '', '', '', '', '0', '', 1150312828, 6, 1);
INSERT INTO `phpcms_page` VALUES (6, 0, '网站公告', '/announce/?channelid=0', '', '', '', '', '', '', '0', '', 1150316643, 7, 1);
INSERT INTO `phpcms_page` VALUES (7, 0, '广告服务', '', '广告报价表', '广告报价表', '广告报价表', '<p>广告服务介绍</p>\r\n<p><font color="#ff0000" size="3"><a href="/ads/"><font color="#ff0000">广告位报价表》</font></a></font></p>', 'page/ads.html', '0', '0', '', 1150448950, 3, 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_paycard`
-- 

DROP TABLE IF EXISTS `phpcms_paycard`;
CREATE TABLE IF NOT EXISTS `phpcms_paycard` (
  `id` int(11) NOT NULL auto_increment,
  `cardidprefix` varchar(10) NOT NULL default '',
  `cardid` varchar(20) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `price` int(11) NOT NULL default '0',
  `inputer` varchar(30) NOT NULL default '',
  `adddate` date NOT NULL default '0000-00-00',
  `enddate` date NOT NULL default '0000-00-00',
  `username` varchar(30) NOT NULL default '',
  `regtime` int(11) NOT NULL default '0',
  `regip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `cardid` (`cardid`,`password`,`username`),
  KEY `cardidprefix` (`cardidprefix`),
  KEY `maker` (`inputer`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_paycard`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_picture`
-- 

DROP TABLE IF EXISTS `phpcms_picture`;
CREATE TABLE IF NOT EXISTS `phpcms_picture` (
  `pictureid` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `specialid` int(11) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `thumb` varchar(255) NOT NULL default '',
  `titlefontcolor` varchar(7) NOT NULL default '',
  `titlefonttype` tinyint(1) NOT NULL default '0',
  `includepic` tinyint(1) NOT NULL default '0',
  `author` varchar(50) NOT NULL default '',
  `copyfromname` varchar(100) NOT NULL default '',
  `copyfromurl` varchar(255) NOT NULL default '',
  `linkurl` varchar(200) NOT NULL default '',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `keywords` varchar(255) NOT NULL default '',
  `hits` bigint(20) NOT NULL default '0',
  `content` text NOT NULL,
  `pictureurls` text NOT NULL,
  `ontop` int(1) NOT NULL default '0',
  `elite` int(1) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  `editor` varchar(20) NOT NULL default '',
  `edittime` int(11) NOT NULL default '0',
  `checker` varchar(30) NOT NULL default '',
  `checktime` int(11) NOT NULL default '0',
  `recycle` int(1) NOT NULL default '0',
  `stars` int(1) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '',
  `templateid` varchar(20) NOT NULL default '0',
  `groupview` varchar(255) NOT NULL default '0',
  `readpoint` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pictureid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_picture`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_pm`
-- 

DROP TABLE IF EXISTS `phpcms_pm`;
CREATE TABLE IF NOT EXISTS `phpcms_pm` (
  `pmid` int(10) unsigned NOT NULL auto_increment,
  `fromusername` varchar(20) NOT NULL default '',
  `tousername` varchar(20) NOT NULL default '0',
  `posttime` int(10) unsigned NOT NULL default '0',
  `title` varchar(75) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `send` tinyint(1) NOT NULL default '1',
  `inbox` tinyint(1) NOT NULL default '0',
  `new` tinyint(1) NOT NULL default '1',
  `recycle` tinyint(1) NOT NULL default '0',
  `system` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`pmid`),
  KEY `fromusername` (`fromusername`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_pm`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_province`
-- 

DROP TABLE IF EXISTS `phpcms_province`;
CREATE TABLE IF NOT EXISTS `phpcms_province` (
  `provinceid` int(11) NOT NULL auto_increment,
  `province` varchar(20) NOT NULL default '',
  `country` varchar(50) NOT NULL default '',
  KEY `provinceid` (`provinceid`),
  KEY `country` (`country`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_province`
-- 

INSERT INTO `phpcms_province` VALUES (1, '北京市', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (2, '上海市', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (3, '天津市', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (4, '重庆市', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (5, '河北省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (6, '山西省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (7, '内蒙古自治区', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (8, '辽宁省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (9, '吉林省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (10, '黑龙江省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (11, '江苏省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (12, '浙江省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (13, '安徽省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (14, '福建省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (15, '江西省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (16, '山东省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (17, '河南省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (18, '湖北省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (19, '湖南省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (20, '广东省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (21, '广西壮族自治区', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (22, '海南省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (23, '四川省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (24, '贵州省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (25, '云南省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (26, '西藏自治区', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (27, '陕西省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (28, '甘肃省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (29, '青海省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (30, '宁夏回族自治区', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (31, '新疆维吾尔自治区', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (32, '台湾省', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (33, '香港特别行政区', '中华人民共和国');
INSERT INTO `phpcms_province` VALUES (34, '澳门特别行政区', '中华人民共和国');

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_reword`
-- 

DROP TABLE IF EXISTS `phpcms_reword`;
CREATE TABLE IF NOT EXISTS `phpcms_reword` (
  `rid` int(11) NOT NULL auto_increment,
  `word` varchar(255) NOT NULL default '',
  `replacement` varchar(255) NOT NULL default '',
  `passed` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`rid`),
  KEY `word` (`word`,`passed`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_reword`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_setting`
-- 

DROP TABLE IF EXISTS `phpcms_setting`;
CREATE TABLE IF NOT EXISTS `phpcms_setting` (
  `variable` varchar(50) NOT NULL default '',
  `value` text NOT NULL,
  `note` varchar(255) NOT NULL default '',
  `module` varchar(20) NOT NULL default '0',
  `channelid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`variable`),
  KEY `variable` (`variable`,`module`),
  KEY `channelid` (`channelid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_setting`
-- 

INSERT INTO `phpcms_setting` VALUES ('sitename', 'phpcms网站管理系统', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('meta_keywords', 'phpcms网站管理系统', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('siteurl', 'http://www.phpcms.cn', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('logo', 'images/logo.gif', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('meta_title', 'phpcms网站管理系统', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('webmasteremail', 'master@domain.com', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('copyright', 'phpcms网站管理系统', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('enablegzip', '0', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('maxpage', '100', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('searchtime', '10', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('maxsearchresults', '500', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('searchperpage', '10', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('meta_description', 'phpcms网站管理系统', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('enablethumb', '1', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('thumb_width', '150', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('thumb_height', '150', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('thumb_type', '1', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('water_type', '2', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('smtphost', 'smtp.163.com', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('smtpuser', '', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('smtppass', '', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('smtpport', '25', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('ftphost', '', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('ftpuser', '', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('ftppass', '', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('enableftp', '0', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('passport_url', 'http://bbs.phpcms.cn/api/passport.php', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('passport_key', '', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('enablepassport', '0', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('pagesize', '20', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('special_pagesize', '专题列表分页个数', '15', 'special', 0);
INSERT INTO `phpcms_setting` VALUES ('water_font', 'class/fonts/simhei.ttf', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('water_text', 'www.phpcms.cn', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('down_upload_filenum', '10', '一次最多上传的文件个数', 'down', 0);
INSERT INTO `phpcms_setting` VALUES ('pagenum', '10', '设置信息显示的条数', 'info', 4);
INSERT INTO `phpcms_setting` VALUES ('down_admin_pagesize', '20', '后台列表页面每页显示条数', 'down', 0);
INSERT INTO `phpcms_setting` VALUES ('water_fontsize', '18', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('water_fontcolor', '#ff0000', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('water_pos', '9', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('water_image', 'images/watermark.gif', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('money2time', '1', '1元资金兑换的天数', 'member', 0);
INSERT INTO `phpcms_setting` VALUES ('enablebanip', '0', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('enablecheckuser', '0', '用户注册是否需要审核<br>\r\n0表示不需要审核，1表示需要审核', 'member', 0);
INSERT INTO `phpcms_setting` VALUES ('money2point', '10', '1元资金兑换的点数', 'member', 0);
INSERT INTO `phpcms_setting` VALUES ('credit2time', '0.1', '一个积分兑换的天数', 'member', 0);
INSERT INTO `phpcms_setting` VALUES ('credit2point', '0.1', '1个积分兑换的点数', 'member', 0);
INSERT INTO `phpcms_setting` VALUES ('sendmailtype', 'smtp', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('searchcontent', '0', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('checkcodeguestbook', '1', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('checkcodecomment', '1', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('comment_checkuser', '0', '是否禁止游客发表评论', 'comment', 0);
INSERT INTO `phpcms_setting` VALUES ('comment_maxcontent', '2000', '评论内容最大字符数', 'comment', 0);
INSERT INTO `phpcms_setting` VALUES ('gbook_usehtml', '1', '留言是否启用html代码[已做安全过滤]', 'guestbook', 0);
INSERT INTO `phpcms_setting` VALUES ('gbook_checkuser', '0', '是否禁止游客留言', 'guestbook', 0);
INSERT INTO `phpcms_setting` VALUES ('gbook_checkpass', '0', '留言是否需要审核', 'guestbook', 0);
INSERT INTO `phpcms_setting` VALUES ('gbook_checkcode', '1', '留言是否启用验证码', 'guestbook', 0);
INSERT INTO `phpcms_setting` VALUES ('gbook_maxcontent', '2000', '留言内容最大字符数', 'guestbook', 0);
INSERT INTO `phpcms_setting` VALUES ('comment_checkpass', '0', '评论是否需要审核', 'comment', 0);
INSERT INTO `phpcms_setting` VALUES ('maxfailedtimes', '5', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('maxlockedtime', '1', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('ftpwebpath', '', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('adminaccessip', '', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('uploaddir', 'uploadfile', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('uploadfiletype', 'gif|jpg|jpeg|png|bmp|txt|zip|rar|doc', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('linklogo', 'images/linklogo.gif', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('version', '3.0.0', '', 'phpcms', 0);
INSERT INTO `phpcms_setting` VALUES ('comment_checkcode', '1', '评论是否启用验证码', 'comment', 0);
INSERT INTO `phpcms_setting` VALUES ('comment_mintime', '30', '连续两次评论的最小时间间隔（秒）', 'comment', 0);
INSERT INTO `phpcms_setting` VALUES ('enableadmincheckcode', '0', '', 'phpcms', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_skin`
-- 

DROP TABLE IF EXISTS `phpcms_skin`;
CREATE TABLE IF NOT EXISTS `phpcms_skin` (
  `skinid` int(11) NOT NULL auto_increment,
  `skinname` varchar(50) NOT NULL default '',
  `skin` varchar(20) NOT NULL default '',
  `isdefault` tinyint(1) NOT NULL default '0',
  `projectid` int(11) NOT NULL default '0',
  `updatetime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`skinid`),
  KEY `isdefault` (`isdefault`,`projectid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_skin`
-- 

INSERT INTO `phpcms_skin` VALUES (1, '默认风格', 'default', 1, 1, 1150247027);
INSERT INTO `phpcms_skin` VALUES (2, '图片风格', 'picture', 0, 1, 1150460109);
INSERT INTO `phpcms_skin` VALUES (3, '下载风格', 'down', 0, 1, 1150460135);
INSERT INTO `phpcms_skin` VALUES (4, '文章风格', 'article', 0, 1, 1150459803);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_special`
-- 

DROP TABLE IF EXISTS `phpcms_special`;
CREATE TABLE IF NOT EXISTS `phpcms_special` (
  `specialid` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `specialname` varchar(100) NOT NULL default '',
  `specialpic` varchar(255) NOT NULL default '',
  `specialbanner` varchar(255) NOT NULL default '',
  `specialdir` varchar(50) NOT NULL default '',
  `introduce` text NOT NULL,
  `meta_keywords` varchar(255) NOT NULL default '',
  `meta_description` text NOT NULL,
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '',
  `hits` int(11) NOT NULL default '0',
  `elite` tinyint(1) NOT NULL default '0',
  `addtime` int(11) NOT NULL default '0',
  `closed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`specialid`),
  KEY `channelid` (`channelid`,`elite`),
  KEY `closed` (`closed`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_special`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_tag`
-- 

DROP TABLE IF EXISTS `phpcms_tag`;
CREATE TABLE IF NOT EXISTS `phpcms_tag` (
  `tagid` int(11) NOT NULL auto_increment,
  `tag` varchar(30) NOT NULL default '',
  `module` varchar(20) NOT NULL default '',
  `channelid` int(11) NOT NULL default '0',
  `func` varchar(30) NOT NULL default '',
  `tagname` varchar(50) NOT NULL default '',
  `parameters` text NOT NULL,
  `tagcode` text NOT NULL,
  `username` varchar(30) NOT NULL default '',
  `edittime` int(11) NOT NULL default '0',
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`tagid`),
  UNIQUE KEY `tag` (`tag`),
  KEY `module` (`module`),
  KEY `channelid` (`channelid`),
  KEY `username` (`username`),
  KEY `func` (`func`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_tag`
-- 

INSERT INTO `phpcms_tag` VALUES (18, 'article_new', 'article', 1, 'articlelist', '首页最新文章列表', 'array (\n  ''channelid'' => ''1'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''articlenum'' => ''10'',\n  ''titlelen'' => ''46'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''2'',\n  ''showcatname'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''showhits'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'articlelist(0,1,0,1,0,0,10,46,0,0,0,1,2,0,0,0,1,1)', 'phpcms', 1151119287, 0);
INSERT INTO `phpcms_tag` VALUES (23, 'hotDown', 'down', 2, 'downlist', '首页热点下载列表', 'array (\n  ''channelid'' => ''2'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''downnum'' => ''10'',\n  ''titlelen'' => ''40'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''5'',\n  ''datetype'' => ''0'',\n  ''showcatname'' => ''1'',\n  ''showauthor'' => ''0'',\n  ''showdowns'' => ''0'',\n  ''showsize'' => ''0'',\n  ''showstars'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'downlist(0,2,0,1,0,0,10,40,0,0,0,5,0,1,0,0,0,0,1,1)', 'phpcms', 1150424565, 0);
INSERT INTO `phpcms_tag` VALUES (79, 'my_link', 'link', 0, 'linklist', '友情链接', 'array (\n  ''channelid'' => ''$channelid'',\n  ''linktype'' => ''0'',\n  ''page'' => ''0'',\n  ''sitenum'' => ''10'',\n  ''cols'' => ''2'',\n  ''templateid'' => ''0'',\n)', 'linklist(0,$channelid,0,0,10,2)', 'phpcms', 1151366556, 0);
INSERT INTO `phpcms_tag` VALUES (25, 'announceIndex', 'announce', 0, 'announcelist', '首页公告调用列表', 'array (\n  ''page'' => ''0'',\n  ''announcenum'' => ''5'',\n  ''titlelen'' => ''30'',\n  ''datetype'' => ''2'',\n  ''showauthor'' => ''0'',\n  ''target'' => ''1'',\n  ''width'' => ''250'',\n  ''height'' => ''100'',\n  ''templateid'' => ''0'',\n)', 'announcelist(0,0,0,5,30,2,0,1,250,100)', 'phpcms', 1150457664, 0);
INSERT INTO `phpcms_tag` VALUES (20, 'pic_new', 'picture', 3, 'picturelist', '首页最新图片调用', 'array (\n  ''channelid'' => ''3'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''picturenum'' => ''12'',\n  ''titlelen'' => ''50'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''2'',\n  ''showcatname'' => ''1'',\n  ''showauthor'' => ''0'',\n  ''showhits'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'picturelist(0,3,0,1,0,0,12,50,0,0,0,1,2,1,0,0,1,1)', 'phpcms', 1150424590, 0);
INSERT INTO `phpcms_tag` VALUES (22, 'down_new', 'down', 2, 'downlist', '首页最新下载列表', 'array (\n  ''channelid'' => ''2'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''downnum'' => ''10'',\n  ''titlelen'' => ''40'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''0'',\n  ''showcatname'' => ''1'',\n  ''showauthor'' => ''0'',\n  ''showdowns'' => ''0'',\n  ''showsize'' => ''0'',\n  ''showstars'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'downlist(0,2,0,1,0,0,10,40,0,0,0,1,0,1,0,0,0,0,1,1)', 'phpcms', 1150424550, 0);
INSERT INTO `phpcms_tag` VALUES (31, 'column', 'article', 1, 'articlelist', '自定义栏目文章列表', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''$catid'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''articlenum'' => ''10'',\n  ''titlelen'' => ''36'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''2'',\n  ''showcatname'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''showhits'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'articlelist(0,$channelid,$catid,1,0,0,10,36,0,0,0,1,2,0,0,0,1,1)', 'phpcms', 1150427398, 0);
INSERT INTO `phpcms_tag` VALUES (30, 'picArticle', 'article', 1, 'picarticle', '栏目首页 图片文章列表', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''$catid'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''articlenum'' => ''5'',\n  ''titlelen'' => ''16'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''1'',\n  ''imgwidth'' => ''128'',\n  ''imgheight'' => ''96'',\n  ''cols'' => ''5'',\n  ''templateid'' => ''0'',\n)', 'picarticle(0,$channelid,$catid,1,0,0,5,16,0,0,0,1,1,1,128,96,5)', 'phpcms', 1150428651, 0);
INSERT INTO `phpcms_tag` VALUES (14, 'special', 'phpcms', 1, 'speciallist', '首页推荐专题', 'array (\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''specialnum'' => ''1'',\n  ''specialnamelen'' => ''50'',\n  ''descriptionlen'' => ''100'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''showtype'' => ''4'',\n  ''imgwidth'' => ''100'',\n  ''imgheight'' => ''100'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'speciallist(0,1,0,0,1,50,100,1,0,4,100,100,1)', 'phpcms', 1150396141, 0);
INSERT INTO `phpcms_tag` VALUES (17, 'index', 'article', 1, 'slidepicarticle', '首页幻灯片', 'array (\n  ''channelid'' => ''1'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''articlenum'' => ''10'',\n  ''titlelen'' => ''30'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''imgwidth'' => ''250'',\n  ''imgheight'' => ''180'',\n  ''timeout'' => ''5000'',\n  ''effectid'' => ''-1'',\n  ''templateid'' => ''0'',\n)', 'slidepicarticle(0,1,0,1,0,10,30,1,0,1,250,180,5000,-1)', 'phpcms', 1151043858, 0);
INSERT INTO `phpcms_tag` VALUES (21, 'hotPic', 'picture', 3, 'picpicture', '首页热点图片列表', 'array (\n  ''channelid'' => ''3'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''picturenum'' => ''6'',\n  ''titlelen'' => ''14'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''0'',\n  ''imgwidth'' => ''110'',\n  ''imgheight'' => ''100'',\n  ''cols'' => ''3'',\n  ''templateid'' => ''0'',\n)', 'picpicture(0,3,0,1,0,0,6,14,0,0,0,1,1,0,110,100,3)', 'phpcms', 1150424632, 0);
INSERT INTO `phpcms_tag` VALUES (32, 'picNew', 'article', 1, 'picarticle', '最新图片文章', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''$catid'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''articlenum'' => ''5'',\n  ''titlelen'' => ''16'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''1'',\n  ''imgwidth'' => ''120'',\n  ''imgheight'' => ''90'',\n  ''cols'' => ''5'',\n  ''templateid'' => ''0'',\n)', 'picarticle(0,$channelid,$catid,1,0,0,5,16,0,0,0,1,1,1,120,90,5)', 'phpcms', 1150428047, 0);
INSERT INTO `phpcms_tag` VALUES (33, 'columnlist', 'article', 1, 'picarticle', '栏目文章列表', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''$catid'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''articlenum'' => ''10'',\n  ''titlelen'' => ''60'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''0'',\n  ''imgwidth'' => ''0'',\n  ''imgheight'' => ''0'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'picarticle(0,$channelid,$catid,1,0,0,10,60,0,0,0,1,1,0,0,0,1)', 'phpcms', 1150428374, 0);
INSERT INTO `phpcms_tag` VALUES (34, 'dream', 'article', 1, 'slidepicarticle', '幻灯片标签', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''articlenum'' => ''5'',\n  ''titlelen'' => ''30'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''imgwidth'' => ''250'',\n  ''imgheight'' => ''180'',\n  ''timeout'' => ''5000'',\n  ''effectid'' => ''-1'',\n  ''templateid'' => ''0'',\n)', 'slidepicarticle(0,$channelid,0,1,0,5,30,0,0,1,250,180,5000,-1)', 'phpcms', 1150428919, 0);
INSERT INTO `phpcms_tag` VALUES (35, 'onlite', 'article', 1, 'articlelist', '推荐文章列表', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''articlenum'' => ''10'',\n  ''titlelen'' => ''50'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''2'',\n  ''showcatname'' => ''1'',\n  ''showauthor'' => ''0'',\n  ''showhits'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'articlelist(0,$channelid,0,1,0,0,10,50,0,1,0,1,2,1,0,0,1,1)', 'phpcms', 1150429377, 0);
INSERT INTO `phpcms_tag` VALUES (36, 'new_announce', 'announce', 1, 'announcelist', '最新公告列表', 'array (\n  ''channelid'' => ''$channelid'',\n  ''page'' => ''0'',\n  ''announcenum'' => ''5'',\n  ''titlelen'' => ''30'',\n  ''datetype'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''target'' => ''1'',\n  ''width'' => ''200'',\n  ''height'' => ''100'',\n  ''templateid'' => ''0'',\n)', 'announcelist(0,$channelid,0,5,30,0,0,1,200,100)', 'phpcms', 1151366335, 0);
INSERT INTO `phpcms_tag` VALUES (38, 'picArticleNemo', 'article', 1, 'picarticle', '频道首页图片文章', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''articlenum'' => ''5'',\n  ''titlelen'' => ''22'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''1'',\n  ''imgwidth'' => ''134'',\n  ''imgheight'' => ''96'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'picarticle(0,$channelid,0,1,0,0,5,22,0,0,0,1,1,1,134,96,1)', 'phpcms', 1150429920, 0);
INSERT INTO `phpcms_tag` VALUES (39, 'specialNew', 'phpcms', 1, 'speciallist', '最新专题列表', 'array (\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''specialnum'' => ''1'',\n  ''specialnamelen'' => ''28'',\n  ''descriptionlen'' => ''50'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''showtype'' => ''4'',\n  ''imgwidth'' => ''100'',\n  ''imgheight'' => ''100'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'speciallist(0,1,0,0,1,28,50,0,0,4,100,100,1)', 'phpcms', 1150430254, 0);
INSERT INTO `phpcms_tag` VALUES (40, 'onliteSpecial', 'phpcms', 1, 'slidespecial', '推荐专题幻灯片显示', 'array (\n  ''specialid'' => ''0'',\n  ''specialnum'' => ''3'',\n  ''specialnamelen'' => ''24'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''imgwidth'' => ''180'',\n  ''imgheight'' => ''120'',\n  ''timeout'' => ''5000'',\n  ''effectid'' => ''-1'',\n  ''templateid'' => ''0'',\n)', 'slidespecial(0,1,0,3,24,0,0,180,120,5000,-1)', 'phpcms', 1150431591, 0);
INSERT INTO `phpcms_tag` VALUES (41, 'specialElite_index', 'article', 1, 'articlelist', '专题首页推荐文章列表', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''articlenum'' => ''10'',\n  ''titlelen'' => ''28'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''0'',\n  ''showcatname'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''showhits'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'articlelist(0,$channelid,0,1,0,0,10,28,0,1,0,1,0,0,0,0,1,1)', 'phpcms', 1150431920, 0);
INSERT INTO `phpcms_tag` VALUES (42, 'speciallistNemo', 'phpcms', 1, 'speciallist', '专题列表', 'array (\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''specialnum'' => ''20'',\n  ''specialnamelen'' => ''50'',\n  ''descriptionlen'' => ''100'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''showtype'' => ''3'',\n  ''imgwidth'' => ''120'',\n  ''imgheight'' => ''90'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'speciallist(0,1,0,0,20,50,100,0,0,3,120,90,1)', 'phpcms', 1150432102, 0);
INSERT INTO `phpcms_tag` VALUES (43, 'specialMovie', 'phpcms', 1, 'slidespecial', '专题列表推荐幻灯片', 'array (\n  ''specialid'' => ''0'',\n  ''specialnum'' => ''4'',\n  ''specialnamelen'' => ''50'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''imgwidth'' => ''180'',\n  ''imgheight'' => ''120'',\n  ''timeout'' => ''5000'',\n  ''effectid'' => ''-1'',\n  ''templateid'' => ''0'',\n)', 'slidespecial(0,1,0,4,50,0,0,180,120,5000,-1)', 'phpcms', 1150436944, 0);
INSERT INTO `phpcms_tag` VALUES (44, 'mySpecialArticel', 'article', 1, 'picarticle', '本专题图片文章', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''$specialid'',\n  ''page'' => ''0'',\n  ''articlenum'' => ''5'',\n  ''titlelen'' => ''20'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''1'',\n  ''imgwidth'' => ''120'',\n  ''imgheight'' => ''90'',\n  ''cols'' => ''5'',\n  ''templateid'' => ''0'',\n)', 'picarticle(0,$channelid,0,1,$specialid,0,5,20,0,0,0,1,1,1,120,90,5)', 'phpcms', 1150437490, 0);
INSERT INTO `phpcms_tag` VALUES (45, 'downTop', 'phpcms', 2, 'catlist', '下载排行', 'array (\n  ''catid'' => ''0'',\n  ''showtype'' => ''2'',\n  ''templateid'' => ''0'',\n)', 'catlist(0,2,0,0,2,0)', 'phpcms', 1150437949, 0);
INSERT INTO `phpcms_tag` VALUES (46, 'downColumn', 'down', 2, 'downlist', '栏目首页文章调用', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''$catid'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''downnum'' => ''10'',\n  ''titlelen'' => ''36'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''2'',\n  ''showcatname'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''showdowns'' => ''0'',\n  ''showsize'' => ''0'',\n  ''showstars'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'downlist(0,$channelid,$catid,1,0,0,10,36,0,0,0,1,2,0,0,0,0,0,1,1)', 'phpcms', 1150438413, 0);
INSERT INTO `phpcms_tag` VALUES (47, 'downlist', 'down', 2, 'downlist', '下载列表', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''$catid'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''downnum'' => ''10'',\n  ''titlelen'' => ''56'',\n  ''descriptionlen'' => ''240'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''5'',\n  ''datetype'' => ''0'',\n  ''showcatname'' => ''0'',\n  ''showauthor'' => ''1'',\n  ''showdowns'' => ''1'',\n  ''showsize'' => ''1'',\n  ''showstars'' => ''1'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''46'',\n)', 'downlist(46,$channelid,$catid,1,0,0,10,56,240,0,0,5,0,0,1,1,1,1,1,1)', 'phpcms', 1150438690, 0);
INSERT INTO `phpcms_tag` VALUES (48, 'downIndexDream', 'down', 2, 'slidepicdown', '频道首页幻灯片', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''downnum'' => ''5'',\n  ''titlelen'' => ''36'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''imgwidth'' => ''250'',\n  ''imgheight'' => ''180'',\n  ''timeout'' => ''5000'',\n  ''effectid'' => ''-1'',\n  ''templateid'' => ''0'',\n)', 'slidepicdown(0,$channelid,0,1,0,5,36,0,0,1,250,180,5000,-1)', 'phpcms', 1150439025, 0);
INSERT INTO `phpcms_tag` VALUES (50, 'downNew', 'down', 2, 'downlist', '频道首页更新下载', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''downnum'' => ''10'',\n  ''titlelen'' => ''50'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''5'',\n  ''datetype'' => ''2'',\n  ''showcatname'' => ''1'',\n  ''showauthor'' => ''0'',\n  ''showdowns'' => ''0'',\n  ''showsize'' => ''0'',\n  ''showstars'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'downlist(0,$channelid,0,1,0,0,10,50,0,0,0,5,2,1,0,0,0,0,1,1)', 'phpcms', 1150439870, 0);
INSERT INTO `phpcms_tag` VALUES (51, 'downElite', 'down', 2, 'downlist', '频道首页推荐下载', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''downnum'' => ''10'',\n  ''titlelen'' => ''24'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''0'',\n  ''showcatname'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''showdowns'' => ''0'',\n  ''showsize'' => ''0'',\n  ''showstars'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'downlist(0,$channelid,0,1,0,0,10,24,0,0,0,1,0,0,0,0,0,0,1,1)', 'phpcms', 1150439994, 0);
INSERT INTO `phpcms_tag` VALUES (52, 'downNum', 'down', 2, 'downlist', '下载排行', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''downnum'' => ''15'',\n  ''titlelen'' => ''22'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''5'',\n  ''datetype'' => ''0'',\n  ''showcatname'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''showdowns'' => ''0'',\n  ''showsize'' => ''0'',\n  ''showstars'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'downlist(0,$channelid,0,1,0,0,15,22,0,0,0,5,0,0,0,0,0,0,1,1)', 'phpcms', 1150440144, 0);
INSERT INTO `phpcms_tag` VALUES (53, 'downSpecial', 'phpcms', 2, 'speciallist', '最新专题列表标签', 'array (\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''specialnum'' => ''1'',\n  ''specialnamelen'' => ''28'',\n  ''descriptionlen'' => ''50'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''showtype'' => ''4'',\n  ''imgwidth'' => ''100'',\n  ''imgheight'' => ''100'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'speciallist(0,2,0,0,1,28,50,0,0,4,100,100,1)', 'phpcms', 1150440382, 0);
INSERT INTO `phpcms_tag` VALUES (54, 'downAnnounceNew', 'announce', 2, 'announcelist', '最新公告列表标签', 'array (\n  ''page'' => ''0'',\n  ''announcenum'' => ''5'',\n  ''titlelen'' => ''30'',\n  ''datetype'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''target'' => ''1'',\n  ''width'' => ''200'',\n  ''height'' => ''100'',\n  ''templateid'' => ''0'',\n)', 'announcelist(0,2,0,5,30,0,0,1,200,100)', 'phpcms', 1150440504, 0);
INSERT INTO `phpcms_tag` VALUES (55, 'downLinkImg', 'link', 2, 'linklist', '图片连接', 'array (\n  ''linktype'' => ''1'',\n  ''showpage'' => ''0'',\n  ''sitenum'' => ''10'',\n  ''cols'' => ''2'',\n  ''templateid'' => ''0'',\n)', 'linklist(0,2,1,,10,2)', 'phpcms', 1150440555, 0);
INSERT INTO `phpcms_tag` VALUES (56, 'downEliteDream', 'phpcms', 2, 'slidespecial', '推荐专题幻灯片', 'array (\n  ''specialid'' => ''0'',\n  ''specialnum'' => ''3'',\n  ''specialnamelen'' => ''30'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''imgwidth'' => ''180'',\n  ''imgheight'' => ''120'',\n  ''timeout'' => ''5000'',\n  ''effectid'' => ''-1'',\n  ''templateid'' => ''0'',\n)', 'slidespecial(0,2,0,3,30,1,0,180,120,5000,-1)', 'phpcms', 1150440723, 0);
INSERT INTO `phpcms_tag` VALUES (57, 'downSpecialElite', 'down', 2, 'downlist', '专题首页推荐下载', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''downnum'' => ''10'',\n  ''titlelen'' => ''28'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''0'',\n  ''showcatname'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''showdowns'' => ''0'',\n  ''showsize'' => ''0'',\n  ''showstars'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'downlist(0,$channelid,0,1,0,0,10,28,0,1,0,1,0,0,0,0,0,0,1,1)', 'phpcms', 1150440923, 0);
INSERT INTO `phpcms_tag` VALUES (58, 'downSpecialIndex', 'phpcms', 2, 'speciallist', '专题首页 专题列表', 'array (\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''specialnum'' => ''1'',\n  ''specialnamelen'' => ''20'',\n  ''descriptionlen'' => ''50'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''showtype'' => ''3'',\n  ''imgwidth'' => ''120'',\n  ''imgheight'' => ''90'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'speciallist(0,2,0,0,1,20,50,0,0,3,120,90,1)', 'phpcms', 1150441035, 0);
INSERT INTO `phpcms_tag` VALUES (59, 'downSpecialElite_1', 'down', 2, 'downlist', '专题列表页推荐下载', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''downnum'' => ''10'',\n  ''titlelen'' => ''28'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''0'',\n  ''showcatname'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''showdowns'' => ''0'',\n  ''showsize'' => ''0'',\n  ''showstars'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'downlist(0,$channelid,0,1,0,0,10,28,0,1,0,1,0,0,0,0,0,0,1,1)', 'phpcms', 1150441308, 0);
INSERT INTO `phpcms_tag` VALUES (60, 'downPageElite', 'down', 2, 'downlist', '专题页推荐下载', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''$specialid'',\n  ''page'' => ''0'',\n  ''downnum'' => ''10'',\n  ''titlelen'' => ''30'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''datetype'' => ''0'',\n  ''showcatname'' => ''0'',\n  ''showauthor'' => ''0'',\n  ''showdowns'' => ''0'',\n  ''showsize'' => ''0'',\n  ''showstars'' => ''0'',\n  ''target'' => ''1'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'downlist(0,$channelid,0,1,$specialid,0,10,30,0,1,0,1,0,0,0,0,0,0,1,1)', 'phpcms', 1150441495, 0);
INSERT INTO `phpcms_tag` VALUES (61, 'downPic', 'down', 2, 'picdown', '本专题图片下载', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''$specialid'',\n  ''page'' => ''0'',\n  ''downnum'' => ''5'',\n  ''titlelen'' => ''20'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''0'',\n  ''imgwidth'' => ''120'',\n  ''imgheight'' => ''90'',\n  ''cols'' => ''5'',\n  ''templateid'' => ''0'',\n)', 'picdown(0,$channelid,0,1,$specialid,0,5,20,0,0,0,1,1,0,120,90,5)', 'phpcms', 1150446060, 0);
INSERT INTO `phpcms_tag` VALUES (62, 'picIndexArticle', 'picture', 3, 'picpicture', '栏目首页图片文章列表', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''$catid'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''picturenum'' => ''5'',\n  ''titlelen'' => ''10'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''1'',\n  ''imgwidth'' => ''128'',\n  ''imgheight'' => ''96'',\n  ''cols'' => ''5'',\n  ''templateid'' => ''0'',\n)', 'picpicture(0,$channelid,$catid,1,0,0,5,10,0,0,0,1,1,1,128,96,5)', 'phpcms', 1150446333, 0);
INSERT INTO `phpcms_tag` VALUES (63, 'picIndexHotDream', 'picture', 3, 'slidepicpicture', '频道首页 热门图片幻灯片', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''picturenum'' => ''5'',\n  ''titlelen'' => ''36'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''30'',\n  ''ordertype'' => ''5'',\n  ''imgwidth'' => ''240'',\n  ''imgheight'' => ''200'',\n  ''timeout'' => ''5000'',\n  ''effectid'' => ''-1'',\n  ''templateid'' => ''0'',\n)', 'slidepicpicture(0,$channelid,0,1,0,5,36,0,30,5,240,200,5000,-1)', 'phpcms', 1150446839, 0);
INSERT INTO `phpcms_tag` VALUES (64, 'picIndexElitePic', 'picture', 3, 'picpicture', '频道首页推荐图片', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''picturenum'' => ''6'',\n  ''titlelen'' => ''34'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''3'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''0'',\n  ''imgwidth'' => ''140'',\n  ''imgheight'' => ''100'',\n  ''cols'' => ''3'',\n  ''templateid'' => ''0'',\n)', 'picpicture(0,$channelid,0,1,0,0,6,34,0,1,0,3,1,0,140,100,3)', 'phpcms', 1150446987, 0);
INSERT INTO `phpcms_tag` VALUES (65, 'picIndexSpecialPic', 'phpcms', 3, 'speciallist', '频道首页专题图片', 'array (\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''specialnum'' => ''1'',\n  ''specialnamelen'' => ''20'',\n  ''descriptionlen'' => ''200'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''showtype'' => ''5'',\n  ''imgwidth'' => ''100'',\n  ''imgheight'' => ''100'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'speciallist(0,3,0,0,1,20,200,0,0,5,100,100,1)', 'phpcms', 1150447183, 0);
INSERT INTO `phpcms_tag` VALUES (66, 'picIndexAnnounce', 'announce', 3, 'announcelist', '频道首页最新公告标签', 'array (\n  ''page'' => ''0'',\n  ''announcenum'' => ''5'',\n  ''titlelen'' => ''50'',\n  ''datetype'' => ''2'',\n  ''showauthor'' => ''0'',\n  ''target'' => ''1'',\n  ''width'' => ''180'',\n  ''height'' => ''100'',\n  ''templateid'' => ''0'',\n)', 'announcelist(0,3,0,5,50,2,0,1,180,100)', 'phpcms', 1150447398, 0);
INSERT INTO `phpcms_tag` VALUES (68, 'picSpecailElitePic', 'phpcms', 3, 'slidespecial', '专题首页推荐幻灯片', 'array (\n  ''specialid'' => ''0'',\n  ''specialnum'' => ''3'',\n  ''specialnamelen'' => ''30'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''imgwidth'' => ''180'',\n  ''imgheight'' => ''150'',\n  ''timeout'' => ''5000'',\n  ''effectid'' => ''-1'',\n  ''templateid'' => ''0'',\n)', 'slidespecial(0,3,0,3,30,1,0,180,150,5000,-1)', 'phpcms', 1150448176, 0);
INSERT INTO `phpcms_tag` VALUES (69, 'picSpecialElite', 'picture', 3, 'picpicture', '专题首页推荐图片', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''picturenum'' => ''10'',\n  ''titlelen'' => ''30'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''0'',\n  ''imgwidth'' => ''150'',\n  ''imgheight'' => ''150'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'picpicture(0,$channelid,0,1,0,0,10,30,0,1,0,1,1,0,150,150,1)', 'phpcms', 1150448287, 0);
INSERT INTO `phpcms_tag` VALUES (70, 'picSpecialIndex', 'phpcms', 3, 'speciallist', '专题首页专题列表', 'array (\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''specialnum'' => ''10'',\n  ''specialnamelen'' => ''50'',\n  ''descriptionlen'' => ''100'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''showtype'' => ''1'',\n  ''imgwidth'' => ''120'',\n  ''imgheight'' => ''90'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'speciallist(0,3,0,0,10,50,100,0,0,1,120,90,1)', 'phpcms', 1150448996, 0);
INSERT INTO `phpcms_tag` VALUES (71, 'picSpecialPage', 'picture', 3, 'picpicture', '专题列表页推荐图片', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''picturenum'' => ''5'',\n  ''titlelen'' => ''28'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''0'',\n  ''imgwidth'' => ''150'',\n  ''imgheight'' => ''150'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'picpicture(0,$channelid,0,1,0,0,5,28,0,1,0,1,1,0,150,150,1)', 'phpcms', 1150449248, 0);
INSERT INTO `phpcms_tag` VALUES (72, 'picSpecailEliteDream', 'phpcms', 3, 'slidespecial', '专题页推荐幻灯片', 'array (\n  ''specialid'' => ''0'',\n  ''specialnum'' => ''3'',\n  ''specialnamelen'' => ''50'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''imgwidth'' => ''180'',\n  ''imgheight'' => ''150'',\n  ''timeout'' => ''5000'',\n  ''effectid'' => ''-1'',\n  ''templateid'' => ''0'',\n)', 'slidespecial(0,3,0,3,50,0,0,180,150,5000,-1)', 'phpcms', 1150449563, 0);
INSERT INTO `phpcms_tag` VALUES (73, 'picSpecialElitePage', 'picture', 3, 'picpicture', '专题页推荐图片', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''$specialid'',\n  ''page'' => ''0'',\n  ''picturenum'' => ''5'',\n  ''titlelen'' => ''28'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''0'',\n  ''imgwidth'' => ''150'',\n  ''imgheight'' => ''150'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'picpicture(0,$channelid,0,1,$specialid,0,5,28,0,1,0,1,1,0,150,150,1)', 'phpcms', 1150450059, 0);
INSERT INTO `phpcms_tag` VALUES (74, 'pic_special', 'picture', 3, 'picpicture', '专题页图片文章', 'array (\n  ''channelid'' => ''$channelid'',\n  ''catid'' => ''0'',\n  ''child'' => ''1'',\n  ''specialid'' => ''$specialid'',\n  ''page'' => ''0'',\n  ''picturenum'' => ''50'',\n  ''titlelen'' => ''20'',\n  ''descriptionlen'' => ''0'',\n  ''iselite'' => ''0'',\n  ''datenum'' => ''0'',\n  ''ordertype'' => ''1'',\n  ''showtype'' => ''1'',\n  ''showalt'' => ''1'',\n  ''imgwidth'' => ''120'',\n  ''imgheight'' => ''90'',\n  ''cols'' => ''5'',\n  ''templateid'' => ''0'',\n)', 'picpicture(0,$channelid,0,1,$specialid,0,50,20,0,0,0,1,1,1,120,90,5)', 'phpcms', 1150450270, 0);
INSERT INTO `phpcms_tag` VALUES (76, 'indexSpecialElite', 'phpcms', 1, 'speciallist', '首页推荐专题', 'array (\n  ''specialid'' => ''0'',\n  ''page'' => ''0'',\n  ''specialnum'' => ''1'',\n  ''specialnamelen'' => ''50'',\n  ''descriptionlen'' => ''100'',\n  ''iselite'' => ''1'',\n  ''datenum'' => ''0'',\n  ''showtype'' => ''4'',\n  ''imgwidth'' => ''100'',\n  ''imgheight'' => ''100'',\n  ''cols'' => ''1'',\n  ''templateid'' => ''0'',\n)', 'speciallist(0,1,0,0,1,50,100,1,0,4,100,100,1)', 'phpcms', 1150451037, 0);
INSERT INTO `phpcms_tag` VALUES (77, 'announceIndexList', 'announce', 0, 'announcelist', '公告首页调用列表', 'array (\n  ''page'' => ''1'',\n  ''announcenum'' => ''10'',\n  ''titlelen'' => ''100'',\n  ''datetype'' => ''1'',\n  ''showauthor'' => ''0'',\n  ''target'' => ''1'',\n  ''width'' => ''300'',\n  ''height'' => ''150'',\n  ''templateid'' => ''13'',\n)', 'announcelist(13,0,1,10,100,1,0,1,300,150)', 'phpcms', 1150457997, 0);
INSERT INTO `phpcms_tag` VALUES (78, 'sdfsd', 'announce', 0, 'announcelist', 'sdfsdfsdf', 'array (\n  ''page'' => ''1'',\n  ''announcenum'' => ''10'',\n  ''titlelen'' => ''50'',\n  ''datetype'' => ''1'',\n  ''showauthor'' => ''0'',\n  ''target'' => ''1'',\n  ''width'' => ''180'',\n  ''height'' => ''100'',\n  ''templateid'' => ''13'',\n)', 'announcelist(13,0,1,10,50,1,0,1,180,100)', 'phpcms', 1150457913, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_usergroup`
-- 

DROP TABLE IF EXISTS `phpcms_usergroup`;
CREATE TABLE IF NOT EXISTS `phpcms_usergroup` (
  `groupid` int(11) NOT NULL auto_increment,
  `groupname` varchar(50) NOT NULL default '',
  `introduce` varchar(255) NOT NULL default '',
  `grouptype` enum('system','special') NOT NULL default 'special',
  `chargetype` tinyint(1) NOT NULL default '0',
  `defaultpoint` int(11) NOT NULL default '0',
  `defaultvalidday` int(11) NOT NULL default '0',
  `discount` int(3) unsigned NOT NULL default '100',
  `enableaddalways` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`groupid`),
  KEY `grouptype` (`grouptype`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_usergroup`
-- 

INSERT INTO `phpcms_usergroup` VALUES (1, '游客', '', 'system', 0, 0, 0, 100, 0);
INSERT INTO `phpcms_usergroup` VALUES (2, '待验证用户', '', 'system', 0, 0, 0, 100, 0);
INSERT INTO `phpcms_usergroup` VALUES (3, '待审批会员', '', 'system', 0, 0, 0, 100, 0);
INSERT INTO `phpcms_usergroup` VALUES (4, '注册用户', '', 'special', 1, 0, -1, 100, 0);
INSERT INTO `phpcms_usergroup` VALUES (5, '收费会员', '', 'special', 1, 0, -1, 100, 0);
INSERT INTO `phpcms_usergroup` VALUES (6, 'VIP会员', '', 'special', 1, 0, -1, 80, 0);
INSERT INTO `phpcms_usergroup` VALUES (7, '特约记者', '本站特约记者', 'special', 0, 100, -1, 100, 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_voteoption`
-- 

DROP TABLE IF EXISTS `phpcms_voteoption`;
CREATE TABLE IF NOT EXISTS `phpcms_voteoption` (
  `optionid` int(11) NOT NULL auto_increment,
  `voteid` int(11) NOT NULL default '0',
  `option` varchar(255) NOT NULL default '',
  `number` int(11) NOT NULL default '0',
  PRIMARY KEY  (`optionid`),
  KEY `voteid` (`voteid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_voteoption`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `phpcms_votesubject`
-- 

DROP TABLE IF EXISTS `phpcms_votesubject`;
CREATE TABLE IF NOT EXISTS `phpcms_votesubject` (
  `voteid` int(11) NOT NULL auto_increment,
  `channelid` int(11) NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `type` varchar(8) NOT NULL default 'radio',
  `username` varchar(30) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `fromdate` date NOT NULL default '0000-00-00',
  `todate` date NOT NULL default '0000-00-00',
  `totalnumber` int(11) NOT NULL default '0',
  `usernames` longtext NOT NULL,
  `passed` tinyint(1) NOT NULL default '0',
  `templateid` varchar(20) NOT NULL default '',
  `skinid` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`voteid`),
  KEY `subject` (`subject`,`username`),
  KEY `channelid` (`channelid`)
) TYPE=MyISAM;

-- 
-- 导出表中的数据 `phpcms_votesubject`
-- 

