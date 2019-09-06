INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('pay', '支付', 'pay/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', 'array (\n  ''maxtopfailedtimes'' => ''0'',\n  ''maxiplockedtime'' => ''1'',\n  ''enabledkey'' => '','',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_pay_payment`;
CREATE TABLE `phpcms_pay_payment` (
  `pay_id` tinyint(3) unsigned NOT NULL auto_increment,
  `pay_code` varchar(20) NOT NULL,
  `pay_name` varchar(120) NOT NULL,
  `pay_desc` text NOT NULL,
  `pay_fee` varchar(10) NOT NULL,
  `config` text NOT NULL,
  `is_cod` tinyint(1) unsigned NOT NULL default '0',
  `is_online` tinyint(1) unsigned NOT NULL default '0',
  `pay_order` tinyint(3) unsigned NOT NULL default '0',
  `enabled` tinyint(1) unsigned NOT NULL default '0',
  `author` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `version` varchar(20) NOT NULL,
  PRIMARY KEY  (`pay_id`),
  KEY `pay_code` (`pay_code`)
) TYPE=MyISAM;
DROP TABLE IF EXISTS `phpcms_pay_card`;
CREATE TABLE `phpcms_pay_card` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `ptypeid` smallint(5) unsigned NOT NULL default '0',
  `cardid` char(25) NOT NULL,
  `inputerid` mediumint(8) unsigned NOT NULL default '0',
  `inputer` char(20) NOT NULL,
  `mtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `regtime` datetime default '0000-00-00 00:00:00',
  `endtime` int(10) unsigned NOT NULL default '0',
  `regip` char(15) NOT NULL default '0.0.0.0',
  `point` smallint(5) unsigned NOT NULL default '0',
  `amount` smallint(5) unsigned NOT NULL default '0',
  `status` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cardid` (`cardid`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `phpcms_pay_pointcard_type`;
CREATE TABLE `phpcms_pay_pointcard_type` (
  `ptypeid` tinyint(3) unsigned NOT NULL auto_increment,
  `name` char(20) NOT NULL,
  `point` smallint(5) unsigned NOT NULL default '0',
  `amount` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ptypeid`)
) TYPE=MyISAM;
INSERT INTO `phpcms_pay_pointcard_type` ( `name`, `point`, `amount`) VALUES ('金卡', 10, 100);
INSERT INTO `phpcms_pay_pointcard_type` ( `name`, `point`, `amount`) VALUES ('银卡', 10, 80);

DROP TABLE IF EXISTS `phpcms_pay_user_account`;
CREATE TABLE `phpcms_pay_user_account` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `email` char(40) NOT NULL,
  `contactname` char(50) NOT NULL,
  `telephone` char(20) NOT NULL,
  `sn` char(50) NOT NULL,
  `inputer` char(20) NOT NULL,
  `inputerid` mediumint(8) unsigned NOT NULL default '0',
  `amount` decimal(8,2) unsigned NOT NULL,
  `addtime` int(10) NOT NULL default '0',
  `paytime` int(10) NOT NULL default '0',
  `adminnote` char(255) NOT NULL,
  `usernote` char(255) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL default '0',
  `payment` char(90) NOT NULL,
  `ip` char(15) NOT NULL default '0.0.0.0',
  `ispay` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ispay` (`ispay`),
  KEY `sn` (`sn`,`amount`,`ispay`,`id`),
  KEY `userid` (`userid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_pay_exchange`;
CREATE TABLE `phpcms_pay_exchange` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'id',
  `module` char(15) NOT NULL,
  `type` enum('amount','point') NOT NULL,
  `number` decimal(8,2) NOT NULL,
  `blance` decimal(8,2) unsigned NOT NULL default '0.00',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `inputid` mediumint(8) unsigned NOT NULL default '0',
  `inputer` char(20) NOT NULL,
  `ip` char(15) NOT NULL default '0.0.0.0',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `note` char(100) NOT NULL,
  `authid` char(32) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`,`type`,`module`,`id`),
  KEY `inputid` (`inputid`,`type`,`module`,`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_pay_stat`;
CREATE TABLE `phpcms_pay_stat` (
  `date` date NOT NULL default '0000-00-00',
  `type` enum('amount','point') NOT NULL,
  `receipts` decimal(8,2) unsigned NOT NULL default '0.00',
  `advances` decimal(8,2) unsigned NOT NULL default '0.00',
  KEY `data` (`date`)
) TYPE=MyISAM;
