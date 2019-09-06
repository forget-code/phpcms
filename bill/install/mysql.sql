INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('推广奖励', 'bill', 'bill', '', 0, 0, 0, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn/', 'phpcms@163.com', '推广奖励', '', '', 'a:3:{s:4:"type";s:6:"points";s:6:"number";s:2:"10";s:6:"domain";s:9:"localhost";}', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_bill`;
CREATE TABLE IF NOT EXISTS `phpcms_bill` (
  `billid` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `refurl` varchar(255) NOT NULL default '',
  `type` enum('points','days','money') NOT NULL default 'points',
  `number` int(11) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  `adddate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`billid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '推广奖励', '', 'bill/reflink.php', '_self', '', 16, '', '', '');