INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('表单向导', 'formguide', 'formguide', '', 0, 0, 0, '1.0.0', 'phpcms', 'www.phpcms.cn', 'phpcms@163.com', 'formguide', '', '', 'a:5:{s:15:"enablecheckcode";s:1:"1";s:9:"uploaddir";s:10:"uploadfile";s:11:"maxfilesize";s:7:"2048000";s:14:"uploadfiletype";s:31:"gif|jpg|txt|rar|zip|doc|xls|ppt";s:16:"allowmultisubmit";s:1:"0";}', 0, '0000-00-00', '0000-00-00', '0000-00-00');
DROP TABLE IF EXISTS `phpcms_formguide`;
CREATE TABLE `phpcms_formguide` (
  `formid` int(8) unsigned NOT NULL auto_increment,
  `formname` varchar(80) NOT NULL default '',
  `introduce` text NOT NULL,
  `toemail` varchar(80) NOT NULL default '',
  `formitems` text NOT NULL,
  `addtime` int(11) NOT NULL default '0',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`formid`)
) TYPE=MyISAM ;

DROP TABLE IF EXISTS `phpcms_formguide_data`;
CREATE TABLE `phpcms_formguide_data` (
  `did` int(11) unsigned NOT NULL auto_increment,
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL default '',
  `username` varchar(80) NOT NULL default '',
  `addtime` int(11) unsigned NOT NULL default '0',
  `formid` int(9) unsigned NOT NULL default '0',
  PRIMARY KEY  (`did`)
) TYPE=MyISAM;