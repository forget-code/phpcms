--
-- 表的结构 `phpcms_video`
--

DROP TABLE IF EXISTS `phpcms_video`;
CREATE TABLE IF NOT EXISTS `phpcms_video` (
  `vid` mediumint(8) unsigned NOT NULL auto_increment COMMENT '视频id',
  `catid` smallint(5) unsigned NOT NULL default '0',
  `title` varchar(80) NOT NULL,
  `style` varchar(5) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `keywords` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL,
  `posids` tinyint(1) unsigned NOT NULL default '0',
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  `status` tinyint(2) unsigned NOT NULL default '3',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `url` varchar(100) NOT NULL,
  `timelen` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`vid`),
  KEY `catid` (`catid`,`status`)
) TYPE=MyISAM;
-- --------------------------------------------------------

--
-- 表的结构 `phpcms_video_count`
--

DROP TABLE IF EXISTS `phpcms_video_count`;
CREATE TABLE IF NOT EXISTS `phpcms_video_count` (
  `vid` mediumint(8) unsigned NOT NULL,
  `hits` mediumint(8) unsigned NOT NULL default '0',
  `hits_day` smallint(5) unsigned NOT NULL default '0',
  `hits_yestoday` mediumint(8) unsigned NOT NULL default '0',
  `hits_week` mediumint(8) unsigned NOT NULL default '0',
  `hits_month` mediumint(8) unsigned NOT NULL default '0',
  `hits_time` int(10) unsigned NOT NULL default '0',
  `comments` smallint(5) unsigned NOT NULL default '0',
  `comments_checked` smallint(5) unsigned NOT NULL default '0',
  KEY `vid` (`vid`),
  KEY `hits_time` (`hits_time`)
) TYPE=MyISAM;
-- --------------------------------------------------------

--
-- 表的结构 `phpcms_video_data`
--

DROP TABLE IF EXISTS `phpcms_video_data`;
CREATE TABLE IF NOT EXISTS `phpcms_video_data` (
  `vid` mediumint(8) unsigned default NULL COMMENT '视频id',
  `vmsvid` varchar(32) NOT NULL,
  `template` varchar(30) NOT NULL default '',
  `content` text NOT NULL,
  `groupids_view` tinyint(1) unsigned NOT NULL default '0',
  `readpoint` smallint(5) unsigned NOT NULL default '0',
  `author` varchar(30) NOT NULL default '',
  `copyfrom` varchar(100) NOT NULL,
  KEY `vid` (`vid`)
) TYPE=MyISAM;
-- --------------------------------------------------------

--
-- 表的结构 `phpcms_video_position`
--

DROP TABLE IF EXISTS `phpcms_video_position`;
CREATE TABLE IF NOT EXISTS `phpcms_video_position` (
  `vid` mediumint(8) unsigned NOT NULL default '0',
  `posid` smallint(5) unsigned NOT NULL default '0',
  KEY `posid` (`posid`),
  KEY `vid` (`vid`)
) TYPE=MyISAM;
-- --------------------------------------------------------

--
-- 表的结构 `phpcms_video_special`
--

DROP TABLE IF EXISTS `phpcms_video_special`;
CREATE TABLE IF NOT EXISTS `phpcms_video_special` (
  `specialid` mediumint(8) unsigned NOT NULL auto_increment COMMENT '专辑id',
  `title` varchar(80) default NULL COMMENT '专辑名称',
  `userid` mediumint(8) unsigned NOT NULL default '0' COMMENT '用户id',
  `style` varchar(5) NOT NULL,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `videonums` mediumint(8) unsigned NOT NULL default '0' COMMENT '专辑频视总数',
  `thumb` varchar(150) default NULL COMMENT '专辑缩略图',
  `banner` varchar(100) NOT NULL,
  `description` text COMMENT '专题介绍',
  `addtime` int(10) unsigned default NULL COMMENT '添加时间',
  `template` varchar(30) NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`specialid`),
  KEY `userid` (`userid`,`disabled`)
) TYPE=MyISAM;
-- --------------------------------------------------------

--
-- 表的结构 `phpcms_video_special_list`
--

DROP TABLE IF EXISTS `phpcms_video_special_list`;
CREATE TABLE IF NOT EXISTS `phpcms_video_special_list` (
  `specialid` mediumint(8) unsigned NOT NULL default '0' COMMENT '专题id',
  `vid` mediumint(8) unsigned NOT NULL default '0' COMMENT '视频vid',
  `listorder` mediumint(8) unsigned default '0' COMMENT '排序',
  PRIMARY KEY  (`specialid`,`vid`)
) TYPE=MyISAM;
-- --------------------------------------------------------

--
-- 表的结构 `phpcms_video_tag`
--

DROP TABLE IF EXISTS `phpcms_video_tag`;
CREATE TABLE IF NOT EXISTS `phpcms_video_tag` (
  `tag` char(20) NOT NULL,
  `vid` mediumint(8) unsigned NOT NULL default '0',
  KEY `vid` (`vid`),
  KEY `tag` (`tag`(10))
) TYPE=MyISAM;