INSERT INTO `phpcms_module` (`module`, `name`, `path`, `url`, `iscore`, `version`, `author`, `site`, `email`, `description`, `license`, `faq`, `tagtypes`, `setting`, `listorder`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('error_report', '错误报告', 'error_report/', '', 0, '1.0.0.0', 'Phpcms Team', 'http://www.phpcms.cn/', 'phpcms@163.com', '', '', '', '', 'array (\n  ''ispoint'' => ''0'',\n  ''enablecheckcode'' => ''1'',\n  ''enabledkey'' => '','',\n)', 0, 0, '2008-10-28', '2008-10-28', '2008-10-28');

DROP TABLE IF EXISTS `phpcms_error_report`;
CREATE TABLE `phpcms_error_report` (
  `error_id` int(10) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL,
  `error_title` varchar(150) NOT NULL,
  `error_text` varchar(255) NOT NULL default '',
  `error_link` varchar(100) NOT NULL,
  `typeid` smallint(5) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `contentid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`error_id`),
  KEY `keyid` (`typeid`,`status`,`error_id`)
) TYPE=MyISAM;

INSERT INTO `phpcms_type` (`typeid`, `module`, `name`, `style`, `typedir`, `description`, `thumb`, `url`, `template`, `listorder`) VALUES (2, 'error_report', '错字', '', '', '', '', '', '', 0);
INSERT INTO `phpcms_type` (`typeid`, `module`, `name`, `style`, `typedir`, `description`, `thumb`, `url`, `template`, `listorder`) VALUES (3, 'error_report', '无效URL', '', '', '', '', '', '', 0);