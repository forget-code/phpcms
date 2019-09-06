DROP TABLE IF EXISTS `phpcms_article_data`;
CREATE TABLE `phpcms_article_data` (
  `articleid` int(10) unsigned NOT NULL default '0',
  `content` mediumtext NOT NULL,
  PRIMARY KEY  (`articleid`)
) TYPE=MyISAM;