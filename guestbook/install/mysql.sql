INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('留言本', 'guestbook', 'guestbook', '', 0, 0, 1, '1.0.0', 'phpcms', 'http://www.phpcms.cn', 'phpcms@163.com', '留言本', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');
DROP TABLE IF EXISTS `phpcms_guestbook`;
CREATE TABLE `phpcms_guestbook` (
  `gid` int(11) NOT NULL auto_increment,
  `keyid` varchar(20) NOT NULL default '0',
  `title` varchar(200) NOT NULL default '',
  `content` text NOT NULL,
  `reply` text NOT NULL,
  `username` varchar(50) NOT NULL default '',
  `gender` tinyint(1) NOT NULL default '0',
  `head` tinyint(4) NOT NULL default '0',
  `email` varchar(100) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `homepage` varchar(100) NOT NULL default '',
  `hidden` tinyint(1) NOT NULL default '0',
  `passed` tinyint(1) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `addtime` int(11) NOT NULL default '0',
  `replyer` varchar(30) NOT NULL default '',
  `replytime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gid`),
  KEY `title` (`title`,`username`),
  FULLTEXT KEY `content` (`content`)
) TYPE=MyISAM;