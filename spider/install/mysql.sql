INSERT INTO `phpcms_module` VALUES ('spider', '采集管理', 'spider/', 'spider/', 0, '1.0.0.0', 'phpcms', 'http://www.phpcms.cn/', 'phpcms@ku6.com', '', '', '', '', 'array (\n  ''Debug'' => ''0'',\n  ''CacheUrlTag'' => ''1'',\n  ''CacheTitleTag'' => ''1'',\n  ''keywordContentLenght'' => ''500'',\n ''titleLength'' => ''72'',\n  ''keywordNumber'' => ''4'',\n  ''keywordStrLength'' => ''4'',\n  ''keywordStrMaxLength'' => ''8'',\n  ''keywordFilter'' => '''',\n  ''descriptionLength'' => ''180'',\n)', 0, 0, '2009-05-20', '2009-05-20', '2009-05-20');

DROP TABLE IF EXISTS `phpcms_spider_job`;
CREATE TABLE `phpcms_spider_job` (
  `JobId` int(11) unsigned NOT NULL auto_increment,
  `SiteId` int(8) NOT NULL default '0',
  `CatId` int(8) NOT NULL default '0',
  `JobName` varchar(100) NOT NULL default '',
  `JobDescription` text NOT NULL,
  `StartUrl` text NOT NULL,
  `SpiderStep` tinyint(1) NOT NULL default '0',
  `UseSpecialLink` tinyint(1) NOT NULL default '0',
  `ScriptLink` varchar(250) NOT NULL default '',
  `TrueLink` varchar(250) NOT NULL default '',
  `ListPageMust` varchar(100) NOT NULL default '',
  `ListPageForbid` varchar(100) NOT NULL default '',
  `ContentPageMust` varchar(100) NOT NULL default '',
  `ContentPageForbid` varchar(100) NOT NULL default '',
  `ListUrlStart` text NOT NULL,
  `ListUrlEnd` text NOT NULL,
  `SpiderRule` text NOT NULL,
  `Cookie` text NOT NULL,
  `DividePageStyle` tinyint(1) NOT NULL default '0',
  `DividePageStart` text NOT NULL,
  `DividePageEnd` text NOT NULL,
  `DividePageUnion` varchar(255) default NULL,
  `AutoPageSize` int(11) NOT NULL default '0',
  `SourceEncode` tinyint(1) NOT NULL default '0',
  `SiteEncode` TINYINT NOT NULL DEFAULT '0',
  `LabelCycle` tinyint(1) NOT NULL default '0',
  `TestPageUrl` varchar(250) NOT NULL default '',
  `DownImg` tinyint(1) NOT NULL default '0',
  `DownSwf` tinyint(1) NOT NULL default '0',
  `DownOther` tinyint(1) NOT NULL default '0',
  `OtherFileType` varchar(200) NOT NULL default '',
  `ThreadNum` int(5) NOT NULL default '0',
  `ThreadRequest` int(5) NOT NULL default '0',
  `ThreadSleep` int(8) NOT NULL default '0',
  `TimeOut` int(5) NOT NULL default '0',
  `CreateOn` int(11) NOT NULL default '0',
  `UpdateOn` int(11) NOT NULL default '0',
  PRIMARY KEY  (`JobId`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_spider_out`;
DROP TABLE IF EXISTS `phpcms_spider_sites`;
CREATE TABLE `phpcms_spider_sites` (
  `Id` int(11) unsigned NOT NULL auto_increment,
  `SiteName` varchar(100) NOT NULL default '',
  `SiteUrl` varchar(250) NOT NULL default '',
  `Description` text NOT NULL,
  PRIMARY KEY  (`Id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_spider_urls`;
CREATE TABLE `phpcms_spider_urls` (
  `Id` int(11) NOT NULL auto_increment,
  `JobId` int(7) NOT NULL default '0',
  `Title` varchar(80) NOT NULL default '',
  `Thumb` varchar(255) default NULL,
  `PageUrl` varchar(250) NOT NULL default '',
  `BaseUrl` varchar(250) NOT NULL default '',
  `CreateOn` int(11) NOT NULL default '0',
  `SpiderOn` int(11) NOT NULL default '0',
  `Spidered` tinyint(1) NOT NULL default '0',
  `Content` text NOT NULL,
  `StartTimeStamp` int(11) NOT NULL default '0',
  `IsOut` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `title` (`Title`,`PageUrl`,`CreateOn`,`JobId`,`Spidered`),
  KEY `PageUrl` (`PageUrl`),
  KEY `Spidered` (`Spidered`,`IsOut`),
  KEY `StartTimeStamp` (`StartTimeStamp`),
  KEY `IsOut` (`IsOut`,`JobId`)
) TYPE=MyISAM ;