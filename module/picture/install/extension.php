<?php
defined('IN_PHPCMS') or exit('Access Denied');

$module = 'picture';
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

$db->query("INSERT INTO `".$CONFIG['tablepre']."module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('图片', 'picture', 'picture', '', 0, 1, 0, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn/', 'phpcms@163.com', '图片管理', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00')");

$db->query("INSERT INTO `".$CONFIG['tablepre']."channel` (`module`, `channelname`, `style`, `channelpic`, `introduce`, `seo_title`, `seo_keywords`, `seo_description`, `listorder`, `islink`, `channeldir`, `channeldomain`, `disabled`, `templateid`, `skinid`, `items`, `comments`, `categorys`, `specials`, `hits`, `enablepurview`, `arrgroupid_browse`, `purview_message`, `point_message`, `enablecontribute`, `enablecheck`, `emailofreject`, `emailofpassed`, `enableupload`, `uploaddir`, `maxfilesize`, `uploadfiletype`, `linkurl`, `setting`, `ishtml`, `cat_html_urlruleid`, `item_html_urlruleid`, `special_html_urlruleid`, `cat_php_urlruleid`, `item_php_urlruleid`, `special_php_urlruleid`) VALUES ('picture', '图片', '', '', '', '', '', '', 3, 0, 'picture', '', 0, 'index', '0', 0, 0, 0, 0, 0, 0, '', '<div align=''center'' style=''color:red''>对不起，您没有阅读权限！</div>', '<p align=''center''><span style=''background:#E3E3E3''><a href=''\{\$readurl\}'' class=''read''>查看本图片需要消耗<font color=''red''>\{\$readpoint\}</font>点，您确认查看吗？</a></span></p><br/>', 1, 1, '', '', 1, 'uploadfile', 2048000, 'jpg|jpeg|gif|png|bmp', 'picture/', '', 1, 0, 0, 0, 0, 0, 0)");
$channelid = $db->insert_id();

$db->query("DROP TABLE IF EXISTS `".$CONFIG['tablepre']."picture_".$channelid."`");
$db->query("CREATE TABLE `".$CONFIG['tablepre']."picture_".$channelid."` (  `pictureid` int(10) unsigned NOT NULL auto_increment,  `catid` smallint(5) unsigned NOT NULL default '0',  `specialid` smallint(5) unsigned NOT NULL default '0',  `typeid` smallint(5) unsigned NOT NULL default '0',  `title` varchar(100) NOT NULL default '',  `style` varchar(50) NOT NULL default '',  `introduce` text NOT NULL,  `keywords` varchar(100) NOT NULL default '',  `author` varchar(50) NOT NULL default '',  `copyfrom` varchar(255) NOT NULL default '',  `pictureurls` text NOT NULL,  `hits` int(10) unsigned NOT NULL default '0',  `comments` int(10) unsigned NOT NULL default '0',  `thumb` varchar(255) NOT NULL default '',  `username` varchar(20) NOT NULL default '',  `addtime` int(10) unsigned NOT NULL default '0',  `editor` varchar(25) NOT NULL default '',  `edittime` int(10) unsigned NOT NULL default '0',  `checker` varchar(25) NOT NULL default '',  `checktime` int(10) unsigned NOT NULL default '0',  `templateid` varchar(20) NOT NULL default '0',  `skinid` varchar(20) NOT NULL default '0',  `arrposid` varchar(50) NOT NULL default '',  `status` tinyint(1) NOT NULL default '0',  `listorder` smallint(4) unsigned NOT NULL default '0',  `arrgroupidview` varchar(255) NOT NULL default '',  `readpoint` smallint(5) unsigned NOT NULL default '0',  `ishtml` tinyint(1) unsigned NOT NULL default '1',  `htmldir` varchar(20) NOT NULL default '',  `prefix` varchar(50) NOT NULL default '',  `urlruleid` tinyint(3) unsigned NOT NULL default '0',  `islink` tinyint(1) unsigned NOT NULL default '0',  `linkurl` varchar(255) NOT NULL default '',  PRIMARY KEY  (`pictureid`),  KEY `catid` (`catid`,`status`,`listorder`,`pictureid`),  KEY `typeid` (`typeid`,`catid`,`status`,`listorder`,`pictureid`),  KEY `endtime` (`status`,`arrposid`),  KEY `username` (`username`(10)),  KEY `hits` (`status`,`hits`,`pictureid`), FULLTEXT KEY `keywords` (`keywords`)) TYPE=MyISAM".$sql);

$db->query("INSERT INTO `".$CONFIG['tablepre']."menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_make', '图片首页', '生成图片首页', '?mod=".$current."&file=createhtml&action=index&channelid=".$channelid."', '_self', '', 1, '1', '', '')");
$db->query("INSERT INTO `".$CONFIG['tablepre']."menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_make', '图片html', '生成图片栏目，内容html页面', '?mod=".$current."&file=createhtml&channelid=".$channelid."', '_self', '', 5, '1', '', '')");
$db->query("INSERT INTO `".$CONFIG['tablepre']."menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_add', '添加图片', '图片管理首页', '?mod=".$current."&file=".$current."&action=main&channelid=".$channelid."', '_self', '', 0, '1', '', '')");

$config = "<?php\n\$mod = '$module';\n\$channelid = ".$channelid.";\n?>";
file_put_contents(PHPCMS_ROOT.'/'.$module.'/config.inc.php', $config);
@chmod(PHPCMS_ROOT.'/'.$module.'/config.inc.php', 0777);
?>