INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES 
('message', '短消息', 'message/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', '', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_message`;
CREATE TABLE IF NOT EXISTS `phpcms_message` (
  `messageid` int(10) unsigned NOT NULL auto_increment,
  `send_from_id` mediumint(8) unsigned NOT NULL default '0',
  `send_to_id` mediumint(8) unsigned NOT NULL default '0',
  `folder` enum('all','inbox','outbox') NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '0',
  `message_time` int(10) unsigned NOT NULL default '0',
  `subject` char(80) NOT NULL,
  `content` text NOT NULL,
  `replyid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`messageid`),
  KEY `msgtoid` (`send_to_id`,`folder`),
  KEY `replyid` (`replyid`),
  KEY `folder` (`send_from_id`,`folder`)
) TYPE=MyISAM;