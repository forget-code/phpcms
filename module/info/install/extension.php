<?php
defined('IN_PHPCMS') or exit('Access Denied');

$module = 'info';
if(!is_dir(PHPCMS_ROOT.'/'.$module.'/'))
{
	dir_copy(PHPCMS_ROOT.'/module/'.$module.'/copy/', PHPCMS_ROOT.'/'.$module.'/');
}
elseif(!is_writable(PHPCMS_ROOT.'/'.$module.'/config.inc.php'))
{
	showmessage('Please chmod 0777 ./'.$module.'/config.inc.php !');
}

$sql = '';
if($db->version() > '4.1' && $CONFIG['dbcharset'])
{
	$sql = " DEFAULT CHARSET=".$CONFIG['dbcharset'];
}

$db->query("INSERT INTO `".$CONFIG['tablepre']."module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('信息', 'info', 'info', '', 0, 1, 0, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn/', 'phpcms@163.com', '分类信息发布与管理', '', '', 'a:16:{s:11:\"thumb_width\";s:3:\"150\";s:12:\"thumb_height\";s:3:\"150\";s:12:\"img_maxwidth\";s:3:\"550\";s:16:\"enable_guest_add\";s:1:\"1\";s:10:\"check_code\";s:1:\"1\";s:9:\"add_point\";s:1:\"0\";s:13:\"enable_reword\";s:1:\"0\";s:14:\"enable_keylink\";s:1:\"0\";s:13:\"keywords_show\";s:1:\"1\";s:12:\"keywords_add\";s:1:\"1\";s:12:\"editor_width\";s:3:\"90%\";s:13:\"editor_height\";s:3:\"300\";s:11:\"editor_mode\";s:9:\"introduce\";s:10:\"enable_rss\";s:1:\"1\";s:7:\"rss_num\";s:2:\"50\";s:10:\"rss_length\";s:3:\"200\";}', 0, '0000-00-00', '0000-00-00', '0000-00-00')");

$db->query("INSERT INTO `".$CONFIG['tablepre']."channel` (`module`, `channelname`, `style`, `channelpic`, `introduce`, `seo_title`, `seo_keywords`, `seo_description`, `listorder`, `islink`, `channeldir`, `channeldomain`, `disabled`, `templateid`, `skinid`, `items`, `comments`, `categorys`, `specials`, `hits`, `enablepurview`, `arrgroupid_browse`, `purview_message`, `point_message`, `enablecontribute`, `enablecheck`, `emailofreject`, `emailofpassed`, `enableupload`, `uploaddir`, `maxfilesize`, `uploadfiletype`, `linkurl`, `setting`, `ishtml`, `cat_html_urlruleid`, `item_html_urlruleid`, `special_html_urlruleid`, `cat_php_urlruleid`, `item_php_urlruleid`, `special_php_urlruleid`) VALUES ('info', '信息', '', '', '', '', '', '', 4, 0, 'info', '', 0, '0', '0', 0, 0, 0, 0, 0, 0, '', '<div align=''center'' style=''color:red''>对不起，您没有阅读权限！</div>', '<p align=''center''><span style=''background:#E3E3E3''><a href=''\{\$readurl\}'' class=''read''>查看本信息需要消耗<font color=''red''>\{\$readpoint\}</font>点，您确认查看吗？</a></span></p><br/>', 1, 1, '退稿时站内短信/Email通知内容：\r\n', '稿件被采用时站内短信/Email通知内容：\r\n', 1, 'uploadfile', 1024000, 'gif|jpg|jpeg|bmp|doc', 'info/', '', 1, 0, 0, 0, 0, 0, 0)");
$channelid = $db->insert_id();

