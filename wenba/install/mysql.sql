INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES 
('问吧', 'wenba', 'wenba', '', 0, 0, 1, '1.0.0', 'phpcms', 'http://www.phpcms.cn', 'phpcms@163.com', '问吧', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_wenba_actor`;
CREATE TABLE IF NOT EXISTS `phpcms_wenba_actor` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `typeid` smallint(3) unsigned NOT NULL,
  `grade` varchar(40) NOT NULL,
  `actor` varchar(100) NOT NULL,
  `min` int(12) unsigned NOT NULL default '0',
  `max` int(12) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_wenba_answer`;
CREATE TABLE IF NOT EXISTS `phpcms_wenba_answer` (
  `aid` int(10) unsigned NOT NULL auto_increment,
  `qid` int(10) unsigned NOT NULL default '0',
  `username` char(18) NOT NULL,
  `answer` mediumtext NOT NULL,
  `answertime` int(10) unsigned NOT NULL default '0',
  `accept_status` tinyint(1) unsigned NOT NULL default '0',
  `prepare_status` tinyint(1) unsigned NOT NULL default '0',
  `vote_count` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`aid`),
  KEY `qid` (`qid`),
  KEY `username` (`username`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_wenba_credit`;
CREATE TABLE IF NOT EXISTS `phpcms_wenba_credit` (
  `cid` int(10) unsigned NOT NULL auto_increment,
  `username` char(20) NOT NULL,
  `premonth` smallint(5) unsigned NOT NULL default '0',
  `month` smallint(5) unsigned NOT NULL default '0',
  `preweek` smallint(5) unsigned NOT NULL default '0',
  `week` smallint(5) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  UNIQUE KEY `username` (`username`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_wenba_question`;
CREATE TABLE IF NOT EXISTS `phpcms_wenba_question` (
  `qid` int(10) unsigned NOT NULL auto_increment,
  `catid` smallint(6) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL,
  `score` smallint(5) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `asktime` int(10) unsigned NOT NULL default '0',
  `endtime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '1',
  `hidname` tinyint(1) unsigned NOT NULL default '0',
  `introtime` int(10) unsigned NOT NULL default '0',
  `answercount` smallint(5) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  `elite` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`qid`),
  KEY `catid` (`catid`,`status`,`hits`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_wenba_response`;
CREATE TABLE IF NOT EXISTS `phpcms_wenba_response` (
  `rid` int(10) unsigned NOT NULL auto_increment,
  `aid` int(10) unsigned NOT NULL default '0',
  `qid` int(10) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY  (`rid`),
  KEY `qid` (`qid`,`aid`,`rid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_wenba_vote`;
CREATE TABLE IF NOT EXISTS `phpcms_wenba_vote` (
  `voteid` int(11) unsigned NOT NULL auto_increment,
  `username` char(20) NOT NULL,
  `qid` int(11) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`voteid`),
  KEY `qid` (`qid`,`username`)
) TYPE=MyISAM;

INSERT INTO `phpcms_channel` (`module`, `channelname`, `style`, `channelpic`, `introduce`, `seo_title`, `seo_keywords`, `seo_description`, `listorder`, `islink`, `channeldir`, `channeldomain`, `disabled`, `templateid`, `skinid`, `items`, `comments`, `categorys`, `specials`, `hits`, `enablepurview`, `arrgroupid_browse`, `purview_message`, `point_message`, `enablecontribute`, `enablecheck`, `emailofreject`, `emailofpassed`, `enableupload`, `uploaddir`, `maxfilesize`, `uploadfiletype`, `linkurl`, `setting`, `ishtml`, `cat_html_urlruleid`, `item_html_urlruleid`, `special_html_urlruleid`, `cat_php_urlruleid`, `item_php_urlruleid`, `special_php_urlruleid`) VALUES ('wenba', '问吧', '', '', '', '', '', '', 30, 1, '', '', 0, '0', '0', 0, 0, 0, 0, 0, 0, '', '', '', 1, 1, '', '', 1, 'uploadfile', 1024000, 'gif|jpg', 'wenba/', '', 1, 0, 0, 0, 0, 0, 0);

ALTER TABLE `phpcms_member` ADD `totalonline` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `phpcms_member` ADD `answercounts` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `phpcms_member` ADD `acceptcount` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `phpcms_member` ADD `actortype` SMALLINT( 2 ) UNSIGNED NOT NULL DEFAULT '0';

INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '修改头衔', '', 'wenba/member_actor.php', '_self', 'color:#FF0000;font-weight:bold;', 0, '', '', '');
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES
('member_menu', '我的提问', '', 'wenba/member_index.php', '_self', 'color:#00FF00;font-weight:bold;', 0, '', '', '');
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES
('member_menu', '我的回答', '', 'wenba/my_answer.php', '_self', '', 0, '', '', '');

INSERT INTO `phpcms_wenba_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES
(1, 0, '一级', '试用期', 0, 100),
(2, 0, '二级', '助理', 101, 500),
(3, 0, '三级', '助理', 501, 1000),
(4, 0, '四级', '经理', 1001, 2500),
(5, 0, '五级', '经理', 2501, 5000),
(6, 1, '一级', '魔法学徒', 0, 100),
(7, 1, '二级', '见习魔法师', 101, 500),
(8, 1, '三级', '见习魔法师', 501, 1000),
(9, 1, '四级', '魔法师', 1001, 2500),
(10, 1, '五级', '魔法师', 2501, 5000),
(11, 2, '一级', '童生', 0, 100),
(12, 2, '二级', '秀才', 101, 500),
(13, 2, '三级', '秀才', 501, 1000),
(14, 2, '四级', '举人', 1001, 2500),
(15, 2, '五级', '举人', 2501, 5000),
(16, 3, '一级', '兵卒', 0, 100),
(17, 3, '二级', '门吏', 101, 500),
(18, 3, '三级', '门吏', 501, 1000),
(19, 3, '四级', '千总', 1001, 2500),
(20, 3, '五级', '千总', 2501, 5000),
(21, 4, '一级', '初学弟子', 0, 100),
(22, 4, '二级', '初入江湖', 101, 500),
(23, 4, '三级', '初入江湖', 501, 1000),
(24, 4, '四级', '江湖新秀', 1001, 2500),
(25, 4, '五级', '江湖新秀', 2501, 5000);