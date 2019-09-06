INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('留言本', 'guestbook', 'guestbook', '', 0, 0, 1, '1.0.0', 'phpcms', 'http://www.phpcms.cn', 'phpcms@163.com', '留言本', '', '', 'a:9:{s:12:"seo_keywords";s:9:"留言本";s:15:"seo_description";s:9:"留言本";s:8:"pagesize";s:2:"10";s:10:"maxcontent";s:4:"1000";s:15:"enablecheckcode";s:1:"1";s:4:"show";s:1:"1";s:13:"enableTourist";s:0:"";s:9:"checkpass";s:0:"";s:7:"usehtml";s:1:"1";}', 0, '0000-00-00', '0000-00-00', '0000-00-00');
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

INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_mymenu', '留言管理', '', '?mod=guestbook&file=guestbook&action=manage&keyid=0', 'right', '', 2, '', '', 'phpcms');

