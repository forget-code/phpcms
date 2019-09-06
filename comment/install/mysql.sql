INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('评论', 'comment', 'comment', '', 0, 0, 1, '1.0.0', 'phpcms', 'www.phpcms.cn', 'phpcms@163.com', 'comment', '', '', 'a:12:{s:12:"ischecklogin";s:1:"1";s:12:"ischeckreply";s:1:"1";s:16:"issupportagainst";s:1:"1";s:14:"ischeckcomment";s:1:"0";s:15:"enablecheckcode";s:1:"1";s:11:"maxsmilenum";s:2:"20";s:14:"enableparseurl";s:1:"1";s:13:"enablekillurl";s:1:"0";s:10:"mincontent";s:1:"3";s:10:"maxcontent";s:5:"10000";s:9:"uploaddir";s:7:"smilies";s:10:"enabledkey";s:112:",1,3,2,4,5,ads,product,vote,link,stat,spider,message,pay,ask,mail,bill,formguide,page,guestbook,mypage,announce,";}', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_comment`;
CREATE TABLE `phpcms_comment` (
  `cid` int(10) unsigned NOT NULL auto_increment,
  `keyid` varchar(20) NOT NULL default '0',
  `itemid` int(10) unsigned NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `score` tinyint(1) unsigned NOT NULL default '0',
  `support` int(8) NOT NULL default '0',
  `against` int(8) NOT NULL default '0',
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL default '',
  `addtime` int(10) unsigned NOT NULL default '0',
  `passed` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `comment` (`keyid`,`itemid`,`passed`,`cid`)
) TYPE=MyISAM ;

INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_mymenu', '评论管理', '', '?mod=comment&file=comment&action=manage', 'right', '', 1, '', '', 'phpcms');