$db->query("DROP TABLE IF EXISTS `".$CONFIG['tablepre']."info_".$channelid."`");
$db->query("CREATE TABLE `".$CONFIG['tablepre']."info_".$channelid."` (`infoid` int(10) unsigned NOT NULL auto_increment,  `catid` smallint(5) unsigned NOT NULL default '0',  `areaid` smallint(5) unsigned NOT NULL default '0',  `specialid` smallint(5) unsigned NOT NULL default '0',  `typeid` smallint(5) unsigned NOT NULL default '0',  `title` varchar(100) NOT NULL default '',  `style` varchar(50) NOT NULL default '',  `keywords` varchar(100) NOT NULL default '',  `author` varchar(50) NOT NULL default '',  `telephone` varchar(20) NOT NULL default '',  `email` varchar(50) NOT NULL default '',  `msn` varchar(50) NOT NULL default '',  `qq` varchar(20) NOT NULL default '',  `address` varchar(100) NOT NULL default '',  `content` mediumtext NOT NULL,  `hits` int(10) unsigned NOT NULL default '0',  `comments` int(10) unsigned NOT NULL default '0',  `thumb` varchar(255) NOT NULL default '',  `username` varchar(20) NOT NULL default '',  `ip` varchar(15) NOT NULL default '',  `addtime` int(10) unsigned NOT NULL default '0',  `endtime` int(10) unsigned NOT NULL default '0',  `editor` varchar(25) NOT NULL default '',  `edittime` int(10) unsigned NOT NULL default '0',  `checker` varchar(25) NOT NULL default '',  `checktime` int(10) unsigned NOT NULL default '0',  `templateid` varchar(20) NOT NULL default '0',  `skinid` varchar(20) NOT NULL default '0',  `arrposid` varchar(50) NOT NULL default '',  `status` tinyint(1) NOT NULL default '0',  `listorder` smallint(4) unsigned NOT NULL default '0',  `arrgroupidview` varchar(255) NOT NULL default '',  `readpoint` smallint(5) unsigned NOT NULL default '0',  `ishtml` tinyint(1) unsigned NOT NULL default '1',  `htmldir` varchar(20) NOT NULL default '',  `prefix` varchar(50) NOT NULL default '',  `urlruleid` tinyint(3) unsigned NOT NULL default '0',  `islink` tinyint(1) unsigned NOT NULL default '0',  `linkurl` varchar(255) NOT NULL default '',  `my_test` varchar(255) NOT NULL default '',  PRIMARY KEY  (`infoid`),  KEY `catid` (`catid`,`status`,`listorder`,`infoid`),  KEY `typeid` (`typeid`,`catid`,`status`,`listorder`,`infoid`),  KEY `endtime` (`status`,`arrposid`),  KEY `username` (`username`(10)),  KEY `hits` (`status`,`hits`,`infoid`), FULLTEXT KEY `keywords` (`keywords`)) TYPE=MyISAM".$sql);

$db->query("DROP TABLE IF EXISTS `".$CONFIG['tablepre']."info_area`");
$db->query("CREATE TABLE `".$CONFIG['tablepre']."info_area` (`areaid` smallint(6) unsigned NOT NULL auto_increment,  `channelid` tinyint(3) unsigned NOT NULL default '0',  `areaname` varchar(50) NOT NULL default '',  `domain` varchar(50) NOT NULL default '',  `style` varchar(50) NOT NULL default '',  `parentid` smallint(6) unsigned NOT NULL default '0',  `arrparentid` varchar(255) NOT NULL default '',  `child` tinyint(1) NOT NULL default '0',  `arrchildid` text NOT NULL,  `listorder` smallint(6) unsigned NOT NULL default '0',  `urlruleid` tinyint(1) unsigned NOT NULL default '0',  `linkurl` varchar(255) NOT NULL default '' , `setting` text NOT NULL,  `hits` int(11) unsigned NOT NULL default '0',  `disabled` tinyint(1) NOT NULL default '0',  PRIMARY KEY  (`areaid`),  KEY `channelid` (`channelid`,`disabled`),  KEY `listorder` (`listorder`)) TYPE=MyISAM".$sql);

$db->query("INSERT INTO `".$CONFIG['tablepre']."info_area` (`channelid`, `areaname`, `domain`, `style`, `parentid`, `arrparentid`, `child`, `arrchildid`, `listorder`, `urlruleid`, `linkurl`, `setting`, `hits`, `disabled`) VALUES (".$channelid.", '全国', '', '', 0, '0', 1, '1', 1, 0, 'area.php?areaid=1', 'a:6:{s:9:\"seo_title\";s:0:\"\";s:12:\"seo_keywords\";s:0:\"\";s:15:\"seo_description\";s:0:\"\";s:6:\"skinid\";s:1:\"0\";s:10:\"templateid\";s:1:\"0\";s:14:\"listtemplateid\";s:1:\"0\";}', 0, 0)");

$db->query("INSERT INTO `".$CONFIG['tablepre']."menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_make', '信息首页', '生成信息首页', '?mod=".$current."&file=createhtml&action=index&channelid=".$channelid."', '_self', '', 1, '1', '', '')");
$db->query("INSERT INTO `".$CONFIG['tablepre']."menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_make', '信息html', '生成信息栏目，内容html页面', '?mod=".$current."&file=createhtml&channelid=".$channelid."', '_self', '', 5, '1', '', '')");
$db->query("INSERT INTO `".$CONFIG['tablepre']."menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_add', '添加信息', '信息管理首页', '?mod=".$current."&file=".$current."&action=main&channelid=".$channelid."', '_self', '', 0, '1', '', '')");

$config = "<?php\n\$mod = '$module';\n\$channelid = ".$channelid.";\n?>";
file_put_contents(PHPCMS_ROOT.'/'.$module.'/config.inc.php', $config);
@chmod(PHPCMS_ROOT.'/'.$module.'/config.inc.php', 0777);
?>