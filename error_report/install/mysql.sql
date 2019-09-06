INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('错误报告', 'error_report', 'error_report', '', 0, 0, 1, '1.0.0', 'phpcms', 'http://www.phpcms.cn', 'phpcms@163.com', '错误报告', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');
DROP TABLE IF EXISTS `phpcms_error_report`;
CREATE TABLE IF NOT EXISTS `phpcms_error_report` (
  `error_id` int(10) unsigned NOT NULL auto_increment,
  `error_title` varchar(255) NOT NULL default '',
  `error_text` varchar(255) NOT NULL default '',
  `error_link` varchar(255) NOT NULL default '',
  `keyid` varchar(50) NOT NULL,
  `addtime` int(10) unsigned zerofill NOT NULL default '0000000000',
  `status` tinyint(1) unsigned zerofill NOT NULL default '0',
  PRIMARY KEY  (`error_id`),
  KEY `keyid` (`keyid`,`status`,`error_id`)
) TYPE=MyISAM;
