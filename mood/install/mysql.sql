INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('mood', '心情指数', 'mood/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', '', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_mood`;
CREATE TABLE `phpcms_mood` (
  `moodid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `number` tinyint(3) unsigned NOT NULL default '0',
  `m1` varchar(100) NOT NULL,
  `m2` varchar(100) NOT NULL,
  `m3` varchar(100) NOT NULL,
  `m4` varchar(100) NOT NULL,
  `m5` varchar(100) NOT NULL,
  `m6` varchar(100) NOT NULL,
  `m7` varchar(100) NOT NULL,
  `m8` varchar(100) NOT NULL,
  `m9` varchar(100) NOT NULL,
  `m10` varchar(100) NOT NULL,
  `m11` varchar(100) NOT NULL,
  `m12` varchar(100) NOT NULL,
  `m13` varchar(100) NOT NULL,
  `m14` varchar(100) NOT NULL,
  `m15` varchar(100) NOT NULL,
  PRIMARY KEY  (`moodid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_mood` (`moodid`, `name`, `number`, `m1`, `m2`, `m3`, `m4`, `m5`, `m6`, `m7`, `m8`, `m9`, `m10`, `m11`, `m12`, `m13`, `m14`, `m15`) VALUES(1, '新闻', 11, '支持|mood/images/zhichi.gif', '高兴|mood/images/gaoxing.gif', '震惊|mood/images/zhenjing.gif', '愤怒|mood/images/fennu.gif', '无奈|mood/images/wunai.gif', '谎言|mood/images/huangyan.gif', '枪稿|mood/images/qianggao.gif', '不解|mood/images/bujie.gif', '搞笑|mood/images/gaoxiao.gif', '无聊|mood/images/wuliao.gif', '标题党|mood/images/biaotidang.gif', '', '', '', '');
INSERT INTO `phpcms_mood` (`moodid`, `name`, `number`, `m1`, `m2`, `m3`, `m4`, `m5`, `m6`, `m7`, `m8`, `m9`, `m10`, `m11`, `m12`, `m13`, `m14`, `m15`) VALUES(2, '视频', 10, '支持|mood/images/zhichi.gif', '高兴|mood/images/gaoxing.gif', '震惊|mood/images/zhenjing.gif', '愤怒|mood/images/fennu.gif', '无奈|mood/images/wunai.gif', '谎言|mood/images/huangyan.gif', '枪稿|mood/images/qianggao.gif', '不解|mood/images/bujie.gif', '搞笑|mood/images/gaoxiao.gif', '无聊|mood/images/wuliao.gif', '', '', '', '', '');

DROP TABLE IF EXISTS `phpcms_mood_data`;
CREATE TABLE `phpcms_mood_data` (
  `moodid` tinyint(3) unsigned NOT NULL default '0',
  `contentid` mediumint(8) unsigned NOT NULL default '0',
  `total` mediumint(8) unsigned NOT NULL default '0',
  `n1` smallint(5) unsigned NOT NULL default '0',
  `n2` smallint(5) unsigned NOT NULL default '0',
  `n3` smallint(5) unsigned NOT NULL default '0',
  `n4` smallint(5) unsigned NOT NULL default '0',
  `n5` smallint(5) unsigned NOT NULL default '0',
  `n6` smallint(5) unsigned NOT NULL default '0',
  `n7` smallint(5) unsigned NOT NULL default '0',
  `n8` smallint(5) unsigned NOT NULL default '0',
  `n9` smallint(5) unsigned NOT NULL default '0',
  `n10` smallint(5) unsigned NOT NULL default '0',
  `n11` smallint(5) unsigned NOT NULL default '0',
  `n12` smallint(5) unsigned NOT NULL default '0',
  `n13` smallint(5) unsigned NOT NULL default '0',
  `n14` smallint(5) unsigned NOT NULL default '0',
  `n15` smallint(5) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  KEY `contentid` (`contentid`),
  KEY `moodid` (`moodid`,`total`)
) TYPE=MyISAM;