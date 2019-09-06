INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('order', '订单', 'order/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', 'array (\n  ''maxcloseday'' => ''7'',\n  ''maxdelivers'' => ''5'',\n)', 0, 0, '2008-11-26', '2008-11-26', '2008-11-26');

DROP TABLE IF EXISTS `phpcms_order`;
CREATE TABLE IF NOT EXISTS `phpcms_order` (
  `orderid` int(10) unsigned NOT NULL auto_increment,
  `goodsid` char(32) NOT NULL,
  `goodsname` char(80) NOT NULL,
  `goodsurl` char(100) NOT NULL,
  `unit` char(10) NOT NULL,
  `price` decimal(8,2) unsigned NOT NULL default '0.00',
  `number` smallint(5) unsigned NOT NULL default '0',
  `carriage` decimal(8,2) unsigned NOT NULL default '0.00',
  `amount` decimal(8,2) unsigned default '0.00',
  `consignee` char(40) NOT NULL,
  `areaid` smallint(5) unsigned NOT NULL default '0',
  `telephone` char(20) NOT NULL,
  `mobile` char(15) NOT NULL,
  `address` char(200) NOT NULL,
  `postcode` char(6) NOT NULL,
  `note` char(255) NOT NULL,
  `memo` char(255) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `ip` char(15) NOT NULL,
  `time` int(10) unsigned NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`orderid`),
  KEY `userid` (`userid`,`status`),
  KEY `goodsid` (`goodsid`,`status`,`date`,`orderid`),
  KEY `date` (`status`,`date`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_order_deliver`;
CREATE TABLE IF NOT EXISTS `phpcms_order_deliver` (
  `deliverid` int(10) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `consignee` char(40) NOT NULL,
  `areaid` smallint(5) unsigned NOT NULL default '0',
  `address` char(200) NOT NULL,
  `postcode` char(6) NOT NULL,
  `telephone` char(20) NOT NULL,
  `mobile` char(15) NOT NULL,
  PRIMARY KEY  (`deliverid`),
  KEY `userid` (`userid`,`deliverid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_order_log`;
CREATE TABLE IF NOT EXISTS `phpcms_order_log` (
  `logid` int(10) unsigned NOT NULL auto_increment,
  `orderid` int(10) unsigned NOT NULL default '0',
  `laststatus` tinyint(1) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `note` char(255) NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `ip` char(15) NOT NULL,
  `time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`logid`)
) TYPE=MyISAM;