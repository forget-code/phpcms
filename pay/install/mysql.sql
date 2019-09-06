INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('支付', 'pay', 'pay', '', 0, 0, 0, '1.0.0', 'phpcms team', 'http://www.phpcms.cn', 'phpcms@163.com', 'a', 'a', 'a', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_pay`;
CREATE TABLE `phpcms_pay` (
  `payid` int(11) unsigned NOT NULL auto_increment,
  `keyid` char(20) NOT NULL default '',
  `typeid` tinyint(3) unsigned NOT NULL default '0',
  `note` char(200) NOT NULL default '',
  `paytype` char(20) NOT NULL default '',
  `amount` float NOT NULL default '0',
  `balance` float NOT NULL default '0',
  `year` smallint(4) unsigned NOT NULL default '0',
  `month` tinyint(2) unsigned NOT NULL default '0',
  `date` date NOT NULL default '0000-00-00',
  `username` char(30) NOT NULL default '',
  `ip` char(15) NOT NULL default '',
  `inputer` char(30) NOT NULL default '',
  `inputtime` int(10) unsigned NOT NULL default '0',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `deleter` char(30) NOT NULL default '',
  `deletetime` int(11) unsigned NOT NULL default '0',
  `deletenote` char(100) NOT NULL default '',
  PRIMARY KEY  (`payid`),
  KEY `type` (`typeid`,`year`,`month`,`date`),
  KEY `deleted` (`deleted`),
  KEY `username` (`username`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_pay_card`;
CREATE TABLE `phpcms_pay_card` (
  `id` int(11) NOT NULL auto_increment,
  `prefix` varchar(10) NOT NULL default '',
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
  UNIQUE KEY `cardid` (`cardid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_pay_exchange`;
CREATE TABLE IF NOT EXISTS `phpcms_pay_exchange` (
  `exchangeid` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `type` enum('money','point','time','credit') NOT NULL default 'money',
  `value` float NOT NULL default '0',
  `unit` enum('','y','m','d') NOT NULL default '',
  `note` text NOT NULL,
  `addtime` int(11) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `authid` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`exchangeid`),
  KEY `username` (`username`,`type`),
  KEY `authid` (`authid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_pay_online`;
CREATE TABLE `phpcms_pay_online` (
  `payid` int(11) NOT NULL auto_increment,
  `paycenter` varchar(50) NOT NULL default '',
  `username` varchar(30) NOT NULL default '',
  `orderid` varchar(64) NOT NULL default '',
  `moneytype` varchar(10) NOT NULL default '0',
  `amount` double NOT NULL default '0',
  `trade_fee` double NOT NULL default '0',
  `status` int(11) NOT NULL default '0',
  `bank` varchar(50) NOT NULL default '',
  `contactname` varchar(50) NOT NULL default '',
  `telephone` varchar(50) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `sendtime` int(11) NOT NULL default '0',
  `receivetime` int(11) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`payid`),
  KEY `username` (`username`,`orderid`,`status`),
  KEY `orderid` (`orderid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_pay_price`;
CREATE TABLE `phpcms_pay_price` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` tinyint(1) unsigned NOT NULL default '0',
  `time` smallint(3) unsigned NOT NULL default '0',
  `unit` enum('','y','m','d') NOT NULL default '',
  `point` smallint(5) unsigned NOT NULL default '0',
  `price` float unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (1, 0, 0, '', 100, 10);
INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (2, 0, 0, '', 50, 5);
INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (3, 0, 0, '', 10, 1);
INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (4, 1, 1, 'y', 0, 100);
INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (5, 1, 1, 'm', 0, 10);
INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (6, 1, 3, 'm', 0, 30);
INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (7, 2, 0, '', 10, 100);
INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (8, 2, 0, '', 50, 500);
INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (9, 3, 1, 'd', 0, 100);
INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (10, 3, 1, 'm', 0, 3000);
INSERT INTO `phpcms_pay_price` (`id`, `type`, `time`, `unit`, `point`, `price`) VALUES (11, 3, 1, 'y', 0, 36000);

DROP TABLE IF EXISTS `phpcms_pay_setting`;
CREATE TABLE `phpcms_pay_setting` (
  `id` int(11) NOT NULL auto_increment,
  `paycenter` varchar(50) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `logo` varchar(255) NOT NULL default '',
  `sendurl` varchar(100) NOT NULL default '',
  `receiveurl` varchar(100) NOT NULL default '',
  `partnerid` varchar(100) NOT NULL default '',
  `keycode` varchar(100) NOT NULL default '',
  `percent` float NOT NULL default '0',
  `enable` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `phpcms_pay_setting` (`id`, `paycenter`, `name`, `logo`, `sendurl`, `receiveurl`, `partnerid`, `keycode`, `percent`, `enable`) VALUES (1, 'chinabank', '网银在线', 'http://merchant.chinabank.com.cn/images/logo.gif', 'https://pay.chinabank.com.cn/select_bank', '', '', '', 0, 1);
INSERT INTO `phpcms_pay_setting` (`id`, `paycenter`, `name`, `logo`, `sendurl`, `receiveurl`, `partnerid`, `keycode`, `percent`, `enable`) VALUES (2, 'alipay', '支付宝', 'http://img.alipay.com/img/logo/logo_126x37.gif', 'http://www.alipay.com/cooperate/gateway.do', '', '', '', 0, 1);
INSERT INTO `phpcms_pay_setting` (`paycenter`, `name`, `logo`, `sendurl`, `receiveurl`, `partnerid`, `keycode`, `percent`, `enable`) VALUES( 'tenpay', '财付通', '', 'https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi?', '', '2000000301', '01234567890123456789012345678901', 0, 0);
INSERT INTO `phpcms_pay_setting` (`paycenter`, `name`, `logo`, `sendurl`, `receiveurl`, `partnerid`, `keycode`, `percent`, `enable`) VALUES('99bill', '快钱', '', 'https://www.99bill.com/webapp/receiveMerchantInfoAction.do?', '', '123456', '123456', 0, 0);
INSERT INTO `phpcms_pay_setting` (`paycenter`, `name`, `logo`, `sendurl`, `receiveurl`, `partnerid`, `keycode`, `percent`, `enable`) VALUES('cncard', '云网支付', '', 'https://www.cncard.net/purchase/getorder.asp?', '', '1000447', '123456', 0, 0);

DROP TABLE IF EXISTS `phpcms_pay_type`;
CREATE TABLE `phpcms_pay_type` (
  `typeid` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `operation` enum('+','-','') NOT NULL default '+',
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`typeid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_pay_type` (`typeid`, `name`, `operation`, `listorder`) VALUES (1, '入款', '+', 1);
INSERT INTO `phpcms_pay_type` (`typeid`, `name`, `operation`, `listorder`) VALUES (2, '扣款', '-', 2);
INSERT INTO `phpcms_pay_type` (`typeid`, `name`, `operation`, `listorder`) VALUES (3, '借款', '+', 3);
INSERT INTO `phpcms_pay_type` (`typeid`, `name`, `operation`, `listorder`) VALUES (4, '还款', '-', 4);
INSERT INTO `phpcms_pay_type` (`typeid`, `name`, `operation`, `listorder`) VALUES (5, '返款', '+', 5);

INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '付款充值', '', 'pay/pay.php', '_self', '', 11, '', '', '');
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '在线支付', '', 'pay/payonline.php', '_self', 'color:#FF0000;font-weight:bold;', 10, '', '', '');
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '购买有效期', '', 'pay/time.php', '_self', '', 9, '', '', '');
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '充值卡充值', '', 'pay/paycard.php', '_self', '', 7, '', '', '');
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '购买点数', '', 'pay/point.php', '_self', '', 8, '', '', '');
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '交易记录', '', 'pay/exchange.php', '_self', '', 11, '', '', '');
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '资金/点数/积分转入', '', 'pay/transferin.php', '_self', '', 11, '', '', '');