DROP TABLE IF EXISTS `phpcms_special_c_data`;
CREATE TABLE IF NOT EXISTS `phpcms_special_c_data` (
  `id` mediumint(8) unsigned NOT NULL default '0',
  `author` varchar(40) NOT NULL,
  `content` text NOT NULL,
  `paginationtype` tinyint(1) unsigned NOT NULL default '0',
  `maxcharperpage` mediumint(6) unsigned NOT NULL default '0',
  `style` char(20) NOT NULL,
  `show_template` varchar(30) NOT NULL,
  UNIQUE KEY `id` (`id`)
) TYPE=MyISAM;