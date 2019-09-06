CREATE TABLE `$tablename` (
  `dataid` mediumint(10) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL,
  `datetime` int(10) unsigned NOT NULL,
  `ip` char(15) NOT NULL,
  PRIMARY KEY ( `dataid` )
) TYPE=MyISAM;