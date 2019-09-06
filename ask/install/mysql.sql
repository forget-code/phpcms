INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('ask', '问吧', 'ask/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '问吧', '', '', 'array (\r\n   ''ask-ask'' => ''问题列表标签'',\r\n   ''ask-credit'' => ''积分标签'',\r\n)\r\n', 'array (\n  ''publish_check'' => ''0'',\n  ''publish_code'' => ''1'',\n  ''answer_check'' => ''0'',\n  ''height_score'' => ''10'',\n  ''anybody_score'' => ''2'',\n  ''answer_give_credit'' => ''2'',\n  ''answer_max_credit'' => ''20'',\n  ''answer_bounty_credit'' => ''10'',\n  ''vote_give_credit'' => ''1'',\n  ''vote_max_credit'' => ''10'',\n  ''del_question_credit'' => ''20'',\n  ''del_answer_credit'' => ''25'',\n  ''del_day15_credit'' => ''25'',\n  ''return_credit'' => ''10'',\n  ''member_group'' => ''公司白领\r\n魔法师\r\n科举夺魁\r\n武将\r\n江湖奇侠'',\n  ''autoupdate'' => ''10'',\n  ''use_editor'' => ''1'',\n  ''rewrite'' => ''0'',\n  ''categoryUrlRuleid'' => ''29'',\n  ''showUrlRuleid'' => ''28'',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_ask`;
CREATE TABLE `phpcms_ask` (
  `askid` mediumint(8) unsigned NOT NULL auto_increment,
  `catid` smallint(5) unsigned NOT NULL default '0',
  `title` char(80) NOT NULL,
  `reward` smallint(5) unsigned NOT NULL default '0',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `endtime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `flag` tinyint(1) unsigned NOT NULL default '0',
  `answercount` tinyint(3) unsigned NOT NULL default '0',
  `anonymity` tinyint(1) unsigned NOT NULL default '0',
  `hits` mediumint(8) unsigned NOT NULL default '0',
  `ischeck` tinyint(1) unsigned NOT NULL default '0',
  `searchid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`askid`),
  KEY `catid` (`catid`,`status`,`askid`),
  KEY `status` (`status`,`askid`),
  KEY `userid` (`userid`,`status`,`askid`),
  KEY `answercount` (`answercount`,`catid`,`askid`),
  KEY `flag` (`flag`,`status`,`askid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_ask_actor`;
CREATE TABLE `phpcms_ask_actor` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `typeid` tinyint(3) unsigned NOT NULL default '0',
  `grade` char(20) NOT NULL,
  `actor` char(30) NOT NULL,
  `min` smallint(5) unsigned NOT NULL default '0',
  `max` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `typeid` (`typeid`,`id`)
) TYPE=MyISAM;

INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(1, 0, '一级', '试用期', 0, 100);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(2, 0, '二级', '助理', 101, 500);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(3, 0, '三级', '助理', 501, 1000);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(4, 0, '四级', '经理', 1001, 2500);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(5, 0, '五级', '经理', 2501, 5000);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(6, 1, '一级', '魔法学徒', 0, 100);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(7, 1, '二级', '见习魔法师', 101, 500);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(8, 1, '三级', '见习魔法师', 501, 1000);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(9, 1, '四级', '魔法师', 1001, 2500);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(10, 1, '五级', '魔法师', 2501, 5000);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(11, 2, '一级', '童生', 0, 100);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(12, 2, '二级', '秀才', 101, 500);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(13, 2, '三级', '秀才', 501, 1000);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(14, 2, '四级', '举人', 1001, 2500);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(15, 2, '五级', '举人', 2501, 5000);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(16, 3, '一级', '兵卒', 0, 100);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(17, 3, '二级', '门吏', 101, 500);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(18, 3, '三级', '门吏', 501, 1000);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(19, 3, '四级', '千总', 1001, 2500);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(20, 3, '五级', '千总', 2501, 5000);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(21, 4, '一级', '初学弟子', 0, 100);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(22, 4, '二级', '初入江湖', 101, 500);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(23, 4, '三级', '初入江湖', 501, 1000);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(24, 4, '四级', '江湖新秀', 1001, 2500);
INSERT INTO `phpcms_ask_actor` (`id`, `typeid`, `grade`, `actor`, `min`, `max`) VALUES(25, 4, '五级', '江湖新秀', 2501, 5000);

DROP TABLE IF EXISTS `phpcms_ask_credit`;
CREATE TABLE `phpcms_ask_credit` (
  `cid` mediumint(8) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `premonth` smallint(5) unsigned NOT NULL default '0',
  `month` smallint(5) unsigned NOT NULL default '0',
  `preweek` smallint(5) unsigned NOT NULL default '0',
  `week` smallint(5) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  UNIQUE KEY `userid` (`userid`),
  KEY `premonth` (`premonth`,`userid`),
  KEY `preweek` (`preweek`,`userid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_ask_posts`;
CREATE TABLE `phpcms_ask_posts` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `askid` mediumint(8) unsigned NOT NULL default '0',
  `isask` tinyint(1) unsigned NOT NULL default '0',
  `message` mediumtext NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `candidate` tinyint(1) unsigned NOT NULL default '0',
  `optimal` tinyint(1) unsigned NOT NULL default '0',
  `reversion` tinyint(1) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '0',
  `anonymity` tinyint(1) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `solvetime` int(10) unsigned NOT NULL default '0',
  `votecount` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`pid`),
  KEY `askid` (`askid`,`status`,`pid`),
  KEY `userid` (`userid`,`askid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_ask_vote`;
CREATE TABLE `phpcms_ask_vote` (
  `voteid` int(11) unsigned NOT NULL auto_increment,
  `askid` mediumint(8) NOT NULL default '0',
  `pid` int(10) unsigned NOT NULL default '0',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`voteid`),
  KEY `pid` (`pid`,`userid`),
  KEY `askid` (`askid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(25, 'ask', 'htmlshow', 0, 'show-{$id}.html', 'show-1.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(26, 'ask', 'htmlcategory', 0, 'ask/list-{$catid}-{$action}-1.html|ask/list-{$catid}-{$action}-{$page}.html', 'list-16-solve-1.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(27, 'ask', 'htmlshow', 0, '{$id}.html', '1234.html');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(28, 'ask', 'show', 0, 'show.php?id={$id}', 'show.php?id=1');
INSERT INTO `phpcms_urlrule` (`urlruleid`, `module`, `file`, `ishtml`, `urlrule`, `example`) VALUES(29, 'ask', 'category', 0, 'ask/list.php?catid={$catid}&action={$action}|ask/list.php?catid={$catid}&action={$action}&page={$page}', 'list.php?catid=1&action=solve');

ALTER TABLE `phpcms_member_info` ADD `actortype` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `phpcms_member_info` ADD `answercount` mediumint(8) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `phpcms_member_info` ADD `acceptcount` smallint(5) UNSIGNED NOT NULL DEFAULT '0';