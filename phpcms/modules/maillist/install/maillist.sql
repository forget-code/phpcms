DROP TABLE IF EXISTS `phpcms_maillist`;
CREATE TABLE `phpcms_maillist` (
  `sdid` varchar(32) DEFAULT NULL,
  `code` varchar(64) DEFAULT NULL,
  `domain` varchar(64) DEFAULT NULL,
  `group_name` varchar(64) DEFAULT NULL,
  `group_addr` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `descs` varchar(512) DEFAULT NULL,
  `rss_enabled` tinyint(1) DEFAULT '0',
  `rss_sys_source` MEDIUMINT(9) DEFAULT NULL,
  `rss_sys_item` varchar(128) DEFAULT NULL, 
  `rss_url` text,  
  `rss_rate` smallint(5) DEFAULT NULL,
  `rss_number` smallint(5) DEFAULT NULL,
  `is_activate` tinyint(1) DEFAULT '0',
  `wzz` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`sdid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8

