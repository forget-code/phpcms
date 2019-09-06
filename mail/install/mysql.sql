INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('邮件订阅', 'mail', 'mail', '', 0, 0, 0, '1.0.0', 'phpcms', 'www.phpcms.cn', 'phpcms@163.com', '邮件订阅', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');
DROP TABLE IF EXISTS `phpcms_mail`;
CREATE TABLE `phpcms_mail` (
  `mailid` int(10) unsigned NOT NULL auto_increment,
  `typeid` varchar(10) NOT NULL default '0',
  `title` varchar(200) NOT NULL default '',
  `content` mediumtext NOT NULL,
  `addtime` int(11) unsigned NOT NULL default '0',
  `sendtime` int(11) unsigned NOT NULL default '0',
  `username` varchar(40) NOT NULL default '',
  `period` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mailid`)
) TYPE=MyISAM ;

DROP TABLE IF EXISTS `phpcms_mail_email`;
CREATE TABLE `phpcms_mail_email` (
  `emailid` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(50) NOT NULL default '',
  `username` varchar(30) NOT NULL default '',
  `typeids` varchar(255) NOT NULL default '',
  `ip` varchar(15) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  `authcode` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`emailid`)
) TYPE=MyISAM ;
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '邮件订阅', '', 'mail/index.php', '_self', '', 18, '', '', '');