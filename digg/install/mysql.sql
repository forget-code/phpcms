INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES( '顶一下', 'digg', 'digg', '', 0, 0, 0, '1.0.0', 'phpcms', 'http://www.phpcms.cn', 'phpcms@163.com', '顶一下', '', '', 'a:4:{s:9:"credit_on";s:1:"0";s:10:"credit_num";s:2:"10";s:11:"digg_cookie";s:1:"1";s:7:"hits_on";s:1:"1";}', 0, '0000-00-00', '0000-00-00', '0000-00-00');

--
-- 表的结构 `phpcms_digg`
--


DROP TABLE IF EXISTS `phpcms_digg`;
CREATE TABLE `phpcms_digg` (
  `digg_id_list` int(10) NOT NULL auto_increment,
  `digg_channel` int(10) NOT NULL,
  `digg_ip` varchar(20) NOT NULL,
  `mod` varchar(255) NOT NULL,
  `text_id` varchar(255) NOT NULL,
  `digg_catid` int(10) NOT NULL,
  `digg_hits` int(10) NOT NULL,
  `digg_date` varchar(255) NOT NULL,
  `digg_user` varchar(255) NOT NULL,
  `digg_con` varchar(10) NOT NULL,
  `digg_id` int(10) NOT NULL,
  PRIMARY KEY  (`digg_id_list`)
) TYPE=MyISAM ;

-- 表的结构 `phpcms_digg_data`
--

DROP TABLE IF EXISTS `phpcms_digg_data`;
CREATE TABLE `phpcms_digg_data` (
  `digg_id` int(10) NOT NULL auto_increment,
  `digg_channel` int(10) NOT NULL,
  `mod` varchar(255) NOT NULL,
  `text_id` int(10) NOT NULL,
  `digg_title` varchar(255) NOT NULL,
  `digg_text` varchar(255) NOT NULL,
  `digg_link` varchar(100) NOT NULL,
  `digg_catid` int(10) NOT NULL,
  `digg_date` varchar(20) NOT NULL,
  PRIMARY KEY  (`digg_id`)
) TYPE=MyISAM;

